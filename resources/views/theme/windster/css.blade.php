    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('dist/app.css')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('dist/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" href="{{ $shop_favicon }}">
    <link rel="mask-icon" href="{{url('dist/safari-pinned-tab.svg')}}" color="#5bbad5">

    <style>
        #ofBar{
            display: none!important;
            z-index: -1;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="{{url('dist/filepond-plugin-image-preview.min.css')}}" media="all">
    <link rel="stylesheet" type="text/css" href="{{url('dist/filepond.min.css')}}" media="all">
    <link rel="stylesheet" type="text/css" href="{{url('dist/animate.css')}}" media="all">
    <link rel="stylesheet" type="text/css" href="{{url('dist/paddle.css')}}" media="all">
    <link rel="stylesheet" href="{{url('dist/flowbite.min.css')}}" />

    <script src="{{url('dist/jquery-3.6.1.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-file-validate-type.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-image-crop.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-image-resize.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-image-transform.min.js')}}"></script>
    <script src="{{url('dist/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{url('dist/filepond.min.js')}}"></script>
  <link rel="stylesheet" href="{{url('dist/flatpickr.min.css')}}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .overlay {
            opacity: 0.5;
            background-color: #000;
            width: 100vw;
            height: 100%;
            z-index: 60;
            position: fixed;
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
        .is-hidden {
            display: none;
        }
        #header_front {
            color: @if (isset($headerMenuColor->header_color)) {{$headerMenuColor->header_color}} @else #fff @endif;
            background-color:@if (isset($headerMenuColor->header_background)) {{$headerMenuColor->header_background}}@else #111433 @endif;
        }

        .navbardropdown {
            color: @if (isset($headerMenuColor->header_color)) {{$headerMenuColor->header_color}}@else #fff @endif;
            background-color:@if (isset($headerMenuColor->header_menu_background)) {{$headerMenuColor->header_menu_background}}@else #111433 @endif;
        }

        .li_level {
            background-color:@if (isset($headerMenuColor->header_menu_background)) {{$headerMenuColor->header_menu_background}}@else #111433 @endif;
        }

        .li_level *,
        .li_level button {
            color: @if (isset($headerMenuColor->header_color)) {{ $headerMenuColor->header_color}}@else #fff @endif;
        }

        .li_level:hover {
            color: @if (isset($headerMenuColor->header_color)) {{$headerMenuColor->header_color}}@else #fff @endif;
            background-color:@if (isset($headerMenuColor->header_background_hover)) {{$headerMenuColor->header_background_hover}}@else #111433 @endif;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.1.0/styles/overlayscrollbars.min.css" integrity="sha512-SWInhnSfP5LyduITbBbAzzj0LCCw6CBqQIfLMACCnuihNPoTLoOGvT+YVmHsV6ub1VWKrQ2wPhZFmR+c5GZUMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-dropdown {
            @apply absolute block w-auto box-border bg-white border-solid border-2 border-gray-600 z-50 float-left;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            cursor: pointer;
            float: right;
            font-weight: bold;
            height: 40px;
            margin-right: 20px;
            padding-right: 0px;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 45px;
            user-select: none;
            -webkit-user-select: none;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/web/pdf_viewer.min.css" rel="stylesheet">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{url('css/overlayscrollbar/OverlayScrollbars.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/overlayscrollbar/os-theme-round-dark.css')}}" />
    <style>
        .os-scrollbar.os-scrollbar-horizontal {
            visibility: visible!important;
            position: fixed;
        }
        .os-scrollbar.os-scrollbar-horizontal {
            width: 95%;
            left: 16rem !important;
        }
        .os-scrollbar.os-scrollbar-vertical {
            display: none;
        }
        .os-content {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
            --tw-divide-y-reverse: 0;
            border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
            border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
            --tw-divide-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-divide-opacity));
        }

        @media (max-width:1920px) {
            .os-content table {
                width: 110% !important;
            }
        }
        .sortby {
            cursor: pointer;
        }
    </style>
