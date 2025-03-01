<?php

namespace App\Imports;

use App\Models\Bill_product;
use App\Models\LedgerOlderBills;
use App\Models\Products;
use App\Models\Store;
use App\Models\Supplier;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerBillsProducts implements ToModel, WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $purchase_id = trim($row['purchase_id']);
        $product_id = trim($row['product_id']);
        $quantity = trim($row['quantity']);
        $order_price = trim($row['order_price']);
        $bill_type_description= trim($row['bill_type_description']);
        $product_name_order = trim($row['product_name_order']);
        $product_unit = trim($row['product_unit']);
        $variation_value = trim($row['variation_value']);
        $product_attributs = trim($row['product_attributs']);
        $id_variation_price = trim($row['id_variation_price']);
        $id_store = trim($row['id_store']);
        $store = trim($row['store']);
        $vat_order = trim($row['vat_order']);
        $discount = trim($row['discount']);
        $bill_type = trim($row['bill_type']);
        $product_attributes_values = trim($row['product_attributes_values']);
        $product_attributes_values_price = trim($row['product_attributes_values_price']);
        $product_attributes_values_price_buying = trim($row['product_attributes_values_price_buying']);

        $id_store_sale = $name_store_sale = '';
        if ($id_store && $store){
            $check_store_pickup = Store::where('name','=',$store)->orderBy('id','DESC')->first();
            if (!$check_store_pickup){
                $store_pick_in = Store::updateOrCreate([
                    'name' => $store,
                ]);
                $id_store_sale = $store_pick_in->id;
                $name_store_sale = $store_pick_in->name;
            } else {
                $id_store_sale = $check_store_pickup->id;
                $name_store_sale = $check_store_pickup->name;
            }
        }

        $check_old_bill = LedgerOlderBills::where('id_bill_import','=',$purchase_id)->orderBy('id','DESC')->first();
        $id_sales = 0;
        if ($check_old_bill) {
            $id_sales = $check_old_bill->id_bill_new;
        }
        if (!$discount) $discount = 0;
        $product = self::productSave($row);
        $bill_product = Bill_product::updateOrCreate([
            'bill_id' =>$id_sales,
            'product_id' => $product->id,
            'product_variations_id' => null,
            'order_price' =>$order_price,
            'quantity' =>$quantity,
            'product_name' =>$product_name_order,
            'tax_sale' =>$vat_order,
            'discount' =>$discount,
            'product_unit' =>$product_unit,
            'bills_type' =>$bill_type
        ]);

        return $bill_product;

    }

    function productSave($row)
    {

        $name_product = trim($row['name_product']);
        $slug_product = trim($row['slug_product']);
        $description_product = trim($row['description_product']);
        $short_description_product = trim($row['short_description_product']);
        $price_product = trim($row['price_product']);
        $price_buying_product = trim($row['price_buying_product']);
        $unit_product = trim($row['unit_product']);
        $attributs_for_pricing_product = trim($row['attributs_for_pricing_product']);
        $allow_combined_value_only_product = trim($row['allow_combined_value_only_product']);
        $vat_product = trim($row['vat_product']);
        $qr_code_src_product = trim($row['qr_code_src_product']);
        $line_item_order_attributes_product = trim($row['line_item_order_attributes_product']);
        $is_maintenance_product = trim($row['is_maintenance_product']);
        $name_supplier_product = trim($row['name_supplier_product']);

        $check_product = Products::where('name','=',$name_product)->orderBy('id','DESC')->first();
        $check_supplier = Supplier::where('name','=',$name_supplier_product)->orderBy('id','DESC')->first();
        $id_supplier = 0;
        if (!$check_supplier) {
            $supplier_creation = Supplier::updateOrCreate([
                'name' => $name_supplier_product,
            ]);
            $id_supplier = $supplier_creation->id;
        } else $id_supplier = $check_supplier->id;

        if (!$check_product) {
            $product_creation = Products::updateOrCreate([
                'name' => $name_product,
                'price' => $price_product,
                'price_buying' => $price_buying_product,
                'unit' => $unit_product,
                'vat' => $vat_product,
                'description' => $description_product,
                'slug' => $slug_product,
                'id_supplier' => $id_supplier,
                'short_description' =>$short_description_product,
                'attributs_for_pricing' =>$attributs_for_pricing_product,
                'allow_combined_value_only' =>$allow_combined_value_only_product,
                'line_item_order_attributes' =>$line_item_order_attributes_product,
                'is_maintenance' =>$is_maintenance_product,
                'qr_code_src' =>$qr_code_src_product,
            ]);
            $check_product = $product_creation;
        }

        return $check_product;
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
