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
                            <a href="{{ url('attribute') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Attribute</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Attribute</h1>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if(Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <span class="font-medium">Success : </span> {{ Session::get('success')}}
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
            </div>
            @endif

        </div>
    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white">

                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('attribute.update', $attribute->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @csrf
                        <!-- Attribute Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="attribute_name">
                                Attribute Name
                            </label>

                            <input required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="attribute_name" placeholder="Attribute Name" value="{{old('attribute_name',$attribute->attribute_name)}}">
                            @error('attribute_name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Attribute Type -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="attribute_type">
                                Attribute Type
                            </label>
                            <select name="attribute_type" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Attribute Type" value="{{old('attribute_type',$attribute->attribute_type)}}">
                                <option value="variation">Variation</option>
                                <option value="specs">Specs</option>
                            </select>
                            @error('attribute_type')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Attribute Values -->
                        {{-- <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="attribute_value">
                                Attribute Values
                                <br>
                                <small>If you need a multiple value, just separate with ","</small>
                            </label>

                            <input class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="attribute_value" placeholder="Attribute Values" value="{{old('attribute_value',$attribute->attribute_value)}}">
                            @error('attribute_value')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div> --}}


                        <!-- Visibility -->


                        <!--<div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="visibility">
                                Value Definition
                            </label>
                            <select name="visibility" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Value Definition" value="{{old('visibility',$attribute->visibility)}}">
                                <option value="Global">Applies new variation value to all items</option>
                                <option value="Defined at product Level">Defined at product Level</option>
                            </select>
                            @error('attribute_type')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>-->
                            <div class="mt-4">
                                <label for="active_filter" class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" id="active_filter" value="1" @if ($attribute->active_filter) checked @endif name="active_filter"  class="sr-only peer" >
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <br>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Active filter</span>
                                </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-semibold rounded-md text-sky-100 bg-sky-500 hover:bg-sky-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">
                                Update
                            </button>
                        </div>
                    </form>


                        <!-- Attribute Values -->
                        <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700" for="attribute_value">
                                Attribute Values Table
                                <br>
                                <small>You can manage Variation Values here : </small>
                            </label>
                            <div class="flex flex-col">
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <form action="{{ route('attributeValue.index') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="attribute_id" value="{{ $attribute->id }}" />
                                            <table class="min-w-full">
                                                <thead class="border-b">
                                                    <tr>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                            ID
                                                        </th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                            Variation Value
                                                        </th>
                                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attr_value as $a)
                                                    <tr class="border-b">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $a->id }}</td>
                                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                           {{ $a->attribute_values }}
                                                        </td>
                                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            <a href="{{ route('attributeValue.edit',$a->id) }}" class="btn-copy-code text-blue-500 bg-transparent border border-solid border-blue-500 active:bg-blue-600 font-bold uppercase text-sm px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Edit</button>
                                                            <a href="{{ route('delete-attribute-value',$a->id) }}" onclick="return confirm('{{ trans('You will delete, do you confirm?') }}');" class="btn-copy-code text-red-600 bg-transparent border border-solid border-red-600 active:bg-red-600 font-bold uppercase text-sm px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="bg-white border-b">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">--</td>
                                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            <input type="text" id="attribute_value" name="attribute_value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Attribute Value" required>
                                                        </td>
                                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                            <button class="btn-copy-code text-green-600 bg-transparent border border-solid border-green-600 active:bg-green-600 font-bold uppercase text-sm px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Add</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
