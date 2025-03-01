<x-app-layout>
    <style>
        th, td {
            word-wrap: break-word; /* Allows breaking of words */
            word-break: break-all; /* Breaks long words at any character to fit */
        }
    </style>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('dashboard') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('appointment-lists') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Appointments</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('detail-appointment',$id) }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Appointment #{{$appointmentData->id}}</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Vitals</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if(Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    <span class="font-medium">Success: </span> {{ Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error: </span> {{ Session::get('error_message')}}
                </div>
            @endif

        </div>
        <x-consultation-header :appointmentData="$appointmentData" />
    </div>
    <div class="md:flex bg-white rounded shadow">
        <x-appointment-side-menu active-menu="vitals" :appointmentData="$appointmentData" />
        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Vitals</h3>

            <form action="{{route('vitals.store',$appointmentData->id)}}" method="POST" class="space-y-6">
                @csrf
                <!-- Height, Weight, Abd. Circumference, BMI -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                        <input type="text" name="height" id="height" value="{{ old('height', $vital->height ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Height">
                        @error('height')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input type="text" name="weight" id="weight" value="{{ old('weight', $vital->weight ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Weight">
                        @error('weight')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="circumference" class="block text-sm font-medium text-gray-700">Abd. Circumference (cm)</label>
                        <input type="text" name="circumference" id="circumference" value="{{ old('circumference', $vital->circumference ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Circumference">
                        @error('circumference')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="bmi" class="block text-sm font-medium text-gray-700">BMI</label>
                        <input type="text" name="bmi" id="bmi" value="{{ old('bmi', $vital->bmi ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly placeholder="BMI">
                        @error('bmi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pulse, Systolic BP, Diastolic BP, Mean BP -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="pulse" class="block text-sm font-medium text-gray-700">Pulse (bpm) <span class="text-red-600">*</span></label>
                        <input type="text" name="pulse" id="pulse" value="{{ old('pulse', $vital->pulse ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Pulse in bpm">
                        @error('pulse')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="sys_blood_pressure" class="block text-sm font-medium text-gray-700">Systolic Blood Pressure (mmHg) <span class="text-red-600">*</span></label>
                        <input type="text" name="sys_blood_pressure" id="sys_blood_pressure" value="{{ old('sys_blood_pressure', $vital->sys_blood_pressure ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Systolic Blood Pressure">
                        @error('sys_blood_pressure')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="dia_blood_pressure" class="block text-sm font-medium text-gray-700">Diastolic Blood Pressure (mmHg) <span class="text-red-600">*</span></label>
                        <input type="text" name="dia_blood_pressure" id="dia_blood_pressure" value="{{ old('dia_blood_pressure', $vital->dia_blood_pressure ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Diastolic Blood Pressure">
                        @error('dia_blood_pressure')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="mean_blood_pressure" class="block text-sm font-medium text-gray-700">Mean Blood Pressure (mmHg)</label>
                        <input type="text" name="mean_blood_pressure" id="mean_blood_pressure" value="{{ old('mean_blood_pressure', $vital->mean_blood_pressure ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Mean Blood Pressure">
                        @error('mean_blood_pressure')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Blood Sugar, Comments -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="blood_sugar" class="block text-sm font-medium text-gray-700">Blood Sugar (mmol/L) <span class="text-red-600">*</span></label>
                        <input type="text" name="blood_sugar" id="blood_sugar" value="{{ old('blood_sugar', $vital->blood_sugar ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Blood Sugar">
                        @error('blood_sugar')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="sugar_comments" class="block text-sm font-medium text-gray-700">Blood Sugar Comments</label>
                        <textarea name="sugar_comments" id="sugar_comments" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" placeholder="Comments">{{ old('sugar_comments', $vital->sugar_comments ?? '') }}</textarea>
                        @error('sugar_comments')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Respiratory Rate, SpO2, Comments -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="respiratory_rate" class="block text-sm font-medium text-gray-700">Respiratory Rate (per min) <span class="text-red-600">*</span></label>
                        <input type="text" name="respiratory_rate" id="respiratory_rate" value="{{ old('respiratory_rate', $vital->respiratory_rate ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="Respiratory Rate">
                        @error('respiratory_rate')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="spo2" class="block text-sm font-medium text-gray-700">SpO2 (%) <span class="text-red-600">*</span></label>
                        <input type="text" name="spo2" id="spo2" value="{{ old('spo2', $vital->spo2 ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onkeyup="numeric_validation(this.id)" onkeypress="numeric_validation(this.id)" placeholder="SpO2">
                        @error('spo2')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="spo2_comments" class="block text-sm font-medium text-gray-700">SpO2 Comments</label>
                        <textarea name="spo2_comments" id="spo2_comments" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" placeholder="Comments">{{ old('spo2_comments', $vital->spo2_comments ?? '') }}</textarea>
                        @error('spo2_comments')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Temperature, Pain Score, Comments -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-700">Temperature (Celsius) <span class="text-red-600">*</span></label>
                        <input type="text" name="temperature" id="temperature" value="{{ old('temperature', $vital->temperature ?? '') }}" class="float-only mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"  placeholder="Temperature">
                        @error('temperature')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pain_score" class="block text-sm font-medium text-gray-700">Pain Score <span class="text-red-600">*</span></label>
                        <input type="text" name="pain_score" id="pain_score" value="{{ old('pain_score', $vital->pain_score ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 float-only"  placeholder="Pain Score">
                        @error('pain_score')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pain_comments" class="block text-sm font-medium text-gray-700">Pain Score Comments</label>
                        <textarea name="pain_comments" id="pain_comments" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" placeholder="Comments">{{ old('pain_comments', $vital->pain_comments ?? '') }}</textarea>
                        @error('pain_comments')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('float-only')) {
                const regex = /^\d*\.?\d*$/;
                if (!regex.test(event.target.value)) {
                    event.target.value = event.target.value.slice(0, -1);
                }
            }
        })
        const calculateBMI=()=>{
            const heightInput = $('#height').val();
            const weightInput = $('#weight').val();

            const height = parseFloat(heightInput) / 100;
            const weight = parseFloat(weightInput);

            if (!isNaN(height) && !isNaN(weight) && height > 0) {
                const bmi = (weight / (height * height)).toFixed(2);
                $('#bmi').val(bmi);
            } else {
                $('#bmi').val('');
            }
        }
        $(document).on('input', '#height, #weight', function() {
            calculateBMI();
        });
    </script>
</x-app-layout>

