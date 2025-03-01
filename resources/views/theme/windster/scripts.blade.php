<script async="" defer="" src="{{url('dist/buttons.js')}}"></script>
    <script src="{{url('dist/app.bundle.js')}}"></script>
    <script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194" integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw==" data-cf-beacon="{&quot;rayId&quot;:&quot;75d118507e5bb3f2&quot;,&quot;version&quot;:&quot;2022.10.3&quot;,&quot;r&quot;:1,&quot;token&quot;:&quot;3a2c60bab7654724a0f7e5946db4ea5a&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>

    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
    <script type="text/javascript" id="" src="{{url('dist/paddle.js')}}"></script>
    <script src="{{url('dist/flowbite.js')}}"></script>
    <script src="{{url('dist/datepicker.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.js"
        integrity="sha512-7jpTN4lfrURp41NL7vGXbMP+RPaf/1S5QlNMHLlkdBteN+X5znoT2P8ryCluqePOK79rpDWVPdq1+la4ijhIbQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js"
        integrity="sha512-2R4VJGamBudpzC1NTaSkusXP7QkiUYvEKhpJAxeVCqLDsgW4OqtzorZGpulE3eEA7p++U0ZYmqBwO3m+R2hRjA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js"
        integrity="sha512-SxO0cwfxj/QhgX1SgpmUr0U2l5304ezGVhc0AO2YwOQ/C8O67ynyTorMKGjVv1fJnPQgjdxRz6x70MY9r0sKtQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{url('dist/flatpickr.min.js')}}"></script>

    <script type="text/javascript" id="">
        if ("demo.themesberg.com" === window.location.hostname) {
            Paddle.Setup({
                vendor: 113942
            });
            var setDomain = "themesberg.com",
                getCookies = function() {
                    for (var b = document.cookie.split(";"), c = {}, a = 0; a < b.length; a++) {
                        var d = b[a].split("\x3d");
                        c[(d[0] + "").trim()] = decodeURIComponent(d[1])
                    }
                    return c
                },
                setCookie = function(b, c, a, d) {
                    var e = new Date;
                    e.setTime(e.getTime() + 864E5 * a);
                    a = "expires\x3d" + e.toUTCString();
                    document.cookie = b + "\x3d" + c + ";" + a + ";domain\x3d" + d + ";path\x3d/"
                },
                deleteCookie = function(b) {
                    document.cookie = b + "\x3d;expires\x3dThu, 01 Jan 1970 00:00:01 GMT;"
                },
                setPaddleCookies = function(b) {
                    var c = getCookies();
                    Object.keys(c).forEach(function(a) {
                        a.startsWith("paddlejs_") && (deleteCookie(a), setCookie(a, c[a], 30, b))
                    })
                };
            setPaddleCookies(setDomain)
        };
    </script>

<script type="text/javascript">
    var closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };
    var openPhotoSwipe = function ($i) {
        var pswpElement = document.querySelectorAll('.pswp')[0];
        var items = [
            <?php if(isset($product)) foreach ($product->images as $images) { ?>
            {
                src: '<?php echo $images->src; ?>',
                w: 1024,
                h: 683
            },
            <?php } ?>
        ];
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };
        var options = {
            history: false,
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
            closeElClasses: ['pswp__button--close', 'ui', 'top-bar'],
            getDoubleTapZoom: function (isMouseClick, item) {
                if (isMouseClick) {
                    return 1.5;
                } else {
                    return item.initialZoomLevel < 0.7 ? 4 : 1.5;
                }
            },
            maxSpreadZoom: 4

        };
        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };
    // document.getElementById('btn').onclick = openPhotoSwipe;
    $('.btn_photoswipe').click(function () {
        var current_image = $(this).data('swipe');
        openPhotoSwipe(current_image);
    });

    $('.btn_photoswipe_img').click(function () {
        var current_image = $(this).data('swipe');
        $('.btn_photoswipe_img').removeClass('current_active');
        $('.carousel-item').removeClass('active');
        $('#photoswipe' + current_image).addClass('active');
        $(this).addClass('current_active');
    });

    $('.btn_photoswipe_img').hover(function () {
        var current_image = $(this).data('swipe');
        $('.btn_photoswipe_img').removeClass('current_active');
        $('.carousel-item').removeClass('active');
        $('#photoswipe' + current_image).addClass('active');
        $(this).addClass('current_active');
    });

    $('.carousel-control-next > i, .carousel-control-prev i').click(function () {
        setTimeout(function () {
            $('.btn_photoswipe_img').removeClass('current_active');
            let swipe = $('.carousel-item.active').find('.btn_photoswipe').data('swipe');
            $('.btn_photoswipe_img').each(function () {
                let swipe_thumb = $(this).data('swipe');
                if (swipe_thumb == swipe) {
                    $(this).addClass('current_active')
                }
            });
        }, 625);
    });

</script>

<script>
  flatpickr('#delivery_date', {
    "minDate": new Date(),
    "dateFormat": "d/m/Y"
});
</script>

<script src="{{url('/js/overlayscrollbars/jquery.overlayScrollbars.js')}}"></script>

<script type="text/javascript">

    $('#over_flowing').overlayScrollbars({
        className            : "os-theme-dark",
        resize               : "none",
        sizeAutoCapable      : true,
        clipAlways           : true,
        normalizeRTL         : true,
        paddingAbsolute      : false,
        autoUpdate           : null,
        autoUpdateInterval   : 33,
        updateOnLoad         : ["img"],
        nativeScrollbarsOverlaid : {
            showNativeScrollbars   : false,
            initialize             : true
        },
        overflowBehavior : {
            x : "scroll",
            y : "scroll"
        },
        scrollbars : {
            visibility       : "auto",
            autoHide         : "never",
            autoHideDelay    : 800,
            dragScrolling    : true,
            clickScrolling   : false,
            touchSupport     : true,
            snapHandle       : false
        },
        textarea : {
            dynWidth       : false,
            dynHeight      : false,
            inheritedAttrs : ["style", "class"]
        },
        callbacks : {
            onInitialized               : null,
            onInitializationWithdrawn   : null,
            onDestroyed                 : null,
            onScrollStart               : null,
            onScroll                    : null,
            onScrollStop                : null,
            onOverflowChanged           : null,
            onOverflowAmountChanged     : null,
            onDirectionChanged          : null,
            onContentSizeChanged        : null,
            onHostSizeChanged           : null,
            onUpdated                   : null
        }
    });

</script>
