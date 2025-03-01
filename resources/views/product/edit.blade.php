<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <a href="{{ url('item') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Items</a>
                        </div>
                    </li>
                    {{--  <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                    aria-current="page">Products</span>
                            </div>
                        </li>  --}}
                </ol>
            </nav>
            @php
                $stock_required_online_shop = App\Models\Setting::where('key', 'stock_required_online_shop')
                    ->pluck('value')
                    ->first();
                $display_online_shop_product = App\Models\Setting::where('key', 'display_online_shop_product')
                    ->pluck('value')
                    ->first();
            @endphp
            @if ($stock_required_online_shop == 'yes' && $display_online_shop_product == 'yes')
                <div
                    class="block items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    Product won't be displayed on online store because of stock settings. You can manage stock settings
                    from here
                    <a href="{{ route('online_stock') }}"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center mx-2">
                        Stock Settings
                    </a>
                </div>
            @endif
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Item</h1>
                </div>
                <div class="flex items-center sm:justify-end w-full">
                    <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Show Item
                    </a>
                    <a href="{{ route('product-stock', $product->id) }}"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Manage Stock
                    </a>
                    <a href="{{ route('product-variation', $product->id) }}"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Manage Variations
                    </a>
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

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center min-h-screen bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white">

                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form id="upload_form" method="POST" action="{{ route('item.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="name">
                                Name
                            </label>

                            <input required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                type="text" name="name" placeholder="Name"
                                value="{{ old('name', $product->name) }}">
                            @error('name')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <!-- Visibility -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    for="display_online">
                                    Display this product on Online Shop
                                </label>

                                <select name="display_online" id="display_online"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Visibility Status"
                                    value="{{ old('display_online', $product->display_online) }}">

                                    <option value="1" @if ($product->display_online == '1') selected @endif>Yes
                                    </option>
                                    <option value="0" @if ($product->display_online == '0') selected @endif>No</option>

                                </select>
                                @error('display_online')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                            class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="name">
                                    Position
                                </label>

                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    type="text" name="position" placeholder="Position"
                                    value="{{ old('position', $product->position) }}">
                                @error('name')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <!-- VAT -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="vat">
                                    VAT
                                </label>
                                <select name="vat" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="VAT" value="{{ old('vat', $product->vat) }}">

                                    <option value="VAT Exempt" @if ($product->vat == 'VAT Exempt') selected @endif>VAT
                                        Exempt</option>
                                    <option value="Zero Rated" @if ($product->vat == 'Zero Rated') selected @endif>Zero
                                        Rated</option>
                                    @foreach ($vat_rate_setting as $k => $vtv)
                                        <option value="{{ $vtv }}"
                                            @if ($product->vat == $vtv) selected @endif>{{ $vtv }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vat')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="description">
                                Description
                            </label>
                            <textarea name="description" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                                placeholder="Your description..."> {{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{--                        <div class="mb-6"> --}}
                        {{--                            <label for="is_variable_product" class="inline-flex relative items-center cursor-pointer"> --}}
                        {{--                                <input type="checkbox" value="" id="is_variable_product" --}}
                        {{--                                    @if ($product->is_variable_product == 'yes') checked @endif name="is_variable_product" --}}
                        {{--                                    class="sr-only peer"> --}}
                        {{--                                <div --}}
                        {{--                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"> --}}
                        {{--                                </div> --}}
                        {{--                                <span class="ml-3 text-sm font-medium text-gray-900 ">Is a Variable Product. Use Variation Selling Price.</span> --}}
                        {{--                            </label> --}}
                        {{--                        </div> --}}

                        <div class="mb-6">
                            <label for="is_rental_product" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="1" id="is_rental_product"
                                    @if ($product->is_rental_product == 'yes') checked @endif name="is_rental_product"
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 ">Can be Rented</span>
                            </label>
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6 div_price">
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="price">
                                    Selling Price
                                </label>
                                <input name="price" type="number" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Selling Price" value="{{ old('price', $product->price) }}"
                                    min="0.10" step="0.01">
                                @error('price')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="price_buying">
                                    Buying Price
                                </label>
                                <input name="price_buying" type="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Buying Price"
                                    value="{{ old('price_bying', $product->price_buying) }}" step="0.01">
                                @error('price_bying')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="unit_selling_label">
                                    Unit Selling Label
                                </label>
                                <input name="unit_selling_label" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Unit Selling Label"
                                    value="{{ old('unit_selling_label', $product->unit) }}">
                                @error('unit_selling_label')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="mb-6 mr-2 w-full" style="display: none;" id="rentalOptions">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="rental_price">
                                    Rental Price
                                </label>
                                <input name="rental_price" id="rental_price" type="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Rental Price"
                                    value="{{ old('rental_price', $product->rental_price) }}"
                                    @if ($product->is_rental_product == 'yes') min="0.10" @endif step="0.01">
                                @error('rental_price')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-6 mr-2 w-full" style="display: none;" id="rentalOptionLabel">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="unit_rental_label">
                                    Unit Rental Label
                                </label>
                                <input name="unit_rental_label" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Unit Rental Label" id="rental_label"
                                    value="{{ old('unit_rental_label', $product->unit_rental_label) }}">
                                @error('unit_rental_label')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <!-- Unit Label -->
                        <!--<div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="unit">
                                    Unit Label
                                </label>
                                <input name="unit" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Unit Label" value="{{ old('unit', $product->unit) }}">
                                @error('unit')
    <span class="text-red-600 text-sm">
                                            {{ $message }}
                                        </span>
@enderror
                            </div>-->
                        <!-- Supplier -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                for="supplier">
                                Supplier
                            </label>
                            <select name="supplier" id="supplier"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Supplier" value="{{ old('supplier', $product->id_supplier) }}">
                                <option value=""></option>
                                @foreach ($supplier as $supp)
                                    <option value="{{ $supp->id }}"
                                        @if ($product->id_supplier == $supp->id) selected @endif>{{ $supp->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                        class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>


                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="category">
                                Category
                            </label>
                            <select name="category[]" id="category" multiple="multiple"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Category" value="{{ old('category') }}">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @foreach ($productCategory as $pc)
                                            @if ($pc->id_category == $category->id)
                                                selected
                                            @endif @endforeach>
                                        {{ $category->category }}</option>
                                @endforeach

                            </select>
                            @error('vat')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="w-full md:w-1/3 text-sm font-medium text-gray-700" for="signinSrEmail">
                                Item Image
                            </label>
                            <div class="w-full md:w-2/3">
                                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden"
                                    data-type="image" data-multiple="true">
                                    <button id="product-images-btn" type="button" data-open-modal
                                        data-input-id="product-images"
                                        data-preview-id="product-images-file-preview-container"
                                        data-multiple-files="true"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 font-medium hover:bg-gray-200">
                                        Browse
                                    </button>
                                    <label for="product-images-btn" class="flex-1 px-4 py-2 text-gray-500">Choose
                                        File</label>
                                    <input type="hidden" name="item_image" class="selected-files"
                                        id="product-images">
                                </div>
                                <div class="file-preview mt-2 border border-gray-200 rounded-sm p-2 bg-gray-50"
                                    id="product-images-file-preview-container">
                                    <!-- File preview box -->
                                </div>
                                <small class="block mt-1 text-xs text-gray-500">
                                    These images are visible in the product details page gallery. Use
                                    600x600 size images.<br>
                                    Click on any image to move it to first position.
                                </small>
                            </div>
                        </div>

                        <div class="mb-6 flex items-center w-full">
                            @foreach ($images as $image)
                                <div class="w-48 pr-4 mx-4">
                                    <div class="card text-white bg-secondary mb-3">
                                        <div class="card-body relative">
                                            <img src="{{ $image->src }}"
                                                class="card-img-top object-contain hover:object-scale-down w-48 clickable-image"
                                                alt="{{ $product->name }}" data-id="{{ $image->id }}">

                                            <a href="{{ route('delete-product-image', $image->id) }}"
                                                class="absolute top-3 right-3 px-1 py-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        {{-- <p style="font: 5px"><b>{{ $image->name_product }}</b></p> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>



                        <div class="flex items-center justify-start mt-4">
                            <button type="submit" id="myButton"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.file-management-modal')

    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.clickable-image').on('click', function() {
                const imageId = $(this).data('id');

                // Send GET request to update the image's updated_at timestamp
                $.ajax({
                    url: `/update-product-image/${imageId}`,
                    method: 'GET',
                    success: function(response) {
                        alert('Image updated successfully!');
                        // Optional: Refresh the page or dynamically update the UI
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating image:', error);
                        alert('Failed to update the image.');
                    }
                });
            });
        });
    </script>


    <script>
        tinymce.init({
            selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'table lists link image', // Add the image plugin
            toolbar: 'undo redo | blocks | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | code | table | link image', // Add the image button to the toolbar
            default_link_target: '_blank',
            promotion: false,
            image_title: true,
            automatic_uploads: true,
            images_upload_url: '{{ route('upload.image') }}',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            license_key: 'gpl'
        });
    </script>
    <!-- include jQuery library -->
    <script>
        // FilePond.parse(document.body);
    </script>
    <script>
        $(document).ready(function() {
            // const inputElement = document.querySelector('.filepond');
            // FilePond.registerPlugin(FilePondPluginImagePreview);
            // FilePond.registerPlugin(FilePondPluginFileValidateType);
            // const pond = FilePond.create(inputElement, {
            //     acceptedFileTypes: ['image/*'],
            //     allowMultiple: true,
            //     allowFileTypeValidation: true,
            //     allowFileEncode: true,
            //     instantUpload: false,
            //     allowProcess: false,
            //     allowReorder: true
            // });

            $("#upload_form").submit(function(e) {
                e.preventDefault();
                var fd = new FormData(this);
                $("#myButton").html(
                    '<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg> Loading...'
                    );
                $("#myButton").attr("disabled", true);
                $("#myButton").attr("class",
                    "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center"
                    );

                // append files array into the form data
                // pondFiles = pond.getFiles();
                // for (var i = 0; i < pondFiles.length; i++) {
                //     fd.append('item_image[]', pondFiles[i].file);
                // }
                $.ajax({
                    url: "{{ route('item.update', $product->id) }}",
                    type: 'POST',
                    data: fd,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        //    todo the logic
                        // remove the files from filepond, etc
                        // window.location.href = data.reload;
                        window.location.reload();
                    },
                    error: function(data) {
                        /// do nothing
                    }
                });
            });

            /// is variable product
            select_is_variable_product();
            $("#is_variable_product").click(function() {
                select_is_variable_product();
            });

            /// select 2
            $('#supplier').select2({
                placeholder: 'Select a Supplier',
                dropdownAutoWidth: false,
                width: '100%',
                allowClear: true
            });
            $('#category').select2({
                placeholder: 'Select category',
                dropdownAutoWidth: false,
                width: '100%',
                allowClear: true
            });
        });

        function select_is_variable_product() {
            if ($("#is_variable_product").is(':checked')) {
                $(".div_price").hide();
            } else {
                $(".div_price").show(1000);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isRentalProductCheckbox = document.getElementById('is_rental_product');
            const rentalOptionsDiv = document.getElementById('rentalOptions');
            const rentalOptionLabelDiv = document.getElementById('rentalOptionLabel');


            function toggleRentalOptions() {
                if (isRentalProductCheckbox.checked) {
                    rentalOptionsDiv.style.display = 'block';
                    rentalOptionLabelDiv.style.display = 'block';
                    $('#rental_price').attr('required', true);
                } else {
                    rentalOptionsDiv.style.display = 'none';
                    rentalOptionLabelDiv.style.display = 'none';
                    $('#rental_price').attr('required', false);
                }
            }

            // Initialize the visibility based on the initial state of the checkbox
            toggleRentalOptions();

            // Add event listener for the change event
            isRentalProductCheckbox.addEventListener('change', toggleRentalOptions);
        });
    </script>
</x-app-layout>


<!-- fortestingcode -->
