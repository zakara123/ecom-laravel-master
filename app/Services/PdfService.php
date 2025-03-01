<?php

namespace App\Services;

use App\Models\Company;
use App\Models\PayementMethodSales;
use App\Models\ProductVariation;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesEBSResults;
use App\Models\SalesInvoiceCounter;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use PDF;

class PdfService {
    public static function pdf_sale($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach ($sales_products as &$item) {
            if (!empty($item->product_variations_id)) {
                $variation_value_final = [];
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);
        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        $pdf = PDF::loadView('pdf.sale_proforma', compact('ebs_typeOfPerson','company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/proforma-sales-' . $id_sale . '.pdf', $pdf->output());


        $pdf = PDF::loadView('pdf.sale', compact('ebs_typeOfPerson','company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/invoice-' . $id_sale . '.pdf', $pdf->output());
    }

    public static function pdf_invoice($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach ($sales_products as &$item) {
            if (!empty($item->product_variations_id)) {
                $variation_value_final = [];
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $salesEbs = SalesEBSResults::where("sale_id", $id_sale)->get();
        $has_typeInvoicSTD = $has_typeInvoicPRF = false;
        $label_typeInvoicSTD = '';
        $label_typeInvoicPRF = '';
        if($salesEbs){
            foreach ($salesEbs as $sebs){
                $jdecod= json_decode($sebs->jsonRequest);
                if (isset($jdecod[0]->invoiceTypeDesc)){
                    if ($jdecod[0]->invoiceTypeDesc == 'STD') {
                        $label_typeInvoicSTD = $sebs->qrCode;
                        $has_typeInvoicSTD = true;
                    }
                    if ($jdecod[0]->invoiceTypeDesc == 'PRF') {
                        $has_typeInvoicPRF = true;
                        $label_typeInvoicPRF = $sebs->qrCode;
                    }
                } else {
                    $sebs->labelModal = '';
                }
            }
        }


        $name_invoice = 'invoice-proforma-';

        $pdf = PDF::loadView('pdf.invoice_proforma', compact('salesEbs','has_typeInvoicPRF','label_typeInvoicPRF','company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/'. $name_invoice . $id_sale . '.pdf', $pdf->output());

        $name_invoice = 'invoice-';
        $ref_invoice = '';
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id',$id_sale)->where('is_sales','yes')->max('id');
        if ($ebs_invoiceCounter){
            if ($ebs_invoiceIdentifier) $ref_invoice = $ebs_invoiceIdentifier->value.$ebs_invoiceCounter;
            else $ref_invoice = $ebs_invoiceCounter;
        }



        $pdf = PDF::loadView('pdf.invoice', compact('salesEbs','label_typeInvoicSTD','has_typeInvoicSTD', 'company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type', 'ref_invoice'));
        $pdf_invoicess= Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/'. $name_invoice . $id_sale . '.pdf', $pdf->output());
        if ($ebs_invoiceCounter) $pdf_invoicess = Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/'. $name_invoice . $ebs_invoiceCounter . '.pdf', $pdf->output());

        return $pdf_invoicess;

    }

    public static function pdf_delivery_note($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $pdf = PDF::loadView('pdf.delivery_note', compact('company', 'sale', 'sales_products', 'display_logo'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/delivery-note-' . $id_sale . '.pdf', $pdf->output());

    }
}
