<!DOCTYPE html>
<html>

<head>
    <title>Purchase Order ID - {{$bill->id}}</title>
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
                @if(isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty(@$company->logo))
                <td style="width:25%">
                    <img style="width: 120px;height: auto;" src="{{public_path(@$company->logo)}}">
                </td>
                @endif
                <td colspan="2" style="text-align: center;">
                <h2>@isset($company->company_name) {{ @$company->company_name }} @else {{ __('ECOM') }} @endisset</h2>
                    @isset($company->company_address) {{ $company->company_address }}<br> @else {{ __('Mauritus') }}<br> @endisset
                    @isset($company->brn_number) BRN: {{ $company->brn_number }} @endisset @if(isset($company->vat_number) && isset($company->brn_number)) | @endisset @isset($company->vat_number) VAT: {{ $company->vat_number }} @endisset  @if(isset($company->vat_number) || isset($company->brn_number)) <br> @endisset
                    @isset($company->company_address) Email: {{ $company->company_email }} @else Email: {{ __('noreply@ecom.mu') }} @endisset | @isset($company->company_phone) Phone: {{ $company->company_phone }} @endisset @isset($company->company_fax) | Fax: {{ $company->company_fax }} @endisset <br>
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td>
                    <br><b>Purchase From:</b>
                    <br>{{$bill->supplier_name}}
                    @if(!empty($bill->supplier_address))<br>{{$bill->supplier_address}}@endif
                    @if(!empty($bill->supplier_email))<br>{{$bill->supplier_email}}@endif
                    @if(!empty($bill->supplier_phone))<br>{{$bill->supplier_phone}}@endif
                    @if(isset($bill->bill_reference) && !empty($bill->bill_reference)) <br><br>Bill Ref: {{$bill->bill_reference}} @endif

                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">
                    <br><br>Bill Number: {{$bill->id}}
                    <br>Purchase Date: {{ date('d/m/Y H:i', strtotime($bill->created_at)) }}
                    @if($bill->due_date)<br>Due Date: {{ date('d/m/Y', strtotime($bill->due_date)) }}@endif
                    @if($bill->delivery_date)<br>Purchase Date: {{ date('d/m/Y', strtotime($bill->delivery_date)) }}@endif
                    @if(isset($order_payment_method->payment_method) && !empty($order_payment_method->payment_method)) <br>Payment Method: {{$order_payment_method->payment_method}} @endif
                </td>
            </tr>
        </table>
        <h3>
            <div style="text-align:center">PURCHASE ORDER</div>
        </h3>
        <div class="my_table">
            <table style="width:100%">
                <tr>
                    <th>Items</th>
                    <th>Unit Price (Rs)</th>
                    <th>Quantity</th>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <th>VAT</th>
                    @endif
                    <th>Amount (Rs)</th>
                </tr>
                @foreach ($bills_products as $item)
                <tr>
                    <td>{{ $item->product_name }}
                        @if(isset($item->variation_value) && !empty($item->variation_value))
                        <br>
                        <small>
                            @foreach ($item->variation_value as $key=>$var)
                            {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                            @if($key !== array_key_last($item->variation_value))
                            |
                            @endif
                            @endforeach
                        </small>
                        @endif
                    </td>
                    <td>{{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                    <td>{{ $item->quantity }}</td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <td>
                        {{ $item->tax_sale }}
                    </td>
                    @endif
                    <td>
                        @if(isset($item->discount) && $item->discount > 0)
                            {{ number_format($item->quantity * ($item->order_price - ($item->order_price*$item->discount/100)),2,".",",") }}
                            <br><small>(Discount {{$item->discount}}%)</small>
                        @else
                            {{ number_format($item->quantity * $item->order_price,2,".",",") }}
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($bill->pickup_or_delivery == "Delivery" && is_null($bill->user_id))
                    <tr>
                        <td>Delivery Fee</td>
                        <td>{{ number_format($bill->delivery_fee,2,".",",") }}</td>
                        <td>--</td>
                        @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td>
                            {{ $bill->delivery_fee_tax }}
                        </td>
                        @endif
                        <td>
                            {{ number_format($bill->delivery_fee,2,".",",") }}
                        </td>
                    </tr>
                @endif
                @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td style="font-weight: bold;">
                        @if($bill->tax_items == "Included in the price")
                        VAT Included
                        @elseif($bill->tax_items == "Added to the price")
                        VAT Added
                        @else
                        No VAT
                        @endif
                        (Rs)</td>
                    <td>{{ number_format($bill->tax_amount,2,".",",") }}</td>
                </tr>
                @endif
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @endif
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td style="font-weight: bold;">Subtotal (Rs)</td>
                    <td>{{ number_format($bill->subtotal,2,".",",") }}</td>
                </tr>
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @endif
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td style="font-weight: bold;">Total (Rs)</td>
                    <td>{{ number_format($bill->amount,2,".",",") }}</td>
                </tr>
            </table>
        </div>
        @if(!empty($bill->comment))
        <br>
        <div style="text-align:left">
            {{ $bill->comment }}
        </div>
        @endif
</body>

</html>
