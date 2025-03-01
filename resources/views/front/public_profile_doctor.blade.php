<html>

<head>
    @php
        $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>

    <link rel="stylesheet" href="{{ url('dist/flowbite.min.css') }}" />

    <link rel="stylesheet" href="{{ url('dist/tailwind.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <script src="{{ url('dist/flowbite.js') }}"></script>
    <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">
    @if ($theme === 'care-connect')
        {{-- new start --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css"
            integrity="sha512-yxWNfGm+7EK+hqP2CMJ13hsUNCQfHmOuCuLmOq2+uv/AVQtFAjlAJO8bHzpYGQnBghULqnPuY8NEr7f5exR3Qw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css"
            integrity="sha512-Rck8F2HFBjAQpszOB9Qy+NVLeIy4vUOMB7xrp46edxB3KXs2RxXRguHfrJqNK+vJ+CkfvcGqAKMJTyWYBiBsGA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet"
            type="text/css" />

        <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" rel="stylesheet">
        {{-- new end --}}
    @endif
    <style>
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


            .decription menu,
            .decription ol {
                list-style: number !important;
                margin: auto !important;
                padding: auto !important;
                padding-left: 40px !important;
            }

            .decription ul {
                list-style: inherit !important;
                margin: auto !important;
                padding: auto !important;
            }

            .decription p {
                display: block;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                unicode-bidi: isolate;
            }

            .decription h3 {
                display: block;
                font-size: 1.17em;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;
                unicode-bidi: isolate;
            }

            .decription h4 {
                display: block;
                margin-block-start: 1.33em;
                margin-block-end: 1.33em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;
                unicode-bidi: isolate;
            }
        }
    </style>
    <style>
        #summary {
            background-color: #f6f6f6;
        }

        .text-xl-p {
            font-size: 1.1rem;
            line-height: 1.75rem;
        }

        .text-white {
            color: white !important;
        }

        .decription ul,
        .decriptionol {
            list-style: initial;
            margin-left: 20px;
            /* Add left margin to match default browser styling */
            padding-left: 20px;
            /* Add left padding for the list items */
        }

        .decription menu,
        .decription ol {
            list-style: number !important;
            margin: auto !important;
            padding: auto !important;
            padding-left: 40px !important;
        }

        .decription ul {
            list-style: inherit !important;
            margin: auto !important;
            padding: auto !important;
        }

        .decription p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            unicode-bidi: isolate;
        }

        .decription h3 {
            display: block;
            font-size: 1.17em;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }

        .decription h4 {
            display: block;
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }

        .custom-directions-button {
            background-color: #4285F4;
            color: white;
            border: none;
            padding: 12px 16px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 14px;
            position: absolute !important;
            left: 10px !important;
            width: max-content;
        }

        .custom-directions-button:hover {
            background-color: #357AE8;
        }
    </style>
    @if (isset($code_added_header->key))
        {!! $code_added_header->value !!}
    @endif
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal"
    style="display:flex;flex-direction:column;max-width:1800px; margin:auto;min-height:100vh;">

    @if ($theme === 'care-connect')
        @include('front.care-connect.layouts.partial.header')
    @else
        @include('front.default.layouts.header')
    @endif
    <div class="d" style="flex-grow:1">
        <div @if ($theme === 'care-connect') style="background: #f6f4f3" @endif
            class="@if ($theme === 'care-connect') sm:ml-8 mb-8 rounded-l-3xl @endif mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14">

            @if (Session::has('error_message'))
                <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
                </div>
            @endif

            <div class="grid md:grid-cols-1  md:gap-1">

                <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-2 gap-4 mt-5">


                    <div class="mr-2 w-full">
                        <div id="step-heading" class="text-left text-xl mb-1">{{ $doctor->first_name }}
                            {{ $doctor->last_name }} Doctor Profile</div>

                        @if ($doctor->type != 'Generalist')
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Specialist: <strong>
                                    @php
                                        $specialtiesWithSpaces = str_replace(',', ', ', $doctor->specialities);
                                    @endphp
                                    {{ $specialtiesWithSpaces }}
                                </strong>
                            </label>
                        @endif
                        @if ($doctor->type == 'Generalist')
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Generalist
                            </label>
                        @endif
                        <label class="block text-sm font-medium text-gray-700" for="name">
                            {{ $doctor->address_1 }}@if ($doctor->address_2 || $doctor->village_town)
                                ,
                            @endif
                            @if ($doctor->address_2)
                                {{ $doctor->address_2 }}@if ($doctor->village_town)
                                    ,
                                @endif
                            @endif
                            @if ($doctor->village_town)
                                {{ $doctor->village_town }}
                            @endif
                        </label>
                        <label class="block text-sm font-medium text-gray-700 mt-5 decription" for="name">
                            {!! $doctor->description !!}
                        </label>
                    </div>


                    <div class="mr-2 w-full">
                        <label class="block text-sm font-medium text-gray-700" for="name">
                            <div id="map" style="height: 500px; width: 100%;"></div>
                        </label>

                    </div>
                </div>

            </div>
            <!-- Stepper -->

        </div>

    </div>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxz3wUvm-olpBO3L98DXs6Ve_KCE9Alc&libraries=places&callback=initMap">
    </script>
    <script>
        window.onload = function() {
            initMap(); // Initialize the map when everything is fully loaded
        };

        let map;
        let marker;
        let directionsService;
        let directionsRenderer;

        function initMap() {
            const initialLocation = {
                lat: parseFloat({{ $doctor->latitude ?? -34.397 }}),
                lng: parseFloat({{ $doctor->longitude ?? 150.644 }})
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: initialLocation,
                zoom: 8,
                mapTypeControl: true, // Ensure map/satellite buttons appear
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_LEFT
                }
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Place marker
            placeFixedMarker(initialLocation);

            // Add a custom control (Directions button)
            const directionsButtonDiv = document.createElement("div");
            const directionsButton = document.createElement("button");
            directionsButton.textContent = "Get Directions";
            directionsButton.classList.add("custom-directions-button");
            directionsButtonDiv.appendChild(directionsButton);

            // Place the custom button below the Map/Satellite buttons
            map.controls[google.maps.ControlPosition.LEFT].push(directionsButtonDiv);

            // Event listener for the Directions button
            // Event listener for the Directions button
            directionsButton.addEventListener("click", function() {
                const destination = {
                    lat: parseFloat({{ $doctor->latitude ?? -34.397 }}),
                    lng: parseFloat({{ $doctor->longitude ?? 150.644 }})
                };

                // Construct the Google Maps directions URL
                const googleMapsUrl =
                    `https://www.google.com/maps/dir/?api=1&destination=${destination.lat},${destination.lng}`;

                // Open Google Maps in a new window/tab
                window.open(googleMapsUrl, '_blank');
            });
        }

        function placeFixedMarker(location) {
            // Place a marker at the initial location
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: false // Ensure that the marker is not draggable
            });
        }

        // Event listener for getting directions
        document.getElementById('getDirections').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    // Call the function to calculate and display the route
                    calculateAndDisplayRoute(currentLocation, {
                        lat: parseFloat({{ $doctor->latitude ?? -34.397 }}),
                        lng: parseFloat({{ $doctor->longitude ?? 150.644 }})
                    });
                }, function() {
                    alert('Geolocation failed');
                });
            } else {
                alert('Browser does not support geolocation');
            }
        });

        function calculateAndDisplayRoute(start, end) {
            directionsService.route({
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING
            }, function(response, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(response);
                } else {
                    alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>
    @if ($theme === 'care-connect')
        @include('front.care-connect.layouts.partial.footer')
    @else
        @include('front.default.layouts.footer')
    @endif

</body>

</html>
