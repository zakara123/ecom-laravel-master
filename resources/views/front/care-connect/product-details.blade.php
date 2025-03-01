@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    $totalProductImages = !empty($images) ? count($images) : 1;

    $images = $product->images;
    $productCategory = $product->categories;
    $variations = $product->variations;

    $variationImages = $product->variations
        ->map(function ($variation) {
            return $variation->imagesVariation;
        })
        ->flatten()
        ->all(); // Convert to plain array if needed

    $variationThumbnails = $product->variations
        ->map(function ($variation) {
            return $variation->variationThumbnail;
        })
        ->flatten()
        ->all(); // Convert to plain array if needed

    $defaultProductImage = 'front/img/ECOM_L.png';

    $stock_api_final = [];
    $displayedVariationImages = [];

@endphp

@extends('front.' . $theme . '.layouts.app')

@section('customStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css"
        integrity="sha512-yxWNfGm+7EK+hqP2CMJ13hsUNCQfHmOuCuLmOq2+uv/AVQtFAjlAJO8bHzpYGQnBghULqnPuY8NEr7f5exR3Qw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css"
        integrity="sha512-Rck8F2HFBjAQpszOB9Qy+NVLeIy4vUOMB7xrp46edxB3KXs2RxXRguHfrJqNK+vJ+CkfvcGqAKMJTyWYBiBsGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" rel="stylesheet">

    {{-- font end --}}


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

        .decription menu,
        .decription ol,
        .decription ul {
            list-style: auto !important;
            margin: auto !important;
        }
    </style>
    <style>
        /* care connect button start */
        .care-connect-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #00e3c3;
            /* Initial magenta background */
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hover effect */
        .care-connect-button:hover {
            background-color: #d80c7e;
            /* Hover teal background */
        }

        /* care connect button end */
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

        .object-cover-multiple {
            display: none;
        }

        .object-cover-multiple.active {
            display: block;
        }

        .main-thumb-image,
        .cover-item {
            border: none;
        }

        .main-thumb-image {
            border: solid 1px;
            border-radius: 20px;
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

        button:disabled {
            background-color: rgba(31, 41, 55, var(--tw-bg-opacity));
            /* Light gray color */
            color: #a1a1a1;
            /* Gray text color */
            cursor: not-allowed;
            /* Not-allowed cursor */
            opacity: 0.6;
            /* Semi-transparent */
        }

        button.disabled {
            background-color: #d3d3d3;
            /* Light grey */
            cursor: not-allowed;
        }
    </style>
    <style>
        .desc-table table {
            border-collapse: collapse;
            width: 100% !important;
            border: 1px solid #ddd;

        }

        .desc-table th,
        .desc-table td {
            border: 1px solid #ddd;

        }

        .desc-table tr {
            height: 34px !important;

        }

        .desc-table td,
        .desc-table span,
        .desc-table p {
            font-size: 0.9rem !important;
        }

        .cover-item {
            border-radius: 20px !important;
            border: none !important;
        }

        header {
            padding-bottom: 1.75rem;
        }
    </style>


    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif
    @if ($theme === 'care-connect')
        {{-- font start --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
            rel="stylesheet">

        <style>
            * {
                font-family: "Inter", serif !important;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: "Merriweather", serif !important;
            }
        </style>
    @endif
@endsection

@section('content')
    <section class=" " style="flex-grow:1;">

        <div class="mx-auto lg:ml-8 md:rounded-l-3xl items-center relative flex-wrap pb-12"
            style="background-color: var(--alternate-color);">

            @if (Session::has('error_message'))
                <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                </div>
            @endif
            <section class="text-gray-700 body-font overflow-hidden ">
                <div class="container px-5 pt-8 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
                    <div class="lg:w-full mx-auto flex flex-wrap py-14">
                        <div class="lg:w-1/2 pswp-gallery my-gallery" style="cursor: zoom-in;" id="forcedgallery">
                            <div class="product__thumbs product__thumbs--beside product__thumbs-placement--left float-left hidden_mobile"
                                style="margin: 0 10px;">
                                @if (count($images) >= 1 || count($variationImages) >= 1)
                                    <div class="container thumbnail-img-block thumb_div_img mx-auto space-y-2 lg:space-y-2">
                                        @php $i = 1 @endphp
                                        @foreach ($images as $image)
                                            <div class="thumb-image btn_photoswipe_img w-full bg-white rounded hover:opacity-90 hover:shadow-xl mb-2 @if ($i == 1) active @endif main-thumb-image"
                                                data-src_target="item-image-{{ $i }}"
                                                data-thumb_swipe="{{ $i }}">
                                                <img src="{{ $image->src }}" alt="{{ $product->name }}" width="300"
                                                    height="300" style="border-radius: 20px;">
                                            </div>
                                            @php $i++ @endphp
                                        @endforeach
                                        @if (isset($variationImages) && !empty($variationImages))
                                            @foreach ($variationImages as $imagev)
                                                <div class="thumb-image btn_photoswipe_img w-full bg-white rounded hover:opacity-90 hover:shadow-xl mb-2 @if ($i == 1) active @endif variation-thumb-image"
                                                    data-src_target="item-image-{{ $i }}"
                                                    data-thumb_swipe="{{ $i }}"
                                                    data-variation_id="{{ $imagev->product_variation_id }}">
                                                    <img src="{{ $imagev->src }}" alt="{{ $product->name }}"
                                                        width="300" height="300" style="border-radius: 20px;">
                                                </div>
                                                @php $i++ @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="product__main-photos w-full hidden_mobile">
                                @if (empty($images))
                                    <div class="cover-item btn_photoswipe main-cover-image bg-white active" id="cover-item"
                                        style="font-family:'hans';overflow: hidden; border-radius: 20px;" data-swipe="1">
                                        <img alt="{{ $product->name }}" class="object-cover object-center w-full "
                                            style=" border: 1px solid; border-radius: 20px;"
                                            @if (!empty($image_cover) > 0) src="{{ $image_cover->src }}"
                                             @else
                                                 @if (isset($company->logo) && !empty(@$company->logo))
                                                     src="{{ @$company->logo }}"
                                             @else
                                                 src="{{ url('front/img/ECOM_L.png') }}" @endif
                                            @endif
                                        >
                                    </div>
                                @else
                                    @php $i = 1 @endphp
                                    @foreach ($images as $image)
                                        <div class="cover-item btn_photoswipe main-cover-image bg-white @if ($i == 1) active @endif"
                                            id="cover-item{{ $i }}" data-swipe="{{ $i }}"
                                            style="font-family:'hans';overflow: hidden; border-radius: 20px;">
                                            <img alt="{{ $product->name }}" id="item-image-{{ $i }}"
                                                style=" border: 1px solid; border-radius: 20px;"
                                                class="object-cover-multiple @if ($i == 1) active @endif object-center w-full"
                                                @if (!empty($image->src) > 0) src="{{ $image->src }}"
                                                 @else
                                                     @if (isset($company->logo) && !empty(@$company->logo))
                                                         src="{{ @$company->logo }}"
                                                 @else
                                                     src="{{ url('front/img/ECOM_L.png') }}" @endif
                                                @endif
                                            >
                                        </div>
                                        @php $i++ @endphp
                                    @endforeach
                                    @if (!empty($variationImages))
                                        @foreach ($variationImages as $imagev)
                                            <div class="cover-item btn_photoswipe variation-cover-image"
                                                id="cover-item{{ $i }}" data-swipe="{{ $i }}"
                                                style="position: relative; overflow: hidden; border-radius: 20px;"
                                                data-variation_id="{{ $imagev->product_variation_id }}">
                                                <img alt="{{ $product->name }}" id="item-image-{{ $i }}"
                                                    style=" border: 1px solid; border-radius: 20px;"
                                                    class="object-cover-multiple @if ($i == 1) active @endif object-center w-full"
                                                    src="{{ $imagev->src }}">
                                            </div>
                                            @php $i++ @endphp
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            <div class="product__main_photos_mobile w-full hidden_desktop">
                                @include('front.components.mobile-layout-slider')
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                            <div class="flex">
                                <div class="flex-center">
                                    @if (count($productCategory) > 0)
                                        <h2 class="text-sm title-font tracking-widest text-capitalize">
                                            @foreach ($productCategory as $key => $c)
                                                <a
                                                    href="{{ route('category-product', $c->slug) }}">{{ strtoupper($c->slug) }}</a>
                                                @if ($key !== $productCategory->keys()->last())
                                                    /
                                                @endif
                                            @endforeach
                                        </h2>
                                    @else
                                        <h2 class="text-sm title-font tracking-widest text-capitalize"><a
                                                href="{{ route('category-product', 0) }}">{{ strtoupper(__('Uncategorized')) }}</a>
                                        </h2>
                                    @endif
                                </div>
                            </div>

                            <h1 class="text-gray-900 text-2xl title-font font-medium mb-1 text-green-800 hover:text-green-400"
                                style="font-family: 'Merriweather', serif;">
                                {{ $product->name }}
                            </h1>



                            <form id="addToCartForm" action="{{ route('add-cart') }}" method="POST">
                                @csrf

                                <script>
                                    var variation_price = [];
                                    var array_color_inside_size = [];
                                    var array_size_inside_color = [];
                                    var array_size_api = [];
                                </script>
                                @if ($product->is_variable_product == 'yes')
                                    <script>
                                        var variation_price = [];
                                        var array_color_inside_size = [];
                                        var array_size_inside_color = [];
                                    </script>
                                    <div class="w-full overflow-hidden">
                                        <div class="w-full overflow-hidden">
                                            <p class="leading-relaxed">
                                                @if (empty($api_product))
                                                    {{--                                                @if ($product->description) --}}
                                                    {{--                                                    {!!$product->description !!} --}}
                                                    {{--                                                @endif --}}
                                                @else
                                                    {!! $product->description !!}
                                                @endif

                                            </p>
                                            <br>
                                        </div>

                                @endif

                                @php
                                    $hasValidThumbnails =
                                        !empty($variationThumbnails) &&
                                        collect($variationThumbnails)->contains(fn($thumbnail) => !is_null($thumbnail));
                                    $hasValidVariations = !empty($variations) && $variations->isNotEmpty();
                                @endphp

                                @if ($hasValidThumbnails)
                                    <div class="flex flex-wrap gap-4 py-4">
                                        @foreach ($variationThumbnails as $variationThumbnail)
                                            @if (!empty($variationThumbnail) && !in_array($variationThumbnail->src, $displayedVariationImages))
                                                @php
                                                    $displayedVariationImages[] = $variationThumbnail->src;
                                                @endphp
                                                <div class="w-24">
                                                    <img src="{{ $variationThumbnail->src }}"
                                                        alt="{{ $variationThumbnail->name }}"
                                                        class="object-contain hover:object-scale-down w-full h-full variation-image"
                                                        data-variation-id="{{ $variationThumbnail->product_variation_id }}"
                                                        style="cursor: pointer;">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                @if ($hasValidVariations)
                                    <div class="mb-2 z-0 w-full group">
                                        <div id="dropdown-container"></div>
                                    </div>
                                @endif

                                @if ($product->is_rental_product === 'no')
                                    <span id="getProductPrice" class="text-lg">Rs
                                        {{ number_format($product->price, 2) }}</span>

                                    <br>
                                @else
                                    <span class="text-lg">Purchase Price: </span> <span id="getProductPrice"
                                        class="text-lg"> Rs
                                        {{ number_format($product->price, 2) }}</span>

                                    <br>
                                    <span class="text-lg">Rental Price as from: Rs
                                        {{ number_format($product->rental_price, 2) }}@if(!empty($product->unit_rental_label))/{{ $product->unit_rental_label }} @endif
                                    </span>
                                    <br>
                                @endif

                                <div class="flex items-center flex-wrap gap-5 mt-2">
                                    <div class="custom-number-input h-10 w-32">
                                        <div class="flex flex-row h-10 w-full rounded-lg bg-transparent">
                                            <button type="button" data-action="decrement"
                                                class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                <span class="m-auto text-2xl font-thin">−</span>
                                            </button>
                                            <input type="number"
                                                class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                name="quantity" value="1"></input>
                                            <button type="button" data-action="increment"
                                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                <span class="m-auto text-2xl font-thin">+</span>
                                            </button>
                                        </div>
                                    </div>
                                    @php
                                        $have_stock_api = 'no';
                                        foreach ($stock_api_final as $stock) {
                                            $stock = (object) $stock;
                                            if (
                                                $stock->location != 'La Casse' &&
                                                $stock->location != 'Bata Industrial' &&
                                                $stock->location != 'Cobbler' &&
                                                $stock->location != 'Sample Issue'
                                            ) {
                                                $have_stock_api = 'yes';
                                            }
                                        }
                                    @endphp

                                    <div class="flex">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                                        <input type="hidden" id="product_price" name="product_price"
                                            value="{{ $product->price }}">
                                        <input type="hidden" id="product_variation_id" name="product_variation_id"
                                            value="">
                                        <input type="hidden" name="tax_sale" id="tax_sale"
                                            value="{{ $product->vat }}">
                                        <input type="hidden" name="have_stock_api" id="have_stock_api"
                                            value="{{ $have_stock_api }}">

                                        <button type="submit"
                                            class="
                                                px-6 py-2 text-white font-semibold transition-colors duration-300 focus:outline-none rounded
                                                @if ($theme === 'troketia') main-button t-cta sticky-mobile gold ml-auto btn-primary border-0
                                                @elseif ($theme === 'care-connect') bg-green-400 hover:bg-green-800
                                                @else t-cta sticky-mobile gold ml-auto btn-primary border-0 @endif
                                            "
                                            id="addToShoppingBag" disabled>
                                            <span>Add To Cart</span>
                                        </button>
                                        <div id="product-container"
                                            data-is-rental="{{ $product->is_rental_product == 'yes' ? 'true' : 'false' }}">
                                            @if ($product->is_rental_product == 'yes')
                                                <div class="flex items-center">
                                                    <div class="flex">

                                                        <button type="button"
                                                            class=" ml-3
                                                    px-6 py-2 text-white font-semibold transition-colors duration-300 focus:outline-none rounded
                                                    @if ($theme === 'troketia') main-button t-cta sticky-mobile gold ml-auto btn-primary border-0
                                                    @elseif ($theme === 'care-connect') bg-green-400 hover:bg-green-800
                                                    @else t-cta sticky-mobile gold ml-auto btn-primary border-0 @endif
                                                "
                                                            id="showButton">
                                                            <span>Request Rental</span>
                                                        </button>
                                                    </div>


                                                </div>
                                            @endif
                                        </div>


                                    </div>

                                </div>


                                {{-- <div id="product-container"
                                    data-is-rental="{{ $product->is_rental_product == 'yes' ? 'true' : 'false' }}">
                                    @if ($product->is_rental_product == 'yes')
                                        <div class="flex items-center mt-2">
                                            <div class="flex mt-8">


                                                <button type="button"
                                                    class="
                                                    px-6 py-2 text-white font-semibold transition-colors duration-300 focus:outline-none rounded
                                                    @if ($theme === 'troketia') main-button t-cta sticky-mobile gold ml-auto btn-primary border-0
                                                    @elseif ($theme === 'care-connect') bg-green-400 hover:bg-green-800
                                                    @else t-cta sticky-mobile gold ml-auto btn-primary border-0 @endif
                                                "
                                                    id="showButton">
                                                    <span>Request Rental</span>
                                                </button>
                                            </div>


                                        </div>
                                    @endif
                                </div> --}}
                            </form>
                            <div class="leading-relaxed desc-table description py-4"
                                style="font-family: 'Inter', sans-serif; color: #687276; text-align: justify;">
                                {!! $product->description !!}
                            </div>
                            <div style="margin-top: 10px;">Need help ? <a href=""style="color:#B05C50">Contact
                                    us</a></div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </section>
    </div>
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
            <div class="pswp__container">
                <!-- don't modify these 3 pswp__item elements, data is added later on -->
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                    <button class="pswp__button pswp__button--share" title="Share"></button>

                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>

    <!-- Main modal -->
    <div id="myModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Rental Request for {{ $product->name }}
                    </h3>
                    <button type="button" id="hideButton"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('add-rental-submission') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">

                            <div class="col-span-2 sm:col-span-1">
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name
                                    <span class="red-astrik">*</span></label>
                                <input type="text" name="rentalfirstname" id="rentalfirstname"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="First Name" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="last_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name
                                    <span class="red-astrik">*</span></label>
                                <input type="text" name="rentallastname" id="rentallastname"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Last Name" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="mobile_number"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mobile
                                    Number <span class="red-astrik">*</span></label>
                                <input type="text" name="rentalphone" onkeypress="validateInput(event)"
                                    id="rentalphone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Mobile Number" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                                    <span class="red-astrik">*</span></label>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Email" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="rental_start_date"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental
                                    Start Date <span class="red-astrik">*</span></label>
                                <input type="date" pattern="\d{2}/\d{2}/\d{4}" required=""
                                    name="rental_start_date" id="rental_start_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Rental Start Date">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="rental_end_date"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rental End
                                    Date</label>
                                <input type="date" pattern="\d{2}/\d{2}/\d{4}" name="rental_end_date"
                                    id="rental_end_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Rental End Date">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="dilvery_address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Delivery
                                    Address</label>
                                <input type="text" name="dilvery_address" id="dilvery_address"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Delivery Address">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="village_town"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Village/Town</label>
                                <input type="text" name="village_town" id="village_town"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Village/Town">
                            </div>
                        </div>
                        <input type="hidden" name="rental_product_id" value="{{ $product->id }}">
                        <input type="hidden" name="rental_product_name" value="{{ $product->name }}">
                        <input type="hidden" id="rental_product_price" name="rental_product_price"
                            value="{{ $product->rental_price }}">
                        <input type="hidden" name="tax_sale" id="tax_sale" value="{{ $product->vat }}">

                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Send Rental Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </section>
@endsection


@section('customScript')
    <!-- Flowbite JS -->
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.js"
        integrity="sha512-7jpTN4lfrURp41NL7vGXbMP+RPaf/1S5QlNMHLlkdBteN+X5znoT2P8ryCluqePOK79rpDWVPdq1+la4ijhIbQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js"
        integrity="sha512-2R4VJGamBudpzC1NTaSkusXP7QkiUYvEKhpJAxeVCqLDsgW4OqtzorZGpulE3eEA7p++U0ZYmqBwO3m+R2hRjA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js"
        integrity="sha512-SxO0cwfxj/QhgX1SgpmUr0U2l5304ezGVhc0AO2YwOQ/C8O67ynyTorMKGjVv1fJnPQgjdxRz6x70MY9r0sKtQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery.izoomify.js') }}"></script>
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

    <script>
        let general_array = [];
    </script>
    <script>
        function decrement(e) {
            const btn = e.target.parentNode.parentElement.querySelector(
                'button[data-action="decrement"]'
            );
            const target = btn.nextElementSibling;
            let value = Number(target.value);
            if (value > 1) value--;
            target.value = value;
        }

        function increment(e) {
            const btn = e.target.parentNode.parentElement.querySelector(
                'button[data-action="decrement"]'
            );
            const target = btn.nextElementSibling;
            let value = Number(target.value);
            value++;
            target.value = value;
        }

        const decrementButtons = document.querySelectorAll(
            `button[data-action="decrement"]`
        );

        const incrementButtons = document.querySelectorAll(
            `button[data-action="increment"]`
        );

        decrementButtons.forEach(btn => {
            btn.addEventListener("click", decrement);
        });

        incrementButtons.forEach(btn => {
            btn.addEventListener("click", increment);
        });
    </script>

    <script>
        var openPhotoSwipe = function($i) {
            $i -= 1;
            var pswpElement = document.querySelector('.pswp');
            var images = [];

            @if (isset($variationImages) && !empty($variationImages))
                @foreach ($variationImages as $imagev)
                    images.push({
                        src: '{{ $imagev->src }}',
                        className: 'variation-cover-image'
                    });
                @endforeach
            @endif

            @if (count($images) <= 0)
                images.push({
                    src: '@if (!empty($image) > 0){{ $image_cover->src }} @else @if (isset($company->logo) && !empty(@$company->logo)){{ @$company->logo }} @else {{ url('front/img/ECOM_L.png') }} @endif @endif',
                    className: 'main-cover-image'
                });
            @else
                @foreach ($images as $image)
                    images.push({
                        src: '@if (!empty($image) > 0) {{ $image->src }} @else @if (isset($company->logo) && !empty(@$company->logo)) {{ @$company->logo }} @else {{ url('front/img/ECOM_L.png') }}@endif @endif',
                        className: 'main-cover-image'
                    });
                @endforeach
            @endif

            initializePhotoSwipe(pswpElement, images, $i);
        };
        var click = 1;
        $(document).ready(function() {
            $('.lightbox_fixed').removeClass('hidden');

            $('.product__main-photos .btn_photoswipe').click(function() {
                var current_image = $(this).data('swipe');
                openPhotoSwipe(current_image);
            });

            $(".thumb-image").click(function() {
                let target_src = $(this).data("src_target");
                $(".thumb-image").removeClass('active');
                $(".object-cover-multiple").removeClass('active');
                $(this).addClass('active');
                $("#" + target_src).addClass('active');
                {
                    {
                        $('#cover-item img').attr('src', target_src);
                    }
                }
                var current_image_r = $(this).data('thumb_swipe');
                openPhotoSwipe(current_image_r);
            });
            $('.product__main-photos .btn_photoswipe_img').dblclick(function() {
                var current_image_t = $(this).data('thumb_swipe');
                openPhotoSwipe(current_image_t);
            });

            $('.js-zoom-icon').click(function() {
                var current_image = $(this).data('swipe');
                openPhotoSwipe(current_image);
            });

            $('.product__main-photos  .cover-item').izoomify();
            $(".thumb-image").hover(function() {
                let target_src = $(this).data("src_target");
                $(".thumb-image").removeClass('active');
                $(".object-cover-multiple").removeClass('active');
                $(this).addClass('active');
                $("#" + target_src).addClass('active');
                {
                    {
                        $('#cover-item img').attr('src', target_src);
                    }
                }
            });

            $('#stock_table').dataTable({
                "pageLength": 10,
                order: [1, 'asc']
            });

            if ($(window).width() <= 767) {

            }

        });

        $(window).resize(function() {
            if ($(window).width() <= 767) {

            }
        });
    </script>
    <script>
        function validateInput(event) {
            const key = String.fromCharCode(event.which);
            const validChars = '0123456789+-';

            if (!validChars.includes(key)) {
                event.preventDefault();
            }
        }

        // Get the current date
        var today = new Date().toISOString().split('T')[0];
        // Set the min attribute to today
        document.getElementById('rental_start_date').setAttribute('min', today);
        document.getElementById('rental_end_date').setAttribute('min', today);
    </script>

    <!-- Custom Script -->
    <script>
        const productVariations = @json($product_variations_array);
        const attributeData = @json($attributeMap);
        const variationImages = @json($variationImages);
        const productContainer = document.getElementById('product-container');
        const isRental = productContainer.getAttribute('data-is-rental') === 'true';
        const priceDisplay = document.getElementById('getProductPrice');
        const addToShoppingBagButton = document.getElementById('addToShoppingBag');
        let addToBagButtonShouldBeEnabled = false;

        // Disable the button by default
        addToShoppingBagButton.disabled = true;

        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('.variation-thumb-image').hide();
                $('.variation-cover-image').hide();
            });

            if (isRental) {
                let modalElement = document.getElementById('myModal');
                let myModal = new Modal(modalElement);

                document.getElementById('showButton').addEventListener('click', function() {
                    myModal.show();
                });

                document.getElementById('hideButton').addEventListener('click', function() {
                    myModal.hide();
                });
            }

            const selectedValues = {};
            const container = document.getElementById('dropdown-container');

            for (const attribute in attributeData) {
                createDropdown(attribute, attributeData[attribute]);
            }

            function createDropdown(attribute, data) {
                const div = document.createElement('div');
                div.classList.add('mb-6', 'z-0', 'w-full', 'group');

                const label = document.createElement('label');
                label.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900');
                label.htmlFor = attribute;
                label.textContent = attribute;
                div.appendChild(label);

                const select = document.createElement('select');
                select.name = attribute;
                select.id = attribute;
                select.classList.add('bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm',
                    'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-1/2', 'p-2.5');

                const defaultOption = document.createElement('option');
                defaultOption.text = `Choose a ${attribute}`;
                defaultOption.disabled = true;
                defaultOption.selected = true;
                select.appendChild(defaultOption);

                const uniqueValues = [...new Set(Object.keys(data))];
                uniqueValues.forEach(value => {
                    const option = document.createElement('option');
                    option.value = value;
                    option.textContent = value;
                    select.appendChild(option);
                });

                div.appendChild(select);
                container.appendChild(div);

                select.addEventListener('change', function() {
                    selectedValues[select.name] = select.value;
                    updateDropdowns(select.name);
                    checkAllDropdownsSelected();
                    updatePriceAndImage();
                });
            }

            function updateDropdowns(changedAttribute) {
                const keys = Object.keys(attributeData);
                const changedIndex = keys.indexOf(changedAttribute);

                if (changedIndex < keys.length - 1) {
                    const currentSelection = attributeData[changedAttribute][selectedValues[changedAttribute]];

                    if (!currentSelection || Object.keys(currentSelection.related).length === 0) {
                        for (let i = changedIndex + 1; i < keys.length; i++) {
                            const attribute = keys[i];
                            const select = document.getElementById(attribute);
                            if (select) {
                                select.innerHTML = `<option selected disabled>Choose a ${attribute}</option>`;
                                select.disabled = true;
                                select.parentElement.style.display = 'none';
                            }
                        }
                        checkAllDropdownsSelected();
                        return;
                    }

                    keys.slice(changedIndex + 1).forEach(nextAttribute => {
                        const relatedValues = currentSelection.related[nextAttribute] || [];
                        const nextSelect = document.getElementById(nextAttribute);
                        if (nextSelect) {
                            nextSelect.innerHTML =
                                `<option selected disabled>Choose a ${nextAttribute}</option>`;
                            if (relatedValues.length > 0) {
                                const uniqueRelatedValues = [...new Set(relatedValues)];
                                uniqueRelatedValues.forEach(value => {
                                    const option = document.createElement('option');
                                    option.value = value;
                                    option.textContent = value;
                                    nextSelect.appendChild(option);
                                });
                                nextSelect.disabled = false;
                                nextSelect.parentElement.style.display = 'block';
                            } else {
                                nextSelect.disabled = true;
                                nextSelect.parentElement.style.display = 'none';
                            }
                        }
                    });
                }
            }

            function updatePriceAndImage() {
                let is_variable_product = @json($product->is_variable_product);
                let prodPrice = parseFloat(@json($product->price));
                const selectedAttributes = Object.entries(selectedValues);

                if (is_variable_product === 'no') {
                    priceDisplay.textContent = "Rs " + prodPrice.toFixed(2);
                    document.getElementById('product_price').value = prodPrice.toFixed(2);
                }

                let matchedVariation = null;

                const selectedAttributesFormatted = selectedAttributes.reduce((acc, [attr, val]) => {
                    acc[attr.toLowerCase()] = val;
                    return acc;
                }, {});

                for (const variation of productVariations) {
                    const variationAttributes = variation.attributes.reduce((acc, {
                        attribute,
                        attribute_value
                    }) => {
                        acc[attribute.toLowerCase()] = attribute_value;
                        return acc;
                    }, {});

                    const isMatch = Object.keys(selectedAttributesFormatted).every(attr =>
                        variationAttributes[attr] === selectedAttributesFormatted[attr]
                    );

                    if (isMatch) {
                        matchedVariation = variation;
                        break;
                    }
                }

                // Assuming matchedVariation is defined and contains the necessary data
                if (matchedVariation) {
                    console.log(matchedVariation);

                    if (is_variable_product === 'yes') {
                        priceDisplay.textContent = "Rs " + prodPrice.toFixed(2);
                        document.getElementById('product_price').value = prodPrice.toFixed(2);

                        if (parseInt(matchedVariation.price) !== 0) {
                            let prodPrice = matchedVariation.price.toFixed(2);
                            priceDisplay.textContent = "Rs " + prodPrice;
                            document.getElementById('product_price').value = prodPrice;
                        }
                    }

                    // add variation id to cart form
                    document.getElementById('product_variation_id').value = matchedVariation.id;

                    if (variationImages.length > 0) {
                        $('.variation-thumb-image').hide();
                        $('.variation-cover-image').hide();
                    }
                    if (selectedAttributes.length > 0) {
                        displayVariationImages(matchedVariation.id);
                    }

                }

                if (is_variable_product === 'yes' && selectedAttributes.length === 0) {
                    priceDisplay.textContent = "Select your preferred choice for price";
                    document.getElementById('product_price').value = "Select your preferred choice for price";
                }
            }

            function checkAllDropdownsSelected() {
                const keys = Object.keys(attributeData);
                let buttonShouldBeEnabled = false;

                for (const attribute of keys) {
                    const selectElement = document.getElementById(attribute);
                    if (selectElement && selectElement.value && selectElement.value !== `Choose a ${attribute}`) {
                        const selectedValue = selectedValues[attribute];
                        if (attributeData[attribute][selectedValue].related && Object.keys(attributeData[attribute][
                                selectedValue
                            ].related).length === 0) {
                            buttonShouldBeEnabled = true;
                            break;
                        }
                    }
                }

                if (!buttonShouldBeEnabled) {
                    buttonShouldBeEnabled = keys.every(attribute => {
                        const selectElement = document.getElementById(attribute);
                        return selectElement && selectElement.value && selectElement.value !==
                            `Choose a ${attribute}`;
                    });
                }

                addToBagButtonShouldBeEnabled = buttonShouldBeEnabled;
                addToShoppingBagButton.disabled = !buttonShouldBeEnabled;
            }

            checkAllDropdownsSelected();
            updatePriceAndImage();
        });

        // Hide all images and reset classes
        function displayVariationImages(imgVariationId = 1) { // Default to 1
            $('.main-cover-image, .main-thumb-image, .variation-cover-image').hide();
            $('.variation-thumb-image, .thumb-image').removeClass('active');
            $('.cover-item > img').removeClass('active');

            // Display and manage variation cover images
            let variationCoverImageFound = false;
            $('.variation-cover-image').each(function(index) {
                if ($(this).data('variation_id') === imgVariationId) {
                    $(this).show();
                    if (!variationCoverImageFound) {
                        $(this).find('img').addClass('active');
                        variationCoverImageFound = true;
                    }
                }
            });

            // Display and manage variation thumbnail images
            let variationThumbImageFound = false;
            $('.variation-thumb-image').each(function(index) {
                if ($(this).data('variation_id') === imgVariationId) {
                    $(this).show();
                    if (!variationThumbImageFound) {
                        $(this).addClass('active');
                        variationThumbImageFound = true;
                    }
                }
            });

            // If no variation images are found, fallback to default images
            if (!variationCoverImageFound) {
                $('.cover-item').each(function() {
                    if ($(this).data('swipe') === 1) {
                        $(this).find('img').addClass('active');
                    }
                });
                $('.thumb-image').each(function() {
                    if ($(this).data('src_target') === 'item-image-1') {
                        $(this).addClass('active');
                    }
                });
                $('.main-cover-image, .main-thumb-image').show();
            }
        }

        $(document).ready(function() {
            function applyBorder() {
                $('.object-cover-multiple').each(function() {
                    if ($(this).hasClass('active')) {
                        $(this).parent().css({
                            'border': 'solid 1px',
                            'border-radius': '20px'
                        });
                    } else {
                        $(this).parent().css({
                            'border': '',
                            'border-radius': ''
                        });
                    }
                });
            }

            // Initial check
            applyBorder();

            // Monitor changes in the active class
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    applyBorder();
                });
            });

            observer.observe(document.querySelector('.object-cover-multiple'), {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>

    <script src="{{ asset('assets/js/product-page.js') }}"></script>
@endsection
