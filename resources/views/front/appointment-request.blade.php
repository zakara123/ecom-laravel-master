@php
    $theme = App\Models\Setting::where('key', 'store_theme')->value('value') ?: 'default';
@endphp

@extends('front.'.$theme.'.layouts.app')

@section('pageTitle')
    Appointment Request
@endsection

@section('customStyles')

@endsection

@section('content')
    <div class="container mx-auto mt-4 px-5 mx-auto sm:px-4 md:px-14 lg:px-14 xl:px-14 2xl:px-14 pb-5">
        <div id="step-heading" class="text-center text-xl mb-4">Appointment Request</div>

        <!-- Stepper -->

        <div id="step-heading" class="text-left text-xl mb-4 mt-4" style="font-size: 1rem;">To book an appointment,
            please complete the different steps. Make sure to give correct details so we can organise your
            appointment rapidly. Call xxx xxxx for assistance if required</div>
        <div class="flex items-center justify-between">
            <div class="flex items-center text-blue-600">
                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full">1</div>
            </div>
            <div class="w-full h-1 bg-blue-200 mx-2"></div>
            <div class="flex items-center text-gray-600">
                <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full">2</div>
            </div>
            <div class="w-full h-1 bg-gray-200 mx-2"></div>
            <div class="flex items-center text-gray-600">
                <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full">3</div>
            </div>
            <!--<div class="w-full h-1 bg-gray-200 mx-2"></div>
            <div class="flex items-center text-gray-600">
                <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full">4</div>
            </div>
            <div class="w-full h-1 bg-gray-200 mx-2"></div>
            <div class="flex items-center text-gray-600">
                <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full">5</div>
            </div>-->

        </div>
        <form id="your-form-id" action="{{ route('create-appointment-request') }}" method="POST">
            @csrf
            <!-- Stepper Content -->
            <div class="mt-4">
                <!-- Step 1 -->
                <div id="step-1" class="step" style="padding-top: 20px;">
                    <div class=" col-span-2 sm:col-span-1" style="margin-top:-10px;">
                        <div class="mb-8">
                            <p class="text-xl-p mb-2">Do you need a generalist or specialist?</p>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="type" value="Generalist"
                                       onclick="handleSelection()" required>
                                <span class="ml-2">Generalist</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="type" value="Specialist"
                                       onclick="handleSelection()" required>
                                <span class="ml-2">Specialist</span>
                            </label>

                        </div>
                    </div>
                    <!-- Specialist Fields -->
                    <div id="specialist-fields" class="hidden col-span-2 sm:col-span-1" style="margin-top:-10px;">
                        <div class="mb-8">
                            <p class="text-xl-p mb-2 mt-2">Please select the specialist you need</p>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="specialist_type" onclick="handleSpecialistSelection('Cardiologist')" value="Cardiologist"
                                       required>
                                <span class="ml-2">Cardiologist</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="specialist_type" onclick="handleSpecialistSelection('Gynecologist')" value="Gynecologist"
                                       required>
                                <span class="ml-2">Gynecologist</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="specialist_type" onclick="handleSpecialistSelection('Orthopedic')" value="Orthopedic"
                                       required>
                                <span class="ml-2">Orthopedic</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" onclick="handleSpecialistSelection('Paediatrician')" name="specialist_type"
                                       value="Paediatrician" required>
                                <span class="ml-2">Paediatrician</span>
                            </label>
                        </div>
                    </div>
                    <div id="doctor-selection-fields" class="hidden col-span-2 sm:col-span-1"  style="margin-top:-10px;">
                        <div class="mb-8">
                            <p class="text-xl-p mb-2 mt-2">Do you have a preferred choice of doctor</p>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio"   onclick="handleDoctorSelection(this.value)" name="choice_doctor" value="No"
                                       required>
                                <span class="ml-2">No</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio"  onclick="handleDoctorSelection(this.value)" name="choice_doctor" value="Yes"
                                       required>
                                <span class="ml-2">Yes</span>
                            </label>
                        </div>
                    </div>
                    @foreach($groupedBySpecialities as $speciality => $doctors)
                        <div id="{{ $speciality }}Dropdown" class="specialist-dropdown col-span-3 sm:col-span-1" style="display: none; margin-top: -10px;">
                            <div class="mb-8">
                                <p class="text-xl-p mb-2 mt-2">Doctors</p>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Select
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Doctor Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($doctors as $doctor)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="radio" name="doctor_id" value="{{ $doctor->id }}" id="doctor_{{ $doctor->id }}">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <label for="doctor_{{ $doctor->id }}">
                                                    {{ $doctor->first_name }} {{ $doctor->last_name }}
                                                </label>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($doctor->public_page_status =='Active')
                                                    <a href="{{ route('doctor.public.page', ['id' => $doctor->id]) }}" target="_blank"
                                                       class="px-4 py-2 bg-blue-600 text-white rounded">View Profile</a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach


                </div>

                <!-- Step 2 -->
                <div id="step-2" class="step hidden">
                    <p id="step2-title" class="text-xl-p mb-2">Please enter the patient details</p>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Generalist Fields -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="first_name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="First Name" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="last_name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Last Name" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="date_of_birth"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth
                                <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Date of Birth" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="phone_no"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="phone_no" onkeypress="validateInputNumber(event)"
                                   id="phone_no"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Mobile Number" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="mobile_no"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mobile Number
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="mobile_no" onkeypress="validateInputNumber(event)"
                                   id="mobile_no"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Phone Number" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="email"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Email" required>
                        </div>
                    </div>

                    
                </div>

                <!-- Step 3 -->
                <div id="step-3" class="step hidden">
                   
                    <p class="text-xl-p mb-2">Please select your preferred date and location for the appointment. A
                        Care Connect representative will be in touch with you to confirm or reschedule the
                        appointment depending on available doctors.</p>
                    <div class="grid gap-4 mb-4 grid-cols-3">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="appointment_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment
                                Date <span class="text-red-500">*</span></label>
                            <input type="date" name="appointment_date" id="appointment_date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Appointment Date" required>
                        </div>
                        <!--<div class="col-span-2 sm:col-span-1">
                            <label for="appointment_time"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Appointment
                                Time <span class="text-red-500">*</span></label>
                            <input type="time" name="appointment_time" id="appointment_time"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                   placeholder="Appointment Time" required>
                        </div>-->
                    </div>

                    <p class="text-xl-p mb-2">Mode of Consultation</p>
                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="consultation_mode" value="Remote"
                                   onclick="consultationMode()" required>
                            <span class="ml-2">Remote</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="consultation_mode"
                                   value="In person, On Site" onclick="consultationMode()" required>
                            <span class="ml-2">In person, On Site</span>
                        </label>
                    </div>

                    <div id="remote-fields" class="hidden">
                        <p class="text-xl-p mb-2">Communication Channel</p>
                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="method_of_communication"
                                       value="Phone Call" onclick="communctionCall()" required>
                                <span class="ml-2">Phone Call</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" name="method_of_communication"
                                       value="Video Call" onclick="communctionCall()" required>
                                <span class="ml-2">Video Call</span>
                            </label>
                        </div>

                        <div id="phone-call-fields" class="hidden">
                            <div class="mb-6">
                                <label for="phone_call_no"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone/Mobile
                                    Number <span class="text-red-500">*</span></label>
                                <input type="text" name="phone_call_no_cell" id="phone_call_no"
                                       onkeypress="validateInputNumber(event)"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                       placeholder="Phone/Mobile Number" required>
                            </div>
                        </div>
                        <div id="video-call-fields" class="hidden">
                            <div class="mb-6">
                                <label for="phone_call_no"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhatsApp
                                    Number <span class="text-red-500">*</span></label>
                                <input type="text" name="phone_call_no_whats"
                                       onkeypress="validateInputNumber(event)" id="phone_call_no"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                       placeholder="WhatsApp Number" required>
                            </div>
                        </div>
                    </div>
                    <div id="on-site-fields" class="hidden">
                        <p class="text-xl-mb-2">Select where consultation will take place</p>
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="mb-6">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="consultation_place"
                                           value="At home" onclick="consultationPlaceAddress()" required>
                                    <span class="ml-2">At home</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" class="form-radio" name="consultation_place"
                                           value="At work" onclick="consultationPlaceAddress()" required>
                                    <span class="ml-2">At work</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" class="form-radio" name="consultation_place"
                                           value="Other location" onclick="consultationPlaceAddress()" required>
                                    <span class="ml-2">Other location</span>
                                </label>
                            </div>
                            <div id="address-fields" class="hidden">
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="consultation_place_address"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span
                                            id="consultation_place_address_label">Residential Address</span> <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="consultation_place_address"
                                           id="consultation_place_address"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                           required>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="village_town"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Village/
                                        Town <span class="text-red-500">*</span></label>
                                    <input type="text" name="village_town" id="village_town"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                           required>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <!--<div id="step-4" class="step hidden">
                    

                </div>

               
                <div id="step-5" class="step hidden">
                    
                </div>-->

                <!-- Navigation Buttons -->
                <div class="mt-4 flex justify-between">
                    <button id="prevBtn" class="px-4 py-2 bg-gray-300 rounded"
                            onclick="nextPrev(-1)">Previous</button>
                    <button id="nextBtn" class="px-4 py-2 bg-blue-600 text-white rounded"
                            onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('customScript')
    <script>
        let currentStep = 1;
        showStep(currentStep);

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((s, index) => {
                s.style.display = (index + 1 === step) ? 'block' : 'none';
            });
            updateStepHeading(step);
            updateStepper(step);
        }

        function updateStepHeading(step) {
            const heading = document.getElementById('step-heading');
            switch (step) {
                case 1:
                    heading.innerText = 'Book an appointment';
                    break;
                case 2:
                    heading.innerText = 'Patient Details';
                    break;
                case 3:
                    heading.innerText = 'Appointment Details';
                    break;
               /* case 4:
                    heading.innerText = 'Consultation Mode';
                    break;
                case 5:
                    heading.innerText = 'Communication Channel';
                    break;*/
                case 6:
                    heading.innerText = 'Confirmation';
                    break;
                default:
                    heading.innerText = 'Book an appointment';
            }
        }

        function updateStepper(step) {
            const stepIndicators = document.querySelectorAll('.flex.items-center .w-10.h-10');
            stepIndicators.forEach((indicator, index) => {
                if (index + 1 < step) {
                    indicator.classList.add('bg-blue-600', 'text-black');
                    indicator.classList.remove('bg-gray-100', 'text-blue-600', 'text-gray-600');
                } else if (index + 1 === step) {
                    indicator.classList.add('bg-blue-100', 'text-blue-600', 'text-white');
                    indicator.classList.remove('bg-blue-600', 'bg-gray-100', 'text-gray-600');
                } else {
                    indicator.classList.add('bg-gray-100', 'text-gray-600');
                    indicator.classList.remove('bg-blue-100', 'text-blue-600', 'text-red');
                }
            });

            const stepConnectors = document.querySelectorAll('.w-full.h-1');
            stepConnectors.forEach((connector, index) => {
                if (index + 1 < step) {
                    connector.classList.add('bg-blue-600');
                    connector.classList.remove('bg-gray-200');
                } else {
                    connector.classList.add('bg-gray-200');
                    connector.classList.remove('bg-blue-600');
                }
            });
        }

        function nextPrev(n) {
            const steps = document.querySelectorAll('.step');
            if (n === 1 && !validateForm()) return false;

            currentStep += n;
            if (currentStep > steps.length) {
                document.getElementById('your-form-id').submit();
                currentStep = steps.length;
                return false; // Prevent further execution
            } else if (currentStep < 1) {
                currentStep = 1;
                return false; // Prevent further execution
            }

            if (currentStep === steps.length) {
                document.getElementById('nextBtn').innerText = 'Submit';
            } else {
                document.getElementById('nextBtn').innerText = 'Next';
            }

            showStep(currentStep);
            toggleButtons();
        }

        function validateForm() {
            const fields = document.querySelectorAll(`#step-${currentStep} [required]`);
            let valid = true;
            fields.forEach(field => {
                const isVisible = field.offsetParent !== null; // Check if the field is visible
                const isHidden = field.classList.contains(
                    'hidden'); // Check if the field is explicitly hidden by a class
                if (isVisible && !isHidden) { // Only validate visible and non-hidden fields
                    if (field.type === 'radio') {
                        const radioGroup = document.querySelector(`input[name="${field.name}"]:checked`);
                        if (!radioGroup) {
                            field.parentElement.classList.add('border-red-500');
                            valid = false;
                        } else {
                            field.parentElement.classList.remove('border-red-500');
                        }
                    } else {
                        if (field.value.trim() === '') {
                            field.classList.add('border-red-500');
                            valid = false;
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    }
                }
            });
            return valid;
        }

        function toggleButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            if (currentStep === 1) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'inline';
            }
            if (currentStep === document.querySelectorAll('.step').length) {
                nextBtn.innerHTML = 'Submit';
            } else {
                nextBtn.innerHTML = 'Next';
            }
        }

        function handleSelection() {
            $('#alert-success').hide();

            const type = document.querySelector('input[name="type"]:checked').value;
            const specialistFields = document.getElementById('specialist-fields');
            const specialistDetailFields = document.getElementById('specialist-detail-fields');
            const doctorDetailFields = document.getElementById('doctor-selection-fields');

            if (type === 'Specialist') {
                resetChoiceDoctor();
                specialistFields.classList.remove('hidden');
                doctorDetailFields.classList.add('hidden');

                //specialistDetailFields.classList.add('hidden');
            } else {
                resetChoiceDoctor();
                const dropdowns = document.querySelectorAll('.specialist-dropdown');
                dropdowns.forEach(dropdown => dropdown.style.display = 'none');
                doctorDetailFields.classList.remove('hidden');
                specialistFields.classList.add('hidden');
                //specialistDetailFields.classList.remove('hidden');
            }
        }
        function resetChoiceDoctor() {
            const radios = document.querySelectorAll('input[name="choice_doctor"]');
            radios.forEach(radio => radio.checked = false);

            const radios1 = document.querySelectorAll('input[name="specialist_type"]');
            radios1.forEach(radio => radio.checked = false);


            const selectedRadio = document.querySelector('input[name="specialist_type"]:checked');
            const selectedTypeRadio = document.querySelector('input[name="type"]:checked');
            const dropdowns = document.querySelectorAll('.specialist-dropdown');
            dropdowns.forEach(dropdown => dropdown.style.display = 'none');

            const selectedDropdown = document.getElementById(`Dropdown`);
            if (selectedDropdown) {
                selectedDropdown.style.display = 'none';
            }


        }

        function handleDoctorSelection(values){
            $('#alert-success').hide();

            if(values == 'Yes'){
                const selectedRadio = document.querySelector('input[name="specialist_type"]:checked');
                const selectedTypeRadio = document.querySelector('input[name="type"]:checked');
                if(selectedRadio){
                    const selectedDropdown = document.getElementById(`${selectedRadio.value}Dropdown`);
                    if (selectedDropdown) {
                        selectedDropdown.style.display = 'block';
                    }
                }else if(selectedTypeRadio && selectedTypeRadio.value == 'Generalist'){
                    const selectedDropdown = document.getElementById(`Dropdown`);
                    if (selectedDropdown) {
                        selectedDropdown.style.display = 'block';
                    }
                }



            }else{
                const dropdowns = document.querySelectorAll('.specialist-dropdown');
                dropdowns.forEach(dropdown => dropdown.style.display = 'none');
            }


            //const doctorDetailFields = document.getElementById('doctor-selection-fields').value();

        }

        function handleSpecialistSelection(selectedType) {
            // Hide all dropdowns
            const doctorDetailFields = document.getElementById('doctor-selection-fields');
            const selectedRadio = document.querySelector('input[name="choice_doctor"]:checked');
            const dropdowns = document.querySelectorAll('.specialist-dropdown');
            dropdowns.forEach(dropdown => dropdown.style.display = 'none');
            doctorDetailFields.classList.remove('hidden');

            if (selectedRadio && selectedRadio.value == 'Yes') {
                const selectedDropdown = document.getElementById(`${selectedType}Dropdown`);
                if (selectedDropdown) {
                    selectedDropdown.style.display = 'block';
                }
                doctorDetailFields.classList.remove('hidden');
            }else{

            }
            // Show the dropdown associated with the selected specialist type

        }

        /*function handleSpecialListType() {
          const specialistDetailFields = document.getElementById('specialist-detail-fields');
          specialistDetailFields.classList.remove('hidden');
        }*/

        function consultationMode() {
            const mode = document.querySelector('input[name="consultation_mode"]:checked').value;
            const remoteFields = document.getElementById('remote-fields');
            const onSiteFields = document.getElementById('on-site-fields');

            if (mode === 'Remote') {
                remoteFields.classList.remove('hidden');
                onSiteFields.classList.add('hidden');
            } else if (mode === 'In person, On Site') {
                remoteFields.classList.add('hidden');
                onSiteFields.classList.remove('hidden');
            } else {
                remoteFields.classList.add('hidden');
                onSiteFields.classList.add('hidden');
            }
        }

        function communctionCall() {
            const mode = document.querySelector('input[name="method_of_communication"]:checked').value;
            const phoneCallFields = document.getElementById('phone-call-fields');
            const videoCallFields = document.getElementById('video-call-fields');

            if (mode === 'Phone Call') {
                phoneCallFields.classList.remove('hidden');
                videoCallFields.classList.add('hidden');
            } else if (mode === 'Video Call') {
                phoneCallFields.classList.add('hidden');
                videoCallFields.classList.remove('hidden');
            } else {
                phoneCallFields.classList.add('hidden');
                videoCallFields.classList.add('hidden');
            }
        }

        function consultationPlaceAddress() {
            const mode = document.querySelector('input[name="consultation_place"]:checked').value;
            const residentialFields = document.getElementById('address-fields');
            const addressLabel = $('#consultation_place_address_label');

            if (mode === 'At home' || mode === 'At work' || mode === 'Other location') {
                residentialFields.classList.remove('hidden');
                if (mode == 'At home') {
                    addressLabel.html("Residential Address");
                } else if (mode === 'At work') {

                    addressLabel.html("Work Address");
                } else {
                    addressLabel.html("Other Location Address");
                }
            } else {
                residentialFields.classList.add('hidden');
            }
        }

        function validateInputNumber(event) {
            const key = String.fromCharCode(event.which);
            const validChars = '0123456789+-';

            if (!validChars.includes(key)) {
                event.preventDefault();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleButtons();
        });

        // Get the current date
        var today = new Date().toISOString().split('T')[0];
        // Set the min attribute to today
        document.getElementById('appointment_date').setAttribute('min', today);
    </script>
@endsection
