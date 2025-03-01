<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (!empty($shop_name))
            <?php
            $logo = '';
            $images = $product->images;
            $productCategory = $product->categories;

            if ($images && isset($images[0]->src) && $images[0]->src != '') {
                $logo = $images[0]->src;
            } elseif (@$company->logo && @$company->logo != '') {
                $logo = @$company->logo;
            }
            ?>
        @include('meta::manager', [
            'title' => (string) $product->name . ' - ' . (string) $shop_name->value,
            'description' => (string) $product->description,
            'image' => $logo,
        ])
    @else
        @if (isset($company) && !empty($company))
            @include('meta::manager', [
                'title' => $product->name . ' - ' . @$company->company_name,
                'description' => 'Shop Ecom Ecommerce',
                'image' => isset($images[0]->src) ? (string) url($images[0]->src) : (string) url(@$company->logo),
            ])
        @else
            @include('meta::manager', [
                'title' => @$product->name . ' - ' . 'Shop Ecom',
                'description' => 'Shop Ecom Ecommerce',
                'image' => isset($images[0]->src) ? url($images[0]->src) : url('front/img/ECOM_L.png'),
            ])
        @endif
    @endif
    <link rel="stylesheet" href="{{ url('dist/tailwind.min.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">

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
    <script src="{{ url('dist/alpine.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>

    {{-- for troketia theme --}}
    @php
        $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?? 'default';
    @endphp
    @if ($theme === 'troketia')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/troketia.css') }}" />
    @else
        <style>
            body {
                background: white !important;
            }
            @font-face {
                font-family: 'IntroRegularAlt';
                src: url('{{ asset('font-intro/intro-regular-alt.otf') }}') format('opentype');
                font-weight: normal;
                font-style: normal;
            }

            *,
            body {
                font-family: 'IntroRegularAlt', sans-serif !important;
            }
        </style>
    @endif

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
            padding: auto !important;
        }
        .thumb-image:hover {
            pointer-events: none;
        }
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

        .cover-item img {
            height: 660px;
        }

        .thumb_div_img img {
            height: 76px;
            object-fit: contain;
        }
        .pswp img {
            object-fit: scale-down;
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

            .hidden_mobile {
                display: none;
            }
        }

        .thumb-image:hover,
        .thumb-image.active {
            border: 1px solid #000;
        }

        .red-astrik {
            color: red;
            padding-left: 0px;
        }

        button:disabled {
            background-color: rgba(31,41,55,var(--tw-bg-opacity)); /* Light gray color */
            color: #a1a1a1; /* Gray text color */
            cursor: not-allowed; /* Not-allowed cursor */
            opacity: 0.6; /* Semi-transparent */
        }

        button.disabled {
            background-color: #d3d3d3; /* Light grey */
            cursor: not-allowed;
        }
    </style>

    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif
</head>

<body
    class=" text-gray-600 work-sans  text-base tracking-normal "style="max-width:1800px; margin:auto;display:flex;flex-direction:column;min-height:100vh;">
@include('front.default.layouts.header')

