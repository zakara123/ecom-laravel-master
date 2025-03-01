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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">MedVigilance</span>
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

            @foreach ($errors->all() as $error)
                <span class="text-red-600 text-sm">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error: </span> {{ $error }}
                </div>
            </span>
            @endforeach

        </div>
        <x-consultation-header :appointmentData="$appointmentData" />
    </div>
    <div class="md:flex bg-white rounded shadow">
        <x-appointment-side-menu active-menu="medvigilance" :appointmentData="$appointmentData" />
        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">MedVigilance</h3>

            <form action="{{ route('med-vigilance.store', $appointmentData->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="date_investigations" class="block text-sm font-medium text-gray-700">Investigations</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="date_investigations" id="date_investigations" class="form-input block w-full sm:text-sm border-gray-300 rounded-md datepicker" placeholder="Select Date" value="{{ old('date_investigations', $medvigilance->date_investigations ?? '06/10/2024') }}">
                            </div>
                        </div>
                        <div>
                            <label for="investigations" class="block text-sm font-medium text-gray-700">Comments</label>
                            <textarea name="investigations" id="investigations" rows="5" class="form-textarea block w-full mt-1 sm:text-sm border-gray-300 rounded-md">{{ old('investigations', $medvigilance->investigations ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="date_radiology" class="block text-sm font-medium text-gray-700">Radiology</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="date_radiology" id="date_radiology" class="form-input block w-full sm:text-sm border-gray-300 rounded-md datepicker" placeholder="Select Date" value="{{ old('date_radiology', $medvigilance->date_radiology ?? '06/10/2024') }}">
                            </div>
                        </div>
                        <div>
                            <label for="radiology" class="block text-sm font-medium text-gray-700">Comments</label>
                            <textarea name="radiology" id="radiology" rows="5" class="form-textarea block w-full mt-1 sm:text-sm border-gray-300 rounded-md">{{ old('radiology', $medvigilance->radiology ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="date_equipment" class="block text-sm font-medium text-gray-700">Equipment</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="date_equipment" id="date_equipment" class="form-input block w-full sm:text-sm border-gray-300 rounded-md datepicker" placeholder="Select Date" value="{{ old('date_equipment', $medvigilance->date_equipment ?? '06/10/2024') }}">
                            </div>
                        </div>
                        <div>
                            <label for="equipment" class="block text-sm font-medium text-gray-700">Comments</label>
                            <textarea name="equipment" id="equipment" rows="5" class="form-textarea block w-full mt-1 sm:text-sm border-gray-300 rounded-md">{{ old('equipment', $medvigilance->equipment ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="date_medvigilance" class="block text-sm font-medium text-gray-700">MedVigilance</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="date" name="date_medvigilance" id="date_medvigilance" class="form-input block w-full sm:text-sm border-gray-300 rounded-md datepicker" placeholder="Select Date" value="{{ old('date_medvigilance', $medvigilance->date_medvigilance ?? '06/10/2024') }}">
                            </div>
                        </div>
                        <div>
                            <label for="medvigilance" class="block text-sm font-medium text-gray-700">Comments</label>
                            <textarea name="medvigilance" id="medvigilance" rows="5" class="form-textarea block w-full mt-1 sm:text-sm border-gray-300 rounded-md">{{ old('medvigilance', $medvigilance->medvigilance ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center mt-2.5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>





    <script type="text/javascript">


    </script>
</x-app-layout>

