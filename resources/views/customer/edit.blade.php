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
                            <a href="{{ url('customer') }}"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Customers</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block sm:flex items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Customer</h1>
                </div>
                <div class="flex items-center sm:justify-end w-full">
                    <a href="{{ route('customer-details', $customer->id) }}"
                        class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                        Statements
                    </a>
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

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('customer.update', $customer->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <span style="float:right;" class="col-md-12"><input class="checkbox" type="checkbox" name="can_customer_company"
                value="1" {{ $customer->can_customer_company == '1' ? 'checked' : '' }} id="can_customer_company"> Customer is a Company</span>
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" style="clear:both;">
                            <!-- Company Name -->
                            <div id="c-field">
                                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input type="text" id="company_name" name="company_name" placeholder="Company name"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('company_name', $customer->company_name) }}">
                                @error('company_name')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="firstname" placeholder="First Name"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('firstname', $customer->firstname) }}">
                                @error('firstname')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="lastname" placeholder="Last Name"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('lastname', $customer->lastname) }}">
                                @error('lastname')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address 1 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address 1</label>
                                <input type="text" name="address1" placeholder="Address 1"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('address1', $customer->address1) }}">
                                @error('address1')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address 2</label>
                                <input type="text" name="address2" placeholder="Address 2"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('address2', $customer->address2) }}">
                                @error('address2')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" placeholder="City"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('city', $customer->city) }}">
                                @error('city')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" name="country" placeholder="Country"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('country', $customer->country) }}">
                                @error('country')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" placeholder="Email"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('email', $customer->email) }}">
                                @error('email')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" placeholder="Password" min="8"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('password')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" name="phone" placeholder="Phone"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fax -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fax</label>
                                <input type="text" name="fax" placeholder="Fax"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('fax', $customer->fax) }}">
                                @error('fax')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- BRN -->
                            <div id='brn-field'>
                                <label class="block text-sm font-medium text-gray-700">BRN</label>
                                <input type="text" name="brn_customer" placeholder="BRN"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('brn_customer', $customer->brn_customer) }}">
                                @error('brn_customer')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- VAT -->
                            <div id='vat-field'>
                                <label class="block text-sm font-medium text-gray-700">VAT</label>
                                <input type="text" name="vat_customer" placeholder="VAT"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('vat_customer', $customer->vat_customer) }}">
                                @error('vat_customer')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Note (Full Row) -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Note</label>
                            <textarea name="note_customer" rows="4" placeholder="Note"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('note_customer', $customer->note_customer) }}</textarea>
                            @error('note_customer')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-start mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 text-sm font-semibold rounded-md text-sky-100 bg-sky-500 hover:bg-sky-700 focus:outline-none">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/u4g64ic0cse8sfc9rj7epn3aswt4n406ej27oacxf3q2qu0u/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- include jQuery library -->
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
    if (this.checked) {
      

      fields.style.display = 'block'; // Show fields
      brn_fields.style.display = 'block'; // Show fields
      vat_fields.style.display = 'block'; // Show fields
    } else {
        fields.style.display = 'none'; // Hide fields
        brn_fields.style.display = 'none'; // Hide fields
        vat_fields.style.display = 'none'; // Hide fields      
    }
  });
  $(document).ready(function() {
    function toggleFields() {
        if ($('#can_customer_company').is(':checked')) {
            fields.style.display = 'block'; // Show fields
            brn_fields.style.display = 'block'; // Show fields
            vat_fields.style.display = 'block'; // Show fields
        } else {
            fields.style.display = 'none'; // Hide fields
            brn_fields.style.display = 'none'; // Hide fields
            vat_fields.style.display = 'none'; // Hide fields  
        }
    }

    
    function checkCompanyName() {
        const companyName = $('#company_name').val(); // Assuming the company name field has id="company_name"
        
        // If company name is not empty, check the checkbox
        if (companyName.trim() !== '') {
            $('#can_customer_company').prop('checked', true); // Check the checkbox
        } else {
            $('#can_customer_company').prop('checked', false); // Uncheck the checkbox
        }
    }

    // Run on page load to toggle fields and check company name
    checkCompanyName();
    toggleFields();
    

    // Run on checkbox change
    $('#can_customer_company').change(function() {
        toggleFields();
    });
});

</script>
