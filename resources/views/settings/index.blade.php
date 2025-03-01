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
                                aria-current="page">Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Settings</h1>
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

            @if (Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    <span class="font-medium">Success : </span> {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
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
        <div
            class="p-4  bg-white block {{-- sm:flex --}} items-center  hidden  justify-between border-b border-gray-200 lg:mt-1.5">
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
            <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Stores</span>
                    </div>
                    <div class="flex-shrink-0">
                        <div class=" font-medium inline-flex items-center rounded-lg text-sm px-5 mx-4">
                            <label for="store-name"
                                class="block text-sm font-medium text-gray-700 dark:text-white pb-1 px-2"> Enable Online
                                Store: </label>
                            <form method="POST" action="{{ route('update-enable-online-shop') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="display_online_shop_product"
                                    class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="display_online_shop_product"
                                        name="display_online_shop_product" onChange="this.form.submit()"
                                        @if (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes') checked @endif class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <br>
                                </label>
                                <input type="hidden" name="id"
                                    value="@if (isset($enable_online_shop->id)) {{ $enable_online_shop->id }} @endif">
                            </form>
                        </div>

                        <a href="{{ route('stores.create') }}"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add Store
                        </a>
                    </div>
                </div>

                <div class="flex flex-col mt-8">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="align-middle inline-block min-w-full">
                            <div class="shadow overflow-hidden sm:rounded-lg">
                                <table class="table-fixed min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Store ID
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Store
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Allow Back Office Sales
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Pickup Location
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Tax
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($stores as $store)
                                            @php
                                                $i++;
                                            @endphp
                                            <tr class="hover:bg-gray-100">
                                                <td class="p-2  text-center font-medium text-gray-900">
                                                    {{ $store->id }}
                                                </td>
                                                <td class="p-2  text-center font-medium text-gray-900">
                                                    {{ $store->name }}
                                                    @if (strtolower($store->name) == 'warehouse')
                                                        <br>
                                                        <span class="text-xs">(By default, online and BO Sales stock
                                                            will be deducted from warehouse)</span>
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center font-medium text-gray-900">
                                                    <form method="POST"
                                                        action="{{ route('is-on-newsale-page', $store->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="is_on_newsale_page{{ $i }}"
                                                            class="inline-flex relative items-center cursor-pointer">
                                                            <input type="checkbox" value=""
                                                                @if ($store->is_on_newsale_page == 'yes') checked @endif
                                                                id="is_on_newsale_page{{ $i }}"
                                                                name="is_on_newsale_page" class="sr-only peer"
                                                                onChange="this.form.submit()">
                                                            <div
                                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                            </div>
                                                            <br>
                                                            <span class="ml-3 text-sm font-medium text-gray-900">
                                                                @if ($store->is_on_newsale_page == 'yes')
                                                                    Yes
                                                                @else
                                                                    No
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td class="p-2 text-center font-medium text-gray-900">
                                                    <form method="POST"
                                                        action="{{ route('update-pickup-location', $store->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="pickup_location{{ $i }}"
                                                            class="inline-flex relative items-center cursor-pointer">
                                                            <input type="checkbox" value=""
                                                                @if ($store->pickup_location == 'yes') checked @endif
                                                                id="pickup_location{{ $i }}"
                                                                name="pickup_location" class="sr-only peer"
                                                                onChange="this.form.submit()">
                                                            <div
                                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                            </div>
                                                            <br>
                                                            <span class="ml-3 text-sm font-medium text-gray-900">
                                                                @if ($store->pickup_location == 'yes')
                                                                    Yes
                                                                @else
                                                                    No
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </form>
                                                </td>

                                                <td class="p-2 text-center font-medium text-gray-900">
                                                    {{ $store->vat_type }}
                                                </td>
                                                <td class="p-2 space-x-2">
                                                    <a href="{{ route('stores.edit', $store->id) }}"
                                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 mb-1 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                        <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                            </path>
                                                            <path fill-rule="evenodd"
                                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Edit store
                                                    </a>
                                                    @if ($store->is_online == 'yes')
                                                    @else
                                                        @if ($store->is_default == 'no')
                                                            <form action="{{ route('stores.destroy', $store->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                                style="margin:0">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">

                                                                <button type="submit"
                                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                                    <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                                        viewBox="0 0 20 20"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd"
                                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    Delete Store
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">

                                    <div class="col-md-12">

                                        {{ $stores->links('pagination::tailwind') }}

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex-shrink-0">
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Company
                                Information</span>
                        </div>
                    </div>
                    <div class="font-sans antialiased">
                        @if (!empty($company) <= 0)
                            <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
                                <div class="w-full overflow-hidden bg-white">
                                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                                        <form method="POST" action="{{ route('create-company') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Company Name -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_name">
                                                        Company Name
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_name" placeholder="Company Name"
                                                        value="">
                                                    @error('company_name')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Address -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_address">
                                                        Address
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_address"
                                                        placeholder="Company Address" value="">
                                                    @error('company_address')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- BRN Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="brn_number">
                                                        BRN Number
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="brn_number" placeholder="BRN Number"
                                                        value="">
                                                    @error('brn_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- VAT Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="vat_number">
                                                        VAT Number
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="vat_number" placeholder="VAT Number"
                                                        value="">
                                                    @error('vat_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Company Email -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_email">
                                                        Company Email
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="email" name="company_email"
                                                        placeholder="Used on Invoices" value="">
                                                    @error('company_email')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Company Tan number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_tan">
                                                        TAN number
                                                    </label>

                                                    <input @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') required @endif
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="number" name="tan" placeholder="Used on ESB"
                                                        value="">
                                                    @error('tan')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Contact Phone -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_phone">
                                                        Contact Phone
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="tel" name="company_phone"
                                                        placeholder="Contact Phone" value="">
                                                    @error('company_phone')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Contact FAX -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_fax">
                                                        Contact FAX
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_fax" placeholder="Contact FAX"
                                                        value="">
                                                    @error('company_fax')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Whatsapp Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="whatsapp_number">
                                                        Whatsapp Number
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="tel" name="whatsapp_number"
                                                        placeholder="Whatsapp Number" value="">
                                                    @error('whatsapp_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Logo -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="item_image">
                                                        Company logo
                                                    </label>
                                                    <div class="flex justify-center items-center w-full">
                                                        <label for="dropzone-file"
                                                            class="flex flex-col justify-center items-center w-full h-15 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer">
                                                            <div
                                                                class="flex flex-col justify-center items-center pt-5 pb-6">
                                                                <svg aria-hidden="true"
                                                                    class="mb-3 w-10 h-10 text-gray-400"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                                    </path>
                                                                </svg>
                                                                <p class="mb-2 text-sm text-gray-500"><span
                                                                        class="font-semibold">Click to upload</span> or
                                                                    drag and drop</p>
                                                                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF
                                                                </p>
                                                            </div>
                                                            <input id="dropzone-file" type="file"
                                                                name="company_logo" accept="image/*"
                                                                class="hidden" />
                                                        </label>
                                                    </div>
                                                    @error('company_logo')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <label for="display_logo_in_pdf"
                                                    class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" value="" id="display_logo_in_pdf"
                                                        @if (isset($display_logo->value) && $display_logo->value == 'yes') checked @endif
                                                        name="display_logo_in_pdf" class="sr-only peer">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>

                                                    <br>
                                                    <span class="ml-3 text-sm font-medium text-gray-900">Display logo
                                                        in PDF documents</span>
                                                </label>
                                                <small id="success_message_display_logo_in_pdf"
                                                    class="text-green-600 ml-2 mb-2 hidden">Change saved
                                                    successfully!</small>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <button type="submit"
                                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
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
                                        <form method="POST" action="{{ route('update-company', $company->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Company Name -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_name">
                                                        Company Name
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_name" placeholder="Company Name"
                                                        value="{{ old('name', @$company->company_name) }}">
                                                    @error('company_name')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Address -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_address">
                                                        Address
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_address"
                                                        placeholder="company_address"
                                                        value="{{ old('company_address', $company->company_address) }}">
                                                    @error('company_address')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- BRN Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="brn_number">
                                                        BRN Number
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="brn_number" placeholder="BRN Number"
                                                        value="{{ old('brn_number', $company->brn_number) }}">
                                                    @error('brn_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- VAT Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="vat_number">
                                                        VAT Number
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="vat_number" placeholder="VAT Number"
                                                        value="{{ old('vat_number', $company->vat_number) }}">
                                                    @error('vat_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Company Email -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_email">
                                                        Company Email
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="email" name="company_email"
                                                        placeholder="Used on Invoices"
                                                        value="{{ old('company_email', $company->company_email) }}">
                                                    @error('company_email')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Company Tan number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_tan">
                                                        TAN number
                                                    </label>

                                                    <input @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') required @endif
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="number" name="tan" placeholder="Used on ESB"
                                                        value="{{ old('tan', $company->tan) }}">
                                                    @error('tan')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Contact Phone -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_phone">
                                                        Contact Phone
                                                    </label>

                                                    <input required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="tel" name="company_phone"
                                                        placeholder="Contact Phone"
                                                        value="{{ old('company_phone', $company->company_phone) }}">
                                                    @error('company_phone')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Contact FAX -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="company_fax">
                                                        Contact FAX
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="text" name="company_fax" placeholder="Contact FAX"
                                                        value="{{ old('company_fax', $company->company_fax) }}">
                                                    @error('company_fax')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="grid md:grid-cols-2 md:gap-6">
                                                <!-- Whatsapp Number -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="whatsapp_number">
                                                        Whatsapp Number
                                                    </label>

                                                    <input
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        type="tel" name="whatsapp_number"
                                                        placeholder="Whatsapp Number"
                                                        value="{{ old('whatsapp_number', $company->whatsapp_number) }}">
                                                    @error('whatsapp_number')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!-- Logo -->
                                                <div class="mb-6 relative z-0 mb-6 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="item_image">
                                                        Company logo
                                                    </label>
                                                    <div class="flex justify-center items-center w-full">
                                                        <label for="dropzone-file"
                                                            class="flex flex-col justify-center items-center w-full h-15 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer">
                                                            <div
                                                                class="flex flex-col justify-center items-center pt-5 pb-6">
                                                                <svg aria-hidden="true"
                                                                    class="mb-3 w-10 h-10 text-gray-400"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                                    </path>
                                                                </svg>
                                                                <p class="mb-2 text-sm text-gray-500"><span
                                                                        class="font-semibold">Click to upload</span> or
                                                                    drag and drop</p>
                                                                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF
                                                                </p>
                                                            </div>
                                                            <input id="dropzone-file" type="file"
                                                                name="company_logo" accept="image/*"
                                                                class="hidden" />
                                                        </label>
                                                    </div>
                                                    @error('company_logo')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="w-full">
                                                <label for="display_logo_in_pdf"
                                                    class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" value="" id="display_logo_in_pdf"
                                                        @if (isset($display_logo->value) && $display_logo->value == 'yes') checked @endif
                                                        name="display_logo_in_pdf" class="sr-only peer">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>

                                                    <br>
                                                    <span class="ml-3 text-sm font-medium text-gray-900">Display logo
                                                        in PDF documents</span>
                                                </label>
                                            </div>
                                            <small id="success_message_display_logo_in_pdf"
                                                class="text-green-600 ml-2 mb-2 hidden">Change saved
                                                successfully!</small>
                                            <div class="w-full">
                                                <div class=" card tex-white bg-secondary mb-3">
                                                    <div class="card-bod">
                                                        <img src="{{ @$company->logo }}"
                                                            class="card-img-top object-contain hover:object-scale-down  w-48"
                                                            alt="{{ @$company->company_name }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <button type="submit"
                                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
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
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 ml-2">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">EBS MRA Transaction
                                Setting</span>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                    <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="align-middle inline-block min-w-full">
                                <div class="shadow overflow-hidden sm:rounded-lg">
                                    <form method="POST" action="{{ route('mra-esb-setting') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- type Of Person -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_typeOfPerson">
                                                    Type Of Person
                                                </label>

                                                <select name="ebs_typeOfPerson" id="ebs_typeOfPerson" type="text"
                                                    required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Type Of person"
                                                    value="{{ old('ebs_typeOfPerson') }}">
                                                    <option value="NVTR"
                                                        @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') selected @elseif(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'VATR') selected @endif>
                                                        Non VAT Registered Person</option>
                                                    <option value="VATR"
                                                        @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'VATR') selected @endif>VAT
                                                        Registered Person</option>
                                                </select>
                                                @error('ebs_typeOfPerson')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                                <div id="vat_calculation"
                                                    @if (isset($ebs_typeOfPerson->value) && ($ebs_typeOfPerson->value == 'NVTR' || !$ebs_typeOfPerson->value)) class="hidden" @endif>
                                                    <label
                                                        class="block mb-2 mt-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                        for="vat_type">
                                                        VAT Calculation
                                                    </label>
                                                    <select name="vat_type" id="vat_type"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="VAT" value="{{ old('vat_type') }}"
                                                        vallue="{{ $ebs_vatType->value }}">
                                                        <option value="Added to the price"
                                                            @if (isset($ebs_vatType->value) && $ebs_vatType->value == 'Added to the price') selected isDefault @endif>
                                                            Added to the price</option>
                                                        <option value="Included in the price"
                                                            @if (isset($ebs_vatType->value) && $ebs_vatType->value == 'Included in the price') selected isDefault @endif>
                                                            Included in the price</option>
                                                        <option hidden class="hidden"
                                                            @if (
                                                                (isset($ebs_vatType->value) && $ebs_vatType->value == 'No VAT') ||
                                                                    (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR')) selected isDefault @endif
                                                            value="No VAT">No VAT</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <!-- VAT RAT -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_vat_rat">
                                                    <br>
                                                </label>
                                                <button type="button" data-modal-toggle="mra-vat_rat"
                                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 text-center sm:ml-auto">
                                                    VAT Rate Settings
                                                </button>
                                            </div>

                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- MRA E-Invoicing -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_mra_einvoincing">
                                                    MRA E-Invoicing
                                                </label>

                                                <select name="ebs_mra_einvoincing" type="text" required
                                                    id="ebs_mra_einvoincing"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="MRA E-Invoicing"
                                                    value="{{ old('ebs_mra_einvoincing') }}">
                                                    <option value="On"
                                                        @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') selected @endif>Active
                                                    </option>
                                                    <option value="Off"
                                                        @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'Off') selected @elseif(isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value != 'On') selected @endif>
                                                        Not Active</option>
                                                </select>
                                                @error('ebs_mra_einvoincing')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <!-- Invoice training -->
                                                <div id="invoince_training_block" class="relative z-0 w-full group">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900"
                                                        for="ebs_trainingmode">
                                                        Training Mode
                                                    </label>

                                                    <select name="ebs_trainingmode" type="text" required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="Training Mode"
                                                        value="{{ old('ebs_trainingmode') }}">
                                                        <option value="On"
                                                            @if (isset($ebs_trainingmode->value) && $ebs_trainingmode->value == 'On') selected @endif>Active
                                                        </option>
                                                        <option value="Off"
                                                            @if (isset($ebs_trainingmode->value) && $ebs_invoiceTypeDesc->value == 'Off') selected @elseif(isset($ebs_trainingmode->value) && $ebs_trainingmode->value != 'On') selected @endif>
                                                            Not Active</option>
                                                    </select>
                                                    @error('ebs_trainingmode')
                                                        <span class="text-red-600 text-sm">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Invoice Identifier -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_invoiceIdentifier">
                                                    Invoice Identifier
                                                </label>

                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="dategenerated_check">
                                                    <label class="form-check-label">
                                                        Date generated
                                                    </label>
                                                </div>

                                                <div class="form-check ml-2 mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="customtext_check">
                                                    <label class="form-check-label">
                                                        Custom text
                                                    </label>
                                                </div>

                                                <div id="todaydateforinvoice">
                                                    <small style="color: red">The date format will be yyyymmdd added as
                                                        prefix</small>
                                                    <input type="text" class=""
                                                        id="ebs_invoiceIdentifier_date" name="ebs_invoiceIdentifier"
                                                        value="Todaydate" hidden><br>

                                                </div>

                                                <input id="ebs_invoiceIdentifier"
                                                    @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') required @endif
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="ebs_invoiceIdentifier"
                                                    placeholder="Invoice Identifier"
                                                    value="{{ old('ebs_invoiceIdentifier', $ebs_invoiceIdentifier->value) }}">
                                                @error('ebs_invoiceIdentifier')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>



                                            <!-- Invoice Counter -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_invoiceCounter">
                                                    Invoice Counter
                                                </label>

                                                <input readonly
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="ebs_invoiceCounter"
                                                    placeholder="Invoice counter"
                                                    value="{{ old('ebs_invoiceCounter', $ebs_invoiceCounter) }}">
                                            </div>

                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- MRA ID -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_mraId">
                                                    MRA ID
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="ebs_mraId" placeholder="MRA Id"
                                                    value="{{ old('ebs_mraId', $ebs_mraId->value) }}">
                                                @error('ebs_mraId')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Area Code -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_areaCode">
                                                    Area Code
                                                </label>

                                                <input id="ebs_areaCode"
                                                    @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') required @endif
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="number" name="ebs_areaCode" placeholder="Area Code"
                                                    value="{{ old('ebs_areaCode', $ebs_areaCode->value) }}">
                                                @error('ebs_areaCode')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- MRA Username -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_mraUsername">
                                                    MRA Username
                                                </label>

                                                <input id="ebs_mraUsername"
                                                    @if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') required @endif
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="ebs_mraUsername" placeholder="MRA Username"
                                                    value="{{ old('ebs_mraUsername', $ebs_mraUsername->value) }}">
                                                @error('ebs_mraUsername')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- MRA Password -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_mraPassword">
                                                    MRA Password
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="password" name="ebs_mraPassword" placeholder="MRA Password"
                                                    value="{{ old('ebs_mraPassword', $ebs_mraPassword->value) }}">
                                                @error('ebs_mraPassword')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Transaction Type -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_transactionType">
                                                    Transaction Type
                                                </label>

                                                <select name="ebs_transactionType" type="text" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Transaction Type"
                                                    value="{{ old('ebs_transactionType') }}">
                                                    <option value="B2B"
                                                        @if (isset($ebs_transactionType->value) && $ebs_transactionType->value == 'B2G') selected @endif>Business to
                                                        Government (B2G)</option>
                                                    <option value="B2C"
                                                        @if (isset($ebs_transactionType->value) && $ebs_transactionType->value == 'B2C') selected @elseif(isset($ebs_transactionType->value) &&
                                                                $ebs_transactionType->value != 'B2B' &&
                                                                (isset($ebs_transactionType->value) && $ebs_transactionType->value != 'EXP') &&
                                                                (isset($ebs_transactionType->value) && $ebs_transactionType->value != 'B2E') &&
                                                                (isset($ebs_transactionType->value) && $ebs_transactionType->value != 'B2G')) selected @endif>
                                                        Business to Consumer (B2C)</option>
                                                    <option value="EXP"
                                                        @if (isset($ebs_transactionType->value) && $ebs_transactionType->value == 'EXP') selected @endif>Zero rated
                                                        supplies – Exports (EXP)</option>
                                                    <option value="B2E"
                                                        @if (isset($ebs_transactionType->value) && $ebs_transactionType->value == 'B2E') selected @endif>Taxable
                                                        supplies made to exempt bodies or persons (B2E)</option>
                                                </select>
                                                @error('ebs_transactionType')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>


                                        </div>


                                        <div class="grid md:grid-cols-1 md:gap-6">
                                            <!-- Token url -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_token_url">
                                                    Token url
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="url" name="ebs_token_url" placeholder="Token url"
                                                    value="{{ old('ebs_token_url', $ebs_token_url->value) }}">
                                                @error('ebs_token_url')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Transmit Url -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900"
                                                    for="ebs_transmit_url">
                                                    Transmit Url
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="url" name="ebs_transmit_url" placeholder="Transmit Url"
                                                    value="{{ old('ebs_transmit_url', $ebs_transmit_url->value) }}">
                                                @error('ebs_transmit_url')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <button type="submit"
                                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                Update
                                            </button>
                                            <a href="{{ route('mra.unsubmitted_invoices') }}"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 text-center sm:ml-auto">
                                                View Unsubmitted Invoices
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-2">
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 mr-2">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Email SMTP
                                Settings</span>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                    <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="align-middle inline-block min-w-full">
                                <div class="shadow overflow-hidden sm:rounded-lg">
                                    <div class="flex flex-col">
                                        <label class="block mb-2 text-md font-medium text-gray-900"
                                            for="activate_sending_email">
                                            Activate sending of email
                                        </label>
                                        <form method="POST" action="{{ route('updateSendBackofficeOrderMail') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="back_office_order"
                                                class="inline-flex relative items-center cursor-pointer">
                                                <input type="checkbox" value="" id="back_office_order"
                                                    name="back_office_order" class="sr-only peer"
                                                    onChange="this.form.submit()"
                                                    @if (isset($backoffice_order_mail->value) && $backoffice_order_mail->value == 'yes') checked @endif>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                </div>
                                                <br>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Back office order
                                                    to Customer</span>
                                            </label>
                                        </form>

                                        <form method="POST"
                                            action="{{ route('updateSendBackofficeOrderMailAdmin') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="backoffice_order_mail_admin"
                                                class="inline-flex relative items-center cursor-pointer">
                                                <input type="checkbox" value=""
                                                    id="backoffice_order_mail_admin"
                                                    name="backoffice_order_mail_admin" class="sr-only peer"
                                                    onChange="this.form.submit()"
                                                    @if (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == 'yes') checked @endif>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                </div>
                                                <br>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Back office order
                                                    to Admin</span>
                                            </label>
                                        </form>

                                        <form method="POST" action="{{ route('updateOnlineshopOrderMail') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="online_shop_order"
                                                class="inline-flex relative items-center cursor-pointer">
                                                <input type="checkbox" value="" id="online_shop_order"
                                                    name="online_shop_order" class="sr-only peer"
                                                    onChange="this.form.submit()"
                                                    @if (isset($onlineshop_order_mail->value) && $onlineshop_order_mail->value == 'yes') checked @endif>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                </div>
                                                <br>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Online Shop order
                                                    to Customer</span>
                                            </label>
                                        </form>

                                        <form method="POST" action="{{ route('updateOnlineshopOrderMailAdmin') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="onlineshop_order_mail_admin"
                                                class="inline-flex relative items-center cursor-pointer">
                                                <input type="checkbox" value=""
                                                    id="onlineshop_order_mail_admin"
                                                    name="onlineshop_order_mail_admin" class="sr-only peer"
                                                    onChange="this.form.submit()"
                                                    @if (isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == 'yes') checked @endif>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                </div>
                                                <br>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Online Shop order
                                                    to Admin</span>
                                            </label>
                                        </form>

                                        <form method="POST" action="{{ route('updateOrderStatusChangeToAdmin') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="order_status_change_to_admin"
                                                class="inline-flex relative items-center cursor-pointer">
                                                <input type="checkbox" value=""
                                                    id="order_status_change_to_admin"
                                                    name="order_status_change_to_admin" class="sr-only peer"
                                                    onChange="this.form.submit()"
                                                    @if (isset($order_status_change_to_admin->value) && $order_status_change_to_admin->value == 'yes') checked @endif>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                </div>
                                                <br>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Order Status
                                                    Change to Admin</span>
                                            </label>
                                        </form>

                                    </div>

                                    <div class="flex flex-col">
                                        <form method="POST" action="{{ route('email-cc-admin') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Order Email for Sales -->
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 mt-6 text-md font-medium text-gray-900"
                                                    for="send">
                                                    Sending Email
                                                </label>
                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="email" name="order_email" placeholder="Sending Email"
                                                    value="@if (isset($company->order_email)) {{ old('order_email', $company->order_email) }} @else {{ old('order_email') }} @endif">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 mt-6 text-md font-medium text-gray-900"
                                                    for="cc">
                                                    Admin Email
                                                </label>
                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="email_cc_admin" placeholder="Admin Email"
                                                    value="@if (isset($email_cc_admin->value) && !empty($email_cc_admin->value)) {{ $email_cc_admin->value }} @endif">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 mt-6 text-md font-medium text-gray-900"
                                                    for="bcc">
                                                    BCC Email Addresses
                                                </label>
                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    type="text" name="email_bcc_admin"
                                                    placeholder="BCC Email Addresses"
                                                    value="@if (isset($email_bcc_admin->value) && !empty($email_bcc_admin->value)) {{ $email_bcc_admin->value }} @endif">
                                            </div>
                                            <div class="flex items-center pr-4 justify-end mt-4">
                                                <button type="submit"
                                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <label class="block mb-2 mt-6 text-md font-medium text-gray-900" for="smtp">
                                        SMTP Settings
                                    </label>
                                    <form method="POST" action="{{ route('add-update-email-smtp') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                                            <div class="flex flex-col">
                                                <div class="overflow-x-auto rounded-lg">
                                                    <div class="align-middle inline-block min-w-full">
                                                        <div class="shadow overflow-hidden sm:rounded-lg">
                                                            <input type="hidden" name="id"
                                                                value="@if (isset($email_smtp->id)) {{ $email_smtp->id }} @endif">
                                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                                <label
                                                                    class="block mb-2 text-sm font-medium text-gray-900"
                                                                    for="smtp_username">
                                                                    SMTP Username
                                                                </label>

                                                                <input
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                                    type="text" name="smtp_username"
                                                                    placeholder="SMTP Username"
                                                                    value="@if (isset($email_smtp->username)) {{ old('smtp_username', $email_smtp->username) }}@else{{ old('smtp_username') }} @endif"
                                                                    required>
                                                                @error('smtp_username')
                                                                    <span class="text-red-600 text-sm">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                                <label
                                                                    class="block mb-2 text-sm font-medium text-gray-900"
                                                                    for="smtp_username">
                                                                    SMTP Password
                                                                </label>

                                                                <textarea id="smtp_password" name="smtp_password" rows="4"
                                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                                    placeholder="SMTP Password" required>
@if (isset($email_smtp->password))
{{ old('smtp_password', $email_smtp->password) }}@else{{ old('smtp_password') }}
@endif
</textarea>
                                                                @error('smtp_password')
                                                                    <span class="text-red-600 text-sm">
                                                                        {{ $message }}
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="flex items-center pr-4 justify-end mt-4">
                                                                <button type="submit"
                                                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                                                    Save
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-2 p-4 xl:p-4 ml-2">

                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Payment
                                Modes</span>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('paymentsMethodSales.create') }}"
                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Add Payment Mode Sales
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="align-middle inline-block min-w-full">
                                <div class="shadow overflow-hidden sm:rounded-lg">
                                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th scope="col"
                                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                    Payment Mode
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                    BO Sales Order
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                    Online Shop Order
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ($paymentMethodSales as $paymentMethodSale)
                                                @if ($paymentMethodSale->payment_method != 'Payment Due')
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    <tr class="hover:bg-gray-100">
                                                        <td class="p-2  text-center font-medium text-gray-900">
                                                            {{ $paymentMethodSale->id }}
                                                        </td>
                                                        <td class="p-2  text-center font-medium text-gray-900">
                                                            {{ $paymentMethodSale->payment_method }}
                                                        </td>

                                                        <td class="p-2 text-center font-medium text-gray-900">
                                                            <form method="POST"
                                                                action="{{ route('update-payment-method-sales-bo-sales', $paymentMethodSale->id) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <label for="is_on_bo_sales_order{{ $i }}"
                                                                    class="inline-flex relative items-center cursor-pointer">
                                                                    <input type="checkbox" value=""
                                                                        @if ($paymentMethodSale->is_on_bo_sales_order == 'yes') checked @endif
                                                                        name="is_on_bo_sales_order"
                                                                        id="is_on_bo_sales_order{{ $i }}"
                                                                        class="sr-only peer"
                                                                        onChange="this.form.submit()">
                                                                    <div
                                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                                    </div>
                                                                    <br>
                                                                    <span
                                                                        class="ml-3 text-sm font-medium text-gray-900">
                                                                        @if ($paymentMethodSale->is_on_bo_sales_order == 'yes')
                                                                            Yes
                                                                        @else
                                                                            No
                                                                        @endif
                                                                    </span>
                                                                </label>
                                                            </form>
                                                        </td>
                                                        <td class="p-2 text-center font-medium text-gray-900">
                                                            @if ($paymentMethodSale->payment_method != 'Credit Sale')
                                                                <form method="POST"
                                                                    action="{{ route('update-payment-method-sales-online-shop', $paymentMethodSale->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <label
                                                                        for="is_on_online_shop_order{{ $i }}"
                                                                        class="inline-flex relative items-center cursor-pointer">
                                                                        <input type="checkbox" value=""
                                                                            @if ($paymentMethodSale->is_on_online_shop_order == 'yes') checked @endif
                                                                            id="is_on_online_shop_order{{ $i }}"
                                                                            name="is_on_online_shop_order"
                                                                            class="sr-only peer"
                                                                            onChange="this.form.submit()">
                                                                        <div
                                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                                        </div>
                                                                        <br>
                                                                        <span
                                                                            class="ml-3 text-sm font-medium text-gray-900">
                                                                            @if ($paymentMethodSale->is_on_online_shop_order == 'yes')
                                                                                Yes
                                                                            @else
                                                                                No
                                                                            @endif
                                                                        </span>
                                                                    </label>
                                                                </form>
                                                            @endif
                                                        </td>
                                                        <td class="p-2">
                                                            <a href="{{ route('paymentsMethodSales.edit', $paymentMethodSale->id) }}"
                                                                class="mt-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                                <svg class="mr-2 h-5 w-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
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
                                                            @if ($paymentMethodSale->payment_method == 'Debit/Credit Card')
                                                                <button data-modal-toggle="mcb-merchant-information"
                                                                    class="mt-1 text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                                                    <svg class="mr-2 h-5 w-5 feather feather-settings"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <circle cx="12" cy="12" r="3">
                                                                        </circle>
                                                                        <path
                                                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                                        </path>
                                                                    </svg>
                                                                    Settings
                                                                </button>
                                                            @endif
                                                            @if ($paymentMethodSale->is_default == 'no')
                                                                <form
                                                                    action="{{ route('paymentsMethodSales.destroy', $paymentMethodSale->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                                    style="margin:0">
                                                                    <input type="hidden" name="_method"
                                                                        value="DELETE">
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
                                                                        Delete Payment mode
                                                                    </button>
                                                                </form>
                                                            @endif
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
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="mcb-merchant-information" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        MCB Merchant Information
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="mcb-merchant-information">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('add-update-mcb-configuration') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            @if ($merchant != null)
                                                <input type="hidden" name="id_bankinfo"
                                                    value="{{ $merchant->id }}">
                                            @endif
                                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                                for="merchantID">
                                                Merchant ID
                                            </label>
                                            <input
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                type="text" name="merchantID" placeholder="Merchant ID"
                                                value="@if ($merchant != null) {{ old('merchantID', $merchant->merchantID) }}@else{{ old('merchantID') }} @endif"
                                                required>
                                            @error('merchantID')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                                for="merchantPassword">
                                                Merchant Password
                                            </label>

                                            <input type="password" id="merchantPassword" name="merchantPassword"
                                                rows="4"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Mechant Password"
                                                value="@if ($merchant != null) {{ old('merchantPassword', $merchant->merchantPassword) }}@else{{ old('merchantPassword') }} @endif"
                                                required>
                                            @error('merchantPassword')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="mra-vat_rat" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        VAT Rate Information
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="mra-vat_rat">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('add-update-mra-vat-rat') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-2">
                            <div class="">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="">
                                        <div class="mb-2">
                                            <span class="leading-none font-bold text-gray-900">Enter the different VAT
                                                % Rates </span>
                                        </div>
                                        <div id="input-container">
                                            @if (empty($vat_rate_setting))
                                                <div class="flex mb-2">
                                                    <input type="text" name="vatrate[]"
                                                        class="form-input px-4 py-3 w-full" placeholder="Enter Rate">
                                                    <button type="button" id="add-field"
                                                        class=" ml-2 bg-blue-500 text-white px-4 py-2 rounded">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                @foreach ($vat_rate_setting as $k => $vtv)
                                                    @if ($k == 0)
                                                        <div class="flex mb-2">
                                                            <input type="text" name="vatrate[]"
                                                                class="form-input px-4 py-3 w-full"
                                                                placeholder="Enter Rate"
                                                                value="{{ $vtv }}">
                                                            <button type="button" id="add-field"
                                                                class=" ml-2 bg-blue-500 text-white px-4 py-2 rounded">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-6 w-6" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="flex mb-2">
                                                            <input type="text" name="vatrate[]"
                                                                class="form-input px-4 py-3 w-full"
                                                                placeholder="Enter Rate"
                                                                value="{{ $vtv }}">
                                                            <button type="button"
                                                                class="ml-2 bg-red-500 text-white px-4 py-2 rounded remove-field ">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-6 w-6" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>


<script>
    $(document).ready(function() {
        // Initially hide and disable elements
        $('#todaydateforinvoice').hide();
        $('#ebs_invoiceIdentifier_date').prop('disabled', true).hide();
        $('#ebs_invoiceIdentifier').prop('disabled', true).hide();

        // Check initial value of $ebs_invoiceIdentifier->value
        const ebsInvoiceValue =
            "{{ $ebs_invoiceIdentifier->value }}"; // Ensure this is correctly passed from server-side

        // Check if the value is 'Todaydate' and update the checkboxes accordingly
        if (ebsInvoiceValue === "Todaydate") {
            // Check the 'dategenerated_check' checkbox and show related elements
            $('#dategenerated_check').prop('checked', true);
            $('#customtext_check').prop('checked', false);
            $('#todaydateforinvoice').show();
            $('#ebs_invoiceIdentifier_date').prop('disabled', false);
            $('#ebs_invoiceIdentifier').prop('disabled', true).hide();
        } else {
            // Check the 'customtext_check' checkbox and show the invoice identifier field
            $('#dategenerated_check').prop('checked', false);
            $('#customtext_check').prop('checked', true);
            $('#todaydateforinvoice').hide();
            $('#ebs_invoiceIdentifier_date').prop('disabled', true).hide();
            $('#ebs_invoiceIdentifier').prop('disabled', false).show();
        }

        // Handle 'dategenerated_check' checkbox
        $('#dategenerated_check').change(function() {
            if ($(this).is(':checked')) {
                // Show and enable the date input and its container
                $('#todaydateforinvoice').show();
                $('#ebs_invoiceIdentifier_date').prop('disabled', false);

                // Hide and disable the custom text input
                $('#ebs_invoiceIdentifier').prop('disabled', true).hide();

                // Uncheck the 'customtext_check' checkbox
                $('#customtext_check').prop('checked', false);
            } else {
                // Reset the date input and its container
                $('#todaydateforinvoice').hide();
                $('#ebs_invoiceIdentifier_date').prop('disabled', true).hide();
            }
        });

        // Handle 'customtext_check' checkbox
        $('#customtext_check').change(function() {
            if ($(this).is(':checked')) {
                // Show and enable the custom text input
                $('#ebs_invoiceIdentifier').prop('disabled', false).show();

                // Hide and disable the date input and its container
                $('#todaydateforinvoice').hide();
                $('#ebs_invoiceIdentifier_date').prop('disabled', true).hide();

                // Uncheck the 'dategenerated_check' checkbox
                $('#dategenerated_check').prop('checked', false);
            } else {
                // Reset the custom text input
                $('#ebs_invoiceIdentifier').prop('disabled', true).hide();
            }
        });

        $("#customtext_check").change(function() {
            if ($(this).is(":checked")) {
                $("#ebs_invoiceIdentifier").val("");
            }
        });

    });
</script>



<script>
    $("#display_logo_in_pdf").click(function() {
        $("#success_message_display_logo_in_pdf").hide();
        change_display_logo_in_pdf();
    });

    $("#ebs_typeOfPerson").change(function() {
        var ebs_typeOfPerson = $(this).val();
        if (ebs_typeOfPerson == "VATR") {
            $('#vat_calculation').removeClass('hidden');
            $("#vat_type").val('Added to the price');
        } else {
            $('#vat_calculation').addClass('hidden');
            $("#vat_type").val('No VAT');
        }

    });

    $("#ebs_mra_einvoincing").change(function() {
        var ebs_mra_einvoincing = $(this).val();
        if (ebs_mra_einvoincing == "On") {
            $('#ebs_areaCode').attr("required", "true");
            $('#ebs_invoiceIdentifier').attr("required", "true");
            $('#ebs_mraUsername').attr("required", "true");

        } else {
            $('#ebs_areaCode').removeAttr("required");
            $('#ebs_invoiceIdentifier').removeAttr("required");
            $('#ebs_mraUsername').removeAttr("required");
        }
    });

    function changetrainingmode(element) {
        var ebs_trainingmode = $(element).val();
        if (ebs_trainingmode == "On") {
            $(element).val('Off');
        } else {
            $(element).val('On');
        }
    }

    function change_display_logo_in_pdf() {
        $.ajax({
            url: '{{ url('/updateDisplayLogoPdf') }}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data, statut) {
                $("#success_message_display_logo_in_pdf").show();
            },
            error: function(data, statut, erreur) {
                alert("Something going wrong\n" + JSON.stringify(data));
                console.log(erreur);
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addFieldButton = document.getElementById('add-field');
        const inputContainer = document.getElementById('input-container');

        addFieldButton.addEventListener('click', function() {
            const newField = document.createElement('div');
            newField.classList.add('flex', 'mb-2');
            newField.innerHTML = `
                    <input type="text" name="vatrate[]" class="form-input px-4 py-3 w-full" placeholder="Enter Rate">
                    <button type="button" class="ml-2 bg-red-500 text-white px-4 py-2 rounded remove-field ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
            inputContainer.appendChild(newField);

            // Ajouter l'écouteur d'événements pour le bouton "Remove"
            newField.querySelector('.remove-field').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Ajouter l'écouteur d'événements pour les boutons "Remove" existants
        document.querySelectorAll('.remove-field').forEach(function(button) {
            button.addEventListener('click', function() {
                button.parentElement.remove();
            });
        });
    });
</script>
