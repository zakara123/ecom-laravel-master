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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Presenting Complaints</span>
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

{{--            @foreach ($errors->all() as $error)--}}
{{--                <span class="text-red-600 text-sm">--}}
{{--                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">--}}
{{--                    <span class="font-medium">Error: </span> {{ $error }}--}}
{{--                </div>--}}
{{--            </span>--}}
{{--            @endforeach--}}

        </div>
        <x-consultation-header :appointmentData="$appointmentData" />
    </div>
    <div class="md:flex bg-white rounded shadow">
        <x-appointment-side-menu active-menu="presenting-complaints" :appointmentData="$appointmentData" />
        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Presenting Complaints</h3>

            <!-- Form Start -->
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="compliant_text" class="block text-sm font-medium text-gray-700">Presenting Complaints
                        <span class="text-red-600">*</span>
                    </label>
                    <textarea name="compliant_text" id="compliant_text" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter presenting complaints...">{{ old('compliant_text', $presentingComplaints->compliant_text ?? '') }}</textarea>
                    @error('compliant_text')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </form>
            <!-- Form End -->
        </div>
    </div>





    <script type="text/javascript">


    </script>
</x-app-layout>

