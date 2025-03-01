<!DOCTYPE html>
<html>

<head>
    <title>Invoice Order ID - {{ $sale->id }}</title>
    <style>
        html {
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .my_table table {
            border-collapse: collapse;
            border: 2px solid rgb(200, 200, 200);
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        .my_table table,
        .my_table td,
        .my_table th {
            border: 1px solid rgb(190, 190, 190);
            padding: 10px 20px;
            text-align: center;
        }

        .my_table th {
            background-color: rgb(235, 235, 235);
        }

        .my_table tr:nth-child(even) td {
            background-color: rgb(250, 250, 250);
        }

        .my_table tr:nth-child(odd) td {
            background-color: rgb(245, 245, 245);
        }

        caption {
            padding: 10px;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
        }

        h2 {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <table style="width:100%;">
        <tr>
            @if (isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty(@$company->logo))
                <td style="width:25%">
                    <img style="width: 120px;height: auto;" src="{{ public_path(@$company->logo) }}">
                </td>
            @endif
            <td colspan="2" style="text-align: center;">
                <h2>
                    @isset($company->company_name) {{ @$company->company_name }}
                    @else
                    {{ __('ECOM') }} @endisset
                </h2>
                @isset($company->company_address) {{ $company->company_address }}<br>
                @else
                {{ __('Mauritus') }}<br> @endisset
                @isset($company->brn_number) BRN: {{ $company->brn_number }} @endisset @if (isset($company->vat_number) && isset($company->brn_number)) | @endisset @isset($company->vat_number) VAT:
                    {{ $company->vat_number }} @endisset @if (isset($company->vat_number) || isset($company->brn_number)) <br> @endisset
                        @isset($company->company_address) Email: {{ $company->company_email }}
                        @else
                            Email: {{ __('noreply@ecom.mu') }} @endisset | @isset($company->company_phone) Phone:
                            {{ $company->company_phone }} @endisset @isset($company->company_fax) | Fax:
                        {{ $company->company_fax }} @endisset <br>
            </td>
        </tr>
    </table>
    <table style="width:100%">
        <tr>
            <td>
                <br><b>Bill To:</b>
                <br>{{ $sale->customer_firstname }} {{ $sale->customer_lastname }}
                @if (!empty($sale->customer_address))<br>{{ $sale->customer_address }}
                @endif
                @if (!empty($sale->customer_city))<br>{{ $sale->customer_city }}
                @endif
                @if (!empty($sale->customer_email))<br>{{ $sale->customer_email }}
                @endif
                @if (!empty($sale->customer_phone))<br>{{ $sale->customer_phone }}
                @endif
                @if (isset($sale->order_reference) && !empty($sale->order_reference)) <br><br>Order Ref:
                    {{ $sale->order_reference }} @endif
            </td>
            <td style="width:100px"></td>
            <td style="text-align:right">
                <br>Invoice Date: {{ date('d/m/Y H:i', strtotime($sale->created_at)) }}
                @if (isset($order_payment_method->payment_method) && !empty($order_payment_method->payment_method)) <br>Payment Method:
                    {{ $order_payment_method->payment_method }} @endif
            </td>
        </tr>
    </table>
    <h3>
        <div style="text-align:center">Proforma Invoice</div>
    </h3>
    @if (!empty($order_payment_method->text_pdf_before_invoice))
        <br>
        <div style="text-align:left">
            {!! $order_payment_method->text_pdf_before_invoice !!}
        </div>
        <br>
    @endif
    <div class="my_table">
        <table style="width:100%">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price (Rs)</th>


                <th>Discount</th>


                @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <th>VAT (Rs)</th>
                @endif
                <th>Amount (Rs)</th>
            </tr>
            @foreach ($sales_products as $item)

                <tr>
                    <td>
                        {{ $item->product_name }}
                        @if (isset($item->variation_value) && !empty($item->variation_value))
                            <br>
                            @foreach ($item->variation_value as $key => $var)
                                {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                @if ($key !== array_key_last($item->variation_value))
                                    |
                                @endif
                            @endforeach
                        @endif
                        @if (isset($item->sku) && !empty($item->sku))
                            <br>SKU: {{ $item->sku }}
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->order_price, 2, '.', ',') }} @if (!empty($item->product_unit))
                            / {{ $item->product_unit }}
                        @endif
                    </td>

                    <td>
                        @if (is_numeric($item->discount ?? null) && $item->discount > 0)
                            {{ $item->discount }}%
                        @endif

                    </td>

                    @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td>
                            @if ($item->tax_sale != 'Zero Rated' && $item->tax_sale != 'VAT Exempt')
                                @php
                                    $rate = (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                                @endphp
                                {{ number_format($item->order_price * $item->quantity * $rate, 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                    @endif
                    <td>
                        @if (
                            $item->tax_sale != 'Zero Rated' &&
                                $item->tax_sale != 'VAT Exempt' &&
                                (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR'))
                            @php
                                $rate = (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                            @endphp
                            {{ number_format($item->order_price * $item->quantity * $rate + $item->quantity * $item->order_price, 2, '.', ',') }}
                        @else
                            {{ number_format($item->quantity * $item->order_price, 2, '.', ',') }}
                        @endif
                    </td>
                </tr>
            @endforeach
            @if ($sale->pickup_or_delivery == 'Delivery' && is_null($sale->user_id))
                <tr>
                    <td>Delivery Fee
                    </td>
                    <td>{{ number_format($sale->delivery_fee, 2, '.', ',') }}</td>

                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td>--</td>
                    @if ($vat_type != 'No VAT' && (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR'))
                        <td>
                            {{ $sale->delivery_fee_tax }}
                        </td>
                    @endif
                    <td>
                        {{ number_format($sale->delivery_fee, 2, '.', ',') }}
                    </td>
                </tr>
            @endif
            @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                <tr>

                    <td
                        style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;">
                    </td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td colspan="2" style="font-weight: bold;">
                        @if (in_array($sale->tax_items, ['Included in the price', 'Added to the price']))
                            VAT
                            {{ $sale->subtotal != 0
                                ? (is_float(($sale->tax_amount / $sale->subtotal) * 100)
                                    ? number_format(($sale->tax_amount / $sale->subtotal) * 100, 2)
                                    : (int) (($sale->tax_amount / $sale->subtotal) * 100))
                                : 100 }}
                            %
                            @if ($sale->tax_items === 'Included in the price')
                                Included
                            @elseif ($sale->tax_items === 'Added to the price')
                                Added
                            @endif
                        @else
                            VAT
                        @endif
                        (Rs)

                    </td>
                    <td>{{ number_format($sale->tax_amount, 2, '.', ',') }}</td>
                </tr>
            @endif
            <tr>
                @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <td
                        style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;">
                    </td>
                @endif
                <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                <td colspan="2" style="font-weight: bold;">Subtotal (Rs)</td>
                <td>{{ number_format($sale->subtotal, 2, '.', ',') }}</td>
            </tr>

            <tr>
                @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <td
                        style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;">
                    </td>
                @endif
                <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                <td colspan="2" style="font-weight: bold;">Total (Rs)</td>
                <td>{{ number_format($sale->amount, 2, '.', ',') }}</td>
            </tr>

        </table>
    </div>
    @if (!empty($sale->comment))
        <br>
        <div style="text-align:left">
            {{ $sale->comment }}
        </div>
    @endif
    @if (!empty($order_payment_method->text_pdf_after_invoice))
        <br>
        <div style="text-align:left">
            {!! $order_payment_method->text_pdf_after_invoice !!}
        </div>
    @endif

    @if (isset($has_typeInvoicPRF) && $has_typeInvoicPRF)
        <br>
        <div style="text-align:right">
            @if (isset($label_typeInvoicPRF) && $label_typeInvoicPRF)
                <img src="data:image/png;base64,{{ $label_typeInvoicPRF }}" alt="Image QrCode" width="100"
                    height="100">
            @endif
        </div>
    @endif
</body>


</html>
