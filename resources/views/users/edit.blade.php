<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('user') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">User</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update User</h1>
        </div>
        <div class="mx-4 my-4 w-full">
        @if (session()->has('message'))
        <div class="p-3 rounded bg-green-500 text-green-100 my-2">
            {{ session('message') }}
        </div>
        @endif
    </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('user.update', $user->id) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Name
                                </label>
                                <input required
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                <span class="text-red-600 text-sm">
            {{ $message }}
        </span>
                                @enderror
                            </div>

                            <!-- Login -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="login">
                                    Login
                                </label>
                                <input required
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="login" placeholder="Login" value="{{ old('login', $user->login) }}">
                                @error('login')
                                <span class="text-red-600 text-sm">
            {{ $message }}
        </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="email">
                                    Email
                                </label>
                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                <span class="text-red-600 text-sm">
            {{ $message }}
        </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="password">
                                    Password
                                </label>
                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="password" name="password" placeholder="Password" value="{{ old('password') }}">
                                @error('password')
                                <span class="text-red-600 text-sm">
            {{ $message }}
        </span>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Mobile Number
                                </label>
                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="phone" placeholder="Mobile Number" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                <span class="text-red-600 text-sm">
            {{ $message }}
        </span>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="role">Role</label>
                                <select name="role"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @if ($user->hasRole($role->name)) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    <!-- Access Online Store Orders -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="access_online_store_orders">
                                Access Online Store Orders
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="access_online_store_orders" type="radio"  id="access_online_store_orders_yes" @if ($user->access_online_store_orders == 'yes') checked @endif
                                class=""
                                       value="yes">
                                <label class="custom-control-label" for="access_online_store_orders_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="access_online_store_orders" type="radio" id="access_online_store_orders_no" @if ($user->access_online_store_orders == 'no') checked @endif
                                class=""
                                       value="no">
                                <label class="custom-control-label" for="access_online_store_orders_no">No</label>
                            </div>


                            @error('access_online_store_orders')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Alarm when receive notification -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="alarm_notification">
                                Alarm when receive notification
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="alarm_notification" type="radio" checked id="alarm_notification_yes" @if ($user->alarm_notification == 'yes') checked @endif
                                class=""
                                       value="yes">
                                <label class="custom-control-label" for="alarm_notification_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="alarm_notification" type="radio" id="alarm_notification_no" @if ($user->alarm_notification == 'no') checked @endif
                                class=""
                                       value="no">
                                <label class="custom-control-label" for="alarm_notification_no">No</label>
                            </div>


                            @error('alarm_notification')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Payment Received SMS -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="sms_received">
                                Payment Received SMS
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_received" type="radio" checked id="sms_received_yes" @if ($user->sms_received == 'yes') checked @endif
                                class=""
                                       value="yes">
                                <label class="custom-control-label" for="sms_received_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_received" type="radio" id="sms_received_no" @if ($user->sms_received == 'no') checked @endif
                                class=""
                                       value="no">
                                <label class="custom-control-label" for="sms_received_no">No</label>
                            </div>


                            @error('sms_received')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Access Online Store Orders -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="sms_validate">
                                Access Online Store Orders
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_validate" type="radio" checked id="sms_validate_yes" @if ($user->sms_validate == 'yes') checked @endif
                                class=""
                                       value="yes">
                                <label class="custom-control-label" for="sms_validate_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_validate" type="radio" id="sms_validate_no" @if ($user->sms_validate == 'no') checked @endif
                                class=""
                                       value="no">
                                <label class="custom-control-label" for="sms_validate_no">No</label>
                            </div>


                            @error('sms_validate')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>


                        <div class="flex items-center justify-start mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2 text-sm font-semibold rounded-md text-sky-100 bg-sky-500 hover:bg-sky-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

