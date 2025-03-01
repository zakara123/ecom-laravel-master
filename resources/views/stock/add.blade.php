<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    @if(Session::has('selected_product'))
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('item.edit', Session::get('selected_product')->id) }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">{{ Session::get('selected_product')->name }}</a>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Add New Stock Level</span>
                        </div>
                    </li>

                </ol>
            </nav>
        </div>
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0">
            @if(Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <span class="font-medium">Success : </span> {{ Session::get('success')}}
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
            </div>
            @endif

            @foreach ($errors->all() as $error)
            <span class="text-red-600 text-sm">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ $error }}
                </div>
            </span>
            @endforeach
        </div>
        <div class="font-sans antialiased">
            <div class="flex-col items-center mt-2 min-h-screen bg-gray-100 sm:justify-center sm:pt-0">

                <div class="w-full overflow-hidden bg-white">

                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form action="{{ route('stock.add_stock_sheet') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-full">
                                    <label class="block text-sm font-medium text-gray-700" for="store">
                                        Product
                                    </label>
                                    <select name="product" id="product" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Product" value="{{old('product')}}" required>
                                        <option value="">Select a product</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @if($product->id == old('product')) selected @endif>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error_message_product" class="text-red-600 ml-2 hidden">Product field is required</small>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-6 mt-2">
                                <div class="col-span-full">
                                    <label class="block text-sm font-medium text-gray-700" for="store">
                                        Store
                                    </label>
                                    <select name="store" id="store" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Role" value="{{old('store')}}">
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}" @if($store->id == old('store')) selected @endif >{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                    @if(Session::has('variations'))
                                <div class="col-span-full">
                                    <label class="block text-sm font-medium text-gray-700" for="store">
                                        Product Variation
                                    </label>
                                    <select name="variation" id="variation" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Role" value="{{old('variation')}}">
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach (Session::get('variations') as $variation)
                                        @if(count($variation->variation_value) == 0)
                                        <option value="" selected>( No Variation )</option>
                                        @php
                                        $i++;
                                        @endphp
                                        @else
                                        <option value="{{ $variation->id }}">
                                            @foreach ($variation->variation_value as $key=>$var)
                                            {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                            @if($key !== array_key_last($variation->variation_value))
                                            ,
                                            @endif
                                            @endforeach
                                        </option>
                                        @endif
                                        @endforeach
                                        @if($i === 0)
                                        <option value="" selected>( No Variation )</option>
                                        @endif
                                    </select>
                                </div>
                    @endif

                    <div class="grid grid-cols-6 gap-6 mt-2">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="quantity_stock" class="text-sm font-medium text-gray-900 block mb-2">Quantity Stock</label>
                                    <input type="number" name="quantity_stock" id="quantity_stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="{{old('quantity_stock')}}" placeholder="Quantity Stock" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="date_received" class="text-sm font-medium text-gray-900 block mb-2">Date Stock Received</label>
                                    <div class="relative">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input name="date_received" id="date_received" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" value="{{old('date_received')}}" placeholder="Date Stock Received">

                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="barcode_value" class="text-sm font-medium text-gray-900 block mb-2">Barcode Value</label>
                                    <input type="text" name="barcode_value" id="barcode_value" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="{{old('barcode_value')}}" placeholder="Barcode Value">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="barcode_value" class="text-sm font-medium text-gray-900 block mb-2">SKU</label>
                                    <input type="text" name="sku" id="sku" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="{{old('sku')}}" placeholder="SKU">
                                </div>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <button type="submit" name="add" value="add" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Add
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
    $("#product").change(function() {
        if($("#product").val() == ""){
            $("#error_message_product").show();
            $('#product').css('border',"solid 1px red");
        }else{
            $("#error_message_product").hide();
            $('#product').css('border',"");
            this.form.submit();
        }
    });
</script>
