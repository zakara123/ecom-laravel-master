<x-app-layout>
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
                            <a href="{{ url('patients') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Patients</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Appointment Details</span>
                        </div>
                    </li>
                </ol>
            </nav>
            @if(!empty($customer->company_name))
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{$customer->upi}} - {{$customer->firstname}} {{$customer->lastname}} 
                    <a href="{{ route('medical-record', $customer->id) }}" data-modal-toggle="product-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline  mr-2" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                        Medical Record
                    </a>
                </h1>
            @else
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{$customer->upi}} - {{$customer->firstname}} {{$customer->lastname}} </h1>
            @endif
        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <div class="mb-0">

            @if(Session::has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    <span class="font-medium">Success : </span> {{ Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <span class="text-red-600 text-sm">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error : </span> {{ $error }}
                </div>
            </span>
            @endforeach

        </div>
        <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <div class="flex items-center w-full">
                    <div class="flex-shrink-0">&nbsp;</div>
                    <div class="flex-1 text-center">
                        <h3 class="font-semibold text-xl mb-3">Patient Info</h3>                        
                    </div>
                    <!--<div>
                        <a title="Update Paitent" href="{{ route('medical-record', $customer->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </a>
                    </div>-->
                        
                </div>
                <div class="grid md:grid-cols-3  md:gap-2">
                    
                    <div >
                        <label class="block mb-2 text-sm font-medium">Patient Name:  
                            
                            {{$customer->firstname}} {{$customer->lastname}}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Date of Birth:  
                            
                        {{date('d/m/Y', strtotime($customer->date_of_birth))}}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Age:  
                            <?php 
                                $birthDate = new DateTime($customer->date_of_birth);
                                $currentDate = new DateTime();
                                $age = $currentDate->diff($birthDate);
                                echo $age->y;

                            ?></label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Email: {{ $customer->email }}</label>
                    </div>
                    
                    <div >
                        <label class="block mb-2 text-sm font-medium">Phone: {{ $customer->phone }}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Mobile: {{ $customer->mobile_no }}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">WhatsApp: {{ $customer->whatsapp }}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Residential Address: {{ $customer->address1 }}</label>
                    </div>
                    <div >
                        <label class="block mb-2 text-sm font-medium">Residential Village/Town: {{ $customer->address2 }}</label>
                    </div>
                </div>
                
                
                
                
            </div>
        <div class="flex flex-col bg-white rounded-md mt-5">
            <div class="grid grid-cols-6 gap-4 mt-2 mb-2">
                <div class="col-span-2 mx-4">
                    <h3 class="font-semibold text-xl mt-2 mb-2">List of Appointments</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden px-2 pb-4">
                        <!--<form action="{{ route('customer-part-statement', $customer->id) }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="start" required datepicker-format="dd/mm/yyyy" datepicker="" datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                            </div>
                            <span class="mx-4 text-gray-500">to</span>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input required name="end" type="text" datepicker-format="dd/mm/yyyy" datepicker="" datepicker-autohide class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                            </div>
                            <span class="mx-4 text-gray-500"> </span>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export Customer Statements</button>
                            {{-- <a  href="{{ route('customer-export-item', $customer->id) }}" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export Items</a> --}}
                            <a  href="{{ route('customer-products', $customer->id) }}" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sales History</a>
                        </div>
                        </form>-->
                    </div>
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Appointment ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Appointment Date
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Type
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Mode of Consultation
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sales as $sale)
                                <tr>
                                 <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('detail-appointment', ['id' => $sale->id]) }}" class="no-underline hover:underline">{{ $sale->id }}</a>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        {{ date('d/m/Y', strtotime($sale->appointment_date)) }} {{ date('H:i', strtotime($sale->appointment_time)) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if($sale->type != 'Generalist')
                                            {{ $sale->type }}: {{ $sale->specialist_type }}
                                        @else
                                            {{ $sale->type }}
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if($sale->consultation_mode != 'In person, On Site')
                                            {{ $sale->consultation_mode }}: {{$sale->method_of_communication }} on {{ $sale->phone_call_no }}
                                        @else
                                             {{ $sale->consultation_mode }}: {{$sale->consultation_place }} <br />
                                             Address1: {{ $sale->consultation_place_address }}  Village/Town: {{$sale->village_town }}
                                        @endif
                                    
                                    
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        <a href="{{ route('detail-appointment', ['id' => $sale->id]) }}" data-modal-toggle="product-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
{{--  <a href="{{ route('export-sale',$sales->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">--}}
{{--        Download--}}
{{--    </a>--}}
{{--    <a href="{{ route('export-invoice',$sales->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">--}}
{{--        Download--}}
{{--    </a>--}}
{{--    <a href="{{ route('export-sale',$sales->id) }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">--}}
{{--        Download--}}
{{--    </a>--}}

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</x-app-layout>
