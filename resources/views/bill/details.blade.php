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
                            <a href="{{ url('bill') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Bills</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Bill Page</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Bill ID #{{$bills->id}} to <a href="#" class="no-underline hover:underline">{{$bills->supplier_name}}</a>
                @if(empty($bills->bill_reference))
                <button data-modal-toggle="update-bill-ref" class="ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </button>
                @endif
            </h1>

            @if(!empty($bills->bill_reference))
            <div class="flex mt-1 ml-1 items-center">
                <label class="flex text-sm font-medium">Ref: {{$bills->bill_reference}}</label>
                <button data-modal-toggle="update-bill-ref" class="flex ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                    </svg>
                </button>
            </div>
            @endif
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
        <div class="grid gap-2 mb-6 md:grid-cols-3">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Bill Info</h3>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Date Created: {{ date('d/m/Y H:i', strtotime($bills->created_at)) }}</label>
                </div>
                @if(!empty($bills->due_date))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Due Date: {{ date('d/m/Y H:i', strtotime($bills->due_date)) }}</label>
                    </div>
                @endif
                @if(!empty($bills->delivery_date))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Purchase Date: {{ date('d/m/Y H:i', strtotime($bills->delivery_date)) }}</label>
                    </div>
                @endif
                <div class="grid gap-6 md:grid-cols-2 mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Status: {{ $bills->status }}</label>
                    </div>
                    <div class="text-right">
                        <button title="Update status" data-modal-toggle="add-product-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Payment Mode: {{ $order_payment_method->payment_method }}</label>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Amount: Rs {{ number_format($bills->amount,2,".",",") }}</label>
                </div>
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Supplier Info</h3>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Supplier Name:  <a href="#" class="no-underline hover:underline"> {{$bills->supplier_name}}</a></label>
                </div>
                @if(!empty($bills->supplier_address))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Supplier Address: {{ $bills->supplier_address }}</label>
                </div>
                @endif
                @if(!empty($bills->supplier_email))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Supplier Email: {{ $bills->supplier_email }}</label>
                </div>
                @endif
                @if(!empty($bills->supplier_phone))
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Phone: {{ $bills->supplier_phone }}</label>
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
{{--                    <div>--}}
{{--                        <label class="block mb-2 mt-1 text-sm font-medium">Store VAT Type: {{ $bills->tax_items }}</label>--}}
{{--                    </div>--}}
                    @if($bills->tax_items != 'No VAT')
                        @if($billsEbs != NULL)
                            <div>
                                <label class="block mb-2 mt-1 text-sm font-medium">MRA EBS
                                    Status: {{ $billsEbs->status }}</label>
                            </div>
                            @if((isset($billsEbs->errorMessages) &&  $billsEbs->errorMessages != NULL))
                                <div>
                                    <label class="block mb-2 mt-1 text-sm font-medium">MRA EBS Message:
                                        @if(isset($billsEbs->errorMessages) &&  $billsEbs->errorMessages != NULL)
                                            <br>- Erreur: {{ $billsEbs->errorMessages }}
                                        @endif
                                    </label>
                                </div>
                            @endif
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <div class="flex flex-col bg-white rounded-md" id="bloc_payment_sales">
            <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
                <div class="col-span-1 text-center"> <h3 class="font-semibold text-sm mt-2 mb-2">Amount Due: Rs {{ number_format($amount_due - $amount_paied,2,".",",") }}</h3> </div>
                <div class="col-span-1 text-center"> <h3 class="font-semibold text-sm mt-2 mb-2">Amount Paid: Rs {{ number_format($amount_paied,2,".",",") }}</h3> </div>
                <div class="col-span-2 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2">Payments</h3>
                </div>
                <div class="col-span-2 text-right">
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
                    <button  data-modal-toggle="add-payment-modal" type="button" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add Payment
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date Payment
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Payment Mode
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Payment Reference
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Amount
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Matched Payement ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($bill_payments as $payment)
                            <tr>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $payment->id }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ date('d/m/Y', strtotime($payment->payment_date)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    @if(!is_null($payment->payment_method))
                                    {{ $payment->payment_method->payment_method }}
                                    @else
                                        Payment method ID: {{ $payment->payment_mode }}
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $payment->payment_reference }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    Rs {{ number_format($payment->amount,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    @if($payment->matched_transaction)
                                        <a href="{{ url('banking') }}?b={{ $payment->matched_transaction }}"> Transaction ID #{{ $payment->matched_transaction }}</a>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <button data-modal-toggle="update-payment-modal" onclick="load_payment('{{ $payment->id }}',`{{date('d/m/Y', strtotime($payment->payment_date))}}`,'{{ $payment->payment_mode }}','{{ $payment->payment_reference }}','{{ $payment->amount }}')" class="text-white p-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                            </path>
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    @if($payment->id_debitnote)
                                        <button data-modal-toggle="view-debit-note-modal"
                                                onclick="view_dnjson('{{ $payment->jsondebitnote }}')"
                                                class="text-white p-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                                <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                            </svg>
                                            Vew DN JSON
                                        </button>
                                    @endif
                                    <form class="p-1" action="{{ route('bills-payments.destroy',$payment->id) }}" method="POST" onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
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
                <h3 class="font-semibold text-xl mt-2 mb-2" style="margin-right:-2.5em">Attachments</h3>
            </div>
            <div class="col-span-3 text-right">
                <button data-modal-toggle="add-attachement-modal" type="button" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload mr-2" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
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
                                    <a href="javascript:void(0)" data-modal-toggle="popup-modal-sales" onclick="view_pdf_sales('{{ route('export-purchase',$bills->id) }}','purchase-{{$bills->id}}.pdf','{{$pdf_src}}')" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                        purchase-order-{{$bills->id}}.pdf
                                    </a>
                                    {{-- <a href="{{ route('export-purchase',$bills->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                    bill-{{$bills->id}}.pdf
                                    </a> --}}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    Purchase Order
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($bills->created_at)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <a href="{{ route('export-purchase',$bills->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Download
                                    </a>
                                </td>
                            </tr>
                            @foreach($bill_files as $file)
                            <tr>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <a href="{{ url('/') }}/{{$file->src}}" target="_blank" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                        {{$file->name}}
                                    </a>
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{$file->type}}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ date('d/m/Y H:i', strtotime($file->created_at)) }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    <form class="p-1" action="{{ route('bill.destroy_billfile',$file->id) }}" method="POST" onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
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
        <h3 class="font-semibold text-xl text-center mt-2 mb-2">Bill Items</h3>
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
                                Unit Price
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Quantity
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Tax
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Bill Type
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
                        @foreach ($bills_products as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $item->product_name }}
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
                                    <br><span class="text-gray-500 text-xs">Tax: {{ $item->tax_sale }}</span>
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs {{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $item->quantity }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs
                                    @if($item->tax_sale == "15% VAT" && $bills->tax_items != "No VAT" )
                                        {{ number_format($item->order_price * 0.15,2,".",",") }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $item->bills_type }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs
                                    @if(isset($item->discount) && $item->discount > 0)
                                        {{ number_format($item->quantity * ($item->order_price - ($item->order_price*$item->discount/100)),2,".",",") }}
                                        <br><small>(Discount {{$item->discount}}%)</small>
                                    @else
                                        {{ number_format($item->quantity * $item->order_price,2,".",",") }}
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-product-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Bill Status
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-product-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('bill.update', $bills->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Sale Status</label>
                                <select id="status" name="status" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="Pending" @if($bills->status == "Pending") selected @endif>Pending</option>
                                    <option value="Paid" @if($bills->status == "Paid") selected @endif>Paid</option>
                                    <option value="Cancelled" @if($bills->status == "Cancelled") selected @endif>Cancelled</option>
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

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-bill-ref" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Order Reference
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-bill-ref">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('bills.update_bill_reference', $bills->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="bill_reference" class="text-sm font-medium text-gray-900 block mb-2">Bill Reference</label>
                                <input type="text" name="bill_reference" id="bill_reference" value="{{old('bill_reference', $bills->bill_reference)}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Order Reference">
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

                <form action="{{ route('bills-payments.index') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="bill_id" name="bill_id" value="{{$bills->id}}">
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
                                <label for="payment_mode" class="text-sm font-medium text-gray-900 block mb-2">Payment Mode</label>
                                <select id="payment_mode" name="payment_mode" value="{{old('payment_mode')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($payment_mode as $payment)
                                        @if($payment->payment_method != "Credit Sale" && $payment->payment_method != "Invoiced")
                                            <option value="{{ $payment->id }}"  {{ (old('payment_mode') == $payment->id  ? 'selected':'') }}>{{ $payment->payment_method }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" max="{{  $amount_due }}"
                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="Amount"
                                       value='{{ number_format($amount_due,2,".","") }}' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" @if(!$amount_due) disabled @endif class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
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

                <form action="{{ route('bills-payments.update', $bills->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="payment_id" name="id" value="" required>
                        <input type="hidden" name="bill_id" value="{{$bills->id}}">
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
                                <label for="update_payment_mode" class="text-sm font-medium text-gray-900 block mb-2">Payment Mode</label>
                                <select id="update_payment_mode" name="payment_mode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                @foreach($payment_mode as $pay)
                                    @if($pay->payment_method != "Credit Sale")
                                    <option value="{{ $pay->id }}">{{ $pay->payment_method }}</option>
                                    @endif
                                @endforeach
                                </select>
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

                <form action="{{ route('add-journal-sale') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="bill_id" name="bill_id" value="{{$bills->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date" value="{{old('date', date('d/m/Y', strtotime($bills->created_at)))}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit" class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit" required name="debit" value="{{old('debit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>
                                    @foreach($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit" class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit" required name="credit" value="{{old('credit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>
                                    @foreach($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($bills->amount,2,".","") }}' required="">
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

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Journal
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('update-journal-sale') }}" method="POST">
                    @csrf
                    <div class="p-6">

                        <input type="hidden" id="journal_id" name="journal_id" value="">
                        <input type="hidden" id="journal_id_debit" name="journal_id_debit" value="">
                        <input type="hidden" id="journal_id_credit" name="journal_id_credit" value="">
                        <input type="hidden" id="bill_id" name="bill_id" value="{{$bills->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date_edit" value="{{old('date', date('d/m/Y', strtotime($bills->created_at)))}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit_edit" class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit_edit" required name="debit" value="{{old('debit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>
                                    @foreach($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit_edit" class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit_edit" required name="credit" value="{{old('credit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>
                                    @foreach($ledgers as $lg)
                                        <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_edit" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($bills->amount,2,".","") }}' required="">
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

                <form action="{{ route('bill.add_bill_files') }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" name="bill_id" value="{{$bills->id}}">
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

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
         id="view-debit-note-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Debit Note JSON Request
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="view-debit-note-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-debit-note-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Debit Note
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-debit-note-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('bill.add_debit_note') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="bill_id" name="bill_id" value="{{$bills->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="debitnote_date"
                                       class="text-sm font-medium text-gray-900 block mb-2">Date</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="debitnote_date" id="debitnote_date"
                                           value="{{old('debitnote_date')}}" datepicker datepicker-autohide
                                           datepicker-format="dd/mm/yyyy" type="text"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="Date Debit Note">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="amount_debitnote" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_debitnote" step=".01" min="0.01"
                                       max="{{ $amount_max }}"
                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="Amount" value='{{ number_format($amount_max,2,".","") }}'
                                       required="">
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Reason</label>
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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div id="popup-modal-sales" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-sales">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_sale" style="min-height: 75vh"  ></iframe>
                </div>
            </div>
        </div>
    </div>

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

        function view_pdf_sales(pdf,name_pdf,src_pdf){
            $('#pdf_view_sale').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }
        function view_pdf_invoice(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }
        function view_pdf_delivery_note(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=0&statusbar=0');
        }

    </script>

    <script>
        function load_payment(id,payment_date,payment_mode,payment_reference,amount){
            $("#payment_id").val(id);
            $("#update_payment_date").val(payment_date);
            $("#update_payment_mode").val(payment_mode);
            $("#update_payment_reference").val(payment_reference);
            $("#update_amount").val(amount);
        }
    </script>

    <script>
        function view_dnjson(json_cn) {
            $("#text_result_cn").text(json_cn);
        }
    </script>

</x-app-layout>
