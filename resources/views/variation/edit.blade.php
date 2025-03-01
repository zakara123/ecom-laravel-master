<x-app-layout>
    <x-slot name="header">
        {{-- <div class="mx-4 my-4">
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
                            <a href="{{ route('item.edit', $product->id) }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">{{ $product->name }}</a>
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
                            <a href="{{ route('product-variation', $product->id) }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Variation</a>
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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Edit
                                Variation</span>

                                
                        </div>
                    </li>
                    <li class="ml-auto">
                        <div class="flex items-center">
                            <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                                class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-right px-3 py-2 text-center">
                                Show Item
                            </a>
                        </div>
                    </li>
                    
                </ol>
            </nav>
        </div> --}}
        <div class="mx-4 my-4">
            <nav class="flex mb-5 justify-between" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('item.edit', $product->id) }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">{{ $product->name }}</a>
                        </div>
                    </li>
                    <li class="inline-flex items-center">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('product-variation', $product->id) }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Variation</a>
                        </div>
                    </li>
                    <li class="inline-flex items-center">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Edit Variation</span>
                        </div>
                    </li>
                </ol>
                <div class="ml-auto">
                    <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-right px-3 py-2 text-center">
                        Show Item
                    </a>
                </div>
            </nav>
        </div>
        
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0">
            @include('layouts.alerts')
        </div>
        <div class="font-sans antialiased">
            <div class="flex-col items-center mt-2 min-h-screen bg-gray-100 sm:justify-center sm:pt-0">

                <div class="w-full overflow-hidden bg-white">

                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                        <form id="upload_form_edit" method="POST"
                            action="{{ route('variation.update', $product_variation->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Name -->
                            <input type="hidden" name="id" value="{{ $product_variation->id }}" />
                            <input type="hidden" name="products_id" value="{{ $product_variation->products_id }}" />
                            <div class="col-span-full">
                                @if (!empty($product_variation->readable_product_variations))
                                    <h3 class="text-md font-bold leading-none text-gray-900">{{ $product->name }} :
                                        Variation - {{ $product_variation->readable_product_variations }}
                                    </h3>
                                @else
                                    <h3 class="text-md font-bold leading-none text-gray-900">{{ $product->name }} - No
                                        Variation</h3>
                                @endif

                            </div>
                            {{-- <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                                class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center" style="
                                width: 93px;
                                height: 45px;
                                margin-top: 22px;
                                margin-left: 205px;
                            ">
                                Show Item
                            </a> --}}
                            
                            <div class="grid grid-cols-3 gap-4 my-2">
                                @foreach ($attributes as $attribute)
                                    @php
                                        $selectedValue = $product_variation->attributes->firstWhere(
                                            'attribute_id',
                                            $attribute->id,
                                        );
                                        //                                            // Filter the collection to find the attribute where attribute_value_id matches $attribute->id
                                        //                                            $selectedValue = $product_variation->attributes->map(function ($item) use ($attribute) {
                                        //                                                return $item['attribute_value_id'] == $attribute->id;
                                        //                                            });
                                        //                                                dd($selectedValue['attribute_value_id']);
                                    @endphp
                                    <div class="p-1">
                                        <label class="block text-sm font-medium text-gray-700"
                                            for="{{ $attribute->attribute_slug }}">
                                            {{ $attribute->attribute_name }} <span class="text-red-500">*</span>
                                        </label>
                                        <select name="{{ $attribute->id }}" required
                                            id="{{ $attribute->attribute_slug }}"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Role">
                                            <option value=""></option>
                                            @foreach ($attribute->attributeValues as $attribute_value)
                                                <option value="{{ $attribute_value->id }}"
                                                    @if ($selectedValue && $selectedValue['attribute_value_id'] == $attribute_value->id) selected @endif>
                                                    {{ $attribute_value->attribute_values }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                                
                            </div>
                            
                            <div class="grid grid-cols-6 gap-6 mt-2">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="text-sm font-medium text-gray-900 block mb-2">Selling
                                        Price</label>
                                    <input type="number" name="price" id="price"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                        placeholder="Selling Price"
                                        value="{{ old('price', $product_variation->price) }}" min="0.10"
                                        step="0.01">

                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price_buying"
                                        class="text-sm font-medium text-gray-900 block mb-2">Buying
                                        Price</label>
                                    <input type="number" name="price_buying" id="price_buying"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                        value="{{ old('price_buying', $product_variation->price_buying) }}"
                                        placeholder="Buying Price" step="0.01">

                                </div>
                            </div>
                            @if ($product_variation->id)
                                <div class="grid grid-cols-6 gap-6 mt-2">
                                    <!-- Variation Images -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="barcode_value"
                                            class="text-sm font-medium text-gray-900 block mb-2">Variation Image</label>
                                        <div class="w-full md:w-2/3">
                                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden"
                                                data-type="image" data-multiple="true">
                                                <button type="button" id="variation-images-btn" data-open-modal
                                                    data-input-id="variation-images"
                                                    data-preview-id="variation-images-file-preview-container"
                                                    data-multiple-files="true"
                                                    class="px-4 py-2 bg-gray-100 text-gray-700 font-medium hover:bg-gray-200">
                                                    Browse
                                                </button>
                                                <label for="variation-images-btn"
                                                    class="flex-1 px-4 py-2 text-gray-500">Choose File</label>
                                                <input type="hidden" name="item_variation_image"
                                                    class="selected-files" id="variation-images">
                                            </div>
                                            <div class="file-preview mt-2 border border-gray-200 rounded-sm p-2 bg-gray-50"
                                                id="variation-images-file-preview-container">
                                                <!-- File preview box -->
                                            </div>
                                            <small class="block mt-1 text-xs text-gray-500">
                                                These images are visible in the product details page gallery. Use
                                                600x600 size images.<br>
                                                click on any image to move it to first position!
                                            </small>

                                        </div>
                                    </div>

                                    <!-- Thumbnail Image -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="thumbnail_image"
                                            class="text-sm font-medium text-gray-900 block mb-2">Thumbnail
                                            Image</label>
                                        <div class="w-full md:w-2/3">
                                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden"
                                                data-type="image" data-multiple="true">
                                                <button type="button" id="variation-thumb-images-btn" data-open-modal
                                                    data-input-id="variation-thumb-images"
                                                    data-preview-id="variation-thumb-images-file-preview-container"
                                                    data-multiple-files="false"
                                                    class="px-4 py-2 bg-gray-100 text-gray-700 font-medium hover:bg-gray-200">
                                                    Browse
                                                </button>
                                                <label for="variation-thumb-images-btn"
                                                    class="flex-1 px-4 py-2 text-gray-500">Choose File</label>
                                                <input type="hidden" name="thumbnail_image" class="selected-files"
                                                    id="variation-thumb-images">
                                            </div>
                                            <div class="file-preview mt-2 border border-gray-200 rounded-sm p-2 bg-gray-50"
                                                id="variation-thumb-images-file-preview-container">
                                                <!-- File preview box -->
                                            </div>
                                            <small class="block mt-1 text-xs text-gray-500">
                                                This image will appear over variation dropdown on product page.
                                                Selecting it on front will select current variation value. Use 600x600
                                                size images.

                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <!-- Uploaded Images Display -->
                                        <div class="mb-6 flex items-center w-full" id="uploadedImages">
                                            @foreach ($images as $image)
                                                <div class="w-48 mx-4">
                                                    <div class="card text-white bg-secondary mb-3">
                                                        <div class="card-body relative">
                                                            <img src="{{ $image->src }}"
                                                                class="card-img-top object-contain hover:object-scale-down w-48 clickable-image"
                                                                alt="{{ $product->name }}"
                                                                data-id="{{ $image->id }}">

                                                            <a href="{{ route('delete-variation-image', $image->id) }}"
                                                                class="absolute top-3 right-3 px-1 py-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                                <svg class="h-5 w-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <p style="font: 5px"><b>{{ $image->id }}</b></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <!-- Thumbnail Display -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <div class="mb-6 flex items-center w-full" id="uploadedThumbnail">
                                            @if (!empty($thumbnail))
                                                <div class="w-48 pr-4 mx-4">
                                                    <div class="card text-white bg-secondary mb-3">
                                                        <div class="card-body relative">
                                                            <img src="{{ $thumbnail->src }}"
                                                                class="card-img-top object-contain hover:object-scale-down w-48"
                                                                alt="{{ $product->name }}">

                                                            <a href="#"
                                                                class="absolute top-3 right-3 px-1 py-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                                <svg class="h-5 w-5" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-start mt-4">
                                <button type="submit" id="editVariationBtn"
                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('components.file-management-modal')


    <script>
        $(document).ready(function() {
            $('.clickable-image').on('click', function() {
                const imageId = $(this).data('id');

                // Send GET request to the update route
                $.ajax({
                    url: `/update-variation-image/${imageId}`,
                    method: 'GET',
                    success: function(response) {
                        // Optional: Refresh the page or update the UI dynamically
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating image:', error);
                        alert('Failed to update image.');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formElement = document.querySelector("#upload_form_edit");

            formElement.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent default form submission

                $("#editVariationBtn").html(
                    '<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg> Loading...'
                );
                $("#editVariationBtn").attr("disabled", true);
                $("#editVariationBtn").attr("class",
                    "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                );

                const formData = new FormData(this);

                const csrfToken = '{{ csrf_token() }}';
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }

                // Submit the form data using fetch
                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        return response.json().then(data => {
                            if (!response.ok) { // If the response status is not 2xx
                                throw new Error(data.message || 'Something went wrong');
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        console.log('Success:', data);
                        createSweetAlert(data.message, 'success');

                        // Update images only if there are any new images in the response
                        let images = data.images;
                        if (images && images.length > 0) {
                            // Clear the existing content and update with new images
                            document.getElementById("uploadedImages").innerHTML = '';
                            images.forEach(image => {
                                document.getElementById("uploadedImages").innerHTML += `
                                    <div class="w-48 pr-4">
                                        <div class="card text-white bg-secondary mb-3">
                                            <div class="card-body">
                                                <img src="${image.src}" class="card-img-top object-contain hover:object-scale-down w-48" alt="">
                                            </div>
                                        </div>
                                    </div>`;
                            });
                        }


                        // Update thumbnail image only if there is a new thumbnail in the response
                        let thumbnail = data.thumbnail;
                        if (thumbnail) {
                            // Clear the existing content and update with new thumbnail
                            document.getElementById("uploadedThumbnail").innerHTML = '';
                            document.getElementById("uploadedThumbnail").innerHTML += `
                                <div class="w-48 pr-4">
                                    <div class="card text-white bg-secondary mb-3">
                                        <div class="card-body">
                                            <img src="${thumbnail.src}" class="card-img-top object-contain hover:object-scale-down w-48" alt="">
                                        </div>
                                    </div>
                                </div>`;
                        }

                        $("#editVariationBtn").html('Validate');
                        $("#editVariationBtn").attr("disabled", false);
                        $("#editVariationBtn").attr("class",
                            "text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        );
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        createSweetAlert(error.message, 'danger');

                        $("#editVariationBtn").html('Validate');
                        $("#editVariationBtn").attr("disabled", false);
                        $("#editVariationBtn").attr("class",
                            "text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        );
                    });
            });
        });

        $(document).ready(function() {
            $('select').select2({
                placeholder: "Select an option", // Optional: Customize placeholder
                allowClear: true, // Optional: Allow clearing the selection
                width: '100%' // Ensure the Select2 dropdown fits the container
            });
        });
    </script>
    <style>
        button#close-modal-btn {
            right: 10px;
            top: 0px;
        }
    </style>
</x-app-layout>
