<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <a href="{{ url('dashboard') }}"
                            class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Home</a>
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
                            <a href="{{ url('supplier') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Supplier</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                aria-current="page">Create Supplier</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Supplier</h1>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('supplier.index') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="mt-4 flex text-sm font-medium">Informations</label>
                        <!-- Contact Name -->
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                <span class="text-red-600" >*</span>  Company Name 
                            </label>

                            <input required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="name" placeholder="Company Name*" value="{{old('name')}}">
                            @error('name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Address -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="address">
                                Address
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="address" placeholder="Address" value="{{old('address')}}">
                            @error('address')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="brn">
                                BRN
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="brn" placeholder="BRN" value="{{old('brn')}}">
                            @error('brn')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="city">
                                VAT Number
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="vat_supplier" placeholder="VAT Number" value="{{old('vat_supplier')}}">
                            @error('vat_supplier')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="default-toggle1" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value=""
                                       id="default-toggle1" name="halal_certified" class="sr-only peer" >
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">Halal Certified</span>
                            </label>
                            @error('halal_certified')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                            Order Email
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="email" name="order_email" placeholder="Order Email" value="{{old('order_email')}}">
                            @error('order_email')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="credit_limit">
                             Credit limit
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="credit_limit" placeholder="Credit limit" value="{{old('credit_limit')}}">
                            @error('credit_limit')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="payment_frequency">
                            Payment Frequency
                            </label>
                            <select name="payment_frequency" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                 placeholder="Payment Frequency">
                                <option value="">None</option>
                                <option value="After 3 days">After 3 days</option>
                                <option value="After 15 days">After 15 days</option>
                                <option value="After 1 month">After 1 month</option>
                            </select>
                            @error('payment_frequency')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="ordering_frequency">
                            Ordering Frequency
                            </label>
                            <select name="ordering_frequency" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                 placeholder="Ordering Frequency">
                                <option value="">NULL</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                            @error('ordering_frequency')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="city">
                                Delivery Days
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="delivery_days" placeholder="Delivery Days" value="{{old('delivery_days')}}">
                            @error('delivery_days')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <label class="mt-6 flex text-sm font-medium">Payment Info</label>
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700" for="bank_name">
                            Bank Name
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="bank_name" placeholder="Bank Name" value="{{old('bank_name')}}">
                            @error('bank_name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="account_name">
                            Account Name
                            </label>
                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="account_name" placeholder="Account Name" value="{{old('account_name')}}">
                            @error('account_name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="account_number">
                            Account Number
                            </label>
                            <input name="account_number" type="text"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   placeholder="Account Number" value="{{old('account_number')}}">
                            @error('account_number')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        
                        <label class="mt-6 flex text-sm font-medium">Contact Person</label>
                        <!-- Contact Last Name -->
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700" for="name_person">
                                Name
                            </label>

                            <input
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="name_person" placeholder="Contact Person Name" value="{{old('name_person')}}">
                            @error('name_person')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="email_address">
                            Email
                            </label>
                            <input name="email_address" type="email"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   placeholder="Email" value="{{old('email_address')}}">
                            @error('email_address')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- VAT -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="mobile">
                            Mobile
                            </label>
                            <input name="mobile" type="text"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   placeholder="Mobile" value="{{old('mobile')}}">
                            @error('mobile')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- City -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="office_phone">
                            Office Phone
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="office_phone" placeholder="Office Phone" value="{{old('office_phone')}}">
                            @error('office_phone')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Note -->
                        {{--<div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700" for="note_supplier">
                                Note
                            </label>
                            <textarea name="note_supplier"
                                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                      rows="4" placeholder="Note"> {{old('note_supplier')}}</textarea>
                            @error('note_supplier')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>--}}


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
