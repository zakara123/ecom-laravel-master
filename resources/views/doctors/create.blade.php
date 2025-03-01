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
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Create Doctor</h1>
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
                    <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="grid md:grid-cols-4  md:gap-6">
                            <!--First Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  First Name
                                </label>

                                <input required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                @error('first_name')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!--Last Name -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  Last Name
                                </label>

                                <input required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="last_name" placeholder="last Name" value="{{old('last_name')}}">
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
                                    type="text" name="nationality" placeholder="Nationality" value="{{old('nationality')}}">
                                @error('nationality')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <!--nid_passport_no -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  NID/Passport No
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="nid_passport_no" placeholder="NID/Passport No" value="{{old('nid_passport_no')}}">
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
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
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
                                        <span class="text-red-600" >*</span>    Email
                                    </label>

                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="email" required name="email" placeholder="Email" value="{{old('email')}}">
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
                                        type="tel" name="phone" placeholder="Phone Number" value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <!-- Mobile Number -->
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="phone">
                                        <span class="text-red-600" >*</span>  Mobile Number
                                    </label>

                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="tel" name="mobile" placeholder="Mobile Number" value="{{old('mobile')}}">
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
                                    type="tel" name="whatsapp" placeholder="WhatsApp" value="{{old('whatsapp')}}">
                                @error('whatsapp')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>  
                            <!-- Address 1 -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  Address 1
                                </label>

                                <input required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address_1" placeholder="Address 1" value="{{old('address_1')}}">
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
                                    type="text" name="address_2" placeholder="Address 2" value="{{old('address_2')}}">
                                @error('address_2')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div> 
                                                            <!-- Village/Town -->
                            <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    <span class="text-red-600" >*</span>  Village/Town
                                </label>

                                <input required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="village_town" placeholder="Village/Town" value="{{old('village_town')}}">
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
                                    <select name="languages[]" multiple require
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Languages" value="{{old('languages')}}">
                                        <option value="English">English</option>
                                        <option value="French">French</option>
                                        <option value="Mauritian Creole">Mauritian Creole</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Telugu">Telugu</option>
                                        <option value="Tamil">Tamil</option>
                                        <option value="Malayalam">Malayalam</option>
                                        <option value="Marathi">Marathi</option>
                                        <option value="Urdu">Urdu</option>
                                        <option value="Mandarin">Mandarin</option>
                                    </select>
                                    @error('languages')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-6 mr-2 w-full">
                                <label class="block text-sm font-medium text-gray-700" for="role">
                                    <span class="text-red-600" >*</span>  Doctor Type
                                </label>
                                <select name="type" required onchange="handleDropdownChange();"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        id="type">
                                    <option value="">Select Type</option>
                                    <option value="Specialist" {{ old('type') == 'Specialist' ? 'selected' : '' }}>Specialist</option>
                                    <option value="Generalist" {{ old('type') == 'Generalist' ? 'selected' : '' }}>Generalist</option>
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
                                    <span class="text-red-600" >*</span>  Speciality
                                </label>
                                <select name="specialities[]" multiple 
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Speciality">
                                    <option value="Allergist">Allergist</option>
                                    <option value="Anesthesiologist">Anesthesiologist</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Dermatologist">Dermatologist</option>
                                    <option value="Gastroenterologist">Gastroenterologist</option>
                                    <option value="Hematologist/Oncologist">Hematologist/Oncologist</option>
                                    <option value="Internal Medicine Physician">Internal Medicine Physician</option>
                                    <option value="Nephrologist">Nephrologist</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Neurosurgeon">Neurosurgeon</option>                               
                                    <option value="Obstetrician">Obstetrician</option>                                
                                    <option value="Gynecologist">Gynecologist</option>
                                    <option value="Nurse-Midwifery">Nurse-Midwifery</option>                                
                                    <option value="Occupational Medicine Physician">Occupational Medicine Physician</option>
                                    <option value="Ophthalmologist">Ophthalmologist</option>
                                    <option value="Oral and Maxillofacial Surgeon">Oral and Maxillofacial Surgeon</option>
                                    <option value="Orthopaedic Surgeon">Orthopaedic Surgeon</option>
                                    <option value="Otolaryngologist">Otolaryngologist</option>
                                    <option value="Pathologist">Pathologist</option>
                                    <option value="Pediatrician">Pediatrician</option>
                                    <option value="Plastic Surgeon">Plastic Surgeon</option>
                                    <option value="Podiatrist">Podiatrist</option>
                                </select>
                                @error('specialities')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            
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
                                    <label class="block text-sm font-medium text-gray-700" for="role">
                                    Public Doctor Page
                                    </label>
                                    <select name="public_page_status" 
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Public Doctor Page" id="public_page_status" value="{{old('public_page_status')}}">
                                        <option value="">Select Public Doctor Page</option>
                                        <option value="Active">Active</option>
                                        <option value="Not Active">Not Active</option>
                                    </select>
                                    @error('public_page_status')
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
                                    placeholder="Your description..." > {{old('description')}}</textarea>

                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                    @enderror

                                </div>
                                <div class="mb-6 mr-2 w-full">                                        
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="typeOfMoney">
                                                Google Map Location :
                                            </label>
                                            <div id="map" style="height: 500px; width: 100%;"></div>
                                            <input type="hidden" name="latitude" id="latitude" value=" {{old('latitude')}}">
                                            <input type="hidden" name="longitude" id="longitude" value=" {{old('longitude')}}">
                                </div> 
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="fee">
                                        Doctor's Consultation Fee
                                    </label>
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="fee"  min="0" step=".01" placeholder="Fee" value="{{old('fee')}}">
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
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxz3wUvm-olpBO3L98DXs6Ve_KCE9Alc&libraries=places&callback=initMap"></script>
  <script>
        window.onload = function() {
        initMap();  // Initialize the map when everything is fully loaded
        };
        let map;
        let marker;

        function initMap() {
        const initialLocation = { lat: -34.397, lng: 150.644 }; // Default location

        // Create a map centered on the default location
        map = new google.maps.Map(document.getElementById("map"), {
            center: initialLocation,
            zoom: 8,
        });

        // Add click event listener to place a marker
        map.addListener("click", (event) => {
            placeMarker(event.latLng);
        });
        }

        function placeMarker(location) {
        // Remove existing marker if it exists
        if (marker) {
            marker.setMap(null);
        }

        // Place a new marker
        marker = new google.maps.Marker({
            position: location,
            map: map,
        });

        // Send latitude and longitude to PHP
        document.getElementById("latitude").value = location.lat();
        document.getElementById("longitude").value = location.lng();
        }
  </script>
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
</x-app-layout>
