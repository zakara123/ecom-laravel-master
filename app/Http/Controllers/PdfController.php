<?php

namespace App\Http\Controllers;

use App\Models\AppointmentBillable;
use App\Models\AppointmentBillableProducts;
use App\Models\Appointments;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Bill;
use App\Models\Bill_product;
use App\Models\Company;
use App\Models\PayementMethodSales;
use App\Models\ProductVariation;
use App\Models\Quotes;
use App\Models\QuotesProducts;
use App\Models\Rentals;
use App\Models\Rentals_products;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesEBSResults;
use App\Models\SalesInvoiceCounter;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use PDF;

class PdfController extends Controller
{

    public function pdf_sale($id_sale){

        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        foreach($sales_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR'){
            if($sale->currency == "MUR"){
                $sale->amount = $sale->amount - $sale->tax_amount;
            }
            else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }

        }

        $pdf = PDF::loadView('pdf.sale', compact('ebs_typeOfPerson','company','sale', 'sales_products','display_logo', 'order_payment_method' , 'vat_type'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'proforma-sales-'.$id_sale.'.pdf', $pdf->output());
        return $pdf->download('sale-'.$id_sale.'.pdf');
    }

    public function pdf_invoice($id_sale){
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach($sales_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation_value_final = $variation_value_text = [];
                $variationRv = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variationRv)) {
                    foreach ($variationRv as $attribute => $value) {
                        $variation_value_final[] = ["attribute" => $attribute, "attribute_value" => $value];
                        $variation_value_text[] = $attribute . ": " . $value;
                    }
                }

                // Convert the $variation_value_text array to a string with | as separator
                $item->variation_value_text = implode(' | ', $variation_value_text);
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $ref_invoice = '';
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id',$id_sale)->where('is_sales','yes')->max('id');
        if ($ebs_invoiceCounter){
            if ($ebs_invoiceIdentifier) $ref_invoice = $ebs_invoiceIdentifier->value.$ebs_invoiceCounter;
            else $ref_invoice = $ebs_invoiceCounter;
        }
        $salesEbs = SalesEBSResults::where("sale_id", $id_sale)->get();
        $has_typeInvoicSTD = false;
        $label_typeInvoicSTD = '';
        if($salesEbs){
            foreach ($salesEbs as $sebs){
                $jdecod= json_decode($sebs->jsonRequest);
                if (isset($jdecod[0]->invoiceTypeDesc)){
                    if ($jdecod[0]->invoiceTypeDesc == 'STD') {
                        $label_typeInvoicSTD = $sebs->qrCode;
                        $has_typeInvoicSTD = true;
                    }
                } else {
                    $sebs->labelModal = '';
                }
            }
        }

        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR'){
            if($sale->currency == "MUR"){
                $sale->amount = $sale->amount - $sale->tax_amount;
            }
            else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }

        }

        $pdf = PDF::loadView('pdf.invoice', compact('ebs_typeOfPerson','salesEbs','label_typeInvoicSTD','has_typeInvoicSTD','company','sale', 'sales_products','display_logo', 'order_payment_method', 'vat_type', 'ref_invoice'));

        $name_invoice = 'invoice-';
