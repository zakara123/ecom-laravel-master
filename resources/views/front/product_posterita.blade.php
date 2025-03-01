
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (isset($shop_name))
    @include('meta::manager', [
    'title' => $products->name . ' - ' . $shop_name->value,
    'description' => $products->description,
    'image' => isset($images[0]->src) ? url($images[0]->src) : url(@$company->logo),
    ])
    @else
    @if (isset($company) && !empty($company))
    @include('meta::manager', [
    'title' => $products->name . ' - ' . @$company->company_name,
    'description' => 'Shop Ecom Ecommerce',
    'image' => isset($images[0]->src) ? url($images[0]->src) : url(@$company->logo),
    ])
    @else
    @include('meta::manager', [
    'title' => $products->name . ' - ' . 'Shop Ecom',
    'description' => 'Shop Ecom Ecommerce',
    'image' => isset($images[0]->src) ? url($images[0]->src) : url('front/img/ECOM_L.png'),
    ])
    @endif
    @endif
    <link rel="stylesheet" href="{{ url('dist/tailwind.min.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">

    <!--    <link rel="stylesheet" type="text/css" href="{{ asset('photoswipAsset/photoswipe/photoswipe.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('photoswipAsset/photoswipe/default-skin/default-skin.css') }}"/>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css"
        integrity="sha512-yxWNfGm+7EK+hqP2CMJ13hsUNCQfHmOuCuLmOq2+uv/AVQtFAjlAJO8bHzpYGQnBghULqnPuY8NEr7f5exR3Qw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css"
        integrity="sha512-Rck8F2HFBjAQpszOB9Qy+NVLeIy4vUOMB7xrp46edxB3KXs2RxXRguHfrJqNK+vJ+CkfvcGqAKMJTyWYBiBsGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />

    <script src="{{ url('dist/flowbite.js') }}"></script>
    <script src="{{ asset('dist/alpine.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-... " crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

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

    .strike {
        text-decoration: none;
        position: relative;
    }

    .strike::before {
        top: 50%;
        /*tweak this to adjust the vertical position if it's off a bit due to your font family */
        background: #000;
        /*this is the color of the line*/
        opacity: .7;
        content: '';
        width: 110%;
        position: absolute;
        height: .1em;
        border-radius: .1em;
        left: -5%;
        white-space: nowrap;
        display: block;
        transform: rotate(-8deg);
    }

    .strike.straight::before {
        transform: rotate(0deg);
        left: -1%;
        width: 102%;
    }
    </style>
    <style>
    #header_front {
        color: @if (isset($headerMenuColor->header_color)) {
                {
                $headerMenuColor->header_color
            }
        }

        @else #fff @endif ;

        background-color:@if (isset($headerMenuColor->header_background)) {
                {
                $headerMenuColor->header_background
            }
        }

        @else #111433 @endif ;
    }

    .navbardropdown {
        color: @if (isset($headerMenuColor->header_color)) {
                {
                $headerMenuColor->header_color
            }
        }

        @else #fff @endif ;

        background-color:@if (isset($headerMenuColor->header_menu_background)) {
                {
                $headerMenuColor->header_menu_background
            }
        }

        @else #111433 @endif ;
    }

    .li_level {
        background-color:@if (isset($headerMenuColor->header_menu_background)) {
                {
                $headerMenuColor->header_menu_background
            }
        }

        @else #111433 @endif ;
    }

    .li_level *,
    .li_level button {
        color: @if (isset($headerMenuColor->header_color)) {
                {
                $headerMenuColor->header_color
            }
        }

        @else #fff @endif ;
    }

    .li_level:hover {
        color: @if (isset($headerMenuColor->header_color)) {
                {
                $headerMenuColor->header_color
            }
        }

        @else #fff @endif ;

        background-color:@if (isset($headerMenuColor->header_background_hover)) {
                {
                $headerMenuColor->header_background_hover
            }
        }

        @else #111433 @endif ;
    }
    </style>
    <style>
    #cover-item:hover {
        cursor: zoom-in;
    }

    .thumb-image {
        position: relative;
    }

    /*.thumb-image.active::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 19, 23, 0.7) url({{ asset('img/yes.svg') }}) no-repeat center center;
            background-size: 1.25em;
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
        }*/

    .object-cover-multiple {
        display: none;
    }

    .object-cover-multiple.active {
        display: block;
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

    #div_color.hidden {
        display: none !important;
    }

    @media (min-width: 600px) {
        .map-src iframe {
            width: 600px;
        }
    }
    </style>

    @if (isset($code_added_header->key))
    {!! $code_added_header->value !!}
    @endif
</head>

