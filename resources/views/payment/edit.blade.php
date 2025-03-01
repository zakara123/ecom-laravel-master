<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Payment</h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
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
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white">

                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('sales-payments.update', $payment->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="sales_id" name="sales_id" value="{{$payment->sales_id}}">
                    <!-- Name -->
                        <div class="mb-6">
                            <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="payment_date" id="payment_date" value="{{old('payment_date',date('d/m/Y', strtotime($payment->payment_date)))}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Date Payment">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="payment_mode" class="text-sm font-medium text-gray-900 block mb-2">Payment Mode</label>
                            <select id="payment_mode" name="payment_mode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            @foreach($payment_mode as $pay)
                                @if($pay->payment_method != "Credit Sale")
                                <option value="{{ $pay->id }}"  {{ ($payment->payment_mode == $pay->id  ? 'selected':'') }}>{{ $pay->payment_method }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                            <input type="text" name="payment_reference" id="payment_reference" value="{{old('payment_reference',$payment->payment_reference)}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                        </div>
                        <div class="mb-6">
                            <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                            <input type="number" name="amount" id="amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($payment->amount,2,".","") }}' required="">
                        </div>

                        <div class="flex items-center justify-start mt-4">
                            <button type="submit"
                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
