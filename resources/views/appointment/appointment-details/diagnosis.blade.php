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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Diagnosis</span>
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
        <x-appointment-side-menu active-menu="diagnosis" :appointmentData="$appointmentData" />
        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 rounded-lg w-full">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Diagnosis</h3>

            <!-- Form Starts Here -->
            @php
                $provisional_diagnosis = json_decode(@$diagnosisData->provisional_diagnosis ?? '[]', true);
            @endphp
            <form action="{{ route('diagnosis.store', $appointmentData->id) }}" method="post">
                @csrf
                <div class="space-y-6">

                    <!-- Provisional Diagnosis Section -->
                    <div class="mb-4">
                        <label for="p_diagnosis" class="block text-sm font-medium text-gray-700">Provisional Diagnosis <span class="text-red-600">*</span></label>

                        @if(!empty($provisional_diagnosis))
                            @foreach($provisional_diagnosis as $index => $provisional)
                                <div class="mb-1 provisional-row">
                                    <input type="text" name="p_diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Provisional Diagnosis {{ $index + 1 }}" value="{{ old('p_diagnosis.'.$index, $provisional) }}">
                                </div>
                            @endforeach
                        @else
                            <div class="mb-1 provisional-row">
                                <input type="text" name="p_diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Provisional Diagnosis 1" value="{{ old('p_diagnosis.0') }}">
                            </div>
                        @endif
                        @error('p_diagnosis.0')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div id="append_provisional"></div>
                        <button type="button" id="add_provisional" class="float-right text-orange-500 hover:text-orange-700 mt-2"><i class="fas fa-plus"></i> Add More</button>
                    </div>

                    <!-- Diagnosis Section (Optional) -->
                    <div class="mb-4">
                        <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>

                        @if(!empty(old('diagnosis',json_decode(@$diagnosisData->diagnosis))))
                            @foreach(old('diagnosis',json_decode(@$diagnosisData->diagnosis)) as $index => $diag)
                                <div class="mb-1 diagnosis-row">
                                    <input type="text" name="diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Diagnosis {{ $index + 1 }}" value="{{ old('diagnosis.'.$index, $diag) }}">
                                </div>
                            @endforeach
                        @else
                            <div class="mb-1 diagnosis-row">
                                <input type="text" name="diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Diagnosis 1" value="{{ old('diagnosis.0') }}">
                            </div>
                        @endif

                        <div id="append_diagnosis"></div>
                        <button type="button" id="add_diagnosis" class="float-right text-orange-500 hover:text-orange-700 mt-2"><i class="fas fa-plus"></i> Add More</button>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center mt-2.5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        // <button type="button" class="remove-provisional mt-2 text-red-500 hover:text-red-700"><i class="fas fa-minus"></i></button>
        // <button type="button" class="remove-diagnosis mt-2 text-red-500 hover:text-red-700"><i class="fas minus"></i></button>


        $(document).ready(function() {
            // Add more Provisional Diagnosis fields
            $('#add_provisional').click(function() {
                // Get the current number of provisional diagnosis inputs
                let provisionalCount = $('#append_provisional .provisional-row').length + 2;
                $('#append_provisional').append(`
        <div class="mb-1 provisional-row">
            <input type="text" name="p_diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Provisional Diagnosis ${provisionalCount}">
        </div>
    `);
            });

            $('#add_diagnosis').click(function() {
                let diagnosisCount = $('#append_diagnosis .diagnosis-row').length + 2;

                $('#append_diagnosis').append(`
        <div class="mb-1 diagnosis-row">
            <input type="text" name="diagnosis[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Diagnosis ${diagnosisCount}">
        </div>
    `);
            });


            // Remove Provisional Diagnosis field
            $(document).on('click', '.remove-provisional', function() {
                $(this).closest('.provisional-row').remove();
            });

            // Remove Diagnosis field
            $(document).on('click', '.remove-diagnosis', function() {
                $(this).closest('.diagnosis-row').remove();
            });
        });


    </script>
</x-app-layout>

