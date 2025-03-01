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
                            <a href="{{ url('page') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Pages</a>
                               
                                    
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-4/5">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Page</h1>
                    
                </div>
                <a href="{{ route('page.view', ['slug' => $page->slug]) }}" target="_blank"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Show
                    </a>
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
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form id="upload_form" method="POST" action="{{ route('page.update',$page->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="name">
                                Title
                            </label>

                            <input required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                   type="text" name="title" placeholder="Title"
                                   value="{{ old('title', $page->title) }}">
                            @error('title')
                            <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="description">
                                Description
                            </label>
                            <textarea name="content" rows="4"
                                      class="ckEditorBlock block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                                      placeholder="Your description..."> {{ old('content', $page->content) }}</textarea>
                            @error('content')
                            <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
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
</x-app-layout>
