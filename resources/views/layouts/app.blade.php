<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $store_name = \App\Models\Setting::where("key", "store_name_meta")->first();
    
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Get started with a free and open source Tailwind CSS dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.79.0">
    <title>@isset($store_name->value) {{ $store_name->value }} @else {{ @@$company->company_name }} @endisset @if(trim($__env->yieldContent('pageTitle'))) | @yield('pageTitle') @endif</title>

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="Item List - Shop Ecom">
    <meta name="twitter:description" content="Get started with a free and open source Tailwind CSS dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta name="twitter:image" content="{{ $shop_favicon }}">

    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:title" content="Item List - Shop Ecom">
    <meta property="og:description" content="Get started with a free and open source Tailwind CSS dashboard featuring a sidebar layout, advanced charts, and hundreds of components based on Flowbite">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{route('get-favicon-store-fo')}}">
    <meta property="og:image:type" content="image/png">
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ asset('dist/flowbite.min.css') }}"/>

    <script src="{{ asset('dist/flowbite.js') }}"></script>
    <script src="{{ asset('dist/jquery-3.6.1.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script defer src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- For calendar -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @include('theme.windster.css')

    <!--STYLE FOR MAKING PERECT SCROLLBAR ALWAYS VISIBLE-->
    <style>
        .ps__thumb-x {
            /*position: fixed;*/
            background-color: #000;
            border-radius: 5px;
            transition: background-color .2s linear, height .2s ease-in-out;
            -webkit-transition: background-color .2s linear, height .2s ease-in-out;
            height: 20px;
            z-index: 51;
        }

        .ps__rail-x {
            /*position: fixed;*/
            z-index: 51;
        }


    </style>
</head>

<body class="bg-gray-50" cz-shortcut-listen="true">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THQTXJ7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @include('theme.windster.topbar')
    <div class="flex overflow-hidden bg-white pt-16">
        @include('layouts.navigation')

        <div id="main-content" class="h-full w-full pt-6 bg-gray-50 relative overflow-y-auto lg:ml-64">
            <main class="mx-2 my-2">
                <!-- Page Heading -->
                @if (isset($header))
                     {{ $header }}
                @endif

                <div id="alert-Box"></div>

                {{ $slot }}

            </main>
        </div>
        <div class="overlay is-hidden"></div>
        <div id="loader_ajax_filter" class="is-hidden">
            <div role="status">
                <svg aria-hidden="true" class="mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    @include('theme.windster.scripts')

</body>

</html>
