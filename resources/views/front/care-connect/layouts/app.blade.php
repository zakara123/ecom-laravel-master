@php
    $shop_favicon = url('files/logo/ecom-logo.png');
    $company = \App\Models\Company::latest()->first();
    $store_name = \App\Models\Setting::where('key', 'store_name_meta')->first();
    if (\App\Models\Setting::where('key', 'store_favicon')->first()) {
        $shop_favicon_db = \App\Models\Setting::where('key', 'store_favicon')->first();
        $shop_favicon = $shop_favicon_db->value;
    } else {
        if (!empty($company) && !empty(@$company->logo)) {
            $shop_favicon = @$company->logo;
        }
    }
@endphp

<!DOCTYPE html>
<html style=" @if ($theme === 'care-connect') background:white; @endif"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Gourishankar.me">
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

        {{--    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet"> --}}
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Merriweather:wght@400;700&display=swap"
            rel="stylesheet">

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        <meta name="twitter:image" content="{{ $shop_favicon }}">

        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ route('get-favicon-store-fo') }}">
        <meta property="og:image:type" content="image/png">

        <link rel="stylesheet" href="{{ asset('dist/flowbite.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('dist/tailwind.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('dist/swiper-bundle.min.css') }}" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">

        <script src="{{ asset('dist/flowbite.js') }}"></script>
        <script src="{{ asset('dist/jquery-3.6.1.min.js') }}"></script>
        <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
        <script defer src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="{{ asset('assets/front/care-connect/css/style.css') }}" />
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="{{ asset('assets/front/care-connect/js/script.js') }}"></script>

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
        style="margin:auto;display:flex;flex-direction:column;min-height:100vh;" x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 1000)">

        <div style="display: none;" x-show="loading"
            class="fixed top-0 left-0 w-full h-full z-50 flex items-center justify-center bg-white">
            <img src="{{ asset('files/logo/loading.gif') }}" class="h-20" alt="Loading...">
        </div>

        @include('front.care-connect.layouts.partial.header')

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

        <!-- Main content start -->
        {{-- @if ($theme === 'care-connect')
            <div style="background:white;">
                <div id="bg-main-container" style="background: #f6f4f3" class="sm:mx-8 mb-8 py-4 rounded-l-3xl">
        @endif --}}
        @yield('content')

        {{-- @if ($theme === 'care-connect')
            </div>
            </div>
        @endif --}}
        <!-- Main content end -->

        @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
            @if (request()->getHost() == 'funkyfish.mu')
                @include('content.funkyfish')
            @elseif(request()->getHost() == 'bata.mu')
                @include('content.bata')
            @else
                @include('content.content')
            @endif
        @endif

        <!-- Footer start -->
        @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
            @include('front.care-connect.layouts.partial.footer')
        @endif
        <!-- Footer end -->

        <div class="overlay is-hidden"></div>

        <script src="{{ asset('dist/util.js') }}"></script>

        @yield('customScript')

    </body>

    </html>
