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
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create User</h1>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('user.index') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                <span class="text-red-600" >*</span>    Name
                            </label>

                            <input required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="name" placeholder="Name" value="{{old('name')}}">
                            @error('name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Login -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="login">
                                <span class="text-red-600" >*</span>    Login
                            </label>

                            <input required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="login" placeholder="Login" value="{{old('login')}}">
                            @error('login')
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
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="password" name="password" placeholder="Password" value="{{old('password')}}">
                            @error('password')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                <span class="text-red-600" >*</span>  Email
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="email" name="email" placeholder="Email" value="{{old('email')}}">
                            @error('email')
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
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="tel" name="phone" placeholder="Mobile Number" value="{{old('phone')}}">
                            @error('phone')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="role"><span class="text-red-600" >*</span> Role</label>
                            <select name="role"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Access Online Store Orders -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="vat_customer">
                                Access Online Store Orders
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="access_online_store_orders" type="radio" checked id="access_online_store_orders_yes"
                                       class=""
                                       value="yes">
                                <label class="custom-control-label" for="access_online_store_orders_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="access_online_store_orders" type="radio" id="access_online_store_orders_no"
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
                            <label class="block text-sm font-medium text-gray-700" for="vat_customer">
                                Alarm when receive notification
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="alarm_notification" type="radio" checked id="alarm_notification_yes"
                                       class=""
                                       value="yes">
                                <label class="custom-control-label" for="alarm_notification_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="alarm_notification" type="radio" id="alarm_notification_no"
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
                            <label class="block text-sm font-medium text-gray-700" for="vat_customer">
                                Payment Received SMS
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_received" type="radio" checked id="sms_received_yes"
                                       class=""
                                       value="yes">
                                <label class="custom-control-label" for="sms_received_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_received" type="radio" id="sms_received_no"
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
                            <label class="block text-sm font-medium text-gray-700" for="vat_customer">
                                Access Online Store Orders
                            </label>

                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_validate" type="radio" checked id="sms_validate_yes"
                                       class=""
                                       value="yes">
                                <label class="custom-control-label" for="sms_validate_yes">Yes</label>
                            </div>
                            <div class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <input name="sms_validate" type="radio" id="sms_validate_no"
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
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server: {
                    url: '/item-image',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },

            })
        </script>
    @endsection

</x-app-layout>
