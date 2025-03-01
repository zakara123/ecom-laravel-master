<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order #{{$sales->id}} Failed - Ecom</title>
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
    <div class="container mx-auto mt-4">
      <div class="flex shadow-md my-2">
        <div class="w-2/3 bg-white px-10 py-5">
          <div class="flex justify-between border-b pb-8">
            <h1 class="font-semibold text-2xl">Order #{{$sales->id}} Failed</h1>
          </div>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(isset($order_payment_method->failed) && !empty($order_payment_method->failed))
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-2 text-md">{!!$order_payment_method->failed!!}</h3>
                </div>
                @else
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-2 text-md">Your order Sale ID#{{$sales->id}} has payment error.</h3>
                </div>
                @endif
            </div>
          <div class="bg-white mt-5 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="font-semibold mb-2 text-md">Customer Information</h3>
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

        <div id="summary" class="w-1/3 items-center px-5 py-5">

          <h1 class="font-semibold text-2xl border-b pb-6">Order Summary</h1>
          @foreach ($sales_products as $item)
          <div class="flex justify-between mt-5 mb-5">
            <span class="font-semibold text-sm">{{$item->product_name}}</span>
            <span class="font-semibold text-sm">Rs {{ $item->quantity * $item->order_price }}</span>
          </div>
          @endforeach
          <div class="border-t mt-5">
            <div class="flex font-semibold justify-between py-2 text-sm">
              <span>VAT Amount</span>
              <span>Rs {{$sales->tax_amount}}</span>
            </div>
            <div class="flex font-semibold justify-between py-2 text-sm">
              <span>Subtotal</span>
              <span>Rs {{$sales->subtotal}}</span>
            </div>
            <div class="flex font-semibold justify-between py-2 text-sm">
              <span>Total cost</span>
              <span class="span_amount">Rs {{$sales->amount}}</span>
            </div>
            </div>
        </div>
      </div>
    </div>
    @include('front.default.layouts.footer')
<script src="https://mcb.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="errorCallback" data-cancel="cancelCallback"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
