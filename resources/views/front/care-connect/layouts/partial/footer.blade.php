<footer style="background-color: rgb(57, 133, 123)" class="text-white py-10">
    <div class="container mx-auto px-4 sm:px-8">
        <!-- Full Width Layout -->
        <div class="flex flex-wrap md:flex-nowrap mx-2">
            <!-- Company Info -->
            <div class="w-full md:w-1/3 flex-grow py-4 pl-4 pr-6">
                <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl mb-6 md:mb-0"
                    href="/">
                    @if (isset($company->logo) && !empty(@$company->logo))
                        <img src="{{ @$company->logo }}" alt="..." style="width:auto; height:55px;">
                    @else
                        <img src="{{ url('front/img/ECOM_L.png') }}" alt="..." style="width:130px; height:auto;">
                    @endif
                </a>
                <p class="text-md leading-relaxed">Floréal Business Park, Floréal, Mauritius</p>
                <a href="#" class="text-teal-300 hover:underline text-md leading-relaxed block mt-2">View
                    Directions</a>
                <p class="mt-4 text-md leading-relaxed">+230 5509 1189</p>
                <p class="text-md leading-relaxed">hello@careconnect.living</p>
            </div>

            <!-- Pages -->
            <div class="w-full md:w-1/3 px-2 lg:px-4 p-4 pr-8">
                <p class="text-lg text-xl font-semibold mb-4">Legal</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('privacy-policy') }}" class="hover:underline text-md leading-relaxed">Privacy
                            Policy</a></li>
                    <li><a href="{{ route('terms-and-conditions') }}"
                            class="hover:underline text-md leading-relaxed">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('return-policy') }}" class="hover:underline text-md leading-relaxed">Return
                            Policy</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="w-full lg:w-1/4 px-2 lg:px-4 p-4">
                <p class="text-lg text-xl font-semibold mb-4">Subscribe to Our Newsletter</p>
                <form class="flex flex-col space-y-4">
                    <input type="email" placeholder="Your email...*"
                        class="px-4 py-2 rounded border border-green-400 bg-transparent text-white placeholder-white focus:outline-none focus:border-white focus:ring-2 focus:ring-white text-md leading-relaxed">
                    <button id="showButton" type="button"
                        class="relative w-full text-white border-2 border-black-100 py-2 px-6 focus:outline-none rounded transition-colors duration-300 hover:text-white hover:bg-green-400 hover:border-green-400">
                        Subscribe
                    </button>
                </form>
                {{-- <div class="flex space-x-4 mt-4">
                    <a href="#" class="bg-teal-400 hover:bg-teal-500 rounded-full p-2">
                        <span class="sr-only">Facebook</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="..." />
                        </svg>
                    </a>
                    <a href="#" class="bg-teal-400 hover:bg-teal-500 rounded-full p-2">
                        <span class="sr-only">Twitter</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="..." />
                        </svg>
                    </a>
                    <a href="#" class="bg-teal-400 hover:bg-teal-500 rounded-full p-2">
                        <span class="sr-only">Instagram</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="..." />
                        </svg>
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- Footer Bottom -->
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm color-ki text-center block dark:text-gray-400">© {{ date('Y') }} <a href="/"
                    class="hover:underline">
                    @if (isset($shop_name->value) && !empty($shop_name->value))
                        {{ $shop_name->value }}
                    @else
                        @if (isset($company->company_name) && !empty(@$company->company_name))
                            {{ @$company->company_name }}
                        @else
                            {{ __('ECOM') }}
                        @endif
                    @endif
                </a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0 mx-auto md:mx-0" style="width:fit-content">
                <a href="https://www.facebook.com/#" class="color-ki hover:text-gray-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Facebook</span>
                </a>
                <a href="https://www.instagram.com/#" class="color-ki hover:text-gray-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Instagram</span>
                </a>
                <a href="#" class="color-ki hover:text-gray-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                    <span class="sr-only">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</footer>