<section class=" "style="flex-grow:1">

    <div class="container mx-auto items-center relative flex-wrap pt-4 pb-12">

        @if (Session::has('error_message'))
            <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
            </div>
        @endif

        <section class="text-gray-700 body-font overflow-hidden ">
            <div class="container px-5 pt-8 mx-auto sm:px-4 md:px-12 lg:px-12 xl:px-12 2xl:px-12">
                <div class="lg:w-full mx-auto flex flex-wrap">
                    <div class="lg:w-2/3 pswp-gallery my-gallery" style="cursor: zoom-in;" id="forcedgallery">
                        <div class="product__main-photos w-full hidden_mobile">
                            @if (count($images) <= 0)
                                <div class="cover-item btn_photoswipe active" id="cover-item" data-swipe="1">
                                    <img alt="{{ $product->name }}" class="object-cover object-center w-full "
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
                                <div class="grid grid-cols-2 gap-2">
                                    @php $i = 1 @endphp
                                    @foreach ($images as $image)
                                        <div class="cover-item btn_photoswipe @if ($i == 1) active @endif" id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                            <img alt="{{ $product->name }}" id="item-image-{{ $i }}" class="object-cover @if ($i == 1) active @endif w-full cursor-pointer" src="{{ $image->src }}">
                                        </div>
                                        @php $i++ @endphp
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="product__main_photos_mobile w-full hidden_desktop">
                            @if (count($images) <= 0)
                                <div class="cover-item relative btn_photoswipe active" id="cover-item"
                                     data-swipe="1">
                                    <img alt="{{ $product->name }}" class="object-cover object-center w-full "
                                         @if (!empty($image_cover) > 0) src="{{ $image_cover->src }}"
                                         @else
                                             @if (isset($company->logo) && !empty(@$company->logo))
                                                 src="{{ @$company->logo }}"
                                         @else
                                             src="{{ url('front/img/ECOM_L.png') }}" @endif
                                        @endif
                                    >
                                    <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                         data-swipe="1">
                                        <svg aria-hidden="true" fill="none" stroke="currentColor"
                                             stroke-width="1.5" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span>Zoom</span>
                                    </div>
                                </div>
                            @else
                                @php $i = 1 @endphp
                                @foreach ($images as $image)
                                    <div class="cover-item relative btn_photoswipe @if ($i == 1) active @endif"
                                         id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                        <img alt="{{ $product->name }}" id="item-image-{{ $i }}"
                                             class="object-cover-multiple @if ($i == 1) active @endif object-center w-full"
                                             @if (!empty($image_cover) > 0) src="{{ $image->src }}"
                                             @else
                                                 @if (isset($company->logo) && !empty(@$company->logo))
                                                     src="{{ @$company->logo }}"
                                             @else
                                                 src="{{ url('front/img/ECOM_L.png') }}" @endif
                                            @endif
                                        >
                                        <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                             data-swipe="{{ $i }}">
                                            <svg aria-hidden="true" fill="none" stroke="currentColor"
                                                 stroke-width="1.5" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                                                      stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <span>Zoom</span>
                                        </div>
                                    </div>
                                    @php $i++ @endphp
                                @endforeach
                                @if (isset($images_variation) && !empty($images_variation))
                                    @foreach ($images_variation as $imagev)
                                        <div class="cover-item btn_photoswipe relative"
                                             id="cover-item{{ $i }}" data-swipe="{{ $i }}">
                                            <img alt="{{ $product->name }}" id="item-image-{{ $i }}"
                                                 class="object-cover-multiple @if ($i == 1) active @endif object-center w-full"
                                                 src="{{ $imagev->src }}">
                                            <div class="cc-container-zoom-icon absolute bottom-2 right-2 js-zoom-icon"
                                                 data-swipe="{{ $i }}">
                                                <svg aria-hidden="true" fill="none" stroke="currentColor"
                                                     stroke-width="1.5" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                                                          stroke-linecap="round" stroke-linejoin="round"></path>
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
                    <div class="lg:w-1/3 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">
                            @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                @if (!empty($product->description))
                                    @php
                                        echo html_entity_decode($product->description);
                                    @endphp
                                    {{-- {{$product->description }} --}}
                                @else
                                    {{ $product->name }}
                                @endif
                            @else
                                {{ $product->name }}
                            @endif

                        </h1>
                        <span id="getProductPrice">Rs {{ number_format($product->price, 2) }}</span>
                        @if (!empty($productCategory) && count($productCategory) > 0)
                            <h2 class="text-sm title-font text-gray-500 tracking-widest">
                                @foreach ($productCategory as $key => $c)
                                    <a
                                        href="{{ route('category-product', $c->category->slug) }}">{{ $c->category->category }}</a>
                                    @if ($key !== $productCategory->keys()->last())
                                        /
                                    @endif
                                @endforeach
                            </h2>
                        @else
                            <h2 class="text-sm title-font text-gray-500 tracking-widest"><a
                                    href="{{ route('category-product', 0) }}">{{ __('Uncategorized') }}</a> </h2>
                        @endif
                        <div class="flex">
                                <span class="flex py-2 border-gray-200">
                                    <!-- Load Facebook SDK for JavaScript -->
                                    <div id="fb-root"></div>
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

                                    <!-- Your share button code -->
                                    <div class="fb-share-button" data-href="{{ url()->current() }}"
                                         data-layout="button"></div>

                                    <!-- <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button_count">
                                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                            </path>
                                        </svg>
                                    </div> -->
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
                                    <div style='margin-top: 2%;margin-left: 4%;'>
                                        <a class="twitter-share-button" href="https://twitter.com/intent/tweet"
                                           class="ml-2 text-gray-500">
                                        </a>
                                    </div>
                                    <div style='margin-top: 0.5%;margin-left: 4%;'>
                                        <a data-pin-do="buttonBookmark"
                                           href="https://www.pinterest.com/pin/create/button/"></a>
                                    </div>
                                    <!-- <a class="ml-2 text-gray-500">
                                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                            <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                            </path>
                                        </svg>
                                    </a> -->
                                </span>

                        </div>
                        <div class="leading-relaxed decription">{!! $product->description !!}</div>

                        <form action="{{ route('add-cart') }}" method="POST">
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
                                <div class="w-full overflow-hidden bg-white">
                                    <div class="w-full overflow-hidden">
                                        <p class="leading-relaxed">
                                            @if (empty($api_product))

                                            @else
                                                {!! $product->description !!}
                                            @endif

                                        </p>
                                        <br>
                                    </div>

                                    @endif
                                    @if (!empty($product_variations) && count($product_variations) > 0)
                                        <div class="mb-6 z-0 mb-6 w-full group">
                                            <div id="dropdown-container"></div>
                                        </div>
                                    @endif
                                    <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-200 mb-5">
                                        @if (!empty($product_variations) && count($product_variations) > 0)

                                            <div class="flex items-center">
                                                <span class="mr-3">Specs:</span>
                                                <div class="">
                                                    {{--                                                @php--}}
                                                    {{--                                                    $i = 0;--}}
                                                    {{--                                                @endphp--}}
                                                    {{--                                                @foreach ($product_variations as $variation)--}}
                                                    {{--                                                    @if (!empty($variation->variation_value))--}}
                                                    {{--                                                        @foreach ($variation->variation_value as $var)--}}
                                                    {{--                                                        @if (isset($var['attribute_type']) && $var['attribute_type'] == 'specs')--}}
                                                    {{--                                                                {{ $var['attribute'] }}:{{ $var['attribute_value'] }}--}}
                                                    {{--                                                                <br />--}}
                                                    {{--                                                            @endif--}}
                                                    {{--                                                        @endforeach--}}
                                                    {{--                                                    @endif--}}
                                                    {{--                                                @endforeach--}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
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
                                                general_array[array_size_inside_color[i].id_variation].size = array_size_inside_color[i].attribute_value
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

                                        function getVariation() { /// get variation by color and size
                                            var color = $("#color").val();
                                            var size = $("#size").val();
                                            if (color == "" || color == "Choose a colour" || color == null || size == "" || size == "Choose a size" ||
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
                                            if (size == "Choose a size") return;
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
                                                        .attr("value", general_array[variation].size).text(general_array[variation].size));
                                                    $("#size").val(general_array[variation].size);
                                                }
                                                $("#color").val(general_array[variation].color);
                                                if (!$("#color").val()) {
                                                    $('#color').append($("<option></option>")
                                                        .attr("value", general_array[variation].color).text(general_array[variation].color));
                                                    $("#color").val(general_array[variation].color);
                                                }
                                            }
                                        }
                                    </script>

                                    <div class="flex items-center mt-2">
                                        <div class="custom-number-input h-10 w-32">
                                            <div class="flex flex-row h-10 w-full rounded-lg bg-transparent">
                                                <button type="button" data-action="decrement"
                                                        class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin">−</span>
                                                </button>
                                                <input type="number"
                                                       class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                       name="quantity" value="1">
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
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                                            <input type="hidden" id="product_price" name="product_price"
                                                   value="{{ $product->price }}">
                                            <input type="hidden" id="product_variation_id" name="product_variation_id" value="">
                                            <input type="hidden" name="tax_sale" id="tax_sale"
                                                   value="{{ $product->vat }}">
                                            <input type="hidden" name="have_stock_api" id="have_stock_api"
                                                   value="{{ $have_stock_api }}">

                                            <button type="submit"
                                                    class="@if ($theme === 'troketia') main-button @endIf t-cta sticky-mobile gold relative ml-auto text-white bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-800 rounded"
                                                    id="addToShoppingBag" disabled="true">
                                                <span>Add To Shopping Bag </span>
                                            </button>
                                        </div>

                                    </div>
                                    <div style="margin-top: 10px;">Need help ? <a href=""style="color:#B05C50">Contact us</a></div>
                                    <div id="product-container" data-is-rental="{{ $product->is_rental_product == 'yes' ? 'true' : 'false' }}">
                                        @if ($product->is_rental_product == 'yes')
                                            <div class="flex items-center mt-2">
                                                <div class="flex mt-8">
                                                    <button id="showButton" type="button"
                                                            class="relative ml-auto text-white bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-800 rounded">Request
                                                        Rental</button>
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                </div>
                        </form>


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
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                <label for="rentalfirstname"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name
                                    <span class="red-astrik">*</span></label>
                                <input type="text" name="rentalfirstname" id="rentalfirstname"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="First Name" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="rentallastname"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name
                                    <span class="red-astrik">*</span></label>
                                <input type="text" name="rentallastname" id="rentallastname"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Last Name" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="rentalphone"
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
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Email" required="" autocomplete="email">
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

