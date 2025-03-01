@php
    $role = Auth::User()->role;
@endphp

@if (Auth::check())
    <aside id="sidebar"
        class="fixed hidden z-30 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
        aria-label="Sidebar">
        <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex-1 px-3 bg-white divide-y space-y-1">
                    <ul class="space-y-2 pb-2">
                        <li>
                            <form action="#" method="GET" class="lg:hidden">
                                <label for="mobile-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" name="email" id="mobile-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:ring-cyan-600 block w-full pl-10 p-2.5"
                                        placeholder="Search">
                                </div>
                            </form>
                        </li>
                        @can('dashboard')
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                        @endcan
                        {{--                    @can('appointment-bookings') --}}
                        {{--                        <li> --}}
                        {{--                            <a href="{{ route('appointment-lists') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group"> --}}
                        {{--                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> --}}
                        {{--                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path> --}}
                        {{--                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path> --}}
                        {{--                                </svg> --}}
                        {{--                                <span class="ml-3">Appointments</span> --}}
                        {{--                            </a> --}}
                        {{--                        </li> --}}
                        {{--                    @endcan --}}
                        {{--                    @can('sales') --}}
                        {{--                        <li> --}}
                        {{--                            <a href="{{ route('sales.index') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group"> --}}
                        {{--                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> --}}
                        {{--                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path> --}}
                        {{--                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path> --}}
                        {{--                                </svg> --}}
                        {{--                                <span class="ml-3">Orders</span> --}}
                        {{--                            </a> --}}
                        {{--                        </li> --}}
                        {{--                    @endcan --}}
                        @can('statistics')
                            <li>
                                <a href="{{ url('statistics') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                    </svg>

                                    <span class="ml-3">Statistics</span>
                                </a>
                            </li>
                        @endcan
                        @can('pages')
                            <li>
                                <a href="{{ route('page.index') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="24px"
                                        viewBox="0 0 18 23" version="1.1">
                                        <g id="surface1">
                                            <path fill-rule="evenodd"
                                                d="M 11.460938 0.140625 C 11.390625 0.078125 11.285156 0.0351562 11.183594 0.0351562 C 11.160156 0.0351562 11.136719 0.0351562 11.113281 0.0429688 L 0.929688 0.0429688 C 0.679688 0.0429688 0.445312 0.140625 0.273438 0.304688 C 0.105469 0.46875 0 0.691406 0 0.941406 L 0 19.097656 C 0 19.347656 0.105469 19.566406 0.273438 19.730469 C 0.445312 19.898438 0.671875 19.996094 0.929688 19.996094 L 6.691406 19.996094 L 6.691406 19.191406 L 0.921875 19.191406 C 0.902344 19.191406 0.871094 19.1875 0.855469 19.164062 C 0.839844 19.148438 0.824219 19.121094 0.824219 19.097656 L 0.824219 0.941406 C 0.824219 0.914062 0.832031 0.890625 0.855469 0.878906 C 0.871094 0.863281 0.890625 0.847656 0.921875 0.847656 L 10.757812 0.847656 L 10.757812 4.371094 C 10.757812 4.707031 10.902344 5.015625 11.128906 5.234375 C 11.359375 5.453125 11.675781 5.59375 12.023438 5.59375 L 15.601562 5.59375 L 15.601562 9.460938 L 16.453125 9.460938 L 16.453125 5.28125 C 16.460938 5.246094 16.46875 5.21875 16.46875 5.183594 C 16.46875 5.0625 16.410156 4.953125 16.328125 4.875 L 11.511719 0.171875 C 11.496094 0.15625 11.492188 0.152344 11.476562 0.140625 Z M 9.199219 11.019531 L 17.285156 11.019531 C 17.480469 11.019531 17.660156 11.09375 17.792969 11.222656 L 17.808594 11.238281 C 17.929688 11.363281 18 11.53125 18 11.710938 L 18 22.273438 C 18 22.460938 17.921875 22.632812 17.792969 22.761719 L 17.789062 22.761719 C 17.660156 22.886719 17.480469 22.964844 17.285156 22.964844 L 9.199219 22.964844 C 9.003906 22.964844 8.824219 22.890625 8.691406 22.761719 L 8.675781 22.746094 C 8.554688 22.621094 8.480469 22.453125 8.480469 22.273438 L 8.480469 11.710938 C 8.480469 11.523438 8.5625 11.351562 8.691406 11.222656 L 8.695312 11.222656 C 8.824219 11.097656 9.003906 11.019531 9.199219 11.019531 Z M 15.621094 13.039062 L 15.851562 13.039062 L 15.851562 14.242188 L 15.621094 14.242188 Z M 10.175781 16.066406 L 11.304688 16.066406 C 11.402344 16.066406 11.480469 16.140625 11.480469 16.234375 L 11.480469 17.15625 C 11.480469 17.25 11.402344 17.328125 11.304688 17.328125 L 10.175781 17.328125 C 10.078125 17.328125 10 17.25 10 17.15625 L 10 16.234375 C 9.996094 16.140625 10.078125 16.066406 10.175781 16.066406 Z M 10.175781 20.445312 L 11.304688 20.445312 C 11.402344 20.445312 11.480469 20.523438 11.480469 20.613281 L 11.480469 21.535156 C 11.480469 21.628906 11.402344 21.703125 11.304688 21.703125 L 10.175781 21.703125 C 10.078125 21.703125 10 21.628906 10 21.535156 L 10 20.613281 C 9.996094 20.523438 10.078125 20.445312 10.175781 20.445312 Z M 10.175781 18.253906 L 11.304688 18.253906 C 11.402344 18.253906 11.480469 18.332031 11.480469 18.425781 L 11.480469 19.347656 C 11.480469 19.441406 11.402344 19.519531 11.304688 19.519531 L 10.175781 19.519531 C 10.078125 19.519531 10 19.441406 10 19.347656 L 10 18.425781 C 9.996094 18.332031 10.078125 18.253906 10.175781 18.253906 Z M 15.183594 16.066406 L 16.3125 16.066406 C 16.410156 16.066406 16.484375 16.140625 16.484375 16.234375 L 16.484375 17.15625 C 16.484375 17.25 16.40625 17.328125 16.3125 17.328125 L 15.183594 17.328125 C 15.085938 17.328125 15.007812 17.25 15.007812 17.15625 L 15.007812 16.234375 C 15.003906 16.140625 15.082031 16.066406 15.183594 16.066406 Z M 15.183594 20.445312 L 16.3125 20.445312 C 16.410156 20.445312 16.484375 20.523438 16.484375 20.613281 L 16.484375 21.535156 C 16.484375 21.628906 16.40625 21.703125 16.3125 21.703125 L 15.183594 21.703125 C 15.085938 21.703125 15.007812 21.628906 15.007812 21.535156 L 15.007812 20.613281 C 15.003906 20.523438 15.082031 20.445312 15.183594 20.445312 Z M 15.183594 18.253906 L 16.3125 18.253906 C 16.410156 18.253906 16.484375 18.332031 16.484375 18.425781 L 16.484375 19.347656 C 16.484375 19.441406 16.40625 19.519531 16.3125 19.519531 L 15.183594 19.519531 C 15.085938 19.519531 15.007812 19.441406 15.007812 19.347656 L 15.007812 18.425781 C 15.003906 18.332031 15.082031 18.253906 15.183594 18.253906 Z M 12.675781 16.066406 L 13.808594 16.066406 C 13.902344 16.066406 13.984375 16.140625 13.984375 16.234375 L 13.984375 17.15625 C 13.984375 17.25 13.902344 17.328125 13.808594 17.328125 L 12.675781 17.328125 C 12.582031 17.328125 12.5 17.25 12.5 17.15625 L 12.5 16.234375 C 12.5 16.140625 12.582031 16.066406 12.675781 16.066406 Z M 12.675781 20.445312 L 13.808594 20.445312 C 13.902344 20.445312 13.984375 20.523438 13.984375 20.613281 L 13.984375 21.535156 C 13.984375 21.628906 13.902344 21.703125 13.808594 21.703125 L 12.675781 21.703125 C 12.582031 21.703125 12.5 21.628906 12.5 21.535156 L 12.5 20.613281 C 12.5 20.523438 12.582031 20.445312 12.675781 20.445312 Z M 12.675781 18.253906 L 13.808594 18.253906 C 13.902344 18.253906 13.984375 18.332031 13.984375 18.425781 L 13.984375 19.347656 C 13.984375 19.441406 13.902344 19.519531 13.808594 19.519531 L 12.675781 19.519531 C 12.582031 19.519531 12.5 19.441406 12.5 19.347656 L 12.5 18.425781 C 12.5 18.332031 12.582031 18.253906 12.675781 18.253906 Z M 10.027344 12.328125 L 16.457031 12.328125 C 16.558594 12.328125 16.644531 12.363281 16.707031 12.425781 L 16.722656 12.445312 C 16.78125 12.503906 16.8125 12.585938 16.8125 12.667969 L 16.8125 14.609375 C 16.8125 14.703125 16.773438 14.789062 16.707031 14.847656 C 16.644531 14.910156 16.554688 14.949219 16.457031 14.949219 L 10.027344 14.949219 C 9.925781 14.949219 9.839844 14.914062 9.777344 14.847656 L 9.761719 14.832031 C 9.703125 14.769531 9.671875 14.691406 9.671875 14.609375 L 9.671875 12.667969 C 9.671875 12.574219 9.710938 12.488281 9.777344 12.425781 C 9.839844 12.367188 9.929688 12.328125 10.027344 12.328125 Z M 16.414062 12.710938 L 10.070312 12.710938 L 10.070312 14.5625 L 16.414062 14.5625 Z M 17.285156 11.503906 L 9.199219 11.503906 C 9.140625 11.503906 9.085938 11.527344 9.046875 11.566406 C 9.007812 11.601562 8.984375 11.65625 8.984375 11.710938 L 8.984375 22.273438 C 8.984375 22.328125 9.003906 22.375 9.035156 22.410156 L 9.046875 22.421875 C 9.085938 22.457031 9.140625 22.484375 9.199219 22.484375 L 17.28125 22.484375 C 17.339844 22.484375 17.394531 22.457031 17.433594 22.421875 C 17.472656 22.382812 17.496094 22.332031 17.496094 22.273438 L 17.496094 11.710938 C 17.496094 11.660156 17.476562 11.609375 17.445312 11.574219 L 17.433594 11.566406 C 17.398438 11.527344 17.34375 11.503906 17.285156 11.503906 Z M 3.316406 12.292969 C 3.109375 12.292969 2.941406 12.132812 2.941406 11.929688 C 2.941406 11.730469 3.109375 11.566406 3.316406 11.566406 L 6.460938 11.566406 C 6.671875 11.566406 6.839844 11.730469 6.839844 11.929688 C 6.839844 12.132812 6.671875 12.292969 6.460938 12.292969 Z M 3.316406 15.050781 C 3.109375 15.050781 2.941406 14.886719 2.941406 14.6875 C 2.941406 14.484375 3.109375 14.324219 3.316406 14.324219 L 6.460938 14.324219 C 6.671875 14.324219 6.839844 14.484375 6.839844 14.6875 C 6.839844 14.886719 6.671875 15.050781 6.460938 15.050781 Z M 3.453125 3.230469 C 3.222656 3.230469 3.03125 3.410156 3.03125 3.640625 C 3.03125 3.859375 3.214844 4.046875 3.453125 4.046875 L 6.335938 4.046875 C 6.5625 4.046875 6.757812 3.867188 6.757812 3.640625 C 6.757812 3.421875 6.574219 3.230469 6.335938 3.230469 Z M 11.597656 4.371094 L 11.597656 1.421875 L 15.035156 4.785156 L 12.023438 4.785156 C 11.90625 4.785156 11.800781 4.734375 11.722656 4.664062 C 11.644531 4.589844 11.597656 4.484375 11.597656 4.371094 Z M 3.453125 6.039062 C 3.222656 6.039062 3.03125 6.21875 3.03125 6.445312 C 3.03125 6.667969 3.214844 6.855469 3.453125 6.855469 L 10.824219 6.855469 C 11.054688 6.855469 11.25 6.675781 11.25 6.445312 C 11.25 6.226562 11.0625 6.039062 10.824219 6.039062 Z M 3.453125 8.753906 C 3.222656 8.753906 3.03125 8.933594 3.03125 9.160156 C 3.03125 9.382812 3.214844 9.570312 3.453125 9.570312 L 12.980469 9.570312 C 13.210938 9.570312 13.40625 9.390625 13.40625 9.160156 C 13.40625 8.941406 13.21875 8.753906 12.980469 8.753906 Z M 3.453125 8.753906 " />
                                        </g>
                                    </svg>

                                    <span class="ml-3">Pages</span>
                                </a>
                            </li>
                        @endcan
                        @can('file-manager')
                            <li>
                                <a href="{{ url('file-manager') }}"  class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"/> <path d="M3 21v-13l9 -4l9 4v13" /> <path d="M13 13h4v8h-10v-6h6" /> <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" /> </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">File Manager</span>
                                </a>
                            </li>
                        @endcan
                        @can('sales')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-sales" data-collapse-toggle="dropdown-sales">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M14.8333 21V15C14.8333 13.8954 13.9379 13 12.8333 13H10.8333C9.72874 13 8.83331 13.8954 8.83331 15V21"
                                            stroke="currentColor" stroke-miterlimit="16" />
                                        <path
                                            d="M21.8183 9.36418L20.1243 3.43517C20.0507 3.17759 19.8153 3 19.5474 3H15.5L15.9753 8.70377C15.9909 8.89043 16.0923 9.05904 16.2532 9.15495C16.6425 9.38698 17.4052 9.81699 18 10C19.0158 10.3125 20.5008 10.1998 21.3465 10.0958C21.6982 10.0526 21.9157 9.7049 21.8183 9.36418Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M14 10C14.5675 9.82538 15.2879 9.42589 15.6909 9.18807C15.8828 9.07486 15.9884 8.86103 15.9699 8.63904L15.5 3H8.5L8.03008 8.63904C8.01158 8.86103 8.11723 9.07486 8.30906 9.18807C8.71207 9.42589 9.4325 9.82538 10 10C11.493 10.4594 12.507 10.4594 14 10Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M3.87567 3.43517L2.18166 9.36418C2.08431 9.7049 2.3018 10.0526 2.6535 10.0958C3.49916 10.1998 4.98424 10.3125 6 10C6.59477 9.81699 7.35751 9.38698 7.74678 9.15495C7.90767 9.05904 8.00913 8.89043 8.02469 8.70377L8.5 3H4.45258C4.18469 3 3.94926 3.17759 3.87567 3.43517Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Sales</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-sales" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ url('sales') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">All
                                            Sales</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('sales') }}?type_sale=BACK_OFFICE_SALE"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Back-office
                                            Sales</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('sales') }}?type_sale=ONLINE_SALE"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Online
                                            Sales</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('new-sale') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">New
                                            Sales</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('bills')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-bills" data-collapse-toggle="dropdown-bills">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" width="20px" height="20px" viewBox="0 0 20 20"
                                        version="1.1">
                                        <g id="surface1">
                                            <path fill-rule="evenodd"
                                                d="M 11.25 0 C 11.941406 0 12.5 0.558594 12.5 1.25 L 12.5 3.75 C 12.5 4.441406 11.941406 5 11.25 5 L 8.125 5 L 8.125 6.25 L 16.566406 6.25 C 17.835938 6.25 18.886719 7.152344 19.070312 8.375 L 19.957031 14.222656 C 19.984375 14.40625 20 14.59375 20 14.78125 L 20 17.5 C 20 18.878906 18.878906 20 17.5 20 L 2.5 20 C 1.117188 20 0 18.878906 0 17.5 L 0 14.78125 C 0 14.59375 0.015625 14.40625 0.0429688 14.222656 L 0.929688 8.375 C 1.113281 7.152344 2.164062 6.25 3.398438 6.25 L 5.589844 6.25 L 5.589844 5 L 2.464844 5 C 1.808594 5 1.214844 4.441406 1.214844 3.75 L 1.214844 1.25 C 1.214844 0.558594 1.808594 0 2.464844 0 Z M 3.75 1.875 C 3.40625 1.875 3.125 2.15625 3.125 2.5 C 3.125 2.84375 3.40625 3.125 3.75 3.125 L 10 3.125 C 10.34375 3.125 10.625 2.84375 10.625 2.5 C 10.625 2.15625 10.34375 1.875 10 1.875 Z M 3.125 17.5 L 16.875 17.5 C 17.21875 17.5 17.5 17.21875 17.5 16.875 C 17.5 16.53125 17.21875 16.25 16.875 16.25 L 3.125 16.25 C 2.78125 16.25 2.5 16.53125 2.5 16.875 C 2.5 17.21875 2.78125 17.5 3.125 17.5 Z M 4.375 8.4375 C 3.859375 8.4375 3.4375 8.855469 3.4375 9.375 C 3.4375 9.894531 3.859375 10.3125 4.375 10.3125 C 4.894531 10.3125 5.3125 9.894531 5.3125 9.375 C 5.3125 8.855469 4.894531 8.4375 4.375 8.4375 Z M 8.125 10.3125 C 8.644531 10.3125 9.0625 9.894531 9.0625 9.375 C 9.0625 8.855469 8.644531 8.4375 8.125 8.4375 C 7.605469 8.4375 7.1875 8.855469 7.1875 9.375 C 7.1875 9.894531 7.605469 10.3125 8.125 10.3125 Z M 6.25 11.5625 C 5.730469 11.5625 5.3125 11.980469 5.3125 12.5 C 5.3125 13.019531 5.730469 13.4375 6.25 13.4375 C 6.769531 13.4375 7.1875 13.019531 7.1875 12.5 C 7.1875 11.980469 6.769531 11.5625 6.25 11.5625 Z M 11.875 10.3125 C 12.394531 10.3125 12.8125 9.894531 12.8125 9.375 C 12.8125 8.855469 12.394531 8.4375 11.875 8.4375 C 11.355469 8.4375 10.9375 8.855469 10.9375 9.375 C 10.9375 9.894531 11.355469 10.3125 11.875 10.3125 Z M 10 11.5625 C 9.480469 11.5625 9.0625 11.980469 9.0625 12.5 C 9.0625 13.019531 9.480469 13.4375 10 13.4375 C 10.519531 13.4375 10.9375 13.019531 10.9375 12.5 C 10.9375 11.980469 10.519531 11.5625 10 11.5625 Z M 15.625 10.3125 C 16.144531 10.3125 16.5625 9.894531 16.5625 9.375 C 16.5625 8.855469 16.144531 8.4375 15.625 8.4375 C 15.105469 8.4375 14.6875 8.855469 14.6875 9.375 C 14.6875 9.894531 15.105469 10.3125 15.625 10.3125 Z M 13.75 11.5625 C 13.230469 11.5625 12.8125 11.980469 12.8125 12.5 C 12.8125 13.019531 13.230469 13.4375 13.75 13.4375 C 14.269531 13.4375 14.6875 13.019531 14.6875 12.5 C 14.6875 11.980469 14.269531 11.5625 13.75 11.5625 Z M 13.75 11.5625 " />
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Bills</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-bills" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ url('bill') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Bills</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('new-bill') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">New
                                            Bill</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('quotes')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-quotes" data-collapse-toggle="dropdown-quotes">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                                        <path
                                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Quotes</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-quotes" class="hidden py-2 space-y-2">
                                    @can('quotes')
                                        <li>
                                            <a href="{{ url('quote') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Quotes</a>
                                        </li>
                                    @endcan
                                    @can('create-quote')
                                        <li>
                                            <a href="{{ route('new-quote') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">New
                                                Quote</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('products-list')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-item" data-collapse-toggle="dropdown-item">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Items</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-item" class="hidden py-2 space-y-2">

                                    <li>
                                        <a href="{{ url('item') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Item
                                            List</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('category') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('attribute') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Attributes</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('stock-sheet')
                            <li>
                                <a href="{{ url('stock-sheets') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21v-13l9 -4l9 4v13" />
                                        <path d="M13 13h4v8h-10v-6h6" />
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Stock Sheet</span>
                                </a>
                            </li>
                        @endcan
                        @can('file-manager')
                            <li>
                                <a href="{{ url('file-manager') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21v-13l9 -4l9 4v13" />
                                        <path d="M13 13h4v8h-10v-6h6" />
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">File Manager</span>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->role == 'patient')
                            <li>
                                <a href="{{ route('medical-record', auth()->user()->getCustomerIdAttribute()) }}"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21v-13l9 -4l9 4v13" />
                                        <path d="M13 13h4v8h-10v-6h6" />
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Medical Record</span>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->role == 'customer')
                            <li>
                                <a href="{{ url('sales') }}?type_sale=ONLINE_SALE"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21v-13l9 -4l9 4v13" />
                                        <path d="M13 13h4v8h-10v-6h6" />
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Online Sale</span>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->role == 'doctor')

                            <li>
                                <a href="{{ url('doctor/' . auth()->user()->getDoctorIdAttribute() . '/edit') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21v-13l9 -4l9 4v13" />
                                        <path d="M13 13h4v8h-10v-6h6" />
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Profile</span>
                                </a>
                            </li>
                        @endcan
                        @can('bookings')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-submission"
                                    data-collapse-toggle="dropdown-submission">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                        sidebar-toggle-item>Bookings</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-submission" class="hidden py-2 space-y-2">
                                    @can('rental-bookings')
                                        <li>
                                            <a href="{{ url('rental-submissions') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Rentals</a>
                                        </li>
                                    @endcan
                                    @can('appointment-bookings')
                                        <li>
                                            <a href="{{ url('appointment-lists') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Appointments</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        <!--<li>
