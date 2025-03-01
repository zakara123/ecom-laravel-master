<x-app-layout>
    <style>
        .list-group {
            padding-left: 0;
            margin-bottom: 20px;
        }
        .list-group-item:first-child {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }
            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            .fa.pull-right {
                    margin-left: .3em;
                }

                .text-aqua {
                    color: #00c0ef !important;
                }
                .text-aqua {
                    color: #00c0ef !important;
                }
                .pull-right {
                    float: right;
                }
                .fa {
                    display: inline-block;
                    font: normal normal normal 14px / 1 FontAwesome;
                    font-size: inherit;
                    text-rendering: auto;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                }
                .pull-right {
                    float: right !important;
                }
                .fa-arrow-circle-right:before {
                    content: "\f0a9";
                }
        </style>
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
                            <a href="{{ url('patients') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Patients</a>
                        </div>
                    </li>

                </ol>
            </nav>
            <div class="block items-center">
                <div class="w-1/2">
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Medical Record of {{$customer->firstname}} {{$customer->lastname}}, UPI: {{$customer->upi}}</h1>
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

    <div class="w-full flex gap-4">
            @include('patient.patient_left_nav', ['customer_id' => $customer->id])
        <div class="w-4/5 bg-gray-200">

            <div class="w-full overflow-hidden bg-white">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 p-5">Edit Allergies</h1>
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('edit-save-patient-allergies', [$customer->id,$record->id]) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid md:grid-cols-2  md:gap-6">
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                        Allergen
                                    </label>
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="allergen" required placeholder="Allergen" value="{{old('allergen',$record->allergen)}}">
                                            @error('allergen')
                                            <span class="text-red-600 text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                </div>
                                
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                        Reaction
                                    </label>
                                    <input
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        type="text" name="reaction" required placeholder="Reaction" value="{{old('reaction',$record->reaction)}}">
                                            @error('reaction')
                                            <span class="text-red-600 text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                </div>
                            </div>

                            <div class="grid md:grid-cols-1  md:gap-6">
                                
                                <div class="mb-12 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                        Severity
                                    </label>
                                    <textarea required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        name="severity" placeholder="Severity" value="{{old('severity')}}">{{old('severity',$record->severity)}}</textarea>
                                            @error('severity')
                                            <span class="text-red-600 text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                </div>
                            </div>


                            <div class="grid md:grid-cols-1  md:gap-6">
                                
                                <div class="mb-12 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                            Note
                                    </label>
                                    <textarea  required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        name="note" placeholder="Note" value="{{old('note')}}">{{old('note',$record->note)}}</textarea>
                                            @error('note')
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
    <script src="https://cdn.tiny.cloud/1/u4g64ic0cse8sfc9rj7epn3aswt4n406ej27oacxf3q2qu0u/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- include jQuery library -->
</x-app-layout>
