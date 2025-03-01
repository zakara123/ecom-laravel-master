<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
    <style>
        #summary {
            background-color: #f6f6f6;
        }
    </style>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" href="{{ $shop_favicon }}">

    <link rel="stylesheet" href="{{ url('dist/flowbite.min.css') }}" />

    <link rel="stylesheet" href="{{ url('dist/tailwind.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <script src="{{ url('dist/flowbite.js') }}"></script>
    <link rel="icon" type="image/x-icon"
        href="@if (isset($company->logo) && !empty(@$company->logo)) {{ url(@$company->logo) }}@else{{ url('front/img/ECOM_L.png') }} @endif">
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

        .align-center img {
            margin: auto;
        }

        h1 {
            font-size: 34px;
        }

        h2 {
            font-size: 30px;
        }

        h3 {
            font-size: 24px;
        }

        h4 {
            font-size: 20px;
        }

        .decription menu,
        .decription ol {
            list-style: number !important;
            margin: auto !important;
            padding: auto !important;
            padding-left: 40px !important;
        }

        .decription ul {
            list-style: inherit !important;
            margin: auto !important;
            padding: auto !important;
            display: table !important;
        }

        .decription p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            unicode-bidi: isolate;
        }

        .decription h3 {
            display: block;
            font-size: 1.17em;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }

        .decription h4 {
            display: block;
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }


    </style>
    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif
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

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
    @include('front.default.layouts.header')
    <div class="container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14">
        <div class="text-center text-xl mb-4">{{ $page->title }}</div>
        <div class="text-md min-h-max decription">
            {!! $page->content !!}
        </div>
    </div>

    @if ($theme === 'troketia')
        @include('front.troketia.layouts.partial.footer')
    @else
        @include('front.default.layouts.footer')
    @endif
</body>

</html>
