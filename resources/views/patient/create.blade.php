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
                            <a href="{{ url('patients') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Patient</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Patient</h1>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('patients.index') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid md:grid-cols-4  md:gap-6">
                            <!-- First Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                  <span class="text-red-600" >*</span>  First Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="firstname" placeholder="First Name" value="{{old('firstname')}}">
                                @error('firstname')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span> Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name" value="{{old('lastname')}}">
                                @error('lastname')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- NID -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  NID/Passport Number
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="nid" placeholder="NID/Passport Number" value="{{old('nid')}}">
                                @error('nid')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                        
                            <!-- DoB -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                      Date of Birth
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="date" name="date_of_birth" id="date_of_birth" value="{{old('date_of_birth')}}">
                                @error('date_of_birth')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-4  md:gap-6">
                            <!-- Email -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span> Email
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
                            <!-- Phone -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="phone" placeholder="Phone" value="{{old('phone')}}"
                                    pattern="[+]{1}[0-9]{7,14}|[0-9]{7,14}|[-]{1}[0-9]{7,14}"
                                    oninvalid="setCustomValidity('Please insert a valid mobile number')"
                                    onchange="try{setCustomValidity('')}catch(e){}">
                                @error('phone')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- Mobile -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    <span class="text-red-600" >*</span>   Mobile
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="mobile_no" placeholder="Mobile" value="{{old('mobile_no')}}"
                                    oninvalid="setCustomValidity('Please insert a valid mobile number')"
                                    onchange="try{setCustomValidity('')}catch(e){}">
                                @error('mobile_no')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- Mobile -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    WhatsApp
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="whatsapp" placeholder="WhatsApp" value="{{old('whatsapp')}}"
                                    oninvalid="setCustomValidity('Please insert a valid WhatsApp')"
                                    onchange="try{setCustomValidity('')}catch(e){}">
                                @error('whatsapp')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <h2>Residential Address</h2>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            
                            <!-- Address 1 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address1" placeholder="Address 1" value="{{old('address1')}}">
                                @error('address1')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- address2 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Village/Town
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address2" placeholder="Village/Town" value="{{old('address2')}}">
                                @error('address2')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <h2>Work Address</h2>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            
                            <!-- Address 1 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="work_address" placeholder="Address 1" value="{{old('work_address')}}">
                                @error('work_address')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- address2 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Village/Town
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="work_village" placeholder="Village/Town" value="{{old('work_village')}}">
                                @error('work_village')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <h2>Other Address</h2>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            
                            <!-- Address 1 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="other_address" placeholder="Address 1" value="{{old('other_address')}}">
                                @error('other_address')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- address2 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Village/Town
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="other_village" placeholder="Village/Town" value="{{old('other_village')}}">
                                @error('other_village')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
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



</x-app-layout>
