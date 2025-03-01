<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('dashboard') }}"
                            class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75 mr-3"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('sales') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Sales</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Sales
                                Page</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Order ID #{{ $sales->id }} to <a
                            href="{{ route('customer-details', ['id' => $sales->customer_id]) }}"
                            class="no-underline hover:underline">{{ $sales->customer_firstname }}
                            {{ $sales->customer_lastname }}</a>
                        @if (empty($sales->order_reference))
                            <button class="ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </button>
                        @endif
                    </h1>
                </div>
                <div class="justify-end flex items-center mb-4 sm:mb-0">
                    @if (!is_null($previous))
                        <a href="{{ route('detail-sale', ['id' => $previous->id]) }}"
                            class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Previous
                        </a>
                    @endif
                    @if (!is_null($next))
                        <a href="{{ route('detail-sale', ['id' => $next->id]) }}"
                            class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center mr-2">
                            Next
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            @if (!empty($sales->order_reference))
                <div class="flex mt-1 ml-1 items-center">
                    <label class="flex text-sm font-medium">Ref: {{ $sales->order_reference }}</label>
                    <button class="flex ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil inline" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if (Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    <span class="font-medium">Success: </span> {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                    role="alert">
                    <span class="font-medium">Error: </span> {{ Session::get('error_message') }}
                </div>
            @endif

            {{--            @foreach ($errors->all() as $error) --}}
            {{--                <span class="text-red-600 text-sm"> --}}
            {{--                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert"> --}}
            {{--                    <span class="font-medium">Error: </span> {{ $error }} --}}
            {{--                </div> --}}
            {{--            </span> --}}
            {{--            @endforeach --}}

        </div>
        @php
            $sumbol_currency = 'Rs';
        @endphp
        @if ($sales->currency != 'MUR')
            @php
                $sumbol_currency = $sales->currency;
            @endphp
        @endif
        <div class="grid gap-2 mb-6 md:grid-cols-3">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Sales Info</h3>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Date
                        Created: {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}</label>
                </div>
                <div class="grid gap-6 md:grid-cols-2 mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Status: {{ $sales->status }}</label>
                    </div>
                    <div class="text-right">
                        <button title="Update status" data-modal-toggle="add-product-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid gap-6 md:grid-cols-2 mb-2">
                    <label class="block mb-2 text-sm font-medium">Payment
                        Mode: {{ $order_payment_method->payment_method }}</label>
                    <div class="text-right">
                        <button title="Update Payment Mode" data-modal-toggle="update-payment-mode-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Amount:
                        @if ($sales->currency == 'MUR')
                            {{ $sumbol_currency }} {{ number_format($sales->amount, 2, '.', ',') }}
                        @else
                            Rs {{ number_format($sales->amount, 2, '.', ',') }}
                            / {{ $sumbol_currency }} {{ number_format($sales->amount_converted, 2, '.', ',') }}
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>

                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Customer Name: <a
                            href="{{ route('customer-details', ['id' => $sales->customer_id]) }}"
                            class="no-underline hover:underline"> {{ $sales->customer_firstname }}
                            {{ $sales->customer_lastname }}</a></label>
                </div>
                @if (!empty($sales->customer_address))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Customer
                            Address: {{ $sales->customer_address }}</label>
                    </div>
                @endif
                @if (!empty($sales->customer_city))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Customer City:
                            {{ $sales->customer_city }}</label>
                    </div>
                @endif
                @if (!empty($sales->customer_email))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Email: {{ $sales->customer_email }}</label>
                    </div>
                @endif
                @if (!empty($sales->customer_phone))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Phone: {{ $sales->customer_phone }}</label>
                    </div>
                @endif
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Store</h3>
                @if ($store != null)
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Store ID: {{ $store->id }}</label>
                    </div>
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Store Name: {{ $store->name }}</label>
                    </div>
                    {{--                    <div> --}}
                    {{--                        <label class="block mb-2 mt-1 text-sm font-medium">Store VAT Type: {{ $sales->tax_items }}</label> --}}
                    {{--                    </div> --}}

                    @if ($sales->tax_items != 'No VAT')
                        @foreach ($salesEbs as $sEbs)
                            <div>
                                <label class="block mb-2 mt-1 text-sm font-medium text-uppercase">MRA EBS
                                    {{ $sEbs->labelModal }} Status: {{ $sEbs->status }}</label>
                                @if (isset($sEbs->errorMessages) && $sEbs->errorMessages != null)
                                    <br>
                                    <div>
                                        <label class="block mb-2 mt-1 text-sm font-medium">Message:
                                            @if (isset($sEbs->errorMessages) && $sEbs->errorMessages != null)
                                                <br>- Erreur: {{ $sEbs->errorMessages }}
                                            @endif
                                        </label>
                                    </div>
                                    <br>
                                @endif
                            </div>
                        @endforeach
                    @endif

                @endif
                @if ($sales->pickup_or_delivery == 'Pickup')
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Store Pickup: {{ $sales->store_pickup }}</label>
                    </div>
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Pickup
                            Date: {{ date('d/m/Y', strtotime($sales->date_pickup)) }}</label>
                    </div>
                @endif
                @if ($sales->pickup_or_delivery == 'Delivery' && is_null($sales->user_id))
                    @if ($sales->type_sale === 'Online Sales')
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Delivery
                                Method: {{ $sales->delivery_name }}</label>
                        </div>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Delivery Fee:
                                {{ $sumbol_currency }} {{ number_format($sales->delivery_fee, 2, '.', ',') }}</label>
                        </div>
                    @endif
                @endif
                @if (!empty($sales->delivery_date))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Delivery
                            Date: {{ date('d/m/Y', strtotime($sales->delivery_date)) }}</label>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex flex-col bg-white rounded-md" id="bloc_payment_sales">
            <div class="grid grid-cols-7 gap-4 mt-2 mb-2">
                <div class="col-span-1 text-center">
                    <h3 class="font-semibold text-sm mt-2 mb-2">Amount Due:
                        @if ($sales->status != 'Draft')
                            {{ $sumbol_currency }} {{ number_format($amount_due, 2, '.', ',') }}
                        @else
                            {{ $sumbol_currency }} 0
                        @endif
                    </h3>
                </div>
                <div class="col-span-1 text-center">
                    <h3 class="font-semibold text-sm mt-2 mb-2">Amount Paid:
                        {{ $sumbol_currency }} {{ number_format($amount_paied, 2, '.', ',') }}</h3>
                </div>
                <div class="col-span-3 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2">Invoices & Payments</h3>
                </div>
                <div class="col-span-2 text-right">
                    @if (Auth::User()->role == 'admin' && $sales->status != 'Draft')
                        <button type="button" data-modal-toggle="add-debit-note-modal"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add Debit Note
                        </button>
                        <button type="button" data-modal-toggle="add-credit-note-modal"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add Credit Note
                        </button>
                        <button type="button" data-modal-toggle="add-payment-modal"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add Payment
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Payment Mode
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Reference
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Balance
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <?php $counter = 1; ?>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{-- <a href="" class="text-gray-700 hover:text-gray-900 inline-flex items-center"> --}}
                                    {{ $counter }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"></td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <a href="javascript:void(0)" data-modal-toggle="popup-modal-invoices"
                                        onclick="view_pdf_invoice('{{ route('export-invoice-proforma', $sales->id) }}','proforma-sales-{{ $sales->id }}.pdf?v={{ time() }}','{{ $pdf_src }}')"
                                        class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                        proforma-invoice-{{ $sales->id }}.pdf
                                    </a>

                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $sumbol_currency }} {{ number_format($sales->amount, 2, '.', ',') }}
                                    {{-- @if ($sales->tax_amount > 0)
                                        <br><span class="text-gray-500 text-xs">Tax: 15% VAT</span>
                                @endif --}}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">

                                    {{ $sumbol_currency }} 0

                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <a href="{{ route('resend-email', $sales->id) }}"
                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                        Resend Email
                                    </a>
                                    <a href="{{ route('export-invoice-proforma', $sales->id) }}"
                                        class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Download
                                    </a>
                                    @if (isset($has_typeInvoicPRF) && $has_typeInvoicPRF)
                                        <button type="button" data-modal-toggle="json-request-prf-modal"
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                </path>
                                                <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                </path>
                                            </svg>
                                            View PRF Request
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @if ($sales->status != 'Draft')
                                <?php $counter++; ?>

                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $counter }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"></td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="javascript:void(0)" data-modal-toggle="popup-modal-invoices"
                                            onclick="view_pdf_invoice('{{ route('export-invoice', $sales->id) }}','invoice-{{ $sales->invoiceCounter }}.pdf?v={{ time() }}','{{ $pdf_src }}')"
                                            class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                            invoice-{{ $sales->id }}.pdf
                                        </a>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }} {{ number_format($sales->amount, 2, '.', ',') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }} {{ number_format($sales->amount, 2, '.', ',') }}

                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('resend-email', $sales->id) }}"
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                            Resend Email
                                        </a>
                                        <a href="{{ route('export-invoice', $sales->id) }}"
                                            class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Download
                                        </a>
                                        @if (isset($has_typeInvoicSTD) && $has_typeInvoicSTD)
                                            <button type="button" data-modal-toggle="json-request-std-modal"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                    </path>
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                    </path>
                                                </svg>
                                                View STD Request
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <?php $counter++; ?>
                            @php $balance = $sales->amount; @endphp
                            @foreach ($sales_payments as $payment)
                                @php $balance = $balance - $payment->amount; @endphp
                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $counter++ }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y', strtotime($payment->payment_date)) }}
                                        {{ date('H:i', strtotime($payment->created_at)) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if (!is_null($payment->payment_method))
                                            {{ $payment->payment_method->payment_method }}@if (isset($payment->counterInvoicePayment) && $payment->counterInvoicePayment)
                                                #{{ $payment->counterInvoicePayment }}
                                            @endif
                                        @else
                                            Payment method ID: {{ $payment->payment_mode }}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $payment->payment_reference }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }} {{ number_format($payment->amount, 2, '.', ',') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }} {{ number_format($balance, 2, '.', ',') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <button data-modal-toggle="update-payment-modal"
                                            onclick="load_payment('{{ $payment->id }}',`{{ date('d/m/Y', strtotime($payment->payment_date)) }}`,'{{ $payment->payment_mode }}','{{ $payment->payment_reference }}','{{ $payment->amount }}')"
                                            class="text-white p-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Edit
                                        </button>

                                        @if ($payment->id_creditnote)
                                            <button data-modal-toggle="view-creditnote-modal"
                                                onclick="view_cnjosn('{{ $payment->jsoncreditnote }}')"
                                                class="text-white p-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                    </path>
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                    </path>
                                                </svg>
                                                Vew CN JSON
                                            </button>
                                        @endif

                                        @if ($payment->id_debitnote)
                                            <button data-modal-toggle="view-debitnote-modal"
                                                onclick="view_dnjosn('{{ $payment->jsondebitnote }}')"
                                                class="text-white p-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                    </path>
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                    </path>
                                                </svg>
                                                Vew DN JSON
                                            </button>
                                        @endif

                                        <form
                                            class="text-white p-1 focus:ring-4 focus:ring-cyan-200 font-medium  text-sm inline-flex items-center text-center"
                                            action="{{ route('sales-payments.destroy', $payment->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                            style="margin:0">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <button type="submit"
                                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col bg-white rounded-md mt-6">
        <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
            <div class="col-span-3 text-right">
                <h3 class="font-semibold text-xl mt-2 mb-2" style="margin-right:-2.5em">MRA EBS</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Request ID
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Response ID
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Invoice Identifier
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    IRN
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    QrCode
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($salesEbs as $saleEbs)
                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $saleEbs->requestId }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $saleEbs->responseId }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $saleEbs->invoiceIdentifier }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $saleEbs->status }}
                                        <br>
                                        {{ $saleEbs->errorMessages }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $saleEbs->irn }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">

                                        <div class="col-span-2 text-right">
                                            <button type="button"
                                                data-modal-toggle="info-qrcode-{{ $saleEbs->requestId }}-modal"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                    </path>
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                    </path>
                                                </svg>
                                                View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col bg-white rounded-md mt-6">
        <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
            <div class="col-span-3 text-right">
                <h3 class="font-semibold text-xl mt-2 mb-2" style="margin-right:-2.5em">Attachments</h3>
            </div>
            <div class="col-span-3 text-right">
                <button type="button" data-modal-toggle="add-attachement-modal"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-upload mr-2" viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path
                            d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                    </svg>
                    Upload
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Document
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Document Type
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date Generated
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date Sent by Email
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!--<tr>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                <a href="javascript:void(0)" data-modal-toggle="popup-modal-sales"
                                   onclick="view_pdf_sales('{{ route('export-sale', $sales->id) }}','proforma-sales-{{ $sales->id }}.pdf','{{ $pdf_src }}')"
                                   class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                    proforma-sales-{{ $sales->id }}.pdf
                                </a>
                                {{-- <a href="{{ route('export-sale',$sales->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                    sale-{{$sales->id}}.pdf
                                </a> --}}
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                Sale Order
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--
                            </td>
                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                <a href="{{ route('resend-email', $sales->id) }}"
                                   class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                    Resend Email
                                </a>
                                <a href="{{ route('export-sale', $sales->id) }}"
                                   class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Download
                                </a>
                            </td>
                        </tr>-->

                            <tr>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{-- <a href="" class="text-gray-700 hover:text-gray-900 inline-flex items-center"> --}}
                                    <a href="javascript:void(0)" data-modal-toggle="popup-modal-invoices"
                                        onclick="view_pdf_delivery_note('{{ route('export-delivery-note', $sales->id) }}','delivery-note-{{ $sales->id }}.pdf?v={{ time() }}','{{ $pdf_src }}')"
                                        class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                        delivery-note-{{ $sales->id }}.pdf
                                    </a>
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    Delivery Note
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <a href="{{ route('export-delivery-note', $sales->id) }}"
                                        class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Download
                                    </a>
                                </td>
                            </tr>
                            @if ($sales->pickup_or_delivery == 'Delivery' && is_null($sales->user_id))
                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('attachment', $sales->id) }}" target="_blank"
                                            class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                            Mauritius Post Form #{{ $sales->id }}
                                        </a>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Mauritius
                                        Post
                                        Form #{{ $sales->id }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('attachment', $sales->id) }}" target="_blank"
                                            class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Print
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @foreach ($sales_files as $file)
                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ $file->src }}" target="_blank"
                                            class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                            {{ $file->name }}
                                        </a>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $file->type }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y H:i', strtotime($file->created_at)) }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <form class="p-1"
                                            action="{{ route('sales.destroy_salesfile', $file->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                            style="margin:0">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit"
                                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col bg-white rounded-md mt-6">
        <h3 class="font-semibold text-xl text-center mt-2 mb-2">Sale Items</h3>
        <div class="col-span-2 text-right  mb-2">
            @if ($sales->status == 'Draft')
                <button type="button" data-modal-toggle="add-new-item"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add Item
                </button>
            @endif
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Item
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Unit Price
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Quantity
                                </th>
                                @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        VAT
                                    </th>
                                @endif
                                @if ($have_sale_type == 'yes')
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Sales Type
                                    </th>
                                @endif
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sales_products as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('item.edit', $item->product_id) }}"
                                            class="no-underline hover:underline">{{ $item->product_name }}</a>

                                        @if (isset($item->variation_value) && !empty($item->variation_value))
                                            <br><span class="text-gray-500 text-xs">

                                                @foreach ($item->variation_value as $key => $var)
                                                    {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                                    @if ($key !== array_key_last($item->variation_value))
                                                        |
                                                    @endif
                                                @endforeach
                                            </span>
                                        @endif
                                        @if (isset($item->sku) && !empty($item->sku))
                                            <br><span class="text-gray-500 text-xs">SKU: {{ $item->sku }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if ($sales->currency == 'MUR')
                                            {{ $sumbol_currency }} {{ number_format($item->order_price, 2, '.', ',') }}
                                            {{--                                        @if (!empty($item->product_unit)) / {{$item->product_unit}} @endif --}}
                                            @if (!empty($item->product->unit_selling_label))
                                                / {{ $item->product->unit_selling_label }}
                                            @endif
                                        @else
                                            {{ $sumbol_currency }}
                                            {{ number_format($item->order_price, 2, '.', ',') }} /
                                            {{ $sumbol_currency }}
                                            {{ number_format($item->order_price_converted, 2, '.', ',') }}
                                            {{--                                        @if (!empty($item->product_unit)) / {{$item->product_unit}} @endif --}}
                                            @if (!empty($item->product->unit_selling_label))
                                                / {{ $item->product->unit_selling_label }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $item->quantity }}</td>
                                    @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            {{ $sumbol_currency }}
                                            @if ($item->tax_sale != 'Zero Rated' && $item->tax_sale != 'VAT Exempt')
                                                @php
                                                    $rate = (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                                                @endphp
                                                @if ($sales->currency == 'MUR')
                                                    {{ number_format($item->order_price * $item->quantity * $rate, 2, '.', ',') }}
                                                @else
                                                    {{ number_format($item->order_price_converted * $rate, 2, '.', ',') }}
                                                @endif
                                            @else
                                                @if ($sales->currency == 'MUR')
                                                    0.00
                                                @else
                                                    0.00 (Rs 0.00)
                                                @endif
                                            @endif
                                            <br><span class="text-gray-500 text-xs">VAT: {{ $item->tax_sale }}</span>
                                        </td>
                                    @endif
                                    @if ($have_sale_type == 'yes')
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            {{ $item->sales_type }}</td>
                                    @endif
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }}
                                        @if (isset($item->discount) && $item->discount > 0)
                                            @if ($sales->currency == 'MUR')
                                                {{ number_format((int) $item->quantity * ($item->order_price - ($item->order_price * $item->quantity * $item->discount) / 100), 2, '.', ',') }}
                                            @else
                                                {{ number_format((int) $item->quantity * ($item->order_price_converted - ($item->order_price_converted * $item->discount) / 100), 2, '.', ',') }}
                                                (Rs
                                                {{ number_format($item->quantity * ($item->order_price - ($item->order_price * $item->discount) / 100), 2, '.', ',') }})
                                            @endif
                                            <br><span class="text-gray-500 text-xs">{{ $item->discount }}% discount:
                                                Rs:
                                                {{ number_format($item->quantity * (($item->order_price * $item->discount) / 100), 2, '.', ',') }}
                                            </span>
                                        @else
                                            @if ($sales->currency == 'MUR')
                                                @if (
                                                    $item->tax_sale != 'Zero Rated' &&
                                                        $item->tax_sale != 'VAT Exempt' &&
                                                        (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR'))
                                                    @php
                                                        $rate =
                                                            (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                                                    @endphp
                                                    {{ number_format((int) $item->quantity * (int) $item->order_price + $item->order_price * $item->quantity * $rate, 2, '.', ',') }}
                                                @else
                                                    {{ number_format((int) $item->quantity * $item->order_price, 2, '.', ',') }}
                                                @endif
                                            @else
                                                {{ number_format($item->quantity * $item->order_price_converted, 2, '.', ',') }}
                                                (Rs
                                                {{ number_format($item->quantity * $item->order_price, 2, '.', ',') }})
                                            @endif
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if ($sales->status == 'Draft')
                                            <div class="flex items-center justify-center space-x-4">
                                                <button title="Update Item Sale" data-modal-toggle="update-item"
                                                    onclick="updateItemSale('{{ $item->product_id }}','{{ $item->tax_sale }}', '{{ $item->order_price }}', '{{ $item->product_variations_id }}', '{{ $sales->currency }}')"
                                                    class="focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-pencil inline" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <form action="{{ route('destroy_sale_item', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                    style="margin:0;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    <input type="hidden" name="_token"
                                                        value="{{ csrf_token() }}">
                                                    <button type="submit" class="focus:outline-none">
                                                        <svg width="16" height="16" fill="currentColor"
                                                            class="h-5 w-5 inline" viewBox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- TODO --}}

                                        @elseif ($sales->status == 'Pending')
                                            <button type="button" data-modal-toggle="update-item-modal"
                                                onclick="updateItem({{$item->id}},'{{$item->quantity}}','{{$item->order_price}}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                            @if ($sales->pickup_or_delivery == 'Delivery' && is_null($sales->user_id))
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Delivery
                                        Fee
                                        <br><span class="text-gray-500 text-xs">
                                            VAT: {{ $sales->delivery_fee_tax }}
                                        </span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ number_format($sales->delivery_fee, 2, '.', ',') }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                    @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            {{ $sumbol_currency }}
                                            @if ($sales->delivery_fee_tax == '15% VAT' && $sales->tax_items != 'No VAT')
                                                @php
                                                    $rate = (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                                                @endphp
                                                {{ number_format($sales->delivery_fee * 0.15, 2, '.', ',') }}
                                            @elseif((str_contains($item->tax_sale, '% VAT') || str_contains($item->tax_sale, '%')) && $sales->tax_items != 'No VAT')
                                                @php
                                                    $rate = (float) preg_replace('/[^\d,]/', '', $item->tax_sale) / 100;
                                                @endphp
                                                {{ number_format($sales->delivery_fee * $rate, 2, '.', ',') }}
                                            @else
                                                0.00
                                            @endif
                                        </td>
                                    @endif
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"></td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ number_format($sales->delivery_fee, 2, '.', ',') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">

                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($sales->status == 'Paid' && $show_stock_transfer == 'yes')
        <div class="flex flex-col bg-white rounded-md mt-6">
            <h3 class="font-semibold text-xl text-center mt-2 mb-2">Stock Transfer</h3>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Source location
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Destination location
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Item
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Quantity Transfered
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sales_products as $item)
                                    <tr class="hover:bg-gray-100">
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            Warehouse
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Online
                                            Store
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            {{ $item->product_name }}
                                            @if (isset($item->variation_value) && !empty($item->variation_value))
                                                <br><span class="text-gray-500 text-xs">
                                                    @foreach ($item->variation_value as $key => $var)
                                                        {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                                        @if ($key !== array_key_last($item->variation_value))
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                            {{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col bg-white rounded-md mt-6">
        <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
            <div class="col-span-1 text-center"></div>
            <div class="col-span-1 text-center"></div>
            <div class="col-span-2 text-center">
                <h3 class="font-semibold text-xl mt-2 mb-2">Journal</h3>
            </div>
            <div class="col-span-2 text-right">
                <button type="button" data-modal-toggle="add-journal-modal"
                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Journal ID
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Debit
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Credit
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col"
                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($journals as $journal)
                                <tr class="hover:bg-gray-100 @if ($journal->credit) border-transparent @endif"
                                    @if ($journal->credit) style="border-top: none " @endif>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        @if ($journal->debit)
                                            {{ $journal->journal_id }}
                                        @endif
                                    </td>

                                    <td class="p-4  text-center font-medium text-gray-900">
                                        @if ($journal->debit)
                                            {{ date('d/m/Y H:i', strtotime($journal->date)) }}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @php $journal_id_debit = $journal->debit @endphp
                                        {{-- @if ($journal->debit_c != '')
                                        @php $journal_id_debit = $journal->debit_c @endphp
                                    @endif --}}
                                        @if (isset($journal->debit_name))
                                            <a href="{{ route('ledger.show', $journal_id_debit) }}">
                                                {{ $journal->debit_name }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @php $journal_id_credit = $journal->credit @endphp
                                        {{-- @if ($journal->credit_c != '')
                                         @php $journal_id_credit = $journal->credit_c @endphp
                                     @endif --}}
                                        @if (isset($journal->credit_name))
                                            <a href="{{ route('ledger.show', $journal_id_credit) }}">
                                                {{ $journal->credit_name }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sumbol_currency }} {{ number_format($journal->amount, 2, '.', ',') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap space-x-2">
                                        @if ($journal->debit)
                                            @php $journal_id_credit_edit = $journal->credit_c @endphp
                                            @if ($journal->credit_c != '')
                                                @php $journal_id_credit_edit = $journal->credit_c @endphp
                                            @endif
                                            <button type="button" data-modal-toggle="update-journal-modal"
                                                onclick="changeJournal('{{ $journal->id }}','{{ date('d/m/Y H:i', strtotime($journal->date)) }}','{{ $journal_id_debit }}','{{ $journal_id_credit_edit }}','{{ $journal->amount }}','{{ $journal->debit_id }}','{{ $journal->credit_id }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-product-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Sale Status
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-product-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update', $sales->id) }}" method="POST"
                    enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Sale
                                    Status</label>
                                <select id="status" name="status"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">

                                    @if ($sales->status == 'Draft')
                                        <option value="Draft" @if ($sales->status == 'Draft') selected @endif>Draft
                                        </option>
                                    @endif
                                    <option value="Pending Payment" @if ($sales->status == 'Pending Payment') selected @endif>
                                        Pending Payment</option>
                                    <option value="Paid" @if ($sales->status == 'Paid') selected @endif>Paid
                                    </option>
                                    <option value="Cancelled" @if ($sales->status == 'Cancelled') selected @endif>
                                        Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-order-ref" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Order Reference
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-order-ref">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update_order_reference', $sales->id) }}" method="POST"
                    enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="order_reference"
                                    class="text-sm font-medium text-gray-900 block mb-2">Order
                                    Reference</label>
                                <input type="text" name="order_reference" id="order_reference"
                                    value="{{ old('order_reference', $sales->order_reference) }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Order Reference">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Payment
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales-payments.index') }}" method="POST">


                    @if (!$amount_due)
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <span class="font-medium">No payment can be added. Amount due is 0</span>
                        </div>
                    @endif
                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date
                                    Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="payment_date" value="{{ old('payment_date') }}"
                                        datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Date Payment">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_mode" class="text-sm font-medium text-gray-900 block mb-2">Payment
                                    Mode</label>
                                <select id="payment_mode" name="payment_mode" value="{{ old('payment_mode') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($payment_mode as $payment)
                                        @if ($payment->payment_method != 'Credit Sale')
                                            <option value="{{ $payment->id }}"
                                                {{ old('payment_mode') == $payment->id ? 'selected' : '' }}>
                                                {{ $payment->payment_method }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference"
                                    class="text-sm font-medium text-gray-900 block mb-2">Payment
                                    Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference"
                                    value="{{ old('payment_reference') }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="amount"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01"
                                    max="{{ $amount_due }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='{{ number_format($amount_due, 2, '.', '') }}'
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" @if (!$amount_due) disabled @endif
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-credit-note-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Credit Note
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-credit-note-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.add_credit_note') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="creditnote_date"
                                    class="text-sm font-medium text-gray-900 block mb-2">Date</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="creditnote_date" id="creditnote_date"
                                        value="{{ old('creditnote_date') }}" datepicker datepicker-autohide
                                        datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Date Credit Note">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="amount_creditnote"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_creditnote" step=".01"
                                    min="0.01" max="{{ $amount_max }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='{{ number_format($amount_max, 2, '.', '') }}'
                                    required="">
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference"
                                    class="text-sm font-medium text-gray-900 block mb-2">Reason</label>
                                <textarea name="reason" id="reason" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Reason...">{{ old('reason') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-debit-note-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Credit Note
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-debit-note-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.add_debit_note') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="creditnote_date"
                                    class="text-sm font-medium text-gray-900 block mb-2">Date</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="debitnote_date" id="debitnote_date"
                                        value="{{ old('debitnote_date') }}" datepicker datepicker-autohide
                                        datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Date Debit Note">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="amount_debitnote"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_debitnote" step=".01"
                                    min="0.01"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='' required="">
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference"
                                    class="text-sm font-medium text-gray-900 block mb-2">Reason</label>
                                <textarea name="reason" id="reason" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Reason...">{{ old('reason') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($salesEbs as $saleEb)
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
            id="info-qrcode-{{ $saleEb->requestId }}-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            QrCode EBS
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="info-qrcode-{{ $saleEb->requestId }}-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                    </div>


                    <div class="w-full max-w-2xl px-4 h-full md:h-auto overflow-x-auto overflow-y-auto">
                        @if (isset($saleEb) && !empty($saleEb))
                            @if (isset($saleEb->qrCode) && $saleEb->qrCode)
                                <img src="data:image/png;base64,{{ $saleEb->qrCode }}" alt="Image QrCode">
                                <br>
                                {{ $saleEb->qrCode }}
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    @foreach ($salesEbs as $seb)
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
            id="json-request-{{ $seb->labelModal }}-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            JSON {{ $seb->labelModal }} Request EBS
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="json-request-{{ $seb->labelModal }}-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                    </div>


                    <div class="w-full max-w-2xl px-4 h-full md:h-auto overflow-x-auto overflow-y-auto">
                        @if (isset($seb->jsonRequest) && $seb->jsonRequest)
                            {{ $seb->jsonRequest }}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="view-creditnote-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Credit Note JSON Request
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="view-creditnote-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                </div>


                <div class="w-full max-w-2xl px-4 h-full md:h-auto overflow-x-auto overflow-y-auto">
                    <p id="text_result_cn"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="view-debitnote-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Debit Note JSON Request
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="view-debitnote-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                </div>


                <div class="w-full max-w-2xl px-4 h-full md:h-auto overflow-x-auto overflow-y-auto">
                    <p id="text_result_dn"></p>
                </div>

            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Payment
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales-payments.update_post') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="payment_id" name="id" value="" required>
                        <input type="hidden" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date
                                    Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="update_payment_date"
                                        value="{{ old('payment_date') }}" datepicker datepicker-autohide
                                        datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 "
                                        placeholder="Date Payment">
                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="update_payment_mode"
                                    class="text-sm font-medium text-gray-900 block mb-2">Payment
                                    Mode</label>
                                <select id="update_payment_mode" name="payment_mode"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    @foreach ($payment_mode as $pay)
                                        @if ($pay->payment_method != 'Credit Sale')
                                            <option value="{{ $pay->id }}">{{ $pay->payment_method }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference"
                                    class="text-sm font-medium text-gray-900 block mb-2">Payment
                                    Reference</label>
                                <input type="text" name="payment_reference" id="update_payment_reference"
                                    value="{{ old('payment_reference') }}"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="update_amount"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="update_amount" step=".01"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Journal
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('add-journal-sale') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date
                                    Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date"
                                        value="{{ old('date', date('d/m/Y', strtotime($sales->created_at))) }}"
                                        datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit"
                                    class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit" required name="debit" value="{{ old('debit') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>
                                    @foreach ($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit"
                                    class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit" required name="credit" value="{{ old('credit') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>
                                    @foreach ($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='{{ number_format($sales->amount, 2, '.', '') }}'
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Journal
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('update-journal-sale') }}" method="POST">
                    @csrf
                    <div class="p-6">

                        <input type="hidden" id="journal_id" name="journal_id" value="">
                        <input type="hidden" id="journal_id_debit" name="journal_id_debit" value="">
                        <input type="hidden" id="journal_id_credit" name="journal_id_credit" value="">
                        <input type="hidden" id="sales_id" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date
                                    Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date_edit"
                                        value="{{ old('date', date('d/m/Y', strtotime($sales->created_at))) }}"
                                        datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit_edit"
                                    class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit_edit" required name="debit"
                                    value="{{ old('debit') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>
                                    @foreach ($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit_edit"
                                    class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit_edit" required name="credit"
                                    value="{{ old('credit') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>
                                    @foreach ($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount"
                                    class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_edit" step=".01"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value='{{ number_format($sales->amount, 2, '.', '') }}'
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-item-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update item
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-item-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{route('update-item-qunaity-sale')}}" method="POST">
                    @csrf
                    <div class="p-6">

                        <input type="hidden" id="update-item-id" name="item_id" value="">
                        <input type="hidden"  name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">




                            <div class="col-span-full">
                                <label for="update-item-price"
                                    class="text-sm font-medium text-gray-900 block mb-2">Unit Price</label>
                                <input type="number" name="order_price" id="update-item-price" step=".01"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Amount" value=''
                                    required="">
                            </div>
                            <div class="col-span-full">
                                <label for="update-item-quantity"
                                    class="text-sm font-medium text-gray-900 block mb-2">Quanitity</label>
                                <input type="number" name="quantity" id="update-item-quantity" min="0"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                    placeholder="Quantity" value=''
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-attachement-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Attachment
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-attachement-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.add_sale_files') }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" name="sales_id" value="{{ $sales->id }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="document_type"
                                    class="text-sm font-medium text-gray-900 block mb-2">Document
                                    Type</label>
                                <select id="document_type" name="document_type"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="Invoice">Invoice</option>
                                    <option value="Delivery Note">Delivery Note</option>
                                    <option value="Proof of payment">Proof of payment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label class="block">
                                    <span class="sr-only">Choose profile file</span>
                                    <input type="file" name="file_upload"
                                        class="block w-full text-sm text-slate-500
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
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-payment-mode-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Payment Mode
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-payment-mode-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update_payment_method', $sales->id) }}" method="POST"
                    enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="w-full mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="payment_method">
                                Payment Mode
                            </label>
                            <select id="payment_method" name="payment_method"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @foreach ($payment_mode as $payment)
                                    <option value="{{ $payment->id }}"
                                        @if ($payment->id == $sales->payment_methode) selected @endif>
                                        {{ $payment->payment_method }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-sale-customer" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        @if (!empty($customer) && $customer->user_id)
                            Update Customer
                        @else
                            Create New Customer
                        @endif
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-sale-customer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('sales.update_customer', $sales->id) }}" method="POST"
                    enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Company Name
                                </label>
                                @if (!empty($customer) && $customer->user_id)
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="company_name" placeholder="Company Name"
                                        value="{{ old('company_name', $customer->company_name) }}">
                                @else
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="company_name" placeholder="Company Name"
                                        value="{{ old('company_name') }}">
                                @endif
                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    BRN
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="brn_customer" placeholder="BRN"
                                    value="{{ old('brn_customer', $customer->brn_customer) }}">

                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    VAT
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="vat_customer" placeholder="VAT"
                                    value="{{ old('vat_customer', $customer->vat_customer) }}">

                            </div>

                        </div>
                        <div class="grid md:grid-cols-2  md:gap-6">
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    First Name
                                </label>
                                @if (!empty($customer) && $customer->user_id)
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="firstname" placeholder="Contact First Name"
                                        value="{{ old('firstname', $sales->customer_firstname) }}">
                                @else
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="firstname" placeholder="Contact First Name"
                                        value="{{ old('firstname') }}">
                                @endif
                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name"
                                    value="{{ old('lastname', $sales->customer_lastname) }}">
                            </div>

                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address1" placeholder="Address 1"
                                    value="{{ old('address1', $customer->address1) }}">
                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 2
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address2" placeholder="Address 2"
                                    value="{{ old('address2', $customer->address2) }}">
                            </div>

                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="city">
                                    Village/Town
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="city" placeholder="Village/Town"
                                    value="{{ old('city', $customer->city) }}">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="email">
                                    Email
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email"
                                    value="{{ old('email', $sales->customer_email) }}">
                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="phone" placeholder="Phone"
                                    value="{{ old('phone', $customer->customer_phone) }}">
                            </div>
                            <div class="mb-3 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Mobile
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="mobile_no" placeholder="Mobile No"
                                    value="{{ old('mobile_no', $customer->mobile_no) }}">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="update-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">

                        Update Price / Vat Type
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="update-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('update-item-sale', $sales->id) }}" method="POST">
                    @csrf

                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <input type="hidden" name="sales_id" value="{{ $sales->id }}">
                                            <input type="hidden" name="product_id" value=""
                                                id="item_id_sale">
                                            <input type="hidden" name="product_variations_id" value=""
                                                id="product_variations_id">
                                            <input type="hidden" name="currency" value="" id="currency">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_unit_price">
                                                    Unit Price (Rs)
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="number" id="item_unit_price" name="item_unit_price"
                                                    placeholder="Unit Price" value="" step="0.01"
                                                    pattern="^\d+(\.\d{0,2})?$" oninput="validateDecimal(this)">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_vat">
                                                    VAT
                                                </label>
                                                <select id="item_vat" name="item_vat"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    placeholder="VAT">
                                                    <option value="VAT Exempt">VAT Exempt</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                    @foreach ($vat_rate_setting as $k => $vtv)
                                                        <option value="{{ $vtv }}">{{ $vtv }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Update Item"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-new-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">

                        Add New Item
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="add-new-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('add-new-item-sales', $sales->id) }}" method="POST">
                    @csrf

                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="grid md:grid-cols-2">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_vat">
                                                    Item
                                                </label>
                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" id="rental_product_name"
                                                    name="rental_product_name" placeholder="Item" value="">

                                            </div>
                                            <input type="hidden" name="sales_id" value="{{ $sales->id }}">

                                            <input type="hidden" name="currency" value="" id="currency">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_unit_price">
                                                    Unit Price (Rs)
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="number" id="add_item_unit_price"
                                                    name="new_item_unit_price" placeholder="Unit Price"
                                                    value="" step="0.01" pattern="^\d+(\.\d{0,2})?$"
                                                    oninput="validateDecimal(this)">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_quantity">
                                                    Quantity
                                                </label>
                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="number" id="item_quantity" name="new_item_quantity"
                                                    placeholder="Quantity" value="" step="1">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="item_vat">
                                                    VAT
                                                </label>
                                                <select id="new_item_vat" name="new_item_vat"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    placeholder="VAT">
                                                    <option value="VAT Exempt">VAT Exempt</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                    @foreach ($vat_rate_setting as $k => $vtv)
                                                        <option value="{{ $vtv }}">{{ $vtv }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Save Item"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
        integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div id="popup-modal-sales" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-sales">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_sale" style="min-height: 75vh"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div id="popup-modal-invoices" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-invoices">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_invoice" style="min-height: 75vh"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function updateItemSale(product_id, tax_sale, order_price, product_variations_id, currency) {

            $('#update-item #item_id_sale').val(product_id);
            $('#update-item #item_vat').val(tax_sale).change();
            $('#update-item #item_unit_price').val(order_price);
            $('#update-item #product_variations_id').val(product_variations_id);
            $('#update-item #currency').val(currency);
        }
        function updateItem(itemid, quantity,price) {
            $('#update-item-id').val(itemid);
            $('#update-item-price').val(price);
            $('#update-item-quantity').val(quantity);
        }
        function changeJournal(id, date, debit, credit, amount, id_debit, id_credit) {
            // $('#journal_id').val(id);
            $('#journal_id_debit').val(id_debit);
            $('#journal_id_credit').val(id_credit);
            $('#journal_date_edit').val(date);

            $('#journal_debit_edit option').attr('selected', false);
            $('#journal_credit_edit option').attr('selected', false);

            $('#journal_debit_edit option').each(function() {
                let debit_val = $(this).attr('value');
                if (debit_val == debit) $(this).attr('selected', true);
            });
            $('#journal_credit_edit option').each(function() {
                let credit_val = $(this).attr('value');
                if (credit_val == credit) $(this).attr('selected', true);
            });


            $('#amount_edit').val(amount);
        }

        function view_pdf_sales(pdf, name_pdf, src_pdf) {
            $('#pdf_view_sale').attr('src', '/pdf/' + src_pdf + '/' + name_pdf + '##toolbar=1');
        }

        //function view_pdf_invoice(pdf, name_pdf, src_pdf) {
        //  $('#pdf_view_invoice').attr('src', '/pdf/' + src_pdf + '/' + name_pdf + '#toolbar=0&statusbar=0');
        //}
        //function view_pdf_invoice(pdf, name_pdf, src_pdf) {
        //  $('#pdf_view_invoice').attr('src', '/pdf/' + src_pdf + '/' + name_pdf + '#toolbar=0&statusbar=0');
        //}

        function view_pdf_invoice(pdf, name_pdf, src_pdf) {
            $('#pdf_view_invoice').attr('src', '/pdf/' + src_pdf + '/' + name_pdf + '#toolbar=1');
        }


        function view_pdf_delivery_note(pdf, name_pdf, src_pdf) {
            $('#pdf_view_invoice').attr('src', '/pdf/' + src_pdf + '/' + name_pdf + '##toolbar=1');
        }
    </script>

    <script>
        function load_payment(id, payment_date, payment_mode, payment_reference, amount) {
            $("#payment_id").val(id);
            $("#update_payment_date").val(payment_date);
            $("#update_payment_mode").val(payment_mode);
            $("#update_payment_reference").val(payment_reference);
            $("#update_amount").val(amount);
        }
    </script>
    <script>
        function view_cnjosn(json_cn) {
            $("#text_result_cn").text(json_cn);
        }

        function validateDecimal(input) {
            let value = input.value;
            let regex = /^\d+(\.\d{0,2})?$/;

            if (!regex.test(value)) {
                input.value = value.slice(0, -1);
            }
        }
    </script>

</x-app-layout>
