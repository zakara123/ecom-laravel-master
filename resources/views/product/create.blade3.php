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
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Item</h1>
        </div>
    </x-slot>

    <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" id="error-message-id" role="alert" style="display: none;">
        <span class="font-medium"></span>
    </div>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center min-h-screen bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" id="upload_form_create" action="{{ route('item.index') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name">
                                Name
                            </label>

                            <input required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="text" name="name" placeholder="Name" value="{{old('name')}}">

                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                        <div class="mb-6 mr-2 w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="position">
                                Position
                            </label>

                            <input
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="number" name="position" placeholder="Position" step="1" value="{{old('position')}}">

                            @error('position')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <!-- Visibility -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="display_online">
                                Display this product on Online Shop
                            </label>
                            <select name="display_online" id="display_online"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Display Status" value="{{ old('display_online') }}">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('display_online')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                        class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <!-- VAT -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="vat">
                                VAT
                            </label>
                            <select name="vat" type="text" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                 placeholder="VAT" value="{{old('vat')}}">
                                <option value="VAT Exempt">VAT Exempt</option>
                                <option value="Zero Rated">Zero Rated</option>
                                @foreach($vat_rate_setting as $k => $vtv)
                                    <option value="{{ $vtv }}">{{ $vtv }}</option>
                                @endforeach
                            </select>
                            @error('vat')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        </div>


                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="description">
                                Description
                            </label>
                            <textarea name="description"
                            rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Your description..." > {{old('description')}}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
{{--                        <div class="mb-6">--}}
{{--                            <label for="is_variable_product" class="inline-flex relative items-center cursor-pointer">--}}
{{--                                <input type="checkbox" value="" id="is_variable_product"--}}
{{--                                    name="is_variable_product"--}}
{{--                                    class="sr-only peer">--}}
{{--                                <div--}}
{{--                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">--}}
{{--                                </div>--}}
{{--                                <span class="ml-3 text-sm font-medium text-gray-900 ">Is a Variable Product. Use--}}
{{--                                    Variation Selling Price.</span>--}}
{{--                            </label>--}}
{{--                        </div>--}}

                        <div class="mb-6">
                            <label for="is_rental_product" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="1" id="is_rental_product"
                                    name="is_rental_product"
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 ">Can be Rented</span>
                            </label>
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6 div_price">
                            <!-- Selling Price -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="price">
                                    Selling Price
                                </label>
                                <input name="price" type="number" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Selling Price" value="{{old('price')}}" min="0.10" step="0.01">
                                @error('price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>

                            <!-- Buying Price -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="price_buying">
                                    Buying Price
                                </label>
                                <input name="price_buying" type="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Buying Price" value="{{old('price_buying')}}" step="0.01">
                                @error('price_bying')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>

                            <!-- Unit Label -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="unit">
                                    Unit Selling Label
                                </label>
                                <input name="unit" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Unit Selling Label" value="{{old('unit')}}">
                                @error('unit')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3  md:gap-6"  >
                            <div  class="mb-6 mr-2 w-full" style="display: none;" id="rentalOptions">
                                <label class="block mb-2 text-sm font-medium text-gray-900 " for="rental_price">
                                    Rental Price
                                </label>
                                <input name="rental_price" type="number"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="Rental Price" value="{{ old('rental_price') }}" min="0.10" step="0.01">
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
                                    placeholder="Unit Rental Label" value="{{ old('unit_rental_label') }}">
                                @error('unit_rental_label')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <!-- Supplier -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="supplier">
                                Supplier
                            </label>
                            <select name="supplier" id="supplier"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                 placeholder="Supplier" value="{{old('supplier')}}">
                                 <option value=""></option>
                                 @foreach($supplier as $supp)
                                    <option value="{{$supp->id}}">{{$supp->name}}</option>
                                 @endforeach
                            </select>
                            @error('supplier')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>



                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="category">
                                Category
                            </label>
                            <select name="category[]" id="category" multiple="multiple"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                 placeholder="Category" value="{{old('category')}}">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category}}</option>
                                @endforeach

                            </select>
                            @error('category')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="item_image">
                                Item Image
                            </label>

                            {{-- <div class="flex justify-center items-center w-full">
                                <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                                    </div>
                                    <input id="dropzone-file" type="file" name="item_image[]" accept="image/*" multiple class="hidden" />
                                </label>

                            </div> --}}
                            <input id="filepond" class="filepond" type="file" name="item_image[]" accept="image/*" multiple />
                            @error('item_image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-start mt-4" id='myButton' >
                            <button type="submit"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
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
        }
    });

</script>
    <script>
    function loading(){
        $("#myButton").html('<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg> Loading...');
        $("#myButton").attr("disabled", true);
        $("#myButton").attr("class", "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center");

    }
        tinymce.init({
            selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'table lists link',
            toolbar: 'undo redo | blocks| bold italic | bullist numlist | code | table | link',
            default_link_target: '_blank'
        });
</script>
    <script>
        FilePond.parse(document.body);
    </script>
    <script>
    $(document).ready(function () {
        const inputElement = document.querySelector('.filepond');
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const pond = FilePond.create(inputElement, {

            allowMultiple: true,
            allowFileTypeValidation:true,
            allowFileEncode: true,
            instantUpload: false,
            allowProcess: false,
            allowReorder: true
        });

        $("#upload_form_create").submit(function (e) {
            e.preventDefault();
            var fd = new FormData(this);
            // append files array into the form data
            $("#myButton").html('<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg> Loading...');
            $("#myButton").attr("disabled", true);
            $("#myButton").attr("class", "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center");


            pondFiles = pond.getFiles();
            for (var i = 0; i < pondFiles.length; i++) {
                fd.append('item_image[]', pondFiles[i].file);
            }
            $.ajax({
                    url: "{{ route('item.index') }}",
                    type: 'POST',
                    data: fd,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        //    todo the logic
                        // remove the files from filepond, etc
                        window.location.href = data.reload;
                    },
                    error: function (data) {
                        $('#error-message-id span').html("Error : " + data.responseJSON.message);
                        document.getElementById('error-message-id').style.display = 'block';
                    }
                }
            );
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
    /// is variable product
    select_is_variable_product();
    $("#is_variable_product").click(function() {
        select_is_variable_product();
    });
    function select_is_variable_product() {
            if ($("#is_variable_product").is(':checked')) {
                $(".div_price").hide();
            } else {
                $(".div_price").show(1000);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const isRentalProductCheckbox = document.getElementById('is_rental_product');
            const rentalOptionsDiv = document.getElementById('rentalOptions');
            const rentalOptionLabelDiv = document.getElementById('rentalOptionLabel');


            function toggleRentalOptions() {
                if (isRentalProductCheckbox.checked) {
                    rentalOptionsDiv.style.display = 'block';

                    $('#rental_price').attr('required', true);
                    rentalOptionLabelDiv.style.display = 'block';
                } else {
                    rentalOptionsDiv.style.display = 'none';

                    $('#rental_price').attr('required', false);
                    rentalOptionLabelDiv.style.display = 'none';
                }
            }

            // Initialize the visibility based on the initial state of the checkbox
            toggleRentalOptions();

            // Add event listener for the change event
            isRentalProductCheckbox.addEventListener('change', toggleRentalOptions);
        });

    </script>

</x-app-layout>
