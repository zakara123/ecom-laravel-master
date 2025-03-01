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
                            <a href="{{ url('customer') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Customers</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Detail Sale</span>
                        </div>
                    </li>
                </ol>
            </nav>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{$customer->firstname}} {{$customer->lastname}} </h1>

        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if(Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    <span class="font-medium">Success : </span> {{ Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <span class="text-red-600 text-sm">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error : </span> {{ $error }}
                </div>
            </span>
            @endforeach

        </div>
        <div class="grid gap-2 mb-6 md:grid-cols-3">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Pending Payment</h3>
                @if(isset($final_list_pending) and (!empty($final_list_pending)))
                    @foreach($final_list_pending as $mp)
                        <div class="grid gap-6  mb-2">
                            <div>
                                <label class="block mb-2 mt-1 text-sm font-medium">{{ $mp['payment_method'] }} : Rs {{ number_format($mp['total_amount'],2,".",",") }}</label>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Paid</h3>
                @if(isset($final_list_completed) and (!empty($final_list_completed)))
                    @foreach($final_list_completed as $mpa)
                        <div class="grid gap-6  mb-2">
                            <div>
                                <label class="block mb-2 mt-1 text-sm font-medium">{{ $mpa['payment_method'] }} : Rs {{ number_format($mpa['total_amount'],2,".",",") }}</label>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Total</h3>
                <div class="grid gap-6  mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Total Pending Payment : Rs {{ number_format($total_pending,2,".",",") }}</label>
                    </div>
                </div>

                <div class="grid gap-6  mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Total Paid : Rs {{ number_format($total_paid,2,".",",") }}</label>
                    </div>
                </div>

            </div>

        </div>
        <div class="flex flex-col bg-white rounded-md">
            <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
                <div class="col-span-2 mx-4">
                    <h3 class="font-semibold text-xl mt-2 mb-2">List of sales</h3>
                </div>
                <div class="col-span-2 text-right">
                   <a  href="{{ route('customer-full-statement', $customer->id) }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Full Statement
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden px-2 pb-4">
                        <form action="{{ route('customer-part-statement', $customer->id) }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="start" required datepicker-format="dd/mm/yyyy" datepicker="" datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                            </div>
                            <span class="mx-4 text-gray-500">to</span>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input required name="end" type="text" datepicker-format="dd/mm/yyyy" datepicker="" datepicker-autohide class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                            </div>
                            <span class="mx-4 text-gray-500"> </span>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export Customer Statements</button>
                            {{-- <a  href="{{ route('customer-export-item', $customer->id) }}" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export Items</a> --}}
                            <a  href="{{ route('customer-products', $customer->id) }}" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sales History</a>
                        </div>
                        </form>
                        <div class="col-span-3 text-right">
                            <a  href="{{ route('customer-mra-request', $customer->id) }}" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Send MRA Request
                            </a>

                            <button type="button" data-modal-toggle="view-mra-modal"
                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                {{--<svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                          clip-rule="evenodd"></path>
                                </svg>--}}
                                View MRA Request
                            </button>
                        </div>
                    </div>
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Sale ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Sale Date
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Sale Reference
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount Due
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount Paid
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Balance
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @php
                            $balance = 0;
                            @endphp
                            @foreach ($sales as $sale)
                                @php
                                    $balance += $sale->amount - $sale->amount_paid;
                                @endphp
                                <tr>
                                 <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('detail-sale', ['id' => $sale->id]) }}" class="no-underline hover:underline">{{ $sale->id }}</a>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y', strtotime($sale->created_at)) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sale->order_reference }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        Rs {{ number_format($sale->amount,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        Rs {{ number_format($sale->amount_due,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        Rs {{ number_format($sale->amount_paid,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        Rs {{ number_format($balance,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $sale->status }}
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
    </div>
    <div class="flex flex-col bg-white rounded-md mt-6 hidden" >
        <h3 class="font-semibold text-xl text-center mt-2 mb-2">Sale Items</h3>
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
                                Amount
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        {{--@foreach ($sales_products as $item)
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
                                    <br><span class="text-gray-500 text-xs">Tax : {{ $item->tax_sale }}</span>
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs {{ number_format($item->order_price,2,".",",") }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $item->quantity }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs
                                    @if($item->tax_sale == "15% VAT" && $sales->tax_items != "No VAT" )
                                        {{ number_format($item->order_price * 0.15,2,".",",") }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs
                                    {{ number_format($item->quantity * $item->order_price,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"></td>
                            </tr>
                        @endforeach
                        @if($sales->pickup_or_delivery == "Delivery" && is_null($sales->user_id))
                            <tr class="hover:bg-gray-100">
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Delivery Fee
                                    <br><span class="text-gray-500 text-xs">
                                        TAX : {{ $sales->delivery_fee_tax }}
                                        </span>
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ number_format($sales->delivery_fee,2,".",",") }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">--</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs
                                    @if($sales->delivery_fee_tax == "15% VAT" && $sales->tax_items != "No VAT" )
                                        {{ number_format($sales->delivery_fee * 0.15,2,".",",") }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format($sales->delivery_fee,2,".",",") }}
                                </td>
                            </tr>
                        @endif--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal h-full hidden"
        id="view-mra-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        MRA Request
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="view-mra-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>

                </div>


                <div class="w-full max-w-2xl px-4 h-full md:h-auto overflow-x-auto overflow-y-auto">
                    @if(isset($cutomersalesEbs->jsonRequest) && $cutomersalesEbs->jsonRequest){{$cutomersalesEbs->jsonRequest}}@endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</x-app-layout>
