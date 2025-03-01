@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
@endphp

@extends('front.'.$theme.'.layouts.app')

@section('pageTitle')
    Contact us
@endsection

@section('customStyles')
    <style>
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .custom-number-input input:focus {
            outline: none !important;
        }

        .custom-number-input button:focus {
            outline: none !important;
        }

        .btn_photoswipe_img:hover {
            cursor: pointer;
        }
    </style>
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
    </style>
    <style>
        #cover-item:hover {
            cursor: zoom-in;
        }

        .thumb-image {
            position: relative;
        }

        /* .thumb-image.active::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 19, 23, 0.7) url({{ asset('img/yes.svg') }}) no-repeat center center;
            background-size: 1.25em;
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
        } */

        .object-cover-multiple {
            display: none;
        }

        .object-cover-multiple.active {
            display: block;
        }

        .cover-item img {
            height: 300px;
            object-fit: contain;
        }

        .thumb_div_img img {
            height: 76px;
            object-fit: contain;
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_info {
            display: none;
        }

        .pswp img {
            object-fit: scale-down;
        }

        .product__thumbs.product__thumbs--beside.product__thumbs-placement--left {
            max-width: 80px;
        }

        @media (min-width:767.1px) {
            .hidden_desktop {
                display: none;
            }
        }

        @media (max-width:767px) {
            .my-gallery {
                flex-direction: column-reverse;
                width: 100%;
                flex-wrap: wrap;
            }

            .product__thumbs.product__thumbs--beside.product__thumbs-placement--left {
                max-width: 100%;
            }

            .hidden_mobile {
                display: none;
            }
        }

        .thumb-image:hover,
        .thumb-image.active {
            border: 1px solid #000;
        }

        .slick-prev {
            left: -25px;
        }

        .slick-prev:before {
            content: '<';
            font-size: 2rem;
            z-index: 75;
            color: #000;
        }

        .slick-next {
            right: -25px;
        }

        .slick-next:before {
            content: '>';
            font-size: 2rem;
            z-index: 75;
            color: #000;
        }

        .slick-next,
        .slick-prev {
            width: 40px;
            height: 40px;
        }

        .red-astrik {
            color: red;
            padding-left: 0px;
        }

        body {
            background: white
        }
        .main-page-content div{
            padding: 15px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="main-page-content container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14"style="flex-grow:1; margin-top:-3px;">
            {{-- @if (Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" style="width: 100%;" role="alert">
                    <span class="font-medium">Success : </span> {{ Session::get('success') }}
                </div>
            @endif --}}
            {{-- @if (Session::has('error_message'))
                <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                </div>
            @endif --}}
        
        <form id="your-form-id"  action="{{ route('send-contact-us') }}" method="POST">
            @csrf
            <!-- Stepper Content -->
            <div class="" style="background:#F7F5F1">
                <div class="text-center text-xl mb-4">Contact Us</div>
                <!-- Step 2 -->
            
                <div class="grid gap-4 mb-4 grid-cols-1">
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Name" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="last_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                            <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Email" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="date_of_birth"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Query
                            <span class="text-red-500">*</span></label>
                        <textarea type="date" name="query" id="query"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Query" required></textarea>
                    </div>
                    
                </div>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-gray-300 rounded">Send Message</button>
                    
                </div>

                

            </div>
        </form>
    </div>
@endsection
