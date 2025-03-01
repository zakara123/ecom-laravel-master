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
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Products Settings</h1>
        </div>
    </x-slot>
    <div class="mx-1 my-4 w-full">
        @if (session()->has('message'))
        <div class="p-2 rounded bg-green-500 text-green-100 my-2">
            {{ session('message') }}
        </div>
        @endif
    </div>

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
        <div class="p-4  bg-white block {{--sm:flex--}} items-center  hidden  justify-between border-b border-gray-200 lg:mt-1.5">
            <div class="mb-1 w-full">
                <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                    <div class="flex items-center sm:justify-end w-full">
                        <div class="hidden md:flex pl-2 space-x-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full p-4 grid grid-cols-1 gap-4">
            <div class="grid grid-cols-2">
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
</x-app-layout>

