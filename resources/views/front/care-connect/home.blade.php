@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
@endphp

@extends('front.' . $theme . '.layouts.app')

@section('customStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />

    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif

    @vite(['resources/css/care-connect.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
    {{-- new slider starts here --}}
    <style>
        .carousel-control {
            position: absolute;
            top: 50%;
            z-index: 30;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .carousel-control:hover {
            background-color: rgba(255, 255, 255, 0.7);
        }

        .carousel-control svg {
            width: 1.5rem;
            height: 1.5rem;
            stroke: #000;
        }

        .carousel-control.prev {
            left: 1rem;
        }

        .carousel-control.next {
            right: 1rem;
        }

        .carousel-container {
            position: relative;
            overflow: hidden;
        }

        .bg-teal-500:hover {
            background: #14b8a6 !important;
        }

        #bg-main-container {
            padding: 0 !important;
        }

        .menu-item::after {
            z-index: 100;
        }


    </style>

    <div class=" bg-white carousel-container" style="margin-top: -46px">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative overflow-hidden rounded-lg" style="aspect-ratio: 2;">
                @foreach ($homeComponentName1 as $item)
                    @foreach ($item->slider_items as $index => $sliderItem)
                        <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                            <img src="{{url('temp-images/slider.webp')}}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $sliderItem->title }}">
                            <div class="absolute bottom-20 left-20 text-white">
                                <h2 class="text-lg md:text-2xl  font-bold"
                                    style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                                    {{ $sliderItem->title }}
                                </h2>
                                @if (!empty($sliderItem->description))
                                    <p class="text-sm md:text-lg " style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                                        {{ $sliderItem->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <button class="carousel-control prev" data-carousel-prev>
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
            </button>
            <button class="carousel-control next" data-carousel-next>
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Section 1: Welcome Section -->
    <section class=" py-20 text-center bg-white">
        <h3 class="mt-10 text-sm uppercase tracking-wider font-medium text-gray-500 mb-6">
            Welcome to Care Connect
        </h3>
        <p class="text-2xl md:text-4xl font-semibold text-gray-800 max-w-4xl lg:mx-auto mx-8  leading-relaxed">
            Your trusted one-stop shop for scheduling medical appointments and finding the right medical equipment for purchase or rental.<br />We're here to make your healthcare journey easier!
        </p>
        <div class="flex justify-center mt-6">
            <img src="https://careconnect.living/files/logo/care-connect-ltd-logo-1731177761671.png" alt="Care Connect Logo"
                class="h-12">
        </div>
    </section>


    <!-- Section 2: Areas of Specialty -->
    <section class="py-20 bg-white">
        <h2 class="text-center mx-8 lg:mx-auto text-3xl md:text-4xl font-semibold text-gray-800 mb-12">
            We can help you with the following conditions:
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 " style="margin: 20px">

            <!-- Card 1 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" stroke-width="6" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-8 h-8"
                            viewBox="0 0 256 256" enable-background="new 0 0 256 256" xml:space="preserve">
                            <path
                                d="M220.94,236.761c-0.627,8.306-7.836,14.418-16.142,13.792c-2.664-0.157-4.545-1.097-6.896-2.194
                                                                                                                                                                                                                                        c0,0-42.628-28.993-45.136-31.031c-4.232-3.605-8.463-7.836-10.344-13.948c-0.627-2.194-9.247-31.501-9.247-31.501L129.306,254H42.8
                                                                                                                                                                                                                                        l2.09-33.068H24.411C12.03,220.932,2,210.901,2,198.52c0-2.978,0.47-5.799,1.567-8.306c0,0,23.195-52.032,27.583-60.495
                                                                                                                                                                                                                                        c6.426-12.695,17.71-18.18,33.538-17.71h41.845l-87.608,62.845l-7.836,18.336c-0.784,1.567-1.097,3.448-1.097,5.328
                                                                                                                                                                                                                                        c0,7.836,6.426,14.262,14.262,14.262H97.13c12.381,0,22.411-10.03,22.411-22.411c0-10.971-7.836-20.217-18.18-22.098l21.314-56.577
                                                                                                                                                                                                                                        h5.015c11.754,0,21.001,7.993,23.665,17.083l16.769,60.495c0.313,0.94,1.411,2.821,2.821,3.918
                                                                                                                                                                                                                                        c1.724,1.254,44.195,30.404,44.195,30.404C219.06,226.574,221.411,231.432,220.94,236.761z M92.272,101.666
                                                                                                                                                                                                                                        c18.336,1.411,34.322-12.224,35.733-30.561c1.41-18.336-12.224-34.322-30.561-35.733c-18.336-1.411-34.322,12.224-35.733,30.561
                                                                                                                                                                                                                                        C60.301,84.27,73.935,100.256,92.272,101.666z M111.392,190.214c0-7.366-5.642-13.321-12.695-14.105l-10.344,28.523l8.776-0.157
                                                                                                                                                                                                                                        C104.966,204.476,111.392,198.05,111.392,190.214z M243.174,21.69v-1.586v-4.106h1.493h3.453V2h-3.453h-62.149h-3.453v13.997h3.453
                                                                                                                                                                                                                                        h1.493v4.106v1.586C177.759,22.25,173,27.475,173,33.821v74.614c0,4.759,2.8,8.865,6.719,10.918c1.586,0.84,3.453,1.306,5.412,1.306
                                                                                                                                                                                                                                        h56.736c1.96,0,3.733-0.467,5.412-1.306c4.013-1.96,6.719-6.159,6.719-10.918V33.821C254.092,27.475,249.333,22.25,243.174,21.69z
                                                                                                                                                                                                                                        M192.13,21.596V20.01v-4.013h1.306h40.313h1.306v4.013v1.586v0.093H192.13V21.596z M247.373,108.435
                                                                                                                                                                                                                                        c0,2.986-2.426,5.412-5.412,5.412h-56.737c-2.986,0-5.412-2.426-5.412-5.412v-6.346h67.561V108.435z M232.463,66.903v11.204h-13.269
                                                                                                                                                                                                                                        v13.268h-11.204V78.108h-13.269V66.903h13.269V53.635h11.204v13.268H232.463z M247.467,44.086h-67.655V33.728
                                                                                                                                                                                                                                        c0-2.986,2.426-5.412,5.412-5.412h55.243c0.093,0,0.28,0,0.373,0s0.093,0,0.187,0c0.187,0,0.373,0,0.56,0h0.467
                                                                                                                                                                                                                                        c2.986,0,5.412,2.426,5.412,5.412V44.086z" />
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Stroke Rehabilitation
                    </h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Recovering ability, mobility and more
                    </p>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" stroke-width="3" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-8 h-8"
                            viewBox="0 0 96.911 96.911" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M29.963,3.464l7.35-3.454C34.375,0.068,31.753,1.393,29.963,3.464z" />
                                    <path
                                        d="M42.364,1.262l-8.02,3.77l9.715-2.572C43.537,2.006,42.972,1.602,42.364,1.262z" />
                                    <path
                                        d="M75.58,23.925v-3.021h0.653c1.224,0,2.214-0.991,2.214-2.214V8.035c0-1.222-0.99-2.213-2.214-2.213h-1.745
                                                                                                                                                       c0.019-0.168,0.028-0.344,0.028-0.527c0-0.135-0.011-0.263-0.019-0.39h0.462c1.595,0,2.893-1.298,2.893-2.892h-0.984
                                                                                                                                                       c0,1.052-0.856,1.907-1.907,1.907h-0.654c-0.225-0.637-0.619-1.025-1.104-1.025c-0.486,0-0.879,0.388-1.105,1.025H64.71V0h-2.953
                                                                                                                                                       v3.92H51.575c-1.054,0-1.907-0.855-1.907-1.907h-0.986c0,1.594,1.297,2.892,2.894,2.892h10.181v32.407
                                                                                                                                                       c-6.297-2.289-8.725-5.428-11.274-8.739c-1.763-2.29-5.019-5.784-10.482-8.034l-2.486,2.503l-2.412-2.531
                                                                                                                                                       c-0.006,0.002-0.014,0.003-0.023,0.004c-1.271,0.305-18.672,6.128-16.413,30.672c0.201,1.998,1.888,3.49,3.854,3.49
                                                                                                                                                       c0.127,0,0.259-0.007,0.391-0.021c2.128-0.214,3.681-2.112,3.468-4.241c-0.585-5.861-0.163-9.963,0.922-13.002
                                                                                                                                                       c0,0,0,10.863,0,13.831s0.665,3.626,0.665,3.626l0.004,37c0,2.529,2.051,4.579,4.58,4.579c2.528,0,4.578-2.052,4.578-4.58
                                                                                                                                                       l-0.002-31.842c0.18,0.009,0.362,0.022,0.544,0.022c0.037,0,0.071-0.004,0.107-0.004v31.824c0,2.529,2.049,4.579,4.578,4.579
                                                                                                                                                       c2.529,0,4.58-2.05,4.58-4.579V54.996c0,0,0.797-0.771,0.797-3.75V37.362c2.783,2.922,6.701,5.863,13.436,7.926
                                                                                                                                                       c0.196,0.06,0.393,0.103,0.592,0.13v41.221h-1.836c-3.13,0-5.807,1.95-6.896,4.697C51.857,91.691,51,92.768,51,94.055
                                                                                                                                                       c0,1.577,1.277,2.856,2.854,2.856c1.578,0,2.855-1.279,2.855-2.856c0-0.757-0.3-1.441-0.779-1.953
                                                                                                                                                       c0.728-1.479,2.234-2.511,3.994-2.511h5.598h1.054c1.76,0,3.268,1.031,3.995,2.511c-0.48,0.512-0.78,1.196-0.78,1.953
                                                                                                                                                       c0,1.577,1.277,2.856,2.854,2.856s2.854-1.279,2.854-2.856c0-1.287-0.858-2.363-2.028-2.719c-1.09-2.748-3.767-4.697-6.896-4.697
                                                                                                                                                       h-0.927H64.81h-0.101V44.605c0.592-0.47,1.058-1.11,1.294-1.888c0.173-0.562,0.198-1.132,0.122-1.679
                                                                                                                                                       c2.081,0.439,4.381,1.058,5.354,1.37c0.853,0.28,1.666,0.419,2.411,0.419c0.966,0,1.818-0.233,2.5-0.694
                                                                                                                                                       c1.09-0.735,1.727-2.033,1.837-3.753c0.17-2.399-0.705-4.294-1.549-6.125c-0.46-0.995-0.934-2.024-1.234-3.123
                                                                                                                                                       c-0.372-1.35-0.613-3.641-0.563-5.208L75.58,23.925L75.58,23.925z M73.248,3.87c0.002,0.006,0.014,0.036,0.02,0.05h-0.062
                                                                                                                                                       C73.22,3.906,73.234,3.876,73.248,3.87z M72.898,4.905h0.605c0.012,0.125,0.028,0.244,0.028,0.39c0,0.195-0.016,0.37-0.036,0.527
                                                                                                                                                       h-0.59C72.884,5.665,72.87,5.49,72.87,5.295C72.871,5.149,72.887,5.029,72.898,4.905z M76.125,32.511
                                                                                                                                                       c0.851,1.843,1.654,3.584,1.496,5.828c-0.103,1.549-0.63,2.656-1.567,3.29c-1.057,0.712-2.611,0.783-4.388,0.201
                                                                                                                                                       c-0.724-0.231-3.336-0.955-5.687-1.436c-0.231-0.718-0.674-1.358-1.271-1.835V4.905h7.196c-0.011,0.127-0.021,0.255-0.021,0.39
                                                                                                                                                       c0,0.184,0.011,0.359,0.028,0.527h-1.743c-1.223,0-2.213,0.991-2.213,2.213v10.654c0,1.223,0.99,2.214,2.213,2.214h0.613v1.333
                                                                                                                                                       h1.681v-1.333h1.434v3.021h0.375c-0.049,1.622,0.2,3.979,0.583,5.369C75.171,30.441,75.655,31.494,76.125,32.511z M73.264,15.778
                                                                                                                                                       c-1.285,0-2.327-1.042-2.327-2.328s2.327-4.929,2.327-4.929s2.327,3.644,2.327,4.929C75.591,14.736,74.55,15.778,73.264,15.778z" />
                                    <path
                                        d="M25.101,9.332c-0.097,0.212-0.182,0.416-0.259,0.603c-0.409,0.993-0.547,1.328-1.919,1.58l0.532,2.906
                                                                                                                                                       c2.956-0.542,3.628-2.171,4.118-3.36c0.01-0.026,0.019-0.042,0.026-0.064c0.512,5.034,4.744,8.965,9.911,8.965
                                                                                                                                                       c5.513,0,9.979-4.468,9.979-9.98c0-1.707-0.432-3.313-1.185-4.719L28.761,9.906l-0.2-2.155l5.784-2.719l-5.892,1.56h-0.002
                                                                                                                                                       L28.1,6.685c-0.004,0.011-0.006,0.021-0.01,0.031c-0.394,0.116-1.005,0.251-1.324,0.135c-0.92-0.337-1.971-1.487-2.292-2.511
                                                                                                                                                       l-2.816,0.885C22.183,6.891,23.571,8.519,25.101,9.332z" />
                                </g>
                            </g>
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Pain Management</h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Managing chronic and acute pain</p>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" stroke-width="3" version="1.1" id="Capa_2"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-8 h-8"
                            viewBox="0 0 97.301 97.302" xml:space="preserve">
                            <g>
                                <g>
                                    <path
                                        d="M51.583,45.473c-10.849,2.372-16.271-2.68-16.553-2.95c-1.37-1.367-3.587-1.379-4.97-0.021
                                                                                                   c-1.393,1.366-1.414,3.604-0.048,4.996c0.271,0.276,5.706,5.671,16.019,5.671c2.144,0,4.499-0.231,7.062-0.793
                                                                                                   c1.906-0.417,3.112-2.302,2.695-4.206C55.372,46.263,53.488,45.058,51.583,45.473z" />
                                    <circle cx="19.542" cy="36.266" r="7.948" />
                                    <path
                                        d="M93.032,68.812l-14.885-6.012c-0.516-0.207-1.066-0.314-1.621-0.314h-3.793v-0.824c0-0.422-0.109-0.814-0.291-1.165
                                                                                                   l14.032,3.829c0.371,0.101,0.744,0.15,1.111,0.15c1.85,0,3.545-1.23,4.056-3.102c0.612-2.242-0.709-4.557-2.951-5.167
                                                                                                   l-18.484-5.046c-0.367-0.1-0.728-0.1-1.13-0.098l-12.601,0.012c-0.587,1.387-1.812,2.48-3.391,2.826
                                                                                                   c-2.079,0.455-4.195,0.686-6.292,0.686c-10.229,0-17.198-5.469-17.489-5.702c-1.002-0.799-1.634-1.941-1.777-3.215
                                                                                                   c-0.145-1.275,0.216-2.53,1.017-3.534c0.916-1.15,2.286-1.809,3.757-1.809c1.074,0,2.131,0.367,2.976,1.034
                                                                                                   c0.142,0.11,2.877,2.199,7.226,3.151l-7.761-5.004c-2.736-1.766-6.12-0.547-8.106,1.332c0,0-0.664,0.567-1.13,1.326
                                                                                                   c-0.446,0.726-0.794,1.631-0.794,1.631L24.7,43.819c-0.899,2.602-0.61,6.175,2.136,7.947l14.744,9.508
                                                                                                   c0.175,0.113,0.354,0.215,0.532,0.305c0,0.027-0.008,0.055-0.008,0.082v0.824h-4.193l-19.614-13.61
                                                                                                   c0.097-0.106,0.19-0.22,0.27-0.347c0.72-1.15,0.371-2.667-0.78-3.389l-6.677-4.182c-1.121-0.703-2.584-0.384-3.327,0.698
                                                                                                   c-1.888-0.923-4.214-0.372-5.449,1.407c-1.363,1.964-0.876,4.662,1.089,6.025l30.665,21.285c0.724,0.504,1.586,0.772,2.468,0.772
                                                                                                   h5.717c0.364,0.981,1.302,1.684,2.407,1.684h5.439V93.15H47.47c-1.146,0-2.074,0.93-2.074,2.076s0.929,2.075,2.074,2.075h20.232
                                                                                                   c1.146,0,2.075-0.929,2.075-2.075s-0.93-2.076-2.075-2.076h-2.983V72.828h5.438c1.106,0,2.043-0.702,2.408-1.684h3.119
                                                                                                   l14.105,5.697c0.53,0.215,1.079,0.316,1.618,0.316c1.716,0,3.336-1.024,4.017-2.709C96.32,72.23,95.25,69.708,93.032,68.812z" />
                                    <path
                                        d="M37.083,37.846c7.871,0,12.233-2.105,15.077-4.597v5.456c-0.254,1.096-0.72,3.132-1.27,5.574
                                                                                                   c0.211-0.042,0.419-0.076,0.63-0.122c0.342-0.075,0.688-0.112,1.033-0.112c2.246,0,4.227,1.594,4.708,3.791
                                                                                                   c0.14,0.643,0.144,1.283,0.032,1.893l11.989-0.06c0.527,0,0.989,0.062,1.475,0.192l1.756,0.48
                                                                                                   c-0.998-4.874-2.133-9.672-2.601-11.613v-6.485c1.287,2.681,2.091,6.522,2.009,12.41c-0.026,1.858,1.46,3.387,3.318,3.413
                                                                                                   c0.018,0,0.032,0,0.049,0c1.837,0,3.34-1.476,3.363-3.319c0.225-16.004-7.793-23.512-15.5-26.364
                                                                                                   c-0.008-0.002-0.016-0.002-0.021-0.004l-2.097,2.199l-2.159-2.175c-1.202,0.295-2.378,0.833-3.404,1.565
                                                                                                   c-0.029,0.016-2.987,2.183-5.058,5.072c-2.41,3.259-4.491,6.072-13.332,6.072c-1.858,0-3.366,1.508-3.366,3.367
                                                                                                   C33.716,36.339,35.224,37.846,37.083,37.846z" />
                                    <path
                                        d="M61.164,17.722c4.487,0,8.128-3.638,8.128-8.127c0-1.877-0.651-3.592-1.725-4.965h-2.628V3.397h1.444
                                                                                                   c-0.506-0.425-1.056-0.799-1.654-1.092C64.113,0.949,62.75,0,61.166,0c-1.582,0-2.941,0.947-3.562,2.302
                                                                                                   c-0.601,0.293-1.152,0.669-1.659,1.095h1.65V4.63H54.76c-1.068,1.373-1.722,3.088-1.722,4.965
                                                                                                   C53.04,14.084,56.676,17.722,61.164,17.722z M61.166,1.714c1.219,0,2.208,0.99,2.208,2.208S62.384,6.13,61.166,6.13
                                                                                                   c-1.217,0-2.206-0.99-2.206-2.208S59.949,1.714,61.166,1.714z" />
                                </g>
                            </g>
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Cardiac Care</h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Expert care for heart health</p>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" stroke-width="3" version="1.1" id="Capa_3"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"class="w-8 h-8"
                            viewBox="0 0 96.623 96.622" xml:space="preserve">
                            <g>
                                <g>
                                    <path
                                        d="M31.642,22.691c5.311,1.138,10.541-2.246,11.68-7.559c0.254-1.183,0.271-2.359,0.105-3.49L48.828,0l-7.489,1.934
                                                                                           l-9.606-1.933l-1.482,3.866l0.002,0.001c-3.033,1.139-5.44,3.743-6.17,7.143C22.946,16.324,26.33,21.553,31.642,22.691z" />
                                    <circle cx="68.822" cy="25.679" r="9.281" />
                                    <path
                                        d="M93.753,91.378l-0.355-1.323l-7.661,3.541c0.624,2.184,2.882,3.475,5.079,2.883
                                                                                           C93.037,95.881,94.351,93.598,93.753,91.378z" />
                                    <polygon points="92.696,87.441 84.388,88.602 85.307,92.012 92.97,88.467 		" />
                                    <path
                                        d="M91.451,82.814l-7.293,3.104c0.012-0.021,0.021-0.043,0.031-0.064c0.016-0.209,0.023-0.42,0.043-0.627
                                                                                           c0.034-0.406,0.098-0.801,0.186-1.188l6.607-2.812l-4.27-16.293c-0.147-0.559-0.414-1.058-0.75-1.494
                                                                                           c0.045,0,0.09,0.002,0.137,0.002c1.988,0,3.604-1.612,3.604-3.603c0-1.989-1.613-3.603-3.604-3.603
                                                                                           c-5.432,0-8.93-2.24-10.742-13.689c-0.042-0.26-0.111-0.508-0.205-0.744c-0.447-3.334-3.511-5.569-6.376-6.271
                                                                                           c0,0-0.976-0.293-2.015-0.27c-0.996,0.023-2.105,0.253-2.105,0.253l-0.027,0.006c-3.121,0.765-6.447,3.309-6.447,7.126
                                                                                           l0.001,18.57l-2.724-19.313c-0.215-1.614-1.705-2.747-3.312-2.532c-1.615,0.214-2.749,1.697-2.531,3.312l0.153,1.121
                                                                                           c-11.314-1.577-11.554-3.209-12.983-13.285c-0.021-0.156-0.07-0.301-0.11-0.45c-0.295-3.052-2.695-5.567-5.206-6.784
                                                                                           c0,0-0.949-0.52-2.031-0.727c-1.036-0.198-2.235-0.205-2.235-0.205l-0.029-0.002c-3.406,0.099-7.416,1.998-8.264,5.954
                                                                                           L2.724,69.779h9.701c-0.245,1.85-0.467,3.205-0.637,3.757c-0.428,1.382-3.744,6.526-7.097,11.011
                                                                                           c-1.649,2.208-1.698,5.086,0.509,6.737c2.36,1.464,4.757,0.553,5.737-0.759c1.718-2.295,7.418-10.096,8.639-14.037
                                                                                           c0.383-1.236,0.784-3.752,1.161-6.711h6.997c0.73,1.914,1.238,3.365,1.367,3.992c0.288,1.418-0.146,7.523-0.929,13.066
                                                                                           c-0.388,2.73,0.972,5.891,4.242,5.643c0.238-0.018-0.527,0.051-0.295,0.051c2.446,0,4.584-1.801,4.938-4.293
                                                                                           c0.402-2.84,1.65-12.42,0.824-16.461c-0.103-0.514-0.298-1.196-0.556-1.996h4.013c0,0-8.04-17.162-7.844-23.169l0.283-1.327
                                                                                           c2.74,3.199,7.266,5.035,15.334,6.137c0.176,0.023,0.352,0.035,0.521,0.035c0.422,0,0.83-0.079,1.214-0.209l2.415,17.361
                                                                                           c-1.596,2.664-2.516,5.777-2.516,9.102c0,9.799,7.971,17.77,17.77,17.77c6.475,0,12.15-3.48,15.257-8.67l0.001,0.006
                                                                                           c0.023-0.068,0.055-0.135,0.079-0.203l0.108,0.402l8.306-1.16L91.451,82.814z M73.197,57.889c1.854,1.644,3.939,3.07,6.297,4.239
                                                                                           L73.197,62.1V57.889z M68.517,89.417c-6.455,0-11.709-5.252-11.709-11.709c0-1.468,0.283-2.868,0.779-4.163
                                                                                           c0.209,0.031,0.42,0.053,0.637,0.053h21.242c0.484,1.281,0.762,2.664,0.762,4.11C80.228,84.165,74.974,89.417,68.517,89.417z" />
                                </g>
                            </g>
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Diabetes Management
                    </h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Managing your blood sugar levels</p>
                </div>
            </a>

            <!-- Card 5 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" class="w-8 h-8" stroke-width="8" version="1.2"
                            baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 256 256" xml:space="preserve">
                            <path id="XMLID_1_"
                                d="M122.2,68.1c-13.1,0-23.8-10.6-23.8-23.8s10.7-23.8,23.8-23.8c13.2,0,23.8,10.6,23.8,23.8
                                                                                      S135.3,68.1,122.2,68.1 M194.7,228.7H4.9c-5.3,0-4.8,4.2-4.8,4.2v7c0,0-0.5,9.1,8.9,9.1h237.7c9.4,0,8.9-8.9,8.9-8.9v-19.4
                                                                                      c0,0-0.8-6.1-8-6.1h-23.2C216.4,214.7,209.9,228.7,194.7,228.7 M213.2,185.8c0,11.8,9.6,21.4,21.5,21.4c11.8,0,21.5-9.6,21.5-21.4
                                                                                      c0-11.9-9.6-21.4-21.5-21.4C222.8,164.4,213.2,174,213.2,185.8 M143.1,145c-1.4,4.3-4.6,7.8-9.2,9.5l-19.1,7.1l7,7h32.2l0-49.4
                                                                                      l-10.8,25.5C143.3,144.8,143.2,144.9,143.1,145 M189.4,180.3h-66.7l-16.1-15.7l-11.2,4.1c-8.3,3-18.4-1.6-21.5-9.8
                                                                                      c-1.8-5.1-1.6-10.8,1.5-15c-1.4-0.1-40.4,0-40.4,0c-6.5,0-11.8,5.2-11.8,11.7c0,6.5,5.3,11.6,11.8,11.6h39.8l15.8,23.9l-81.4,6.6
                                                                                      c-5.2,1.2-9.1,5.9-9.1,11.4c0,6.5,5.2,11.8,11.7,11.8l91.4,0c-1.6-2.6-2.6-5.6-2.6-8.8c0-9.3,7.6-16.9,16.9-16.9H154l29.6-6.2
                                                                                      l1.6,7.9l-30.4,6.4h-37.4c-4.9,0-8.8,3.9-8.8,8.8c0,4.8,3.9,8.7,8.6,8.8l72.3,0c11.2-0.1,20.2-9.1,20.2-20.3
                                                                                      C209.7,189.4,200.7,180.3,189.4,180.3 M130.8,147.9c2.4-0.9,4.4-2.8,5.4-5.1L153,102c3.7-9.4,0.2-27.6-18-27.6h-32.1
                                                                                      c-8.9,0-13.7,3.4-15.8,5.5c-1.6,1.6-51.6,56.5-51.6,56.5l28.6,0l25.3-27.6V135l25.8-9.5l8.9-21.4l6.8,2.5l-10.5,25l-33.9,12.8
                                                                                      c-4.7,2.1-6.9,7.6-4.8,12.3c2.1,4.7,7.6,6.8,12.3,4.8L130.8,147.9z" />
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Physical Therapy
                    </h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Restoring mobility and strength</p>
                </div>
            </a>

            <!-- Card 6 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" class="w-8 h-8" stroke-width="10" version="1.1"
                            id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve">

                            <g>
                                <path class="st0" d="M502.198,263.697C492.386,148.068,375.395,65.876,259.027,65.876c-153.162,0-143.009,50.139-160.082,51.56
                                                                           C57.128,120.813,0,169.687,0,226.746c0,57.148,23.702,112.864,92.638,112.864c-4.196,23.673,4.165,62.024,78.62,62.024
                                                                           c35.664,0,85.852,0,103.149,0c0,56.369,85.034,43.14,114.898,43.14c29.941,0,34.818-32.062,29.358-40.385
                                                                           C511.99,403.679,525.092,306.224,502.198,263.697z M367.112,114.661h26.447c5.684,0,10.308,4.634,10.308,10.366
                                                                           c0,5.86-4.624,10.523-10.308,10.523h-26.447c-5.86,0-10.502-4.663-10.502-10.523C356.61,119.295,361.252,114.661,367.112,114.661z
                                                                            M290.477,150.881c1.859,0,3.562,0,5.149,0c5.509,0,6.94-0.915,6.94-0.915c0.516-1.003,0.516-4.867,0.516-7.31v-30.505
                                                                           c0-5.704,4.555-10.416,10.366-10.416c5.694,0,10.386,4.712,10.386,10.416v30.34c0.107,2.608,0.107,5.509-0.302,8.39h34.478
                                                                           c1.06,0,2.21-0.049,3.591-0.049c8.372-0.35,21.045-0.72,30.37,8.225c6.054,5.85,9.228,14.61,9.228,25.94v36.697
                                                                           c0,3.446-0.126,10.629,1.781,12.605c0.886,0.827,2.998,0.886,3.758,0.886h53.741c5.646,0,10.278,4.75,10.278,10.464
                                                                           c0,5.85-4.633,10.503-10.278,10.503h-53.741c-9.559,0-15.418-3.854-18.572-7.106c-8.089-8.225-8.06-20.334-7.836-27.527v-1.557
                                                                           v-34.965c0-5.275-1.052-9.208-2.863-10.979c-2.852-2.755-9.655-2.521-15.164-2.278c-1.568,0-2.969,0.116-4.293,0.116h-68.4
                                                                           c0,0-0.108-0.116-0.331-0.116c-8.673,0-21.044,0-24.355,3.26c-0.204,0.243-0.983,0.857-0.983,3.494v56.962
                                                                           c0,5.812-4.74,10.513-10.415,10.513c-5.763,0-10.445-4.701-10.445-10.513v-56.962c0-9.276,3.972-15.088,7.144-18.299
                                                                           C259.942,150.657,276.276,150.706,290.477,150.881z M199.174,92.303c0-5.752,4.682-10.473,10.347-10.473
                                                                           c5.841,0,10.502,4.72,10.502,10.473v11.505h17.512c5.665,0,10.347,4.76,10.347,10.435c0,5.811-4.682,10.503-10.347,10.503h-17.512
                                                                           v14.942c0,5.693-4.662,10.473-10.502,10.473c-5.665,0-10.347-4.78-10.347-10.473V92.303z M96.482,144.584h43.336
                                                                           c9.976-0.088,22.484-0.176,31.741,9.11c7.136,7.018,10.581,17.658,10.581,32.686v11.058h16.363c5.772,0,10.376,4.779,10.376,10.551
                                                                           c0,5.752-4.604,10.454-10.376,10.454H182.14v8.664c0,5.762-4.73,10.493-10.396,10.493c-5.879,0-10.532-4.73-10.532-10.493V186.38
                                                                           c0-8.858-1.548-15.029-4.36-17.774c-3.164-3.338-9.9-3.338-16.986-3.086H96.482c-5.918,0-10.454-4.72-10.454-10.522
                                                                           C86.028,149.323,90.564,144.584,96.482,144.584z M87.77,236.909v19.059c0,5.811-4.604,10.464-10.542,10.464
                                                                           c-5.714,0-10.318-4.653-10.318-10.464v-19.059H40.366c-5.781,0-10.502-4.722-10.502-10.474c0-5.772,4.722-10.503,10.502-10.503
                                                                           h73.228c5.627,0,10.425,4.73,10.425,10.503c0,5.752-4.798,10.474-10.425,10.474H87.77z M141.16,305.679
                                                                           c-5.996,5.869-8.848,14.455-8.848,26.291c0,5.664-4.75,10.464-10.454,10.464c-5.84,0-10.425-4.799-10.425-10.464
                                                                           c0-17.424,5.071-31.275,15.039-41.107c17.774-17.54,45.748-17.092,62.384-16.839c1.81,0,3.309,0,4.78,0h84.315
                                                                           c13.199,0,22.806-2.89,28.238-8.672c8.897-9.384,8.176-25.96,7.533-39.432c-0.135-3.232-0.272-6.268-0.272-8.916
                                                                           c0-5.821,4.604-10.454,10.298-10.454c5.899,0,10.562,4.633,10.562,10.454c0,2.326,0.136,5.1,0.272,8.05
                                                                           c0.77,15.448,1.81,38.828-13.101,54.616c-9.705,10.162-24.296,15.262-43.53,15.262h-84.315c-1.548,0-3.28,0-5.11,0
                                                                           C174.275,294.737,152.646,294.406,141.16,305.679z M249.303,350.687v20.869c0,5.851-4.662,10.445-10.434,10.445
                                                                           c-5.753,0-10.396-4.594-10.396-10.445v-20.869h-40.464c-5.694,0-10.483-4.673-10.483-10.464c0-5.674,4.788-10.445,10.483-10.445
                                                                           h132.322c5.831,0,10.415,4.77,10.415,10.445c0,5.791-4.584,10.464-10.415,10.464H249.303z M390.025,402.247h-61.984
                                                                           c-5.763,0-10.445-4.643-10.445-10.385c0-5.812,4.682-10.474,10.445-10.474h36.21V361.94c0-5.918,4.662-10.474,10.444-10.474
                                                                           c5.821,0,10.415,4.556,10.415,10.474v19.448h4.916c5.723,0,10.425,4.662,10.425,10.474
                                                                           C400.45,397.604,395.748,402.247,390.025,402.247z M417.105,329.779v-17.064h-48.348c-5.744,0-10.454-4.584-10.454-10.366
                                                                           c0-5.772,4.71-10.503,10.454-10.503h73.052c5.889,0,10.551,4.731,10.551,10.503c0,5.782-4.662,10.366-10.551,10.366h-3.757v17.064
                                                                           c0,5.89-4.692,10.445-10.445,10.445C421.845,340.224,417.105,335.669,417.105,329.779z M470.758,377.806h-26.427
                                                                           c-5.831,0-10.494-4.555-10.494-10.366s4.663-10.406,10.494-10.406h26.427c5.86,0,10.571,4.595,10.571,10.406
                                                                           S476.618,377.806,470.758,377.806z" />
                            </g>
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Mental Health
                        Support
                    </h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Supporting mental wellness</p>
                </div>
            </a>

            <!-- Card 7 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" class="w-8 h-8" stroke-width="10" version="1.1"
                            id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 380.662 380.662" xml:space="preserve">
                            <path
                                d="M150.943,107.736c0,6.106-4.95,11.057-11.056,11.057s-11.056-4.951-11.056-11.057c0-6.106,4.95-11.057,11.056-11.057
                                                       S150.943,101.629,150.943,107.736z M178.553,96.679c-6.106,0-11.056,4.95-11.056,11.057c0,6.106,4.95,11.057,11.056,11.057
                                                       c6.107,0,11.056-4.951,11.056-11.057C189.61,101.629,184.66,96.679,178.553,96.679z M215.039,343.175
                                                       c-16.498,11.44-35.8,17.487-55.819,17.487c-54.275,0-98.432-44.155-98.432-98.43V118.43c0-54.274,44.156-98.43,98.432-98.43
                                                       c54.274,0,98.431,44.155,98.431,98.43v44.011c0,5.522,4.478,10,10,10s10-4.478,10-10V118.43C277.65,53.127,224.522,0,159.22,0
                                                       C93.916,0,40.788,53.127,40.788,118.43v143.803c0,65.303,53.128,118.43,118.432,118.43c24.111,0,47.354-7.279,67.216-21.052
                                                       c4.538-3.147,5.667-9.378,2.52-13.916S219.576,340.028,215.039,343.175z M339.874,246.097v40.219c0,5.522-4.478,10-10,10h-32.115
                                                       v32.115c0,5.522-4.478,10-10,10h-40.217c-5.522,0-10-4.478-10-10v-32.115h-32.115c-5.522,0-10-4.478-10-10v-40.219
                                                       c0-5.522,4.478-10,10-10h32.115v-32.114c0-5.522,4.478-10,10-10h40.217c5.522,0,10,4.478,10,10v32.114h32.115
                                                       C335.396,236.097,339.874,240.574,339.874,246.097z M319.874,256.097h-32.115c-5.522,0-10-4.478-10-10v-32.114h-20.217v32.114
                                                       c0,5.522-4.478,10-10,10h-32.115v20.219h32.115c5.522,0,10,4.478,10,10v32.115h20.217v-32.115c0-5.522,4.478-10,10-10h32.115
                                                       V256.097z M233.142,119.661c0,28.154-16.333,54.216-41.646,66.52c-3,15.076-16.332,26.474-32.275,26.474
                                                       c-15.942,0-29.274-11.396-32.276-26.471c-25.423-12.328-41.646-38.034-41.646-66.522c0-40.761,33.162-73.922,73.923-73.922
                                                       S233.142,78.9,233.142,119.661z M172.127,179.746c0-7.117-5.79-12.907-12.907-12.907s-12.908,5.79-12.908,12.907
                                                       s5.791,12.908,12.908,12.908S172.127,186.863,172.127,179.746z M213.142,119.661c0-29.732-24.189-53.922-53.922-53.922
                                                       c-29.733,0-53.923,24.189-53.923,53.922c0,18.514,9.393,35.417,24.555,45.246c5.434-10.712,16.558-18.068,29.368-18.068
                                                       c12.804,0,23.924,7.352,29.36,18.054C203.691,155.031,213.142,137.951,213.142,119.661z" />
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Pediatric Care</h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Health care for children and infants
                    </p>
                </div>
            </a>

            <!-- Card 8 -->
            <a href="/appointment-request"
                class="relative border p-8 rounded-lg shadow-md transform transition duration-500 cursor-pointer hover:scale-105 hover:shadow-xl group overflow-hidden hover:bg-teal-500">
                <div class="absolute inset-0 bg-cover bg-center opacity-0 group-hover:opacity-30 transition duration-500"
                    style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg');">
                </div>
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-teal-100 rounded-full">
                        <svg fill="none" stroke="#06b6d4" class="w-8 h-8" stroke-width="4" viewBox="0 0 96 96"
                            data-name="Your Icons" id="Your_Icons" xmlns="http://www.w3.org/2000/svg">

                            <title />
                            <path class="cls-1"
                                d="M17.57,71.77c.18-5.62,1.23-11.93,4.49-16.64a9,9,0,0,1,5.1-3.79A15.09,15.09,0,0,1,33,51.6c4.5.72,9.55.48,13.6-1.79,3.49-2,6.16-5.65,6.14-9.66a12.44,12.44,0,0,0-2.7-7.24C47.17,29,44,27.13,42.62,22.22c-1.09-4-.93-8.18-.93-12.3" />
                            <path class="cls-1"
                                d="M48.08,9.92c-.08,3.84.15,7.76,1.73,11.31a4.29,4.29,0,0,0,1.86,2.29c1.57.73,3.33-.39,4.81-1.3a13.82,13.82,0,0,1,9.05-2.33,12.62,12.62,0,0,1,8,5.17C78.92,32.26,79.2,42,76.21,50.2c-2.5,6.9-7.75,14.31-15.06,16.6-8.54,2.69-18.08-1.11-24.93-6.19-1.58-1.17-3.28-2.5-5.24-2.42a5.46,5.46,0,0,0-4.52,3.67c-1.16,3-1,6.76-1.46,9.91" />
                            <circle class="cls-1" cx="64.42" cy="54.8" r="2.63" />
                            <circle class="cls-1" cx="49.83" cy="59.66" r="2.63" />
                            <circle class="cls-1" cx="61.18" cy="45.07" r="2.63" />
                            <circle class="cls-1" cx="57.57" cy="60.34" r="1.93" />
                            <circle class="cls-1" cx="41.67" cy="57.4" r="1.93" />
                            <circle class="cls-1" cx="55.3" cy="51.35" r="1.93" />
                            <circle class="cls-1" cx="67.3" cy="39.35" r="1.93" />
                            <circle class="cls-1" cx="69.89" cy="46.49" r="1.93" />
                        </svg>

                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-start group-hover:text-white mb-2">Gastroenterology
                    </h3>
                    <p class="text-sm text-gray-600 text-start group-hover:text-white">Digestive system care</p>
                </div>
            </a>

        </div>
    </section>



    <!-- Section 3: Consultation Section -->
    <section class="bg-white">
        <div class="relative h-[500px] bg-cover bg-center rounded-3xl overflow-hidden"
            style="background-image: url('/files/homeslider/localhost_8000/3-homeslider-1737453132559.jpg'); margin:20px">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-20 rounded-3xl"></div>

            <!-- Logo (Top Left) -->
            <div class="absolute top-6 left-6 md:top-8 md:left-8">
                <img src="https://careconnect.living/files/logo/care-connect-ltd-logo-1738309321765.png"
                    alt="Renew Medical" class="w-28 md:w-36 h-auto" />
            </div>

            <!-- Content and Button -->
            <div
                class="absolute bottom-16 left-6 right-6 md:bottom-12 md:left-8 md:right-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <!-- Text Section -->
                <div>
                    <h3 class="text-white text-xl md:text-2xl lg:text-3xl font-bold mb-2">
                        Schedule a Consultation Online
                    </h3>
                    <p class="text-white text-base md:text-lg lg:text-xl">
                        Request an appointment with us.
                    </p>
                </div>

                <!-- Button Section -->
                <a href="#"
                    class="bg-teal-500 whitespace-nowrap hover:bg-teal-600 text-white text-base md:text-lg px-6 py-3 rounded-full transition">
                    Request an Appointment
                </a>
            </div>
        </div>
    </section>


    {{-- new slider ends here --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
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
