<nav class="bg-white border-b border-gray-200 fixed z-40 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile"  aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                    <svg id="toggleSidebarMobileHamburger" data-collapse-toggle="sidebar" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="toggleSidebarMobileClose" data-collapse-toggle="sidebar" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <a href="/" class="text-xl font-bold flex items-center lg:ml-2.5">
                    <img src="@isset($company->logo) {{ @$company->logo }} @else {{ url('files/logo/ecom-logo.png') }} @endisset" class="h-14 mr-2"style="object-fit:cover" alt="@isset($company->company_name) {{ @$company->company_name }} @else {{ __('ECOM') }} @endisset">

                </a>
                
            </div>
            @if(Auth::check() &&  Auth::User()->role=='admin') 
            <div class="hidden md:flex items-center">
                <a href="{{ route('new-quote') }}" class="sm:inline-flex ml-2 text-gray-900 font-medium text-sm px-5 py-2.5 text-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 mr-2 text-gray-900 flex-shrink-0 transition duration-75" viewBox="0 0 16 16"> <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/> <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/> 
                </svg>
                    <label class="hidden cursor-pointer md:flex" for="here1">New Quote</label>
                </a>
                <a href="{{ route('new-sale') }}" class="sm:inline-flex ml-2 text-gray-900 font-medium text-sm px-5 py-2.5 text-center items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-900 flex-shrink-0 transition duration-75" width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                        <path d="M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10" stroke="currentColor" stroke-width="1.5"></path> <path d="M14.8333 21V15C14.8333 13.8954 13.9379 13 12.8333 13H10.8333C9.72874 13 8.83331 13.8954 8.83331 15V21" stroke="currentColor" stroke-miterlimit="16"></path> <path d="M21.8183 9.36418L20.1243 3.43517C20.0507 3.17759 19.8153 3 19.5474 3H15.5L15.9753 8.70377C15.9909 8.89043 16.0923 9.05904 16.2532 9.15495C16.6425 9.38698 17.4052 9.81699 18 10C19.0158 10.3125 20.5008 10.1998 21.3465 10.0958C21.6982 10.0526 21.9157 9.7049 21.8183 9.36418Z" stroke="currentColor" stroke-width="1.5"></path> <path d="M14 10C14.5675 9.82538 15.2879 9.42589 15.6909 9.18807C15.8828 9.07486 15.9884 8.86103 15.9699 8.63904L15.5 3H8.5L8.03008 8.63904C8.01158 8.86103 8.11723 9.07486 8.30906 9.18807C8.71207 9.42589 9.4325 9.82538 10 10C11.493 10.4594 12.507 10.4594 14 10Z" stroke="currentColor" stroke-width="1.5"></path> <path d="M3.87567 3.43517L2.18166 9.36418C2.08431 9.7049 2.3018 10.0526 2.6535 10.0958C3.49916 10.1998 4.98424 10.3125 6 10C6.59477 9.81699 7.35751 9.38698 7.74678 9.15495C7.90767 9.05904 8.00913 8.89043 8.02469 8.70377L8.5 3H4.45258C4.18469 3 3.94926 3.17759 3.87567 3.43517Z" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                    <label class="hidden cursor-pointer md:flex" for="here1">New Sale</label>
                </a>
                <a href="{{ route('customer.create')}}" class="sm:inline-flex ml-2 text-gray-900 font-medium text-sm px-5 py-2.5 text-center items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-900 flex-shrink-0 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="hidden cursor-pointer md:flex" for="here1">New Customer</label>
                </a>
                <a href="{{ route('item.create')}}" class="sm:inline-flex ml-2 text-gray-900 font-medium text-sm px-5 py-2.5 text-center items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-900 flex-shrink-0 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="hidden cursor-pointer md:flex" for="here1">New Item</label>
                </a>
            </div>
            @endif
            @if(Auth::check() &&  Auth::User()->role=='doctor') 
            <div class="hidden md:flex items-center">
                    <label class="hidden cursor-pointer md:flex" for="here1">{{ucfirst(Auth::User()->role)}} - {{ucfirst(Auth::User()->name)}}</label>
            </div>
            @endif
            @if(Auth::check() &&  Auth::User()->role=='patient') 
            <div class="hidden md:flex items-center">
                    <label class="hidden cursor-pointer md:flex" for="here1">{{ucfirst(Auth::User()->role)}} - {{Auth::User()->customer_upi}} {{ucfirst(Auth::User()->name)}}</label>
            </div>
            @endif
        </div>
    </div>
</nav>
