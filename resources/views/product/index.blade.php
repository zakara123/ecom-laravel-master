<link href="{{url('dist/jquery.dataTables.min.css')}}" rel="stylesheet">
<style>
    .dataTables_length {
        display: none;
    }

    .dataTables_info {
        display: none;
    }

    #stock_api_filter, #stock_database_filter {
        float: left;
    }
    .stock_api_filterSelect{
        max-width: 40%!important;
        float: right;
        margin-right: 1%;
      }
</style>
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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                  aria-current="page">Item</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="grid grid-cols-2 gap-2">
                <div class="w-full">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                        Displaying all <span id="total_displayd">{{$products->total()}}</span> items
                    </h1>
                </div>
                <div class="w-full flex gap-4">
                    <a href="{{ route('item.create')}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add Item
                    </a>
                    <a href="{{ route('export-item')}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Export Item Excel
                    </a>
                    <a href="{{ route('import-item-view') }}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Import Item
                    </a>
                    <a href="{{ route('import-item-image-view') }}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Import Item Images
                    </a>
                    <div>
                        <form action="{{ route('empty_item') }}" method="POST"
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
                                Empty Table
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </x-slot>
    <div class="mx-1 my-4 w-full">
        @if (session()->has('message'))
            <div class="p-2 rounded bg-green-500 text-green-100 my-2" id="message_product">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">

            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">

                <div class="mt-1 w-full relative flex gap-2">
                    <div class="flex justify-center">
                        <div class="mb-3 flex">
                            <form class="sm:pr-3 mb-4 sm:mb-0" id="form_search" action="javascript:void(0)"
                                  data-action="{{ route('search-products') }}" method="GET">
                                <div class="flex items-center gap-2">
                                    <div class="input-group relative flex flex-wrap items-stretch w-full">
                                        <input id="search_input" type="text" name="s" onkeyup="searchItem();"
                                               onchange="searchItem();" value="{{ $ss }}"
                                               class="form-control relative flex-auto min-w-0 block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-cyan-600 focus:outline-none"
                                               placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                    </div>

                                </div>
                            </form>
                            <div class="input-group relative flex flex-nowrap items-stretch w-full">
                                <form action="{{ route('export-item-param-image') }}" enctype="multipart/form-data" class="flex gap-3 items-center">
                                    @csrf

                                    <div class=" ml-4 w-full text-sm font-medium text-gray-900 ">
                                        Product Image :
                                    </div>
                                    <select id="filter_image" name="filter_image" onchange="searchItem();" required
                                            class="shadow-sm bg-gray-50 border mr-4 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600">
                                        <option value="all">All</option>
                                        <option value="Product with image" @if($fs == 'Product with image') selected @endif> Product with image</option>
                                        <option value="Product without image" @if($fs == 'Product without image') selected @endif> Product without image</option>
                                    </select>
                                    <button type="submit"
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                        Export
                                    </button>
                                </form>
                            </div>
                            <div class="input-group relative flex flex-nowrap items-stretch w-full">
                                <form action="#" enctype="multipart/form-data" class="flex gap-3 items-center">
                                    @csrf

                                    <div class=" ml-4 w-full text-sm font-medium text-gray-900 ">
                                       Category :
                                    </div>
                                    <select id="filter_category" name="filter_category" onchange="searchItem();" required
                                            class="shadow-sm bg-gray-50 border mr-4 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600">
                                        <option value="all">All</option>
                                        <option value="0">Uncategorized</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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

                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col relative" id="item_field">
        <div class="bg-gray-100">
            <div class="align-middle inline-block relative bg-gray-100 overflow-x-auto max-w-full">
                <div class="shadow" id="over_flowing">
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="sortby p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'id')selected @endif" data-sortby="id" data-orderby="@if($sb == 'id' && $ob == 'ASC')DESC @elseif($sb == 'id' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'id');">
                                Item ID
                            </th>
                            <th scope="col" class="sortby p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'position' )selected @endif" data-sortby="position"  data-orderby="@if($sb == 'position' && $ob == 'ASC')DESC @elseif($sb == 'position' && $ob == 'DESC')ASC @else ASC @endif"  onclick="sortItem(this,'position');">
                                Position
                            </th>
                            <th scope="col" class="sortby p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'name' )selected @endif" data-sortby="name" data-orderby="@if($sb == 'name' && $ob == 'ASC')DESC @elseif($sb == 'name' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'name');">
                                Name
                            </th>
                            <th scope="col" class="sortby p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'price' )selected @endif" data-sortby="price" data-orderby="@if($sb == 'price' && $ob == 'ASC')DESC @elseif($sb == 'price' && $ob == 'DESC')ASC @else ASC @endif"  onclick="sortItem(this,'price');">
                                Selling Price
                            </th>
                            <th scope="col" class="sortby p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'price_buying' )selected @endif" data-sortby="price_buying"  data-orderby="@if($sb == 'price_buying' && $ob == 'ASC')DESC @elseif($sb == 'price_buying' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'price_buying');">
                                Buying Price
                            </th>
                            <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                Category
                            </th>
                            <!-- <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                Supplier
                            </th> -->
                            <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                Created_At
                            </th>
                            <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                View Image
                            </th>
                            <th scope="col" class="p-4 w-40 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    <a href="{{ route('item.edit', $product->id) }}" class="no-underline hover:underline">
                                        {{ $product->id }}
                                    </a>
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $product->position }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                  <a href="{{ route('item.edit', $product->id) }}" class="hover:underline" >{{ $product->name }}</a>
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ number_format($product->price,2,".",",") }} @if(!empty($product->unit_selling_label))
                                        / {{$product->unit_selling_label}} @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ number_format($product->price_buying,2,".",",") }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if(count($product->categoryproduct) > 0)
                                        @foreach ($product->categoryproduct as $category)
                                            @if ($loop->last)
                                                {{ $category->category_name }}
                                            @else
                                                {{ $category->category_name }},
                                            @endif
                                        @endforeach
                                    @else
                                        {{ __('Uncategorized') }}
                                    @endif
                                </td>
                                <!-- <td class="p-4  text-center font-medium text-gray-900">
                                    @if(isset($product->supplier))
                                        {{ $product->supplier }}
                                    @endif
                                </td> -->
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($product->created_at)) }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if(isset($product->product_image) && !empty($product->product_image))
                                        <div class="w-20 ml-4 mb-2">
                                            <img class="h-auto" src="{{$product->product_image->src}}" alt="">
                                        </div>
                                    @endif
                                    <a href="/item-images/{{ $product->id }}"> Show</a>
                                </td>
                                <td class="p-4  space-x-2">
                                    <a href="{{ route('item.edit', $product->id) }}"
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
                                        Edit item
                                    </a>
                                    <button onclick="get_stock('{{ $product->id }}','stock')"
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        Stock
                                    </button>
                                    <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        Show
                                    </a>
                                    <form action="{{ route('item.destroy',$product->id) }}" method="POST"
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
                                            Delete Item
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-md-12">

                            {{ $products->links('pagination::tailwind') }}

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="slideover-container" class="w-full h-full fixed inset-0 invisible" style="padding-top: 5rem;">
        <div id="slideover-bg" class="w-full h-full duration-500 ease-out transition-all inset-0 absolute bg-gray-900">
            <div style="margin-top: 13vh;" class="h-2 w-full">
                <div class="flex">
                    <div id="div_previous" class="cursor-pointer text-white mr-2" style="margin-left: 55%;">Previous
                    </div>
                    <div class="text-white">|</div>
                    <div id="div_next" class="cursor-pointer text-white ml-2">Next</div>
                </div>
            </div>
            <div onclick="toggleSlideover()" class="cursor-pointer">
                <img id="product_image_cover_loading" style="margin-top: 20vh;margin-left: 38%;"
                     class="w-2/12 h-auto m-auto " src="" alt="IMAGE HERE"/>
                <img id="product_image_cover" style="margin-top: 5vh;margin-left: 26%;" class="w-1/3 h-auto m-auto "
                     src="" alt="IMAGE HERE"/>
            </div>
            <div onclick="toggleSlideover()" class="cursor-pointer h-10" id="div_no_image"
                 style="margin-top:36vh;text-align:center">
                <label class="text-center mt-2 text-white" for="product_not_have_image">Item has no image.</label>
            </div>
        </div>
        <div id="slideover" style="width:35%"
             class="bg-white h-full absolute right-0 duration-300 ease-out transition-all translate-x-full">
            <div
                class="absolute cursor-pointer text-gray-600 top-0 w-8 h-8 flex items-center justify-center right-0 mr-5">
                <svg onclick="toggleSlideover()" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="pl-4 max-h-full overflow-y-auto" style="max-height: calc(100vh - 5rem);">
                <h1 id="title_stock" style="max-width:85%" class="text-md mb-6 font-bold mt-2 text-gray-900">Stock</h1>
                <div class="">
                @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")
                <h5 class="font-bold">Stock API</h5>
                    <div class="mt-2">
                        <table id="stock_api"
                               class="w-full mt-4 text-sm text-center text-gray-900 display table table-striped table-bordered dt-responsive">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Variation
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Store
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Stock
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <h5 class="font-bold mt-4">Stock Database</h5>
                    <div class="mt-2">
                        <table id="stock_database"
                               class="w-full mt-4 text-sm text-center text-gray-900 display table table-striped table-bordered dt-responsive">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Variation
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Store
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Stock
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="{{url('dist/jquery.dataTables.min.js')}}"></script>
<script src="{{url('dist/filterDropDown.js')}}"></script>

