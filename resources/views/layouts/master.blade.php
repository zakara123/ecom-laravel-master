<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $store_name = \App\Models\Setting::where("key", "store_name_meta")->first();
        
    @endphp
    <title>@isset($store_name->value) {{ $store_name->value }} @else {{ @@$company->company_name }} @endisset @if(trim($__env->yieldContent('pageTitle'))) | @yield('pageTitle') @endif</title>

    <!-- include jQuery library -->
    <script src="{{url('dist/jquery.js')}}"></script>

    <!-- include FilePond library -->
    <script src="{{url('dist/filepond.min.js')}}"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
</head>
<body>

    <div id="app">

    <div class="py-4">
        @yield('content')
    </div>

    </div>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
