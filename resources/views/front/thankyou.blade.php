@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $layout = \App\Services\CommonService::doStringMatch($theme, 'default') ? 'front.default.layouts.app' : 'front.troketia.layouts.app';
@endphp

@extends('front.'.$theme.'.layouts.app')

@section('pageTitle')
    Thank You
@endsection

@section('content')
    <div class="container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
        <div class="flex shadow-md my-2">
            <div class="w-2/3 bg-white px-10 py-5">
                <div class="border-b pb-8">
                    <h1 class="font-semibold mb-2 text-2xl">Thank You!</h1>
                    <h3 class="font-semibold mb-2 text-md">Your order id#{{$sales->id}} has been received at {{ date('d/m/Y', strtotime($sales->created_at)) }}.</h3>
                </div>
                <div class="bg-white mt-5 overflow-hidden shadow-sm sm:rounded-lg">
                    @if(isset($order_payment_method->thankyou) && !empty($order_payment_method->thankyou))
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="mb-2 text-md">{!!$order_payment_method->thankyou!!}</h3>
                        </div>
                    @else
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="mb-2 text-md">Order Updated</h3>
                            You'll receive a confirmation email with your order number.<br>
                            You'll get shipping and delivery updates by email.
                        </div>
                    @endif
                </div>
                <div class="bg-white mt-5 overflow-hidden shadow-sm sm:rounded-lg">

                </div>
            </div>

            <div id="summary" class="w-1/3 items-center px-5 py-5">

                <h1 class="font-semibold text-2xl border-b pb-6">Order Summary</h1>
                @foreach ($sales_products as $item)
                    <div class="flex justify-between mt-5 mb-5">
                        <span class="font-semibold text-sm">{{$item->product_name}}</span>
                        <span class="font-semibold text-sm">Rs {{ number_format($item->quantity * $item->order_price,2,".",",") }}</span>
                    </div>
                @endforeach
                <div class="border-t mt-5">
                    @if($sales->pickup_or_delivery == "Delivery" && !empty($sales->delivery_fee))
                        <div class="div_delivery">
                            <div class="flex font-semibold justify-between py-2 text-sm">
                                <span id="span_delivery_name">Delivery Fee</span>
                                <span id="span_delivery_fee">Rs {{ number_format($sales->delivery_fee,2,".",",") }}</span>
                            </div>
                        </div>
                    @endif
                    @if(isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value != 'NVTR')
                    <div class="flex font-semibold justify-between py-2 text-sm">
                        <span>VAT Amount</span>
                        <span>Rs {{number_format($sales->tax_amount,2,".",",")}}</span>
                    </div>
                        @endif
                    <div class="flex font-semibold justify-between py-2 text-sm">
                        <span>Subtotal</span>
                        <span>Rs {{number_format($sales->subtotal,2,".",",")}}</span>
                    </div>
                    <div class="flex font-semibold justify-between py-2 text-sm">
                        <span>Total cost</span>
                        <span class="span_amount">Rs {{number_format($sales->amount,2,".",",")}}</span>
                    </div>
                    <div class="py-2 border-t font-semibold">
                        <h3 class="mb-2 text-md">Customer Information</h3>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Name : {{$sales->customer_firstname}} {{$sales->customer_lastname}}</label>
                        </div>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Address : {{ $sales->customer_address }}</label>
                        </div>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">City : {{ $sales->customer_city }}</label>
                        </div>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Email : {{ $sales->customer_email }}</label>
                        </div>
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">Phone : {{ $sales->customer_phone }}</label>
                        </div>
                        @if(!empty($sales->comment))
                            <div class="mb-2">
                                <label class="block mb-2 text-sm font-medium">Additionnal Note : {{ $sales->comment }}</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
