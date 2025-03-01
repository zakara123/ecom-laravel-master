<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Sales;
use App\Models\Store;

class SalesService {

    public static function createSales($data, $customer)
    {
        $pickup_details = self::getPickupOrDeliveryDetails($data);
        $address2 = isset($data['address2']) ? $data['address2'] : '';
        $pickup_or_delivery = isset($data['pickup_or_delivery']) ? $data['pickup_or_delivery'] : null;

        $sales = Sales::create([
            'amount' => $data['amount'],
            'subtotal' => $data['subtotal'],
            'tax_amount' => $data['vat_amount'],
            'currency' => "MUR",
            'status' => "Pending Payment",
            'order_reference' => "",
            'customer_id' => $customer->id,
            'customer_firstname' => $data['firstname'],
            'customer_lastname' => $data['lastname'],
            'customer_address' => $data['address1'] . ($address2 ? ", " . $address2 : ''),
            'customer_city' => $data['city'] . " " . $data['country'],
            'customer_email' => $data['email'],
            'customer_phone' => $data['phone'],
            'comment' => $data['comment'],
            'tax_items' => $data['tax_items'],
            'id_store' => $data['id_store'],
            'payment_methode' => $data['payment_methode'],
            'pickup_or_delivery' => $pickup_or_delivery,
            'id_store_pickup' => $pickup_details['id_store_pickup'],
            'store_pickup' => $pickup_details['store_pickup'],
            'date_pickup' => $pickup_details['date_pickup'],
            'id_delivery' => $pickup_details['id_delivery'],
            'delivery_name' => $pickup_details['delivery_name'],
            'delivery_fee' => $pickup_details['delivery_fee'],
            'delivery_fee_tax' => $pickup_details['delivery_vat'],
            'type_sale' => 'Online Sales'
        ]);

        return $sales;
    }

    private static function getPickupOrDeliveryDetails($data)
    {
        $details = [
            'id_store_pickup' => null,
            'store_pickup' => null,
            'date_pickup' => null,
            'id_delivery' => null,
            'delivery_name' => null,
            'delivery_fee' => 0,
            'delivery_vat' => 'VAT Exempt',
        ];

        if ($data['pickup_or_delivery'] === "Pickup") {
            $store = Store::find($data['store_pickup']);
            if ($store) {
                $details['id_store_pickup'] = $data['store_pickup'];
                $details['store_pickup'] = $store->name;
                $details['date_pickup'] = self::transform_date($data['pickup_date']);
            }
        } elseif ($data['pickup_or_delivery'] === "Delivery") {
            $delivery = Delivery::find($data['delivery_method']);
            if ($delivery) {
                $details['id_delivery'] = $data['delivery_method'];
                $details['delivery_name'] = $delivery->delivery_name;
                $details['delivery_fee'] = $delivery->delivery_fee;
                $details['delivery_vat'] = isset($delivery->vat) ? $delivery->vat : 'VAT Exempt';
            }
        }

        return $details;
    }
}


