@php
    $result = \App\Models\Setting::where('key', 'sticky_banner_header')->first();
    if ($result) {
        // Access the key and value properties
        $key = $result->key;
        $value = $result->value;
        echo $value;
    }
    $theme = \App\Models\Setting::get()?->where('key', 'store_theme')->value('value') ?? 'default';

    $headerMenus = \App\Services\CommonService::getHeaderMenus();
    $headerMenuColor = \App\Models\HeaderMenuColor::latest()->first();

    $session_id = Illuminate\Support\Facades\Session::get('session_id');
    $carts = $session_id
        ? \App\Models\Cart::with([
            'productImage' => function ($query) {
                $query->where('active_thumbnail', 1)->orWhereNull('active_thumbnail')->orderByDesc('active_thumbnail');
            },
        ])
            ->where('session_id', $session_id)
            ->get()
        : [];
@endphp

<style>
    .nav-bg {
        background-color: #FFFFFF !important;
    }

    .main-button::before,
    .main-button::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        height: 1px;
        /* Thickness of the line */
        background-color: white;
        /* Color of the line */
    }

    .main-button::before {
        top: 3px;
        /* Position above the button */
    }

    .main-button::after {
        bottom: 3px;
        /* Position below the button */
    }

    .main-button {
        position: relative;
        background: #B05C50;
        border: none;
        color: #ffffff;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 6px 2px;
        cursor: pointer;
    }

    nav .main-button {
        padding: 15px 20px;

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


    .main-button::before {
        top: 3px;
        /* Position above the button */
    }

    .main-button::after {
        bottom: 3px;
        /* Position below the button */
    }

    @media only screen and (max-width: 768px) {
        .header-mobile {
            display: block;
            width: 100%;
            clear: both;
            z-index: 9999;
            padding: 0 0 0.5rem;
        }

        .no-js .owl-carousel,
        .owl-carousel.owl-loaded {
            overflow: hidden;
            position: relative;
            z-index: 5;
        }

        .spacer {
            clear: both;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            height: auto;
        }

    }
</style>
<!--Nav-->
<nav id="header" class="w-full z-30 top-0 py-1 md:my-8 header-mobile">
    <div style="display: none">{{ 'nav in trokotia' . $theme }}</div>
    <div
        class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-3 px-4 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14">

        @if (count($headerMenus))
            <button data-collapse-toggle="navbar-solid-bg" type="button"
                class="inline-flex items-center p-2 ml-0 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 ring-2 ring-gray-100 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-solid-bg" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="hidden w-full md:block md:flex md:items-center md:w-auto w-full order-3 md:order-1"
                id="navbar-solid-bg">
                @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                    <ul id="navbar-multi-level"
                        class="flex flex-row gap-2 justify-center md:justify-left rounded-lg bg-gray-50 flex-row space-x-8 mt-4 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
                        @foreach ($headerMenus as $item)
                            @if (isset($item->children) && !empty($item->children) && count($item->children) > 0)
                                <li data-dropdown-toggle-parent="dropdownNavbarLink{{ $item->id }}"
                                    class="p-2 mt-4 li_level li_level_multi  rounded-lg border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700">
                                    <button id="dropdownNavbarLink{{ $item->id }}"
                                        data-dropdown-toggle="dropdownNavbar{{ $item->id }}"
                                        class="flex justify-between items-center py-2 pr-4 pl-3 w-full font-medium text-gray-700 border-b border-gray-100  md:hover:bg-transparent md:border-0  md:p-0 md:w-auto  dark:border-gray-700 ">
                                        {{ $item->title }}
                                        <svg class="ml-1 w-4 h-4" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg></button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownNavbar{{ $item->id }}"
                                        class="absolute top-12 md:top-8 -left-12 md:left-0 hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                                        <ul class="text-sm text-gray-700 dark:text-gray-400"
                                            aria-labelledby="dropdownLargeButton{{ $item->id }}">
                                            @foreach ($item->children as $item_children)
                                                @if (isset($item_children->child_of_child) &&
                                                        !empty($item_children->child_of_child) &&
                                                        count($item_children->child_of_child) > 0)
                                                    <li data-dropdown-toggle-parent="doubleDropdownButton{{ $item_children->id }}"
                                                        class="p-2 mt-4 border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700"
                                                        aria-labelledby="dropdownNavbarLink{{ $item_children->id }}">
                                                        <button id="doubleDropdownButton{{ $item_children->id }}"
                                                            data-dropdown-toggle="doubleDropdown{{ $item_children->id }}"
                                                            data-dropdown-placement="right-start" type="button"
                                                            class="flex justify-between items-center py-2 px-4 w-full ">
                                                            {{ $item_children->title }}
                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg></button>
                                                        <div id="doubleDropdown{{ $item_children->id }}"
                                                            class="navbardropdown hidden z-40 w-44  rounded divide-y divide-gray-100 shadow dark:bg-gray-700"
                                                            data-popper-reference-hidden="" data-popper-escaped=""
                                                            data-popper-placement="right-start"
                                                            style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(10px, 0px);">
                                                            <ul class="text-sm text-gray-700 dark:text-gray-200"
                                                                aria-labelledby="doubleDropdownButton{{ $item_children->id }}">
                                                                @foreach ($item_children->child_of_child as $item_child_of_child)
                                                                    @if (isset($item_child_of_child->child_of_childrends) &&
                                                                            !empty($item_child_of_child->child_of_childrends) &&
                                                                            count($item_child_of_child->child_of_childrends) > 0)
                                                                        <li data-dropdown-toggle-parent="doubleDropdownButton{{ $item_children->id }}"
                                                                            aria-labelledby="dropdownNavbarLink{{ $item_child_of_child->id }}"
                                                                            class="py-1 text-sm text-gray-700 dark:text-gray-20">
                                                                            <button
                                                                                id="doubleDropdownButton{{ $item_child_of_child->id }}"
                                                                                data-dropdown-toggle="doubleDropdown{{ $item_child_of_child->id }}"
                                                                                data-dropdown-placement="right-start"
                                                                                type="button"
                                                                                class="flex justify-between items-center py-2 px-4 w-full ">
                                                                                {{ $item_child_of_child->title }}
                                                                                <svg aria-hidden="true" class="w-5 h-5"
                                                                                    fill="currentColor"
                                                                                    viewBox="0 0 20 20"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                                        clip-rule="evenodd"></path>
                                                                                </svg></button>
                                                                            <div id="doubleDropdown{{ $item_child_of_child->id }}"
                                                                                class=" navbardropdown hidden z-40 w-44  rounded divide-y divide-gray-100 shadow dark:bg-gray-700"
                                                                                data-popper-reference-hidden=""
                                                                                data-popper-escaped=""
                                                                                data-popper-placement="right-start"
                                                                                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(10px, 0px);">
                                                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                                                    aria-labelledby="doubleDropdownButton{{ $item_child_of_child->id }}">
                                                                                    @foreach ($item_child_of_child->child_of_childrends as $item_child_of_children)
                                                                                        <li
                                                                                            class="p-2 mt-4 li_level li_level_4 border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700">
                                                                                            <a href="{{ $item_child_of_children->link }}"
                                                                                                class="block py-2 px-4">{{ $item_child_of_children->title }}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @else
                                                                        <li
                                                                            class="p-2 mt-4 li_level li_level_3 border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700">
                                                                            <a href="{{ $item_child_of_child->link }}"
                                                                                class="block py-2 px-4">{{ $item_child_of_child->title }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li
                                                        class="p-2 mt-4 li_level li_level_2 border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700">
                                                        <a href="{{ $item_children->link }}"
                                                            class="block py-2 px-4 ">{{ $item_children->title }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li
                                    class="p-2 mt-4 li_level li_level_1  border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0  dark:border-gray-700">
                                    <a href="{{ $item->link }}" class="block py-2 pr-4 pl-3  rounded  md:p-0 "
                                        aria-current="page">{{ $item->title }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <div class="order-1 md:order-2">
            <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                href="/">

                @if (isset($company->logo) && !empty(@$company->logo))
                    <img src="{{ @$company->logo }}" alt="..." style="width:auto; height:55px;">
                @else
                    <img src="{{ url('front/img/ECOM_L.png') }}" alt="..." style="width:130px; height:auto;">
                @endif
            </a>
        </div>

        <div class="order-2 md:order-3 flex items-center mr-2" id="nav-content">

            <a class="inline-block no-underline hover:text-black" href="{{ route('login') }}">
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.2816 4.2442C11.2816 6.01748 9.8272 7.46246 8.02388 7.46246C6.22056 7.46246 4.76618 6.01748 4.76618 4.2442C4.76618 2.47093 6.22056 1.02594 8.02388 1.02594C9.8272 1.02594 11.2816 2.47093 11.2816 4.2442Z"
                        stroke="currentColor" stroke-width="0.809698"></path>
                    <path
                        d="M1 16.5024C1 13.5909 1.70241 8.95898 8.02406 8.95898C14.3457 8.95898 15.0481 13.5909 15.0481 16.5024H2.31701"
                        stroke="currentColor" stroke-width="0.809698"></path>
                </svg>
            </a>
            @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))

                <div x-data="{ open: false }" class="mx-2">
                    <a href="{{ $theme == 'default' ? route('cart') : 'javascript:;' }}" role="button"
                        class="relative flex" @click="{{ $theme == 'default' ? 'open = false' : 'open = !open' }}">
                        <svg width="15" height="17" viewBox="0 0 15 17" fill="none"
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
                        <div x-show="open" class="fixed inset-y-0 right-0 z-50 w-96 nav-bg shadow-lg p-4"
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
                                        <div
                                            class="md:flex items-strech py-8 md:py-10 lg:py-8 border-t border-gray-50">
                                            <div
                                                class="md:w-4/12 2xl:w-1/4 w-full bg-gray-50 flex items-center justify-center p-2">

                                                @if (!empty($cart->productImage->src))
                                                    <img src="{{ $cart->productImage->src }}"
                                                        alt="{{ $cart->product_name }}"
                                                        class="w-96 object-center object-cover md:block hidden" />
                                                @else
                                                    <img class="w-96 object-center object-cover md:block hidden"
                                                        src="{{ url('front/img/ECOM_L.png') }}" alt="Default Image">
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

                                                @if ($variationReadable)
                                                    @foreach ($variationReadable as $attribute => $value)
                                                        <p class="text-xs leading-3 text-gray-600 py-2">
                                                            {{ $attribute }}: {{ $value }}</p>
                                                    @endforeach
                                                @else
                                                    <p class="text-xs leading-3 text-gray-600 py-2">No variation</p>
                                                @endif

                                                <?php } ?>

                                                <p class="text-xs leading-3 text-gray-600 py-4">
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
                                        class="text-center font-semibold hover:bg-gray-600 py-3 text-sm text-white w-full main-button"style="background:#B05C50">View
                                        Cart</a>
                                </div>


                            </div>
                        </div>
                </div>

            @endif

        </div>
        @endif

    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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
