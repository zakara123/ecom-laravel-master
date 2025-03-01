<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<div class="swiper mySwiper" style="height: 300px;">
    <div class="swiper-wrapper">
        @if (count($images) <= 0)
            <div class="swiper-slide" id="cover-item" data-swipe="1" style="width: 544px; margin-right: 10px; display: flex; justify-content: center; align-items: center; min-height: 100%;">
                <img alt="{{ $product->name }}" class="object-cover object-center h-full"
                     @if (!empty($image_cover)) src="{{ $image_cover->src }}"
                     @else
                         @if (isset($company->logo) && !empty(@$company->logo))
                             src="{{ @$company->logo }}"
                     @else
                         src="{{ url('front/img/ECOM_L.png') }}"
                    @endif
                    @endif
                >
            </div>
        @else
            @php $i = 1; @endphp
            @if (!empty($variationImages))
                @foreach ($variationImages as $imagev)
                    <div class="swiper-slide" style="width: 544px; margin-right: 10px; display: flex; justify-content: center; align-items: center; min-height: 100%;">
                        <img alt="{{ $product->name }}" id="item-image-{{ $i }}"
                             class="object-cover @if ($i == 1) active @endif object-center h-full"
                             src="{{ $imagev->src }}">
                    </div>
                    @php $i++; @endphp
                @endforeach
            @endif

            @foreach ($images as $image)
                <div class="swiper-slide" style="width: 544px; margin-right: 10px; display: flex; justify-content: center; align-items: center; min-height: 100%;">
                    <img alt="{{ $product->name }}" id="item-image-{{ $i }}" class="object-cover @if ($i == 1) active @endif h-full cursor-pointer" src="{{ $image->src }}">
                </div>
                @php $i++; @endphp
            @endforeach
        @endif
    </div>

    <!-- Pagination dots -->
    <div class="swiper-pagination"></div>

    <!-- Navigation buttons -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    // const swiper = new Swiper('.mySwiper', {
    //     slidesPerView: 1,
    //     spaceBetween: 10,
    //     loop: true,
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    // });

    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 3000, // Auto slide every 3 seconds
            disableOnInteraction: false, // Keep autoplay going even after interaction
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