<a href="{{ url('customer') }}" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
<svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
<path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
<path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
</svg>
<span class="ml-3 flex-1 whitespace-nowrap">Customers</span>
</a>
</li>-->

                        <!-- <li>
<a href="{{ url('user') }}" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
<svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
</svg>
<span class="ml-3 flex-1 whitespace-nowrap">Users</span>
</a>
</li>-->

                        @can('users-list')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-users" data-collapse-toggle="dropdown-users">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                        sidebar-toggle-item>Users</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-users" class="hidden py-2 space-y-2">
                                    @can('customer-users-list')
                                        <li>
                                            <a href="{{ url('customer') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Customer</a>
                                        </li>
                                    @endcan
                                    @can('doctor-users-list')
                                        <li>
                                            <a href="{{ url('doctor') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Doctors</a>
                                        </li>
                                    @endcan
                                    @can('patients-users-list')
                                        <li>
                                            <a href="{{ url('patients') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Patients</a>
                                        </li>
                                    @endcan
                                    @can('supplier-users-list')
                                        <li>
                                            <a href="{{ url('supplier') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">
                                                Suppliers
                                            </a>
                                        </li>
                                    @endcan
                                    @can('system-users-list')
                                        <li>
                                            <a href="{{ url('user') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">System</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @if (in_array($role, ['admin']))
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-access-control"
                                    data-collapse-toggle="dropdown-access-control">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                        sidebar-toggle-item>Access Control</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-access-control" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ url('roles') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Roles</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('permissions') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Permissions</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @can('accounting')
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-accounting"
                                    data-collapse-toggle="dropdown-accounting">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                        height="24px" viewBox="0 0 18 23" version="1.1">
                                        <g id="surface1">
                                            <path fill-rule="evenodd"
                                                d="M 11.460938 0.140625 C 11.390625 0.078125 11.285156 0.0351562 11.183594 0.0351562 C 11.160156 0.0351562 11.136719 0.0351562 11.113281 0.0429688 L 0.929688 0.0429688 C 0.679688 0.0429688 0.445312 0.140625 0.273438 0.304688 C 0.105469 0.46875 0 0.691406 0 0.941406 L 0 19.097656 C 0 19.347656 0.105469 19.566406 0.273438 19.730469 C 0.445312 19.898438 0.671875 19.996094 0.929688 19.996094 L 6.691406 19.996094 L 6.691406 19.191406 L 0.921875 19.191406 C 0.902344 19.191406 0.871094 19.1875 0.855469 19.164062 C 0.839844 19.148438 0.824219 19.121094 0.824219 19.097656 L 0.824219 0.941406 C 0.824219 0.914062 0.832031 0.890625 0.855469 0.878906 C 0.871094 0.863281 0.890625 0.847656 0.921875 0.847656 L 10.757812 0.847656 L 10.757812 4.371094 C 10.757812 4.707031 10.902344 5.015625 11.128906 5.234375 C 11.359375 5.453125 11.675781 5.59375 12.023438 5.59375 L 15.601562 5.59375 L 15.601562 9.460938 L 16.453125 9.460938 L 16.453125 5.28125 C 16.460938 5.246094 16.46875 5.21875 16.46875 5.183594 C 16.46875 5.0625 16.410156 4.953125 16.328125 4.875 L 11.511719 0.171875 C 11.496094 0.15625 11.492188 0.152344 11.476562 0.140625 Z M 9.199219 11.019531 L 17.285156 11.019531 C 17.480469 11.019531 17.660156 11.09375 17.792969 11.222656 L 17.808594 11.238281 C 17.929688 11.363281 18 11.53125 18 11.710938 L 18 22.273438 C 18 22.460938 17.921875 22.632812 17.792969 22.761719 L 17.789062 22.761719 C 17.660156 22.886719 17.480469 22.964844 17.285156 22.964844 L 9.199219 22.964844 C 9.003906 22.964844 8.824219 22.890625 8.691406 22.761719 L 8.675781 22.746094 C 8.554688 22.621094 8.480469 22.453125 8.480469 22.273438 L 8.480469 11.710938 C 8.480469 11.523438 8.5625 11.351562 8.691406 11.222656 L 8.695312 11.222656 C 8.824219 11.097656 9.003906 11.019531 9.199219 11.019531 Z M 15.621094 13.039062 L 15.851562 13.039062 L 15.851562 14.242188 L 15.621094 14.242188 Z M 10.175781 16.066406 L 11.304688 16.066406 C 11.402344 16.066406 11.480469 16.140625 11.480469 16.234375 L 11.480469 17.15625 C 11.480469 17.25 11.402344 17.328125 11.304688 17.328125 L 10.175781 17.328125 C 10.078125 17.328125 10 17.25 10 17.15625 L 10 16.234375 C 9.996094 16.140625 10.078125 16.066406 10.175781 16.066406 Z M 10.175781 20.445312 L 11.304688 20.445312 C 11.402344 20.445312 11.480469 20.523438 11.480469 20.613281 L 11.480469 21.535156 C 11.480469 21.628906 11.402344 21.703125 11.304688 21.703125 L 10.175781 21.703125 C 10.078125 21.703125 10 21.628906 10 21.535156 L 10 20.613281 C 9.996094 20.523438 10.078125 20.445312 10.175781 20.445312 Z M 10.175781 18.253906 L 11.304688 18.253906 C 11.402344 18.253906 11.480469 18.332031 11.480469 18.425781 L 11.480469 19.347656 C 11.480469 19.441406 11.402344 19.519531 11.304688 19.519531 L 10.175781 19.519531 C 10.078125 19.519531 10 19.441406 10 19.347656 L 10 18.425781 C 9.996094 18.332031 10.078125 18.253906 10.175781 18.253906 Z M 15.183594 16.066406 L 16.3125 16.066406 C 16.410156 16.066406 16.484375 16.140625 16.484375 16.234375 L 16.484375 17.15625 C 16.484375 17.25 16.40625 17.328125 16.3125 17.328125 L 15.183594 17.328125 C 15.085938 17.328125 15.007812 17.25 15.007812 17.15625 L 15.007812 16.234375 C 15.003906 16.140625 15.082031 16.066406 15.183594 16.066406 Z M 15.183594 20.445312 L 16.3125 20.445312 C 16.410156 20.445312 16.484375 20.523438 16.484375 20.613281 L 16.484375 21.535156 C 16.484375 21.628906 16.40625 21.703125 16.3125 21.703125 L 15.183594 21.703125 C 15.085938 21.703125 15.007812 21.628906 15.007812 21.535156 L 15.007812 20.613281 C 15.003906 20.523438 15.082031 20.445312 15.183594 20.445312 Z M 15.183594 18.253906 L 16.3125 18.253906 C 16.410156 18.253906 16.484375 18.332031 16.484375 18.425781 L 16.484375 19.347656 C 16.484375 19.441406 16.40625 19.519531 16.3125 19.519531 L 15.183594 19.519531 C 15.085938 19.519531 15.007812 19.441406 15.007812 19.347656 L 15.007812 18.425781 C 15.003906 18.332031 15.082031 18.253906 15.183594 18.253906 Z M 12.675781 16.066406 L 13.808594 16.066406 C 13.902344 16.066406 13.984375 16.140625 13.984375 16.234375 L 13.984375 17.15625 C 13.984375 17.25 13.902344 17.328125 13.808594 17.328125 L 12.675781 17.328125 C 12.582031 17.328125 12.5 17.25 12.5 17.15625 L 12.5 16.234375 C 12.5 16.140625 12.582031 16.066406 12.675781 16.066406 Z M 12.675781 20.445312 L 13.808594 20.445312 C 13.902344 20.445312 13.984375 20.523438 13.984375 20.613281 L 13.984375 21.535156 C 13.984375 21.628906 13.902344 21.703125 13.808594 21.703125 L 12.675781 21.703125 C 12.582031 21.703125 12.5 21.628906 12.5 21.535156 L 12.5 20.613281 C 12.5 20.523438 12.582031 20.445312 12.675781 20.445312 Z M 12.675781 18.253906 L 13.808594 18.253906 C 13.902344 18.253906 13.984375 18.332031 13.984375 18.425781 L 13.984375 19.347656 C 13.984375 19.441406 13.902344 19.519531 13.808594 19.519531 L 12.675781 19.519531 C 12.582031 19.519531 12.5 19.441406 12.5 19.347656 L 12.5 18.425781 C 12.5 18.332031 12.582031 18.253906 12.675781 18.253906 Z M 10.027344 12.328125 L 16.457031 12.328125 C 16.558594 12.328125 16.644531 12.363281 16.707031 12.425781 L 16.722656 12.445312 C 16.78125 12.503906 16.8125 12.585938 16.8125 12.667969 L 16.8125 14.609375 C 16.8125 14.703125 16.773438 14.789062 16.707031 14.847656 C 16.644531 14.910156 16.554688 14.949219 16.457031 14.949219 L 10.027344 14.949219 C 9.925781 14.949219 9.839844 14.914062 9.777344 14.847656 L 9.761719 14.832031 C 9.703125 14.769531 9.671875 14.691406 9.671875 14.609375 L 9.671875 12.667969 C 9.671875 12.574219 9.710938 12.488281 9.777344 12.425781 C 9.839844 12.367188 9.929688 12.328125 10.027344 12.328125 Z M 16.414062 12.710938 L 10.070312 12.710938 L 10.070312 14.5625 L 16.414062 14.5625 Z M 17.285156 11.503906 L 9.199219 11.503906 C 9.140625 11.503906 9.085938 11.527344 9.046875 11.566406 C 9.007812 11.601562 8.984375 11.65625 8.984375 11.710938 L 8.984375 22.273438 C 8.984375 22.328125 9.003906 22.375 9.035156 22.410156 L 9.046875 22.421875 C 9.085938 22.457031 9.140625 22.484375 9.199219 22.484375 L 17.28125 22.484375 C 17.339844 22.484375 17.394531 22.457031 17.433594 22.421875 C 17.472656 22.382812 17.496094 22.332031 17.496094 22.273438 L 17.496094 11.710938 C 17.496094 11.660156 17.476562 11.609375 17.445312 11.574219 L 17.433594 11.566406 C 17.398438 11.527344 17.34375 11.503906 17.285156 11.503906 Z M 3.316406 12.292969 C 3.109375 12.292969 2.941406 12.132812 2.941406 11.929688 C 2.941406 11.730469 3.109375 11.566406 3.316406 11.566406 L 6.460938 11.566406 C 6.671875 11.566406 6.839844 11.730469 6.839844 11.929688 C 6.839844 12.132812 6.671875 12.292969 6.460938 12.292969 Z M 3.316406 15.050781 C 3.109375 15.050781 2.941406 14.886719 2.941406 14.6875 C 2.941406 14.484375 3.109375 14.324219 3.316406 14.324219 L 6.460938 14.324219 C 6.671875 14.324219 6.839844 14.484375 6.839844 14.6875 C 6.839844 14.886719 6.671875 15.050781 6.460938 15.050781 Z M 3.453125 3.230469 C 3.222656 3.230469 3.03125 3.410156 3.03125 3.640625 C 3.03125 3.859375 3.214844 4.046875 3.453125 4.046875 L 6.335938 4.046875 C 6.5625 4.046875 6.757812 3.867188 6.757812 3.640625 C 6.757812 3.421875 6.574219 3.230469 6.335938 3.230469 Z M 11.597656 4.371094 L 11.597656 1.421875 L 15.035156 4.785156 L 12.023438 4.785156 C 11.90625 4.785156 11.800781 4.734375 11.722656 4.664062 C 11.644531 4.589844 11.597656 4.484375 11.597656 4.371094 Z M 3.453125 6.039062 C 3.222656 6.039062 3.03125 6.21875 3.03125 6.445312 C 3.03125 6.667969 3.214844 6.855469 3.453125 6.855469 L 10.824219 6.855469 C 11.054688 6.855469 11.25 6.675781 11.25 6.445312 C 11.25 6.226562 11.0625 6.039062 10.824219 6.039062 Z M 3.453125 8.753906 C 3.222656 8.753906 3.03125 8.933594 3.03125 9.160156 C 3.03125 9.382812 3.214844 9.570312 3.453125 9.570312 L 12.980469 9.570312 C 13.210938 9.570312 13.40625 9.390625 13.40625 9.160156 C 13.40625 8.941406 13.21875 8.753906 12.980469 8.753906 Z M 3.453125 8.753906 " />
                                        </g>
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                        sidebar-toggle-item>Accounting</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-accounting" class="hidden py-2 space-y-2">
                                    @can('ledger')
                                        <li>
                                            <a href="{{ url('ledger') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Ledger</a>
                                        </li>
                                    @endcan
                                    @can('journal')
                                        <li>
                                            <a href="{{ url('journal') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Journal</a>
                                        </li>
                                    @endcan
                                    @can('pretty-cash')
                                        <li>
                                            <a href="{{ url('petty_cash') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Petty
                                                Cash</a>
                                        </li>
                                    @endcan
                                    @can('banking')
                                        <li>
                                            <a href="{{ url('banking') }}"
                                                class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Banking</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @if (in_array($role, ['admin']))
                            <li>
                                <button type="button"
                                    class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-online-shop"
                                    data-collapse-toggle="dropdown-online-shop">
                                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                        width="24" height="24" stroke-width="1.5"
                                        viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M14.8333 21V15C14.8333 13.8954 13.9379 13 12.8333 13H10.8333C9.72874 13 8.83331 13.8954 8.83331 15V21"
                                            stroke="currentColor" stroke-miterlimit="16" />
                                        <path
                                            d="M21.8183 9.36418L20.1243 3.43517C20.0507 3.17759 19.8153 3 19.5474 3H15.5L15.9753 8.70377C15.9909 8.89043 16.0923 9.05904 16.2532 9.15495C16.6425 9.38698 17.4052 9.81699 18 10C19.0158 10.3125 20.5008 10.1998 21.3465 10.0958C21.6982 10.0526 21.9157 9.7049 21.8183 9.36418Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M14 10C14.5675 9.82538 15.2879 9.42589 15.6909 9.18807C15.8828 9.07486 15.9884 8.86103 15.9699 8.63904L15.5 3H8.5L8.03008 8.63904C8.01158 8.86103 8.11723 9.07486 8.30906 9.18807C8.71207 9.42589 9.4325 9.82538 10 10C11.493 10.4594 12.507 10.4594 14 10Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path
                                            d="M3.87567 3.43517L2.18166 9.36418C2.08431 9.7049 2.3018 10.0526 2.6535 10.0958C3.49916 10.1998 4.98424 10.3125 6 10C6.59477 9.81699 7.35751 9.38698 7.74678 9.15495C7.90767 9.05904 8.00913 8.89043 8.02469 8.70377L8.5 3H4.45258C4.18469 3 3.94926 3.17759 3.87567 3.43517Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                        sidebar-toggle-item>Online Shop</span>
                                    <svg sidebar-toggle-item
                                        class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                        fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <ul id="dropdown-online-shop" class="hidden py-2 space-y-2">

                                    <li>
                                        <a href="{{ url('homepage-components') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Homepage
                                            Components</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('headermenu') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Header
                                            Menu</a>
                                    </li>
                                    <!-- <li>
<a href="{{ url('homecarousel') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Homepage Carousel</a>
</li>
<li>
<a href="{{ url('home-collection-image') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Homepage Collection Images
<div class=""></div>
</a>
</li>-->
                                    <li>
                                        <a href="{{ url('delivery') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Delivery</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('store-settings') }}"
                                            class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Store
                                            Settings</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ url('settings') }}"
                                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                    <span class="ml-3 flex-1 whitespace-nowrap">Settings</span>
                                </a>
                            </li>
                        @endif
                        {{-- <li>
                        <a href="{{ url('store') }}" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group ">
                            <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3 flex-1 whitespace-nowrap">Store</span>
                        </a>
                    </li> --}}
        </ul>
        <div class="space-y-2 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                        width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8m4-9-4-4m4 4-4 4m4-4H9" />
                    </svg>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
</div>
</aside>

<div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>

@endif
