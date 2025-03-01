<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayementMethodSales extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'payment_method',
        'text_email',
        'text_email_before',
        'text_email_before_invoice',
        'text_email_after_invoice',
        'text_pdf_before',
        'text_pdf_after',
        'text_pdf_before_invoice',
        'text_pdf_after_invoice',
        'thankyou',
        'failed',
        'option_visibility_mail_sales',
        'option_visibility_mail_invoice',
        'option_visibility_pdf_sales',
        'option_visibility_pdf_invoice',
        'display_delivery_options',
        'is_deleted',
        'is_default',
        'is_on_bo_sales_order',
        'is_on_online_shop_order'
    ];
}
