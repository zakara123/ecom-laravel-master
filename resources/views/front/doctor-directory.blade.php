<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>

    <link rel="stylesheet" href="{{ url('dist/flowbite.min.css') }}" />

    <link rel="stylesheet" href="{{ url('dist/tailwind.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}" />
    <script src="{{ url('dist/flowbite.js') }}"></script>
    <link rel="icon" type="image/x-icon" href="{{ $shop_favicon }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

        .decription ul, .decriptionol {
        list-style: initial;
        margin-left: 20px; /* Add left margin to match default browser styling */
        padding-left: 20px; /* Add left padding for the list items */
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

<body
    class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal"
    style="display:flex;flex-direction:column;max-width:1800px; margin:auto;min-height:100vh;"
>
@include('front.default.layouts.header')
<div class="d" style="flex-grow:1">
    <div class="container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14">

        @if (Session::has('error_message'))
            <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Error : </span> {{ Session::get('error_message') }}
            </div>
        @endif

        <div class="grid md:grid-cols-1  md:gap-1">

            <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-2 gap-4 mt-5">


                <div class="mr-2 w-full">
                    <div id="step-heading" class="text-left text-xl mb-1"> Doctor Directory</div>

                   
                        <table id="default-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctors as $item)
                                <tr>
                                    <td>{{$item->first_name}}</td>
                                    <td>{{$item->last_name}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>
                                    <a href="{{ route('doctor.public.page', ['id' => $item->id]) }}" target="_blank"
                                        class="p-2 mt-4 li_level li_level_1 border border-gray-100 md:flex-row 
                                                md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 dark:border-gray-700
                                                 current_click text-white">
                                        View
                                    </a>
                                    </td>                                    
                                </tr>
                                @endforeach
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>

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
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxz3wUvm-olpBO3L98DXs6Ve_KCE9Alc&libraries=places&callback=initMap"></script>
<script>
    const doctors = @json($doctors); // Converts the $doctors collection to a JavaScript object
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    window.onload = function() {
        initMap(); // Initialize the map
    };

    let map;
    let markers = [];

    function initMap() {
        const defaultLocation = { lat: 20.5937, lng: 78.9629 }; // Default location (India)

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 5
        });

        // Loop through doctors and place markers
        doctors.forEach(doctor => {
            if (doctor.latitude && doctor.longitude) {
                const position = { lat: parseFloat(doctor.latitude), lng: parseFloat(doctor.longitude) };

                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: doctor.user?.name || doctor.name
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div>
                            <h5>${doctor.user?.name || doctor.name}</h5>
                            <p><strong>Specialty:</strong> ${doctor.specialty || 'Not available'}</p>
                        </div>
                    `
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
            }
        });

        fitMapToBounds();
    }

    function fitMapToBounds() {
        const bounds = new google.maps.LatLngBounds();

        markers.forEach(marker => {
            bounds.extend(marker.getPosition());
        });

        if (!bounds.isEmpty()) {
            map.fitBounds(bounds);
        }
    }

        $(document).ready(function () {
        $('#default-table').DataTable({
            info: false,
            lengthChange: false,
            dom: '<"top"f>rt<"bottom"ip>',
            "paging": true, // Enable pagination
            "pageLength": 10 // Default page length
        });
    });
</script>


@include('front.default.layouts.footer')

</body>

</html>
