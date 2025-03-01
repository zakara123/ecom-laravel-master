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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Header
                                Menu</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Settings Header Menu</h1>
        </div>
    </x-slot>
    <div
        class="p-4  bg-white block {{-- sm:flex --}} items-center  hidden  justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                {{-- <form class="sm:pr-3 mb-4 sm:mb-0" action="#" method="GET">
                    <label for="products-search" class="sr-only">Search</label>
                    <div class="mt-1 relative sm:w-64 xl:w-96">
                        <input type="text" name="email" id="products-search"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Search for items">
                    </div>
                </form> --}}
                <div class="flex items-center sm:justify-end w-full">
                    <div class="hidden md:flex pl-2 space-x-1">
                        {{-- <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                </path>
                            </svg>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-4 grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-8 2xl:col-span-2">

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Header Menu List</span>
                    {{--                    <span class="text-base font-normal text-gray-500">This is a list of latest transactions</span> --}}
                </div>
                <div class="flex-shrink-0">
                    {{--                    <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">View all</a> --}}
                    <a href="{{ route('headermenu.create') }}"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add Menu
                    </a>
                </div>
            </div>

            <div class="flex flex-col mt-8">
                <div class="overflow-x-auto rounded-lg">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden sm:rounded-lg">
                            {{-- <table class="table-fixed min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Menu ID
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Title
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Link
                                    </th>
                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Created_At
                                    </th>

                                    <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($headerMenus as $headerMenu)
                                    <tr class="hover:bg-gray-100">
                                        <td class="p-2  text-center font-medium text-gray-900">
                                            {{ $headerMenu->id }}
                                        </td>
                                        <td class="p-2  text-center font-medium text-gray-900">
                                            {{ $headerMenu->title }}
                                        </td>


                                        <td class="p-2 text-center font-medium text-gray-900">
                                            {{$headerMenu->link }}
                                        </td>

                                        <td class="p-2 text-center font-medium text-gray-900">
                                            {{$headerMenu->created_at }}</td>

                                        <td class="p-2 space-x-2">
                                            <a href="{{ route('headermenu.edit', $headerMenu->id) }}" data-modal-toggle="product-modal"
                                               class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                          d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                                Edit Menu
                                            </a>
                                            <form action="{{ route('headermenu.destroy',$headerMenu->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                    Delete Menu
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table> --}}

                            <ol id="menuContainer" class="dd-list w-full pl-2 connectedSortable">
                                @foreach ($headerMenus as $menu)
                                    <li class="dd-item items-center py-4" data-id="{{ $menu->id }}">
                                        <div class="btn-group ml-auto flex items-center">
                                            <span class="dd-handle">
                                                <i class="fa fa-grip fa-rotate-90"></i>
                                                <span class="title_header_menu">{{ $menu->title }}</span>
                                            </span>
                                            <a href="{{ route('headermenu.edit', $menu->id) }}"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Edit Menu
                                            </a>
                                            <form action="{{ route('headermenu.destroy', $menu->id) }}" method="POST"
                                                onsubmit="return confirm('You will delete, do you confirm?');" style="margin:0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Delete Menu
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-4  ">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Header color</span>
                    {{--                    <h3 class="text-base font-normal text-gray-500">Sales this week</h3> --}}
                </div>
                {{-- <div class="flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                    12.5%
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div> --}}
            </div>
            <div id="main-chart" style="min-height: 435px;">
                <div class="font-sans antialiased">
                    @if (!empty($headerMenuColor) <= 0)
                        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
                            <div class="w-full overflow-hidden bg-white">
                                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                                    <form method="POST" action="{{ route('header-color-create') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Header Background -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_background">
                                                    Header Background
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_background"
                                                    placeholder=" Header Background">
                                                @error('header_background')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Header Menu Background -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_menu_background">
                                                    Header Menu Background
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_menu_background"
                                                    placeholder="Header Menu Background">
                                                @error('header_menu_background')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Menu Item Background Hover -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_background_hover">
                                                    Menu Item Background Hover
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_background_hover"
                                                    placeholder="Menu Item Background Hover">
                                                @error('header_background_hover')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Menu Item Color -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_color">
                                                    Menu Item Color
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_color" placeholder="Menu Item Color">
                                                @error('header_color')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <button type="submit"
                                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
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
                                    <form method="POST"
                                        action="{{ route('header-color-update', $headerMenuColor->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Header Background -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_background">
                                                    Header Background
                                                </label>

                                                <input
                                                    style="background-color: {{ $headerMenuColor->header_background }}"
                                                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_background"
                                                    placeholder=" Header Background"
                                                    value="{{ old('header_background', $headerMenuColor->header_background) }}">
                                                @error('header_background')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Header Menu Background -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_menu_background">
                                                    Header Menu Background
                                                </label>

                                                <input
                                                    style="background-color: {{ $headerMenuColor->header_menu_background }}"
                                                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_menu_background"
                                                    placeholder="Header Menu Background"
                                                    value="{{ old('header_menu_background', $headerMenuColor->header_menu_background) }}">
                                                @error('header_menu_background')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <!-- Menu Item Background Hover -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_background_hover">
                                                    Menu Item Background Hover
                                                </label>

                                                <input
                                                    style="background-color: {{ $headerMenuColor->header_background_hover }}"
                                                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_background_hover"
                                                    placeholder="Menu Item Background Hover"
                                                    value="{{ old('header_background_hover', $headerMenuColor->header_background_hover) }}">
                                                @error('header_background_hover')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- Menu Item Color -->
                                            <div class="mb-6 relative z-0 mb-6 w-full group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="header_color">
                                                    Menu Item Color
                                                </label>

                                                <input style="background-color: {{ $headerMenuColor->header_color }}"
                                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    type="color" name="header_color" placeholder="Menu Item Color"
                                                    value="{{ old('header_color', $headerMenuColor->header_color) }}">
                                                @error('header_color')
                                                    <span class="text-red-600 text-sm">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <button type="submit"
                                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
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
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('menuContainer');
            var sortable = new Sortable(el, {
                onEnd: function(evt) {
                    var order = sortable.toArray(); // Get the order of items
                    // Send order to the server
                    fetch("{{ route('headermenu.updateOrder') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                order: order
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Menu order updated successfully!');
                            } else {
                                alert('Error updating menu order.');
                            }
                        });
                }
            });
        });
    </script>

    <style>
        .dd-item>button {
            left: 1rem;
        }

        .dd-item>button[data-action="collapse"]:before {
            content: '-';
        }

        .dd-item>button:before {
            content: '+';
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0;
        }

        .dd-item>button:before {
            left: 0;
            content: '+';
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0;
        }

        .dd-item>button[data-action="collapse"]:before {
            content: '-';
            left: 0;
        }

        .dd-dragel {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
        }

        .dd-dragel>.dd-item .dd-handle {
            margin-top: 0;
        }

        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
            box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        }

        .btn-group.ml-auto.flex.items-center {
            position: relative;
        }

        .btn-group.ml-auto.flex.items-center a {
            margin: auto 15px;
        }

        .dd-list .btn-group.ml-auto.flex.items-center a {
            position: absolute;
            right: 13.5%;

        }

        .dd-list .btn-group.ml-auto.flex.items-center form {
            position: absolute;
            right: 0;
        }

        .fa.fa-grip:before {
            content: "\f142 \202F \f142 \202F \f142";
        }

        .dd-list {
            width: 100%;
        }

        .dd-item .dd-list {
            padding-left: 1rem;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    {{--    <script src="cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script> --}}
    <script type="text/javascript">
        /*!
         * Nestable jQuery Plugin - Copyright (c) 2012 David Bushell - http://dbushell.com/
         * Dual-licensed under the BSD or MIT licenses
         */
        ;
        (function($, window, document, undefined) {
            var hasTouch = 'ontouchstart' in document;

            /**
             * Detect CSS pointer-events property
             * events are normally disabled on the dragging element to avoid conflicts
             * https://github.com/ausi/Feature-detection-technique-for-pointer-events/blob/master/modernizr-pointerevents.js
             */
            var hasPointerEvents = (function() {
                var el = document.createElement('div'),
                    docEl = document.documentElement;
                if (!('pointerEvents' in el.style)) {
                    return false;
                }
                el.style.pointerEvents = 'auto';
                el.style.pointerEvents = 'x';
                docEl.appendChild(el);
                var supports = window.getComputedStyle && window.getComputedStyle(el, '').pointerEvents ===
                    'auto';
                docEl.removeChild(el);
                return !!supports;
            })();

            var defaults = {
                listNodeName: 'ol',
                itemNodeName: 'li',
                rootClass: 'dd',
                listClass: 'dd-list',
                itemClass: 'dd-item',
                dragClass: 'dd-dragel',
                handleClass: 'dd-handle',
                collapsedClass: 'dd-collapsed',
                placeClass: 'dd-placeholder',
                noDragClass: 'dd-nodrag',
                emptyClass: 'dd-empty',
                expandBtnHTML: '<button data-action="expand" type="button">Expand</button>',
                collapseBtnHTML: '<button data-action="collapse" type="button">Collapse</button>',
                group: 0,
                maxDepth: 5,
                threshold: 20
            };

            function Plugin(element, options) {
                this.w = $(document);
                this.el = $(element);
                this.options = $.extend({}, defaults, options);
                this.init();
            }

            Plugin.prototype = {

                init: function() {
                    var list = this;

                    list.reset();

                    list.el.data('nestable-group', this.options.group);

                    list.placeEl = $('<div class="' + list.options.placeClass + '"/>');

                    $.each(this.el.find(list.options.itemNodeName), function(k, el) {
                        list.setParent($(el));
                    });

                    list.el.on('click', 'button', function(e) {
                        if (list.dragEl) {
                            return;
                        }
                        var target = $(e.currentTarget),
                            action = target.data('action'),
                            item = target.parent(list.options.itemNodeName);
                        if (action === 'collapse') {
                            list.collapseItem(item);
                        }
                        if (action === 'expand') {
                            list.expandItem(item);
                        }
                    });

                    var onStartEvent = function(e) {
                        var handle = $(e.target);
                        if (!handle.hasClass(list.options.handleClass)) {
                            if (handle.closest('.' + list.options.noDragClass).length) {
                                return;
                            }
                            handle = handle.closest('.' + list.options.handleClass);
                        }

                        if (!handle.length || list.dragEl) {
                            return;
                        }

                        list.isTouch = /^touch/.test(e.type);
                        if (list.isTouch && e.touches.length !== 1) {
                            return;
                        }

                        e.preventDefault();
                        list.dragStart(e.touches ? e.touches[0] : e);
                    };

                    var onMoveEvent = function(e) {
                        if (list.dragEl) {
                            e.preventDefault();
                            list.dragMove(e.touches ? e.touches[0] : e);
                        }
                    };

                    var onEndEvent = function(e) {
                        if (list.dragEl) {
                            e.preventDefault();
                            list.dragStop(e.touches ? e.touches[0] : e);
                        }
                    };

                    if (hasTouch) {
                        list.el[0].addEventListener('touchstart', onStartEvent, false);
                        window.addEventListener('touchmove', onMoveEvent, false);
                        window.addEventListener('touchend', onEndEvent, false);
                        window.addEventListener('touchcancel', onEndEvent, false);
                    }

                    list.el.on('mousedown', onStartEvent);
                    list.w.on('mousemove', onMoveEvent);
                    list.w.on('mouseup', onEndEvent);

                },

                serialize: function() {
                    var data,
                        depth = 0,
                        list = this;
                    step = function(level, depth) {
                        var array = [],
                            items = level.children(list.options.itemNodeName);
                        items.each(function() {
                            var li = $(this),
                                item = $.extend({}, li.data()),
                                sub = li.children(list.options.listNodeName);
                            if (sub.length) {
                                item.children = step(sub, depth + 1);
                            }
                            array.push(item);
                        });
                        return array;
                    };
                    data = step(list.el.find(list.options.listNodeName).first(), depth);
                    return data;
                },

                serialise: function() {
                    return this.serialize();
                },

                reset: function() {
                    this.mouse = {
                        offsetX: 0,
                        offsetY: 0,
                        startX: 0,
                        startY: 0,
                        lastX: 0,
                        lastY: 0,
                        nowX: 0,
                        nowY: 0,
                        distX: 0,
                        distY: 0,
                        dirAx: 0,
                        dirX: 0,
                        dirY: 0,
                        lastDirX: 0,
                        lastDirY: 0,
                        distAxX: 0,
                        distAxY: 0
                    };
                    this.isTouch = false;
                    this.moving = false;
                    this.dragEl = null;
                    this.dragRootEl = null;
                    this.dragDepth = 0;
                    this.hasNewRoot = false;
                    this.pointEl = null;
                },

                expandItem: function(li) {
                    li.removeClass(this.options.collapsedClass);
                    li.children('[data-action="expand"]').hide();
                    li.children('[data-action="collapse"]').show();
                    li.children(this.options.listNodeName).show();
                },

                collapseItem: function(li) {
                    var lists = li.children(this.options.listNodeName);
                    if (lists.length) {
                        li.addClass(this.options.collapsedClass);
                        li.children('[data-action="collapse"]').hide();
                        li.children('[data-action="expand"]').show();
                        li.children(this.options.listNodeName).hide();
                    }
                },

                expandAll: function() {
                    var list = this;
                    list.el.find(list.options.itemNodeName).each(function() {
                        list.expandItem($(this));
                    });
                },

                collapseAll: function() {
                    var list = this;
                    list.el.find(list.options.itemNodeName).each(function() {
                        list.collapseItem($(this));
                    });
                },

                setParent: function(li) {
                    if (li.children(this.options.listNodeName).length) {
                        li.prepend($(this.options.expandBtnHTML));
                        li.prepend($(this.options.collapseBtnHTML));
                    }
                    li.children('[data-action="expand"]').hide();
                },

                unsetParent: function(li) {
                    li.removeClass(this.options.collapsedClass);
                    li.children('[data-action]').remove();
                    li.children(this.options.listNodeName).remove();
                },

                dragStart: function(e) {
                    var mouse = this.mouse,
                        target = $(e.target),
                        dragItem = target.closest(this.options.itemNodeName);

                    this.placeEl.css('height', dragItem.height());

                    mouse.offsetX = e.offsetX !== undefined ? e.offsetX : e.pageX - target.offset().left;
                    mouse.offsetY = e.offsetY !== undefined ? e.offsetY : e.pageY - target.offset().top;
                    mouse.startX = mouse.lastX = e.pageX;
                    mouse.startY = mouse.lastY = e.pageY;

                    this.dragRootEl = this.el;

                    this.dragEl = $(document.createElement(this.options.listNodeName)).addClass(this.options
                        .listClass + ' ' + this.options.dragClass);
                    this.dragEl.css('width', dragItem.width());

                    dragItem.after(this.placeEl);
                    dragItem[0].parentNode.removeChild(dragItem[0]);
                    dragItem.appendTo(this.dragEl);

                    $(document.body).append(this.dragEl);
                    this.dragEl.css({
                        'left': e.pageX - mouse.offsetX,
                        'top': e.pageY - mouse.offsetY
                    });
                    // total depth of dragging item
                    var i, depth,
                        items = this.dragEl.find(this.options.itemNodeName);
                    for (i = 0; i < items.length; i++) {
                        depth = $(items[i]).parents(this.options.listNodeName).length;
                        if (depth > this.dragDepth) {
                            this.dragDepth = depth;
                        }
                    }
                },

                dragStop: function(e) {
                    var el = this.dragEl.children(this.options.itemNodeName).first();
                    el[0].parentNode.removeChild(el[0]);
                    this.placeEl.replaceWith(el);

                    this.dragEl.remove();
                    this.el.trigger('change');
                    if (this.hasNewRoot) {
                        this.dragRootEl.trigger('change');
                    }
                    this.reset();
                },

                dragMove: function(e) {
                    var list, parent, prev, next, depth,
                        opt = this.options,
                        mouse = this.mouse;

                    this.dragEl.css({
                        'left': e.pageX - mouse.offsetX,
                        'top': e.pageY - mouse.offsetY
                    });

                    // mouse position last events
                    mouse.lastX = mouse.nowX;
                    mouse.lastY = mouse.nowY;
                    // mouse position this events
                    mouse.nowX = e.pageX;
                    mouse.nowY = e.pageY;
                    // distance mouse moved between events
                    mouse.distX = mouse.nowX - mouse.lastX;
                    mouse.distY = mouse.nowY - mouse.lastY;
                    // direction mouse was moving
                    mouse.lastDirX = mouse.dirX;
                    mouse.lastDirY = mouse.dirY;
                    // direction mouse is now moving (on both axis)
                    mouse.dirX = mouse.distX === 0 ? 0 : mouse.distX > 0 ? 1 : -1;
                    mouse.dirY = mouse.distY === 0 ? 0 : mouse.distY > 0 ? 1 : -1;
                    // axis mouse is now moving on
                    var newAx = Math.abs(mouse.distX) > Math.abs(mouse.distY) ? 1 : 0;

                    // do nothing on first move
                    if (!mouse.moving) {
                        mouse.dirAx = newAx;
                        mouse.moving = true;
                        return;
                    }

                    // calc distance moved on this axis (and direction)
                    if (mouse.dirAx !== newAx) {
                        mouse.distAxX = 0;
                        mouse.distAxY = 0;
                    } else {
                        mouse.distAxX += Math.abs(mouse.distX);
                        if (mouse.dirX !== 0 && mouse.dirX !== mouse.lastDirX) {
                            mouse.distAxX = 0;
                        }
                        mouse.distAxY += Math.abs(mouse.distY);
                        if (mouse.dirY !== 0 && mouse.dirY !== mouse.lastDirY) {
                            mouse.distAxY = 0;
                        }
                    }
                    mouse.dirAx = newAx;

                    /**
                     * move horizontal
                     */
                    if (mouse.dirAx && mouse.distAxX >= opt.threshold) {
                        // reset move distance on x-axis for new phase
                        mouse.distAxX = 0;
                        prev = this.placeEl.prev(opt.itemNodeName);
                        // increase horizontal level if previous sibling exists and is not collapsed
                        if (mouse.distX > 0 && prev.length && !prev.hasClass(opt.collapsedClass)) {
                            // cannot increase level when item above is collapsed
                            list = prev.find(opt.listNodeName).last();
                            // check if depth limit has reached
                            depth = this.placeEl.parents(opt.listNodeName).length;
                            if (depth + this.dragDepth <= opt.maxDepth) {
                                // create new sub-level if one doesn't exist
                                if (!list.length) {
                                    list = $('<' + opt.listNodeName + '/>').addClass(opt.listClass);
                                    list.append(this.placeEl);
                                    prev.append(list);
                                    this.setParent(prev);
                                } else {
                                    // else append to next level up
                                    list = prev.children(opt.listNodeName).last();
                                    list.append(this.placeEl);
                                }
                            }
                        }
                        // decrease horizontal level
                        if (mouse.distX < 0) {
                            // we can't decrease a level if an item preceeds the current one
                            next = this.placeEl.next(opt.itemNodeName);
                            if (!next.length) {
                                parent = this.placeEl.parent();
                                this.placeEl.closest(opt.itemNodeName).after(this.placeEl);
                                if (!parent.children().length) {
                                    this.unsetParent(parent.parent());
                                }
                            }
                        }
                    }

                    var isEmpty = false;

                    // find list item under cursor
                    if (!hasPointerEvents) {
                        this.dragEl[0].style.visibility = 'hidden';
                    }
                    this.pointEl = $(document.elementFromPoint(e.pageX - document.body.scrollLeft, e.pageY - (
                        window.pageYOffset || document.documentElement.scrollTop)));
                    if (!hasPointerEvents) {
                        this.dragEl[0].style.visibility = 'visible';
                    }
                    if (this.pointEl.hasClass(opt.handleClass)) {
                        this.pointEl = this.pointEl.parent(opt.itemNodeName);
                    }
                    if (this.pointEl.hasClass(opt.emptyClass)) {
                        isEmpty = true;
                    } else if (!this.pointEl.length || !this.pointEl.hasClass(opt.itemClass)) {
                        return;
                    }

                    // find parent list of item under cursor
                    var pointElRoot = this.pointEl.closest('.' + opt.rootClass),
                        isNewRoot = this.dragRootEl.data('nestable-id') !== pointElRoot.data('nestable-id');

                    /**
                     * move vertical
                     */
                    if (!mouse.dirAx || isNewRoot || isEmpty) {
                        // check if groups match if dragging over new root
                        if (isNewRoot && opt.group !== pointElRoot.data('nestable-group')) {
                            return;
                        }
                        // check depth limit
                        depth = this.dragDepth - 1 + this.pointEl.parents(opt.listNodeName).length;
                        if (depth > opt.maxDepth) {
                            return;
                        }
                        var before = e.pageY < (this.pointEl.offset().top + this.pointEl.height() / 2);
                        parent = this.placeEl.parent();
                        // if empty create new list to replace empty placeholder
                        if (isEmpty) {
                            list = $(document.createElement(opt.listNodeName)).addClass(opt.listClass);
                            list.append(this.placeEl);
                            this.pointEl.replaceWith(list);
                        } else if (before) {
                            this.pointEl.before(this.placeEl);
                        } else {
                            this.pointEl.after(this.placeEl);
                        }
                        if (!parent.children().length) {
                            this.unsetParent(parent.parent());
                        }
                        if (!this.dragRootEl.find(opt.itemNodeName).length) {
                            this.dragRootEl.append('<div class="' + opt.emptyClass + '"/>');
                        }
                        // parent root list has changed
                        if (isNewRoot) {
                            this.dragRootEl = pointElRoot;
                            this.hasNewRoot = this.el[0] !== this.dragRootEl[0];
                        }
                    }
                }

            };

            $.fn.nestable = function(params) {
                var lists = this,
                    retval = this;

                lists.each(function() {
                    var plugin = $(this).data("nestable");

                    if (!plugin) {
                        $(this).data("nestable", new Plugin(this, params));
                        $(this).data("nestable-id", new Date().getTime());
                    } else {
                        if (typeof params === 'string' && typeof plugin[params] === 'function') {
                            retval = plugin[params]();
                        }
                    }
                });

                return retval || lists;
            };

        })(window.jQuery || window.Zepto, window, document);
    </script>
    <script type="text/javascript">
        $(".dd").each(function() {
            let id = $(this).attr('id');
            $(this).nestable({
                maxDepth: 3,
                group: 0
            }).on('change', updateOutput);
        });

        function updateOrderJson(data, id_parent) {
            $.ajax({
                url: "{{ route('headermenu-position-update') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'json': JSON.stringify(data),
                    'id_parent': id_parent
                },
                success: function(data) {

                }
            })
        }

        function updateOutput(e, arg1) {
            var list = e.length ? e : $(e.target);
            // var output = $('.dd').nestable('serialize');
            let id_parent = $(list).data('id_parent');
            console.log("cddd", output);
            // updateOrderJson(list.nestable('serialize'),id_parent);
        }
    </script>
</x-app-layout>
