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
                    <br><b>Rental To:</b>
                    <br>{{$quote->customer_firstname}} {{$quote->customer_lastname}}
                    @if(!empty($quote->customer_address))<br>{{$quote->customer_address}}@endif
                    @if(!empty($quote->customer_city))<br>{{$quote->customer_city}}@endif
                    @if(!empty($quote->customer_email))<br>{{$quote->customer_email}}@endif
                    @if(!empty($quote->customer_phone))<br>{{$quote->customer_phone}}@endif
                    @if(isset($quote->order_reference) && !empty($quote->order_reference)) <br><br>Quote Ref: {{$quote->order_reference}} @endif

                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">
                    <br>Rental Period: {{ date('d/m/Y', strtotime($quote->rental_start_date)) }} - {{ date('d/m/Y', strtotime($quote->rental_end_date)) }}
                </td>
            </tr>
        </table>
        <h3>
            <div style="text-align:center">
                Proforma Invoice
            </div>
        </h3>
        <div class="my_table">
            <table style="width:100%">
                <tr>

                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price (Rs)</th>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <th>VAT (Rs)</th>
                    @endif
                    <th>Amount (Rs)</th>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($quotes_products as $item)
                <tr>

                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <td>
                        @if($item->tax_sale != "Zero Rated" && $item->tax_sale != "VAT Exempt")
                            @php
                                $rate = (float)preg_replace('/[^\d,]/', '', $item->tax_sale)/100;
                            @endphp
                            {{ number_format(($item->order_price*$item->quantity) * $rate,2,".",",") }}
                        @else
                          0
                        @endif
                    </td>
                    @endif
                    <td>
                        @if($item->tax_sale != "Zero Rated" && $item->tax_sale != "VAT Exempt" && (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR'))
                            @php
                                $rate = (float)preg_replace('/[^\d,]/', '', $item->tax_sale)/100;
                            @endphp
                            {{ number_format((($item->order_price*$item->quantity) * $rate) + ($item->quantity * $item->order_price),2,".",",") }}
                        @else
                            {{ number_format($item->quantity * $item->order_price,2,".",",") }}
                        @endif

                    </td>
                </tr>
                @php
                    $i++;
                @endphp
                @endforeach
                <tr>
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                    @endif
                        <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                        <td colspan="2" style="font-weight: bold;">Subtotal (Rs)</td>
                    <td>{{ number_format($quote->subtotal,2,".",",") }}</td>
                </tr>
                @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <tr>
                        <td style="background: white;border-left-color: white;border-bottom-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-left-color: white;border-bottom-color: white;"></td>
                        <td colspan="2" style="font-weight: bold;">
                            @if($quote->tax_items == "Included in the price")
                            VAT
                            @elseif($quote->tax_items == "Added to the price")
                            VAT
                            @else
                            VAT
                            @endif
                            (Rs)</td>
                        <td>{{ number_format($quote->tax_amount,2,".",",") }}</td>
                    </tr>
                @endif
                <tr>
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
