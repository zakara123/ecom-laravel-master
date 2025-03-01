<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $store_name = \App\Models\Setting::where("key", "store_name_meta")->first();
    
@endphp
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
        <div class="flex flex-col relative" id="item_field">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product name
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product Variation
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    SKU
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Group
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Type
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Material
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Colour
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Size
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Barcode
                                </th>
                                
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Stock warehouse
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($product_sku as $ps)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                        {{ $ps->products_id }}
                                    </td>
                                    <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                        {{ $ps->product_name }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if(count($ps->variation_value) == 0)
                                            <i>( No Variation )</i>
                                        @else

                                            @foreach ($ps->variation_value as $key=>$var)
                                                {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                                @if($key !== array_key_last($ps->variation_value))
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->sku}}
                                    </td>

                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->group}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->type}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->material}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->colour}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->size}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->barcode}}
                                    </td>
                                    <td class="p-4 whitespace-nowrap font-medium text-gray-900">
                                        {{$ps->stock_warehouse}}
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