<body class="bg-white text-gray-600 work-sans  text-base tracking-normal"
    style="display:flex;flex-direction:column;max-width:1800px; margin:auto;min-height:100vh;"
    x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">

    <div x-show="loading" class="fixed top-0 left-0 w-full h-full z-50 flex items-center justify-center bg-white">
        <img src="{{ asset('files/logo/loading.gif') }}" class="h-20" alt="Loading...">
    </div>

    <div x-show="!loading" style="display: none;">
        @include('front.default.layouts.header')
    </div>
    <div style="flex-grow:1">
        <section class="bg-white">

            <div class="container mx-auto items-center relative flex-wrap pt-4 pb-12">

                @if (Session::has('error_message'))
                <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                </div>
                @endif
                <section class="text-gray-700 body-font overflow-hidden bg-white">
                    <div class="container px-5 pt-8 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
                        <div class="lg:w-full mx-auto flex flex-wrap">
                            <div class="lg:w-1/2 pswp-gallery my-gallery flex sm:w-full" style="cursor: zoom-in;"
                                id="forcedgallery">
                                <div
                                    class="product__thumbs product__thumbs--beside product__thumbs-placement--left float-left hidden_mobile">
                                    @if (count($images) >= 1 || count($images_variation) >= 1)
                                    <div
                                        class="container thumbnail-img-block thumb_div_img mx-auto space-y-2 lg:space-y-0">
                                        @php $i = 0 @endphp
                                        @foreach ($images as $image)
                                        <div class=" thumb-image btn_photoswipe_img w-full rounded hover:opacity-90 hover:shadow-xl @if ($i == 0) active @endif"
                                            data-src_target="item-image-{{ $i }}" data-thumb_swipe="{{ $i }}">
                                            <img src="{{ $image->src }}" alt="">
                                        </div>
                                        @php $i++ @endphp
                                        @endforeach
                                        @if (isset($images_variation) && !empty($images_variation))
                                        @foreach ($images_variation as $imagev)
                                        <div class=" thumb-image btn_photoswipe_img w-full rounded hover:opacity-90 hover:shadow-xl @if ($i == 0) active @endif"
                                            data-src_target="item-image-{{ $i }}" data-thumb_swipe="{{ $i }}">
                                            <img src="{{ $imagev->src }}" alt="">
                                        </div>
                                        @php $i++ @endphp
                                        @endforeach
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="product__main-photos w-full hidden_mobile">
                                    @if (count($images) <= 0) <div class="cover-item btn_photoswipe active"
                                        id="cover-item" data-swipe="0">
                                        <img alt="" class="object-cover object-center w-full "
                                         @if(!empty($image_cover)> 0) src="{{ $image_cover->src }}"
                                        @else
                                        @if (isset($company->logo) && !empty(@$company->logo))
                                        src="{{ @$company->logo }}"
                                        @else
                                        src="{{ url('front/img/ECOM_L.png') }}" @endif
                                        @endif
                                        >
                                </div>
                                @else
                                @php $i = 0 @endphp
                                @foreach ($images as $image)
                                <div class="cover-item btn_photoswipe @if ($i == 0) active @endif"
                                    id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                    <img alt="" id="item-image-{{ $i }}"
                                        class="object-cover-multiple @if ($i == 0) active @endif object-center w-full"
                                        @if (!empty($image_cover)> 0) src="{{ $image->src }}"
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
                                @if (isset($images_variation) && !empty($images_variation))
                                @foreach ($images_variation as $imagev)
                                <div class="cover-item btn_photoswipe" id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                    <img alt="" id="item-image-{{ $i }}"
                                        class="object-cover-multiple @if ($i == 0) active @endif object-center w-full"
                                        src="{{ $imagev->src }}">
                                </div>
                                @php $i++ @endphp
                                @endforeach
                                @endif
                                @endif
                            </div>
                            <div class="product__main_photos_mobile w-full hidden_desktop">
                                @if (count($images) <= 0) <div class="cover-item relative btn_photoswipe active"
                                    id="cover-item" data-swipe="1">
                                    <img alt="" class="object-cover object-center w-full " @if
                                        (!empty($image_cover)> 0) src="{{ $image_cover->src }}"
                                    @else
                                    @if (isset($company->logo) && !empty(@$company->logo))
                                    src="{{ @$company->logo }}"
                                    @else
                                    src="{{ url('front/img/ECOM_L.png') }}" @endif
                                    @endif
                                    >
                                    <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                        data-swipe="1">
                                        <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span>Zoom</span>
                                    </div>
                            </div>
                            @else
                            @php $i = 0 @endphp
                            @foreach ($images as $image)
                            <div class="cover-item relative btn_photoswipe @if ($i == 0) active @endif"
                                id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                <img alt="" id="item-image-{{ $i }}"
                                    class="object-cover-multiple @if ($i == 0) active @endif object-center w-full" @if
                                    (!empty($image_cover)> 0) src="{{ $image->src }}"
                                @else
                                @if (isset($company->logo) && !empty(@$company->logo))
                                src="{{ @$company->logo }}"
                                @else
                                src="{{ url('front/img/ECOM_L.png') }}" @endif
                                @endif
                                >
                                <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                    data-swipe="{{ $i }}">
                                    <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    <span>Zoom</span>
                                </div>
                            </div>
                            @php $i++ @endphp
                            @endforeach
                            @if (isset($images_variation) && !empty($images_variation))
                            @foreach ($images_variation as $imagev)
                            <div class="cover-item btn_photoswipe relative" id="cover-item{{ $i }}"
                                data-swipe="{{ $i }}">
                                <img alt="" id="item-image-{{ $i }}"
                                    class="object-cover-multiple @if ($i == 0) active @endif object-center w-full"
                                    src="{{ $imagev->src }}">
                                <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                    data-swipe="{{ $i }}">
                                    <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    <span>Zoom</span>
                                </div>
                            </div>
                            @php $i++ @endphp
                            @endforeach
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">
                            @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                            @if (!empty($api_product->description))
                            {{ $api_product->description }}
                            @else
                            @if ($products->description)
                            {!! $products->description !!}
                            @else
                            {{ $products->name }}
                            @endif
                            @endif
                            @else
                            {{ $products->name }}
                            @endif

                        </h1>
                        {{--                        old --}}
                        {{--                        @if (is_null($api_product)) --}}

                        {{--                        @else --}}
                        {{--                            <h1 class="text-gray-900 text-3xl title-font font-medium mb-1"> --}}
                        {{--                                @if (str_contains(request()->getSchemeAndHttpHost(), 'bata')) --}}
                        {{--                                    @if (!empty($products->description)) --}}
                        {{--                                        {!! $products->description !!} --}}
                        {{--                                    @else --}}
                        {{--                                       <!--  @if (isset($api_product->brand) && is_string($api_product->brand)) --}}
                        {{--                                            {{$api_product->brand}} --}}
                        {{--                                        @endif --}}
                        {{--                                        @if (isset($api_product->model) && is_string($api_product->model)) --}}
                        {{--                                            {{$api_product->model}} --}}
                        {{--                                        @endif --}}
                        {{--                                        @if (isset($api_product->gender) && is_string($api_product->gender)) --}}
                        {{--                                            for {{$api_product->gender}} --}}
                        {{--                                        @endif --> --}}
                        {{--                                        {{ $products->name }} --}}
                        {{--                                    @endif --}}
                        {{--                                @else --}}
                        {{--                                    @if (!empty($api_product->description)) --}}
                        {{--                                        {{$api_product->description}} --}}
                        {{--                                    @else --}}
                        {{--                                        @if (!empty($products->description)) --}}
                        {{--                                            {{$api_product->description}} --}}
                        {{--                                        @else --}}
                        {{--                                            {{ $products->name }} --}}
                        {{--                                        @endif --}}
                        {{--                                    @endif --}}
                        {{--                                @endif --}}

                        {{--                            </h1> --}}
                        {{--                        @endif --}}
                        @if (count($productCategory) > 0)
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">
                            @foreach ($productCategory as $key => $c)
                            <a
                                href="{{ route('category-product', $c->category->slug) }}">{{ $c->category->category }}</a>
                            @if ($key !== $productCategory->keys()->last())
                            /
                            @endif
                            @endforeach
                        </h2>
                        @endif
                        @if (isset($first_upc->price))
                        <h1 class="text-gray-900 text-xl title-font font-medium mb-1 flex">
                            <div class="w-fit mr-2 font-semibold">Rs
                                {{ number_format($first_upc->price->current_price, 2, '.', ',') }}</div>
                            @if ($first_upc->price->current_price != $first_upc->price->original_price)
                            <div class="w-fit italic ml-2 strike">Rs
                                {{ number_format($first_upc->price->original_price, 2, '.', ',') }}
                            </div>
                            @endif
                        </h1>
                        @endif

                        <div class="flex">
                            <span class="flex py-2 border-gray-200">
                                <div>
                                    <script>
                                    (function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return;
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));
                                    </script>
                                    <a style="    padding-right: 0.5rem;
                                        font-size: 1.2rem;" href="#"
                                        onclick="FB.ui({ method: 'share', href: '{{ url()->current() }}' }); return false;"><i
                                            style="color:black" class="fa fa-facebook" aria-hidden="true"></i></a>
                                </div>
                                <!--twitter code-->
                                <script>
                                window.twttr = (function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0],
                                        t = window.twttr || {};
                                    if (d.getElementById(id)) return t;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "https://platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js, fjs);

                                    t._e = [];
                                    t.ready = function(f) {
                                        t._e.push(f);
                                    };

                                    return t;
                                }(document, "script", "twitter-wjs"));
                                </script>
                                {{-- End here --}}
                                <a style="padding-right: 0.5rem; font-size: 1.2rem;"
                                    href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"
                                    data-pin-custom="true"><i style="color:black" class="fa fa-pinterest"
                                        aria-hidden="true"></i></a>
                                <a style="    padding-right: 0.5rem;
