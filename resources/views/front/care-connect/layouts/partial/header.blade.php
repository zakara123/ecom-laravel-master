<style>
    .phone-time-address {
        padding: 0 5px;
        font-size: 20px;
        font-weight: 500;
        font-family: 'Inter';
        color: #002333;
    }

    .phone-time-address-details {
        padding: 0 5px;
        font-size: 15px;
        text-align: left;
        font-weight: normal;
        color: #687276;
    }

    @media (min-width: 640px) {
            .sm\:mx-8 {
                margin-left: 0rem !important ;
                margin-right: 0rem !important ;
            }
        }


</style>
@php
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

    $result = \App\Models\Setting::where('key', 'sticky_banner_header')->first();
    if ($result) {
        // Access the key and value properties
        $key = $result->key;
        $value = $result->value;
        echo $value;
    }
@endphp
<!-- Top Bar -->
<div class="top-bar text-center md:text-left text-sm flex justify-between items-stretch "
    style="background-color: #f6f4f3;">
    <span class="text-md lg:pl-20 hidden py-3  justify-center items-center md:flex mx-4"
        style="color: var(--text-color);">
        Care Connect: Medical Appointments, Equipment, and Rentals.
    </span>
    <a href="{{ url('/appointment-request') }}"
        class="text-white text-md whitespace-nowrap flex justify-center items-center py-3 px-40 font-bold ml-auto w-full md:w-auto text-center"
        style="background-color: rgb(57, 133, 123);">
        Book an Appointment
    </a>
</div>

<!-- Header Section -->
<header class="pt-0 md:pt-7 pb-7 sm:mx-8 mx-2" style="background: white">
    <div class="container mx-auto flex justify-between items-center px-2 md:px-4 py-2">
        <!-- Part 1: Logo -->
        <div class="lg:w-1/4 flex items-center justify-center lg:justify-start md:ml-8">
            @if (isset($company->logo) && !empty(@$company->logo))
                <img src="{{ asset(@$company->logo) }}" alt="logo" class="w-40 lg:w-60 h-[80px] lg:h-[60px] object-contain">
            @else
                <img src="{{ asset('front/img/ECOM_L.png') }}" alt="logo" class="w-60">
            @endif
        </div>

        <!-- Mobile Menu Button (Visible on small screens) -->
        <div class="block lg:hidden">
            <div class="flex items-center gap-3">
                <div x-data="{ open: false }" class="mx-2">
                    <a href="{{ route('cart') }}" role="button" class="relative flex"
                        @click="{{ 'open = false' }}">
                        <i class='bx bxs-shopping-bag' style="font-size: 25px"></i>
                        <span
                            class="absolute right-0 top-0 bg-gray-400 rounded-full w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center"
                            style="margin-top: -3px;margin-right: -10px;">{{ count($carts) }}
                        </span>
                    </a>
                </div>
                <button id="mobile-menu-button" class="btn-secondary p-2 rounded-lg focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Part 2: Phone, Hours, Address (Hidden on small screens) -->
        <div class="hidden lg:flex lg:space-x-4 px-5">
            @if (count($headerMenus))
                @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                    <nav class="container mx-auto hidden lg:flex justify-center py-5">
                        <ul class="flex space-x-10 text-xl font-medium">
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
                                                                <svg aria-hidden="true" class="w-5 h-5"
                                                                    fill="currentColor" viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
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
                                                                                </button>
                                                                                <div id="doubleDropdown{{ $item_child_of_child->id }}"
                                                                                    class=" navbardropdown hidden z-40 w-44  rounded divide-y divide-gray-100 shadow dark:bg-gray-700"
                                                                                    data-popper-reference-hidden=""
                                                                                    data-popper-escaped=""
                                                                                    data-popper-placement="right-start"
                                                                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(10px, 0px);">
                                                                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                                                        aria-labelledby="doubleDropdownButton{{ $item_child_of_child->id }}">
                                                                                        @foreach ($item_child_of_child->child_of_childrends as $item_child_of_children)
                                                                                            <li><a href="{{ $item_child_of_children->link }}"
                                                                                                    class="menu-item">{{ $item_child_of_children->title }}</a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            </li>
                                                                        @else
                                                                            <li><a href="{{ $item_child_of_child->link }}"
                                                                                    class="menu-item">{{ $item_child_of_child->title }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li><a href="{{ $item_children->link }}"
                                                                class="menu-item">{{ $item_children->title }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @else
                                    <li><a href="{{ $item->link }}" class="menu-item">{{ $item->title }}</a></li>
                                @endif
                            @endforeach
                            {{-- <li><a href="#" class="menu-item"><i class="fas fa-search"></i></a></li> --}}
                            {{-- start --}}
                            @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                                <div x-data="{ open: false }" class="mx-2">
                                    <a href="{{ route('cart') }}" role="button" class="relative flex"
                                        @click="{{ 'open = false' }}">
                                        <i class='bx bxs-shopping-bag'></i>
                                        <span
                                            class="absolute right-0 top-0 bg-gray-400 rounded-full w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center"
                                            style="margin-top: -3px;margin-right: -10px;">{{ count($carts) }}
                                        </span>
                                    </a>
                                </div>
                            @endif

                            {{-- ends --}}
                        </ul>
                    </nav>
                @endif
            @endif
        </div>
    </div>


    <!-- Navigation Bar -->


    <!-- Mobile Navigation Panel -->
    <div id="mobile-menu-panel"
        class="fixed top-0 right-0 w-3/4 h-full mobile-menu shadow-lg z-50 transform translate-x-full transition-transform">
        <div class="p-8 flex">
            <!-- Logo -->
            <div class="w-1/3 lg:w-1/4 flex items-center justify-center lg:justify-start">
                @if (isset($company->logo) && !empty(@$company->logo))
                    <img src="{{ asset(@$company->logo) }}" alt="logo" class="w-40">
                @else
                    <img src="{{ asset('front/img/ECOM_L.png') }}" alt="logo" class="w-40">
                @endif
            </div>

            <!-- Close Button -->
            <button id="close-menu-button" class="ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="space-y-4 p-8">
            @if (count($headerMenus))
                @if (!isset($enable_online_shop->value) || (isset($enable_online_shop->value) && $enable_online_shop->value == 'yes'))
                    @foreach ($headerMenus as $item)
                        <li><a href="{{ $item->link }}"
                                class="menu-item block text-white text-xl">{{ $item->title }}</a></li>
                    @endforeach
                @endif
            @endif

            <li class="flex items-center">
                <!-- Search Input with Icon and Button -->
                <div class="relative flex items-center border border-white rounded-md w-full">
                    <input type="text" placeholder="Search..."
                        class="bg-transparent border-none rounded-l-md py-2 pl-10 pr-4 text-white w-full">
                    <button class="rounded-md bg-primary-color text-white py-2 px-4" style="height: 40px">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </li>
            <li>
                <!-- Book Appointment Button -->
                <button class="btn-secondary text-white rounded-md py-2 px-4 w-full">
                    Book Appointment
                </button>
            </li>
        </ul>
    </div>
</header>
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu-panel').classList.toggle('translate-x-full');
    });

    document.getElementById('close-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu-panel').classList.add('translate-x-full');
    });
</script>
