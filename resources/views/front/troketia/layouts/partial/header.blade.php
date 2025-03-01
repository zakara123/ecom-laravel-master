@php
    $headerMenus = \App\Services\CommonService::getHeaderMenus();        $headerMenuColor = \App\Models\HeaderMenuColor::latest()->first();

    $session_id = Illuminate\Support\Facades\Session::get('session_id');
    $carts = $session_id ? \App\Models\Cart::with(['productImage' => function($query) {
        $query->where('active_thumbnail', 1)->orWhereNull('active_thumbnail')->orderByDesc('active_thumbnail');
    }])->where('session_id', $session_id)->get() : [];

    $result = \App\Models\Setting::where('key', 'sticky_banner_header')->first();
if ($result) {
    // Access the key and value properties
    $key = $result->key;
    $value = $result->value;
    echo $value;
}
@endphp
<style>
    .main-button {
        position: relative;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

    .main-button::before,
    .main-button::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        height: 2px;
        /* Thickness of the line */
        background-color: white;
        /* Color of the line */
    }

    nav .main-button {
        padding: 14px 20px;

    }

    .main-button::before {
        top: 3px;
        /* Position above the butto n */
    }

    .main-button::after {
        bottom: 3px;
        /* Position below the button */
    }

    .text-light-red {
        color: #f38a73;
    }

    input.text-light-red::placeholder {
        color: inherit;
        /* This makes the placeholder use the color from .text-light-red */
    }