font-size: 1.2rem;" href="https://twitter.com/share"><i style="color:black" class="fa fa-twitter"
                                        aria-hidden="true"></i></a>
                                <script type="text/javascript">
                                (function(d) {
                                    var f = d.getElementsByTagName('SCRIPT')[0],
                                        p = d.createElement('SCRIPT');
                                    p.type = 'text/javascript';
                                    p.async = true;
                                    p.src = '//assets.pinterest.com/js/pinit.js';
                                    f.parentNode.insertBefore(p, f);
                                })(document);
                                </script>
                                <!-- Load Facebook SDK for JavaScript -->
                                <div id="fb-root"></div>
                                {{-- <script type="text/javascript">
                                (function (d) {
                                    var f = d.getElementsByTagName('SCRIPT')[0],
                                    p = d.createElement('SCRIPT');
                                    p.type = 'text/javascript';
                                    p.async = true;
                                    p.src = '//assets.pinterest.com/js/pinit.js';
                                    f.parentNode.insertBefore(p, f);
                                })(document);
                                </script> --}}
                                <!-- Your share button code -->
                                {{-- <script>window.twttr = (function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0],
                                                t = window.twttr || {};
                                            if (d.getElementById(id)) return t;
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = "https://platform.twitter.com/widgets.js";
                                            fjs.parentNode.insertBefore(js, fjs);

                                            t._e = [];
                                            t.ready = function(f) {
                                                t._e.push(f);
                                            };

                                            return t;
                                        }(document, "script", "twitter-wjs"));
                                        </script>
                                        <div style='margin-top: 2%;margin-left: 4%;'>
                                            <a class="twitter-share-button" href="https://twitter.com/intent/tweet" class="ml-2 text-gray-500">
                                            </a>
                                        </div> --}}
                                {{-- <div style='margin-top: 0.5%;margin-left: 4%;'>
                                            <a data-pin-do="buttonBookmark" href="https://www.pinterest.com/pin/create/button/"></a>
                                        </div> --}}
                                <!-- <a class="ml-2 text-gray-500">
                                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                            <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                            </path>
                                        </svg>
                                    </a> -->
                            </span>
                        </div>
                        <form action="{{ route('add-cart') }}" method="POST">
                            @csrf
                            <script>
                            var variation_price = [];
                            var array_color_inside_size = [];
                            var array_size_inside_color = [];
                            var array_size_api = [];
                            </script>
                            @if ($products->is_variable_product == 'yes')
                            <script>
                            var variation_price = [];
                            var array_color_inside_size = [];
                            var array_size_inside_color = [];
                            </script>
                            <div class="w-full overflow-hidden bg-white">
                                <div class="w-full overflow-hidden">
                                    <div class="leading-relaxed">
                                        @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                        @if (empty($api_product->description))
                                        @else
                                        {!! $products->description !!}
                                        @endif
                                        @else
                                        {{ $products->name }}
                                        @endif
                                    </div>
                                    <br>
                                </div>
                                @if ($size != null && count($size_value) > 0)
                                <div id="div_size" class="grid md:grid-cols-2 md:gap-6">
                                    <input type="hidden" id="attribute_size" name="sizeattribute" value="Size">
                                    <div class="mb-6  z-0 mb-6 w-full group">
                                        <label class="block mb-2 text-sm font-medium text-gray-900" for="size">
                                            Size
                                        </label>

                                        <select id="size" name="size"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option selected>Choose a size</option>
                                            @foreach ($size_value as $val)
                                            <option value="{{ $val->attribute_values }}">
                                                {{ $val->attribute_values }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    @if ($color != null && count($color_value) > 0)
                                    <div id="div_color" class="mb-6  z-0 mb-6 w-full group  hidden">
                                        <label class="block mb-2 text-sm font-medium text-gray-900"
                                            for="company_address">
                                            Colour
                                        </label>
                                        <select id="color" name="color"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option selected>Choose a colour</option>
                                            @foreach ($color_value as $val)
                                            <option value="{{ $val->attribute_values }}">
                                                {{ $val->attribute_values }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                </div>

                                <!-- Variation -->
                                @if (count($product_variation) > 0)
                                @foreach ($product_variation as $variation)

                                @if (count($variation->variation_value) == 0)
                                <script>
                                variation_price.push({
                                    id: '{{ $variation->id }}',
                                    attribute: '',
                                    attribute_value: '',
                                    price: '{{ $variation->price }}',
                                    price_dec: '{{ number_format($variation->price, 2, '.
                                    ', ',
                                    ') }}'
                                });
                                </script>
                                @else
                                @foreach ($variation->variation_value as $key => $var)
                                <script>
                                variation_price.push({
                                    id: '{{ $variation->id }}',
                                    attribute: "{{ $var['attribute'] }}",
                                    attribute_value: "{{ $var['attribute_value'] }}",
                                    price: '{{ $variation->price }}',
                                    price_dec: '{{ number_format($variation->price, 2, '.
                                    ', ',
                                    ') }}'
                                })
                                if ("{{ $var['attribute'] }}" == 'Colour' || "{{ $var['attribute'] }}" == 'Color') {
                                    array_color_inside_size.push({
                                        'id_variation': "{{ $variation->id }}",
                                        'attribute': "{{ $var['attribute'] }}",
                                        'attribute_value': "{{ $var['attribute_value'] }}"
                                    });
                                }
                                if ("{{ $var['attribute'] }}" == 'Size') {
                                    array_size_inside_color.push({
                                        'id_variation': "{{ $variation->id }}",
                                        'attribute': "{{ $var['attribute'] }}",
                                        'attribute_value': "{{ $var['attribute_value'] }}",
                                        'stock_quantity': "{{ $variation->stock }}"
                                    });

                                }
                                </script>
                                @if ($var['attribute'] == 'Size')
                                <span class="valuesize" id-variation="{{ $variation->id }}"
                                    attribute="{{ $var['attribute'] }}" attribute-value="{{ $var['attribute_value'] }}"
                                    attribute-stock="{{ $variation->stock }}"></span>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                                @endif

                                @if (false)

                                <div id="accordionFlushExample">
                                    <div
                                        class="rounded-none border border-t-0 border-l-0 border-r-0 border-neutral-200 bg-white">
                                        <h2 class="mb-0" id="flush-headingOne">
                                            <button
                                                class="group relative flex w-full items-center rounded-none border-0 bg-white py-4 px-0 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)]"
                                                type="button" data-te-collapse-init data-te-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Item info
                                                <span
                                                    class="ml-auto -mr-1 h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-6 w-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="!visible border-0" data-te-collapse-item
                                            data-te-collapse-show aria-labelledby="flush-headingOne"
                                            data-te-parent="#accordionFlushExample">
                                            <div class="py-4 px-5">
                                                @if (isset($info_sku->sku))
                                                <div class="flex mt-2 items-center pb-2  mb-2">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">SKU : </span>
                                                        <div class="">{{ $info_sku->sku }}</div>
                                                    </div>
                                                </div>
                                                @endif


                                                @foreach ($product_variation as $variation)
                                                <input type="hidden" name="variation_t" value="{{ $variation->id }}">
                                                @if (count($variation->variation_value) > 0)
                                                @foreach ($variation->variation_value as $key => $var)
                                                @if ($var['attribute'] != 'Size' && $var['attribute'] != 'Colour' &&
                                                $var['attribute'] != 'Color')
                                                <div class="flex mt-2 items-center pb-2  mb-2">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">{{ $var['attribute'] }}
                                                            : </span>
                                                        <div class="">
                                                            {{ $var['attribute_value'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                @break
                                                @endif
                                                @endforeach
                                                @if (isset($info_sku->group))
                                                <div class="flex mt-2 items-center pb-2  mb-2">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">Group : </span>
                                                        <div class="">{{ $info_sku->group }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if (isset($info_sku->type))
                                                <div class="flex mt-2 items-center pb-2  mb-2">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">Type : </span>
                                                        <div class="">{{ $info_sku->type }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if (isset($info_sku->material))
                                                <div class="flex mt-2 items-center pb-2  mb-2">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">Material : </span>
                                                        <div class="">{{ $info_sku->material }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if (isset($info_sku->colour))
                                                <div class="flex mt-2 items-center pb-4   mb-4">
                                                    <div class="flex items-center">
                                                        <span class="mr-3">Colour : </span>
                                                        <div class="">{{ $info_sku->colour }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <script>
                                var general_array = [];
                                for (i = 0; i < array_color_inside_size.length; i++) {
                                    general_array[array_color_inside_size[i].id_variation] = {
                                        id_variation: array_color_inside_size[i].id_variation,
                                        size: null,
                                        color: array_color_inside_size[i].attribute_value
                                    };
                                }
                                for (i = 0; i < array_size_inside_color.length; i++) {
                                    if (typeof general_array[array_size_inside_color[i].id_variation] === 'undefined') {

                                        general_array[array_size_inside_color[i].id_variation] = {
                                            id_variation: array_size_inside_color[i].id_variation,
                                            size: array_size_inside_color[i].attribute_value,
                                            color: null
                                        };
                                    } else {
                                        general_array[array_size_inside_color[i].id_variation].size =
                                            array_size_inside_color[i].attribute_value
                                    }
                                }

                                function getColor(size) { /// get color by size
                                    var data = general_array.filter(function(element) {
                                        return element.size == size;
                                    });
                                    return [...new Map(data.map(item => [item['color'], item])).values()];
                                }

                                function getSize(color) { /// get size by color
                                    var data = general_array.filter(function(element) {
                                        return element.color == color;
                                    });
                                    return [...new Map(data.map(item => [item['size'], item])).values()];
                                }

                                function getSizeGeneral() { /// get size default
                                    var data = general_array.filter(function(element) {
                                        return true;
                                    });
                                    return [...new Map(data.map(item => [item['size'], item])).values()];
                                }

                                function getVariation() { /// get variation by color and size
                                    var color = $("#color").val();
                                    var size = $("#size").val();
                                    if (color == "" || color == "Choose a colour" || color == null || size == "" ||
                                        size == "Choose a size" ||
                                        size == null) return "No Variation";
                                    var data = general_array.filter(function(element) {
                                        return element.color == color && element.size == size;
                                    });
                                    if (data.length == 0) return "No Variation";
                                    $("#variation").val(data[0].id_variation);
                                    return data[0].id_variation;
                                }

                                $('#size').on('change', function() {
                                    var size = $("#size :selected").text();
                                    var old_color = $("#color").val();
                                    var arr = getColor(size);
                                    $('#color option').remove().end();
                                    $.each(arr, function(key, value) {
                                        $('#color').append($("<option></option>")
                                            .attr("value", value.color).text(value.color));
                                    });
                                    $("#color").val(old_color);
                                    if (!$("#color").val()) $("#color").val($("#color option:first").val());
                                    var id_variation = getVariation();
                                    change_price(id_variation);
                                    let size_changer = $(this).val();
                                    ///hide btn or not
                                    add_to_cart_if_stock_set($("#size").val());
                                    check_size_exist();
                                    if ($('#variation').length > 0) {
                                        $('#variation').val('');
                                        $('.valuesize').each(function() {
                                            let id_variation_size = $(this).attr('id-variation');
                                            let val_size = $(this).attr('attribute-value');
                                            if (size_changer == val_size) $('#variation').val(
                                                id_variation_size);
                                        });
                                    }

                                });
                                $('#color').on('change', function() {
                                    var color = $("#color :selected").text();
                                    var old_size = $("#size").val();
                                    if (size == "Choose a colour") return;
                                    var arr = getSize(color); /// get size by color
                                    $('#size option').remove().end();
                                    $.each(arr, function(key, value) {
                                        $('#size').append($("<option></option>")
                                            .attr("value", value.size).text(value.size));
                                    });
                                    $("#size").val(old_size);
                                    if (!$("#size").val()) $("#size").val($("#size option:first").val());
                                    var id_variation = getVariation();
                                    change_price(id_variation);
                                });
                                $('#variation').on('change', function() {
                                    load_variation();
                                });

                                function load_variation() {
                                    var variation = $("#variation").val();
                                    if (typeof general_array[variation] !== "undefined") {
                                        $("#size").val(general_array[variation].size);
                                        if (!$("#size").val()) {
                                            $('#size').append($("<option></option>")
                                                .attr("value", general_array[variation].size).text(general_array[
                                                    variation].size));
                                            $("#size").val(general_array[variation].size);
                                        }
                                        $("#color").val(general_array[variation].color);
                                        if (!$("#color").val()) {
                                            $('#color').append($("<option></option>")
                                                .attr("value", general_array[variation].color).text(general_array[
                                                    variation].color));
                                            $("#color").val(general_array[variation].color);
                                        }
                                    }
                                }
                                </script>
                                @endif

                                <div class="flex items-center mt-2">
                                    <div class="custom-number-input h-10 w-32">
                                        <div class="flex flex-row h-10 w-full rounded-lg bg-transparent">
                                            <button type="button" data-action="decrement"
                                                class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                <span class="m-auto text-2xl font-thin">−</span>
                                            </button>
                                            <input type="number"
                                                class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                name="quantity" value="1" id="quantity_stock">
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
                                    <div class="flex ml-6">
                                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                                        <input type="hidden" name="product_name" value="{{ $products->name }}">
                                        @if (isset($first_upc->price->current_price))
                                        <input type="hidden" id="product_price" name="product_price"
                                            value="{{ $first_upc->price->current_price }}">
                                        @else
                                        <input type="hidden" id="product_price" name="product_price"
                                            value="{{ $products->price }}">
                                        @endif
                                        <input type="hidden" id="variation" name="variation" value="">
                                        <input type="hidden" name="tax_sale" id="tax_sale" value="{{ $products->vat }}">
                                        <input type="hidden" name="have_stock_api" id="have_stock_api"
                                            value="{{ $have_stock_api }}">
                                        <button type="button" id="btn_submit_nosize_stock"
                                            class="hidden relative ml-auto text-white bg-gray-700 border-0 py-2 px-6 focus:outline-none cursor-not-allowed  hover:bg-gray-700 rounded"
                                            disabled>Size Required</button>
                                        <button type="submit" id="btn_submit_ok_stock"
                                            class="relative ml-auto text-white bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-800 rounded">Add
                                            to cart</button>
                                        <button type="button" id="btn_submit_nok_stock"
                                            class="hidden relative ml-auto text-white bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-800 rounded"
                                            disabled>Not available Online</button>
                                    </div>
                                </div>
                                @if ($info_sku || count($product_variation) > 0)
                                <div id="accordion-flush-0" class="mb-2" data-accordion="collapse"
                                    data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500">
                                    <h2 id="accordion-flush-0-heading-0">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200"
                                            data-accordion-target="#accordion-flush-body-0" aria-expanded="true"
                                            aria-controls="accordion-flush-body-0">
                                            <span>Stores</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-flush-body-0" class="hidden"
                                        aria-labelledby="accordion-flush-heading-1">
                                        <div id="api_store_size" class="my-2"><b> </b>Select a size to
                                            display
                                            store location</div>
                                    </div>
                                </div>
                                <div id="accordion-flush" class="mb-2" data-accordion="collapse"
                                    data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500">

                                    <h2 id="accordion-flush-heading-1">
                                        <button type="button"
                                            class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200"
                                            data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                                            aria-controls="accordion-flush-body-1">
                                            <span>Item info</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-flush-body-1" class="hidden"
                                        aria-labelledby="accordion-flush-heading-1">
                                        <div class="py-5 border-b border-gray-200">
                                            @if (isset($info_sku->sku)).
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">SKU: {{ $info_sku->sku }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            {{-- gender --}}
                                            @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                            @if ($api_product)
                                            @if (!empty($api_product->gender))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Gender:
                                                        {{ $api_product->gender }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            @if (!empty($api_product->model))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Model:
                                                        {{ $api_product->model }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            @if (!empty($api_product->brand))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Brand:
                                                        {{ $api_product->brand }}</span>
                                                </div>
                                            </div>
                                            @endif

                                            @if (!empty($api_product->group5))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Color:
                                                        {{ $api_product->group5 }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            @else
                                            @foreach ($product_variation as $variation)
                                            @if (count($variation->variation_value) > 0)
                                            @foreach ($variation->variation_value as $key => $var)
                                            @if ($var['attribute'] != 'Size' && $var['attribute'] != 'Colour' &&
                                            $var['attribute'] != 'Color')
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    {{--                                                                                        @if (!empty($var['m_attribute_slug']) && !empty($var['sub_attribute_slug'])) --}}
                                                    {{--                                                                                            <a href="{{route('attributes-product', ['main' => ($var["m_attribute_slug"]), 'sub' => ($var["sub_attribute_slug"])])}}">
                                                    --}}
                                                    <span class="mr-3">{{ $var['attribute'] }}:
                                                        {{ $var['attribute_value'] }}</span>
                                                    {{--                                                                                            </a> --}}
                                                    {{--                                                                                        @endif --}}
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @break
                                            @endif
                                            @endforeach
                                            @endif
                                            @else
                                            @foreach ($product_variation as $variation)
                                            @if (count($variation->variation_value) > 0)
                                            @foreach ($variation->variation_value as $key => $var)
                                            @if ($var['attribute'] != 'Size' && $var['attribute'] != 'Colour' &&
                                            $var['attribute'] != 'Color')
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    @if (!empty($var['m_attribute_slug']) &&
                                                    !empty($var['sub_attribute_slug']))
                                                    <a
                                                        href="{{ route('attributes-product', ['main' => $var['m_attribute_slug'], 'sub' => $var['sub_attribute_slug']]) }}">
                                                        <span class="mr-3">{{ $var['attribute'] }}:
                                                            {{ $var['attribute_value'] }}</span>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @break
                                            @endif
                                            @endforeach
                                            @endif

                                            @if (isset($info_sku->group))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Group:
                                                        {{ $info_sku->group }}</span>
                                                </div>
                                            </div>
                                            @endif

                                            @if (isset($info_sku->type))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Type:
                                                        {{ $info_sku->type }}</span>
                                                </div>
                                            </div>
                                            @endif

                                            @if (isset($info_sku->material))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Material:
                                                        {{ $info_sku->material }}</span>
                                                </div>
                                            </div>
                                            @endif

                                            @if (isset($info_sku->colour))
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <span class="mr-3">Colour:
                                                        {{ $info_sku->colour }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </form>
                        @if (request()->getHost() == 'bata.mu' || request()->getHost() == 'laravel.ecom.mu')
                        <div class="w-fit underline hover:no-underline" data-modal-toggle="size-guide">
                            <span class="flex cursor-pointer justify-start pb-4 items-center" data-sizes-trigger="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="19" viewBox="0 0 26 19"
                                    fill="none" class="icon icon-size-guide icon-size-guide">
                                    <path
                                        d="M25.477 11.684h-7.712v-5.33C17.765 2.852 13.79 0 8.883 0S0 2.852 0 6.354v6.297c0 3.226 3.37 5.888 7.712 6.293h.09c.36.03.726.056 1.096.056h16.58a.517.517 0 00.522-.512v-6.292a.517.517 0 00-.523-.512zM8.91 1.029c4.31 0 7.838 2.391 7.838 5.33s-3.506 5.33-7.838 5.33c-4.332 0-7.838-2.391-7.838-5.33s3.532-5.33 7.838-5.33zm7.838 8.315v2.34h-3.031a7.856 7.856 0 003.004-2.34h.027zm8.208 8.632H23.91v-2.591a.517.517 0 00-.523-.512.517.517 0 00-.522.512v2.596h-2.09v-1.408a.517.517 0 00-.522-.512.517.517 0 00-.523.512v1.408h-2.09v-1.408a.517.517 0 00-.522-.512.517.517 0 00-.523.512v1.408h-2.09v-2.596a.517.517 0 00-.523-.512.517.517 0 00-.522.512v2.596h-2.002v-1.408a.517.517 0 00-.522-.512.517.517 0 00-.522.512v1.408h-2.09v-1.408a.517.517 0 00-.523-.512.517.517 0 00-.522.512v1.285c-3.527-.512-6.182-2.652-6.182-5.212V9.344c1.494 2.002 4.436 3.364 7.838 3.364h16.02v5.268z"
                                        fill="#414B56"></path>
                                </svg>
                                <div class="ml-3">Size Guide</div>
                            </span>
                        </div>
                        @endif

                        @if (false)


                        @if ($empty_warehouse != 'yes')

                        @php
                        $display = false;
                        foreach ($stock_api_final as $stock) {
                        $stock = (object) $stock;
                        if ($stock->location === 'Warehouse') {
                        $display = true;
                        }
                        }
                        @endphp

                        @if ($display)
                        <div class="mt-4">
                            <table id="stock_table_warehouse" class="w-full mt-4 text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            UPC
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Store
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Stock
                                        </th>
                                        @if ($have_size == 'yes')
                                        <th scope="col" class="py-3 px-6">
                                            Size
                                        </th>
                                        @endif
                                        <th scope="col" class="py-3 px-6">
                                            Color
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_api_final as $stock)
                                    @php
                                    $stock = (object) $stock;
                                    $i = 0;
                                    @endphp
                                    @if ($stock->location === 'Warehouse')
                                    <tr class="@if (floatval($stock->qty) >= 0) @if ($i % 2 == 0) bg-gray-50 hover:bg-gray-100 @else bg-white hover:bg-gray-50 @endif
@else
bg-red-400 hover:bg-red-600 @endif border-b" @if (floatval($stock->qty) < 0) style="background:#FA8072" @else @if ($i %
                                            2==0) style="background:rgb(249 250 251)" @else style="background:#FFFFFF"
                                            @endif @endif>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $stock->upc }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $stock->location }}
                                            </td>
                                            <td class="py-4 px-6">
                                                @if (floatval($stock->qty) > 0)
                                                {{ $stock->qty }}
                                                @else
                                                0 @endif
                                            </td>
                                            @if ($have_size == 'yes')
                                            <td class="py-4 px-6">
                                                {{ $stock->size }}
                                            </td>
                                            @endif
                                            <td class="py-4 px-6">
                                                {{ $stock->color }}
                                            </td>
                                    </tr>
                                    <script>
                                    array_size_api["{{ $stock->size }}"] = {
                                        {
                                            $stock - > qty
                                        }
                                    };
                                    </script>
                                    @php
                                    $i++;
                                    @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @endif


                        @endif

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
    </section>

    @if (false)

    @if (count($stock_api_final) > 0 && $have_size == 'yes')
    <section class="bg-white py-1 px-8">
        <div class="flex mt-8 items-center pb-5 border-b-2 border-gray-200 mb-5">
            <div class="overflow-x-auto relative">
                <span class="ml-3 mb-2 text-xl">Store Availability</span>

                @php
                $store_list = '<th scope="col" class="py-3 px-6">Size</th>';
                $tbody = '';
                if (count($distinct_location) == 0) {
                $store_list = '';
                }
                $i = 1;
                foreach ($distinct_location as $location) {
                $store_list = $store_list . '<th scope="col" class="py-3 px-6">' . $location . '</th>';
                }
                foreach ($distinct_size as $size) {
                foreach ($distinct_location as $location) {
                if ($i == 1) {
                $tbody =
                $tbody .
                '<tr>
                    <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">' .
                        $size .
                        '</td>';
                    }
                    $qty_value = '--';
                    $css_td = '';
                    if (isset($stock_api_duplicate_color[$location][$size])) {
                    $css_td = ' style="background:#4df3e9;"';
                    }
                    if (isset($stock_api_sort[$location][$size])) {
                    $qty_value = $stock_api_sort[$location][$size];
                    if ($qty_value < 0) { $css_td=' style="background:#FA8072;"' ; $qty_value=0; } } $tbody=$tbody
                        . '<td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap"' . $css_td
                        . '>' . $qty_value . '</td>' ; if ($i==count($distinct_location)) { $tbody=$tbody . '</tr>' ;
                        $i=1; } else { $i++; } } } @endphp <table id="stock_table"
                        class="stripe w-full mt-2 text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            {!! $store_list !!}
                        </thead>
                        <tbody>
                            {!! $tbody !!}
                        </tbody>
                        </table>
            </div>
        </div>
    </section>
    @endif
    @endif
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="error-size-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Error
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="error-size-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <span id="modal_error_message_span">Size required</span>
                </div>
                <div class="p-6 border-t border-gray-200 rounded-b text-right">
                    <button type="button"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2"
                        data-modal-toggle="error-size-modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="size-guide" tabindex="-1"
        class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 z-50 justify-center items-center h-modal sm:h-full w-full md:inset-0 h-modal md:h-full hidden">
        <div class="relative w-full max-w-6xl py-2 h-full md:h-auto md:w-full mt-auto">
            <div class="bg-white rounded-lg shadow relative" style="min-height: 85vh">

                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="size-guide">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="p-4 text-left border-b">
                    <span class="text-xl font-bold">Size Chart</span>
                    <span class="inherit text-sm mt-2" style="display:inherit">If you have wide feet or prefer a
                        roomier fit to accommodate toe splay, we suggest going up a half size. For extra wide feet,
                        go
                        up a whole size.</span>
                </div>
                <div class="rounded border w-full mx-auto mt-4">
                    <!-- Tabs -->
                    <ul id="tabs" class="inline-flex pt-2 px-1 w-full border-b">
                        <li
                            class="bg-white w-1/5 text-center px-4 text-gray-800 font-semibold py-2 rounded-t border-t border-r border-l -mb-px underline hover:no-underline">
                            <a id="default-tab" href="#first">Women</a>
                        </li>
                        <li
                            class="w-1/5 text-center px-4 text-gray-800 font-semibold py-2 rounded-t underline hover:no-underline">
                            <a href="#second">Men</a>
                        </li>
                        <li
                            class="w-1/5 text-center px-4 text-gray-800 font-semibold py-2 rounded-t underline hover:no-underline">
                            <a href="#third">Youth</a>
                        </li>
                        <li
                            class="w-1/5 text-center px-4 text-gray-800 font-semibold py-2 rounded-t underline hover:no-underline">
                            <a href="#fourth">Junior</a>
                        </li>
                        <li
                            class="w-1/5 text-center px-4 text-gray-800 font-semibold py-2 rounded-t underline hover:no-underline">
                            <a href="#fith">Kids & Infants</a>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div id="tab-contents">
                        <div id="first" class="p-4">
                            <div class="text-xl text-center font-bold">
                                Bata, Bata Red Label, Bata Flexible, Bata Comfit, Bata 3D Energy, Bata 3D Oxygen,
                                Northstar, Weinbrenner, Marie Claire & Badminton Master Brand Shoes for Women</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA
                                        </th>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            UK
                                        </th>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            26,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl mt-2 text-center font-bold">
                                Power Brand Sport Shoes for Women</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            26,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Bata, Patapata, Power & Northstar Slippers for Women</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            27,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="second" class="hidden p-4">
                            <div class="text-xl text-center font-bold">
                                Bata, Bata Red Label, Bata Flexible, Bata Comfit, Bata Waterproof, Bata Acu
                                Pressure,
                                Bata Gel Cushioning, Bata Air Motion, Bata 3D Energy, Bata 3D Oxygen, Weinbrenner,
                                Northstar & Badminton Master Brand Shoes for Men</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43
                                        </td>
                                        <td class="px-6 py-4">
                                            44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl mt-2 text-center font-bold">
                                Power Brand Sport Shoes for Men</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43
                                        </td>
                                        <td class="px-6 py-4">
                                            44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            24,5
                                        </td>
                                        <td class="px-6 py-4">
                                            25,5
                                        </td>
                                        <td class="px-6 py-4">
                                            26,5
                                        </td>
                                        <td class="px-6 py-4">
                                            27,5
                                        </td>
                                        <td class="px-6 py-4">
                                            28,5
                                        </td>
                                        <td class="px-6 py-4">
                                            29,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Bata, Patapata, Power & Northstar Slippers for Men</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39-40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43-44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                        <td class="px-6 py-4">
                                            46
                                        </td>
                                        <td class="px-6 py-4">
                                            48
                                        </td>
                                        <td class="px-6 py-4">
                                            48
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            23,5
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="third" class="hidden p-4">
                            <div class="text-xl mt-2 text-center font-bold">
                                Northstar & Power Brand School Shoes for Youth</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43
                                        </td>
                                        <td class="px-6 py-4">
                                            44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                        <td class="px-6 py-4">
                                            46
                                        </td>
                                        <td class="px-6 py-4">
                                            47
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl mt-2 text-center font-bold">
                                Adidas & Puma School Shoes for Youth</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                        <td class="px-6 py-4">
                                            42
                                        </td>
                                        <td class="px-6 py-4">
                                            43-44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                        <td class="px-6 py-4">
                                            46
                                        </td>
                                        <td class="px-6 py-4">
                                            47
                                        </td>
                                        <td class="px-6 py-4">
                                            48,5
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl mt-2 text-center font-bold">
                                Asics School Shoes for Youth</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            41-42
                                        </td>
                                        <td class="px-6 py-4">
                                            43
                                        </td>
                                        <td class="px-6 py-4">
                                            44
                                        </td>
                                        <td class="px-6 py-4">
                                            45
                                        </td>
                                        <td class="px-6 py-4">
                                            46-47
                                        </td>
                                        <td class="px-6 py-4">
                                            48
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            28,5
                                        </td>
                                        <td class="px-6 py-4">
                                            29,5
                                        </td>
                                        <td class="px-6 py-4">
                                            30,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="fourth" class="hidden p-4">
                            <div class="text-xl text-center font-bold">
                                B.First & Northstar School Shoes for Junior</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                        <td class="px-6 py-4">
                                            41
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            24,5
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            25,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Adidas & Puma School Shoes for Junior</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            24,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Asics School Shoes for Junior</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37-38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                        <td class="px-6 py-4">
                                            40
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            22,5
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            25,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Weinbrenner & Marvel Shoes for Junior</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                        <td class="px-6 py-4">
                                            39
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="fith" class="hidden p-4">
                            <div class="text-xl text-center font-bold">
                                B.First & Power School Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            11,5
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            1,5
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                        <td class="px-6 py-4">
                                            32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34
                                        </td>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                        <td class="px-6 py-4">
                                            37
                                        </td>
                                        <td class="px-6 py-4">
                                            38
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            16,5
                                        </td>
                                        <td class="px-6 py-4">
                                            17
                                        </td>
                                        <td class="px-6 py-4">
                                            17,5
                                        </td>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            18,5
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            20,5
                                        </td>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Adidas & Puma School Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                        <td class="px-6 py-4">
                                            32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34-35
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            18,5
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            20,5
                                        </td>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Asics School Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31-32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34
                                        </td>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            17,5
                                        </td>
                                        <td class="px-6 py-4">
                                            18,5
                                        </td>
                                        <td class="px-6 py-4">
                                            19,5
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Bubblegummers Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30-31
                                        </td>
                                        <td class="px-6 py-4">
                                            32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34-35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            14
                                        </td>
                                        <td class="px-6 py-4">
                                            15
                                        </td>
                                        <td class="px-6 py-4">
                                            16
                                        </td>
                                        <td class="px-6 py-4">
                                            17
                                        </td>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            18,5
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            20,5
                                        </td>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Marvel, Disney Frozen & Disney Princess Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            7
                                        </td>
                                        <td class="px-6 py-4">
                                            8
                                        </td>
                                        <td class="px-6 py-4">
                                            9
                                        </td>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            11,5
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            1,5
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            25
                                        </td>
                                        <td class="px-6 py-4">
                                            26
                                        </td>
                                        <td class="px-6 py-4">
                                            27
                                        </td>
                                        <td class="px-6 py-4">
                                            28
                                        </td>
                                        <td class="px-6 py-4">
                                            29
                                        </td>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                        <td class="px-6 py-4">
                                            32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34
                                        </td>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            15
                                        </td>
                                        <td class="px-6 py-4">
                                            16,5
                                        </td>
                                        <td class="px-6 py-4">
                                            17
                                        </td>
                                        <td class="px-6 py-4">
                                            17,5
                                        </td>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            18,5
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            20,5
                                        </td>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            21,5
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Pop by Heelys & Heelys Shoes for Kids</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            US
                                        </th>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            30
                                        </td>
                                        <td class="px-6 py-4">
                                            31
                                        </td>
                                        <td class="px-6 py-4">
                                            32
                                        </td>
                                        <td class="px-6 py-4">
                                            33
                                        </td>
                                        <td class="px-6 py-4">
                                            34
                                        </td>
                                        <td class="px-6 py-4">
                                            35
                                        </td>
                                        <td class="px-6 py-4">
                                            36-37
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            UK
                                        </th>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            17
                                        </td>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            21
                                        </td>
                                        <td class="px-6 py-4">
                                            22
                                        </td>
                                        <td class="px-6 py-4">
                                            23
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xl text-center font-bold">
                                Bubblegummers Shoes for Infants</div>
                            <div class="relative overflow-x-auto mt-2 mb-2">
                                <table class="w-full text-sm text-center text-gray-500">
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            BATA (UK)
                                        </th>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            2
                                        </td>
                                        <td class="px-6 py-4">
                                            3
                                        </td>
                                        <td class="px-6 py-4">
                                            4
                                        </td>
                                        <td class="px-6 py-4">
                                            5
                                        </td>
                                        <td class="px-6 py-4">
                                            6
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            EU
                                        </th>
                                        <td class="px-6 py-4">
                                            17
                                        </td>
                                        <td class="px-6 py-4">
                                            18
                                        </td>
                                        <td class="px-6 py-4">
                                            19
                                        </td>
                                        <td class="px-6 py-4">
                                            20-21
                                        </td>
                                        <td class="px-6 py-4">
                                            22-23
                                        </td>
                                        <td class="px-6 py-4">
                                            24
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium bg-gray-800 text-white whitespace-nowrap">
                                            CM
                                        </th>
                                        <td class="px-6 py-4">
                                            10
                                        </td>
                                        <td class="px-6 py-4">
                                            11
                                        </td>
                                        <td class="px-6 py-4">
                                            12
                                        </td>
                                        <td class="px-6 py-4">
                                            13
                                        </td>
                                        <td class="px-6 py-4">
                                            13,5
                                        </td>
                                        <td class="px-6 py-4">
                                            14
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="inherit text-sm mt-4">
                            DISCLAIMER*<br>
                            The content of this page is provided for general informational and use only.The shoe
                            size
                            converter is intended to provide an approximation of your true size, it is not a
                            substitute
                            for a personal fitting. Bata does not guarantee as to the accuracy or suitability of the
                            information and shall not be liable as sizing may vary by shoe style and
                            manufacturer.Should
                            you have any doubts, we recommend trying on the shoes before purchasing in order to
                            ensure
                            the product meet your specific requirements
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="map-guide" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="min-height: 75vh">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white " id="map-title">
                        Map
                    </h3>
                    <button type="button" id="close-map"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="map-guide">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 hidden map-src" id="bata-port-louis">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14981.375963835086!2d57.5037134!3d-20.161398!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c51ab48377111%3A0x3a9d44c5035222d9!2sBata!5e0!3m2!1sfr!2smg!4v1688494237427!5m2!1sfr!2smg"
                        style="max-width: 100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="p-6 space-y-6 hidden map-src" id="bata-royal">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14981.375963835086!2d57.5037134!3d-20.161398!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c51ab48377111%3A0x3a9d44c5035222d9!2sBata!5e0!3m2!1sfr!2smg!4v1688494237427!5m2!1sfr!2smg"
                        style="max-width: 100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="p-6 space-y-6 hidden map-src" id="bata-la-city">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3742.9988006290487!2d57.4901646!3d-20.2588845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5b16a65c88b9%3A0x7146fefaa90013c6!2sBata!5e0!3m2!1sfr!2smg!4v1688494284008!5m2!1sfr!2smg"
                        style="max-width: 100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="p-6 space-y-6 hidden map-src" id="bata-trianon">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3743.3776497803324!2d57.476749999999996!3d-20.243166700000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjDCsDE0JzM1LjQiUyA1N8KwMjgnMzYuMyJF!5e0!3m2!1sen!2smg!4v1690308700366!5m2!1sen!2smg"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="p-6 space-y-6 hidden map-src" id="bata-rose-hill">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14979.125975105628!2d57.4706849!3d-20.1848214!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c501b1ae39b77%3A0xd90650f3110a38c9!2sFactory%20Bata%20Shoe!5e0!3m2!1sfr!2smg!4v1688494366421!5m2!1sfr!2smg"
                        style="max-width: 100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="p-6 space-y-6 hidden map-src" id="bata-curepipe">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7483.233617956564!2d57.5241731!3d-20.3161222!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5dc7b2e8ce8d%3A0x77a0b8516e44c0b4!2sShoe%20Bazaar!5e0!3m2!1sfr!2smg!4v1688494410412!5m2!1sfr!2smg"
                        style="max-width: 100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>
    </div>

    </div>
    @include('front.default.layouts.footer')
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
        let max = Number(target.max);
        value++;
        if (value > max) {
            value = max;
        }
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
    let tabsContainer = document.querySelector("#tabs");

    let tabTogglers = tabsContainer.querySelectorAll("#tabs a");

    // console.log(tabTogglers);

    tabTogglers.forEach(function(toggler) {
        toggler.addEventListener("click", function(e) {
            e.preventDefault();

            let tabName = this.getAttribute("href");

            let tabContents = document.querySelector("#tab-contents");

            for (let i = 0; i < tabContents.children.length; i++) {

                tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l",
                    "-mb-px", "bg-white");
                tabContents.children[i].classList.remove("hidden");
                if ("#" + tabContents.children[i].id === tabName) {
                    continue;
                }
                tabContents.children[i].classList.add("hidden");

            }
            e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px",
                "bg-white");
        });
    });
    </script>

    <script>
    function change_price(item) {
        /*for (i = 0; i < variation_price.length; i++) {
            if (item == variation_price[i].id) {
                $(".span_price").html(variation_price[i].price_dec);
                $("#product_price").val(variation_price[i].price);
                $("#variation_hidden").val(item);
            }
        }*/
    }

    function check_size_exist() {
        var size = $("#size").val();
        if (size == "" || size == "Choose a size") {
            $("#btn_submit_ok_stock").hide();
            $("#btn_submit_nok_stock").hide();
            $("#btn_submit_nosize_stock").show();
        } else {
            $("#btn_submit_nosize_stock").hide();
            $("#btn_submit_nok_stock").hide();
            $("#btn_submit_ok_stock").show();
        }
    }

    function add_to_cart_if_stock_set(size) {
        if (typeof array_size_api[size] !== 'undefined') {
            if (array_size_api[size] > 0) {
                $("#btn_submit_ok_stock").show();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_out_stock").hide();
            } else {
                $("#btn_submit_ok_stock").hide();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_out_stock").show();
            }
        } else {
            $("#btn_submit_ok_stock").show();
            $("#btn_submit_nok_stock").show();
            $("#btn_submit_out_stock").hide();
        }
    }

    var openPhotoSwipe = function($i) {
        var pswpElement = document.querySelectorAll('.pswp')[0];
        var items = [

            @if(count($images) <= 0) {
                src: '@if (!empty($image_cover) > 0){{ $image_cover->src }} @else @if (isset($company->logo) && !empty(@$company->logo)){{ @$company->logo }} @else {{ url('
                front / img / ECOM_L.png ') }} @endif @endif',
                w: 1024,
                h: 700
            },
            @else
            @foreach($images as $image) {
                src: '@if (!empty($image_cover) > 0) {{ $image->src }} @else @if (isset($company->logo) && !empty(@$company->logo)) {{ @$company->logo }} @else {{ url('
                front / img / ECOM_L.png ') }}@endif @endif',
                w: 1024,
                h: 700
            },
            @endforeach
            @endif
            @if(isset($images_variation) && !empty($images_variation))
            @foreach($images_variation as $imagev) {
                src: '{{ $imagev->src }}',
                w: 1024,
                h: 700
            },
            @endforeach
            @endif

        ];
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };
        var options = {
            history: true,
            focus: true,
            index: $i,
            showAnimationDuration: 0,
            hideAnimationDuration: 0,
            closeOnScroll: false,
            pinchToClose: true,
            closeEl: true,
            captionEl: true,
            fullscreenEl: true,
            zoomEl: true,
            shareEl: true,
            counterEl: true,
            arrowEl: true,
            preloaderEl: true,
            tapToClose: false,
            tapToToggleControls: true,
            clickToCloseNonZoomable: true,
            initialZoomLevel: 'fit',
            secondaryZoomLevel: 1.5,
            maxZoomLevel: 2,
            wheelToZoom: true,
            order: 8,
            closeElClasses: ['pswp__button--close', 'ui', 'top-bar'],
            getDoubleTapZoom: function(isMouseClick, item) {
                if (isMouseClick) {
                    return 1.5;
                } else {
                    return item.initialZoomLevel < 0.7 ? 4 : 1.5;
                }
            },
            maxSpreadZoom: 4

        };
        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.listen('imageLoadComplete', function(index, item) {
            var linkEl = item.el.children[0];
            var img = item.container.children[0];
            if (!linkEl.getAttribute('data-size')) {
                linkEl.setAttribute('data-size', img.naturalWidth + 'x' + img.naturalHeight);
                item.w = img.naturalWidth;
                item.h = img.naturalHeight;
                gallery.invalidateCurrItems();
                gallery.updateSize(true);
            }
        });
        gallery.init();

    };
    var click = 1;

    $(document).ready(function() {

        @if($products - > is_variable_product == 'yes')
        load_select();
        load_variation();

        // Check if #size element exists and has options
        if ($("#size").length && $("#size").find('option').length) {
            $("#size").find('option').get(0).remove();
        }
        if ($("#color").length && $("#color").find('option').length) {
            $("#color").find('option').get(0).remove();
        }
        @endif
        $('#quantity_stock').change(function() {
            let val = $(this).val();
            let max = $(this).attr('max');
            if (max < val) {
                val = max;
            }
            $(this).val(val);
        });

        $('.lightbox_fixed').removeClass('hidden');

        $('#size option:gt(0)').remove();


        change_price($("#variation").val());

        $('.product__main-photos .btn_photoswipe').click(function() {
            var current_image = $(this).data('swipe');
            openPhotoSwipe(current_image);
        });

        $('.js-zoom-icon').click(function() {
            var current_image = $(this).data('swipe');
            openPhotoSwipe(current_image);
        });

        $(".thumb-image").click(function() {
            let target_src = $(this).data("src_target");
            $(".thumb-image").removeClass('active');
            $(".object-cover-multiple").removeClass('active');
            $(this).addClass('active');
            $("#" + target_src).addClass('active'); {
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

        $('.product__main-photos .cover-item').izoomify();
        $(".thumb-image").hover(function() {
            let target_src = $(this).data("src_target");
            $(".thumb-image").removeClass('active');
            $(".object-cover-multiple").removeClass('active');
            $(this).addClass('active');
            $("#" + target_src).addClass('active'); {
                {
                    $('#cover-item img').attr('src', target_src);
                }
            }
        });



        $('#stock_table').dataTable({
            "pageLength": 10,
            order: [1, 'asc']
        });

        /// manage color and size section
        if (($('#color').length === 1 && ($("#color option:first").text() == "Choose a colour" || $(
                "#color option:first").text() == "")) || $('#color').length === 0) {
            $('#div_color').hide();
        } else {
            $('#div_color').show();
        }

        if (($('#size').length === 1 && ($("#size option:first").text() == "Choose a size" || $(
                "#size option:first").text() == "")) || $('#size').length === 0) {
            $('#div_size').hide();
        } else {
            $('#div_size').show();
        }

        $('#stock_table_warehouse').dataTable({
            "pageLength": 10,
            order: [1, 'asc']
        });

        ///hide btn or not
        add_to_cart_if_stock_set($("#size").val());
        check_size_exist();

        if ($(window).width() <= 767) {
            $('.product__main_photos_mobile').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                infinite: true,
                speed: 1000,
                autoplay: true,
                autoplaySpeed: 3000,
                fade: true,
                dots: true,
            });
            $('.pswp__button.pswp__button--close').click(function() {
                $('.pswp--open').removeClass('pswp--open');
            });
        }

    });

    $(window).resize(function() {
        if ($(window).width() <= 767) {
            $('.product__main_photos_mobile').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                infinite: true,
                speed: 1000,
                autoplay: true,
                autoplaySpeed: 3000,
                fade: true,
                dots: true,

            });
            $('.pswp__button.pswp__button--close').click(function() {
                $('.pswp--open').removeClass('pswp--open');
            });
        }
    });

    function make_filter_color(data) {
        var data = data.filter(function(element) {
            return element.color != null;
        });
        return [...new Map(data.map(item => [item['color'], item])).values()];
    }

    function make_filter_size(data) {
        var data = data.filter(function(element) {
            return element.size != null;
        });
        return [...new Map(data.map(item => [item['size'], item])).values()];
    }

    function load_select() {
        var distinct_color = make_filter_color(general_array);
        var distinct_size = make_filter_size(general_array);
        /*$('#color option:gt(0)').remove();
        $('#size option:gt(0)').remove();*/
        $.each(distinct_color, function(key, value) {
            $('#color').append($("<option></option>")
                .attr("value", value.color).text(value.color));
        });
        $.each(distinct_size, function(key, value) {
            $('#size').append($("<option></option>")
                .attr("value", value.size).text(value.size));
        });
        $('#color').append($("<option selected></option>")
            .attr("value", "").text("Choose a color"));
        $('#size').append($("<option selected></option>")
            .attr("value", "").text("Choose a size"));
    }
    </script>

    <script>
    var api_store_size = [];
    var api_store_size = @json($api_size_store);

    var api_store_size_phone = [{
            store: "Bata Port Louis",
            class: "bata-port-louis",
            phone: "5 445 9676",
            location: ""
        },
        {
            store: "Bata Royal",
            class: "bata-royal",
            phone: "5 445 9676",
            location: ""
        },
        {
            store: "Bata La City",
            class: "bata-la-city",
            phone: "5 445 1459",
            location: ""
        },
        {
            store: "Bata Trianon",
            class: "bata-trianon",
            phone: "5 445 1459",
            location: ""
        },
        {
            store: "Bata Rose-Hill",
            class: "bata-rose-hill",
            phone: "5 445 9787​",
            location: ""
        },
        {
            store: "Bata Curepipe",
            class: "bata-curepipe",
            phone: "5 445 9766",
            location: ""
        }
    ];



    $('#size').on('change', function() {
        var size = $("#size").val();
        var html = "";

        arr_api_store_size = api_store_size[size];

        if (typeof arr_api_store_size !== "undefined") {
            var html =
                "<table class='w-full text-center text-sm text-left text-gray-500 dark:text-gray-400'><tr class='text-xs text-gray-700 uppercase bg-gray-50'><td class='px-6 py-3'>Store</td><td class='px-6 py-3'>Phone Number</td></tr>";
            var has_no_warhouse = 1;
            var has_warhouse = 0;
            var is_exist = 0;
            var qte_warhouse = 0;

            for (i = 0; i < arr_api_store_size.length; i++) {
                has_warhouse = 0;
                var phone = "--";
                var location = "";
                var class_ = "";
                if (arr_api_store_size[i]['location'] != 'Warehouse') {

                    for (j = 0; j < api_store_size_phone.length; j++) {
                        if (arr_api_store_size[i]['location'] == api_store_size_phone[j].store ||
                            api_store_size_phone[j].store.indexOf(arr_api_store_size[i]['location']) != -1) {
                            is_exist += 1;
                            phone = api_store_size_phone[j].phone;
                            location = api_store_size_phone[j].location;
                            class_ = api_store_size_phone[j].class;
                            break;
                        }
                    }
                    if (is_exist) {
                        let store_name = arr_api_store_size[i]['location'];
                        let location_icon =
                            "<div class='w-fit underline hover:no-underline' data-modal-toggle='map-guide' onclick='showMap(\"" +
                            store_name + "\",\"" + phone + "\",\"" + class_ +
                            "\");'><svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6 pr-2 cursor-pointer'><path stroke-linecap='round' stroke-linejoin='round' d='M15 10.5a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' d='M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z' /></svg></div>";
                        html = html +
                            "<tr class='bg-white border-b'><td class='px-6 py-4 flex items-center justify-center font-medium text-gray-900 whitespace-nowrap'>" +
                            location_icon + arr_api_store_size[i]['location'] +
                            "</td><td class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap'>" + phone +
                            "</td></tr>";
                    }
                }
                if (arr_api_store_size[i]['location'] == 'Warehouse') {
                    has_warhouse += 1;
                    qte_warhouse = arr_api_store_size[i]['quantity'];
                }
            }
        }
        if (qte_warhouse) {
            $('#quantity_stock').attr('max', qte_warhouse);
        } else {
            $('#quantity_stock').attr('max', 100000);
        }
        var stock_db = 0;
        $('.valuesize').each(function() {
            let attribute_value = $(this).attr('attribute-value');
            if (size == attribute_value) {
                stock_db = parseInt($(this).attr('attribute-stock'));
            }
        });

        if (typeof arr_api_store_size === "undefined" || arr_api_store_size.length === 0) {
            if (is_exist) html = '<div>Selected size is also available in below stores</div><br>' + html +
                "</table>";
            else if (stock_db && size != "") {
                html = "Selected size is only available in online store";
                $("#btn_submit_ok_stock").show();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_nosize_stock").hide();
            } else if (size != "" && has_warhouse) {
                html = "Selected size is only available in online store";
                $("#btn_submit_ok_stock").show();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_nosize_stock").hide();
            } else if (size === "" || (size != "" && has_no_warhouse)) {
                html = "Select a size to display store location";
                $("#btn_submit_ok_stock").hide();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_nosize_stock").show();
            } else {
                $("#btn_submit_ok_stock").hide();
                $("#btn_submit_nok_stock").show();
                $("#btn_submit_nosize_stock").hide();
                html = "Selected size is not available in store";
            }
        } else {
            if (size != "" && is_exist) {
                html = '<div>Selected size is also available in below stores</div><br>' + html + "</table>";
            } else if (size != "" && (has_warhouse)) {
                html = "Selected size is only available in online store";

            } else {
                html = "Selected size is not available in store";
            }

            if (size != "" && (!has_warhouse) && is_exist) {

                $("#btn_submit_ok_stock").hide();
                $("#btn_submit_nok_stock").show();
                $("#btn_submit_nosize_stock").hide();
            } else if (size != "" && (has_warhouse)) {

                $("#btn_submit_ok_stock").show();
                $("#btn_submit_nok_stock").hide();
                $("#btn_submit_nosize_stock").hide();
            } else {

                $("#btn_submit_ok_stock").hide();
                $("#btn_submit_nok_stock").show();
                $("#btn_submit_nosize_stock").hide();
            }

        }
        $("#api_store_size").html(html);

    });
    $('#close-map').click(function() {
        $('#map-guide').toggle();
    });

    function showMap(name, phone, classs) {
        if (phone != '--') phone = " - " + phone;
        let title = name + phone;
        $('#map-title').html(title);
        $('.map-src').addClass('hidden');
        $('#' + classs).removeClass('hidden');
        $('#map-guide').toggle();
    }
    </script>
</body>

</html>
