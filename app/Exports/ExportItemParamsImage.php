<?php

namespace App\Exports;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Product_image;
use App\Models\Products;
use App\Models\ProductVariation;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportItemParamsImage implements FromCollection, WithHeadings
{
    public $has_image;

    public function __construct(int $has_image)
    {
        $this->has_image = $has_image;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $export_item = array();
        $products = Products::select('id', 'name', 'price', 'price_buying', 'unit', 'vat', 'description', 'id_supplier')->orderBy('id', 'desc')->get();
        $id_arrays = array();
        if ($this->has_image == 1) {
            $productsimages = Product_image::latest()->get();
            foreach ($productsimages as $pi) {
                array_push($id_arrays, $pi->products_id);
            }
            $products = Products::whereIn('id', array_unique($id_arrays))
                ->orderBy('id', 'DESC')->get();

        }
        elseif($this->has_image == 2) {
            $productsimages = Product_image::latest()->get();
            foreach ($productsimages as $pi) {
                array_push($id_arrays, $pi->products_id);
            }
            $products = Products::whereNotIn('id', array_unique($id_arrays))->orderBy('id', 'DESC')->get();

        }
        foreach ($products as $product) {

            $stock_product = DB::table('stocks')
                ->where('products_id', $product->id)
                ->where('product_variation_id', NULL)->orderBy('id', 'desc')->first();
            $quantity_stock_product = '';
            $barcode_product = '';
            if (isset($stock_product->quantity_stock) && isset($stock_product->barcode_value)) {
                $quantity_stock_product = $stock_product->quantity_stock;
                $barcode_product = $stock_product->barcode_value;
            }

            $categoryproduct = Category_product::where('id_product', $product['id'])->get();
            foreach ($categoryproduct as &$cp) {
                $category = Category::find($cp->id_category);
                $cp['category_name'] = $category->category;
            }
            $product['categoryproduct'] = $categoryproduct;
            $category_ = '';
            $supplier = '';

            if (count($product->categoryproduct) > 0) {
                $loop = 0;
                foreach ($product->categoryproduct as $category) {
                    if ($loop < (count($product->categoryproduct) - 1))
                        $category_ .= $category->category_name . ';';
                    else
                        $category_ .= $category->category_name;

                    $loop++;
                }
            } else  $category_ = 'Uncategorized';

            if ($product->id_supplier) {
                $supplier_product = Supplier::find($product->id_supplier);
                $supplier = $supplier_product->name;
            }

            $store = '';
            $store_p = Stock::where('products_id', $product->id)
                ->orderBy('id', 'desc')->first();

            if ((bool)$store_p) {
                if (isset($store_p->store_id) && is_null($store_p->store_id)){
                    $store_product = Store::find($stock->store_id);
                    $store = $store_product->name;
                }
            }

            $export_item[] = array(
                $product->id, $product->name,
                $product->price,
                $product->price_buying,
                $product->unit_selling_label,
                $product->vat,
                $product->description,
                '',
                $quantity_stock_product,
                $barcode_product,
                $category_,
                $supplier,
                $store

            );

            $product_variation = ProductVariation::where('products_id', $product->id)->get();
            foreach ($product_variation as $key1 => $variation) {
                $variation = (array)$variation;
                $variation_value = json_decode($variation['variation_value']);
                $variation['variation_value'] = [];
                if ($variation_value != NULL) {
                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if (!empty($attr_val->attribute_values) && !empty($attr->attribute_name))
                                $variation['variation_value'] = array_merge($variation['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $variation = (object)$variation;
                $product_variation[$key1] = $variation;
            }


            foreach ($product_variation as $key1 => $variation) {
                $i = 1;
                $attribute = array();
                $stock = DB::table('stocks')
                    ->where('products_id', $product->id)
                    ->where('product_variation_id', $variation->id)->orderBy('id', 'desc')->first();
                $attribute[] = $product->id . $variation->id;
                $attribute[] = $product->name;
                $attribute[] = $variation->price;
                $attribute[] = $variation->price_buying;
                $attribute[] = $product->unit_selling_label;
                $attribute[] = $product->vat;
                $attribute[] = $product->description;
                $attribute[] = $variation->id;
                $quantity_stock = '';
                $barcode_value = '';

                if (isset($stock->quantity_stock) && isset($stock->barcode_value)) {
                    $quantity_stock = $stock->quantity_stock;
                    $barcode_value = $stock->barcode_value;
                }


                $attribute[] = $quantity_stock;
                $attribute[] = $barcode_value;
                $attribute[] = '';
                $attribute[] = $supplier;
                $attribute[] = $store;
                foreach ($variation->variation_value as $key => $var) {
                    $attribute[] = $var['attribute'];
                    $attribute[] = $var['attribute_value'];
                }
                $export_item[] = $attribute;
            }
        }
        return collect($export_item);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ["ID", "Name", "Selling price", "Buying price", "Unit", "VAT", "Description", "Variation ID", "Stock", "Barcode", "Category", "Supplier", "Store"];
        $deep = sizeof(Attribute::all());
        for ($i = 1; $i <= $deep; $i++) {
            array_push($heading, trim("Attribute name " . $i));
            array_push($heading, trim("Attribute value " . $i));
        }
        return $heading;
    }
}
