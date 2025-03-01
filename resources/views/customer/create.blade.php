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
                            <a href="{{ url('customer') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Customer</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Customer</h1>
            
        </div>
    </x-slot>

    <div class="font-sans antialiased" >
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('customer.index') }}" enctype="multipart/form-data">
                        @csrf
                        <span style="float:right;" class="col-md-12"><input class="checkbox" type="checkbox" name="can_customer_company"
       value="1" id="can_customer_company" 
       {{ old('can_customer_company', 0) == 1 ? 'checked' : '' }}> Customer is a Company</span>
                        <div class="grid md:grid-cols-4  md:gap-6" style="clear:both;">
                            <!-- Company Name -->
                            <div id="c-field">
                                <label class="block text-sm font-medium text-gray-700" for="company_name">
                                    <span class="text-red-600" >*</span>  Company Name <br>

                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="company_name" placeholder="Company name"
                                    value="{{ old('company_name') }}">
                                <small>If trading as individual, put individual full name as company name</small>
                                @error('company_name')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Contact First Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" id="fn-field-star" >*</span>  First Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="firstname" placeholder="Contact First Name"
                                    value="{{ old('firstname') }}">
                                @error('firstname')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <!-- Contact Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" id="ln-field-star">*</span>  Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name"
                                    value="{{ old('lastname') }}">
                                @error('lastname')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Address 1 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address1" placeholder="Address 1"
                                    value="{{ old('address1') }}">
                                @error('address1')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Address 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="address2">
                                    Address 2
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address2" placeholder="Address 2"
                                    value="{{ old('address2') }}">
                                @error('address2')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="city">
                                    City
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="city" placeholder="City" value="{{ old('city') }}">
                                @error('city')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="country">
                                    Country
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="country" placeholder="Country" value="{{ old('country') }}">
                                @error('country')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>   Email
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="tel" name="phone" placeholder="Phone" value="{{ old('phone') }}"
                                    pattern="[+]{1}[0-9]{7,14}|[0-9]{7,14}|[-]{1}[0-9]{7,14}"
                                    oninvalid="setCustomValidity('Please insert a valid mobile number')"
                                    onchange="try{setCustomValidity('')}catch(e){}">
                                @error('phone')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Fax -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="password">
                                    Password
                                </label>
                                <input name="password" type="password"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Password">
                                @error('password')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="price">
                                    Fax
                                </label>
                                <input name="fax" type="text"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Fax" value="{{ old('fax') }}">
                                @error('price')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- BRN -->
                            <div class="mt-4" id='brn-field'>
                                <label class="block text-sm font-medium text-gray-700" for="brn_customer">
                                    BRN
                                </label>
                                <input name="brn_customer" type="text"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="BRN" value="{{ old('brn_customer') }}">
                                @error('brn_customer')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <!-- VAT -->
                            <div class="mt-4" id='vat-field'>
                                <label class="block text-sm font-medium text-gray-700" for="vat_customer">
                                    VAT
                                </label>
                                <input name="vat_customer" type="text"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="VAT" value="{{ old('vat_customer') }}">
                                @error('vat_customer')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <!-- Note -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="note_customer">
                                    Note
                                </label>
                                <textarea name="note_customer"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    rows="4" placeholder="Note"> {{ old('note_customer') }}</textarea>
                                @error('note_customer')
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

<script>
    let fields = document.getElementById('c-field');
    let brn_fields = document.getElementById('brn-field');
    let vat_fields = document.getElementById('vat-field');
    fields.style.display = 'none'; // Hide fields
    brn_fields.style.display = 'none'; // Hide fields
    vat_fields.style.display = 'none'; // Hide fields 
  document.getElementById('can_customer_company').addEventListener('change', function() {
    let fields = document.getElementById('c-field');
    let brn_fields = document.getElementById('brn-field');
    let vat_fields = document.getElementById('vat-field');
    let ln_field_star = document.getElementById("ln-field-star");
    let fn_field_star = document.getElementById("fn-field-star");
    if (this.checked) {
      

      fields.style.display = 'block'; // Show fields
      brn_fields.style.display = 'block'; // Show fields
      vat_fields.style.display = 'block'; // Show fields
      fn_field_star.style.display = 'none';
      ln_field_star.style.display = 'none';
    } else {
        fields.style.display = 'none'; // Hide fields
        brn_fields.style.display = 'none'; // Hide fields
        vat_fields.style.display = 'none'; // Hide fields   
        fn_field_star.style.display = 'block';
        ln_field_star.style.display = 'block';   
    }
  });

  $(document).ready(function() {
    function toggleFields() {
        if ($('#can_customer_company').is(':checked')) {
            fields.style.display = 'block'; // Show fields
            brn_fields.style.display = 'block'; // Show fields
            vat_fields.style.display = 'block'; // Show fields
            fn_field_star.style.display = 'none';
            ln_field_star.style.display = 'none';
            
        } else {
            fields.style.display = 'none'; // Hide fields
            brn_fields.style.display = 'none'; // Hide fields
            vat_fields.style.display = 'none'; // Hide fields  
            fn_field_star.style.display = 'block';
            ln_field_star.style.display = 'block';
        }
    }

    // Run on page load
    toggleFields();

    // Run on checkbox change
    $('#can_customer_company').change(function() {
        toggleFields();
    });
});
</script>
