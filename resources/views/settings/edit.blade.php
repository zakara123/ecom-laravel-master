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
                            <a href="{{ url('store') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Stores</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Store</h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center min-h-screen bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white">

                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('stores.update', $store->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name">
                                Name
                            </label>

                            <input required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   type="text" name="name" placeholder="180" value="{{old('name',$store->name)}}">
                            @error('name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- pickup location -->
                        <div class="mb-6">
                            <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="" @if ($store->pickup_location == 'yes') checked
                                       @endif
                                       id="default-toggle" name="pickup_location" class="sr-only peer" required>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</span>
                            </label>
                            @error('pickup_location')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- is default -->
                        <div class="mb-6">
                            <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="" @if ($store->is_default == 'yes') checked
                                       @endif id="default-toggle" name="is_default" class="sr-only peer" required>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</span>
                            </label>
                            @error('is_default')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- vat type -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="vat_type">
                                VAT TYPE
                            </label>

                            <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    type="text" name="vat_type" placeholder="180"
                                    value="{{old('name',$store->vat_type)}}">
                            @error('vat_type')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
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

</x-app-layout>