</style>
<nav class="bg-[#f7f5f1] w-full hidden md:block pt-10">

    <div class="bg-[#f7f5f1] w-full flex items-center justify-center">
        <a href="{{ url('/') }}">
            @if (isset($company->logo) && !empty(@$company->logo))
                <img src="{{ asset(@$company->logo) }}" alt="logo" class="h-20">
            @else
                <img src="{{ asset('front/img/ECOM_L.png') }}" alt="logo" class="h-10 ">
            @endif
        </a>
    </div>

    <div class="flex justify-start text-black px-12 p-2">
        <div class="text-light-red flex gap-1 items-center">
            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M13.4902 7.73285C13.4902 11.3692 10.5723 14.309 6.9826 14.309C6.08258 14.309 5.22632 14.1247 4.44784 13.7917C3.75594 13.4957 3.12471 13.0819 2.579 12.5748C2.07429 12.1058 1.64307 11.5572 1.30488 10.9489C0.776594 9.99871 0.475 8.90217 0.475 7.73285C0.475 4.09652 3.39292 1.15664 6.9826 1.15664C10.5723 1.15664 13.4902 4.09652 13.4902 7.73285Z"
                    stroke="#f38a73" stroke-width="0.95"></path>
                <path d="M12.6289 13.4102L15.5157 16.3256" stroke="#f38a73" stroke-width="0.85"></path>
            </svg>
            <input type="text" placeholder="Search"
                class="p-2 w-70 focus:outline-none focus:ring-0 bg-[#f7f5f1] text-light-red" style="background-color: #f7f5f1 !important;border-color: #f38a73;">
        </div>

        <div class="flex justify-center mx-auto gap-5 items-center">
            @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                @foreach ($headerMenus as $item)
                    <a href="{{ $item->link }}" class="text-xl font-semibold text-light-red hover:text-black">
                        {{ $item->title }}
                    </a>
                @endforeach
            @endif
        </div>

        <div class="text-[#b0736a] flex gap-2 items-center ml-auto">

            <a class="inline-block no-underline hover:text-black" href="{{ route('login') }}">
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.2816 4.2442C11.2816 6.01748 9.8272 7.46246 8.02388 7.46246C6.22056 7.46246 4.76618 6.01748 4.76618 4.2442C4.76618 2.47093 6.22056 1.02594 8.02388 1.02594C9.8272 1.02594 11.2816 2.47093 11.2816 4.2442Z"
                        stroke="#f38a73" stroke-width="0.809698"></path>
                    <path
                        d="M1 16.5024C1 13.5909 1.70241 8.95898 8.02406 8.95898C14.3457 8.95898 15.0481 13.5909 15.0481 16.5024H2.31701"
                        stroke="#f38a73" stroke-width="0.809698"></path>
                </svg>
            </a>
            @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))

                <div x-data="{ open: false }" class="mx-2">
                    <a href="{{ $theme == 'default' ? route('cart') : 'javascript:;' }}" role="button"
                        class="relative flex" @click="{{ $theme == 'default' ? 'open = false' : 'open = !open' }}">
                        <svg width="15" height="17" viewBox="0 0 15 17" fill="none" style="filter: invert(63%) sepia(12%) saturate(1936%) hue-rotate(322deg) brightness(99%) contrast(92%);"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.23535 9.82878V2.48418C6.23535 1.36893 7.13944 0.464844 8.25469 0.464844V0.464844C9.36994 0.464844 10.274 1.36893 10.274 2.48418V3.79284"
                                stroke="currentColor" stroke-width="0.809698" stroke-linecap="square"></path>
                            <path
                                d="M7.89644 5.44922H12.7474C13.0913 5.44922 13.378 5.71232 13.4075 6.05493L14.2309 15.6281C14.2641 16.0149 13.9591 16.3473 13.5708 16.3473H1.96995C1.58168 16.3473 1.27664 16.0149 1.30991 15.6281L2.13329 6.05493C2.16276 5.71232 2.44946 5.44922 2.79334 5.44922H4.50922"
                                stroke="currentColor" stroke-width="0.809698" stroke-linecap="square"></path>
                        </svg>
                        <span
                            class="absolute right-0 top-0 bg-gray-400 rounded-full w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center"
                            style="margin-top: -3px;margin-right: -10px;">{{ count($carts) }}
                        </span>
                    </a>


                    @if (@$theme == 'troketia')
                        <div x-show="open" class="fixed inset-0 z-50 bg-black bg-opacity-50" style="display: none;">
                        </div>
                        <div x-show="open" class="fixed inset-y-0 right-0 z-50 w-96 bg-white shadow-lg p-4 nav-bg"
                            x-transition:enter="transform transition-transform duration-300 ease-out"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition-transform duration-300 ease-in"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            style="display: none;">

                            <div class="flex justify-end items-center">
                                <button @click="open = false" class="text-2xl">&times;</button>
                            </div>
                            <div class="mt-4">

                                @if (count($carts) > 0)

                                    <p class="text-base font-black leading-none text-gray-800 text-center mb-4">
                                        Product(s) added to the shopping bag</p>

                                    @foreach ($carts as $cart)
                                        <div class="md:flex items-strech py-8 md:py-10 lg:py-8 border-t border-gray-50">
                                            <div
                                                class="md:w-4/12 2xl:w-1/4 w-full bg-gray-50 flex items-center justify-center p-2">
                                                @if (isset($cart->product_image->src))
                                                    <img src="{{ $cart->product_image->src }}" alt="Gray Sneakers"
                                                        class="w-96 object-center object-cover md:block hidden" />
                                                @else
                                                    <img class="w-96 object-center object-cover md:block hidden"
                                                        src="{{ url('front/img/ECOM_L.png') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="md:pl-3 md:w-8/12 2xl:w-3/4 flex flex-col justify-center">

                                                <div class="w-full pt-1">
                                                    <p class="text-base font-black leading-none text-gray-800 ">
                                                        {{ $cart->product_name }}</p>
                                                    <p class="text-xs leading-3 text-gray-600 mt-2 pt-2">
                                                        Rs @if ($cart->tax_sale == '15% VAT' && $cart->tax_items == 'Added to the price')
                                                            {{ number_format($cart->product_price * $cart->quantity + $cart->product_price * 0.15 * $cart->quantity, 2, '.', ',') }}
                                                        @else
                                                            {{ number_format($cart->product_price * $cart->quantity, 2, '.', ',') }}
                                                        @endif
                                                    </p>
                                                </div>

                                                    <?php
                                                if(!empty($cart->product_variation_id)){
                                                    $variationReadable = \App\Models\ProductVariation::getReadableVariationById($cart->product_variation_id);
                                                    ?>

                                                @if($variationReadable)
                                                    @foreach($variationReadable as $attribute => $value)
                                                        <p class="text-xs leading-3 text-gray-600">{{ $attribute }}: {{ $value }}</p>
                                                    @endforeach
                                                @else
                                                    <p class="text-xs leading-3 text-gray-600">No variation</p>
                                                @endif

                                                <?php } ?>

                                                <p class="text-xs leading-3 text-gray-600">
                                                    Quantity: {{ $cart->quantity }}
                                                </p>

                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center justify-center">
                                        <p class="text-sm text-gray-400">No items in cart</p>
                                    </div>
                                @endif


                                <div class="flex justify-center mt-8 ">
                                    <a href="{{ route('cart') }}"
                                        class=" text-center font-semibold hover:bg-gray-600 py-3 text-sm text-white w-full main-button"
                                        style="background:#B05C50">View
                                        Cart</a>
                                </div>


                            </div>
                        </div>
                </div>

            @endif
        </div>
        @endif

    </div>

    </div>
