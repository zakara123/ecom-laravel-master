<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Stock Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Stock Settings</h1>
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
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
            <div class="mb-1 w-full">
                <div>
                    <form method="POST" action="{{ route('update-stock-online-product') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="display_online_shop_product" class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" value="" id="display_online_shop_product" name="display_online_shop_product" onChange="this.form.submit()" @if(isset($stock_required_online_shop->value) && $stock_required_online_shop->value == "yes") checked @endif class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <br>
                            <span class="ml-3 text-sm font-medium text-gray-900">Product in stock required to display product on online shop.</span>
                        </label>
                    </form>
                </div>
                <div>
                    <form method="POST" action="{{ route('update-enable-stock-api') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="online_stock_api" class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" value="" id="online_stock_api" name="online_stock_api" onChange="this.form.submit()" @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes") checked @endif class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <br>
                            <span class="ml-3 text-sm font-medium text-gray-900">Get product stock from API</span>
                        </label>
                        <svg data-modal-toggle="setting-modal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display: inline;margin-top: -1.5%;" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 w-6 h-6 text-gray-500 hover:text-gray-700 cursor-pointer flex-shrink-0 group-hover:text-gray-900 transition duration-75">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </form>
                </div>
                <div>
                    <form method="POST" action="{{ route('updateImageRequiredOnlineShop') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="image_required_for_product_onlineshop" class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" value="" id="image_required_for_product_onlineshop" name="image_required_for_product_onlineshop" onChange="this.form.submit()" @if(isset($image_required_for_product_onlineshop->value) && $image_required_for_product_onlineshop->value == "yes") checked @endif class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <br>
                            <span class="ml-3 text-sm font-medium text-gray-900">Product image required to display product on online shop</span>
                        </label>
                    </form>
                </div>
                <div>
                    <form method="POST" action="{{ route('updateEnableFilteringOnlineShop') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="filtered_required_for_product_onlineshop" class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" value="" id="filtered_required_for_product_onlineshop" name="filtered_required_for_product_onlineshop" onChange="this.form.submit()" @if(isset($filtering->value) && $filtering->value == "yes") checked @endif class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <br>
                            <span class="ml-3 text-sm font-medium text-gray-900">Display product filter on online shop</span>
                        </label>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
            <form action="{{route('updateShopMeta')}}" class="w-full" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-1 w-full">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-shrink-0">
                            <span class="text-xl sm:text-xl leading-none font-bold text-gray-900">Store</span>
                        </div>
                    </div>
                    <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="store_name_meta">
                            Store Name
                        </label>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" name="store_name_meta" placeholder="Store Name" value="@if(isset($shop_name->key)){{$shop_name->value}}@endif" required>
                    </div>
                    <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="store_description_meta">
                            Store Description
                        </label>
                        <textarea id="store_description_meta" name="store_description_meta" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Store Description">@if(isset($shop_description->key)){{$shop_description->value}}@endif</textarea>
                    </div>

                    <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="store_favicon">
                            Store Favicon
                        </label>
                        <input type="file" accept="image/*" name="store_favicon" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" id="store_favicon">

                        @if(isset($store_favicon->key))
                            <div class="w-48 pr-4">
                                <div class=" card tex-white bg-secondary mb-3">
                                    <div class="card-bod">
                                        <img src="{{ $store_favicon->value }}" class="card-img-top" alt="{{ $store_favicon->key }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="store_favicon">
                            Themes
                        </label>
                        
                        <select name="store_theme" id="store_theme" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($themes as $key => $theme)
                                <option value="{{ $key }}" @if($settings?->where('key', 'store_theme')->value('value') == $key) selected @endif>{{ $theme }}</option>
                            @endforeach
                        </select>
                            
                        
                    </div>
                    <div class="flex items-center pr-4 justify-end mt-4">
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-4 w-full block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
            <div class="mb-1 w-full">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="{{route('updatePrivacyPolicy')}}" method="POST">
                        @csrf
                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                            <label class="block mb-2 text-xl font-medium text-gray-900" for="privacy_policy">
                                Privacy Policy
                            </label>
                            <textarea id="privacy_policy" name="privacy_policy" rows="4" class="editor block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Privacy Policy">@if(isset($privacy_policy->key)){{$privacy_policy->value}}@endif</textarea>
                        </div>
                        <div class="flex items-center pr-4 justify-end mt-4">
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4 w-full block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
            <div class="mb-1 w-full">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="{{route('updateTermsConditions')}}" method="POST">
                        @csrf
                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                            <label class="block mb-2 text-xl font-medium text-gray-900" for="terms_conditions">
                                Terms and Conditions
                            </label>
                            <textarea id="terms_conditions" name="terms_conditions" rows="4" class="editor block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Terms and Conditions">@if(isset($terms_conditions->key)){{$terms_conditions->value}}@endif</textarea>
                        </div>
                        <div class="flex items-center pr-4 justify-end mt-4">
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4 w-full block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
            <div class="mb-1 w-full">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="{{route('updateReturnPolicy')}}" method="POST">
                        @csrf
                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                            <label class="block mb-2 text-xl font-medium text-gray-900" for="return_policy">
                                Return Policy
                            </label>
                            <textarea id="return_policy" name="return_policy" rows="4" class="editor block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Return Policy">@if(isset($return_policy->key)){{$return_policy->value}}@endif</textarea>
                        </div>
                        <div class="flex items-center pr-4 justify-end mt-4">
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4 w-full block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
            <div class="mb-1 w-full">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="{{route('updateCodeStickyHeader')}}" method="POST">
                        @csrf
                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                            <label class="block mb-2 text-xl font-medium text-gray-900" for="code_added_header">
                             Sticky Banner for All Pages. Front Side Only
                            </label>
                            <textarea id="sticky_banner_header" name="sticky_banner_header" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Code Added to Header">@if(isset($sticky_banner_header->key)){{$sticky_banner_header->value}}@endif</textarea>
                        </div>
                        <div class="flex items-center pr-4 justify-end mt-4">
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4 w-full block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
            <div class="mb-1 w-full">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="{{route('updateCodeAddedHeader')}}" method="POST">
                        @csrf
                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                            <label class="block mb-2 text-xl font-medium text-gray-900" for="code_added_header">
                                Code Added to Header of All Pages. Front Side Only
                            </label>
                            <textarea id="code_added_header" name="code_added_header" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Code Added to Header">@if(isset($code_added_header->key)){{$code_added_header->value}}@endif</textarea>
                        </div>
                        <div class="flex items-center pr-4 justify-end mt-4">
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--<div class="grid grid-cols-2">
            <div class="p-4 block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
                <div class="mb-1 w-full">

                    <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                        <form class="sm:pr-3 mb-4 sm:mb-0" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="mt-1 relative sm:w-64 xl:w-96">
                                <input type="text" name="email" id="products-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Search for stock">
                            </div>
                        </form>
                    </div>
                </div>
            </div>--}}
            <div class="p-4 block grid grid-cols-2 sm:flex items-center justify-between border-b border-gray-200">
                <div class="mb-1 w-full">
                    <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Setting</span>
                            </div>
                        </div>
                        <div class="font-sans antialiased">
                            @if(!empty($product_settings) <= 0)
                                <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
                                <div class="w-full overflow-hidden bg-white">
                                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                                        <form method="POST" action="{{ route('product-setting-add-update',0) }}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="w-full">
                                                <!-- Name Value -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900" for="company_name">
                                                        Product per page
                                                    </label>

                                                    <input  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="hidden" name="name" placeholder="Name" value="product_per_page">
                                                    <input  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="hidden" name="id" placeholder="Id" value="0">
                                                    <input required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" name="value" placeholder="Product per page">
                                                    @error('value')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                @else
                                <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">

                                    <div class="w-full overflow-hidden bg-white">

                                        <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                                            <form method="POST" action="{{ route('product-setting-add-update') }}" enctype="multipart/form-data">
                                                @csrf

                                                <div class="w-full">
                                                    <!-- Name Value -->
                                                    <div class="mb-6 relative z-0 mb-6 w-full group">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900" for="company_name">
                                                            Product per page
                                                        </label>

                                                        <input  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="hidden" name="name" placeholder="Name" value="product_per_page">
                                                        <input  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="hidden" name="id" placeholder="Id" value="{{ $product_settings->id }}">
                                                        <input required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" name="value" placeholder="Product per page" value="{{old('value',$product_settings->value)}}">
                                                        @error('value')
                                                        <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-end mt-4">
                                                    <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Item ID
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Item Name
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Name
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Store
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Current Stock
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Barcode
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($stock->stock))
                                    @foreach($stock->stock as $item)
                                    <tr>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">@if(isset($product->id)) {{$product->id}} @endif</td>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">@if(isset($product->name)) {{$product->name}} @endif</td>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">{{$stock->name}}</td>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">{{$item->location}}</td>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">{{$item->qty}}</td>
                                        <td class="p-4 whitespace-nowrap text-center  font-medium text-gray-900">{{$stock->upc}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="setting-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Stock API Settings
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="setting-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{route('onlinestockapi.index')}}" method="POST" enctype="multipart/form-data">

                        <div class="p-6">
                            @csrf
                            <div class="grid grid-cols-6 gap-6 mt-2">
                                @if(isset($online_stock_api->id))
                                <input type="hidden" name="id" value="{{$online_stock_api->id}}">
                                @endif
                                <div class="col-span-full">
                                    <label for="api_url" class="text-sm font-medium text-gray-900 block mb-2">API Url</label>
                                    <input type="text" name="api_url" id="api_url" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="API URL" value="@if(isset($online_stock_api->api_url)){{old('api_url',$online_stock_api->api_url)}}@else{{old('api_url')}}@endif" required="">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="text-sm font-medium text-gray-900 block mb-2">Username</label>
                                    <input type="text" name="username" id="username" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="@if(isset($online_stock_api->username)){{old('username',$online_stock_api->username)}}@else{{old('username')}}@endif" placeholder="Username" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Password</label>
                                    <input type="text" name="password" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="@if(isset($online_stock_api->password)){{old('password',$online_stock_api->password)}}@else{{old('password')}}@endif" placeholder="Password" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="barcode" class="text-sm font-medium text-gray-900 block mb-2">Barcode (upc)</label>
                                    <input type="text" name="barcode" id="barcode" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Barcode (upc)" value="{{old('barcode')}}">
                                </div>
                                {{--<div class="col-span-6 sm:col-span-3">
                                    <label for="test" class="text-sm font-medium text-gray-900 block mb-2">&nbsp;</label>
                                    <button type="submit" name="test" value="test" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Test</button>
                                </div>--}}
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-200 rounded-b">
                            <button type="submit" name="save" value="save"  class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>

<script>
tinymce.init({

        selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'table lists link image', // Add the image plugin
        toolbar: 'undo redo | blocks | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | code | table | link image', // Add the image button to the toolbar
        default_link_target: '_blank',
        promotion:false,
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '{{ route('upload.image') }}',
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        license_key: 'gpl'
    });

</script>