@if ($theme === 'troketia')
    @include('front.troketia.layouts.partial.footer')
@else
    @include('front.default.layouts.footer')
@endif

<!-- Flowbite JS -->
<!-- Custom Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productContainer = document.getElementById('product-container');
        const isRental = productContainer.getAttribute('data-is-rental') === 'true';
        const priceDisplay = document.getElementById('getProductPrice');
        const addToShoppingBagButton = document.getElementById('addToShoppingBag');

        // Disable the button by default
        addToShoppingBagButton.disabled = true;

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

        const productVariations = @json($product_variations_array);
        const attributeData = @json($attributeMap);

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
            select.classList.add('bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5');

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
                updatePrice();
                checkAllDropdownsSelected();
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
                        nextSelect.innerHTML = `<option selected disabled>Choose a ${nextAttribute}</option>`;
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

        function updatePrice() {
            const is_variable_product = @json($product->is_variable_product);

            if (is_variable_product === 'no') {
                let prodPrice = @json($product->price);
                priceDisplay.textContent = "Rs " + prodPrice.toFixed(2);
                document.getElementById('product_price').value = prodPrice.toFixed(2);
                return false;
            }

            const selectedAttributes = Object.entries(selectedValues);
            if (selectedAttributes.length === 0) {
                priceDisplay.textContent = "Select your preferred choice for price";
                document.getElementById('product_price').value = "Select your preferred choice for price";
                return;
            }

            let matchedVariation = null;

            const selectedAttributesFormatted = selectedAttributes.reduce((acc, [attr, val]) => {
                acc[attr.toLowerCase()] = val;
                return acc;
            }, {});

            for (const variation of productVariations) {
                const variationAttributes = variation.attributes.reduce((acc, { attribute, attribute_value }) => {
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

            if (matchedVariation) {
                let prodPrice = matchedVariation.price.toFixed(2);
                priceDisplay.textContent = "Rs " + prodPrice;
                document.getElementById('product_price').value = prodPrice;

                let images = matchedVariation.images;
                images.forEach(image => {
                    const newSrc = image.src;
                    updateImageToThumbnailAndSlider(newSrc, newSrc)
                });

                document.getElementById('product_variation_id').value = matchedVariation.id;
            } else {
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
                    if (attributeData[attribute][selectedValue].related && Object.keys(attributeData[attribute][selectedValue].related).length === 0) {
                        buttonShouldBeEnabled = true;
                        break;
                    }
                }
            }

            if (!buttonShouldBeEnabled) {
                buttonShouldBeEnabled = keys.every(attribute => {
                    const selectElement = document.getElementById(attribute);
                    return selectElement && selectElement.value && selectElement.value !== `Choose a ${attribute}`;
                });
            }

            addToShoppingBagButton.disabled = !buttonShouldBeEnabled;
        }

        function updateImageToThumbnailAndSlider(newThumbImageSrc, newCoverImageSrc){
            // Clone first element in .thumbnail-img-block and insert it before the first element
            const thumbnailContainer = document.querySelector('.container.thumbnail-img-block.thumb_div_img');
            if (thumbnailContainer) {
                const firstThumbImage = thumbnailContainer.querySelector('.thumb-image');
                if (firstThumbImage) {
                    const clonedThumbImage = firstThumbImage.cloneNode(true);
                    const img = clonedThumbImage.querySelector('img');
                    if (img) {
                        img.src = newThumbImageSrc; // Update image src
                    }
                    thumbnailContainer.insertBefore(clonedThumbImage, firstThumbImage);
                } else {
                    console.error('No .thumb-image element found to clone in .thumbnail-img-block');
                }
            } else {
                console.error('.thumbnail-img-block container not found');
            }

            // Clone first element in .product__main-photos and insert it before the first element
            const mainPhotosContainer = document.querySelector('.product__main-photos');
            if (mainPhotosContainer) {
                const firstCoverItem = mainPhotosContainer.querySelector('.cover-item');
                if (firstCoverItem) {
                    const clonedCoverItem = firstCoverItem.cloneNode(true);
                    const img = clonedCoverItem.querySelector('img');
                    if (img) {
                        img.src = newCoverImageSrc; // Update image src
                    }
                    mainPhotosContainer.insertBefore(clonedCoverItem, firstCoverItem);
                } else {
                    console.error('No .cover-item element found to clone in .product__main-photos');
                }
            } else {
                console.error('.product__main-photos container not found');
            }
        }

        checkAllDropdownsSelected();
        updatePrice();
    });