</nav>

<nav class="bg-[#f7f5f1] w-full flex  justify-between md:hidden px-3 py-5">

    <div class="flex items-center" x-data="{ open: false }">
        <button class="focus:outline-none" @click="open = !open">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H20" stroke="#f38a73" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </button>

        <div x-show="open" class="fixed inset-0 z-50 bg-black bg-opacity-50" style="display: none;"></div>
        <div x-show="open" class="fixed inset-y-0 right-0 z-50 w-full bg-white shadow-lg p-4" style="display: none;"
            x-transition:enter="transform transition-transform duration-300 ease-out"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition-transform duration-300 ease-in"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <div class="flex justify-end items-center">
                <button @click="open = false" class="text-2xl">&times;</button>
            </div>
            <div class="mt-4">
                <div class="flex flex-col gap-4">
                    @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                        @foreach ($headerMenus as $item)
                            <a href="{{ $item->link }}" class="text-sm font-semibold">
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>



    <div class="bg-[#f7f5f1] w-full flex items-center justify-center">
        @if (isset($company->logo) && !empty(@$company->logo))
            <img src="{{ asset(@$company->logo) }}" alt="logo" class="">
        @else
            <img src="{{ asset('front/img/ECOM_L.png') }}" alt="logo" class="">
        @endif
    </div>



    <div class="text-[#b0736a] flex gap-2 items-center ml-auto">

        <a class="inline-block no-underline hover:text-black" href="{{ route('login') }}">
            <svg width="25" height="25" viewBox="0 0 16 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.2816 4.2442C11.2816 6.01748 9.8272 7.46246 8.02388 7.46246C6.22056 7.46246 4.76618 6.01748 4.76618 4.2442C4.76618 2.47093 6.22056 1.02594 8.02388 1.02594C9.8272 1.02594 11.2816 2.47093 11.2816 4.2442Z"
                    stroke="#f38a73" stroke-width="0.809698"></path>
                <path
                    d="M1 16.5024C1 13.5909 1.70241 8.95898 8.02406 8.95898C14.3457 8.95898 15.0481 13.5909 15.0481 16.5024H2.31701"
                    stroke="#f38a73" stroke-width="0.809698"></path>
            </svg>
        </a>

        @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
            <div x-data="{ open: false }" class="mx-2">
                <a href="{{ route('cart') }}" role="button" class="relative flex">
                    <svg width="25" height="25" viewBox="0 0 15 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.23535 9.82878V2.48418C6.23535 1.36893 7.13944 0.464844 8.25469 0.464844V0.464844C9.36994 0.464844 10.274 1.36893 10.274 2.48418V3.79284"
                            stroke="#f38a73" stroke-width="0.809698" stroke-linecap="square"></path>
                        <path
                            d="M7.89644 5.44922H12.7474C13.0913 5.44922 13.378 5.71232 13.4075 6.05493L14.2309 15.6281C14.2641 16.0149 13.9591 16.3473 13.5708 16.3473H1.96995C1.58168 16.3473 1.27664 16.0149 1.30991 15.6281L2.13329 6.05493C2.16276 5.71232 2.44946 5.44922 2.79334 5.44922H4.50922"
                            stroke="#f38a73" stroke-width="0.809698" stroke-linecap="square"></path>
                    </svg>
                    <span
                        class="absolute right-0 top-0 bg-gray-400 rounded-full w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center"
                        style="margin-top: -3px;margin-right: -10px;">{{ count($carts) }}
                    </span>
                </a>


            </div>
        @endif

    </div>


</nav>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#navbar-multi-level .li_level').hover(function() {
            let target = $(this).data('dropdown-toggle-parent');
            $('#' + target).click();
            $(this).removeClass('current_click');
            $(this).addClass('current_click');
        });
        $('#navbar-multi-level').hover(function() {

        }, function() {
            $('.current_click').click();
        });
    });
</script>
