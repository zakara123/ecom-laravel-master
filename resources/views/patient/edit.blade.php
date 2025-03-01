<x-app-layout>
    <style>
        .list-group {
            padding-left: 0;
            margin-bottom: 20px;
        }
        .list-group-item:first-child {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }
            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            .fa.pull-right {
                    margin-left: .3em;
                }

                .text-aqua {
                    color: #00c0ef !important;
                }
                .text-aqua {
                    color: #00c0ef !important;
                }
                .pull-right {
                    float: right;
                }
                .fa {
                    display: inline-block;
                    font: normal normal normal 14px / 1 FontAwesome;
                    font-size: inherit;
                    text-rendering: auto;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                }
                .pull-right {
                    float: right !important;
                }
                .fa-arrow-circle-right:before {
                    content: "\f0a9";
                }
        </style>
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
                            Dashboard
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
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Patients</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Medical Record of {{$customer->firstname}} {{$customer->lastname}}, UPI: {{$customer->upi}}</h1>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="mx-1 my-4 w-full">
        @if (session()->has('message'))
            <div class="p-2 rounded bg-green-500 text-green-100 my-2" id="message_product">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="w-full flex gap-4">
        @include('patient.patient_left_nav', ['customer_id' => $customer->id])
        
        <div class="w-4/5 bg-gray-200">

            <div class="w-full overflow-hidden bg-white">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 p-5">Edit KYC</h1>
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('patient-update', $customer->id) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                        <div class="grid md:grid-cols-4  md:gap-6">
                            <!-- First Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    First Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="firstname" placeholder="First Name" value="{{old('firstname',$customer->firstname)}}">
                                @error('firstname')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name" value="{{old('lastname',$customer->lastname)}}">
                                @error('name')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- NID -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    NID/Passport Number
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="nid" placeholder="NID/Passport Number" value="{{old('nid',$customer->nid)}}">
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
                                    type="date" name="date_of_birth" id="date_of_birth" value="{{old('date_of_birth',$customer->date_of_birth)}}">
                                @error('email')
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
                                    Email
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email" value="{{old('email',$customer->email)}}">
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
                                    type="tel" name="phone" placeholder="Phone" value="{{old('phone',$customer->phone)}}"
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
                                    Mobile
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="mobile_no" placeholder="Mobile" value="{{old('mobile_no',$customer->mobile_no)}}"
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
                                    WhatsApp
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="whatsapp" placeholder="WhatsApp" value="{{old('whatsapp',$customer->whatsapp)}}"
                                    oninvalid="setCustomValidity('Please insert a valid WhatsApp')"
                                    onchange="try{setCustomValidity('')}catch(e){}">
                                @error('whatsapp')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <!-- Sex -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Sex
                                </label>

                                <select name="sex"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Sex" value="{{old('sex')}}">
                                <option value="Male" @if ($customer->sex == 'Male') selected @endif>Male</option>
                                <option value="Female" @if ($customer->sex == 'Female') selected @endif>Female</option>
                            </select>
                                @error('sex')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <!-- Blood Group -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Blood Group
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="blood_group" placeholder="Blood Group" value="{{old('blood_group',$customer->blood_group)}}">
                                @error('blood_group')
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
                                    type="text" name="address1" placeholder="Address 1" value="{{old('address1',$customer->address1)}}">
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
                                    type="text" name="address2" placeholder="Village/Town" value="{{old('address2',$customer->address2)}}">
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
                                    type="text" name="work_address" placeholder="Address 1" value="{{old('work_address',$customer->work_address)}}">
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
                                    type="text" name="work_village" placeholder="Village/Town" value="{{old('work_village',$customer->work_village)}}">
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
                                    type="text" name="other_address" placeholder="Address 1" value="{{old('other_address',$customer->other_address)}}">
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
                                    type="text" name="other_village" placeholder="Village/Town" value="{{old('other_village',$customer->other_village)}}">
                                @error('other_village')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <h2>Account Info</h2>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            
                            <!-- Account Password -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Account Password
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="password" name="account_password" placeholder="Account Password" value="{{old('account_password')}}">
                                @error('account_password')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                                <div class="mb-6 mr-2 w-full">
                                
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="typeOfMoney">
                                        Account Status :
                                    </label>

                                    <select name="account_status" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Account Status" value="{{old('account_status')}}">

                                            <option value="Active" @if(@$user->account_status =='Active') selected @endif>Active</option>
                                            <option value="Not Active" @if(@$user->account_status=='Not Active') selected @endif>Not Active</option>

                                    </select>

                                @error('account_status')
                                <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            
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
    <script src="https://cdn.tiny.cloud/1/u4g64ic0cse8sfc9rj7epn3aswt4n406ej27oacxf3q2qu0u/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- include jQuery library -->
</x-app-layout>
