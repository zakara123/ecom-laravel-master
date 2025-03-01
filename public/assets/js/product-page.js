$(document).ready(function() {
    $('#addToShoppingBag').on('click', function(e) {
        e.preventDefault();

        var form = $('#addToCartForm')[0]; // Get the raw DOM element of the form
        var formData = new FormData(form); // Create a FormData object from the form
        var url = $(form).attr('action'); // Get the form action URL

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type header
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle success (e.g., show a success message, update the cart, etc.)
                console.log('Item added to cart successfully');
                createToast(response.message, 'success');
                setTimeout(function() {
                    location.reload();
                }, 3000); // 3000 milliseconds = 3 seconds

            },
            error: function(xhr) {
                // Handle error (e.g., show an error message)
                console.log('Failed to add item to cart');
                createToast(xhr.message, 'success');
            }
        });
    });

    // Get all images with the class 'variation-image'
    // Feature: on click of image select all dropdowns automatically and display related images
    $('.variation-image').on('click', function() {
        const variationId = $(this).data('variation-id');

        // Find the variation object based on variationId
        const selectedVariation = productVariations.find(variation => variation.id == variationId);

        if (selectedVariation) {
            // Loop through attributes in the selected variation
            $.each(selectedVariation.attributes, function(index, attribute) {
                // Find the corresponding dropdown for the attribute
                const dropdown = $(`[name="${attribute.attribute}"]`);

                if (dropdown.length) {
                    // Update the dropdown value to the corresponding attribute_value_id
                    dropdown.val(attribute.attribute_value);
                }
                displayVariationImages(variationId);
                addToShoppingBagButton.disabled = false;
            });
        }
    });
});


function initializePhotoSwipe(pswpElement, images, startIndex = 0) {
    var items = images.map(function(image) {
        return {
            src: image.src,
            w: image.w || 1024,
            h: image.h || 700,
            className: image.className || 'main-cover-image'
        };
    });

    var options = {
        history: true,
        focus: true,
        index: startIndex,
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
            return isMouseClick ? 1.5 : (item.initialZoomLevel < 0.7 ? 4 : 1.5);
        },
        maxSpreadZoom: 4
    };

    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.listen('imageLoadComplete', function(index, item) {
        if (item.el) {
            var img = item.container.children[0];
            if (!item.el.children[0].getAttribute('data-size')) {
                item.el.children[0].setAttribute('data-size', img.naturalWidth + 'x' + img.naturalHeight);
                item.w = img.naturalWidth;
                item.h = img.naturalHeight;
                gallery.invalidateCurrItems();
                gallery.updateSize(true);
            }
            item.container.classList.add(item.className);
        }
    });
    gallery.init();
}
