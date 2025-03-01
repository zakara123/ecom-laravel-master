<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Ecom</title>
    <style>
        #summary {
            background-color: #f6f6f6;
        }

    </style>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $shop_favicon }}">
    <link rel="icon" type="image/png" href="{{ $shop_favicon }}">

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/ie.min.css" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <style>
        #header_front {
            color: @if (isset($headerMenuColor->header_color)) {{$headerMenuColor->header_color}} @else #fff @endif;
            background-color:@if (isset($headerMenuColor->header_background)) {{
            $headerMenuColor->header_background
        }}@else #111433 @endif;
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
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
    @include('front.default.layouts.header')
    @foreach ($errors->all() as $error)
    <span class="text-red-600 text-sm">
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">Error : </span> {{ $error }}
        </div>
    </span>
    @endforeach
    <div class="container mx-auto mt-4">
        <div class="flex  my-2 h-96 flex items-center justify-center shadow-md my-2">
            <div class="">
                <div class="">
                    <h1 class="font-semibold mb-2 text-2xl">Redirecting you to MCB Secured Payment Gateway!</h1>
                </div>
            </div>
        </div>
    </div>
    <button type="button" hidden id="payement" onclick="Checkout.showPaymentPage();" class="bg-gray-100 font-semibold hover:bg-gray-300 py-3 text-sm w-full">PROCESS MCB PAYEMENT</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://mcb.gateway.mastercard.com/static/checkout/checkout.min.js"
    data-error="errorCallback"
    data-cancel="{{ route('cart') }}"
    data-complete="{{ route('save-mcb-payment',$sales->id) }}"
    data-beforeRedirect="Checkout.saveFormFields"
    data-afterRedirect="Checkout.restoreFormFields"
    ></script>

    @if($session_id != '' && $sales->status != 'Paid')
    <script type="text/javascript">
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }

        var merchantId = "0000022921";
        @if(isset($setting_mcb_merchant_id))
        merchantId = "{{  $setting_mcb_merchant_id->value  }}"
        @endif
        Checkout.configure({
            merchant: { id: merchantId,  name : @if(isset($store_name) && !empty($store_name)) "{{ $store_name }}" @else "Shop Ecom" @endif },
            order: {id: {{ $sales->id }},
            description: "Pay for order ID #{{ $sales->id }} via SECURED PAYMENT GATEWAY",
            customerOrderDate: "{{ date('Y-m-d', strtotime($sales->created_at)) }}",
            customerReference: "ID {{ $sales->id }}",
            reference: "ID {{ $sales->id }}"
            },
            session: {
                id: "{{ $session_id }}"
            },

            customer: {
                email: "{{ $sales->customer_email}}",
                firstName: "{{ $sales->customer_firstname }}",
                lastName: "{{ $sales->customer_lastname }}",
                phone: "{{ $sales->customer_phone }}"
            },
             interaction: {
                merchant: {
                    name: "@if(isset($store_name) && !empty($store_name)) {{ $store_name }} @else Shop Ecom @endif",
                    address: {
                        line1: "@if(isset($store_address) && !empty($store_address)) {{ $store_address }} @else Address test 1 @endif"
                    }
                }
            }

        });
        $(document).ready(function() {
            $('#payement').click();
        });

    </script>
    @endif
</body>


</html>
