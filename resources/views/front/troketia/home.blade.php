@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
@endphp

@extends('front.troketia.layouts.app')

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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
          integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <style>
        #header_front {
            color: @if (isset($headerMenuColor->header_color))
                {{ $headerMenuColor->header_color }}
            @else
                #fff
        @endif
;

            background-color: @if (isset($headerMenuColor->header_background))
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

            background-color: @if (isset($headerMenuColor->header_menu_background))
                {{ $headerMenuColor->header_menu_background }}
            @else
                #111433
        @endif
;
        }

        .li_level {
            background-color: @if (isset($headerMenuColor->header_menu_background))
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

            background-color: @if (isset($headerMenuColor->header_background_hover))
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

        .page-item {
            width: 22px;
            border-radius: 6px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            gap: 10px;
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

        #no_product {
            min-width: 50vw;
            font-size: 18px;
            padding: 20px;
            font-weight: 600;
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
            font-family: 'Intro', sans-serif !important;
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
    <style>
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
    </style>
    <style>
        :root {
            --expandable-search-size-compact: 2.2em;
            --expandable-search-size-expanded: 10em;
            --expandable-search-radius: 50em;
            --expandable-search-icon-size: 1.2em;
            --expandable-search-btn-padding: 2px;
            --main-text-color: #040606;
            --secondary-color: #f38a73;
            --background-color: #f7f5f1;
            --product-background: #e7ded9;
        }

        a dev h5 {
            color: var(--main-text-color) !important;
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


        * {
            /* font-family: 'Intro', sans-serif !important; */
            /* background-color: var(--background-color); */
            color: var(--main-text-color);
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

        @media (max-widh:500px) {
            #carousel_slid {
                padding-left: .5rem;
                padding-right: .5rem;
            }

            .item_product_filter {
                width: auto;
                margin: 10px auto;
                position: relative;
            }


        }

        .bg-norepeat-contains {
            background-position: center center;
            background-repeat: no-repeat;
            background-size: contain;
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
    </style>

    <style>
        [data-carousel-item] {
            width: 100%;
        }

        .bg-no-repeat {
            background-repeat: no-repeat;
        }

        .bg-cover {
            background-size: cover;
        }

        .bg-center {
            background-position: center;
        }
    </style>
    <style>
        .image-grid1 {
            display: grid;
            grid-template-columns: repeat(var(--num-images, 1), 1fr);
            /* Dynamically sets the number of columns based on the number of images */
            gap: 10px;
            /* Space between images */
            width: 100%;
            margin: auto
        }
        .image-container1 {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif

    @vite(['resources/css/troketia.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
            integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <?php $counter = 1; ?>
    @foreach ($homeComponentName1 as $item)
        <div class="bg-[#f7f5f1]">
            @if ($item->type != 'collection')
                @if ($counter != 1)
                    <h2 style="margin: auto 0;text-align: center;color: #f38a73;padding-top:2rem;padding-bottom:2rem;font-size: 20px;font-weight: bold;">
                        {{ $item->title }} <h2>
                            @endif
                            @if (count($item->slider_items) > 0)
                                <div class="relative overflow-hidden px-5 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12" id="carousel_slid" data-carousel="slide"
                                     data-carousel-interval="@if ($interval_homecarousel) {{ $interval_homecarousel->value }} @endif">
                                    <div
                                        class="carousel-inner relative w-full overflow-hidden overflow-hidden relative h-screen-1_2 sm:h-64 xl:h-80 2xl:h-96">

                                        @for ($i = 1; $i <= count($item->slider_items); $i++)
                                            <!--Slide {{ $i }} -->
                                            <div class="hidden h-full duration-700 ease-linear" data-carousel-item>
                                                <a href="{{ $item->slider_items[$i - 1]->link }}">
                                                    <div class="block h-full w-full mx-auto flex pt-6 md:pt-0 md:items-center bg-no-repeat bg-cover bg-center"
                                                         style="background-image: url('{{ $item->slider_items[$i - 1]->image }}');">
                                                        <div class="container mx-auto">
                                                            <img src="{{ $item->slider_items[$i - 1]->image }}"
                                                                 alt="{{ $item->slider_items[$i - 1]->title }}"
                                                                 class="object-scale-down" style="opacity: 0">
                                                            <div
                                                                class="flex flex-col w-full lg:w-1/2 md:ml-16  items-center md:items-start px-6 tracking-wide">
                                                                <p class="text-black text-2xl my-4">
                                                                    {{ $item->slider_items[$i - 1]->title }}</p>
                                                                @if (!empty($item->slider_items[$i - 1]->description))
                                                                    <p class="text-black text-1xl my-4">
                                                                        {{ $item->slider_items[$i - 1]->description }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endfor
                                        <button type="button"
                                                class=" flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                                                data-carousel-prev>
                                <span
                                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span class="hidden">Previous</span>
                                </span>
                                        </button>
                                        <button type="button"
                                                class=" flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                                                data-carousel-next>
                                <span
                                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="hidden">Next</span>
                                </span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @else
                                <h2 style="margin: auto 0;text-align: center;color: #f38a73;margin-top:2rem;margin-bottom:2rem;font-size: 20px;font-weight: bold;">
                                    {{ $item->title }}<h2>
                                        @if (count($item->slider_items) > 0)
                                            <div class="relative overflow-hidden px-5 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
                                                    <div class="image-grid1" style="--num-images: {{ count($item->slider_items) }};">
                                                    @foreach ($item->slider_items as $image)
                                                        <div class="image-container1">
                                                            <a href="{{ $image->link }}">
                                                                <img src="{{ $image->image }}" alt="" loading="lazy" class="image-item">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                @endif
            @endif
        </div>
            <?php $counter++; ?>
    @endforeach
@endsection

@section('customScript')
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
    </script>
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
        var current_sortable = '';

        function sortFilter(event, sortable, type_sort) {
            current_sortable = sortable + ';' + type_sort;

            update_filter(event, 0);
        }

        function update_filter(event, page) {
            var form = $('#form_filter');
            var actionUrl = $('#url_original').val();
            var search = $('#expandable-search-filter').val();
            var page_url = '';
            if (page != 0) page_url = '?page=' + page + '&token={{ csrf_token() }}';
            if (page != 0 && search != '') page_url += '&search=' + search + '&token={{ csrf_token() }}';
            else if (search != '') page_url = '?search=' + search + '&token={{ csrf_token() }}';
            $('#search').val(search);
            let current_sort_url = '';
            if (page_url == '') current_sort_url = '?sortBy=' + current_sortable;
            else current_sort_url = '&sortBy=' + current_sortable;

            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: actionUrl + page_url + current_sort_url,
                    data: form.serialize(), // serializes the form's elements.
                    beforeSend: function() {
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function(data) {
                        $('.filter_product_ajax').html(data) // show response from the php script.
                    },
                    error: function() {
                        console.log('Error');
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
            $('.accordion__header').click(function() {
                $(this).siblings().toggle('show');
            });
            $(document).on('click', '.filter_product_ajax .pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                update_filter(event, page);
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
            /*
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

                */
        });
    </script>
@endsection
