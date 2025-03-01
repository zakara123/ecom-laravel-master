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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Physical Examination</span>
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
        <x-appointment-side-menu active-menu="physical-examination" :appointmentData="$appointmentData" />

        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Physical Examination</h3>

            <!-- Form starts here -->
            <form action="{{route('physical-examination.store',$appointmentData->id)}}" method="POST">
                @csrf <!-- Add CSRF token for security -->

                <!-- Checkbox Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">P</span>
                            <input type="checkbox" name="p_check" value="1"   id="p_check" class="form-checkbox h-5 w-5 text-blue-600" {{ old('p_check',@$physicalExamination->p_check==1 ?'checked':'') }}>
                        </label>
                        @error('p_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">I</span>
                            <input type="checkbox" name="i_check" id="i_check" value="1"  class="form-checkbox h-5 w-5 text-blue-600" {{ old('i_check',@$physicalExamination->i_check ==1? 'checked' : '') }}>
                        </label>
                        @error('i_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">C</span>
                            <input type="checkbox" name="c_check" id="c_check" value="1"  class="form-checkbox h-5 w-5 text-blue-600" {{ old('c_check',@$physicalExamination->c_check ==1? 'checked' : '') }}>
                        </label>
                        @error('c_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">K</span>
                            <input type="checkbox" name="k_check" id="k_check" value="1"  class="form-checkbox h-5 w-5 text-blue-600" {{ old('k_check',@$physicalExamination->k_check==1?'checked' : '') }}>
                        </label>
                        @error('k_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">L</span>
                            <input type="checkbox" name="l_check" id="l_check" value="1"  class="form-checkbox h-5 w-5 text-blue-600" {{ old('l_check',@$physicalExamination->l_check ==1? 'checked' : '') }}>
                        </label>
                        @error('l_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <span class="mr-2">E</span>
                            <input type="checkbox" name="e_check" id="e_check"  value="1"  class="form-checkbox h-5 w-5 text-blue-600" {{ old('e_check',@$physicalExamination->e_check==1?'checked' : '') }}>
                        </label>
                        @error('e_check')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Text Area Sections -->
                <div class="mt-4">
                    <label for="e_comments" class="block text-sm font-medium text-gray-700">Pickle Comments <span class="text-red-600">*</span></label>
                    <textarea name="e_comments" id="e_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('e_comments',$physicalExamination->e_comments??'') }}</textarea>
                    @error('e_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="cvs_comments" class="block text-sm font-medium text-gray-700">CVS</label>
                    <textarea name="cvs_comments" id="cvs_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('cvs_comments',$physicalExamination->cvs_comments??'') }}</textarea>
                    @error('cvs_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="rs_comments" class="block text-sm font-medium text-gray-700">RS</label>
                    <textarea name="rs_comments" id="rs_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('rs_comments',$physicalExamination->rs_comments??'') }}</textarea>
                    @error('rs_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="cns_comments" class="block text-sm font-medium text-gray-700">CNS</label>
                    <textarea name="cns_comments" id="cns_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('cns_comments',$physicalExamination->cns_comments??'') }}</textarea>
                    @error('cns_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="abdomen_comments" class="block text-sm font-medium text-gray-700">Abdomen</label>
                    <textarea name="abdomen_comments" id="abdomen_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('abdomen_comments',$physicalExamination->abdomen_comments??'') }}</textarea>
                    @error('abdomen_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="skin_comments" class="block text-sm font-medium text-gray-700">Skin</label>
                    <textarea name="skin_comments" id="skin_comments" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('skin_comments',$physicalExamination->skin_comments??'') }}</textarea>
                    @error('skin_comments')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="genitourinary" class="block text-sm font-medium text-gray-700">Genitourinary</label>
                    <textarea name="genitourinary" id="genitourinary" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('genitourinary',$physicalExamination->genitourinary??'') }}</textarea>
                    @error('genitourinary')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
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

