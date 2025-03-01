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
                            <a href="{{ url('settings') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Settings</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Create Payment Mode</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Payment Mode</h1>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('create-payment-method-sales') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="payment_method">
                                Payment Method
                            </label>

                            <input required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" name="payment_method" placeholder="Payment Method" value="" required>
                            @error('payment_method')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-3 md:gap-6">

                            <div class="mb-2 w-full text-center">
                                <label for="is_on_bo_sales_order" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="is_on_bo_sales_order" name="is_on_bo_sales_order" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>

                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900">visible on BO Sales Order</span>
                                </label>
                            </div>

                            <div class="mb-2 w-full text-center">
                                <label for="is_on_online_shop_order" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="is_on_online_shop_order" name="is_on_online_shop_order" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>

                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900">visible on Online Shop Order</span>
                                </label>
                            </div>

                            <div class="mb-2 w-full text-center">
                                <label for="is_default" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" value="" id="is_default" name="is_default" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>

                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900">is a default Payment</span>
                                </label>
                            </div>

                        </div>

                        <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 text-gray-600">

                            <h2 id="accordion-color-heading-2">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100" data-accordion-target="#accordion-color-body-2" aria-expanded="false" aria-controls="accordion-color-body-2">
                                    <span>Sales Order Email</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
                                <div class="p-5 font-light border border-b-0 border-gray-200">
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_email_before">
                                                Sales Order Email Body : Text Before Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_email_before" rows="8" name="text_email_before" class="block px-0 w-full text-sm text-gray-800 bg-white border-0 focus:ring-0" placeholder="Text Before Order Details"></textarea>
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
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_email">
                                                Sales Order Email Body : Text After Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_email" rows="8" name="text_email" class="block px-0 w-full text-sm text-gray-800 bg-white border-0 focus:ring-0" placeholder="Text After Order Details"></textarea>
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

                        <div id="accordion-color-0" data-accordion="collapse" data-active-classes="bg-blue-100 text-gray-600">

                            <h2 id="accordion-color-heading-21">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100" data-accordion-target="#accordion-color-body-21" aria-expanded="false" aria-controls="accordion-color-body-2">
                                    <span>Invoice Email</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-21" class="hidden" aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200">
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_email_before_invoice">
                                                Invoice Order Email Body : Text Before Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_email_before_invoice" rows="8" name="text_email_before_invoice" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text Before Order Details"></textarea>
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
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_email_after_invoice">
                                                Invoice Order Email Body : Text After Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_email_after_invoice" rows="8" name="text_email_after_invoice" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text After Order Details"></textarea>
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
                        <div id="accordion-color-3" data-accordion="collapse" data-active-classes="bg-blue-100 text-gray-600">

                            <h2 id="accordion-color-heading-3">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                                    <span>Sales Order PDF</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200">

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_pdf_before">
                                                Sales Order PDF Body : Text Before Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_pdf_before" rows="8" name="text_pdf_before" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text Before Order Details"></textarea>
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
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_pdf_after">
                                                Sales Order PDF Body : Text After Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_pdf_after" rows="8" name="text_pdf_after" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text After Order Details"></textarea>
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

                        <div id="accordion-color-4" data-accordion="collapse" data-active-classes="bg-blue-100 text-gray-600">

                            <h2 id="accordion-color-heading-4">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100" data-accordion-target="#accordion-color-body-4" aria-expanded="false" aria-controls="accordion-color-body-24">
                                    <span>Invoice PDF</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-4" class="hidden" aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200">

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <!-- Text Before Order Details -->
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_pdf_before_invoice">
                                                Invoice Order PDF Body : Text Before Order Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_pdf_before_invoice" rows="8" name="text_pdf_before_invoice" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text Before Order Details"></textarea>
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
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="text_pdf_after_invoice">
                                                Invoice Order PDF Body : Text After Order Details
                                            </label>
                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="text_pdf_after_invoice" rows="8" name="text_pdf_after_invoice" class="block px-0 w-full text-sm text-gray-800 bg-white border-0" placeholder="Text After Order Details"></textarea>
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

                        <div id="accordion-color-5" data-accordion="collapse" data-active-classes="bg-blue-100 text-gray-600">
                            <h2 id="accordion-color-heading-5">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100" data-accordion-target="#accordion-color-body-5" aria-expanded="false" aria-controls="accordion-color-body-5">
                                    <span>Online Shop Checkout Results Page</span>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-color-body-5" class="hidden" aria-labelledby="accordion-color-heading-21">
                                <div class="p-5 font-light border border-b-0 border-gray-200">

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="thankyou">
                                                Thanks You Details
                                            </label>

                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="thankyou" rows="8" name="thankyou" class="block px-0 w-full text-sm text-gray-800 bg-white border-0 focus:ring-0" placeholder="Thanks You Details">{{old('thankyou')}}</textarea>
                                                </div>
                                            </div>
                                            @error('thankyou')
                                            <span class="text-red-600 text-sm">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-6 relative z-0 mb-6 w-full group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900" for="failed">
                                                Failed Order Details
                                            </label>
                                            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="py-2 px-4 bg-white rounded-b-lg">

                                                    <textarea id="failed" rows="8" name="failed" class="block px-0 w-full text-sm text-gray-800 bg-white border-0 focus:ring-0" placeholder="Failed Order Details">{{old('failed')}}</textarea>
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
                            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Save
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
            promotion:false,
            toolbar: 'undo redo | blocks | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | code | table | link image', // Add the image button to the toolbar
            default_link_target: '_blank'
        });
</script>


    {{-- @section('script')
        <script>
            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server: {
                    url: '/item-image',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
    },

    })
    </script>
    @endsection --}}

</x-app-layout>