</script>


<!-- Flowbite JS -->
<script src="https://unpkg.com/flowbite@latest/dist/flowbite.js"></script>
<!-- Custom Script -->

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
    function change_price(item) {
        //console.log();
        for (i = 0; i < variation_price.length; i++) {
            if (item == variation_price[i].id) {
                $(".span_price").html(variation_price[i].price_dec);
                $("#product_price").val(variation_price[i].price);
                $("#variation_hidden").val(item);
            }
        }
    }

    var openPhotoSwipe = function($i) {
        var pswpElement = document.querySelectorAll('.pswp')[0];
        var items = [

                @if (count($images) <= 0)
            {
                src: '@if (!empty($image_cover) > 0){{ $image_cover->src }} @else @if (isset($company->logo) && !empty(@$company->logo)){{ @$company->logo }} @else {{ url('front/img/ECOM_L.png') }} @endif @endif',
                w: 1024,
                h: 700
            },
                @else
                @foreach ($images as $image)
            {
                src: '@if (!empty($image_cover) > 0) {{ $image->src }} @else @if (isset($company->logo) && !empty(@$company->logo)) {{ @$company->logo }} @else {{ url('front/img/ECOM_L.png') }}@endif @endif',
                w: 1024,
                h: 700
            },
                @endforeach
                @endif
                @if (isset($images_variation) && !empty($images_variation))
                @foreach ($images_variation as $imagev)
            {
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
        $('.lightbox_fixed').removeClass('hidden');

        change_price($("#variation").val());

        $('.product__main-photos .btn_photoswipe').click(function() {
            var current_image = $(this).data('swipe');
            openPhotoSwipe(current_image - 1); // Adjusting index as needed by the library
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

        @if ($product->is_variable_product == 'yes')
        load_select();
        load_variation();
        var sizeOption = $("#size").find('option').get(0);
        if (sizeOption) {
            sizeOption.remove();
        }

        var colorOption = $("#color").find('option').get(0);
        if (colorOption) {
            colorOption.remove();
        }
        @endif

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
        console.log()
        if (($('#size').length === 1 && ($("#size option:first").text() == "Choose a size" || $(
            "#size option:first").text() == "")) || $('#size').length === 0) {
            $('#div_size').hide();
        } else {
            $('#div_size').show();
        }

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
        var sizeOption = $("#size").find('option').get(0);
        if (sizeOption) {
            sizeOption.remove();
        }

        var colorOption = $("#color").find('option').get(0);
        if (colorOption) {
            colorOption.remove();
        }
        $.each(distinct_color, function(key, value) {
            $('#color').append($("<option></option>")
                .attr("value", value.color).text(value.color));
        });
        $.each(distinct_size, function(key, value) {
            $('#size').append($("<option></option>")
                .attr("value", value.size).text(value.size));
        });

    }
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
</body>
</html>
