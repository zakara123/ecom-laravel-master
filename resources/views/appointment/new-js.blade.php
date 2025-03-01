<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{ __('New Sale') }}</h1>
        </div>
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0 ml-8 mr-8">

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
    <form action="{{route('newsale.index')}}" method="post">
    @csrf
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="order_reference">
                                    Order Reference
                                </label>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="order_reference" placeholder="Order Reference" value="{{old('order_reference')}}">
                            </div>
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="store">
                                    Stores
                                </label>
                                <select id="store" name="store" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected>Select a Store</option>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}" @if($store->id == old('store')) selected @endif>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="customer">
                                    Existing Customer
                                </label>
                                <select id="customer" name="customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected>Select a Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" @if($customer->id == old('customer')) selected @endif>{{ $customer->firstname }} {{ $customer->lastname }} ({{$customer->email}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3 md:gap-6">
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="item">
                                    Existing Item
                                </label>
                                <select id="item" name="item" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected>Select an Item</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" @if($product->id == old('item')) selected @endif>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="quantity">
                                    Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" value="{{old('quantity')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                            </div>
                            <div class="mb-6">
                                <button name="add_item" id="add_item" class="bg-blue-700 mt-7 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                    ADD
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto relative">
                            <table class="w-full text-xs text-center font-medium text-gray-900 dark:text-gray-400">
                                <thead class="text-xs border text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            Item
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Quantity
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Unit Price (Rs)
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            VAT (Rs)
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Amount (Rs)
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                    <td class="py-3 px-6 border">Item 1</td>
                                    <td class="py-3 px-6 border">10</td>
                                    <td class="py-3 px-6 border">12,000.00</td>
                                    <td class="py-3 px-6 border">0.00</td>
                                    <td class="py-3 px-6 border">120,000.00</td>
                                    <td class="py-3 px-6 border">
                                        <button type="button" name="delete" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-red-500 py-2 px-4 border border-red-500 hover:border-transparent rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-6 border">Item 2</td>
                                    <td class="py-3 px-6 border">10</td>
                                    <td class="py-3 px-6 border">12,000.00</td>
                                    <td class="py-3 px-6 border">0.00</td>
                                    <td class="py-3 px-6 border">120,000.00</td>
                                    <td class="py-3 px-6 border"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-6 border">Item 3</td>
                                    <td class="py-3 px-6 border">10</td>
                                    <td class="py-3 px-6 border">12,000.00</td>
                                    <td class="py-3 px-6 border">0.00</td>
                                    <td class="py-3 px-6 border">120,000.00</td>
                                    <td class="py-3 px-6 border"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-6 border">Item 4</td>
                                    <td class="py-3 px-6 border">10</td>
                                    <td class="py-3 px-6 border">12,000.00</td>
                                    <td class="py-3 px-6 border">0.00</td>
                                    <td class="py-3 px-6 border">120,000.00</td>
                                    <td class="py-3 px-6 border"></td>
                                </tr> -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            VAT Amount (Rs)
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            0.00
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            Subtotal (Rs)
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            0.00
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="py-3 px-6">
                                        </th>
                                        <th scope="col" colspan="2" class="py-3 px-6 border">
                                            Total Amount (Rs)
                                        </th>
                                        <th colspan="2" class="py-3 px-6 border">
                                            0.00
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="w-full mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="delivery_date">
                                Expected Delivery Date
                            </label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input id="delivery_date" name="delivery_date" datepicker datepicker-autohide minDate="{{date('d/m/Y', strtotime(time()));}}" datepicker-format="dd/mm/yyyy" value="{{ old('delivery_date') }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Expected Delivery Date" readonly="readonly">
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                            <textarea id="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Comment..."></textarea>
                        </div>
                        <div class="w-full mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="payment_method">
                                Payment Mode
                            </label>
                            <select id="payment_method" name="payment_method" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" selected>Select an Payment Mode</option>
                                @foreach($payment_mode as $payment)
                                <option value="{{ $payment->id }}" @if($payment->id == old('payment_method')) selected @endif>{{ $payment->payment_method }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full mt-4">
                            <button type="submit" name="add_sale" id="add_sale" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Save Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>