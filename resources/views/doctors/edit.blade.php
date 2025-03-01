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
                            <a href="{{ url('doctor') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Doctor</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Doctor</h1>
        </div>
        <div class="mx-4 my-4 w-full">
        @if (session()->has('message'))
        <div class="p-3 rounded bg-green-500 text-green-100 my-2">
            {{ session('message') }}
        </div>
        @endif
        @error('specialities')
        <div class="p-4 mb-4 mx-5 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            At least one speciality should be chosen, when doctor type is specialist.
        </div>
        @enderror
    </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('doctor.update', $doctor->id) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid md:grid-cols-4  md:gap-6">
                        <!--First Name -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                First Name
                            </label>

                            <input required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="first_name" placeholder="First Name" value="{{old('first_name',$doctor->first_name)}}">
                            @error('first_name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>


                        <!--Last Name -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Last Name
                            </label>

                            <input required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="last_name" placeholder="last Name" value="{{old('last_name',$doctor->last_name)}}">
                            @error('last_name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!--Nationality -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Nationality
                            </label>

                            <input 
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="nationality" placeholder="Nationality" value="{{old('nationality',$doctor->nationality)}}">
                            @error('nationality')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!--nid_passport_no -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                NID/Passport No
                            </label>

                            <input 
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   type="text" name="nid_passport_no" placeholder="NID/Passport No" value="{{old('nid_passport_no',$doctor->nid_passport_no)}}">
                            @error('nid_passport_no')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="grid md:grid-cols-4  md:gap-6">
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="role">
                                Sex
                            </label>
                            <select name="sex"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Sex" value="{{old('sex')}}">
                                <option value="Male" @if ($doctor->sex == 'Male') selected @endif>Male</option>
                                <option value="Female" @if ($doctor->sex == 'Female') selected @endif>Female</option>
                            </select>
                            @error('sex')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Email
                            </label>

                            <input required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="email" name="email" placeholder="Email" value="{{old('email',$doctor->email)}}">
                            @error('email')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Phone Number -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="phone">
                                Phone Number
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="tel" name="phone" placeholder="Phone Number" value="{{old('phone',$doctor->phone)}}">
                            @error('phone')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Mobile Number -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="phone">
                                Mobile Number
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="tel" name="mobile" placeholder="Mobile Number" value="{{old('mobile',$doctor->mobile)}}">
                            @error('mobile')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-4  md:gap-6">
                        <!-- WhatsApp -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="phone">
                                WhatsApp
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="tel" name="whatsapp" placeholder="WhatsApp" value="{{old('whatsapp',$doctor->whatsapp)}}">
                            @error('whatsapp')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        <!-- Address 1 -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Address 1
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="address_1" placeholder="Address 1" value="{{old('address_1',$doctor->address_1)}}">
                            @error('address_1')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- address_2 -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                               Address 2
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="address_2" placeholder="Address 2" value="{{old('address_2',$doctor->address_2)}}">
                            @error('address_2')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Village/Town -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Village/Town
                            </label>

                            <input
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="village_town" placeholder="Village/Town" value="{{old('village_town',$doctor->village_town)}}">
                            @error('village_town')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3  md:gap-6">
                        

                        <!-- Language -->
                        <div class="mb-6 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="role">
                                Language
                            </label>
                            <select name="languages[]" multiple
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Languages" value="{{old('languages')}}">
                                <option value="English" {{ in_array('English', explode(',', $doctor->languages)) ? 'selected' : '' }}>English</option>
                                <option value="French" {{ in_array('French', explode(',', $doctor->languages)) ? 'selected' : '' }}>French</option>
                                <option value="Mauritian Creole" {{ in_array('Mauritian Creole', explode(',', $doctor->languages)) ? 'selected' : '' }}>Mauritian Creole</option>
                                <option value="Hindi" {{ in_array('Hindi', explode(',', $doctor->languages)) ? 'selected' : '' }}>Hindi</option>
                                <option value="Telugu" {{ in_array('Telugu', explode(',', $doctor->languages)) ? 'selected' : '' }}>Telugu</option>
                                <option value="Tamil" {{ in_array('Tamil', explode(',', $doctor->languages)) ? 'selected' : '' }}>Tamil</option>
                                <option value="Malayalam" {{ in_array('Malayalam', explode(',', $doctor->languages)) ? 'selected' : '' }}>Malayalam</option>
                                <option value="Marathi" {{ in_array('Marathi', explode(',', $doctor->languages)) ? 'selected' : '' }}>Marathi</option>
                                <option value="Urdu" {{ in_array('Urdu', explode(',', $doctor->languages)) ? 'selected' : '' }}>Urdu</option>
                                <option value="Mandarin" {{ in_array('Mandarin', explode(',', $doctor->languages)) ? 'selected' : '' }}>Mandarin</option>
                            </select>
                            @error('languages')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="role">
                                    Doctor Type
                                </label>
                                <select name="type" required onchange="handleDropdownChange();"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        id="type">
                                    <option value="">Select Type</option>
                                    <option value="Specialist" {{ old('type', $doctor->type) == 'Specialist' ? 'selected' : '' }}>Specialist</option>
                                    <option value="Generalist" {{ old('type', $doctor->type) == 'Generalist' ? 'selected' : '' }}>Generalist</option>
                                </select>
                                @error('type')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!-- specialities -->
                            <div class="mb-6 mr-2 w-full" id="generalDiv" style="display:none;">
                                <label class="block text-sm font-medium text-gray-700" for="role">
                                    Speciality
                                </label>
                                <select name="specialities[]" multiple 
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Speciality">
                                    <option value="Allergist"  {{ in_array('Allergist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Allergist</option>
                                    <option value="Anesthesiologist"  {{ in_array('Anesthesiologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Anesthesiologist</option>
                                    <option value="Cardiologist"  {{ in_array('Cardiologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Cardiologist</option>
                                    <option value="Dermatologist"  {{ in_array('Dermatologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Dermatologist</option>
                                    <option value="Gastroenterologist"  {{ in_array('Gastroenterologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Gastroenterologist</option>
                                    <option value="Hematologist/Oncologist"  {{ in_array('Hematologist/Oncologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Hematologist/Oncologist</option>
                                    <option value="Internal Medicine Physician"  {{ in_array('Internal Medicine Physician', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Internal Medicine Physician</option>
                                    <option value="Nephrologist"  {{ in_array('Nephrologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Nephrologist</option>
                                    <option value="Neurologist"  {{ in_array('Neurologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Neurologist</option>
                                    <option value="Neurosurgeon"  {{ in_array('Neurosurgeon', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Neurosurgeon</option>                               
                                    <option value="Obstetrician"  {{ in_array('Obstetrician', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Obstetrician</option>                                
                                    <option value="Gynecologist"  {{ in_array('Gynecologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Gynecologist</option>
                                    <option value="Nurse-Midwifery"  {{ in_array('Nurse-Midwifery', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Nurse-Midwifery</option>                                
                                    <option value="Occupational Medicine Physician"  {{ in_array('Occupational Medicine Physician', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Occupational Medicine Physician</option>
                                    <option value="Ophthalmologist"  {{ in_array('Ophthalmologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Ophthalmologist</option>
                                    <option value="Oral and Maxillofacial Surgeon"  {{ in_array('Oral and Maxillofacial Surgeon', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Oral and Maxillofacial Surgeon</option>
                                    <option value="Orthopaedic Surgeon"  {{ in_array('Orthopaedic Surgeon', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Orthopaedic Surgeon</option>
                                    <option value="Otolaryngologist"  {{ in_array('Otolaryngologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Otolaryngologist</option>
                                    <option value="Pathologist"  {{ in_array('Pathologist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Pathologist</option>
                                    <option value="Pediatrician"  {{ in_array('Pediatrician', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Pediatrician</option>
                                    <option value="Plastic Surgeon"  {{ in_array('Plastic Surgeon', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Plastic Surgeon</option>
                                    <option value="Podiatrist"  {{ in_array('Podiatrist', explode(',', $doctor->specialities)) ? 'selected' : '' }}>Podiatrist</option>
                                </select>
                                @error('specialities')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        <div class="mb-4 mr-2 w-full">
                            <label class="block text-sm font-medium text-gray-700" for="role">
                            Public Doctor Page
                            </label>
                            <select name="public_page_status" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Public Doctor Page" id="public_page_status" value="{{old('public_page_status')}}">
                                <option value="">Select Public Doctor Page</option>
                                <option value="Active" @if ($doctor->public_page_status == 'Active') selected @endif>Active</option>
                                <option value="Not Active" @if ($doctor->public_page_status == 'Not Active') selected @endif>Not Active</option>
                            </select>
                            @error('public_page_status')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div id="view-public-page-container" class="mb-2 mr-2 w-full mt-5" style="display: none;">
                            <a href="{{ route('doctor.public.page', ['id' => $doctor->id]) }}" target="_blank"
                                class="text-white mr-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                View Public Page
                            </a>
                        </div>

                        
                    </div>

                    

                    <h2>Account Info</h2>
                    <div class="grid md:grid-cols-3  md:gap-6">
                            
                            <!-- Password -->
                        <div class="mb-6 mr-2 w-full">
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

                                <div class="mb-6 mr-2 w-full">
                                
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="typeOfMoney">
                                        Account Status
                                    </label>

                                    <select name="account_status" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Account Status" value="{{old('account_status')}}">

                                            <option value="Active" @if($user->account_status =='Active') selected @endif>Active</option>
                                            <option value="Not Active" @if($user->account_status=='Not Active') selected @endif>Not Active</option>

                                    </select>

                                @error('account_status')
                                <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            
                        </div>




                        <!---->
                        <h2 class="mb-5">Doctor's Info</h2>
                        <div class="grid md:grid-cols-2  md:gap-6">                                
                                <!-- Password -->
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="password">
                                        Doctor profile description
                                    </label>
                                    <textarea name="description"
                                    rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Your description..." > {{old('description',$doctor->description)}}</textarea>

                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                    @enderror

                                </div>
                                <div class="mb-6 mr-2 w-full">                                        
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="typeOfMoney">
                                                Google Map Location :
                                            </label>
                                            <div id="map" style="height: 500px; width: 100%;"></div>
                                            <input type="hidden" id="latitude" name="latitude"  value=" {{old('latitude',$doctor->latitude)}}">
                                            <input type="hidden" id="longitude" name="longitude"  value=" {{old('longitude',$doctor->longitude)}}">
                                </div>  
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="fee">
                                        Doctor's Consultation Fee
                                    </label>
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="number" name="fee"  min="0" step=".01" placeholder="Fee" value="{{old('fee',$doctor->fee)}}">
                                    @error('fee')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    
                                </div>                                
                            </div>
                        <!----->
                    
                    
                        
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
tinymce.init({

        selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'table lists link image', // Add the image plugin
        toolbar: 'undo redo | blocks | bold italic | bullist numlist | alignleft aligncenter alignright alignjustify | code | table | link image', // Add the image button to the toolbar
        default_link_target: '_blank',
        promotion:false,
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '{{ route('upload.image') }}',
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        license_key: 'gpl'
    });

</script>
    <script>
              function handleDropdownChange() {
                const dropdown = document.getElementById('type');
                const generalDiv = document.getElementById('generalDiv');
                
                if (dropdown.value === 'Specialist') {
                    generalDiv.style.display = 'block';
                } else {
                    generalDiv.style.display = 'none';
                }
            }
            
        </script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('public_page_status');
    const viewPageContainer = document.getElementById('view-public-page-container');
    
    function toggleViewPageButton() {
        if (statusSelect.value === 'Active') {
            viewPageContainer.style.display = 'block';
        } else {
            viewPageContainer.style.display = 'none';
        }
    }

    const dropdown = document.getElementById('type');
    const generalDiv = document.getElementById('generalDiv');
    
    if (dropdown.value === 'Specialist') {
        generalDiv.style.display = 'block';
    } else {
        generalDiv.style.display = 'none';
    }

    // Initial check on page load
    toggleViewPageButton();

    // Add event listener to dropdown
    statusSelect.addEventListener('change', toggleViewPageButton);
});
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxz3wUvm-olpBO3L98DXs6Ve_KCE9Alc&libraries=places&callback=initMap" async defer></script>
  <script>
      window.onload = function() {
            initMap();  // Initialize the map when everything is fully loaded
        };
        
        let map;
        let marker;
        
        function initMap() {
        
            // Set Lahore as the default location
            const initialLocation = {
                lat: parseFloat({{ $doctor->latitude ?? -34.397 }}),  // Fallback to Lahore latitude
                lng: parseFloat({{ $doctor->longitude ?? 150.644 }}) // Fallback to Lahore longitude
            };
                    // Lahore coordinates

            // Create a map centered on Lahore
            map = new google.maps.Map(document.getElementById("map"), {
                center: initialLocation,
                zoom: 12,  // Zoom level appropriate for city view
            });

            // Place a draggable marker at Lahore
            placeMarker(initialLocation);

            // Add click event listener to place a marker
            map.addListener("click", (event) => {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            // Remove existing marker if it exists
            if (marker) {
                marker.setMap(null);  // This removes the previous marker from the map
            }

            // Place a new draggable marker at the location
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,  // Make the marker draggable
            });

            // Update hidden input fields with the marker's position
            //document.getElementById("latitude").value = location.lat();
            //document.getElementById("longitude").value = location.lng();

            // Add event listener to update coordinates when marker is dragged
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById("latitude").value = event.latLng.lat();
                document.getElementById("longitude").value = event.latLng.lng();
            });
        }
  </script>
        
</x-app-layout>

