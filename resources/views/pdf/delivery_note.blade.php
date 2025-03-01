<!DOCTYPE html>
<html>

<head>
    <title>Delivery Order ID - {{$sale->id}}</title>
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
                    @isset($company->company_address) {{ $company->company_address }} @else {{ __('Mauritus') }} @endisset <br>
                    @isset($company->company_address) {{ $company->company_email }} @else {{ __('noreply@ecom.mu') }} @endisset <br>
                    @isset($company->company_phone) {{ $company->company_phone }} <br> @endisset
                    @isset($company->vat_number) VAT : {{ $company->vat_number }} <br> @endisset
                    @isset($company->brn_number) BRN : {{ $company->brn_number }} <br> @endisset
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td>
                    <br><b>Delivered To:</b>
                    <br>{{$sale->customer_firstname}} {{$sale->customer_lastname}}
                    @if(!empty($sale->customer_address))<br>{{$sale->customer_address}}@endif
                    @if(!empty($sale->customer_city))<br>{{$sale->customer_city}}@endif
                    @if(!empty($sale->customer_email))<br>{{$sale->customer_email}}@endif
                    @if(!empty($sale->customer_phone))<br>{{$sale->customer_phone}}@endif
                    @if(isset($sale->order_reference) && !empty($sale->order_reference))  <br><br>Order Ref: {{$sale->order_reference}} @endif

                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">
                    <br><br>Delivery Number : {{ date('Ymd', strtotime($sale->created_at)) }}-{{$sale->id}}
                    @if(!empty($sale->delivery_date)) 
                    <br>Delivery Date : {{ date('d/m/Y', strtotime($sale->delivery_date)) }}
                    @endif
                    @if(!empty($sale->date_pickup)) 
                    <br>Pickup Date : {{ date('d/m/Y', strtotime($sale->date_pickup)) }}
                    @endif
                </td>
            </tr>
        </table>
        <h3>
            <div style="text-align:center">DELIVERY NOTE</div>
        </h3>
        <div class="my_table">
            <table style="width:100%">
                <tr>
                    <th>Items</th>
                    <th>Quantity</th>
                </tr>
                @foreach ($sales_products as $item)
                <tr>
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
                    <td>{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @if(!empty($sale->comment))
        <br>
        <div style="text-align:left">
            {{ $sale->comment }}
        </div>
        @endif
        <br>
        <table style="width:100%">
            <tr>
                <td style="text-align:center">Delivered by:
                </td>
                <td style="width:120px"></td>
                <td style="text-align:center">Received by:
                </td>
            </tr>
        </table>
</body>

</html>