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
                            <a href="{{ url('ledger') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Ledgers</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Detail Ledger</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{$ledger->name}}</h1>
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
        <div class="grid gap-2 mb-6 md:grid-cols-3 hidden">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Pending Payment</h3>

                <div class="grid gap-6  mb-2">
                    <div>
                       </div>
                </div>

            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Paid</h3>
                <div class="grid gap-6  mb-2">
                    <div></div>
                </div>
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Total</h3>
                <div class="grid gap-6  mb-2">
                    <div></div>
                </div>
                <div class="grid gap-6  mb-2">
                    <div></div>
                </div>

            </div>

        </div>
        <div class="flex flex-col bg-white rounded-md">
            <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
                <div class="col-span-2 mx-4">
                    <h3 class="font-semibold text-xl mt-2 mb-2">List of Transactions </h3>
                </div>
                <div class="col-span-2 text-right">
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden px-2 pb-4 hidden">

                    </div>
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Transaction
                                </th>

                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Description
                                </th>

                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Debit
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Credit
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Balance
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if ($transaction->id_order && isset($transaction->is_sale) && $transaction->is_sale)
                                            <a href="{{ route('detail-bill',$transaction->id_order) }}">
                                                {{$transaction->id_order}}
                                            </a>
                                            @elseif($transaction->id_order && isset($transaction->is_bill) && $transaction->is_bill )

                                            <a href="{{ route('detail-sale',$transaction->id_order) }}">
                                                {{$transaction->id_order}}
                                            </a>
                                            @elseif($transaction->id_order && $transaction->is_petty)
                                            <a href="{{ route('petty_cash') }}">
                                                {{$transaction->id_order}}
                                            </a>
                                            @else
                                                {{$transaction->id_order}}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">

                                        @if (!$transaction->is_pettycash && !$transaction->banking && !$transaction->credit_card)
                                            @php $str_payment = ''; @endphp

{{--                                            <a href="{{ route('detail-sale',$transaction->id_order.$str_payment) }}">--}}
{{--                                                {{$transaction->name}}--}}
{{--                                            </a>--}}
                                            @if ($transaction->id_order && isset($transaction->is_sale) && $transaction->is_sale)
                                                @if(str_contains($transaction->name, 'Payment'))
                                                    @php $str_payment = '#bloc_payment_bills'; @endphp
                                                @endif
                                                <a href="{{ route('detail-bill',$transaction->id_order.$str_payment) }}">
                                                    {{$transaction->name}}
                                                </a>
                                            @elseif($transaction->id_order && isset($transaction->is_bill) && $transaction->is_bill )
                                                @if(str_contains($transaction->name, 'Payment'))
                                                    @php $str_payment = '#bloc_payment_sales'; @endphp
                                                @endif
                                                <a href="{{ route('detail-sale',$transaction->id_order.$str_payment) }}">
                                                    {{$transaction->name}}
                                                </a>
                                            @endif
                                            @if(isset($transaction->customer_name) || isset($transaction->customer_id))
                                                By <a href="{{ route('customer-details',$transaction->customer_id) }}">
                                                    {{ $transaction->customer_name }}
                                                </a>
                                            @endif
                                        @else
                                            @php $str_pettycash = ''; @endphp
                                            @if(str_contains($transaction->name, 'Petty cash'))
                                                @php $str_pettycash = ''; @endphp
                                            @endif
                                            <a href="{{ url('petty_cash') }}">
                                                {{$transaction->name}}
                                            </a>
                                        @endif


                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y', strtotime($transaction->date)) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if(isset($transaction->debit_amount))
                                            Rs {{ number_format($transaction->debit_amount,2,".",",") }}
                                        @endif

                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if(isset($transaction->credit_amount))
                                            Rs {{ number_format($transaction->credit_amount,2,".",",") }}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">

                                        @if(isset($transaction->balance))
                                            Rs {{ number_format($transaction->balance,2,".",",") }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center align-center">
                            {{ $transactions->links("pagination::tailwind") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</x-app-layout>
