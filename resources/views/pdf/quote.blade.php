<!DOCTYPE html>
<html>

<head>
    <title>Quote ID - {{$quote->id}}</title>
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
                    <br><b>Quote To:</b>
                    <br>{{$quote->customer_firstname}} {{$quote->customer_lastname}}
                    @if(!empty($quote->customer_address))<br>{{$quote->customer_address}}@endif
                    @if(!empty($quote->customer_city))<br>{{$quote->customer_city}}@endif
                    @if(!empty($quote->customer_email))<br>{{$quote->customer_email}}@endif
                    @if(!empty($quote->customer_phone))<br>{{$quote->customer_phone}}@endif
                    @if(isset($quote->order_reference) && !empty($quote->order_reference)) <br><br>Quote Ref: {{$quote->order_reference}} @endif

                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">
                    <br><br>Quote Number: {{$quote->id}}
                    <br>Quote Date: {{ date('d/m/Y', strtotime($quote->created_at)) }}
                </td>
            </tr>
        </table>
        <h3>
            <div style="text-align:center">QUOTE</div>
        </h3>
        <div class="my_table">
            <table style="width:100%">
                <tr>
                    <th>Item</th>
                    <th>Selling Price (Rs)</th>
                    <th>Quantity</th>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <th>VAT</th>
                    @endif
                    <th>Amount (Rs)</th>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($quotes_products as $item)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    <td>{{ $item->product_name }}
                        @if(isset($item->variation_value) && !empty($item->variation_value))
                        <br>
                        <small>
                            @foreach ($item->variation_value as $key=>$var)
                            {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                            @if($key !== array_key_last($item->variation_value))
                            ,
                            @endif
                            @endforeach
                        </small>
                        @endif
                    </td>
                    <td>{{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                    <td>{{ $item->quantity }}</td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <td>
                        {{ $item->tax_quote }}
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
                @php
                    $i++;
                @endphp
                @endforeach
                @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td colspan="2" style="font-weight: bold;">
                        @if($quote->tax_items == "Included in the price")
                        VAT Included
                        @elseif($quote->tax_items == "Added to the price")
                        VAT Added
                        @else
                        No VAT
                        @endif
                        (Rs)</td>
                    <td>{{ number_format($quote->tax_amount,2,".",",") }}</td>
                </tr>
                @endif
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @endif
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td colspan="2" style="font-weight: bold;">Subtotal (Rs)</td>
                    <td>{{ number_format($quote->subtotal,2,".",",") }}</td>
                </tr>
                <tr>
                    <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @endif
                    <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                    <td colspan="2" style="font-weight: bold;">Total (Rs)</td>
                    <td>{{ number_format($quote->amount,2,".",",") }}</td>
                </tr>
            </table>
        </div>
        @if(!empty($quote->comment))
        <br>
        <div style="text-align:left">
            {{ $quote->comment }}
        </div>
        @endif
</body>

</html>
