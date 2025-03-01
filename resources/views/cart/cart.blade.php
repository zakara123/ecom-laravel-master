@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $layout = \App\Services\CommonService::doStringMatch($theme, 'default')
        ? 'front.default.layouts.app'
        : 'front.troketia.layouts.app';
@endphp

@extends($layout)

@section('pageTitle')
    Cart
@endsection

@section('customStyles')
    <link rel="stylesheet" href="{{ url('dist/flatpickr.min.css') }}" />
    <link rel="stylesheet" href="{{ url('dist/ie.min.css') }}" />
    <style>
        #summary {
            background-color: #f6f6f6;
        }

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

        input[name="pickup_date"]:focus.invalid~label:after,
        input[name="pickup_date"].invalid~label:after {
            content: attr(data-error);
            color: #F44336;
            opacity: 1;
        }

        input[name="pickup_date"]:focus~label:after,
        input[name="pickup_date"]~label:after {
            display: block;
            content: "";
            position: absolute;
            top: 36px;
            opacity: 0;
            white-space: pre;
            transition: .2s opacity ease-out, .2s color ease-out;
        }
    </style>
@endsection

@section('content')

    @if ($theme == 'care-connect')
        <style>
            header {
                padding-bottom: 1.75rem;
                margin: 0 !important;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }


            @media (min-width: 640px) {
                header {
                    padding-left: 2rem;
                    padding-right: 2rem;
                }
            }
        </style>
    @endif
    <form action="{{ route('order-confirmation') }}" method="post">
        <div class="container mx-auto mt-4 px-4 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
            <div class="md:flex lg:flex xl:flex 2xl:flex shadow-md my-10">
                <div class="md:w-1/4 lg:w-1/4 xl:w-1/4 2xl:w-1/4 sm:w-full bg-gray-100 px-10 py-10">
                    <h3 class="font-semibold text-md">Contact Information</h3>
                    <div class="mb-6">
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Email Address*" required>
                    </div>
                    <div class="mb-4">
                        <input type="tel" id="phone" pattern="[+]{1}[0-9]{7,14}|[0-9]{7,14}|[-]{1}[0-9]{7,14}"
                            name="phone" value="{{ old('phone') }}"
                            oninvalid="setCustomValidity('Please insert a valid mobile number')"
                            onchange="try{setCustomValidity('')}catch(e){}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Phone*" required>
                        @error('phone')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center mb-6">
                        <input id="create_account" name="create_account" type="checkbox" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            onclick="togglePasswordField()">
                        <label for="create_account" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Create
                            customer account</label>
                    </div>
                    <!-- Hidden password field -->
                    <div id="password_field" class="mb-6 hidden">
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Password*">
                    </div>
                    <h3 class="font-semibold text-md">Customer Address</h3>
                    {{-- <div class="grid gap-6 mb-6 md:grid-cols-2">
                      <div>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Company">
                      </div>
                      <div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Person name *" required>
                      </div>
                    </div> --}}
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="First Name*" required>
                        </div>
                        <div>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Last Name*" required>
                        </div>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="address1" name="address1" value="{{ old('address1') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Address 1*" required>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="address2" name="address2" value="{{ old('address2') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Address 2">
                    </div>
                    <div class="mb-6">
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="City*" required>
                    </div>
                    <div class="mb-6">
                        {{-- <input type="text" id="country" name="country" value="{{ old('country') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Country*" required> --}}
                        <select id="country" name="country"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Rodrigues Island">Rodrigues Island</option>
                        </select>
                    </div>
                    {{-- <div class="mb-6">
                      <input type="text" id="fax" name="fax" value="{{ old('fax') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fax">
                    </div> --}}
                    <div class="mb-6">
                        <textarea id="comment" name="comment" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Comment...">{{ old('comment') }}</textarea>
                    </div>
                </div>
                <div
                    class="md:w-2/4 lg:w-2/4 xl:w-2/4 2xl:w-2/4 sm:w-full bg-white px-2 sm:px-2 md:px-10 lg:px-10 xl:px-10 2xl:px-10 py-5">
                    <div class="flex justify-between border-b pb-8">
                        <h1 class="font-semibold text-2xl">Shopping Cart</h1>
                        <h2 class="font-semibold text-2xl">{{ count($carts) }} Item(s)</h2>
                    </div>
                    @if (Session::has('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                            role="alert">
                            <span class="font-medium">Success : </span> {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error_message'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                        </div>
                    @endif
                    <div class="flex mt-5 mb-5">
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                        <h3
                            class="font-semibold text-center text-gray-600 text-xs uppercase @if (!$agent->isMobile()) w-2/6 @else w-3/6 @endif text-center">
                            Quantity</h3>

                        <!-- <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/6 text-center">VAT Amount</h3> -->
                        @if (!$agent->isMobile())
                            <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-2/6 text-center">Price
                            </h3>
                            <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-2/6 text-center">Total
                            </h3>
                        @endif
                    </div>

                    @php
                        $total_cart = 0;
                        $subtotal = 0;
                        $vat_amount = 0;
                        $i = 1;
                    @endphp

                    @foreach ($carts as $cart)
                        <input type="hidden" name="id_item" id="item_id_{{ $i }}"
                            value="{{ $cart->id }}">
                        <div
                            class="flex items-center hover:bg-gray-100 @if (!$agent->isMobile()) -mx-8 px-6 @endif py-1">
                            <div class="w-2/5">
                                <!-- product -->
                                <div class="w-20 ml-4 mb-2">
                                    @if (isset($cart->product_image->src))
                                        <img class="h-auto" src="{{ $cart->product_image->src }}" alt="">
                                    @else
                                        <img class="h-auto" src="{{ url('front/img/ECOM_L.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="flex flex-col justify-between ml-4 flex-grow">
                                    <span class="font-bold text-sm">{{ $cart->product_name }}</span>
                                    @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR')
                                        <span class="text-gray-500 text-xs">Tax : {{ $cart->tax_sale }}</span>
                                    @endif
                                    <span class="text-gray-500 text-xs">
                                        @foreach ($cart->variation_value as $key => $var)
                                            {{ $var['attribute'] }}:{{ $var['attribute_value'] }}@if ($key !== array_key_last($cart->variation_value))
                                                ,
                                            @endif
                                        @endforeach
                                    </span>
                                    <a href="{{ route('delete-cart', ['id' => $cart->id]) }}"
                                        class="font-semibold hover:text-red-500 text-gray-500 text-xs"
                                        onclick="return confirm('You will remove, do you confirm?')">Remove</a>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-center @if ($agent->isMobile()) w-3/6 @else items-center w-2/6 @endif ">
                                <div
                                    class="flex items-center @if ($agent->isMobile()) justify-center @endif  border-gray-100">
                                    <span id="decrease" onclick="decrease(this, '{{ $i }}')"
                                        class="cursor-pointer rounded-l bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                        - </span>
                                    <input id="qty_value_{{ $i }}"
                                        class="h-8 w-8 border bg-white text-center text-xs outline-none" type="text"
                                        value="{{ $cart->quantity }}" readonly="readonly" min="1">
                                    <span id="increase" onclick="increase(this, '{{ $i }}')"
                                        class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50">
                                        + </span>
                                </div>
                                <div class="mt-2 text-center">
                                    <button id="btn_{{ $i }}" type="button"
                                        onclick="update(this, '{{ $i }}')"
                                        class="hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded-full">
                                        Save
                                    </button>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp

                            @if (!$agent->isMobile())
                                <span class="text-center w-2/6 font-semibold text-sm">Rs
                                    {{ number_format($cart->product_price, 2, '.', ',') }}</span>
                                <!-- <span class="text-center w-1/6 font-semibold text-sm">Rs
                                                                                                                                        @if ($cart->tax_sale == '15% VAT' && $cart->tax_items != 'No VAT')
    {{ number_format($cart->product_price * 0.15 * $cart->quantity, 2, '.', ',') }}
                                                                                                                                            @php
                                                                                                                                                $vat_amount =
                                                                                                                                                    $vat_amount +
                                                                                                                                                    $cart->product_price *
                                                                                                                                                        0.15 *
                                                                                                                                                        $cart->quantity;
                                                                                                                                            @endphp
@elseif((str_contains($cart->tax_sale, '% VAT') || str_contains($cart->tax_sale, '%')) && $cart->tax_items != 'No VAT')
    @php
        $rate = (float) preg_replace('/[^\d,]/', '', $cart->tax_sale) / 100;
    @endphp
                                                                                                                                                {{ number_format($cart->product_price * $rate * $cart->quantity, 2, '.', ',') }}
                                                                                                                                                @php
                                                                                                                                                    $vat_amount =
                                                                                                                                                        $vat_amount +
                                                                                                                                                        $cart->product_price *
                                                                                                                                                            $rate *
                                                                                                                                                            $cart->quantity;
                                                                                                                                                @endphp
@else
    0.00
    @endif

                                                                                                                                        {{-- if tax_sale == 15% VAT and tax_items != No VAT => VAT AMOUNT = UNIT PRICE * 15 / 100  --}}
                                                                                                                                        </span> -->
                                <span class="text-center w-2/6 font-semibold text-sm">Rs
                                    @if ($cart->tax_sale == '15% VAT' && $cart->tax_items == 'Added to the price')
                                        {{ number_format($cart->product_price * $cart->quantity + $cart->product_price * 0.15 * $cart->quantity, 2, '.', ',') }}
                                    @elseif(
                                        (str_contains($cart->tax_sale, '% VAT') || str_contains($cart->tax_sale, '%')) &&
                                            $cart->tax_items == 'Added to the price')
                                        @php
                                            $rate = (float) preg_replace('/[^\d,]/', '', $cart->tax_sale) / 100;
                                        @endphp
                                        {{ number_format($cart->product_price * $cart->quantity + $cart->product_price * $rate * $cart->quantity, 2, '.', ',') }}
                                    @else
                                        {{ number_format($cart->product_price * $cart->quantity, 2, '.', ',') }}
                                    @endif
                                </span>
                            @endif
                        </div>

                        @if ($agent->isMobile())
                            <div class="w-full block">
                                <div class="flex mt-5 mb-5">

                                    <h3
                                        class="font-semibold text-center text-gray-600 text-xs uppercase w-3/6 text-center">
                                        Price</h3>
                                    <h3
                                        class="font-semibold text-center text-gray-600 text-xs uppercase w-3/6 text-center">
                                        Total</h3>

                                </div>
                                <div class="flex mt-5 mb-5">
                                    <span class="text-center w-3/6 font-semibold text-sm text-center">Rs
                                        {{ number_format($cart->product_price, 2, '.', ',') }}</span>
                                    <span class="text-center w-3/6 font-semibold text-sm text-center">Rs

                                        @if ($cart->tax_sale == '15% VAT' && $cart->tax_items == 'Added to the price')
                                            {{ number_format($cart->product_price * $cart->quantity + $cart->product_price * 0.15 * $cart->quantity, 2, '.', ',') }}
                                        @elseif(
                                            (str_contains($cart->tax_sale, '% VAT') || str_contains($cart->tax_sale, '%')) &&
                                                $cart->tax_items == 'Added to the price')
                                            @php
                                                $rate = (float) preg_replace('/[^\d,]/', '', $cart->tax_sale) / 100;
                                            @endphp
                                            {{ number_format($cart->product_price * $cart->quantity + $cart->product_price * $rate * $cart->quantity, 2, '.', ',') }}
                                        @else
                                            {{ number_format($cart->product_price * $cart->quantity, 2, '.', ',') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif


                        @php
                            $subtotal = $subtotal + $cart->product_price * $cart->quantity;
                        @endphp

                        @php
                            if ($cart->tax_sale == '15% VAT' && $cart->tax_items != 'No VAT') {
                                if ($cart->tax_items == 'Included in the price') {
                                    $total_cart = $total_cart + $cart->product_price * $cart->quantity;
                                }

                                if ($cart->tax_items == 'Added to the price') {
                                    $total_cart =
                                        $total_cart +
                                        $cart->quantity * ($cart->product_price + $cart->product_price * 0.15);
                                }
                            } elseif (
                                (str_contains($cart->tax_sale, '% VAT') || str_contains($cart->tax_sale, '%')) &&
                                $cart->tax_items != 'No VAT'
                            ) {
                                $rate = (float) preg_replace('/[^\d,]/', '', $cart->tax_sale) / 100;
                                if ($cart->tax_items == 'Included in the price') {
                                    $total_cart = $total_cart + $cart->product_price * $cart->quantity;
                                }

                                if ($cart->tax_items == 'Added to the price') {
                                    $total_cart =
                                        $total_cart +
                                        $cart->quantity * ($cart->product_price + $cart->product_price * $rate);
                                }
                            } else {
                                $total_cart = $total_cart + $cart->product_price * $cart->quantity;
                            }
                        @endphp
                    @endforeach

                    @php
                        if ($tax_items == 'Included in the price') {
                            $subtotal = $total_cart - $vat_amount;
                        }
                    @endphp
                    <a href="{{ route('online_shop') }}" class="flex font-semibold text-indigo-600 text-sm mt-10">
                        <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Continue Shopping
                    </a>
                </div>

                <div id="summary" class="md:w-1/4 lg:w-1/4 xl:w-1/4 2xl:w-1/4 sm:w-full items-center px-8 py-5">
                    <h3 class="font-semibold text-md mt-2 mb-2">Payment Method</h3>
                    <div class="mb-2">
                        <select id="payment_methode" name="payment_methode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option value="">Select Payment Method</option>
                            @foreach ($payment_mode as $payment)
                                @if ($payment->payment_method != 'Credit Sale')
                                    <option value="{{ $payment->id }}">{{ $payment->payment_method }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @if (count($stores) > 0 && count($delivery) > 0)
                        <h3 class="font-semibold text-md">Pickup Or Delivery</h3>
                    @else
                        @if (count($stores) > 0 && count($delivery) == 0)
                            <h3 class="font-semibold text-md mt-2 mb-2">Pickup</h3>
                        @endif
                        @if (count($stores) == 0 && count($delivery) > 0)
                            <h3 class="font-semibold text-md mt-2 mb-2">Delivery</h3>
                        @endif
                    @endif
                    <div class="grid mb-6 md:grid-cols-2 @if (count($stores) == 0) hidden @endif">
                        @if (count($stores) > 0)
                            <div class="items-center mt-2 w-1/2">
                                <input checked id="default-radio-1" type="radio" value="Pickup"
                                    {{ old('pickup_or_delivery') != 'Delivery' ? 'checked' : '' }}
                                    name="pickup_or_delivery"
                                    class="w-4 h-4 mt-0.5 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-1"
                                    class="absolute ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">Pickup</label>
                            </div>
                        @endif
                        @if (count($delivery) > 0)
                            <div class="items-center mt-25 w-1/2">
                                <input id="default-radio-2" type="radio" value="Delivery"
                                    {{ old('pickup_or_delivery') == 'Delivery' ? 'checked' : '' }}
                                    @if (count($stores) == 0) checked @endif name="pickup_or_delivery"
                                    class="w-4 h-4 mt-0.5 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-2"
                                    class="absolute ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">Delivery</label>
                            </div>
                        @endif
                    </div>
                    @if (count($stores) > 0)
                        <div class="mb-6 div_pickup border-b">
                            <select id="store_pickup" name="store_pickup"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                                <option value="" selected>Select a Store</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}"
                                        @if ($store->id == old('store_pickup')) selected @endif>{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-6 div_pickup border-b">
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input id="pickup_date" name="pickup_date" datepicker datepicker-autohide
                                    minDate="{{ date('d/m/Y', strtotime('+1 day', time())) }}"
                                    datepicker-format="dd/mm/yyyy" value="{{ old('pickup_date') }}" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Pickup Date" readonly="readonly" required>
                            </div>
                            <small id="error_message" class="text-red-600 ml-2 hidden">This field is required</small>
                        </div>
                    @endif
                    @if (count($delivery) > 0)
                        <div class="mb-6 div_delivery hidden">
                            <script>
                                var delivery_array = [];
                            </script>
                            <select id="delivery_method" name="delivery_method"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected>Select a Delivery Method</option>
                                @foreach ($delivery as $del)
                                    <script>
                                        delivery_array.push({
                                            id: '{{ $del->id }}',
                                            name: '{{ $del->delivery_name }}',
                                            fee: '{{ $del->delivery_fee }}',
                                            vat: '{{ $del->vat }}',
                                            fee_dec: '{{ number_format($del->delivery_fee, 2, '.', ',') }}',
                                        });
                                    </script>
                                    <option value="{{ $del->id }}"
                                        @if ($del->id == old('delivery_method')) selected @endif>{{ $del->delivery_name }}(Rs
                                        {{ number_format($del->delivery_fee, 2, '.', ',') }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <h1 class="font-semibold text-2xl border-b pb-6">Order Summary</h1>
                    {{-- <div class="flex justify-between mt-5 mb-5 border-b pb-5">
                      <span class="font-semibold text-sm">Store VAT Type : {{ $tax_items }}</span>
                    </div> --}}
                    @foreach ($carts as $cart)
                        <div class="flex justify-between mt-5 mb-5">
                            <span class="font-semibold text-sm uppercase">{{ $cart->product_name }}</span>
                            <span class="font-semibold text-sm">Rs
                                {{ number_format($cart->product_price * $cart->quantity, 2, '.', ',') }} </span>
                        </div>
                    @endforeach
                    @if (count($carts) == 0)
                        <div class="text-center justify-between mt-5 mb-5">
                            <span class="font-semibold text-sm uppercase">Cart is empty.</span>
                        </div>
                    @endif
                    <div class="hidden div_delivery">
                        <div class="flex font-semibold justify-between py-2 text-sm">
                            <span id="span_delivery_name">Delivery</span>
                            <span id="span_delivery_fee">Rs 0.00</span>
                        </div>
                    </div>
                    <div class="border-t mt-5">
                        <div class="flex font-semibold justify-between py-2 text-sm">
                            @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR')
                                <span>VAT Amount</span>
                                <span class="span_vat_amount">Rs {{ number_format($vat_amount, 2, '.', ',') }}</span>
                            @endif
                        </div>
                        <div class="flex font-semibold justify-between py-2 text-sm">
                            <span>Subtotal</span>
                            <span class="span_subtotal">Rs {{ number_format($subtotal, 2, '.', ',') }}</span>
                        </div>
                        <div class="flex font-semibold justify-between py-2 text-sm">
                            <span>Total cost</span>
                            <span class="span_amount">Rs {{ number_format($total_cart, 2, '.', ',') }}</span>
                        </div>
                        <input type="hidden" name="amount" id="amount" value="{{ $total_cart }}">
                        <input type="hidden" name="old_amount" id="old_amount" value="{{ $total_cart }}">
                        <input type="hidden" name="subtotal" id="subtotal" value="{{ $subtotal }}">
                        <input type="hidden" name="old_subtotal" id="old_subtotal" value="{{ $subtotal }}">


                        @if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR')
                            <input type="hidden" name="vat_amount" id="vat_amount" value="{{ $vat_amount }}">
                            <input type="hidden" name="old_vat_amount" id="old_vat_amount"
                                value="{{ $vat_amount }}">
                        @else
                            <input type="hidden" name="vat_amount" id="vat_amount" value="0">
                            <input type="hidden" name="old_vat_amount" id="old_vat_amount" value="0">
                        @endif

                        <input type="hidden" name="tax_items" id="tax_items" value="{{ $tax_items }}">
                        <input type="hidden" name="id_store" id="id_store" value="{{ $id_store }}">
                        @csrf

                        <button type="submit" style="width: 100%;"
                            class=" pointer w-100
                            @if ($theme === 'care-connect') bg-green-400 hover:bg-green-800  px-6 py-2 text-white font-bold transition-colors duration-300 focus:outline-none rounded
                            @else bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-sm text-white @endif
                        ">
                            Checkout
                            - <span class="span_amount">Rs {{ number_format($total_cart, 2, '.', ',') }}</span>
                        </button>
                        <button type="button" onclick="window.location='{{ route('empty-cart') }}'"
                            style="width: 100%;"
                            class=" w-100 mt-2
                                @if ($theme === 'care-connect') relative ml-auto text-black border-2 border-black-100 py-2 px-6 focus:outline-none rounded transition-colors duration-300 hover:text-white hover:bg-green-400 hover:border-green-400
                                @else
                                    bg-gray-100 font-semibold hover:bg-gray-300 py-3 text-sm w-full @endif
                            ">Empty
                            Cart</button>
                        {{-- <button type="button" onclick="Checkout.showPaymentPage();" class="bg-gray-100 font-semibold hover:bg-gray-300 py-3 text-sm w-full">MCB PAYEMENT</button> --}}

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('customScript')
    <script src="{{ url('dist/flatpickr.min.js') }}"></script>

    <script>
        flatpickr('#pickup_date', {
            "minDate": new Date().fp_incr(1),
            "dateFormat": "d/m/Y"
        });


        $('input[type=radio][name=pickup_or_delivery]').change(function() {
            if (this.value == 'Pickup' && $(this).is(':checked')) {
                $(".div_delivery").hide(500);
                $(".div_pickup").show(500);
                $("#pickup_date").val("");
                $("#store_pickup").val($("#store_pickup option:first").val());
                $('#store_pickup').prop('required', true);
                $('#pickup_date').prop('required', true);
                $('#delivery_method').prop('required', false);

                ///disable delivery
                $("#span_delivery_name").html("Delivery");
                $("#span_delivery_fee").html("Rs 0.00");
                $(".span_amount").html("Rs " + formatNumber($("#old_amount").val()));
                $(".span_subtotal").html("Rs " + formatNumber($("#old_subtotal").val()));
                $(".span_vat_amount").html("Rs " + formatNumber($("#old_vat_amount").val()));
                $("#amount").val($("#old_amount").val());
                $("#subtotal").val($("#old_subtotal").val());
                $("#vat_amount").val($("#old_vat_amount").val());
            }

            @if (count($delivery) > 0)
                else if (this.value == 'Delivery' && $(this).is(':checked')) {
                    $(".div_delivery").show(500);
                    $(".div_pickup").hide(500);
                    $("#delivery_method").val($("#delivery_method option:first").val());
                    $('#store_pickup').prop('required', false);
                    $('#pickup_date').prop('required', false);
                    $('#delivery_method').prop('required', true);
                    load_delivery_method();
                }
            @endif
        });

        $('#payment_methode').change(function() {
            if ($('#payment_methode').val() == "") {
                $('#span_error_payment_mode').show();
                $('#payment_methode').css('border', "solid 1px red");
            } else {
                $('#span_error_payment_mode').hide();
                $('#payment_methode').css('border', "");
            }
        });

        function decrease(button, i) {
            if (parseFloat($('#qty_value_' + i).val()) > 1) {
                $('#qty_value_' + i).val($('#qty_value_' + i).val() - 1);
                /*var url = "{{ url('decrease') }}/" + $('#item_id_' + i).val();
                $.ajax({
                  url: url,
                  type: 'GET',
                  dataType: 'json', // added data type
                  success: function(data) {
                    //success
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $('#qty_value_' + i).val(parseFloat($('#qty_value_' + i).val()) + 1);
                  }
                });*/
                $('#btn_' + i).show();
            }
        }

        function increase(button, i) {
            $('#qty_value_' + i).val(parseFloat($('#qty_value_' + i).val()) + 1);
            /*var url = "{{ url('increase') }}/" + $('#item_id_' + i).val();
               $.ajax({
                  url: url,
                  type: 'GET',
                  dataType: 'json', // added data type
                  success: function(data) {
                    //success
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $('#qty_value_' + i).val(parseFloat($('#qty_value_' + i).val()) - 1);
                  }
                });*/
            $('#btn_' + i).show();
        }

        function update(button, i) {
            var qty = $('#qty_value_' + i).val();
            var url = "{{ url('cart_update_qty') }}/" + $('#item_id_' + i).val() + "/" + qty;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(data) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        function checkDate() {
            if ($('#payment_methode').val() == "") {
                $('#span_error_payment_mode').show();
                $('#payment_methode').css('border', "solid 1px red");
                return false;
            }
            var delivery_methode = $('#default-radio-1');
            if (delivery_methode.val() == 'Pickup' && delivery_methode.is(':checked') && $('#pickup_date').val() == '') {
                $('#pickup_date').css('border', "solid 1px red");
                $('#error_message').show();
                return false;
            } else {
                $('#pickup_date').css('border', '');
                $('#error_message').hide();
                return true;
            }
        }

        $('form').submit(function() {
            return checkDate();
        });

        $(document).ready(function() {
            $('input[type=radio][name=pickup_or_delivery]').change();
        });
        @if (count($delivery) > 0)
            $("#delivery_method").change(function() {
                load_delivery_method();
            });
        @endif
        function load_delivery_method() {
            var tax_items = "No VAT";
            @if (isset($online_store->vat_type) && !empty($online_store->vat_type))
                tax_items = "{{ $online_store->vat_type }}";
            @endif
            var text = $("#delivery_method option:selected").text();
            if ($('#delivery_method').has('option').length > 0) {
                if ($('#delivery_method').val() == "") {
                    $("#span_delivery_name").html(
                        '<small class="text-red-600 ml-2">You have to select a Delivery Method</small>');
                    $("#span_delivery_fee").html("");
                    $(".span_amount").html("Rs " + formatNumber($("#old_amount").val()));
                    $(".span_subtotal").html("Rs " + formatNumber($("#old_subtotal").val()));
                    $(".span_vat_amount").html("Rs " + formatNumber($("#old_vat_amount").val()));
                    $("#amount").val($("#old_amount").val());
                    $("#subtotal").val($("#old_subtotal").val());
                    $("#vat_amount").val($("#old_vat_amount").val());
                } else {
                    $("#span_delivery_name").html(text);
                    var id = $("#delivery_method").val();
                    for (i = 0; i < delivery_array.length; i++) {
                        if (delivery_array[i].id == id) {
                            if (delivery_array[i].vat == "15% VAT" && (tax_items == "Added to the price" || tax_items ==
                                    "Included in the price")) {
                                if (tax_items == "Added to the price") {
                                    var vat_delivery_fee = parseFloat(delivery_array[i].fee) * 0.15;
                                    $("#span_delivery_fee").html("Rs " + delivery_array[i].fee_dec);
                                    var amount = parseFloat($("#old_amount").val()) + parseFloat(delivery_array[i].fee) +
                                        vat_delivery_fee;
                                    var subtotal = parseFloat($("#old_subtotal").val()) + parseFloat(delivery_array[i].fee);
                                    var vat_amount = parseFloat($("#old_vat_amount").val()) + parseFloat(vat_delivery_fee);
                                    $("#amount").val(amount + "");
                                    $("#subtotal").val(subtotal + "");
                                    $("#vat_amount").val(vat_amount + "");
                                    $(".span_amount").html("Rs " + formatNumber(amount));
                                    $(".span_subtotal").html("Rs " + formatNumber(subtotal));
                                    $(".span_vat_amount").html("Rs " + formatNumber(vat_amount));
                                }
                                if (tax_items == "Included in the price") {
                                    var vat_delivery_fee = parseFloat(delivery_array[i].fee) * 0.15;
                                    $("#span_delivery_fee").html("Rs " + delivery_array[i].fee_dec);
                                    var amount = parseFloat($("#old_amount").val()) + parseFloat(delivery_array[i].fee);
                                    //var subtotal = parseFloat($("#old_subtotal").val()) + parseFloat(delivery_array[i].fee);
                                    var vat_amount = parseFloat($("#old_vat_amount").val()) + parseFloat(vat_delivery_fee);
                                    var subtotal = parseFloat(amount) - parseFloat(vat_amount);
                                    $("#amount").val(amount + "");
                                    $("#subtotal").val(subtotal + "");
                                    $("#vat_amount").val(vat_amount + "");
                                    $(".span_amount").html("Rs " + formatNumber(amount));
                                    $(".span_subtotal").html("Rs " + formatNumber(subtotal));
                                    $(".span_vat_amount").html("Rs " + formatNumber(vat_amount));
                                }
                            } else {
                                $("#span_delivery_fee").html("Rs " + delivery_array[i].fee_dec);
                                var amount = parseFloat($("#old_amount").val()) + parseFloat(delivery_array[i].fee);
                                $("#amount").val(amount + "");
                                var subtotal = parseFloat($("#old_subtotal").val()) + parseFloat(delivery_array[i].fee);
                                $(".span_amount").html("Rs " + formatNumber(amount));
                                $("#vat_amount").val($("#old_vat_amount").val());
                                $(".span_subtotal").html("Rs " + formatNumber(subtotal));
                                $(".span_vat_amount").html("Rs " + formatNumber($("#old_vat_amount").val()));
                            }
                        }
                    }
                }
            } else {
                $("#span_delivery_name").html(
                    '<small class="text-red-600 ml-2">You have to select a Delivery Method</small>');
                $("#span_delivery_fee").html("");
                $(".span_vat_amount").html("Rs " + formatNumber($("#old_vat_amount").val()));
                $(".span_amount").html("Rs " + formatNumber($("#old_amount").val()));
                $("#amount").val($("#old_amount").val());
                $("#vat_amount").val($("#old_vat_amount").val());
            }
        }

        function formatNumber(number) {
            number = parseFloat(number);
            number = number.toFixed(2) + '';
            x = number.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
    <script type="text/javascript">
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }

        function cancelCallback() {
            console.log('Payment cancelled');
        }
        Checkout.configure({
            session: {
                id: 'SESSION0002301073293F3449692F97'
            },
            interaction: {
                merchant: {
                    name: 'Ecom shop',
                    address: {
                        line1: 'Str ',
                        line2: 'MRU'
                    }
                }
            }
        });
    </script>
    <script>
        function togglePasswordField() {
            var passwordField = document.getElementById('password_field');
            var createAccountCheckbox = document.getElementById('create_account');
            var passwordInput = document.getElementById('password');

            if (createAccountCheckbox.checked) {
                passwordField.classList.remove('hidden');
            } else {
                passwordField.classList.add('hidden');
            }
        }
    </script>
@endsection
