@php
    $selectedAttributesArr = $attributes->pluck('id')->toArray();
    $totalVariations = $variations->toArray();
@endphp

<x-app-layout>
    <x-slot name="header">
        @include('layouts.breadcrumb', ['product' => $product])
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0">
            @include('layouts.alerts')
        </div>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
            <div class="mb-1 w-full">
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                    @if(!empty($allAttributes->toArray()))
                        <span class="font-medium"></span> Create Attribute under items > Attribute to have different Variation Labels/Value/Combinations
                        <a style="margin-top: -10px;" href="{{ route('attribute.index') }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            Manage Attribute
                        </a>
                    @else
                        <span class="font-medium"></span> Create Attribute to assign variation values
                        <a style="float: right;margin-top: -10px;" href="{{ route('attribute.create') }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                            Create Attribute
                        </a>
                    @endif
                        <a style="float: right;margin-top: -10px;" href="{{ route('product-stock', $product->id) }}"
                           class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                            Manage Stock
                        </a>
                        <a style="float: right;margin-top: -10px;" href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                           class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                            Show Item
                        </a>
                </div>
                @if(!empty($allAttributes->toArray()))
                    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        <span class="font-medium"></span> Assign attribute first in order to create variations
                        <a style="margin-top: -10px;" data-modal-toggle="assign-attribute-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
{{--                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>--}}
{{--                            </svg>--}}
                            Assign Attribute
                        </a>
                    </div>

                @endif

                <div class="block sm:flex items-center md:divide-x md:divide-gray-100 mb-4">
                    <form class="sm:pr-3 mb-4 sm:mb-0" action="#" method="GET">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="mt-1 relative sm:w-64 xl:w-96">
                            <input type="text" name="email" id="products-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Search for variation">
                        </div>
                    </form>
                    <div class="flex items-center sm:justify-center w-full">
                        <div class="mt-1">
                            <label for="is_variable_product" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="" id="is_variable_product"
                                       @if ($product->is_variable_product == 'yes') checked @endif name="is_variable_product"
                                       class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 "> Activate Variable Product. <br> Use Variation Selling Price if set.</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center sm:justify-end w-full">
                        <div class="hidden md:flex pl-2 space-x-1">
                            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                    </path>
                                </svg>
                            </a>
                        </div>

                        @if(!empty($selectedAttributesArr))
                        <button data-modal-toggle="add-variation-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center">
                            <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            New Variation
                        </button>
                        @endif

                    </div>
                </div>

            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Variation ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Variation Value
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Selling Price
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Buying Price
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Thumbnail
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($variations as $variation)
                                @include('variation.variation-row', ['variation' => $variation])
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">No Variations found</td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>
                        <div class="row">

                        <div class="col-md-12">

                            {{ $variations->links('pagination::tailwind') }}

                        </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Variation popup -->
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-variation-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">

                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Add Variation
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-variation-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="variation-form" action="{{ route('variation.index') }}" method="POST" enctype="multipart/form-data">

                        <div class="p-6">
                            @csrf
                            <input type="hidden" name="products_id" value="{{ $product->id }}" />
                            <div class="grid grid-cols-2 gap-3 my-2">
                                @foreach ($attributes as $attribute)
                                    <div class="">
                                        <label class="block text-sm font-medium text-gray-700" for="{{ $attribute->attribute_slug }}">
                                            {{ $attribute->attribute_name }} <span class="text-red-500">*</span>
                                        </label>
                                        <select name="{{ $attribute->id }}" required id="{{ $attribute->attribute_slug }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Role">
                                            <option value=""></option>
                                            @foreach ($attribute->attributeValues as $attribute_value)
                                                <option value="{{ $attribute_value->id }}">{{ $attribute_value->attribute_values }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid grid-cols-6 gap-6 mt-2">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price" class="text-sm font-medium text-gray-900 block mb-2">Selling Price</label>
                                    <input type="number" name="price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Selling Price" value="{{ $product->price }}" min="0.10" step="0.01">

                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price_buying" class="text-sm font-medium text-gray-900 block mb-2">Buying Price</label>
                                    <input type="number" name="price_buying" id="price_buying" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" value="{{old('price_buying')}}" placeholder="Buying Price" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-200 rounded-b">
                            <button type="submit" id="createVariationBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Assign Attribute Modal -->
        <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="assign-attribute-modal" aria-hidden="true">
            <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

                <div class="bg-white rounded-lg shadow relative">
                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold">
                            Assign Attributes
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="assign-attribute-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="variation-form" action="{{ route('product_attributes.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <!-- Input Field -->
                        <div class="mt-4 p-6">
                            <!-- this handles the logic of EL-100, if there are variations for a product, than we dont allow user to add / update the attributes,
                            in order to add / edit attributes, than admin needs to remove all variations and than assign attributes feature. -->
                            @if(!empty($totalVariations['total'])) <span class="text-red-400">Adding/Removing attributes is not possible now. <br> Remove all variations linked to product to allow adding/removing attributes.</span> @endif

                            @foreach ($allAttributes as $attribute)
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" id="attribute_{{ $attribute->id }}" name="product_attributes[]" value="{{ $attribute->id }}"
                                           class="h-4 w-4 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500"
                                           @if(in_array($attribute->id, $selectedAttributesArr)) checked @endif
                                           @if(!empty($totalVariations['total'])) disabled="true" @endif
                                    >
                                    <label for="attribute_{{ $attribute->id }}" class="ml-2 block text-sm font-medium text-gray-700">
                                        {{ $attribute->attribute_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>


                        <!-- Submit Button -->
                        <div class="mt-6 p-6">
                            @if(empty($totalVariations['total']))
                            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-lg text-sm px-4 py-2 text-center">
                                Submit
                            </button>
                            @endif
                            <button type="button" data-modal-toggle="assign-attribute-modal"
                                    class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-sm px-4 py-2 text-center">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isVariableProductCheckbox = document.getElementById('is_variable_product');

        isVariableProductCheckbox.addEventListener('change', function() {
            const isVariableProduct = this.checked ? 'yes' : 'no';
            const productId = {{ $product->id }}; // Assuming you have the product ID available

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the product's variable status.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/product/${productId}/update-variable-status`, // Update the endpoint as needed
                        type: 'POST',
                        data: {
                            is_variable_product: isVariableProduct,
                            _token: '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'
                                }
                            });
                        },
                        error: function(error) {
                            isVariableProductCheckbox.checked = !isVariableProductCheckbox.checked;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.responseJSON.message || 'An error occurred',
                                customClass: {
                                    confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
                                }
                            });
                        }
                    });
                } else {
                    // If the user cancels, reset the checkbox to its previous state
                    isVariableProductCheckbox.checked = !isVariableProductCheckbox.checked;
                }
            });
        });

        // handle creation via ajax call
        document.getElementById('variation-form').addEventListener('submit', function(event) {
            event.preventDefault();

            $("#createVariationBtn").html('<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg> Loading...');
            $("#createVariationBtn").attr("disabled", true);
            $("#createVariationBtn").attr("class", "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center");

            let formData = new FormData(this);

            fetch("{{ route('variation.index') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                }
            }).then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            customClass: {
                                confirmButton: 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'
                            }
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An error occurred',
                            customClass: {
                                confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
                            }
                        });
                        $("#createVariationBtn").html('Validate');
                        $("#createVariationBtn").attr("disabled", false);
                        $("#createVariationBtn").attr("class", "text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center");
                    }
                }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
    $(document).ready(function() {
        $('select').select2({
            placeholder: "Select an option", // Optional: Customize placeholder
            allowClear: true,               // Optional: Allow clearing the selection
            width: '100%'                   // Ensure the Select2 dropdown fits the container
        });
    });
</script>
