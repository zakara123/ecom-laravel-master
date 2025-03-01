<!DOCTYPE html>
@php
    $store_name = \App\Models\Setting::where("key", "store_name_meta")->first();
    
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="Get started with a free and open source Tailwind CSS dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.79.0">
    <title>@isset($store_name->value) {{ $store_name->value }} @else {{ @@$company->company_name }} @endisset @if(trim($__env->yieldContent('pageTitle'))) | @yield('pageTitle') @endif</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('dist/app.css')}}">
    <link rel="stylesheet" href="{{url('dist/flowbite.min.css')}}" />
    <link rel="stylesheet" href="{{url('dist/flatpickr.min.css')}}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" cz-shortcut-listen="true">
<div class="flex overflow-hidden bg-white pt-16">
    <div class="overlay is-hidden"></div>
    <div class="mx-auto mt-2">
        <div class="mx-4 my-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Products</h1>
        </div>
        <div class="flex flex-col relative" id="item_field">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product ID > Stock ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product name
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Buying Price
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Selling Price
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Store
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Stock In
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Stock Out
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Description
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Previous Stock
                                </th>
                                
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Current Stock
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Stock Updated
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    SKU
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Barcode Value
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Barcode
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($stocks as $stock)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $stock->products_id }} > {{ $stock->id }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $stock->product_name }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ number_format($stock->price_buying,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ number_format($stock->price_selling,2,".",",") }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $stock->store }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if($stock->type == 'Stock Add')
                                            {{$stock->quantity}}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if($stock->type == 'Stock Take')
                                            {{abs($stock->quantity)}}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{$stock->stock_description}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{$stock->quantity_previous}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ $stock->quantity_stock }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if(!empty($stock->date_received)){{ date('d/m/Y', strtotime($stock->date_received)) }}@endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$stock->sku}}

                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$stock->barcode_image_value}}

                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
{{--                                        {!! $stock->barcode_image !!}--}}
                                        <img src="{{$stock->barcode_image_other}}" alt="">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
