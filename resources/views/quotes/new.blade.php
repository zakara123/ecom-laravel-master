<x-app-layout>
    
    <x-slot name="header">
        
    </x-slot>
<form action="{{route('quote.index')}}" id="main_form" method="post">
    @csrf
        <div class="py-2">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 grid md:grid-cols-3 md:gap-6">
                        <div class="flex mb-2">
                            <h1 class="text-2xl sm:text-xl font-semibold text-gray-900">{{ __('New Quote') }}</h1>
                            <input name="order_reference" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 ml-4 p-2.5" type="text" placeholder="Quote Reference" value="{{old('order_reference')}}">
                        </div>
                        <div class="col-span-2 text-right mx-4">
                            <button data-modal-toggle="add-new-customer" id="btn-add-new-customer" type="button" class="bg-blue-700 hover:bg-blue-700 mx-4 text-white font-bold py-2 px-4 rounded cursor-pointer">New Customer</button>
                            <button name="name-add-news-item" id="id-add-news-item" type="button" class="bg-blue-700 hover:bg-blue-700 mr-4 text-white font-bold py-2 px-4 rounded cursor-pointer">Add New Item</button>
                            <button data-modal-toggle="add-service-item" name="add_service_item" id="add_service_item" type="button" class="bg-blue-700 hover:bg-blue-700 mr-4 text-white font-bold py-2 px-4 rounded cursor-pointer">Add Service Item</button>
                        </div>
                    </div>
                    <div class="mx-auto my-2">
                        <div class="mb-0">
                        @php
                            $vat_type = "No VAT";
                            $store_first = "";
                            $symbol_currency = "Rs";
                        @endphp

                        @if(!empty(old('currency')) && old('currency') != "MUR")
                            @php
                                $symbol_currency = old('currency');
                            @endphp
                        @endif         

                        @if(Session::has('store') && isset(Session::get('store')->vat_type))
                            @php
                                $vat_type = Session::get('store')->vat_type;
                                $store_first = Session::get('store')->id;
                            @endphp
                        @endif

                            @if(Session::has('success'))
                            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                <span class="font-medium">Success : </span> {{ Session::get('success')}}
                            </div>
                            @endif
                            @if(Session::has('error_message'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                                <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
                            </div>
                            @endif

                            @foreach ($errors->all() as $error)
                            <span class="text-red-600 text-sm">
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                                    <span class="font-medium">Error : </span> {{ $error }}
                                </div>
                            </span>
                            @endforeach
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="flex mb-6">
                                <div class="mr-2 w-full">
                                    <label class="block mb-2 text-sm font-medium text-gray-900" for="customer">
                                        Existing Customer
                                    </label>
                                    <select id="customer" name="customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" selected>Select a Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @if(Session::has('old_customer')) @if(Session::get('old_customer') == $customer->id) selected @endif @else @if($customer->id == old('customer')) selected @endif @endif>@if(!empty($customer->company_name)) {{ $customer->company_name }} @else {{ $customer->firstname }} {{ $customer->lastname }} @endif @if(!empty($customer->email)) ({{$customer->email}})@endif</option>
                                        @endforeach
                                    </select>
                                    <small id="error_message_customer" class="text-red-600 ml-2 hidden">Customer field is required</small>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="store">
                                    Stores
                                </label>
                                <select id="store" name="store" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="" selected>Select a Store</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}" @if($store->id == old('store')) selected @endif @if($store->id == old('store_popup')) selected @endif @if(!empty($store_first) && $store->id == $store_first) selected @endif >{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <small id="error_message_store" class="text-red-600 ml-2 hidden">Store field is required</small>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3 md:gap-6">
                            <div class="mb-6">
                                <div class="input-group relative flex flex-wrap items-stretch w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item">
                                    Existing Item
                                </label>
                                <div class="default_spinner ml-2 hidden" role="status">
                                    <svg aria-hidden="true" class="mr-2 w-6 h-6 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                @php
                                    $items = [];
                                    $data_currency = [];
                                    $currency_value = "1";
                                @endphp
                                @if(Session::has('item_store'))
                                    @php
                                        $items = Session::get('item_store');
                                    @endphp
                                @endif

                                <select id="item" name="item" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="" selected>Select an Item</option>
                                    @foreach($items as $product)
                                    <option value="{{ $product->id }}" @if(Session::has('old_item')) @if(Session::get('old_item') == $product->id) selected @endif @endif>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <small id="stock_label" class="text-gray-900 ml-2 hidden">Current Stock : 0</small>
                                <small id="error_message_item" class="text-red-600 ml-2 hidden">Item field is required</small>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="quantity">
                                    Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                                <small id="error_message_quantity" class="text-red-600 ml-2 hidden">Quantity field is required</small>
                            </div>
                            <div class="mb-6">
                                <input type="submit" name="add_item" id="add_item" value="Add" class="bg-blue-700 mt-7 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer"></input>
                                <input type="button" id="label_click_modal_add_item_global" value="modal add item" style="display:none" data-modal-toggle="add-new-item" />
                            </div>
                        </div>
                        <div class="overflow-x-auto relative">
                            <table class="w-full text-xs text-center font-medium text-gray-900">
                                <thead class="text-xs border text-gray-700 bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            Item
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Quantity
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Unit Selling Price ({{$symbol_currency}})
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Unit Buying Price ({{$symbol_currency}})
                                        </th>
                                        @if($vat_type != 'No VAT')
                                        <th scope="col" class="py-3 px-6">
                                            VAT ({{$symbol_currency}})
                                        </th>
                                        @endif
                                        @if($have_sale_type == 'yes')
                                        <th scope="col" class="py-3 px-6">
                                            Sales Type
                                        </th>
                                        @endif
                                        <th scope="col" class="py-3 px-6">
                                            Amount ({{$symbol_currency}})
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_amount = 0;
                                        $subtotal = 0;
                                        $vat_amount = 0;
                                        $amount_converted = 0;
                                        $subtotal_converted = 0;
                                        $tax_amount_converted = 0;
                                    @endphp
                                    @foreach($newquote as $item)
                                        <tr>
                                            <td class="py-3 px-6 border">{{$item->product_name}}
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
                                            </td>
                                            <td class="py-3 px-6 border">{{$item->quantity}}</td>
                                            <td class="py-3 px-6 border">@if(!empty(old('currency')) && old('currency') != "MUR") {{number_format($item->product_price_converted,2,".",",")}} (Rs {{number_format($item->product_price,2,".",",")}}) @else {{number_format($item->product_price,2,".",",")}}@endif @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                                            <td class="py-3 px-6 border">{{number_format($item->order_price_bying,2,".",",")}} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                                            @if($vat_type != 'No VAT')
                                                <td class="py-3 px-6 border">
                                                    @if($item->tax_quote == "15% VAT" && $vat_type != "No VAT" )
                                                        @if(!empty(old('currency')) && old('currency') != "MUR") 
                                                            {{ number_format($item->product_price * 0.15 * $item->quantity,2,".",",") }} <br><small>(15% VAT)</small>
                                                        @else
                                                            {{ number_format($item->product_price_converted * 0.15 * $item->quantity,2,".",",") }} ({{ number_format($item->product_price * 0.15 * $item->quantity,2,".",",") }}) <br><small>(15% VAT)</small>
                                                        @endif
                                                        @php
                                                            $vat_amount = $vat_amount + ($item->product_price * 0.15 * $item->quantity);
                                                            $tax_amount_converted = $tax_amount_converted + ($item->product_price_converted * 0.15 * $item->quantity);
                                                        @endphp
                                                    @else
                                                        @if(!empty(old('currency')) && old('currency') != "MUR") 
                                                            0.00 (Rs 0.00)
                                                        @else
                                                            0.00
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif
                                            @if($have_sale_type == 'yes')
                                                <td class="py-3 px-6 border">{{ $item->sales_type }}</td>
                                            @endif
                                            <td class="py-3 px-6 border">
                                                @if(isset($item->discount) && $item->discount > 0)
                                                    @if(!empty(old('currency')) && old('currency') != "MUR") 
                                                        {{number_format(($item->product_price_converted - ($item->product_price_converted * $item->discount/100)) * $item->quantity,2,".",",")}} (Rs {{number_format(($item->product_price - ($item->product_price * $item->discount/100)) * $item->quantity,2,".",",")}})
                                                    @else
                                                        {{number_format(($item->product_price - ($item->product_price * $item->discount/100)) * $item->quantity,2,".",",")}}
                                                    @endif
                                                    <br><small>(Discount {{$item->discount}}%)</small>
                                                @else
                                                    @if(!empty(old('currency')) && old('currency') != "MUR")
                                                        {{number_format($item->product_price_converted * $item->quantity,2,".",",")}} (Rs {{number_format($item->product_price * $item->quantity,2,".",",")}})
                                                    @else
                                                        {{number_format($item->product_price * $item->quantity,2,".",",")}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="py-3 border">
                                                <button data-modal-toggle="update-sales-type" onclick="load_sales_type('{{$item->id}}','{{$item->sales_type}}')" type="button" id="btn_sales_type" name="btn_sales_type" class="bg-transparent hover:bg-gray-500 text-gray-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded" title="Sales type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" width="20px" height="16px" viewBox="0 0 20 16" version="1.1">
                                                        <g id="surface1">
                                                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 8.945312 4.847656 C 8.980469 5.058594 9 5.277344 9 5.472656 C 9 5.722656 8.980469 5.941406 8.945312 6.152344 L 9.640625 6.773438 C 9.859375 6.96875 9.949219 7.253906 9.835938 7.554688 C 9.761719 7.691406 9.683594 7.882812 9.597656 8.039062 L 9.5 8.207031 C 9.378906 8.363281 9.304688 8.511719 9.195312 8.660156 C 9.015625 8.898438 8.703125 8.976562 8.421875 8.882812 L 7.539062 8.589844 C 7.203125 8.867188 6.820312 9.089844 6.40625 9.246094 L 6.191406 10.152344 C 6.15625 10.445312 5.929688 10.675781 5.636719 10.710938 C 5.429688 10.738281 5.214844 10.75 5 10.75 C 4.785156 10.75 4.570312 10.738281 4.363281 10.710938 C 4.070312 10.675781 3.816406 10.445312 3.78125 10.152344 L 3.566406 9.246094 C 3.179688 9.089844 2.796875 8.867188 2.460938 8.589844 L 1.578125 8.882812 C 1.296875 8.976562 0.984375 8.898438 0.808594 8.660156 C 0.695312 8.511719 0.59375 8.359375 0.5 8.203125 L 0.402344 8.039062 C 0.316406 7.882812 0.238281 7.71875 0.167969 7.554688 C 0.0507812 7.253906 0.140625 6.96875 0.359375 6.773438 L 1.054688 6.152344 C 1.019531 5.941406 0.972656 5.722656 0.972656 5.472656 C 0.972656 5.277344 1.019531 5.058594 1.054688 4.847656 L 0.359375 4.226562 C 0.140625 4.003906 0.0507812 3.71875 0.167969 3.445312 C 0.238281 3.253906 0.316406 3.117188 0.402344 2.960938 L 0.5 2.796875 C 0.59375 2.640625 0.695312 2.488281 0.808594 2.339844 C 0.984375 2.105469 1.296875 2.027344 1.578125 2.117188 L 2.460938 2.410156 C 2.796875 2.132812 3.179688 1.910156 3.566406 1.753906 L 3.78125 0.847656 C 3.816406 0.554688 4.070312 0.324219 4.363281 0.289062 C 4.570312 0.261719 4.785156 0.25 5 0.25 C 5.214844 0.25 5.429688 0.261719 5.636719 0.289062 C 5.929688 0.324219 6.15625 0.554688 6.191406 0.847656 L 6.40625 1.753906 C 6.820312 1.910156 7.203125 2.132812 7.539062 2.410156 L 8.421875 2.117188 C 8.703125 2.027344 9.015625 2.105469 9.195312 2.339844 C 9.304688 2.484375 9.378906 2.636719 9.5 2.796875 L 9.597656 2.964844 C 9.683594 3.121094 9.761719 3.28125 9.835938 3.445312 C 9.949219 3.71875 9.859375 4.003906 9.640625 4.226562 Z M 5 3.972656 C 4.171875 3.972656 3.5 4.671875 3.5 5.472656 C 3.5 6.328125 4.171875 6.972656 5 6.972656 C 5.828125 6.972656 6.5 6.328125 6.5 5.472656 C 6.5 4.671875 5.828125 3.972656 5 3.972656 Z M 15.152344 14.945312 C 14.941406 14.980469 14.722656 15 14.5 15 C 14.277344 15 14.058594 14.980469 13.847656 14.945312 L 13.226562 15.640625 C 13.003906 15.859375 12.71875 15.949219 12.445312 15.835938 C 12.28125 15.761719 12.117188 15.683594 11.960938 15.597656 L 11.792969 15.5 C 11.636719 15.378906 11.488281 15.304688 11.339844 15.195312 C 11.101562 15.015625 11.023438 14.703125 11.117188 14.421875 L 11.410156 13.539062 C 11.132812 13.203125 10.910156 12.820312 10.753906 12.40625 L 9.847656 12.191406 C 9.554688 12.15625 9.324219 11.929688 9.289062 11.636719 C 9.261719 11.429688 9.25 11.214844 9.25 11 C 9.25 10.785156 9.261719 10.570312 9.289062 10.363281 C 9.324219 10.070312 9.554688 9.816406 9.847656 9.78125 L 10.753906 9.566406 C 10.910156 9.179688 11.132812 8.796875 11.410156 8.460938 L 11.117188 7.578125 C 11.023438 7.296875 11.101562 6.984375 11.339844 6.804688 C 11.488281 6.695312 11.640625 6.566406 11.796875 6.496094 L 11.960938 6.402344 C 12.117188 6.316406 12.253906 6.238281 12.445312 6.164062 C 12.71875 6.050781 13.003906 6.140625 13.226562 6.359375 L 13.847656 7.054688 C 14.058594 7.019531 14.277344 7 14.5 7 C 14.722656 7 14.941406 7.019531 15.152344 7.054688 L 15.773438 6.359375 C 15.96875 6.140625 16.253906 6.050781 16.554688 6.164062 C 16.71875 6.238281 16.882812 6.316406 17.039062 6.402344 L 17.203125 6.496094 C 17.359375 6.566406 17.511719 6.695312 17.660156 6.804688 C 17.898438 6.984375 17.976562 7.296875 17.882812 7.578125 L 17.589844 8.460938 C 17.867188 8.796875 18.089844 9.179688 18.246094 9.566406 L 19.152344 9.78125 C 19.445312 9.816406 19.675781 10.070312 19.710938 10.363281 C 19.738281 10.570312 19.75 10.785156 19.75 11 C 19.75 11.214844 19.738281 11.429688 19.710938 11.636719 C 19.675781 11.929688 19.445312 12.15625 19.152344 12.191406 L 18.246094 12.40625 C 18.089844 12.820312 17.867188 13.203125 17.589844 13.539062 L 17.882812 14.421875 C 17.976562 14.703125 17.898438 15.015625 17.660156 15.195312 C 17.511719 15.304688 17.363281 15.378906 17.207031 15.5 L 17.039062 15.597656 C 16.882812 15.683594 16.691406 15.761719 16.554688 15.835938 C 16.253906 15.949219 15.96875 15.859375 15.773438 15.640625 Z M 16 11 C 16 10.171875 15.328125 9.5 14.5 9.5 C 13.671875 9.5 13 10.171875 13 11 C 13 11.828125 13.671875 12.5 14.5 12.5 C 15.328125 12.5 16 11.828125 16 11 Z M 16 11 "/>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button data-modal-toggle="update-item" onclick="load_row('{{$item->id}}',`{{$item->product_name}}`,'{{$item->product_price}}','{{$item->order_price_bying}}','{{$item->quantity}}','{{$item->discount}}','{{$item->tax_quote}}')" type="button" id="update" name="update" title="Update" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"> <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/> </svg>
                                                </button>
                                                <button type="submit" name="delete" value="{{$item->id}}" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $product_price = $item->product_price;
                                            $product_price_converted = $item->product_price_converted;
                                            if(isset($item->discount) && $item->discount > 0){
                                                $product_price = $item->product_price - ($item->product_price * $item->discount/100);
                                                $product_price_converted = $item->product_price_converted - ($item->product_price_converted * $item->discount/100);
                                            }

                                            $subtotal = $subtotal + ($product_price * $item->quantity);
                                            $subtotal_converted = $subtotal_converted + ($product_price_converted * $item->quantity);

                                            if($item->tax_quote == "15% VAT" && $vat_type != "No VAT" ){
                                                if($vat_type == "Included in the price"){
                                                    $total_amount = $total_amount + ($item->quantity * $product_price);
                                                    $amount_converted = $amount_converted + ($item->quantity * $product_price_converted);
                                                }

                                                if($vat_type == "Added to the price"){
                                                    $total_amount = $total_amount + ($item->quantity * ( $product_price + ($product_price * 0.15) ) );
                                                    $amount_converted = $amount_converted + ($item->quantity * ( $product_price + ($product_price_converted) ) );
                                                }
                                            }
                                            else
                                            {
                                                $total_amount = $total_amount + ($product_price * $item->quantity);
                                                $amount_converted = $amount_converted + ($product_price_converted * $item->quantity);
                                            }
                                        @endphp
                                    @endforeach

                                    @php 
                                        if($vat_type == "Included in the price"){
                                            $subtotal = $total_amount - $vat_amount;
                                            $subtotal_converted = $amount_converted - $tax_amount_converted;
                                        }
                                    @endphp
                                </tbody>
                                <tfoot>
                                    @if($vat_type != 'No VAT')
                                    <tr>
                                        <th colspan="3" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            VAT Amount ({{$symbol_currency}})
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            @if(!empty(old('currency')) && old('currency') != "MUR")
                                                {{number_format($tax_amount_converted,2,".",",")}} (Rs {{number_format($vat_amount,2,".",",")}})
                                            @else
                                                {{number_format($vat_amount,2,".",",")}}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            Subtotal ({{$symbol_currency}})
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            @if(!empty(old('currency')) && old('currency') != "MUR")
                                                {{number_format($subtotal_converted,2,".",",")}} (Rs {{number_format($subtotal,2,".",",")}})
                                            @else
                                                {{number_format($subtotal,2,".",",")}}
                                            @endif
                                        </th>
                                    </tr>
                                    @endif
                                    @if($vat_type != 'No VAT')
                                    <tr>
                                        <th colspan="3" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            Total Amount ({{$symbol_currency}})
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            @if(!empty(old('currency')) && old('currency') != "MUR")
                                                {{number_format($amount_converted,2,".",",")}} (Rs {{number_format($total_amount,2,".",",")}})
                                            @else
                                                {{number_format($total_amount,2,".",",")}}
                                            @endif
                                        </th>
                                    </tr>
                                    @else
                                    <tr>
                                        <th colspan="2" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            Total Amount ({{$symbol_currency}})
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            @if(!empty(old('currency')) && old('currency') != "MUR")
                                                {{number_format($amount_converted,2,".",",")}} (Rs {{number_format($total_amount,2,".",",")}})
                                            @else
                                                {{number_format($total_amount,2,".",",")}}
                                            @endif
                                        </th>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>
                        @if(Session::has('data_currency') && isset(Session::get('data_currency')->conversion_rates))
                            @php
                                $data_currency = Session::get('data_currency');
                                $currency_value = $data_currency->conversion_rates->MUR;
                            @endphp
                        @endif
                            <input data-modal-toggle="error-modal" type="hidden" name="click_btn_error_modal" id="click_btn_error_modal">
                            <input type="hidden" name="tax_items" id="tax_items" value="{{ $vat_type }}">
                            <input type="hidden" name="amount" id="amount" value="{{ $total_amount }}">
                            <input type="hidden" name="old_amount" id="old_amount" value="{{ $total_amount }}">
                            <input type="hidden" name="subtotal" id="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="vat_amount" id="vat_amount" value="{{ $vat_amount }}">
                            <input type="hidden" name="currency_value" id="currency_value" value="{{ $currency_value }}">
                            <input type="hidden" name="amount_converted" id="amount_converted" value="{{ $amount_converted }}">
                            <input type="hidden" name="subtotal_converted" id="subtotal_converted" value="{{ $subtotal_converted }}">
                            <input type="hidden" name="tax_amount_converted" id="tax_amount_converted" value="{{ $tax_amount_converted }}">
                            <input type="button" id="label_click_modal" value="modal" style="display:none" data-modal-toggle="add-variation-modal" />
                            <input type="button" id="label_click_modal_store" value="modal store" style="display:none" data-modal-toggle="add-store-modal" />
                        </div>
                        <div class="grid md:grid-cols-3 md:gap-6">
                            <div class="mb-6">
                                <div class="input-group relative flex flex-wrap items-stretch w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="currency">
                                    Sales Currency @if(isset($data_currency->conversion_rates->MUR)) : 1 {{old('currency')}} = Rs {{$data_currency->conversion_rates->MUR}} @endif
                                </label>
                                <select id="currency" name="currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="MUR" @if(old('currency') == "MUR") selected @endif>MUR</option>
                                    <option value="USD" @if(old('currency') == "USD") selected @endif>USD</option>
                                    <option value="EUR" @if(old('currency') == "EUR") selected @endif>EUR</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="delivery_date">
                                Expected Delivery Date
                            </label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input id="delivery_date" name="delivery_date" minDate="{{date('d/m/Y', strtotime(time()));}}" datepicker-format="dd/mm/yyyy" value="{{ old('delivery_date') }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Expected Delivery Date" readonly="readonly">
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Comment</label>
                            <textarea id="comment" name="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Comment...">{{ old('comment') }}</textarea>
                        </div>
                        <div class="w-full mt-4">
                            <input type="submit" name="add_quote" id="add_quote" value="Save Quote" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 cursor-pointer rounded">
                            </input>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-variation-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold" id="label_item_name">
                            Variation Item
                        </h3>
                        <!-- <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-variation-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button> -->
                    </div>

                     <div class="p-6">
                           <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700" for="variation">
                                        Variation
                                    </label>
                                    <select name="variation" id="variation" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Variation" value="{{old('variation')}}">
                                        <option value="">Select Variation</option>
                                    </select>
                                    <small id="error_message_variation" class="text-red-600 ml-2 hidden">Item field is required</small>
                                </div>
                                <div class="col-span-2">
                                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">Current Stock</label>
                                    <input type="number" name="quantity_stock" id="quantity_stock" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="{{old('quantity_stock')}}" placeholder="Stock" step=".01" disabled readonly>
                                </div>
                                <div class="col-span-2">
                                    <label for="quantity_variation" class="text-sm font-medium text-gray-900 block mb-2">Quantity</label>
                                    <input type="number" name="quantity_variation" id="quantity_variation" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Quantity" value="{{old('quantity')}}">
                                    <small id="error_message_quantity_variation" class="text-red-600 ml-2 hidden">Invalid quantity field</small>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-6 mt-2">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="text-sm font-medium text-gray-900 block mb-2">Selling Price</label>
                                    <input type="number" name="price_variation" id="price_variation" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{old('price_variation')}}" placeholder="Selling Price" step=".01">
                                    <small id="error_message_price_variation" class="text-red-600 ml-2 hidden">Invalid selling price field</small>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="text-sm font-medium text-gray-900 block mb-2">Buying Price</label>
                                    <input type="number" name="price_buying_variation" id="price_buying_variation" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" value="{{old('price_buying_variation')}}" placeholder="Buying Price" step=".01" disabled readonly>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-200 rounded-b text-right ">
                            <input type="submit" name="add_item_variation" id="add_item_variation" value="Add Item" class="text-white cursor-pointer bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"></input>
                            <button id="cancel_button" data-modal-toggle="add-variation-modal" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Cancel</button>
                        </div>
                </div>
            </div>
        </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-store-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Please Select a Store :
                        </h3>
                    </div>

                     <div class="p-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="store">
                            Stores
                        </label>
                        <select id="store_popup" name="store_popup" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" selected>Select a Store</option>
                            @foreach($stores as $store)
                            <option value="{{ $store->id }}" @if($store->id == old('store_popup')) selected @endif >{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <small id="error_message_store_popup" class="text-red-600 ml-2 hidden">Store field is required</small>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b text-right ">
                        <input type="submit" name="select_store" id="select_store" value="Select Store" class="text-white cursor-pointer bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"></input>
                        <button id="cancel_button_store" data-modal-toggle="add-store-modal" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Price or Add Discount
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
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
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="row_item" name="row_item" placeholder="Item">
                                        </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_unit_price">
                                                    Unit Selling Price (Rs)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onkeyup="calculatePriceDiscount()" type="number" id="item_unit_price" name="item_unit_price" placeholder="Unit Selling Price" value="" step=".01">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_unit_price_buying">
                                                    Unit Buying Price (Rs)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="item_unit_price_buying" name="item_unit_price_buying" placeholder="Unit Buying Price" value="" step=".01">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_quantity">
                                                    Quantity
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onkeyup="calculatePriceDiscount()" type="number" id="item_quantity" name="item_quantity" placeholder="Quantity" value="">
                                            </div>
                                        </div>
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="discount">
                                                    Discount (%)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onkeyup="calculateDiscount()" type="number" id="discount" name="discount" placeholder="Discount (%)" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    VAT
                                                </label>
                                                <select id="item_vat" name="item_vat" type="text"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    placeholder="VAT">
                                                    <option value="VAT Exempt" selected>VAT Exempt</option>
                                                    <option value="15% VAT">15% VAT</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="item_amount">
                                                Amount (Rs)
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="item_amount" name="item_amount" placeholder="Amount" value="" readonly="readonly" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Update Item" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-sales-type" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Select Sale Type
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-sales-type">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-2">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                         <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <input type="hidden" name="item_id_sales_type" id="item_id_sales_type" value="">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                Sales Type
                                            </label>
                                            <select id="quotes_type" name="quotes_type" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                placeholder="Sales Type">
                                                <option value=""></option>
                                                @foreach($sales_type as $type)
                                                    <option value="{{$type->name}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_quotes_type" id="update_quotes_type" value="Update Sales Type" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-new-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add New Item
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-new-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-2">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="flex p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg" role="alert">
                                            <svg style="width:22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><defs><style>.cls-1{fill:#fff;opacity:0;}.cls-2{fill:#231f20;}</style></defs><title>info</title><g id="Layer_2" data-name="Layer 2"><g id="info"><g id="info-2" data-name="info"><rect class="cls-1" width="24" height="24" transform="translate(24 24) rotate(180)"></rect><path class="cls-2" d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" fill="blue"></path><circle class="cls-2" cx="12" cy="8" r="1"></circle><path class="cls-2" d="M12,10a1,1,0,0,0-1,1v5a1,1,0,0,0,2,0V11A1,1,0,0,0,12,10Z" fill="blue"></path></g></g></g></svg>
                                            <span class="ml-2 font-medium">Item will be added to current order, save in Item List, and New Stock created.</span>
                                        </div>
                                        <div class="hidden modal_error_notification flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                                            <svg style="width:22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><defs><style>.cls-1{fill:#fff;opacity:0;}.cls-2{fill:#231f20;}</style></defs><title>info</title><g id="Layer_2" data-name="Layer 2"><g id="info"><g id="info-2" data-name="info"><rect class="cls-1" width="24" height="24" transform="translate(24 24) rotate(180)"></rect><path class="cls-2" d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" fill="blue"></path><circle class="cls-2" cx="12" cy="8" r="1"></circle><path class="cls-2" d="M12,10a1,1,0,0,0-1,1v5a1,1,0,0,0,2,0V11A1,1,0,0,0,12,10Z" fill="blue"></path></g></g></g></svg>
                                            <span class="modal_error_notification_msg ml-2 font-medium">A required field is empty.</span>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_name">
                                                    Name
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="add_product_name" name="add_product_name" placeholder="Name">
                                                <small id="error_add_product_name" class="text-red-600 ml-2 hidden">Name Item field is required</small>
                                            </div>
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_supplier">
                                                    Supplier
                                                </label>
                                                <select id="add_product_supplier" name="add_product_supplier"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    placeholder="Supplier">
                                                    <option value=""></option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">@if(!empty($supplier->name)){{$supplier->name}}@else{{$supplier->name_person}}@endif @if(!empty($supplier->order_email))({{$supplier->order_email}})@endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_description">
                                                Description
                                            </label>
                                            <textarea name="add_product_description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Your description..." ></textarea>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_selling_price">
                                                    Selling Price
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" step=".01" id="add_product_selling_price" name="add_product_selling_price" placeholder="Selling Price">
                                                <small id="error_add_product_selling_price" class="text-red-600 ml-2 hidden">Selling Price field is required</small>
                                            </div>
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_selling_price">
                                                    Buying Price
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" step=".01" id="add_product_buying_price" name="add_product_buying_price" placeholder="Buying Price">
                                                <small id="error_add_product_buying_price" class="text-red-600 ml-2 hidden">Buying Price field is required</small>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_quantity">
                                                    Quantity
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="add_product_quantity" name="add_product_quantity" placeholder="Quantity" value="">
                                                <small id="error_add_product_item_quantity" class="text-red-600 ml-2 hidden">Quantity field is required</small>
                                            </div>
                                            <div class="mb-2 relative pl-4 pr-4 z-0 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="add_product_vat">
                                                    VAT
                                                </label>
                                                <select id="add_product_vat" name="add_product_vat"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    placeholder="VAT">
                                                    <option value="VAT Exempt">VAT Exempt</option>
                                                    <option value="15% VAT">15% VAT</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                </select>
                                                <small id="error_add_product_vat" class="text-red-600 ml-2 hidden">VAT field is required</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 border-t border-gray-200 rounded-b text-right">
                        <input type="submit" name="add_new_item_main" id="add_new_item_main" value="Add New Item" class="mr-4 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-service-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Service Item
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-service-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-2">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="flex p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg" role="alert">
                                            <svg style="width:22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><defs><style>.cls-1{fill:#fff;opacity:0;}.cls-2{fill:#231f20;}</style></defs><title>info</title><g id="Layer_2" data-name="Layer 2"><g id="info"><g id="info-2" data-name="info"><rect class="cls-1" width="24" height="24" transform="translate(24 24) rotate(180)"></rect><path class="cls-2" d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" fill="blue"></path><circle class="cls-2" cx="12" cy="8" r="1"></circle><path class="cls-2" d="M12,10a1,1,0,0,0-1,1v5a1,1,0,0,0,2,0V11A1,1,0,0,0,12,10Z" fill="blue"></path></g></g></g></svg>
                                            <span class="ml-2 font-medium">Service Line Item is not saved into Item List, nor associated with stock.</span>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="service_item">
                                                Item
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="service_item" name="service_item" placeholder="Item" value="">
                                            <small id="error_service_item" class="text-red-600 ml-2 hidden">Item field is required</small>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="service_item_price">
                                                Unit Price
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" step=".01" id="service_item_price" name="service_item_price" placeholder="Unit Price" value="">
                                            <small id="error_service_item_price" class="text-red-600 ml-2 hidden">Unit Price field is required</small>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="service_item_quantity">
                                                Quantity
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="service_item_quantity" name="service_item_quantity" placeholder="Quantity" value="">
                                            <small id="error_service_item_quantity" class="text-red-600 ml-2 hidden">Quantity field is required</small>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="vat_service_item">
                                                VAT
                                            </label>
                                            <select id="vat_service_item" name="vat_service_item"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                placeholder="VAT">
                                                <option value="VAT Exempt">VAT Exempt</option>
                                                <option value="15% VAT">15% VAT</option>
                                                <option value="Zero Rated">Zero Rated</option>
                                            </select>
                                            <small id="error_vat_service_item" class="text-red-600 ml-2 hidden">VAT field is required</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="add_service_item" id="add_service_item" value="Add Service Item" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-new-customer" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add New Customer
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-new-customer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-2">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="hidden modal_error_notification flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                                            <svg style="width:22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><defs><style>.cls-1{fill:#fff;opacity:0;}.cls-2{fill:#231f20;}</style></defs><title>info</title><g id="Layer_2" data-name="Layer 2"><g id="info"><g id="info-2" data-name="info"><rect class="cls-1" width="24" height="24" transform="translate(24 24) rotate(180)"></rect><path class="cls-2" d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" fill="blue"></path><circle class="cls-2" cx="12" cy="8" r="1"></circle><path class="cls-2" d="M12,10a1,1,0,0,0-1,1v5a1,1,0,0,0,2,0V11A1,1,0,0,0,12,10Z" fill="blue"></path></g></g></g></svg>
                                            <span class="modal_error_notification_msg ml-2 font-medium">A required field is empty.</span>
                                        </div>
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_company_name">
                                                Company Name*
                                            </label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_company_name" name="customer_company_name" placeholder="Company Name" value="">
                                            <small class="text-gray-600 ml-2">If trading as individual, put individual full name as company name</small>
                                            <small id="error_customer_company_name" class="text-red-600 ml-2 hidden">Company Name field is required</small>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_firstname">
                                                    First Name
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_firstname" name="customer_firstname" placeholder="First Name" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_lastname">
                                                    Last Name
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_lastname" name="customer_lastname" placeholder="Last Name" value="">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_address1">
                                                    Address 1
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_address1" name="customer_address1" placeholder="Address 1" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_address2">
                                                    Address 2
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_address2" name="customer_address2" placeholder="Address 2" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_city">
                                                    City
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_city" name="customer_city" placeholder="City" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_country">
                                                    Country
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_country" name="customer_country" placeholder="Country" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_email">
                                                    Email
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_email" name="customer_email" placeholder="Email" value="">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="customer_phone">
                                                    Phone
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="customer_phone" name="customer_phone" placeholder="Phone" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="add_new_customer" id="add_new_customer" value="Add New Customer" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
            </div>
        </div>
    </div>
    </form>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="error-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Empty field
                        </h3>
                        <button type="button" class="btn_error_modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="error-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                        <div class="p-6">
                           <span id="modal_error_message_span">Error message</span>
                        </div>
                        <div class="p-6 border-t border-gray-200 rounded-b text-right">
                            <button type="button" class="btn_error_modal text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2" data-modal-toggle="error-modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
</x-app-layout>
<script>
    /// Global Variables

    var variation_products = [];
function show_error_modal(msg = "A required field is empty"){
    $("#click_btn_error_modal").click();
    $("#modal_error_message_span").html(msg);
}
function show_modal_notification(msg = "A required field is empty"){
    $(".modal_error_notification").css('display', 'flex');
    $(".modal_error_notification_msg").html(msg);
}
function init_errors(){
    $("#error_message_item").hide();
    $('#item').css('border',"");
    $("#error_message_quantity").hide();
    $('#quantity').css('border',"");
    $("#error_message_store").hide();
    $('#store').css('border',"");
    $("#error_message_customer").hide();
    $('#customer').css('border',"");
    $("#error_message_quantity_variation").hide();
    $('#quantity_variation').css('border',"");
    $("#error_message_price_variation").hide();
    $('#price_variation').css('border',"");
    $("#error_message_variation").hide();
    $('#variation').css('border',"");
    $("#error_service_item").hide();
    $('#service_item').css('border',"");
    $("#error_service_item_price").hide();
    $('#service_item_price').css('border',"");
    $("#error_service_item_quantity").hide();
    $('#service_item_quantity').css('border',"");
    $("#error_vat_service_item").hide();
    $('#vat_service_item').css('border',"");
    $('#add_product_name').css('border',"");
    $("#error_add_product_name").hide();
    $('#add_product_selling_price').css('border',"");
    $("#error_add_product_selling_price").hide();
    $('#add_product_quantity').css('border',"");
    $(".error_add_product_item_quantity").hide();
    $('#customer_company_name').css('border',"");
    $("#error_customer_company_name").hide();
}
$(document).ready(function(){
    $("form").submit(function() {
        init_errors();
        var val = $("input[type=submit][clicked=true]").val();
        if(val === "Add"){
            if($("#item").val() == ""){
                $("#error_message_item").show();
                $('#item').css('border',"solid 1px red");
                return false;
            }
            if($("#quantity").val() == ""){
                $("#error_message_quantity").show();
                $('#quantity').css('border',"solid 1px red");
                return false;
            }
            if($("#quantity").val() <= 0){
                $("#error_message_quantity").html("Invalid Quantity field.");
                $("#error_message_quantity").show();
                $('#quantity').css('border',"solid 1px red");
                return false;
            }
            return true;
        }
        if(val === "Save Quote"){
            console.log(val);
            if($("#store").val() == ""){
                $("#error_message_store").show();
                $('#store').css('border',"solid 1px red");
                show_error_modal("Store field is required");
                return false;
            }
            if($("#customer").val() == ""){
                $("#error_message_customer").show();
                show_error_modal("Customer field is required");
                $('#customer').css('border',"solid 1px red");
                return false;
            }
            return true;
        }
        if(val === "Add Item"){
            if($("#quantity_variation").val() == "" || parseFloat($("#quantity_variation").val()) <=0 ){
                $("#error_message_quantity_variation").show();
                $('#quantity_variation').css('border',"solid 1px red");
                return false;
            }
            if($("#variation").val() == ""){
                $("#error_message_variation").show();
                $('#variation').css('border',"solid 1px red");
                return false;
            }
            if($("#price_variation").val() == ""){
                $("#error_message_price_variation").show();
                $('#price_variation').css('border',"solid 1px red");
                return false;
            }
        }
        if(val === "Select Store"){
            if($("#store_popup").val() == ""){
                $("#error_message_store_popup").show();
                $('#store_popup').css('border',"solid 1px red");
                return false;
            }
        }
        if(val === "Add Service Item"){
            if($("#service_item").val() == ""){
                $("#error_service_item").show();
                $('#service_item').css('border',"solid 1px red");
                return false;
            }
            if($("#service_item_price").val() == ""){
                $("#error_service_item_price").show();
                $('#service_item_price').css('border',"solid 1px red");
                return false;
            }
            if($("#service_item_quantity").val() == ""){
                $("#error_service_item_quantity").show();
                $('#service_item_quantity').css('border',"solid 1px red");
                return false;
            }
            if($("#vat_service_item").val() == ""){
                $("#error_vat_service_item").show();
                $('#vat_service_item').css('border',"solid 1px red");
                return false;
            }
        }
        if(val === "Add New Item"){
            if($("#add_product_name").val() == ""){
                $("#error_add_product_name").show();
                show_modal_notification("Product name field is required");
                $('#add_product_name').css('border',"solid 1px red");
                return false;
            }
            if($("#add_product_selling_price").val() == ""){
                $("#error_add_product_selling_price").show();
                show_modal_notification("Selling Price field is required");
                $('#add_product_selling_price').css('border',"solid 1px red");
                return false;
            }
            if($("#add_product_quantity").val() == ""){
                $("#error_add_product_item_quantity").show();
                show_modal_notification("Quantity field is required");
                $('#add_product_quantity').css('border',"solid 1px red");
                return false;
            }
        }
        if(val === "Add New Customer"){
            if($("#customer_company_name").val() == ""){
                $("#error_customer_company_name").show();
                show_modal_notification("Company Name field is required");
                $('#customer_company_name').css('border',"solid 1px red");
                return false;
            }
        }
        init_errors();
        return true;
    });
    $("form input[type=submit]").click(function() {
        $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });
    $(".btn_error_modal").click(function() {
        $("#add_quote").attr("clicked",false);
    });
    $("#item").change(function() {
        if($("#item").val() == ""){
            $("#error_message_item").show();
            $('#item').css('border',"solid 1px red");
        }
        else{
            $("#error_message_item").hide();
            $('#item').css('border',"");
        }
    });
    $("#quantity").change(function() {
        if($("#quantity").val() == "" || parseFloat($("#quantity").val()) <= 0){
            $("#error_message_quantity").show();
            $('#quantity').css('border',"solid 1px red");
        }
        else{
            $("#error_message_quantity").hide();
            $('#quantity').css('border',"");
        }
    });
    $("#quantity").keyup(function() {
        if($("#quantity").val() == "" || parseFloat($("#quantity").val()) <= 0){
            $("#error_message_quantity").show();
            $('#quantity').css('border',"solid 1px red");
        }
        else{
            $("#error_message_quantity").hide();
            $('#quantity').css('border',"");
        }
    });
    $("#quantity").bind('keyup mouseup', function () {
        $("#quantity").keyup();            
    });
    $("#store").change(function() {
        if($("#store").val() == ""){
            $("#error_message_store").show();
            $('#store').css('border',"solid 1px red");
            $("#item").empty().end();
            $('#item').append($('<option>', {
                value: "",
                text : "Select an Item"
            }));
            $("#store_popup").val("");
        }
        else{
            $("#error_message_store").hide();
            $('#store').css('border',"");
        }
    });
    $("#quantity_variation").change(function() {
        if($("#quantity_variation").val() == "" || parseFloat($("#quantity_variation").val()) <= 0){
            $("#error_message_quantity_variation").show();
            $('#quantity_variation').css('border',"solid 1px red");
        }
        else{
            $("#error_message_quantity_variation").hide();
            $('#quantity_variation').css('border',"");
        }
        if($("#price_variation").val() == "" || parseFloat($("#price_variation").val()) <= 0){
            $("#error_message_price_variation").show();
            $('#price_variation').css('border',"solid 1px red");
        }
        else{
            $("#error_message_price_variation").hide();
            $('#price_variation').css('border',"");
        }
    });
    $("#quantity_variation").keyup(function() {
        if($("#quantity_variation").val() == "" || parseFloat($("#quantity_variation").val()) <= 0){
            $("#error_message_quantity_variation").show();
            $('#quantity_variation').css('border',"solid 1px red");
        }
        else{
            $("#error_message_quantity_variation").hide();
            $('#quantity_variation').css('border',"");
        }
    });
    $("#customer").change(function() {
        if($("#customer").val() == ""){
            $("#error_message_customer").show();
            $('#customer').css('border',"solid 1px red");
        }
        else{
            $("#error_message_customer").hide();
            $('#customer').css('border',"");
        }
    });

    $("#store").change(function() {
        if($("#store").val() != ""){
           // this.form.submit();
           $("#main_form").submit();
        }
    });
    $("#currency").change(function() {
        if($("#store").val() != ""){
            init_errors();
            $("#main_form").submit();
        } else {
            $("#error_message_store").show();
            $('#store').css('border',"solid 1px red");
        }
    });
    $("#item").change(function() {
        $("#error_message_quantity_variation").hide();
        $('#quantity_variation').css('border',"");
        $("#error_message_variation").hide();
        $('#variation').css('border',"");
        $("#error_message_price_variation").hide();
        $('#price_variation').css('border',"");
        get_variation();
    });
    flatpickr('#delivery_date', {
      "minDate": new Date().fp_incr(1),
      "dateFormat": "d/m/Y"
    });
    $("#variation").change(function() {
        $.each(variation_products, function (i, item) {
            if(item.id_item == $("#variation").val()){
                $("#price_variation").val(item.price);
                $("#price_buying_variation").val(item.price_buying);
                $("#quantity_stock").val(item.quantity_stock);
            }
        });
    });
    $("#cancel_button").click(function() {
        $("#item").val('').trigger('change');
    });
    $("#item").click(function() {
        if($("#store").val() == ""){
            $("#error_message_store_popup").hide();
            $('#store_popup').css('border',"");
            $("#label_click_modal_store").click();
            $("#item").blur();
            $("#item").select2().trigger("select2:close");
        }
    });
    $("#id-add-news-item").click(function() {
        if($("#store").val() == ""){
            $("#label_click_modal_store").click();
        }
        else{
            $("#label_click_modal_add_item_global").click();
        }
    });
    $("#store_popup").change(function() {
        if($("#store_popup").val() != ""){
            $("#error_message_store_popup").hide();
            $('#store_popup').css('border',"");
        }
        else{
            $("#error_message_store_popup").show();
            $('#store_popup').css('border',"solid 1px red");
        }
    });
    $("#update").click(function() {
        
    });

    ///select2
    $('#customer').select2({
        placeholder: 'Select customer',
        dropdownAutoWidth: false,
        width: '100%',
        allowClear: true
    });
    $('#store').select2({
        placeholder: 'Select a Store',
        dropdownAutoWidth: false,
        allowClear: true
    });
    $('#item').select2({
        placeholder: 'Select an Item',
        dropdownAutoWidth: false,
        allowClear: true
    });
    $('#add_product_supplier').select2({
        placeholder: 'Select a supplier',
        dropdownAutoWidth: false,
        width: '100%',
        allowClear: true
    });
    $('#item').on("select2:opening", function(e) {
        $("#item").click();
    });
    $('#store').on("select2:opening", function(e) {
        $("#store").click();
    });
    $(document).on('select2:open', function(e) {
        document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
    });
});
function get_variation(){
    $("#label_item_name").html("Variation Item");
    var id_prod = $("#item").val();
    var store = $("#store").val();
    if(id_prod == "") return;
    $(".default_spinner").show();
    var url = "{{ url('product_variations') }}/" + id_prod + "/" + store;
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(data) {
            $("#variation").empty().end();
            var count = 0;
            var stock = 0;
            console.log(data);
            $.each(data.variation, function (i, item) {
                if(item.variation_value_text !== ""){
                    $('#variation').append($('<option>', {
                        value: item.id,
                        text : item.variation_value_text 
                    }));
                    
                    variation_products.push({
                        id_item:item.id + "",
                        item:item.variation_value_text,
                        price:item.price,
                        price_buying:item.price_buying,
                        stock_id:item.stock_id,
                        quantity_stock:item.quantity_stock
                    });
                    count++;
                }
            });
            if(count>0){
                $("#label_item_name").html("Add " + data.product.name);
                show_variation_modal();
                $("#variation").change();
                $("#stock_label").hide();
                $("#stock_label").html("");
            }
            else{
                stock = data.stock.quantity_stock;
                variation_products = [];
                $("#stock_label").show();
                $("#stock_label").html("Current Stock : " + stock + " | Buying Price : Rs " + data.product.price_buying );
            }
            $(".default_spinner").hide();
        }
    });
}
function show_variation_modal(){
    $("#label_click_modal").click();
}
function load_row(id,product_name,product_price,product_price_buying,quantity,discount,tax_quote){
    $("#item_id").val(id);
    $("#row_item").val(product_name);
    $("#item_unit_price").val(product_price);
    $("#item_unit_price_buying").val(product_price_buying);
    $("#item_quantity").val(quantity);
    $("#discount").val(discount);
    $("#item_vat").val(tax_quote);
    var item_amount = parseFloat(product_price) * parseFloat(quantity);
    $("#item_amount").val(item_amount.toFixed(2));
    if(parseFloat(discount)>0){
        discount = product_price * discount / 100;
        product_price = product_price - discount;
        var item_amount = parseFloat(product_price) * parseFloat(quantity);
        $("#item_amount").val(item_amount.toFixed(2));
    }
}
function load_sales_type(id,sales_type){
    $("#item_id_sales_type").val(id);
    $("#sales_type").val(sales_type);
}
function calculatePriceDiscount(){
    var qty = $("#item_quantity").val();
    if (qty === "") qty = 0;
    qty = parseFloat(qty);
    var price_details = $("#item_unit_price").val();
    if (price_details === "") price_details = 0;
    price_details = parseFloat(price_details);
    var amount = qty * price_details;
    amount = amount.toFixed(2);
    $("#item_amount").val(amount + "");
}
function calculateDiscount(){
    var qty = $("#item_quantity").val();
    if (qty === "") qty = 0;
    qty = parseFloat(qty);
    var price_details = $("#item_unit_price").val();
    if (price_details === "") price_details = 0;
    price_details = parseFloat(price_details);
    var discount_details = $("#discount").val();
    if (discount_details === "") discount_details = 0;
    discount_details = parseFloat(discount_details);
    if (discount_details < 0 || discount_details > 100) {
        alert("Error Discount");
        return;
    }
    discount_details = price_details * discount_details / 100;
    price_details = price_details - discount_details;
    var amount = qty * price_details;
    amount = amount.toFixed(2);
    price_details = price_details.toFixed(2);
    $("#item_amount").val(amount + "");
}
</script>