//        if ($sale->status == "Draft") $name_invoice = 'proforma-invoice-';
        if ($sale->status == "Draft") self::pdf_invoice_proforma($id_sale);

        if($ebs_invoiceCounter) {
            Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).$name_invoice.$ebs_invoiceCounter.'.pdf', $pdf->output());
            return $pdf->download('invoice-'.$ebs_invoiceCounter.'.pdf');
        } else {
            Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).$name_invoice.$id_sale.'.pdf', $pdf->output());
            return $pdf->download('invoice-'.$id_sale.'.pdf');
        }

    }


    public function pdf_invoice_proforma($id_sale){
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach($sales_products as &$item) {
            if(!empty($item->product_variations_id)) {
                $variation_value_final = $variation_value_text = [];
                $variationRv = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variationRv)) {
                    foreach ($variationRv as $attribute => $value) {
                        $variation_value_final[] = ["attribute" => $attribute, "attribute_value" => $value];
                        $variation_value_text[] = $attribute . ": " . $value;
                    }
                }

                // Convert the $variation_value_text array to a string with | as separator
                $item->variation_value_text = implode(' | ', $variation_value_text);
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $name_invoice = 'proforma-sales-';

        $salesEbs = SalesEBSResults::where("sale_id", $id_sale)->get();
        $label_typeInvoicPRF = '';
        $has_typeInvoicPRF = false;
        if($salesEbs){
            foreach ($salesEbs as $sebs){
                $jdecod= json_decode($sebs->jsonRequest);
                if (isset($jdecod[0]->invoiceTypeDesc)){
                    if ($jdecod[0]->invoiceTypeDesc == 'PRF') {
                        $has_typeInvoicPRF = true;
                        $label_typeInvoicPRF = $sebs->qrCode;
                    }
                }
            }
        }

        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR'){
            if($sale->currency == "MUR"){
                $sale->amount = $sale->amount - $sale->tax_amount;
            }
            else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }

        }

        $pdf = PDF::loadView('pdf.invoice_proforma', compact('ebs_typeOfPerson','salesEbs','has_typeInvoicPRF','label_typeInvoicPRF','company','sale', 'sales_products','display_logo', 'order_payment_method', 'vat_type'));
        //Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).$name_invoice.$id_sale.'.pdf', $pdf->output());
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())).$name_invoice.$id_sale.'.pdf', $pdf->output());

        $name_invoice = 'invoice-';
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())).$name_invoice.$id_sale.'.pdf', $pdf->output());

        return $pdf->download('proforma-sales-'.$id_sale.'.pdf');
    }

    public function pdf_delivery_note($id_sale){
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach($sales_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR'){
            if($sale->currency == "MUR"){
                $sale->amount = $sale->amount - $sale->tax_amount;
            }
            else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }

        }
        $pdf = PDF::loadView('pdf.delivery_note', compact('ebs_typeOfPerson','company','sale', 'sales_products','display_logo'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/delivery-note-'.$id_sale.'.pdf', $pdf->output());
        return $pdf->download('delivery-note-'.$id_sale.'.pdf');
    }

    public function pdf_purchase($bill_id){

        $company = Company::latest()->first();

        $bill = Bill::find($bill_id);

        $bills_products = Bill_product::where("bill_id", $bill_id)->get();

        foreach($bills_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($bill->payment_methode);
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $pdf = PDF::loadView('pdf.purchase', compact('ebs_typeOfPerson','company','bill', 'bills_products','display_logo', 'order_payment_method'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'sale-'.$bill_id.'.pdf', $pdf->output());
        return $pdf->download('purchase-'.$bill_id.'.pdf');
    }
    public function pdf_quote($id_quote){

        $company = Company::latest()->first();

        $quote = Quotes::find($id_quote);

        $quotes_products = QuotesProducts::where("quotes_id", $id_quote)->get();

        foreach($quotes_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $pdf = PDF::loadView('pdf.quote', compact('ebs_typeOfPerson','company', 'quote', 'quotes_products', 'display_logo'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/quote-'.$id_quote.'.pdf', $pdf->output());
        return $pdf->download('quote-'.$id_quote.'.pdf');
    }

    public function pdf_appointment($id_sale){

        $company = Company::latest()->first();
        $appointment = Appointments::where('id',$id_sale)->first();
        $quote = AppointmentBillable::where('appointment_id',$appointment->id)->first();
        $quotes_products = AppointmentBillableProducts::where("appointment_billable_id", @$quote->id)->get();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        // Generate the PDF
        $pdf = PDF::loadView('pdf.appointment', compact('ebs_typeOfPerson','appointment','company', 'quote', 'quotes_products', 'display_logo'));


        //$display_logo = Setting::where("key","display_logo_in_pdf")->first();
        ////$ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        //$pdf = PDF::loadView('pdf.rental', compact('ebs_typeOfPerson','company', 'quote', 'quotes_products', 'display_logo'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/appointment-'.$id_sale.'.pdf', $pdf->output());
        return $pdf->download('appointment-'.$id_sale.'.pdf');
    }


    public function pdf_appointment_proforma($id_sale){

        $company = Company::latest()->first();
        $appointment = Appointments::where('id',$id_sale)->first();
        $quote = AppointmentBillable::where('appointment_id',$appointment->id)->first();
        $quotes_products = AppointmentBillableProducts::where("appointment_billable_id", @$quote->id)->get();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        // Generate the PDF
        $pdf = PDF::loadView('pdf.appointment_proforma', compact('ebs_typeOfPerson','appointment','company', 'quote', 'quotes_products', 'display_logo'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/appointment-proforma-' . $id_sale . '.pdf', $pdf->output());

        return $pdf->download('appointment-proforma'.$id_sale.'.pdf');
    }

    public function pdf_rental($id_quote){

        $company = Company::latest()->first();

        $quote = Rentals::find($id_quote);

        $quotes_products = Rentals_products::where("sales_id", $id_quote)->get();

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        $pdf = PDF::loadView('pdf.rental', compact('company', 'quote', 'quotes_products', 'display_logo','ebs_typeOfPerson'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/rental-' . $id_quote . '.pdf', $pdf->output());

        return $pdf->download('rental-'.$id_quote.'.pdf');
    }

    public function pdf_rental_proforma($id_quote){

        $company = Company::latest()->first();

        $quote = Rentals::find($id_quote);

        $quotes_products = Rentals_products::where("sales_id", $id_quote)->get();

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();


        $pdf = PDF::loadView('pdf.rental_proforma', compact('company', 'quote', 'quotes_products', 'display_logo','ebs_typeOfPerson'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/rental-proforma-' . $id_quote . '.pdf', $pdf->output());

        return $pdf->download('rental-proforma-'.$id_quote.'.pdf');
    }

    public function update_item_submission_amount($id_quote){

        $company = Company::latest()->first();

        $quote = Rentals::find($id_quote);

        $quotes_products = Rentals_products::where("sales_id", $id_quote)->get();

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key","ebs_typeOfPerson")->first();

        $pdf = PDF::loadView('pdf.rental', compact('ebs_typeOfPerson','company', 'quote', 'quotes_products', 'display_logo'));
        Storage::put('public/pdf/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/rental-'.$id_quote.'.pdf', $pdf->output());
        return $pdf->download('rental-'.$id_quote.'.pdf');
//        return redirect()->route('detail-rental', $id_quote)->with('message', 'Rental proforma invoice updated Successfully');

    }




}
