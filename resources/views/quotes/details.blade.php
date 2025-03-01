<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('dashboard') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('quote') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Quotes</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Quote Page</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Quote ID #{{$quotes->id}} to <a href="{{ route('customer-details', ['id' => $quotes->customer_id]) }}" class="no-underline hover:underline">{{$quotes->customer_firstname}} {{$quotes->customer_lastname}}</a>
                        
                    </h1>
                </div>
            </div>

            @if(!empty($quotes->order_reference))
            <div class="flex mt-1 ml-1 items-center">
                <label class="flex text-sm font-medium">Ref: {{$quotes->order_reference}}</label>
            </div>
            @endif
            <div class="justify-end flex items-center mb-4 sm:mb-0">
                @if(!is_null($previous))
                    <a href="{{ route('detail-quote', ['id' => $previous->id]) }}" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Previous 
                    </a>
                @endif
                @if(!is_null($next))
                    <a href="{{ route('detail-quote', ['id' => $next->id]) }}" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center mr-2">
                        Next <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if(Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <span class="font-medium">Success: </span> {{ Session::get('success')}}
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <span class="font-medium">Error: </span> {{ Session::get('error_message')}}
            </div>
            @endif

            @foreach ($errors->all() as $error)
                <span class="text-red-600 text-sm">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error: </span> {{ $error }}
                </div>
            </span>
            @endforeach

        </div>
        @php
            $sumbol_currency = "Rs";
        @endphp
        @if($quotes->currency != "MUR")
            @php
                $sumbol_currency = $quotes->currency;
            @endphp
        @endif
        <div class="grid gap-2 mb-6 md:grid-cols-3">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Quotes Info</h3>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Date Created: {{ date('d/m/Y H:i', strtotime($quotes->created_at)) }}</label>
                </div>
                <div class="grid gap-6 md:grid-cols-2 mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Status: {{ $quotes->status }}</label>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Amount:
                        @if($quotes->currency == "MUR")
                            {{$sumbol_currency}} {{ number_format($quotes->amount,2,".",",") }}
                        @else
                            Rs {{ number_format($quotes->amount,2,".",",") }} / {{$sumbol_currency}} {{ number_format($quotes->amount_converted,2,".",",") }}
                        @endif
                    </label>
                </div>
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <div class="flex items-center w-full">
                    <div class="flex-shrink-0">&nbsp;</div>
                    <div class="flex-1 text-center">
                        <h3 class="font-semibold text-xl mb-3">Customer Info</h3>
                    </div>
                    <div style="margin-top: -5%;">
                        <button title="Update Customer" data-modal-toggle="update-sale-customer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Customer Name:  <a href="{{ route('customer-details', ['id' => $quotes->customer_id]) }}" class="no-underline hover:underline"> {{$quotes->customer_firstname}} {{$quotes->customer_lastname}}</a></label>
                </div>
                @if(!empty($quotes->customer_address))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Customer Address: {{ $quotes->customer_address }}</label>
                </div>
                @endif
                @if(!empty($quotes->customer_city))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Customer City: {{ $quotes->customer_city }}</label>
                </div>
                @endif
                @if(!empty($quotes->customer_email))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Email: {{ $quotes->customer_email }}</label>
                </div>
                @endif
                @if(!empty($quotes->customer_phone))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Phone: {{ $quotes->customer_phone }}</label>
                </div>
                @endif
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Store</h3>
                @if($store != NULL)
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Store ID: {{$store->id}}</label>
                    </div>
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Store Name: {{$store->name}}</label>
                    </div>
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Store VAT Type: {{ $quotes->tax_items }}</label>
                    </div>
                @endif
                @if(!empty($quotes->delivery_date))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Delivery Date: {{ date('d/m/Y', strtotime($quotes->delivery_date)) }}</label>
                    </div>
                @endif
            </div>
        </div>

        
    <div class="flex flex-col bg-white rounded-md mt-6">
        <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
            <div class="col-span-3 text-right">
                <h3 class="font-semibold text-xl mt-2 mb-2" style="margin-right:-2.5em">Attachment</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Document
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Document Type
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date Generated
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date Sent by Email
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                <a href="javascript:void(0)" data-modal-toggle="popup-modal-quotes" onclick="view_pdf_quote('{{ route('export-quote',$quotes->id) }}','quote-{{$quotes->id}}.pdf','{{$pdf_src}}')" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                quote-{{$quotes->id}}.pdf
                                </a>
                                {{-- <a href="{{ route('export-quote',$quotes->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                    quote-{{$quotes->id}}.pdf
                                </a> --}}
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                Quote
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                {{ date('d/m/Y H:i', strtotime($quotes->created_at)) }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                <a href="{{ route('export-quote',$quotes->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Download
                                </a>
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col bg-white rounded-md mt-6">
        <h3 class="font-semibold text-xl text-center mt-2 mb-2">Quote Items</h3>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Item
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Unit Selling Price
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Unit Buying Price
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Quantity
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Tax
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Sales Type
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Amount
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($quotes_products as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                <a href="{{ route('item.edit', $item->product_id) }}" class="no-underline hover:underline">{{ $item->product_name }}</a>
                                    @if(isset($item->variation_value) && !empty($item->variation_value))
                                        <br><span class="text-gray-500 text-xs">

                                        @foreach ($item->variation_value as $key=>$var)
                                                {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                                @if($key !== array_key_last($item->variation_value))
                                                    ,
                                                @endif
                                            @endforeach
                                    </span>
                                    @endif
                                    @if(!empty($item->tax_quote)) <br><span class="text-gray-500 text-xs">Tax: {{ $item->tax_quote }}</span>@endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    @if($quotes->currency == "MUR")
                                        {{$sumbol_currency}} {{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif
                                    @else
                                        Rs {{ number_format($item->order_price,2,".",",") }} / {{$sumbol_currency}} {{ number_format($item->order_price_converted,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{$sumbol_currency}} {{ number_format($item->order_price_bying,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $item->quantity }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{$sumbol_currency}}
                                    @if($item->tax_quote == "15% VAT" && $quotes->tax_items != "No VAT" )
                                        @if($quotes->currency == "MUR")
                                            {{ number_format($item->order_price * 0.15,2,".",",") }}
                                        @else
                                            {{ number_format($item->order_price_converted * 0.15,2,".",",") }}
                                        @endif
                                    @else
                                        @if($quotes->currency == "MUR")
                                            0.00
                                        @else
                                            0.00 (Rs 0.00)
                                        @endif
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $item->sales_type }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{$sumbol_currency}}
                                    @if(isset($item->discount) && $item->discount > 0)
                                        @if($quotes->currency == "MUR")
                                            {{ number_format($item->quantity * ($item->order_price - ($item->order_price*$item->discount/100)),2,".",",") }}
                                        @else
                                        {{ number_format($item->quantity * ($item->order_price_converted - ($item->order_price_converted*$item->discount/100)),2,".",",") }} (Rs {{ number_format($item->quantity * ($item->order_price - ($item->order_price*$item->discount/100)),2,".",",") }})
                                        @endif
                                        <br><small>(Discount {{$item->discount}}%)</small>
                                    @else
                                        @if($quotes->currency == "MUR")
                                            {{ number_format($item->quantity * $item->order_price,2,".",",") }}
                                        @else
                                            {{ number_format($item->quantity * $item->order_price_converted,2,".",",") }} (Rs {{ number_format($item->quantity * $item->order_price,2,".",",") }})
                                        @endif
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <button title="Update Item" data-modal-toggle="update-item" onclick="load_row('{{$item->id}}',`{{$item->product_name}}`,`{{$item->order_price}}`,'{{$item->quantity}}','{{$item->discount}}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-sale-customer" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Customer
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-sale-customer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('quotes.update_customer', $quotes->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    First Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="firstname" placeholder="Contact First Name" value="{{old('firstname', $quotes->customer_firstname)}}">
                                
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name" value="{{old('lastname', $quotes->customer_lastname)}}">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address1" placeholder="Address 1" value="{{old('address1', $quotes->customer_address)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 2
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address2" placeholder="Address 2" value="{{old('address2')}}">
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="city">
                                City
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="city" placeholder="City" value="{{old('city',$quotes->customer_city)}}">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="phone" placeholder="Phone" value="{{old('phone',$quotes->customer_phone)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="email">
                                    Email
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email" value="{{old('email',$quotes->customer_email)}}">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Item
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('quotes.update_quote_product', $quotes->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <input type="hidden" name="item_id" id="item_id" value="">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="item">
                                                Item
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="row_item" name="row_item" placeholder="Item" value="" readonly="readonly">
                                        </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_unit_price">
                                                    Unit Selling Price (Rs)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="item_unit_price" name="item_unit_price" placeholder="Unit Selling Price" value="" step=".01">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_quantity">
                                                    Quantity
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="item_quantity" name="item_quantity" placeholder="Quantity" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="discount">
                                                    Discount (%)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="discount" name="discount" placeholder="Discount (%)" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Update Item" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="popup-modal-quotes" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-quotes">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_sale" style="min-height: 75vh"  ></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-product-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Sale Status
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-product-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update', $quotes->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Sale Status</label>
                                <select id="status" name="status" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="Pending" @if($quotes->status == "Pending") selected @endif>Pending</option>
                                    <option value="Paid" @if($quotes->status == "Paid") selected @endif>Paid</option>
                                    <option value="Cancelled" @if($quotes->status == "Cancelled") selected @endif>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-order-ref" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Order Reference
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-order-ref">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update_order_reference', $quotes->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="order_reference" class="text-sm font-medium text-gray-900 block mb-2">Order Reference</label>
                                <input type="text" name="order_reference" id="order_reference" value="{{old('order_reference', $quotes->order_reference)}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Order Reference">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Payment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales-payments.index') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{$quotes->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="payment_date" value="{{old('payment_date')}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Payment">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Payment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales-payments.update_post') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="payment_id" name="id" value="" required>
                        <input type="hidden" name="sales_id" value="{{$quotes->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                            <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="payment_date" id="update_payment_date" value="{{old('payment_date')}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Date Payment">
                            </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="update_payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="update_amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="update_amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Journal
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-attachement-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Attachment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-attachement-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.add_sale_files') }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" name="sales_id" value="{{$quotes->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="document_type" class="text-sm font-medium text-gray-900 block mb-2">Document Type</label>
                                <select id="document_type" name="document_type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="Invoice">Invoice</option>
                                    <option value="Delivery Note">Delivery Note</option>
                                    <option value="Proof of payment">Proof of payment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label class="block">
                                    <span class="sr-only">Choose profile file</span>
                                    <input type="file" name="file_upload" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100
                            " />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <div id="popup-modal-invoices" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-invoices">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_invoice" style="min-height: 75vh"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function changeJournal(id,date,debit,credit,amount,id_debit,id_credit){
            // $('#journal_id').val(id);
            $('#journal_id_debit').val(id_debit);
            $('#journal_id_credit').val(id_credit);
            $('#journal_date_edit').val(date);

            $('#journal_debit_edit option').attr('selected',false);
            $('#journal_credit_edit option').attr('selected',false);

            $('#journal_debit_edit option').each(function (){
                let debit_val = $(this).attr('value');
                if(debit_val == debit) $(this).attr('selected',true);
            });
            $('#journal_credit_edit option').each(function (){
                let credit_val = $(this).attr('value');
                if(credit_val == credit) $(this).attr('selected',true);
            });


            $('#amount_edit').val(amount);
        }

        function view_pdf_quote(pdf,name_pdf,src_pdf){
            console.log('/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
            $('#pdf_view_sale').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }
        function view_pdf_invoice(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }
        function view_pdf_delivery_note(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }
        function load_row(id,product_name,product_price,quantity,discount){
            $("#item_id").val(id);
            $("#row_item").val(product_name);
            $("#item_unit_price").val(product_price);
            $("#item_quantity").val(quantity);
            $("#discount").val(discount);
        }
    </script>

</x-app-layout>

