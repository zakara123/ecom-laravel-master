<link href="{{url('dist/jquery.dataTables.min.css')}}" rel="stylesheet">
<style>
    .dataTables_length {
        display: none;
    }

    .dataTables_info {
        display: none;
    }
</style>
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
                                  aria-current="page">Pages</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="grid grid-cols-2 gap-2">
                <div class="w-full">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
                        Displaying all <span id="total_displayd">{{$pages->total()}}</span> pages
                    </h1>
                </div>
                <div class="w-full flex gap-4">
                    <a href="{{ route('page.create')}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add Page
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

    <div class="flex flex-col relative" id="item_field">
        <div class="bg-gray-100">
            <div class="align-middle inline-block relative bg-gray-100 overflow-x-auto max-w-full">
                <div class="shadow" id="over_flowing">
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                                Title
                            </th>
                            <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                                Slug
                            </th>
                            <th scope="col" class="p-4 w-40 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pages as $page)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $page->title }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $page->slug }}
                                </td>
                                <td class="p-4  space-x-2 flex gap-3">
                                    <a href="{{ route('page.view', ['slug' => $page->slug]) }}" target="_blank"
                                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        Show
                                    </a>
                                    <a href="{{ route('page.edit', $page->id) }}"
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
                                        Edit item
                                    </a>
                                    <form action="{{ route('page.destroy',$page->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                          style="margin:0">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <button type="submit"
                                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                            Delete Item
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $pages->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="{{url('dist/jquery.dataTables.min.js')}}"></script>
<script src="{{url('dist/filterDropDown.js')}}"></script>

<script type="text/javascript">
    {{--$(document).ready(function () {--}}
    {{--    $('.search_pagination .pagination li a').click(function (e) {--}}
    {{--        e.preventDefault();--}}
    {{--        var actionUrl = $(this).attr('href');--}}
    {{--        // var page_url = '&s=' + $('#search_input').val();--}}
    {{--        var filter_image = $('#filter_image').val();--}}
    {{--        var filter_category = $('#filter_category').val();--}}
    {{--        var sortby = $('.sortby.selected').data('sortby');--}}
    {{--        var orderby = $('.sortby.selected').data('orderby');--}}
    {{--        var page_url = '&s=' + $('#search_input').val() +'&fs=' + filter_image +'&category=' + filter_category;--}}
    {{--        $.ajax({--}}
    {{--            type: "GET",--}}
    {{--            url: actionUrl + page_url,// serializes the form's elements.--}}
    {{--            beforeSend: function () {--}}
    {{--                $('.overlay').removeClass('is-hidden');--}}
    {{--                $('#loader_ajax_filter').removeClass('is-hidden');--}}
    {{--            },--}}
    {{--            success: function (data) {--}}
    {{--                $('#item_field').html(data);--}}
    {{--                let total_p = $('#total_p').val();--}}
    {{--                $('#total_displayd').html(total_p);--}}
    {{--            }, error: function () {--}}
    {{--                console.log('Error');--}}
    {{--            },--}}
    {{--            complete: function () {--}}
    {{--                $('.overlay').addClass('is-hidden');--}}
    {{--                $('#loader_ajax_filter').addClass('is-hidden');--}}
    {{--            }--}}
    {{--        });--}}
    {{--    });--}}

    {{--    /// create datatabale--}}
    {{--    @if(isset($product_stock_from_api->value) && $product_stock_from_api->value == "yes")--}}
    {{--        stock_api = $('#stock_api').DataTable({--}}
    {{--        "language": {search: '', searchPlaceholder: "Search..."},--}}
    {{--        "pageLength": 6,--}}
    {{--        "createdRow": function (row, data, index) {--}}
    {{--            if (data[2] < 0) $(row).css("background-color", "rgb(248 113 113)");--}}
    {{--        },--}}
    {{--        filterDropDown: {--}}
    {{--            columns: [--}}
    {{--                {--}}
    {{--                    idx: 1,--}}
    {{--                    title: "Store"--}}
    {{--                }--}}
    {{--            ],--}}
    {{--            bootstrap: false--}}
    {{--        }--}}
    {{--    });--}}
    {{--    @endif--}}
    {{--        stock_database = $('#stock_database').DataTable({--}}
    {{--        "language": {search: '', searchPlaceholder: "Search..."},--}}
    {{--        "pageLength": 6,--}}
    {{--        "createdRow": function (row, data, index) {--}}
    {{--            if (data[2] < 0) $(row).css("background-color", "rgb(248 113 113)");--}}
    {{--        }--}}
    {{--    });--}}

    {{--});--}}
</script>
