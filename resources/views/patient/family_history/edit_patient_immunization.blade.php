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
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 p-5">Edit Family History</h1>
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form method="POST" action="{{ route('edit-save-patient-family-history', [$customer->id,$record->id]) }}"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                        <div class="grid md:grid-cols-2  md:gap-6">
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                        Prescription Glasses
                                    </label>
                                    <select name="relation" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-invalid="false">
                                    
                                    <option value="Paternal Grand Father">Paternal Grand Father</option>
                                    <option value="Paternal Grand Mother">Paternal Grand Mother</option>
                                    <option value="Paternal Uncle">Paternal Uncle</option>
                                    <option value="Paternal Aunty">Paternal Aunty</option>
                                    <option value="Paternal Cousin Sister">Paternal Cousin Sister</option>
                                    <option value="Paternal Cousin Brother">Paternal Cousin Brother</option>
                                    <option value="Maternal Grand Father">Maternal Grand Father</option>
                                    <option value="Maternal Grand Mother">Maternal Grand Mother</option>
                                    <option value="Maternal Uncle">Maternal Uncle</option>
                                    <option value="Maternal Aunty">Maternal Aunty</option>
                                    <option value="Maternal Cousin Sister">Maternal Cousin Sister</option>
                                    <option value="Maternal Cousin Brother">Maternal Cousin Brother</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Brother">Brother</option>
                                    </select>
                                            @error('relation')
                                            <span class="text-red-600 text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                </div>
                                <div class="mb-6 mr-2 w-full">
                                    <label class="block text-sm font-medium text-gray-700" for="name">
                                        Hearing Aids
                                    </label>
                                    <select name="condition" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" aria-invalid="false">
                                    <option value="Familial Hypercholesterolemia">Familial Hypercholesterolemia</option>
                                    <option value="Alpha-1 Antitrypsin Deficiency">Alpha-1 Antitrypsin Deficiency</option>
                                    <option value="Antiphospholipid Syndrome">Antiphospholipid Syndrome</option>
                                    <option value="Asthma">Asthma</option>
                                    <option value="Autism">Autism</option>
                                    <option value="Autosomal Dominant Polycystic Kidney Disease">Autosomal Dominant Polycystic Kidney Disease</option>
                                    <option value="Cancer -  Kidney">Cancer -  Kidney</option>
                                    <option value="Cancer - Blood">Cancer - Blood</option>
                                    <option value="Cancer - Brain">Cancer - Brain</option>
                                    <option value="Cancer - Breast">Cancer - Breast</option>
                                    <option value="Cancer - Colon">Cancer - Colon</option>
                                    <option value="Diabetes Type 1">Diabetes Type 1</option>
                                    <option value="Diabetes Type 2">Diabetes Type 2</option>
                                    <option value="Down Syndrome">Down Syndrome</option>
                                    <option value="Duane Syndrome">Duane Syndrome</option>
                                    <option value="Factor V Leiden Thrombophilia">Factor V Leiden Thrombophilia</option>
                                    <option value="Cancer - Ovary">Cancer - Ovary</option>
                                    <option value="Cancer - Prostate">Cancer - Prostate</option>
                                    <option value="Cancer - Skin">Cancer - Skin</option>
                                    <option value="Cancer - Stomach">Cancer - Stomach</option>
                                    <option value="Cancer - Uterus">Cancer - Uterus</option>
                                    <option value="Charcot-Marie-Tooth">Charcot-Marie-Tooth</option>
                                    <option value="Chronic Kidney Disease">Chronic Kidney Disease</option>
                                    <option value="Cridu chat">Cridu chat</option>
                                    <option value="Crohns Disease">Crohns Disease</option>
                                    <option value="Cystic fibrosis">Cystic fibrosis</option>
                                    <option value="Dercum Disease">Dercum Disease</option>
                                    <option value="Familial Mediterranean Fever">Familial Mediterranean Fever</option>
                                    <option value="Fragile X Syndrome">Fragile X Syndrome</option>
                                    <option value="Gaucher Disease">Gaucher Disease</option>
                                    <option value="Hemochromatosis">Hemochromatosis</option>
                                    <option value="Hemophilia A">Hemophilia A</option>
                                    <option value="Hemophilia B">Hemophilia B</option>
                                    <option value="Holoprosencephaly">Holoprosencephaly</option>
                                    <option value="Huntingtons disease">Huntingtons disease</option>
                                    <option value="Hypertension">Hypertension</option>
                                    <option value="Klinefelter Syndrome">Klinefelter Syndrome</option>
                                    <option value="Marfan Syndrome">Marfan Syndrome</option>
                                    <option value="Muscular Dystrophy - Duchenen">Muscular Dystrophy - Duchenen</option>
                                    <option value="Myotonic Dystrophy">Myotonic Dystrophy</option>
                                    <option value="Neurofibromatosis">Neurofibromatosis</option>
                                    <option value="Noonan Syndrome">Noonan Syndrome</option>
                                    <option value="Osteogenesis Imperfecta">Osteogenesis Imperfecta</option>
                                    <option value="Parkinsons disease">Parkinsons disease</option>
                                    <option value="Phenylketonuria">Phenylketonuria</option>
                                    <option value="Poland Anomaly">Poland Anomaly</option>
                                    <option value="Porphyria">Porphyria</option>
                                    <option value="Progeria">Progeria</option>
                                    <option value="Retinitis Pigmentosa">Retinitis Pigmentosa</option>
                                    <option value="Severe Combined Immunodeficiency (SCID)">Severe Combined Immunodeficiency (SCID)</option>
                                    <option value="Sickle cell disease">Sickle cell disease</option>
                                    <option value="Spinal Muscular Atrophy">Spinal Muscular Atrophy</option>
                                    <option value="Tay-Sachs">Tay-Sachs</option>
                                    <option value="Thalassemia">Thalassemia</option>
                                    <option value="Trimethylaminuria">Trimethylaminuria</option>
                                    <option value="Turner Syndrome">Turner Syndrome</option>
                                    <option value="Velocardiofacial Syndrome">Velocardiofacial Syndrome</option>

                                    <option value="WAGR Syndrome">WAGR Syndrome</option>
                                    <option value="Wilson Disease">Wilson Disease</option>
                                    <option value="Others">Others</option>
                                    </select>
                                            @error('condition')
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
