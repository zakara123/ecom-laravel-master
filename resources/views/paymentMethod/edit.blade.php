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
                            <a href="{{ url('settings') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Settings</a>
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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Update
                                Payment Mode</span>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Payment Mode</h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white">

                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('update-payment-method-sales', $paymentMethode->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Payment Method -->

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                for="payment_method">
                                Payment Mode
                            </label>

                            <input required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="text" name="payment_method" placeholder="Payment Method"
                                value="{{ old('payment_method', $paymentMethode->payment_method) }}"
                                @if ($paymentMethode->is_default == 'yes') readonly="readonly" @endif>
                            @error('payment_method')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        @if ($paymentMethode->credentials)
                            @php
                                $credentials = json_decode($paymentMethode->credentials, true);
                            @endphp
                            @foreach ($credentials as $key => $value)
                                <div class="mb-6">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        for="credentials[{{ $key }}]">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    <input required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        type="text" name="credentials[{{ $key }}]"
                                        placeholder="{{ ucfirst(str_replace('_', ' ', $key)) }}"
                                        value="{{ old('credentials.' . $key, $value) }}">

                                    @error('credentials.' . $key)
                                        <span class="text-red-600 text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        @endif


                        {{-- <div class="grid md:grid-cols-3 md:gap-6">

                            <div class="mb-6 w-1/3">
                                <label for="is_on_bo_sales_order" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="is_on_bo_sales_order" name="is_on_bo_sales_order" onChange="this.form.submit()"
                                    @if ($paymentMethode->is_on_bo_sales_order == 'yes') checked
                                    @endif
                                    class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">visible on BO Sales Order</span>
                                </label>
                            </div>

                            <div class="mb-6 w-1/3">
                                <label for="is_on_online_shop_order" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="is_on_online_shop_order" name="is_on_online_shop_order" onChange="this.form.submit()"
                                    @if ($paymentMethode->is_on_online_shop_order == 'yes') checked
                                    @endif
                                    class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">visible on Online Shop Order</span>
                                </label>
                            </div>

                        </div> --}}

                        <div id="accordion-color" data-accordion="collapse"
                            data-active-classes="bg-blue-100 dark:bg-gray-800 text-gray-600 dark:text-white">

                            <h2 id="accordion-color-heading-2">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-color-body-2" aria-expanded="false"
                                    aria-controls="accordion-color-body-2">
                                    <span>Pending Payment Email</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
                                <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_email_before">
                                                Sales Order Email Body : Text Before Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_email_before" rows="8" name="text_email_before"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text Before Order Details">{{ old('text_email_before', $paymentMethode->text_email_before) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_email_before')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Text After Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_email">
                                                Sales Order Email Body : Text After Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_email" rows="8" name="text_email"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text After Order Details">{{ old('text_email', $paymentMethode->text_email) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_email')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="accordion-color-3" data-accordion="collapse"
                            data-active-classes="bg-blue-100 dark:bg-gray-800 text-gray-600 dark:text-white">

                            <h2 id="accordion-color-heading-3">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-color-body-3" aria-expanded="false"
                                    aria-controls="accordion-color-body-3">
                                    <span>Pending Payment PDF</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-3" class="hidden"
                                aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_pdf_before">
                                                Sales Order PDF Body : Text Before Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_pdf_before" rows="8" name="text_pdf_before"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text Before Order Details">{{ old('text_pdf_before', $paymentMethode->text_pdf_before) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_pdf_before')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Text After Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_pdf_after">
                                                Sales Order PDF Body : Text After Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_pdf_after" rows="8" name="text_pdf_after"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text After Order Details">{{ old('text_pdf_after', $paymentMethode->text_pdf_after) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_pdf_after')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="accordion-color-0" data-accordion="collapse"
                            data-active-classes="bg-blue-100 dark:bg-gray-800 text-gray-600 dark:text-white">

                            <h2 id="accordion-color-heading-21">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-color-body-21" aria-expanded="false"
                                    aria-controls="accordion-color-body-2">
                                    <span>Payment Received Email</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-21" class="hidden"
                                aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">


                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_email_before_invoice">
                                                Invoice Order Email Body : Text Before Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_email_before_invoice" rows="8" name="text_email_before_invoice"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text Before Order Details">{{ old('text_email_before_invoice', $paymentMethode->text_email_before_invoice) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_email_before_invoice')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Text After Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_email_after_invoice">
                                                Invoice Order Email Body : Text After Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_email_after_invoice" rows="8" name="text_email_after_invoice"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text After Order Details">{{ old('text_email_after_invoice', $paymentMethode->text_email_after_invoice) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_email_after_invoice')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="accordion-color-4" data-accordion="collapse"
                            data-active-classes="bg-blue-100 dark:bg-gray-800 text-gray-600 dark:text-white">

                            <h2 id="accordion-color-heading-4">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-color-body-4" aria-expanded="false"
                                    aria-controls="accordion-color-body-24">
                                    <span>Payment Received PDF</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-4" class="hidden"
                                aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_pdf_before_invoice">
                                                Invoice Order PDF Body : Text Before Order Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_pdf_before_invoice" rows="8" name="text_pdf_before_invoice"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text Before Order Details">{{ old('text_pdf_before_invoice', $paymentMethode->text_pdf_before_invoice) }}</textarea>
                                                </div>
                                            </div>
                                            @error('text_pdf_before_invoice')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Text After Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="text_pdf_after_invoice">
                                                Invoice Order PDF Body : Text After Order Details
                                            </label>
                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="text_pdf_after_invoice" rows="8" name="text_pdf_after_invoice"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Text After Order Details">{{ old('text_pdf_after_invoice', $paymentMethode->text_pdf_after_invoice) }}</textarea>
                                                </div>
                                            </div>

                                            @error('text_pdf_after_invoice')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="accordion-color-5" data-accordion="collapse"
                            data-active-classes="bg-blue-100 dark:bg-gray-800 text-gray-600 dark:text-white">

                            <h2 id="accordion-color-heading-5">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                                    data-accordion-target="#accordion-color-body-5" aria-expanded="false"
                                    aria-controls="accordion-color-body-5">
                                    <span>Online Shop Checkout Results Page</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-5" class="hidden"
                                aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">

                                    <div class="grid md:grid-cols-2 md:gap-6">

                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="thankyou">
                                                Thanks You Details
                                            </label>

                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="thankyou" rows="8" name="thankyou"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Thanks You Details">{{ old('thankyou', $paymentMethode->thankyou) }}</textarea>
                                                </div>
                                            </div>
                                            @error('thankyou')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="failed">
                                                Failed Order Details
                                            </label>
                                            <div
                                                class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                                <div class="py-2 px-4 bg-white rounded-b-lg dark:bg-gray-800">

                                                    <textarea id="failed" rows="8" name="failed"
                                                        class="block px-0 w-full text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Failed Order Details">{{ old('failed', $paymentMethode->failed) }}</textarea>
                                                </div>
                                            </div>

                                            @error('failed')
                                                <span class="text-red-600 text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'table lists',
            plugins: 'table lists link', // Add the image plugin
            toolbar: 'undo redo | blocks | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | code | table | link image', // Add the image button to the toolbar
            default_link_target: '_blank',
            promotion: false,
            license_key: 'gpl'
        });
    </script>

</x-app-layout>
