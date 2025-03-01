@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $layout = \App\Services\CommonService::doStringMatch($theme, 'default') ? 'front.default.layouts.app' : 'front.troketia.layouts.app';
@endphp

@extends('front.'.$theme.'.layouts.app')

@section('pageTitle')
    Terms and Conditions
@endsection

@section('content')
    <div class="container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14"style="flex-grow:1">
        <div class="flex shadow-md my-2">
            <div class="w-full bg-white px-10 py-5">
                <div class="flex justify-between border-b pb-8">
                    <h1 class="font-semibold text-2xl">Sale Saved Successfully</h1>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pt-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold mb-2 text-md">Your order Sale has been saved and paid successfully.</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
