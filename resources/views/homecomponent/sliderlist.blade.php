@php
function isImage( $url )
{
  $pos = strrpos( $url, ".");
  if ($pos === false)
    return false;
  $ext = strtolower(trim(substr( $url, $pos)));
  $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif"); // this is far from complete but that's always going to be the case...
  if ( in_array($ext, $imgExts) )
    return true;
  return false;
}
@endphp
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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                  aria-current="page">
                                  <a href="{{ url('homepage-components') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">
                                    Homepage Component
                                  </a>
                                </span>
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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                  aria-current="page">Slides</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All HomePage Slides - {{$mainComponent->title}}</h1>
        </div>
    </x-slot>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                <form class="sm:pr-3 mb-4 sm:mb-0" action="#" method="GET">
                    <label for="products-search" class="sr-only">Search</label>
                    <div class="mt-1 relative sm:w-64 xl:w-96">
                        <input type="text" name="email" id="products-search"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                               placeholder="Search for items">
                    </div>
                </form>
                <div class="flex items-center sm:justify-end w-full">
                    
                    <a href=" {{ route('createslider', $id)}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add Slide Image
                    </a>
                    <a href="javascript:void(0)" data-modal-toggle="add-collection-homepage"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center ml-5">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Edit Setting
                    </a>
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
                            Slide ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Image
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Title
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Description
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
                        @foreach ($homeCarousels as $homeCarousel)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $homeCarousel->id }}
                                </td>
                                <td class="p-4  text-center font-medium flex justify-center items-center text-gray-900">
                                    @if(isImage($homeCarousel->image))
                                    <img src="{{ $homeCarousel->image }}" class=" img-responsive" alt="" width="150" height="150">
                                    @else
                                    <video width="150" height="150" controls>
                                        <source src="{{ $homeCarousel->image }}" type="video/mp4">
                                    </video>
                                    @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $homeCarousel->title }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{$homeCarousel->description }}
                                </td>
                                
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $homeCarousel->link }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($homeCarousel->created_at)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('edit_slider', $homeCarousel->id) }}"
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
                                        Edit Slide Image
                                    </a>
                                    <form action="{{ route('destroy_slider',$homeCarousel->id) }}" method="POST"
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
                                            Delete Slide Image
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center">
                        {{ $homeCarousels->links("pagination::tailwind") }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
         id="add-collection-homepage" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        HomePage Slider Setting
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-collection-homepage">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" class="p-5" action="{{ route('update-main-slider',$mainComponent->id) }}" enctype="multipart/form-data">
                    @csrf

                    

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="title">
                            Title
                        </label>
                        <input 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            type="text" name="title" value="{{$mainComponent->title}}">
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="title">
                            Position
                        </label>
                        <input required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            type="number" name="position" value = "{{$mainComponent->position}}">
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="title">
                               Description
                        </label>

                        <textarea 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            type="text" name="description">{{$mainComponent->description}}</textarea>
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
    
</x-app-layout>
