<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
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
                            <a href="{{ route('item.index') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Items</a>
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
                            <a href="{{ route('item.edit', $product->id) }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">{{ $product->name }}</a>
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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                aria-current="page">Stock</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Stock List for {{ $product->name }}</h1>
                </div>
                <div class="flex items-center sm:justify-end w-full">
                    <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Show Item
                    </a>
                    <a href="{{ route('product-variation', $product->id) }}"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Manage Variations
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if (Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    <span class="font-medium">Success : </span> {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                    role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <span class="text-red-600 text-sm">
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                        role="alert">
                        <span class="font-medium">Error : </span> {{ $error }}
                    </div>
                </span>
            @endforeach

        </div>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
            <div class="mb-1 w-full">

                <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="#" method="GET">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="mt-1 relative sm:w-64 xl:w-96">
                            <input type="text" name="email" id="products-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Search for stock">
                        </div>
                    </form>
                    <div class="flex items-center sm:justify-end w-full">
                        <div class="hidden md:flex pl-2 space-x-1">
                            <a href="#"
                                class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <button data-modal-toggle="add-stock-modal"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add New Stock Level
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Stock ID
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Product Variation
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Store
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Current Stock
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        SKU
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Barcode
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Stock Updated
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($stocks as $stock)
                                    @if ($stock->product_variation_id)
                                        @foreach ($stock->productVariationId as $variation)
                                            <tr class="hover:bg-gray-100">
                                                <td class="p-4  text-center font-medium text-gray-900">
                                                    Stock : {{ $stock->products_id }}{{ $variation->id }}
                                                    {{-- {{ $stock->id }}     --}}
                                                    <br>
                                                    Product : {{ $stock->products_id }}<br>
                                                    Variation :<div>{{ $variation->id }}</div>
                                                </td>
                                                <td
                                                    class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                    {{ $stock->readable_product_variations }}
                                                </td>
                                                <td
                                                    class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                    {{ $stock->name }}
                                                </td>
                                                <td
                                                    class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                    {{ $stock->quantity_stock }}
                                                </td>
                                                <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                                    {{ $stock->sku }}
                                                </td>
                                                <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                                    {!! $stock->barcode_image !!}
                                                </td>
                                                <td
                                                    class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                    @if (!empty($stock->date_received))
                                                        {{ date('d/m/Y', strtotime($stock->date_received)) }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                    <button onclick="get_stock_history('{{ $stock->id }}')"
                                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" fill="currentColor" class="mr-1 h-5 w-5"
                                                            viewBox="0 0 18 18">
                                                            <path
                                                                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                            <path
                                                                d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                            <path
                                                                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                        </svg>
                                                        Stock History
                                                    </button><br>
                                                    <a href="{{ route('stock.edit', $stock->id) }}"
                                                        class="mt-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                        <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                            </path>
                                                            <path fill-rule="evenodd"
                                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('stock.destroy', $stock->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                        style="margin:0">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token"
                                                            value="{{ csrf_token() }}">

                                                        <button type="submit"
                                                            class="mt-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                            <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                                viewBox="0 0 20 20"
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
                                    @else
                                        <tr class="hover:bg-gray-100">
                                            <td class="p-4  text-center font-medium text-gray-900">
                                                Stock : {{ $stock->products_id }}
                                                {{-- {{ $stock->id }} --}}
                                                <br>
                                                Product : {{ $stock->products_id }}<br>
                                                Variation :<div>(No Variation)</div>
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                {{ $stock->readable_product_variations }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                {{ $stock->name }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                {{ $stock->quantity_stock }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                                {{ $stock->sku }}
                                            </td>
                                            <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                                {!! $stock->barcode_image !!}
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                @if (!empty($stock->date_received))
                                                    {{ date('d/m/Y', strtotime($stock->date_received)) }}
                                                @endif
                                            </td>
                                            <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                <button onclick="get_stock_history('{{ $stock->id }}')"
                                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" fill="currentColor" class="mr-1 h-5 w-5"
                                                        viewBox="0 0 18 18">
                                                        <path
                                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                        <path
                                                            d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                        <path
                                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                    </svg>
                                                    Stock History
                                                </button><br>
                                                <a href="{{ route('stock.edit', $stock->id) }}"
                                                    class="mt-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
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
                                                </a>
                                                <form action="{{ route('stock.destroy', $stock->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                    style="margin:0">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token"
                                                        value="{{ csrf_token() }}">

                                                    <button type="submit"
                                                        class="mt-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                        <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
            id="add-stock-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Add New Stock Level
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-stock-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('stock.index') }}" method="POST" enctype="multipart/form-data">

                        <div class="p-6">
                            @csrf
                            <div class="grid grid-cols-6 gap-6">

                                <input type="hidden" name="products_id" value="{{ $product->id }}" />

                            </div>
                            <div class="grid grid-cols-6 gap-6 mt-2">
                                <!-- <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="text-sm font-medium text-gray-900 block mb-2">Price</label>
                                    <input type="number" name="price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Price" value="{{ old('price') }}" required="">

                                </div>-->
                                <div class="col-span-full">
                                    <label class="block text-sm font-medium text-gray-700" for="store">
                                        Store
                                    </label>
                                    <select name="store" id="store"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Store" value="{{ old('store') }}">
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if (count($variations) > 0 && collect($variations)->sum(fn($v) => count($v->variation_value)) > 0)
                                    <div class="col-span-full">
                                        <label class="block text-sm font-medium text-gray-700" for="store">
                                            Product Variation
                                        </label>
                                        <select name="variation" id="variation"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Variation" value="{{ old('variation') }}">
                                            @foreach ($variations as $variation)
                                                @if (count($variation->variation_value) > 0)
                                                    <option value="{{ $variation->id }}">
                                                        {{ $variation->variation_value_text }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="quantity_stock"
                                        class="text-sm font-medium text-gray-900 block mb-2">Stock Quantity</label>
                                    <input type="number" name="quantity_stock" id="quantity_stock"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                        value="{{ old('quantity_stock') }}" placeholder="Stock Quantity">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="date_received"
                                        class="text-sm font-medium text-gray-900 block mb-2">Date Stock
                                        Received</label>
                                    <div class="relative">
                                        <div
                                            class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input name="date_received" id="date_received" datepicker datepicker-autohide
                                            datepicker-format="dd/mm/yyyy" type="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            value="{{ old('date_received', now()->format('d/m/Y')) }}"
                                            placeholder="Date Stock Received">

                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="barcode_value"
                                        class="text-sm font-medium text-gray-900 block mb-2">SKU</label>
                                    <input type="text" name="sku" id="sku"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                        value="{{ old('sku') }}" placeholder="SKU">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="barcode_value"
                                        class="text-sm font-medium text-gray-900 block mb-2">Barcode Value</label>
                                    <input type="text" name="barcode_value" id="barcode_value"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                        value="{{ old('barcode_value') }}" placeholder="Barcode Value">
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="slideover-container" class="w-full h-full fixed inset-0 invisible" style="padding-top: 5rem;">
            <div onclick="toggleSlideover()" id="slideover-bg"
                class="w-full h-full duration-500 ease-out transition-all inset-0 absolute bg-gray-900 opacity-0">
            </div>
            <div onclick="toggleSlideover()" id="slideover"
                class="w-96 bg-white h-full absolute right-0 duration-300 ease-out transition-all translate-x-full">
                <div
                    class="absolute cursor-pointer text-gray-600 top-0 w-8 h-8 flex items-center justify-center right-0 mr-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="pl-4 max-h-full overflow-y-auto" style="max-height: calc(100vh - 5rem);">
                    <h1 class="text-md sm:text-2xl p-2 font-semibold text-gray-900">Stock History</h1>
                    <div class="">
                        <div class="mt-2 p-2" id="chartreport">
                            <canvas id="myStockChart" class="animated fadeIn"></canvas>
                        </div>
                        <div class="mt-2 p-2">
                            <ol id="stock_timeline" class="relative border-l border-gray-200 dark:border-gray-700">
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleSlideover() {
        document.getElementById('slideover-container').classList.toggle('invisible');
        document.getElementById('slideover-bg').classList.toggle('opacity-0');
        document.getElementById('slideover-bg').classList.toggle('opacity-50');
        document.getElementById('slideover').classList.toggle('translate-x-full');
    }
</script>
<script>
    function get_stock_history(stock_id) {
        var url = "{{ url('stock_history_per_id_stock') }}/" + stock_id;
        var labels = [];
        var datasets = [];
        toggleSlideover();
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                html = "";
                template = "";
                $.each(data, function(i, item) {
                    labels.push(item.normal_date_time);
                    datasets.push(item.quantity_current);

                    var template_order = ``;
                    var label_qty = `Quantity`;
                    /// if is order
                    if (item.type_history == "Deduct Stock") {
                        template_order = `
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            Sale : <a href="detail-sale/${item.sales_id}" class="text-blue-500 underline hover:text-blue-700">Sale ID#${item.sales_id}</a>
                        </p>`;
                        label_qty = `Quantity Sold`;
                    }
                    if (item.type_history == "Update Stock") {
                        label_qty = `Quantity Updated`;
                    }

                    /// create timeline
                    template = `<li class="mb-4 ml-4">
                                    <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">${item.normal_date_time}</time>
                                    <h3 class="text-lg font-semibold text-gray-900">${item.type_history}</h3>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                        ${label_qty} : ${item.quantity}
                                    </p>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                        Current Stock : ${item.quantity_current}
                                    </p>
                                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                        Previous Stock : ${item.quantity_previous}
                                    </p>
                                    ${template_order}
                                </li>`;

                    html = html + template;
                });

                /// remove if there is an existing chart
                $("canvas#myStockChart").remove();
                $("div#chartreport").append('<canvas id="myStockChart" class="animated fadeIn"></canvas>');

                /// create new chart
                const ctx = document.getElementById('myStockChart');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels.reverse(),
                        datasets: [{
                            label: ' Stock Qty',
                            data: datasets.reverse(),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                /// build html template
                $("#stock_timeline").html(html);
            }
        });
    }
</script>
