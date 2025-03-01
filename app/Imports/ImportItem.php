<?php

namespace App\Imports;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Product_image;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use App\Services\ProductVariationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportItem implements ToModel, WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (isset($row['name'])){
            if (isset($row['id'])) {
                $product = Products::find($row['id']);
                if (isset($row['variation_id']) && $row['variation_id']) {
                    $product_variation = ProductVariation::find($row['variation_id']);
                    if (!$row['buying_price']) $row['buying_price'] = 0;
                    $product_variation->update([
                        'price' => (float)trim($row['selling_price']),
                        'price_buying' => (float)trim($row['buying_price'])
                    ]);

                    $store = 1;
                    if (isset($row['store']) && $row['store']) {
                        $stores = Store::where('name', '=', trim($row['store']))->orderBy('id', 'DESC')->first();
                        if (!$stores) {
                            $stores = Store::create([
                                'name' => trim($row['store'])
                            ]);
                        }
                        $store = $stores->id;
                    }
                    $sku = "";
                    if (isset($row['sku']) && !empty(trim($row['sku']))) $sku = trim($row['sku']);
                    $barcode = $product->id . $row['variation_id'];
                    $stock = 0;
                    if (!empty($row['stock'])) $stock = $row['stock'];
                    if (!empty($row['barcode'])) $barcode = trim($row['barcode']);
                    $stock_ = DB::table('stocks')
                        ->where('products_id', $product->id)
                        ->where('barcode_value', trim($barcode))
                        ->where('store_id', '=', $store)
                        ->where('product_variation_id', $row['variation_id'])->orderBy('id', 'desc')->first();

                    $stock_->update([
                        'products_id' => $product->id,
                        'store_id' => $store,
                        'product_variation_id' => $row['variation_id'],
                        'quantity_stock' => $stock,
                        'sku' => $sku,
                        'barcode_value' => $barcode
                    ]);


                } else {
                    $vat = self::vatTransform($row['vat']);
                    if (!$row['buying_price']) $row['buying_price'] = 0;

                    $supplier = NULL;
                    if (isset($row['supplier']) && $row['supplier']) {
                        $suppliers = Supplier::where('name', '=', trim($row['supplier']))->orderBy('id', 'DESC')->first();
                        if (!$suppliers) {
                            $suppliers = Supplier::create([
                                'name' => trim($row['supplier'])
                            ]);
                        }
                        $supplier = $suppliers->id;
                    }
                    $slug = self::transform_slug(trim($row['name']));
                    $product->update([
                        'name' => trim($row['name']),
                        'price' => $row['selling_price'],
                        'price_buying' => $row['buying_price'],
                        'unit' => $row['unit'],
                        'vat' => $vat,
                        'description' => $row['description'],
                        'slug' => $slug,
                        'id_supplier' => $supplier,
                    ]);

                    $store = 1;
                    if (isset($row['store']) && $row['store']) {
                        $stores = Store::where('name', '=', trim($row['store']))->orderBy('id', 'DESC')->first();
                        if (!$stores) {
                            $stores = Store::create([
                                'name' => trim($row['store'])
                            ]);
                        }
                        $store = $stores->id;
                    }
                    $sku = "";
                    if (isset($row['sku']) && !empty(trim($row['sku']))) $sku = trim($row['sku']);

                    $barcode = $product->id . $row['variation_id'];
                    if (!empty($row['barcode']))  $barcode = trim($row['barcode']);
                    $stock = 0;
                    if (!empty($row['stock'])) $stock = $row['stock'];
                    $stock_ = DB::table('stocks')
                        ->where('products_id', $product->id)
                        ->where('barcode_value', trim($barcode))
                        ->where('store_id', '=', $store)
                        ->where('product_variation_id', null)->orderBy('id', 'desc')->first();

                    $stock_->update([
                        'products_id' => $product->id,
                        'store_id' => $store->id,
                        'product_variation_id' => null,
                        'quantity_stock' => $stock,
                        'sku' => $sku,
                        'barcode_value' => $barcode
                    ]);

                    if (!empty($row['category'])) {
                        if ($row['category'] == '' || $row['category'] == 'Uncategorized') {
                            Category_product::where('id_product', $product->id)->delete();
                        } else {
                            $category_ = explode(';', $row['category']);
                            Category_product::where('id_product', $product->id)->delete();
                            foreach ($category_ as $cat) {
                                $category_ = Category::where('category', $cat)->orderBy('id', 'desc')->first();
                                Category_product::updateOrCreate([
                                    'id_product' => $product->id,
                                    'id_category' => $category_->id,
                                ]);
                            }
                        }
                    }
                }
                return $product;
            } else {
                $deep = count($row) - 12;
                $is_product_exist = Products::where('name', trim($row['name']))->get()->last();
                $slug = self::transform_slug(trim($row['name']));
                if (!empty($row['selling_price']) && $row['selling_price'] != '' && $row['selling_price'] != null) {
                    $row['selling_price'] = $row['selling_price'];
                } else $row['selling_price'] = 0;

                if (!$row['buying_price']) $row['buying_price'] = 0;

                if (empty($is_product_exist)) {
                    $vat = self::vatTransform($row['vat']);
                    if (!trim($row['buying_price'])) $row['buying_price'] = 0;

                    $supplier = NULL;
                    if (isset($row['supplier']) && $row['supplier']) {
                        $suppliers = Supplier::where('name', '=', trim($row['supplier']))->orderBy('id', 'DESC')->first();
                        if (!$suppliers) {
                            $suppliers = Supplier::create([
                                'name' => trim($row['supplier'])
                            ]);
                        }
                        $supplier = $suppliers->id;
                    }
                    $is_slug_exist = Products::where('slug', '=', $slug)->orderBy('id', 'desc')->first();
                    if ($is_slug_exist) {
                        $i = 0;
                        $j = 1;
                        $slug .= '-' . $j;
                        while ($i < $j) {
                            $is_slug_exist_ = Products::where('slug', '=', $slug)->orderBy('id', 'desc')->first();
                            if ($is_slug_exist_) {
                                $i++;
                                $j++;
                                $slug .= '-' . $j;
                            } else {
                                $i++;
                            }

                        }
                    }

                    $product_creation = Products::updateOrCreate([
                        'name' => trim($row['name']),
                        'price' => $row['selling_price'],
                        'price_buying' => $row['buying_price'],
                        'unit' => $row['unit'],
                        'vat' => $vat,
                        'description' => $row['description'],
                        'slug' => $slug,
                        'id_supplier' => $supplier,
                    ]);
                    $is_product_exist = $product_creation;
                }

                if (isset($row['name']) && !empty(trim($row['name']))){
                    $products_images = Product_image::where('name_product', '=',trim($row['name']))->orderBy('id','ASC')->get();
                    foreach ($products_images as $pi){
                        $products_image = Product_image::find($pi->id);
                        $products_image->update([
                            'products_id' => $is_product_exist->id
                        ]);
                    }
                }

                $variation_value = [];
                $attributes = [];
                for ($i = 1; $i <= ceil($deep / 2); $i++) {
                    if (isset($row['attribute_name_' . $i]) && isset($row['attribute_value_' . $i])) {
                        $slug = self::transform_slug(trim($row['attribute_name_' . $i]));
                        $attribute = Attribute::updateOrCreate([
                            'attribute_name' => trim($row['attribute_name_' . $i]),
                            'attribute_slug' => $slug,
                            'attribute_type' => 'Variation',
                        ]);
                        $attribute_value = trim($row['attribute_value_' . $i]);
                        if (self::validateDate($attribute_value,'Y')) {
                            $attribute_value = $this->transformDate($attribute_value, 'd/m/Y')->format('d/m/Y');
                        }

                        $attribute_val_exist = AttributeValue::where('attribute_values', '=', $attribute_value)->orderBy('id', 'DESC')->first();
                        if (!$attribute_val_exist) {
                            $attribute_value_c = AttributeValue::create([
                                'attribute_values' => $attribute_value,
                                'attribute_id' => $attribute->id,
                            ]);
                            $attribute_val_exist = $attribute_value_c;
                        }

                        $attributes[$attribute->id] = $attribute_val_exist->id;
                        $variation_value = array_merge($variation_value, [[$attribute->id => $attribute_val_exist->id]]);
                    }
                }

                if(!empty($attributes)){
                    ProductVariationService::validateExistingVariationsByProductId($is_product_exist->id, $attributes, false);

//                    // Update the product variation attributes
//                    DB::table('product_variation_attributes')->where('products_id', $is_product_exist->id)->delete();

                    // Save the new variation if it doesn't exist
                    $variation = ProductVariation::create([
                        'products_id' => $is_product_exist->id,
                        'price' =>  $is_product_exist->price,
                        'price_buying' => $is_product_exist->price_buying,
                        'position' => NULL,
                    ]);

                    foreach ($attributes as $attributeId => $attributeValueId) {
                        DB::table('product_variation_attributes')->insert([
                            'product_variation_id' => $variation->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $attributeValueId
                        ]);
                    }

                    if (!$variation && !empty($attributes)) {
                        $variation_s = ProductVariation::create([
                            'products_id' => $is_product_exist->id,
                            'price' =>  $is_product_exist->price,
                            'price_buying' => $is_product_exist->price_buying,
                            'position' => NULL,
                        ]);
                        $variation = $variation_s;
                    } elseif($variation && !empty($attributes)) {
                        $variation->update([
                            'price' => trim($row['selling_price']),
                            'price_buying' => trim($row['buying_price']),
                        ]);
                    }
                }

                if (!empty($attributes)) {
                    $store = 1;
                    if (isset($row['store']) && $row['store']) {
                        if (trim($row['store']) == "Default") {
                            // $stores = Store::where('name', '=', "Default Store")->orderBy('id', 'DESC')->first();
                            // if (!$stores) {
                            //     $stores_c = Store::create([
                            //         'name' => "Default Store"
                            //     ]);
                            //     $stores = $stores_c;
                            // }
                            $store = 1;
                        } else {
                            $stores = Store::where('name', '=', trim($row['store']))->orderBy('id', 'DESC')->first();
                            if (!$stores) {
                                $stores_c = Store::create([
                                    'name' => trim($row['store'])
                                ]);
                                $stores = $stores_c;
                            }
                            $store = $stores->id;
                        }

                    } else {

                        $store = 1;
                    }

                    $sku = "";
                    if (isset($row['sku']) && !empty(trim($row['sku']))) $sku = trim($row['sku']);
                    $barcode = $is_product_exist->id . $variation->id;
                    if (!empty($row['barcode'])) $barcode = trim($row['barcode']);
                    $stock = 0;
                    if (!empty($row['stock'])) $stock = $row['stock'];
                    $existing_stock = DB::table('stocks')->select('*')
                        ->where('products_id', '=', $is_product_exist->id)
                        ->where('store_id', '=', $store)
                        ->where('barcode_value', '=', $barcode)
                        ->where('product_variation_id', '=', $variation->id)->orderBy('id', 'DESC')
                        ->first();

                    if (!$existing_stock) {

                        $stocks_sheet = Stock::create([
                            'products_id' => $is_product_exist->id,
                            'store_id' => $store,
                            'product_variation_id' => $variation->id,
                            'quantity_stock' => $stock,
                            'date_received' => date('Y-m-d'),
                            'sku' => $sku,
                            'barcode_value' => $barcode
                        ]);

                    }
                } else {
                    $store = 1;
                    if (isset($row['store']) && $row['store']) {
                        if (trim($row['store']) == "Default") {

                            $store = 1;
                        } else {
                            $stores = Store::where('name', '=', trim($row['store']))->orderBy('id', 'DESC')->first();
                            if (!$stores) {
                                $stores_c = Store::create([
                                    'name' => trim($row['store'])
                                ]);
                                $stores = $stores_c;
                            }
                            $store = $stores->id;
                        }

                    } else {
                        $store = 1;
                    }

                    $sku = "";
                    if (isset($row['sku']) && !empty(trim($row['sku']))) $sku = trim($row['sku']);
                    $barcode = $is_product_exist->id;
                    if (!empty($row['barcode'])) $barcode = trim($row['barcode']);
                    $stock = 0;
                    if (!empty($row['stock'])) $stock = $row['stock'];

                    $existing_stock = DB::table('stocks')->select('*')
                        ->where('products_id', '=', $is_product_exist->id)
                        ->where('store_id', '=', $store)
                        ->whereNull('product_variation_id')
                        ->where('barcode_value', '=', $barcode)
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (!$existing_stock) {

                        Stock::create([
                            'products_id' => $is_product_exist->id,
                            'store_id' => $store,
                            'product_variation_id' => null,
                            'quantity_stock' => $stock,
                            'date_received' => date('Y-m-d'),
                            'sku' => $sku,
                            'barcode_value' => $barcode
                        ]);
                    }
                }
                if (!empty($row['category'])) {
                    if ($row['category'] != '' && $row['category'] != 'Uncategorized') {
                        $category_ = explode(';', $row['category']);
                        foreach ($category_ as $cat) {
                            $category_ = Category::where('category', $cat)->orderBy('id', 'desc')->first();
                            if (!$category_) {
                                $category__ = Category::updateOrCreate([
                                    'category' => $cat
                                ]);
                                $category_ = $category__;
                            }
                            Category_product::updateOrCreate([
                                'id_product' => $is_product_exist->id,
                                'id_category' => $category_->id,
                            ]);
                        }
                    }
                }
                if (!empty($attributes)) {
                    $is_product_exist->update([
                        'is_variable_product' => 'yes'
                    ]);
                }
                return $is_product_exist;
            }
        }

    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(Date::excelToDateTimeObject($value));
        } catch (ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        return $str;
    }

    protected function vatTransform($vat)
    {
        if ($vat == '0') {
            $vat = 'Zero Rated';
        } elseif ($vat == 'Ex' || $vat == 'ex') {
            $vat = 'VAT Exempt';
        } elseif ($vat > 0 && is_numeric($vat)) {
            $vat = $vat . '% VAT';
        }
        return $vat;
    }


}
