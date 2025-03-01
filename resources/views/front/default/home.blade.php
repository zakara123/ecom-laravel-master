@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $layout = \App\Services\CommonService::doStringMatch($theme, 'default')
        ? 'front.default.layouts.app'
        : 'front.troketia.layouts.app';
@endphp

@extends('front.' . $theme . '.layouts.app')

@section('pageTitle')
    Privacy Policy
@endsection

<style>
    .bg-color-on-hover {
            background: #f6f6f6;
            /* padding: 3px 6px; */
            padding: 26px;
            border-radius: 20px;
        }



        @media (min-width: 1280px) {
            .xl\:w-1\/3 {
                width: 30.333333% !important;
            }
        }



        @media (min-width: 1024px) {
            .lg\:gap-3 {
                gap: 3.75rem !important;
            }
        }

        @media (min-width: 640px) {
            .sm\:mx-8 {
                margin-left: 0rem !important ;
                margin-right: 0rem !important ;
            }
        }


.card-inner-side{
    width: 350px
}
@media(max-width:768px){
    .card-inner-side{
        width: 100%
    }
}
@media(max-width:500px){
    .shop-search-container{
        justify-content: center!important;
        gap: 15px
    }
}

</style>

@section('content')
    <div class=""style="flex-grow:1">
        <section class=" py-1">
            <div class="container mx-auto flex items-center flex-wrap pt-4">
                <nav id="category" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3 shop-search-container">

                        <h1 class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl ">
                            {{-- {{ $category_name }} --}}
                            Online Shop
                        </h1>

                        <div class="flex items-center" id="store-nav-content">

                            <a class="pl-3 inline-block no-underline hover:text-black" href="javascript:void(0)"
                                data-dropdown-toggle="dropdownDotsNoFilter">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                </svg>
                            </a>
                            <form class="expandable-search  js-expandable-search" method="get"
                                action="{{ route('online_shop') }}">
                                @csrf
                                <label class="sr-only" for="expandable-search">Search</label>

                                <input
                                    class="expandable-search__input js-expandable-search__input  @if (isset($sq) && $sq != '') expandable-search__input--has-content @endif "
                                    type="search" onChange="this.form.submit()" name="search" id="expandable-search"
                                    @if (isset($sq) && $sq != '') value="{{ $sq }}" @endif
                                    placeholder="Search...">

                                <button class="expandable-search__btn">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <title>Search</title>
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <circle cx="10" cy="10" r="8" />
                                            <line x1="16" y1="16" x2="22" y2="22" />
                                        </g>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if ($sq != '' && isset($sq))
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            Search results for {{ $sq }}
                        </div>
                    @endif


                    @if (count($products) > 0)
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <div class="flex items-center justify-between mb-5 relative lg:mb-10">
                                <p class="text-sm lg:text-base"><span class="js-adv-filter__results-count">Displaying
                                        @if ($last != $first)
                                            {{ $first }}-{{ $last }}
                                        @else
                                            {{ $last }} @endif of {{ $products_all }}
                                    </span>
                                    products</p>
                            </div>
                        </div>
                    @endif
                </nav>
                @if (Session::has('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        style="width: 100%;" role="alert">
                        <span class="font-medium">Success : </span> {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                        style="width: 100%;" role="alert">
                        <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                    </div>
                @endif
                <div id="dropdownDotsNoFilter"
                    class="z-50 hidden  divide-y divide-gray-100 rounded-lg bg-white shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconButton">

                            <li>
                                <form class="" method="get" action="{{ route('online_shop') }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByPriceAsc"
                                        value="price;ASC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByPriceAsc">Price low to high
                                    </button>
                                </form>

                            </li>
                            <li>
                                <form class="" method="get" action="{{ route('online_shop') }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByNameAsc"
                                        value="name;ASC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByNameAsc">Name Ascending
                                    </button>
                                </form>

                            </li>
                            <li>
                                <form class="" method="get" action="{{ route('online_shop') }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByNameDESC"
                                        value="name;DESC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByNameDESC">Name Descending
                                    </button>
                                </form>
                            </li>
                            @if ($is_api_active)
                                <li>
                                    <form class="" method="get" action="{{ route('online_shop') }}">
                                        @csrf
                                        <input class="" type="hidden" name="sortBy" id="sordByStockOnlineOut"
                                            value="filter_sort;out_of_stock_online">
                                        <button type="submit"
                                            class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            onclick="this.form.submit()" for="sordByStockOnlineOut">Out of Stock
                                            Online
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form class="" method="get" action="{{ route('online_shop') }}">
                                        @csrf
                                        <input class="" type="hidden" name="sortBy" id="sordByStockOnlineIn"
                                            value="filter_sort;in_stock_online">
                                        <button type="submit"
                                            class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            onclick="this.form.submit()" for="sordByStockOnlineIn">In Stock
                                            Online
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </ul>
                </div>
                <div class="grid  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3  gap-2 lg:gap-3 w-full relative z-40 lg:mx-20"
                    id="no_filter_product_list" style="margin-bottom:60px;">
                    @foreach ($products as $product)
                        <div
                            class="bg-white bg-contrast-lower min-h-64 flex justify-center items-center relative p-2 item_product_filter bg-color-on-hover mb-4">
                            <div class="flex  gap-1.5 lg:gap-2 flex-wrap justify-center bg-color-on-hover" style="height: 420px">
                                <div class="flex flex-col ">

                                    <div class="flex-shrink-0 card-inner-side">
                                        <div style="background: white !important;">
                                            <a href="{{ route('product', ['id' => $product->slug]) }}">
                                                <img class=" h-64 object-scale-down"
                                                    @if (isset($product->product_image) && !empty($product->product_image)) src="{{ $product->product_image->src }}"
                                                     @else
                                                         @if (isset($company->logo) && !empty(@$company->logo))
                                                             src="{{ @$company->logo }}"
                                                     @else
                                                         src="{{ asset('front/img/ECOM_L.png') }}" @endif
                                                    @endif style="width:300px;height:300px">
                                            </a>
                                        </div>

                                        <a href="{{ route('product', ['id' => $product->slug]) }}" >
                                            <div class="pt-3 flex items-center justify-between cursor-pointer " style="background: #f6f6f6">

                                                @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                                    @if (!empty($product['product_api']->description))
                                                        {{ $product['product_api']->description }}
                                                    @else
                                                        {!! $product->description !!}
                                                        {{--                                                        <p class="">  {{ $product->name }}
                                                        </p> --}}
                                                    @endif
                                                @else
                                                    <p class="text-green-800 hover:text-green-400 " style="background: #f6f6f6"> {{ Str::limit($product->name, 60, '...') }} </p>
                                                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" onclick="">
                                        <path
                                            d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z">
                                        </path>
                                        <circle cx="10.5" cy="18.5" r="1.5"></circle>
                                        <circle cx="17.5" cy="18.5" r="1.5"></circle>
                                        </svg>
                                                @endif

                                                <svg class="fill-current hover:text-black"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" onclick="" style='display:none'>
                                                    <path
                                                        d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z">
                                                    </path>
                                                    <circle cx="10.5" cy="18.5" r="1.5"></circle>
                                                    <circle cx="17.5" cy="18.5" r="1.5"></circle>
                                                </svg>
                                            </div>
                                        </a>
                                        @if (isset($product->product_api->price->original_price) &&
                                                isset($product->product_api->price->current_price) &&
                                                $product->product_api->price->current_price != $product->product_api->price->original_price)
                                            <div class="pt-1 flex text-gray-900 ">
                                                <div class="w-fit mr-2 font-sizes">Rs
                                                    {{ number_format($product->product_api->price->current_price, 2, '.', ',') }}
                                                </div>
                                                <div class="italic w-fit strike font-sizes">Rs
                                                    {{ number_format($product->product_api->price->original_price, 2, '.', ',') }}
                                                </div>
                                            </div>
                                        @else
                                            <p class="pt-1 text-gray-900 font-sizes " style="background: #f6f6f6; color:#34d399; font-size:15px">Rs
                                                {{ number_format($product->price, 2, '.', ',') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <div id="pagination" class="text-center pt-5" style="padding-bottom:40px;overflow-x:auto">
            {{ $products->links('pagination::shop_pagination') }}
        </div>
    </div>
@endsection

@section('customScript')
    <script>
        $(document).ready(function() {

            $("#owl-demo").owlCarousel({

                nav: true, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                items: 1,
                itemsDesktop: true,
                itemsDesktopSmall: true,
                itemsTablet: true,
                itemsMobile: true,
                autoplay: true,
                autoplayTimeout: 7000,
                animateOut: 'fadeOut',
                responsiveClass: true,
                autoHeight: true,


            });


        });
    </script>
@endsection
