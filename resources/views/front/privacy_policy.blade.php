@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $layout = \App\Services\CommonService::doStringMatch($theme, 'default')
        ? 'front.default.layouts.app'
        : 'front.troketia.layouts.app';
@endphp

@extends('front.' . $theme . '.layouts.app')

@section('pageTitle')
    Privacy Policy
@endsection

<style>
    .bg-color-on-hover {
            background: #f6f6f6;
            /* padding: 3px 6px; */
            padding: 26px;
            border-radius: 20px;
        }



        @media (min-width: 1280px) {
            .xl\:w-1\/3 {
                width: 30.333333% !important;
            }
        }



        @media (min-width: 1024px) {
            .lg\:gap-3 {
                gap: 3.75rem !important;
            }
        }
        /* body {
            background: #F7F5F1
        } */

        @media (min-width: 640px) {
            .sm\:mx-8 {
                margin-left: 0rem;
                margin-right: 0rem;
            }
        }



        .main-page-content p ul li ol {
            font-family: "Inter", serif !important;
        }



        .main-page-content p {
            font-size: 0.875rem; /* text-sm */
            color: #color-ki; /* Replace with actual color value */
            text-align: left   !important;
            /* margin-bottom:-10px;
            margin-top:-10px; */


        }

        .main-page-content div{
            padding: 15px;
            border-radius: 10px;
            padding-left:30px;
            padding-right:30px;
            padding-bottom: 30px;

        }
        .main-page-content li {
            font-size: 0.875rem; /* text-sm */
            color: #color-ki; /* Replace with actual color value */
            text-align: left   !important;
            /* margin:-15px; */
        }

        .main-page-content ul {
            list-style-type: disc; /* Default bullet style */
            /* margin-top: -15px; */
            /* margin-bottom: -15px; */
            padding-left: 50px;
        }

        .main-page-content ol {
            list-style-type: decimal; /* Numbered list */
            padding-left: 50px;

        }




        @media (prefers-color-scheme: dark) {
            p {
                color: #gray-400; /* dark:text-gray-400 */
            }
        }

        @media (min-width: 640px) {
            .sm\:mx-8 {
                margin-left: 0rem;
                margin-right: 0rem;
            }
        }
        .main-page-content div{
            padding: 15px;
            border-radius: 10px;
            padding-left:40px;
            padding-right:40px;
            padding-bottom: 40px;

        }
        .main-page-content li {
            font-size: 0.875rem; /* text-sm */
            color: #color-ki; /* Replace with actual color value */
            text-align: left   !important;
            margin:-15px;
        }

        .main-page-content ul {
            list-style-type: disc; /* Default bullet style */
            margin-top: -15px;
            margin-bottom: -15px;
            padding-left: 50px;
        }

        .main-page-content ol {
            list-style-type: decimal; /* Numbered list */
            padding-left: 50px;

        }


        * {
                font-family: "Inter", serif !important;
            }

              /* If the theme is 'troketia', set the custom font */
        .troketia * {
            font-family: 'IntroRegularAlt', sans-serif !important;
        }

        .top-bar{

        }

        p{
            font-family: "Inter", serif !important;
        }

        .main-page-content p {
            font-size: 0.875rem; /* text-sm */
            color: #color-ki; /* Replace with actual color value */
            text-align: left   !important;
            margin-bottom:-10px;
            margin-top:-10px;


        }

        @media (prefers-color-scheme: dark) {
            p {
                color: #gray-400; /* dark:text-gray-400 */
            }
        }

</style>

@section('content')
    <div class="main-page-content container mt-4 mx-auto sm:px-0 md:px-14 lg:px-14 xl:px-14 2xl:px-14"style="flex-grow:1; margin-top:-3px">
        <div class="text-center text-xl mb-4 " style="background: #F7F5F1; padding:36px" >Privacy Policy
        <p class="text-md min-h-max mt-2" style="background: #F7F5F1; margin-top:-36px">
            @if (isset($privacy_policy->key))
                <br><br>{!! nl2br($privacy_policy->value) !!}
            @endif
            
        </p>
    </div>
    </div>
@endsection


