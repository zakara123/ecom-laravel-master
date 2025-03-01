home page code 

@extends('front.default.layouts.app')

@section('customStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
        integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />

    <style>
        body {
            background: white !important;
        }

        ul .active,
        ul .disabled {
            cursor: default;
        }

        #pagination span {
            color: #6b7280;
            height: 40px;
        }

        #pagination a {
            color: #1f2937;
            height: 40px;
        }

        #pagination ul {
            justify-content: center;
            display: flex;
            flex-direction: row;
            /*gap: 20px;*/
        }

        #pagination .active a {
            --tw-text-opacity: 1;
            color: rgb(28 100 242/var(--tw-text-opacity));
            background-color: rgb(235 245 255/var(--tw-bg-opacity));
        }

        .radio+label::before,
        .checkbox+label::before {
            margin-right: 0.5rem;
        }

        @media (max-width: 910px) {
            .item_product_filter {
                width: 24rem;
                margin: 10px 0;
                position: relative;
            }

            .sidebar--static .sidebar__header,
            html:not(.js) .sidebar .sidebar__header {
                display: flex;
            }

            #pagination ul {
                flex-wrap: wrap;
                --gap-y: 15px;
            }
        }

        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        .strike {
            text-decoration: none;
            position: relative;
        }

        .strike::before {
            top: 50%;
            /*tweak this to adjust the vertical position if it's off a bit due to your font family */
            background: #000;
            /*this is the color of the line*/
            opacity: .7;
            content: '';
            width: 110%;
            position: absolute;
            height: .1em;
            border-radius: .1em;
            left: -5%;
            white-space: nowrap;
            display: block;
            transform: rotate(-8deg);
        }

        .strike.straight::before {
            transform: rotate(0deg);
            left: -1%;
            width: 102%;
        }

        :root {
            --expandable-search-size-compact: 2.2em;
            --expandable-search-size-expanded: 10em;
            --expandable-search-radius: 50em;
            --expandable-search-icon-size: 1.2em;
            --expandable-search-btn-padding: 2px;
        }

        .expandable-search {
            position: relative;
            display: inline-block;
            user-select: none;
        }

        .expandable-search__input {
            width: var(--expandable-search-size-compact);
            height: var(--expandable-search-size-compact);
            color: rgb(75, 85, 99);
            overflow: hidden;
            border-radius: var(--expandable-search-radius);
            transition: width 0.3s cubic-bezier(0.215, 0.61, 0.355, 1), box-shadow 0.3s, background-color 0.3s;
        }

        .expandable-search__input::-webkit-input-placeholder {
            opacity: 0;
            color: transparent;
        }

        .expandable-search__input::-moz-placeholder {
            opacity: 0;
            color: transparent;
        }

        .expandable-search__input:-ms-input-placeholder {
            opacity: 0;
            color: transparent;
        }

        .expandable-search__input::-ms-input-placeholder {
            opacity: 0;
            color: transparent;
        }

        .expandable-search__input::placeholder {
            opacity: 0;
            color: transparent;
        }

        .expandable-search__input:hover {
            @apply bg-contrast-higher / 10;
            cursor: pointer;
        }

        .expandable-search__input:not(:focus):not(.expandable-search__input--has-content) {
            padding: 0px;
            /* padding = 0 if search is not expanded */
        }

        .expandable-search__input:focus,
        .expandable-search__input.expandable-search__input--has-content {
            @apply bg-floor;
            width: var(--expandable-search-size-expanded);
            padding-top: 0;
            padding-right: calc(var(--expandable-search-btn-padding, 2px) + var(--expandable-search-size-compact));
            padding-bottom: 0;
            outline: none;
            box-shadow: 0 0.9px 1.5px rgba(0, 0, 0, 0.03), 0 3.1px 5.5px rgba(0, 0, 0, 0.08), 0 14px 25px rgba(0, 0, 0, 0.12), 0 0 0 2px hsl(var(--color-primary));
            @apply text-contrast-higher;
            cursor: auto;
            user-select: auto;
            /* 👇 you can ovveride this padding by using the padding utility classes */
        }

        .expandable-search__input:focus:not([class^=padding-]):not([class*=" padding-"]),
        .expandable-search__input.expandable-search__input--has-content:not([class^=padding-]):not([class*=" padding-"]) {
            @apply pl-3 lg: pl-5;
        }

        .expandable-search__input:focus::-webkit-input-placeholder,
        .expandable-search__input.expandable-search__input--has-content::-webkit-input-placeholder {
            opacity: 1;
            @apply text-contrast-low;
        }

        .expandable-search__input:focus::-moz-placeholder,
        .expandable-search__input.expandable-search__input--has-content::-moz-placeholder {
            opacity: 1;
            @apply text-contrast-low;
        }

        .expandable-search__input:focus:-ms-input-placeholder,
        .expandable-search__input.expandable-search__input--has-content:-ms-input-placeholder {
            opacity: 1;
            @apply text-contrast-low;
        }

        .expandable-search__input:focus::-ms-input-placeholder,
        .expandable-search__input.expandable-search__input--has-content::-ms-input-placeholder {
            opacity: 1;
            @apply text-contrast-low;
        }

        .expandable-search__input:focus::placeholder,
        .expandable-search__input.expandable-search__input--has-content::placeholder {
            opacity: 1;
            @apply text-contrast-low;
        }

        .expandable-search__input:focus+.expandable-search__btn {
            pointer-events: auto;
        }

        .expandable-search__input::-webkit-search-decoration,
        .expandable-search__input::-webkit-search-cancel-button,
        .expandable-search__input::-webkit-search-results-button,
        .expandable-search__input::-webkit-search-results-decoration {
            display: none;
        }

        .expandable-search__btn {
            position: absolute;
            display: flex;
            top: var(--expandable-search-btn-padding, 2px);
            right: var(--expandable-search-btn-padding, 2px);
            width: calc(var(--expandable-search-size-compact) - var(--expandable-search-btn-padding, 2px) * 2);
            height: calc(var(--expandable-search-size-compact) - var(--expandable-search-btn-padding, 2px) * 2);
            border-radius: var(--expandable-search-radius);
            z-index: 1;
            pointer-events: none;
            transition: background-color 0.3s;
        }

        .expandable-search__btn .icon {
            display: block;
            margin: auto;
            height: var(--expandable-search-icon-size);
            width: var(--expandable-search-icon-size);
        }

        .expandable-search__btn:hover {
            @apply bg-contrast-higher / 10;
        }

        .expandable-search__btn:focus {
            outline: none;
            @apply bg-primary / 15;
        }

        @media only screen and (max-width: 320px) {
            .carousel-inner.h-screen-1_2 {
                height: 23vh;
            }

            .collection {
                width: 260px
            }
        }

        @media screen and (max-width: 375px) and (min-width: 321px) {
            .carousel-inner.h-screen-1_2 {
                height: 27vh;
            }

            .collection {
                width: 260px
            }
        }

        @media screen and (max-width: 425px) and (min-width: 376px) {
            .carousel-inner.h-screen-1_2 {
                height: 30vh;
            }

            .collection {
                width: 260px
            }
        }

        @media screen and (max-width: 767px) and (min-width: 426px) {
            .carousel-inner.h-screen-1_2 {
                height: 62vh;
            }

            .collection {
                width: 260px
            }
        }

        @media screen and (min-width: 768px) {
            .carousel-inner.h-screen-1_2 {
                height: 570px;
            }

            .collection {
                width: 365px
            }
        }

        .boost-pfs-filter-option-title-text:before {
            border: 5px solid transparent;
            content: "";
            width: 5px;
            height: 17px;
            display: inline-block;
            margin: 0 10px -2px 0;
            border-top-color: transparent;
            border-bottom-color: #000;
            margin-bottom: 2px;
        }

        .collection {
            width: 407px
        }

        .toggle_class .boost-pfs-filter-option-title-text:before {
            content: "";
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-top-color: transparent;
            border-top-color: #000;
            display: inline-block;
            margin: 0 10px -2px 0;
        }

        .boost-pfs-filter-option-title::after {
            content: "";
            display: table;
            clear: both;
        }

        .boost-pfs-filter-tree-v .boost-pfs-filter-option .boost-pfs-filter-option-title {
            line-height: 20px;
        }

        .adv-filter .sidebar--static {
            width: 15em;
            flex-grow: 0;
        }

        @media screen and (max-width: 500px) and (min-width: 426px) {
            .item_product_filter {
                width: auto;
                margin: 10px auto;
                position: relative;
            }


        }

        .font-sizes {
            font-size: 15px;
        }

        #owl-demo .item img {
            display: block;
            width: 100%;
            height: 80vmin !important;
        }

        .owl-theme .owl-dots {
            position: absolute;
            bottom: 15%;
            width: 100%;
            margin: 0 auto;
        }

        span.img-text:hover {
            color: #fff;
        }

        #owl-demo .owl-nav {

            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }

        #owl-demo .owl-nav .owl-prev {
            position: absolute;
            left: 19px;
            display: block;
            background: #ffffff;
            width: 50px;
            height: 50px;
            color: #ababab;
            font-size: 31px;
            border-radius: 50%;

        }

        #owl-demo .owl-nav .owl-next {
            position: absolute;
            right: 19px;
            display: block;
            background: #ffffff;
            width: 50px;
            height: 50px;
            color: #ababab;
            font-size: 31px;
            border-radius: 50%;

        }

        #owl-demo2 .owl-theme .owl-dots {
            display: none;
        }

        @media only screen and (max-width: 7680px) and (min-width: 767px) {


            .displays-sm {
                display: none !important;
            }

            .displays-lg {
                display: block !important;
            }

        }

        @media only screen and (max-width: 768px) {

            .displays-sm {
                display: block !important;
            }

            .displays-lg {
                display: none !important;
            }

            /*#owl-demo {
                                        margin-top: -24%;
                                        margin-bottom: -20%;
                                    }*/
            #owl-demo .item img {
                height: 50vmin !important;
            }

            #owl-demo .owl-nav .owl-prev {
                position: absolute;
                left: 19px !important;
                display: block;
                background: #ffffff;
                width: 22px !important;
                height: 22px !important;
                color: #ababab;
                font-size: 14px !important;
                border-radius: 50%;

            }

            #owl-demo .owl-nav .owl-next {
                position: absolute;
                right: 19px !important;
                display: block;
                background: #ffffff;
                width: 22px !important;
                height: 22px !important;
                color: #ababab;
                font-size: 14px;
                border-radius: 50%;

            }

            .pagination-size {
                font-size: 8px;
            }
        }

        .product-button {
            margin-bottom: 1px !important;

            min-width: 40%;
            border: 1px solid #a1a4a6;
            background-color: transparent;
            color: #414b56;
            border-radius: 64px;
        }

        .product-button:hover {
            margin-bottom: 1px !important;

            min-width: 40%;
            border: 1px solid #a1a4a6;
            background-color: #414b56;
            color: #fff;
            border-radius: 64px;
        }

        .collection-title {
            text-decoration: none;
            color: #414b56;
        }

        .overlay {
            opacity: 0.5;
            background-color: #000;
            width: 100vw;
            height: 100%;
            z-index: 60;
            position: absolute;
            top: 0;
            left: 0;
        }

        #loader_ajax_filter {
            position: fixed;
            z-index: 100;
            left: 50%;
            top: 50%;
            margin-top: -10vh;
        }
        .bg-color-on-hover {
            background: #f6f6f6;
            padding: 12px 0px 0px 0px;
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

        .menu-item {
            position: relative;
            color:  #031f2b;
            text-decoration: none; /* Remove underline */
        }

        .menu-item::after {
            content: '';
            display: block;
            height: 3px; /* Thickness of the underline */
            background-color: #2A5A56; /* Underline color */
            position: absolute;
            left: 0;
            right: 0;
            bottom: -15px; /* Space between text and underline */
            transform: scaleX(0); /* Initially hidden */
            transition: transform 0.3s ease; /* Smooth transition */
        }

        .menu-item:hover {
            color: #2A5A56; /* Text color on hover */
        }

        .menu-item:hover::after {
            transform: scaleX(1); /* Show underline on hover */
        }

    </style>
@endsection

{{-- Main content --}}
@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.querySelector(".overlay");
            if (overlay && overlay.style.display !== "none") {
                overlay.style.display = "none";
            }
        });
    </script>
    @if (isset($shop_name))
        @include('meta::manager', [
            'title' => $shop_name->value,
            'description' => $shop_description->value,
        ])
    @else
        @if (isset($company) && !empty($company))
            @include('meta::manager', [
                'title' => $company->company_name,
                'description' => 'Shop Ecom Ecommerce',
                'image' => asset($company->logo),
            ])
        @else
            @include('meta::manager', [
                'title' => 'Shop Ecom',
                'description' => 'Shop Ecom Ecommerce',
                'image' => asset('front/img/ECOM_L.png'),
            ])
        @endif
    @endif


    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif


   
    @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
        <section>
            <div class="clearfix mt-4"></div>
        </section>
        <section class="bg-white py-8 overflow-hidden" @if (isset($filtering->value) && $filtering->value == 'yes') hidden @endif style="padding-bottom:50px;margin-top:-80px">
            <div class="container flex items-center flex-wrap  mx-auto pt-4 pb-1">
                
                {{-- <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                        <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                            href="javascript:void(0)">
                            Online Shop
                        </a>

                        <div class="flex items-center" id="store-nav-content">

                            <a class="pl-3 inline-block no-underline hover:text-black" href="javascript:void(0)"
                                data-dropdown-toggle="dropdownDotsNoFilter">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                </svg>
                            </a>
                            <form class="expandable-search  js-expandable-search" method="get"
                                action="{{ route('online_shop') }}">
                                @csrf
                                <label class="sr-only" for="expandable-search">Search</label>

                                <input
                                    class="  @if (isset($sq) && $sq != '') expandable-search__input--has-content @endif"
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
                                            {{ $last }}
                                        @endif of {{ $products_all }}
                                    </span> products
                                    @if (!empty($filter_by))
                                        filtered by
                                        {{ $filter_by }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </nav> --}}
                <nav id="category" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3" >

                        <h1 class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl  " style="margin-top: 12px;margin-bottom:5px">
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
                                    class="  @if (isset($sq) && $sq != '') expandable-search__input--has-content @endif"
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
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-2"  style="margin-top: 10px">
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
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" style="width: 100%;"
                        role="alert">
                        <span class="font-medium">Success : </span> {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" style="width: 100%;" role="alert">
                        <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                    </div>
                @endif

                <div id="dropdownDotsNoFilter"
                    class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
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
                <div class="grid  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3  gap-2 lg:gap-3 w-full relative z-40 "
                    id="no_filter_product_list" style="margin-left: 100px;margin-right:100px;margin-bottom:60px; margin-top:25px">
                    @foreach ($products as $product)
                        <div
                            class="bg-white  bg-contrast-lower min-h-64 flex justify-center items-center relative p-2 item_product_filter bg-color-on-hover">
                            <div class="flex  gap-1.5 lg:gap-2 flex-wrap justify-center bg-color-on-hover" style="height: 408px">
                                <div class="flex flex-col ">

                                    <div class="flex-shrink-0" style="width: 350px">
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
        <div id="pagination" class="text-center" @if (isset($filtering->value) && $filtering->value == 'yes') hidden @endif style="padding-bottom:40px">
            {{ $products->onEachSide(1)->links('pagination::shop_pagination') }}
        </div>

        <section class="adv-filter container relative lg:py-12 js-adv-filter overflow-hidden"
            @if ((isset($filtering->value) && $filtering->value != 'yes') || !isset($filtering->value)) hidden @endif>
            <div class="mx-auto flex items-center flex-wrap md:px-6 lg:px-6 xl:px-6 2xl:px-6 pt-0 pb-4">
                <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                        <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                            href="javascript:void(0)">
                            Store
                        </a>

                        <div class="flex items-center" id="store-nav-content">

                            <a class="pl-3 inline-block no-underline hover:text-black" id="sortByBtn"
                                href="javascript:void(0)" data-dropdown-toggle="dropdownDotsFilter">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                </svg>
                            </a>


                            <form class="expandable-search  js-expandable-search" method="get"
                                action="javascript:void(0)" onsubmit="applyFilter()">

                                @csrf

                                <label class="sr-only" for="expandable-search">Search</label>

                                <input class="expandable-search__input js-expandable-search__input" type="text"
                                    onchange="applyFilter()" name="search" id="expandable-search-filter"
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
                </nav>
                @if ($sq != '' && isset($sq))
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                        Search results for {{ $sq }}
                    </div>
                @endif

                <div id="dropdownDotsFilter"
                    class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                        <li onclick="sortFilter(event,'price','ASC')" class="li_sortby">
                            <a href="javascript:void(0)"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Price
                                low to high</a>
                        </li>
                        <li onclick="sortFilter(event,'name','ASC')" class="li_sortby">
                            <a href="javascript:void(0)"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Name
                                Ascending</a>
                        </li>
                        <li onclick="sortFilter(event,'name','DESC')" class="li_sortby">
                            <a href="javascript:void(0)"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Name
                                Descending</a>
                        </li>
                        @if ($is_api_active)
                            <li onclick="sortFilter(event,'filter_sort','out_of_stock_online')" class="li_sortby">
                                <a href="javascript:void(0)"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Out
                                    of Stock Online</a>
                            </li>
                            <li onclick="sortFilter(event,'filter_sort','in_stock_online')" class="li_sortby">
                                <a href="javascript:void(0)"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">In
                                    Stock Online</a>
                            </li>

                        @endif
                    </ul>
                </div>

                <div class="block z-40 md:px-8 py-1">
                    <div class="mb-5 lg:mb-8 lg:hidden overflow-hidden">
                        <button class="btn btn--subtle w-full max-w-full" aria-controls="filter-panel">Show
                            filters
                        </button>
                    </div>

                    <div class="lg:flex">
                        <aside id="filter-panel" class="sidebar sidebar--static@md js-sidebar sidebar--loaded">
                            <div class="sidebar__panel max-w-full w-full">
                                <header
                                    class="sidebar__header bg-floor py-3 lg:py-5 px-5 lg:px-8 border-b border-contrast-lower z-2">
                                    <h1 class="text-lg lg:text-2xl truncate" id="filter-panel-title">Filters</h1>

                                    <button class="reset sidebar__close-btn js-sidebar__close-btn js-tab-focus">
                                        <svg class="icon w-[16px] h-[16px]" viewBox="0 0 16 16">
                                            <title>Close panel</title>
                                            <g stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                                                <line x1="13.5" y1="2.5" x2="2.5" y2="13.5">
                                                </line>
                                                <line x1="2.5" y1="2.5" x2="13.5" y2="13.5">
                                                </line>
                                            </g>
                                        </svg>
                                    </button>
                                </header>

                                <form class="relative z-1 js-adv-filter__form" id="form_filter">
                                    @csrf
                                    <input type="hidden" name="url" id="url" value="{{ $url }}">
                                    <input type="hidden" name="url_original" id="url_original"
                                        value="{{ $url_origin }}">
                                    <input type="hidden" name="_token" id="url" value="{{ csrf_token() }}">
                                    <input type="hidden" name="search" id="search" value="">
                                    <div class="p-4 lg:p-0 lg:mb-2 ">
                                        <button onclick="applyFilter('reset')"
                                            class="text-sm lg:text-base text-contrast-high underline cursor-pointer mb-1 lg:mb-1 lg:text-xs js-adv-filter__reset"
                                            type="reset">Reset all filters
                                        </button>

                                        <div class="search-input search-input--icon-left lg:text-base hidden">
                                            <input class="search-input__input form-control" onchange="applyFilter('a')"
                                                type="search" name="search_products" id="search-products"
                                                placeholder="Try category 1...">

                                            <button class="search-input__btn">
                                                <svg class="icon" viewBox="0 0 20 20">
                                                    <title>Submit</title>
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2">
                                                        <circle cx="8" cy="8" r="6" />
                                                        <line x1="12.242" y1="12.242" x2="18"
                                                            y2="18" />
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>




                                    
                                    <ul class="accordion " data-animation="on" data-multi-items="on">
                                        @if (count($categories) > 0)
                                            <li class="accordion__item accordion__item--is-open">
                                                <button class="accordion__header py-3 lg:px-2 px-2 lg:px-2 lg:px-2 "
                                                    type="button">
                                                    <div>
                                                        <div class="lg:text-base show_hide_icon toggle_class"><span
                                                                class="boost-pfs-filter-option-title-text js-adv-filter__selection"></span>Categories
                                                        </div>
                                                        <div class="text-sm lg:text-base text-contrast-low">
                                                            <i class="sr-only">Active filters: </i>
                                                            <span class="js-adv-filter__selection hidden">Show/Hide</span>
                                                        </div>
                                                    </div>

                                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden"
                                                        viewBox="0 0 20 20">
                                                        <g class="icon__group" fill="none" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <line x1="3" y1="3" x2="17"
                                                                y2="17" />
                                                            <line x1="17" y1="3" x2="3"
                                                                y2="17" />
                                                        </g>
                                                    </svg>
                                                </button>
                                                <div class="accordion__panel" style="display: none">
                                                    <div class="pt-1 lg:pt-1.5 px-5 lg:px-8 pb-5 lg:pb-8 lg:px-3">
                                                        <div class="adv-filter__checkbox-list flex flex-col gap-1 lg:gap-1.5 js-read-more"
                                                            data-btn-labels="Show More, Show Less" data-ellipsis="off"
                                                            data-btn-class="reset text-sm lg:text-base underline cursor-pointer mt-2 lg:mt-3">
                                                            @php $i=0; @endphp
                                                            <div onclick="applyFilter('b')">
                                                                <input class="checkbox" type="checkbox" name="category[]"
                                                                    value="0" id="checkbox-primary-0">
                                                                <label for="checkbox-primary-0">Uncategorized</label>
                                                            </div>
                                                            @foreach ($categories as $key => $category)
                                                                @if ($i < 4)
                                                                    <div onclick="applyFilter('c')">
                                                                        <input class="checkbox" type="checkbox"
                                                                            name="category[]" value="{{ $category->id }}"
                                                                            id="checkbox-primary-{{ $category->id }}">
                                                                        <label
                                                                            for="checkbox-primary-{{ $category->id }}">{{ $category->category }}</label>
                                                                    </div>
                                                                @endif

                                                                @php $i++; @endphp
                                                            @endforeach

                                                            @if (count($categories) >= 5)
                                                                <div class="js-read-more__content">
                                                                    <div class="flex flex-col gap-1 lg:gap-1.5">
                                                                        @php $j=0; @endphp
                                                                        @foreach ($categories as $key => $category)
                                                                            @if ($j >= 4)
                                                                                <div onclick="applyFilter('d')">
                                                                                    <input class="checkbox"
                                                                                        type="checkbox" name="category[]"
                                                                                        value="{{ $category->id }}"
                                                                                        id="checkbox-primary-{{ $category->id }}">
                                                                                    <label
                                                                                        for="checkbox-primary-{{ $category->id }}">{{ $category->category }}</label>
                                                                                </div>
                                                                            @endif

                                                                            @php $j++; @endphp
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if (count($attributes) > 0)
                                            @php $k=0; @endphp
                                            @foreach ($attributes as $attr)
                                                <li class="accordion__item accordion__item--is-open"
                                                    data-default-text="Show/Hide">
                                                    <button class="accordion__header py-3 lg:px-2 px-2 lg:px-2 lg:px-2"
                                                        type="button">
                                                        <input class="checkbox" type="hidden" name="parent_attributes[]"
                                                            value="{{ $attr->id }}"
                                                            id="attribute-primary-{{ $attr->id }}">
                                                        <div>
                                                            <div class="lg:text-base show_hide_icon toggle_class">
                                                                <div>
                                                                    <span
                                                                        class="boost-pfs-filter-option-title-text js-adv-filter__selection"></span>
                                                                    {{ $attr->attribute_name }}
                                                                </div>
                                                            </div>
                                                            <div class="text-sm lg:text-base text-contrast-low"><i
                                                                    class="sr-only">Active filters: </i>
                                                                <span
                                                                    class="js-adv-filter__selection hidden">Show/Hide</span>
                                                            </div>
                                                        </div>

                                                        <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden"
                                                            viewBox="0 0 20 20">
                                                            <g class="icon__group" fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <line x1="3" y1="3" x2="17"
                                                                    y2="17" />
                                                                <line x1="17" y1="3" x2="3"
                                                                    y2="17" />
                                                            </g>
                                                        </svg>
                                                    </button>

                                                    <div class="accordion__panel" style="display: none">
                                                        <div class="pt-1 lg:pt-1.5 px-5 lg:px-8 pb-5 lg:pb-8 lg:px-3">
                                                            <ul class="adv-filter__radio-list flex flex-column gap-xxxs js-read-more read-more--loaded"
                                                                aria-controls="adv-filter-gallery"
                                                                data-btn-labels="Show More, Show Less" data-ellipsis="off"
                                                                data-btn-class="reset text-sm text-underline cursor-pointer margin-top-xs js-tab-focus">
                                                                @if (count($attr->attributeValues) > 0)
                                                                    @php $i=0; @endphp
                                                                    @foreach ($attr->attributeValues as $key => $attr_value)
                                                                        @if ($i < 4)
                                                                            <li class="filter-item">
                                                                                <input class="checkbox" type="checkbox"
                                                                                    name="attribute_value_ids[]"
                                                                                    id="radio_{{ $key }}_{{ $attr_value->id }}"
                                                                                    value="{{ $attr_value->id }}"
                                                                                    data-filter="">
                                                                                <label
                                                                                    for="radio_{{ $key }}_{{ $attr_value->id }}">{{ $attr_value->attribute_values }}</label>
                                                                            </li>
                                                                        @endif
                                                                        @php $i++; @endphp
                                                                    @endforeach
                                                                    @if (count($attr->attributes_values) >= 5)
                                                                        <div class="js-read-more__content">
                                                                            <div class="flex flex-col gap-1 lg:gap-1.5">
                                                                                @php $j=0; @endphp
                                                                                @foreach ($attr->attributes_values as $key => $attr_value)
                                                                                    @if ($j >= 4)
                                                                                        <li class="filter-item">
                                                                                            <input class="checkbox"
                                                                                                type="checkbox"
                                                                                                name="attribute_value_ids[]"
                                                                                                id="radio_{{ $key }}_{{ $attr_value->id }}"
                                                                                                value="{{ $attr_value->id }}"
                                                                                                data-filter="">
                                                                                            <label
                                                                                                for="radio_{{ $key }}_{{ $attr_value->id }}">{{ $attr_value->attribute_values }}</label>
                                                                                        </li>
                                                                                    @endif
                                                                                    @php $j++; @endphp
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                @php $k++; @endphp
                                            @endforeach
                                        @endif
                                    </ul>
                                </form>
                            </div>
                        </aside>
                        <main class="grow lg:pl-5 sidebar-loaded:show">
                            <div>
                                @if (count($products) > 0)
                                    <div class="filter_product_ajax">
                                        @include('front.filter_listing_ajax')
                                    </div>
                                @endif
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-4 text-gray-900 bg-white font-bold text-lg border-gray-900">
                        @if ($company)
                            @if (isset($company->company_name))
                                {{ @$company->company_name }}
                            @endif
                            @if (isset($company->company_address))
                                <br>
                                {{ $company->company_address }}
                            @endif
                            @if (isset($company->company_phone))
                                <br> Tel :
                                {{ $company->company_phone }}
                            @endif
                            @if (isset($company->whatsapp_number))
                                <br> Whatsapp :
                                {{ $company->whatsapp_number }}
                            @endif
                            @if (isset($company->company_email))
                                <br> Email : <a class="underline"
                                    href="mailto:{{ $company->company_email }}">{{ $company->company_email }}</a>
                            @endif
                            @if (isset($company->brn_number))
                                <br> BRN :
                                {{ $company->brn_number }}
                            @endif
                            @if (isset($company->vat_number))
                                <br> VAT :
                                {{ $company->vat_number }}
                            @endif
                        @else
                            {{ __('Online Shop Disabled.') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
        @if (request()->getHost() == 'funkyfish.mu')
            @include('content.funkyfish')
        @elseif(request()->getHost() == 'bata.mu')
            @include('content.bata')
        @else
            @include('content.content')
        @endif
    @endif

    <div class="overlay is-hidden"></div>

@endsection

@section('customScript')
    @php
        if (!empty($interval_homecarousel->value)) {
            if ($interval_homecarousel->value < 1900) {
                $timmeerr = 2000;
            } else {
                $timmeerr = $interval_homecarousel->value;
            }
        } else {
            $timmeerr = 2000;
        }

    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
        integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        (function() {
            var expandableSearch = document.getElementsByClassName('js-expandable-search');
            if (expandableSearch.length > 0) {
                for (var i = 0; i < expandableSearch.length; i++) {
                    (function(i) { // if user types in search input, keep the input expanded when focus is lost
                        expandableSearch[i].getElementsByClassName('js-expandable-search__input')[0]
                            .addEventListener('input', function(event) {
                                Util.toggleClass(event.target, 'expandable-search__input--has-content',
                                    event.target.value.length > 0);
                            });
                    })(i);
                }
            }
        }());

        var current_sortable = '';

        function sortFilter(event, sortable, type_sort) {
            current_sortable = sortable + ';' + type_sort;
            // update_filter(event, 0);
        }

        function applyFilter(type = 'custom') {
            console.log("type:", type);
            let form = $('#form_filter');
            let actionUrl = $('#url_original').val();
            let search = $('#expandable-search-filter').val();
            let page_url = '';

            let attribute_value_ids = $('input[name="attribute_value_ids[]"]:checked')
                .map(function() {
                    return this.value;
                }).get(); // Get all checked attribute value IDs as an array

            if (search != '') page_url = '?search=' + search + '&token={{ csrf_token() }}';

            $('#search').val(search);

            let current_sort_url = '';
            if (current_sortable !== '') {
                if (page_url === '') current_sort_url = '?sortBy=' + current_sortable;
                else current_sort_url = '&sortBy=' + current_sortable;
            }

            if (attribute_value_ids.length > 0) { // Check if any attribute_value_ids are selected
                if (page_url === '') page_url = '?attribute_value_id[]=' + attribute_value_ids.join(
                    '&attribute_value_id[]=');
                else page_url += '&attribute_value_id[]=' + attribute_value_ids.join('&attribute_value_id[]=');
                page_url += '&token={{ csrf_token() }}';
            }

            let fullUrl = actionUrl + page_url + current_sort_url;
            if (type === 'reset') {
                fullUrl = actionUrl;
            }


            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: fullUrl,
                    data: form.serialize(), // Serializes the form's elements.
                    beforeSend: function() {
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function(data) {
                        $('.filter_product_ajax').html(data); // Show response from the PHP script.
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', status, error);
                    },
                    complete: function() {
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');

                        if ($(window).width() < 992) {
                            $('.adv-filter .sidebar__close-btn.js-sidebar__close-btn').click();
                        }

                        $('html, body').animate({
                            scrollTop: $("#adv-filter-gallery").offset().top
                        }, 850);
                    }
                });
            }, 500);
        }

        $(document).ready(function() {
            // Use event delegation for clicks
            $(document).on('click', '.filter-item', function(e) {
                // let type = $(this).data('type');
                e.preventDefault();
                // Find the checkbox within the clicked item
                let checkbox = $(this).find('input.checkbox');
                // Toggle the checkbox state
                checkbox.prop('checked', !checkbox.prop('checked'));
                applyFilter();
            });

            $('.accordion__header').click(function() {
                $(this).siblings().toggle('show');
            });
            $(document).on('click', '.filter_product_ajax .pagination a', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                // update_filter(event, page);
            });
            $(".li_sortby").click(function() {
                $(".js-adv-filter__results-count").trigger('click');
                $(".js-adv-filter__results-count").trigger('focus');
            });

            $('.show_hide_icon').click(function() {
                $(this).toggleClass('toggle_class');
            });

        });


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
                autoplayTimeout: {{ $timmeerr }},
                animateOut: 'fadeOut',
                responsiveClass: true,
                autoHeight: true,
                loop: true


            });


        });
        $(document).ready(function() {

            $("#owl-demo2").owlCarousel({

                // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                items: 1,
                dots: false,
                itemsDesktop: true,
                itemsDesktopSmall: true,
                itemsTablet: true,
                itemsMobile: true,
                autoplay: true,
                autoplayTimeout: {{ $timmeerr }},
                animateOut: 'fadeOut',
                responsiveClass: true,
                loop: true,
                margin: 10,
                responsive: {
                    0: {
                        items: 1,
                        nav: true,
                        loop: false
                    },
                    600: {
                        items: 2,
                        nav: true,
                        loop: false
                    },
                    1440: {
                        items: 3,
                        nav: false,
                        loop: false
                    }
                }
            });
        });
    </script>
@endsection
