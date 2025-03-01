<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (isset($company) && !empty($company))
        @include('meta::manager', [
            'title' => $category_name . ' - ' . @$company->company_name,
            'description' => $category_name . 'of shop ' . @$company->company_name,
            'image' => @$company->logo,
        ])
    @else
        @include('meta::manager', [
            'title' => $category_name . ' - Shop Ecom',
            'description' => 'Shop Ecom Ecommerce',
            'image' => 'front/img/ECOM_L.png',
        ])
    @endif

    <link rel="icon" type="image/png" sizes="32x32" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" href="{{ $shop_favicon }}">

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
        integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <style>
        #header_front {
            color: @if (isset($headerMenuColor->header_color))
                {{ $headerMenuColor->header_color }}
            @else
                #fff
            @endif
            ;

            background-color:@if (isset($headerMenuColor->header_background))
                {{ $headerMenuColor->header_background }}
            @else
                #111433
            @endif
            ;
        }

        .navbardropdown {
            color: @if (isset($headerMenuColor->header_color))
                {{ $headerMenuColor->header_color }}
            @else
                #fff
            @endif
            ;

            background-color:@if (isset($headerMenuColor->header_menu_background))
                {{ $headerMenuColor->header_menu_background }}
            @else
                #111433
            @endif
            ;
        }

        .li_level {

            background-color:@if (isset($headerMenuColor->header_menu_background))
                {{ $headerMenuColor->header_menu_background }}
            @else
                #111433
            @endif
            ;
        }

        .li_level *,
        .li_level button {
            color: @if (isset($headerMenuColor->header_color))
                {{ $headerMenuColor->header_color }}
            @else
                #fff
            @endif
            ;
        }

        .li_level:hover {
            color: @if (isset($headerMenuColor->header_color))
                {{ $headerMenuColor->header_color }}
            @else
                #fff
            @endif
            ;

            background-color:@if (isset($headerMenuColor->header_background_hover))
                {{ $headerMenuColor->header_background_hover }}
            @else
                #111433
            @endif
            ;
        }

        .form-add-to-cart {
            position: relative;
        }

        .btn-add-to-cart {
            position: absolute;
            right: 0;
            width: 24px;
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
        }

        body {
            background: #F7F5F1
        }
    </style>
    <style>
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

        .carousel-inner.h-screen-1_2 {
            height: 50vh;
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

            #owl-demo {
                margin-top: -24%;
                margin-bottom: -20%;
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

    </style>
    @php
        $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?? 'default';
    @endphp
    @if ($theme === 'troketia')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/troketia.css') }}" />
    @else
        <style>
            body {
                background: white !important;
            }
              @font-face {
            font-family: 'IntroRegularAlt';
            src: url('{{ asset('font-intro/intro-regular-alt.otf') }}') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        *,
        body {
            font-family: 'IntroRegularAlt', sans-serif !important;
        }
        </style>
    @endif
</head>

<body
    class=" text-gray-600 work-sans leading-normal text-base tracking-normal"style="display:flex;flex-direction:column;max-width:1800px; margin:auto;min-height:100vh;">
    @include('front.default.layouts.header')
    <div class=""style="flex-grow:1">


        @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
            @if (count($homeCarousels) > 0)
                <div id="owl-demo" class="owl-carousel owl-theme">
                    @for ($i = 1; $i <= count($homeCarousels); $i++)
                        <div class="item">
                            <a href="{{ $homeCarousels[$i - 1]->link }}">
                                <picture class="displays-lg">
                                    <source
                                        srcset="{{ $homeCarousels[$i - 1]->image }} 1x, {{ $homeCarousels[$i - 1]->image }} 2x, {{ $homeCarousels[$i - 1]->image }} 3x"
                                        media="(min-width: 1920px)">
                                    <source
                                        srcset="{{ $homeCarousels[$i - 1]->image }} 1x, {{ $homeCarousels[$i - 1]->image }} 2x,{{ $homeCarousels[$i - 1]->image }} 3x"
                                        media="(min-width: 767px)">
                                    <img src="{{ $homeCarousels[$i - 1]->image }}" class="collection">
                                </picture>
                            </a>


                            <img src="{{ $homeCarousels[$i - 1]->image }}" alt="{{ $homeCarousels[$i - 1]->title }}"
                                class="h-screen w-screen object-scale-down	 displays-sm">
                        </div>
                    @endfor
                </div>
            @endif
        @endif

        <section class=" py-8">
            <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                <nav id="category" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                        <h1
                            class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl ">
                            {{ $category_name }}
                        </h1>

                        <div class="flex items-center" id="store-nav-content">

                            <a class="pl-3 inline-block no-underline hover:text-black" href="javascript:void(0)"
                                data-dropdown-toggle="dropdownDotsNoFilter">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                                </svg>
                            </a>
                            <form class="expandable-search  js-expandable-search" method="get"
                                action="{{ route('category-product', $id) }}">
                                @csrf
                                <label class="sr-only" for="expandable-search">Search</label>

                                <input
                                    class="expandable-search__input js-expandable-search__input  @if (isset($sq) && $sq != '') expandable-search__input--has-content @endif"
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
                        <div
                            class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            Search results for {{ $sq }}
                        </div>
                    @endif


                    @if (count($products) > 0)
                        <div
                            class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
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
                    class="z-50 hidden  divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownMenuIconButton">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconButton">

                            <li>
                                <form class="" method="get" action="{{ route('category-product', $id) }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByPriceAsc"
                                        value="price;ASC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByPriceAsc">Price low to high</button>
                                </form>

                            </li>
                            <li>
                                <form class="" method="get" action="{{ route('category-product', $id) }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByNameAsc"
                                        value="name;ASC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByNameAsc">Name Ascending</button>
                                </form>

                            </li>
                            <li>
                                <form class="" method="get" action="{{ route('category-product', $id) }}">
                                    @csrf
                                    <input class="" type="hidden" name="sortBy" id="sordByNameDESC"
                                        value="name;DESC">
                                    <button type="submit"
                                        class="block px-4 w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        onclick="this.form.submit()" for="sordByNameDESC">Name Descending</button>
                                </form>
                            </li>
                        </ul>
                    </ul>
                </div>
                @foreach ($products as $product)
                    <div class="  w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                        <a href="{{ route('product', ['id' => $product->slug]) }}">
                            <img class="hover:grow hover:shadow-lg"
                                @if (isset($product->product_image) && !empty($product->product_image)) src="{{ $product->product_image->src }}"
                         @else
                            @if (isset($company->logo) && !empty(@$company->logo))
                                src="{{ @$company->logo }}"
                            @else
                                src="{{ url('front/img/ECOM_L.png') }}" @endif
                                @endif style="width: 400px;height: 400px; object-fit: contain">
                        </a>

                        <a href="{{ route('product', ['id' => $product->slug]) }}">
                            <div class="pt-3 flex items-center justify-between cursor-pointer">
                                @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                    @if (!empty($product['product_api']->description))
                                        {{ $product['product_api']->description }}
                                    @else
                                        @if ($product->description)
                                            {!! $product->description !!}
                                        @else
                                            {{ $product->name }}
                                        @endif
                                    @endif
                                @else
                                    <p class="">{{ $product->name }}</p>
                                @endif

                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" onclick="">
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
                            <div class="pt-1 flex text-gray-900">
                                <div class="w-fit mr-2 font-sizes">Rs
                                    {{ number_format($product->product_api->price->current_price, 2, '.', ',') }}</div>
                                <div class="italic w-fit strike font-sizes">Rs
                                    {{ number_format($product->product_api->price->original_price, 2, '.', ',') }}
                                </div>
                            </div>
                        @else
                            <p class="pt-1 text-gray-900">Rs {{ number_format($product->price, 2, '.', ',') }}</p>
                        @endif
                        {{--                    <p class="pt-1 text-gray-900">Rs {{ $product->price }}</p> --}}
                    </div>
                @endforeach
            </div>
        </section>

        <div id="pagination" class="text-center">
            {{ $products->links('pagination::shop_pagination') }}
        </div>
    </div>
    @if ($theme === 'troketia')
        @include('front.troketia.layouts.partial.footer')
    @else
        @include('front.default.layouts.footer')
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
        integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
</body>

</html>
