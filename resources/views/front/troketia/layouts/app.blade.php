@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $shop_favicon = url('files/logo/ecom-logo.png');
    $company = \App\Models\Company::latest()->first();

    if (\App\Models\Setting::where('key', 'store_favicon')->first()) {
        $shop_favicon_db = \App\Models\Setting::where('key', 'store_favicon')->first();
        $shop_favicon = $shop_favicon_db->value;
    } else {
        if (!empty($company) && !empty(@$company->logo)) {
            $shop_favicon = @$company->logo;
        }
    }
@endphp
@php
    $store_name = \App\Models\Setting::where('key', 'store_name_meta')->first();

@endphp
<!DOCTYPE html>
<html style=" @if ($theme === 'care-connect') background:white; @endif"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Get started with a free and open source Tailwind CSS dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.79.0">
    <title>
        @isset($store_name->value)
            {{ $store_name->value }}
        @else
            {{ @@$company->company_name }}
            @endisset @if (trim($__env->yieldContent('pageTitle')))
                | @yield('pageTitle')
            @endif
        </title>

        <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:image" content="{{ $shop_favicon }}">

        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ route('get-favicon-store-fo') }}">
        <meta property="og:image:type" content="image/png">

        {{-- taken from default page --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/accordion.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/custom-select.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/filter.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/number-input.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/radios-checkboxes.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/read-more.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/responsive-sidebar.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/search-input.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/slider.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/slider-multi-value.css') }}" />
        @if ($theme !== 'care-connect')
            <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/advanced-filter.css') }}" />
            <link rel="stylesheet" type="text/css" href="{{ asset('css/css-advanced-filter/style.min.css') }}" />
        @else
            {{-- new start --}}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css"
                integrity="sha512-yxWNfGm+7EK+hqP2CMJ13hsUNCQfHmOuCuLmOq2+uv/AVQtFAjlAJO8bHzpYGQnBghULqnPuY8NEr7f5exR3Qw=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css"
                integrity="sha512-Rck8F2HFBjAQpszOB9Qy+NVLeIy4vUOMB7xrp46edxB3KXs2RxXRguHfrJqNK+vJ+CkfvcGqAKMJTyWYBiBsGA=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet"
                type="text/css" />

            <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
            <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

            <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" rel="stylesheet">
            {{-- new end --}}
        @endif
        <link rel="stylesheet" href="{{ asset('dist/flowbite.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('dist/tailwind.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('dist/swiper-bundle.min.css') }}" />

        <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">

        <script src="{{ asset('dist/flowbite.js') }}"></script>
        <script src="{{ asset('dist/jquery-3.6.1.min.js') }}"></script>
        <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
        <script defer src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/troketia.css') }}" />

        @if (isset($code_added_header->key))
            {!! $code_added_header->value !!}
        @endif

        @yield('customStyles')
        @if ($theme === 'care-connect')
            {{-- font start --}}
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link
                href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
                rel="stylesheet">

            <style>
                * {
                    font-family: "Inter", serif !important;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    font-family: "Merriweather", serif !important;
                }
            </style>
        @endif
    </head>

    <body
        class="bg-[#f7f5f1] @if ($theme === 'care-connect') container @endif  relative leading-normal text-base tracking-normal"
        style=" @if ($theme !== 'care-connect') max-width:1800px; @endif  margin:auto;display:flex;flex-direction:column;min-height:100vh;"
        x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">

        <div style="background-color: #e9e6e2;display: none;" x-show="loading"
            class="fixed top-0 left-0 w-full h-full z-50 flex items-center justify-center">
            <img src="{{ asset('assets/themes/troketia/images/loading.gif') }}" class="h-20" alt="Loading...">
        </div>

        <div x-show="!loading" style="display: none;">


            @if ($theme === 'care-connect')
                @include('front.care-connect.layouts.partial.header')
            @else
                @include('front.troketia.layouts.partial.header')
            @endif
        </div>

        @if (Session::has('success'))
            <div class="p-4 mb-4 mx-5 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {!! Session::get('success') !!}
            </div>
        @endif
        @if (Session::has('error_message'))
            <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
            </div>
        @endif

        @if ($theme === 'care-connect')
            <div style="background:white;">


                <div style="background: #f6f4f3" class="sm:ml-8 sm:py-2 md:py-3 lg:py-4 mb-8 rounded-l-3xl">
        @endif
        <div x-show="!loading" class="bg-[#f7f5f1]" style="display: none;">
            @yield('content')

        </div>
        @if ($theme === 'care-connect')
            </div>
            </div>
        @endif

        {{-- @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes')) --}}
        {{--    @if (request()->getHost() == 'funkyfish.mu') --}}
        {{--        @include('content.funkyfish') --}}
        {{--    @elseif(request()->getHost() == 'bata.mu') --}}
        {{--        @include('content.bata') --}}
        {{--    @else --}}
        {{--        @include('content.content') --}}
        {{--    @endif --}}
        {{-- @endif --}}

        <!-- Footer start -->
        <div x-show="!loading" style="display: none;">
            @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                @if ($theme === 'care-connect')
                    @include('front.care-connect.layouts.partial.footer')
                @else
                    @include('front.troketia.layouts.partial.footer')
                @endif
            @endif
        </div>
        <!-- Footer end -->

        <div class="overlay is-hidden"></div>

        <script src="{{ asset('dist/util.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/accordion.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/custom-select.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/filter.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/number-input.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/read-more.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/slider.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/slider-multi-value.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/advanced-filter.js') }}"></script>
        <script src="{{ asset('js/js-advanced-filter/responsive-sidebar.js') }}"></script>
        <script src="{{ asset('dist/swiper-bundle.min.js') }}"></script>

        @yield('customScript')

    </body>

    </html>