<script type="text/javascript">
    @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")
        var stock_api;
    @endif
    var stock_database;

    function searchItem(page) {
        var form = $('#form_search');
        var actionUrl = form.data('action');
        var search = $('#search_input').val();
        var filter_category = $('#filter_category').val();
        var filter_image = $('#filter_image').val();
        var page_url = '?s=' + search + '&fs=' + filter_image+ '&category=' + filter_category;
        setTimeout(function () {
            $.ajax({
                type: "GET",
                url: actionUrl + page_url,
                beforeSend: function () {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function (data) {
                    $('#item_field').html(data);
                    let total_p = $('#total_p').val();
                    $('#total_displayd').html(total_p);
                    // show response from the php script.
                }, error: function () {
                    console.log('Error');
                },
                complete: function () {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        }, 500);
    }

    function sortItem(element,id_sort) {
        $('.sortby').removeClass('selected');
        $(element).addClass('selected');
        var form = $('#form_search');
        var actionUrl = form.data('action');
        var search = $('#search_input').val();
        var filter_image = $('#filter_image').val();
        var filter_category = $('#filter_category').val();
        var orderby = $('.sortby.selected').data('orderby');
        var page_url = '?s=' + search + '&fs=' + filter_image  + '&category=' + filter_category +'&sortby=' + id_sort + '&orderby=' + orderby;
        setTimeout(function () {
            $.ajax({
                type: "GET",
                url: actionUrl + page_url,
                beforeSend: function () {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function (data) {
                    $('#item_field').html(data);
                    let total_p = $('#total_p').val();
                    $('#total_displayd').html(total_p);
                    // show response from the php script.
                }, error: function () {
                    console.log('Error');
                },
                complete: function () {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        }, 500);
    }

    $(document).ready(function () {



        $('.search_pagination .pagination li a').click(function (e) {
            e.preventDefault();
            var actionUrl = $(this).attr('href');
            // var page_url = '&s=' + $('#search_input').val();
            var filter_image = $('#filter_image').val();
            var filter_category = $('#filter_category').val();
            var sortby = $('.sortby.selected').data('sortby');
            var orderby = $('.sortby.selected').data('orderby');
            var page_url = '&s=' + $('#search_input').val() +'&fs=' + filter_image +'&category=' + filter_category;
            $.ajax({
                type: "GET",
                url: actionUrl + page_url,// serializes the form's elements.
                beforeSend: function () {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function (data) {
                    $('#item_field').html(data);
                    let total_p = $('#total_p').val();
                    $('#total_displayd').html(total_p);
                }, error: function () {
                    console.log('Error');
                },
                complete: function () {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        });

        /// create datatabale
        @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")
        stock_api = $('#stock_api').DataTable({
            "language": {search: '', searchPlaceholder: "Search..."},
            "pageLength": 6,
            "createdRow": function (row, data, index) {
                if (data[2] < 0) $(row).css("background-color", "rgb(248 113 113)");
            },
            filterDropDown: {
            columns: [
                    {
                        idx: 1,
                        title: "Store"
                    }
                ],
            bootstrap: false
            }
        });
        @endif
        stock_database = $('#stock_database').DataTable({
            "language": {search: '', searchPlaceholder: "Search..."},
            "pageLength": 6,
            "createdRow": function (row, data, index) {
                if (data[2] < 0) $(row).css("background-color", "rgb(248 113 113)");
            }
        });

    });
</script>
<script>
    function toggleSlideover() {
        document.getElementById('slideover-container').classList.toggle('invisible');
        document.getElementById('slideover').classList.toggle('translate-x-full');
    }

</script>
<script type="text/javascript">
    function get_stock(id, target = "stock") {
        var url = "{{ url('ws_stock') }}/" + id;
        $("#product_image_cover").hide();
        $("#product_image_cover_loading").show();
        $("#product_image_cover_loading").attr("src", "/img/loading1.gif");
        $('#slideover-bg').addClass('opacity-50');
        $('#title_stock').html("Stock");
        $("#div_no_image").hide();
        stock_database.clear().draw();
        @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")
            stock_api.clear().draw();
        @endif
        if (target == "stock") {
            toggleSlideover();
        }
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json', // added data type
            success: function (data) {

                $('#title_stock').html("Stock of " + data.products.name);

                $.each(data.stocks, function (i, item) {

                    var variation = "(No Variation)";
                    if (item.product_variation_id != null) variation = item.variation_value;
                    /* template = `
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                            ${variation}
                        </td>
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                            ${item.name}
                        </td>
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                            ${item.quantity_stock}
                        </td>
                    </tr>
                    `; */

                    stock_database.row.add([
                        variation,
                        item.name,
                        item.quantity_stock
                    ]).draw();
                });
                    $('#stock_api_filterSelect1 option:gt(0)').remove();

                var sort = [];
                $.each(data.api, function (i, item) {
                    var size = "";
                    if (item.size != "") size = "Size:  " + item.size + ", ";
                    /* template1 = `
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                           ${size} Color: ${item.color}
                        </td>
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                            ${item.location}
                        </td>
                        <td scope="row" class="py-4 text-center px-6 font-medium text-gray-900 ">
                            ${item.qty}
                        </td>
                    </tr>
                    `;
                    html1 = html1 + template1; */
                    @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")
                        stock_api.row.add([
                            size + "Color: " + item.color,
                            item.location,
                            item.qty
                        ]).draw();
                        sort.push(item.location);
                    @endif
                });

                function onlyUnique(value, index, array) {
                    return array.indexOf(value) === index;
                }
                sort = sort.filter(onlyUnique);
                for(i=0; i<sort.length; i++){
                    $('#stock_api_filterSelect1').append($("<option></option>")
                                                     .attr("value",sort[i])
                                                     .text(sort[i]));
                }
                if (data.image_cover == "") {
                    $("#div_no_image").show();
                    $("#product_image_cover").hide();
                    $("#product_image_cover").attr("src", "");
                } else {
                    $('#slideover-bg').removeClass('opacity-50');
                    $("#product_image_cover").show();
                    $("#product_image_cover").attr("src", data.image_cover);
                }
                $("#product_image_cover_loading").hide();

                /// add preview + next
                if (data.preview != "") {
                    $("#div_previous").show();
                    $("#div_previous").attr("onclick", "get_stock('" + data.preview + "','preview')");
                } else {
                    $("#div_previous").hide();
                }
                /// add preview + next
                if (data.next != "") {
                    $("#div_next").show();
                    $("#div_next").attr("onclick", "get_stock('" + data.next + "','next')");
                } else {
                    $("#div_next").hide();
                }

            }
        });
    }
</script>
