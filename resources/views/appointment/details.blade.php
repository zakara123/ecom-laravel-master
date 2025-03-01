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
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Appointment #{{$sales->id}}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Appointment ID #{{$sales->id}} from <a href="{{ route('patient-details', ['id' => $sales->customer_id]) }}" class="no-underline hover:underline">{{$sales->patient_firstname}} {{$sales->patient_lastname}}</a>
                        @if(empty($sales->order_reference) && Auth::check() &&  Auth::User()->role=='admin')
                            <button class="ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </button>
                        @endif
                    </h1>
                </div>
                @if(Auth::check() &&  Auth::User()->role=='admin')
                    <div class="justify-end flex items-center mb-4 sm:mb-0">
                        @if(!is_null($previous))
                            <a href="{{ route('detail-appointment', ['id' => $previous->id]) }}" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Previous
                            </a>
                        @endif
                        @if(!is_null($next))
                            <a href="{{ route('detail-appointment', ['id' => $next->id]) }}" class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center mr-2">
                                Next <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            @if(!empty($sales->order_reference))
                <div class="flex mt-1 ml-1 items-center">
                    <label class="flex text-sm font-medium">Ref: {{$sales->order_reference}}</label>
                    <button class="flex ml-4" title="Update Sale Ref" data-modal-toggle="update-order-ref">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </button>
                </div>
            @endif
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
        @php
            $sumbol_currency = "Rs";
        @endphp
        @if($sales->currency && $sales->currency != "MUR")
            @php
                $sumbol_currency = $sales->currency;
            @endphp
        @endif
        <div class="grid gap-2 mb-6 md:grid-cols-3">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Appointment Info</h3>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Appointment Date: {{ date('d/m/Y', strtotime($sales->appointment_date)) }}</label>
                </div>
                <div class="grid gap-6 md:grid-cols-2 mb-2">
                    <div>
                        <label class="block mb-2 mt-1 text-sm font-medium">Appointment Time: {{ date('H:i', strtotime($sales->appointment_time)) }}</label>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Date Created: {{ date('d/m/Y H:i', strtotime($sales->created_at)) }}</label>
                </div>
                @if(!empty($sales->consultation_end_time))
                    <div class="mb-2">
                        <label class="text-red-500 block mb-2 text-sm font-medium">Consultation Ended: {{ date('d/m/Y H:i', strtotime($sales->consultation_end_time)) }}</label>
                    </div>
                 @endif

            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <div class="flex items-center w-full">
                    <div class="flex-shrink-0">&nbsp;</div>
                    <div class="flex-1 text-center">
                        <h3 class="font-semibold text-xl mb-3">Patient Info</h3>
                    </div>
                    @if(Auth::check() &&  Auth::User()->role=='admin')
                        <div style="margin-top: -5%;">
                            <button title="Update Customer" data-modal-toggle="update-sale-customer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="mb-2">
                    <label class="block mb-2 text-sm font-medium">Patient Name:
                        <a href="{{ route('patient-details', ['id' => $sales->customer_id]) }}"
                           class="no-underline hover:underline">
                            {{$sales->patient_firstname}} {{$sales->patient_lastname}}</a></label>
                </div>
                @if(!empty($sales->consultation_place_address))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Patient Address: {{ $sales->consultation_place_address }}</label>
                    </div>
                @endif
                @if(!empty($sales->patient_email))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Email: {{ $sales->patient_email }}</label>
                    </div>
                @endif
                @if(!empty($sales->patient_phone))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Phone: {{ $sales->patient_phone }}</label>
                    </div>
                @endif
                @if(!empty($customer->mobile_no))
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium">Mobile: {{ $customer->mobile_no }}</label>
                    </div>
                @endif
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Status</h3>


                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Appointment Status: {{ ucfirst(strtolower($sales->status)) }}</label>
                </div>
                @if(Auth::check() &&  Auth::User()->role=='admin')
                    <div class="text-right">
                        <button title="Update status" data-modal-toggle="appointment-status-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                    </div>
                @endif
                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Doctor Status: {{ ucfirst(strtolower($sales->doctor_status)) }}</label>
                </div>
                @if(empty($sales->consultation_start_time))
                @if(Auth::check() &&  Auth::User()->role!='patient' && strtolower($sales->doctor_status)=='confirmed' && strtolower($sales->status) == 'booked')
                 
                <div>
                    <a href="{{route('detail-appointment.presenting-complaints',$sales->id)}}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                            <path d="M11.596 8.697l-6.363 4.692C4.72 13.767 4 13.443 4 12.692V3.308c0-.751.72-1.075 1.233-.697l6.363 4.692a1 1 0 0 1 0 1.394z"/>
                        </svg>
                        Start Consultation
                    </a>
                </div>
                @endif
                @endif
            </div>
        </div>
        <div class="flex flex-col bg-white rounded-md mt-6">
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2">
                <div class="col-span-3 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2" >Appointment Details</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="divide-y divide-gray-200" width="100%">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" width="12%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Appointment ID
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Appointment Date
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Type
                                </th>
                                <th scope="col" width="25%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Mode of Consultation
                                </th>
                                <th scope="col" width="23%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Comment
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $sales->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y', strtotime($sales->appointment_date)) }} {{ date('H:i', strtotime($sales->appointment_time)) }}
                                </td>

                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if($sales->type != 'Generalist')
                                        {{ $sales->type }}:<br /> {{ $sales->specialist_type }}
                                    @else
                                        {{ $sales->type }}
                                    @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if($sales->consultation_mode != 'In person, On Site')
                                        {{ $sales->consultation_mode }}: {{$sales->method_of_communication }} on {{ $sales->phone_call_no }}
                                    @else
                                        {{ $sales->consultation_mode }}: {{$sales->consultation_place }} <br />
                                        Address1: {{ $sales->consultation_place_address }}  Village/Town: {{$sales->village_town }}
                                    @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $sales->appointment_comment }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if(Auth::check() &&  Auth::User()->role=='admin')
                                        <div class="flex-shrink-0">&nbsp;</div>
                                        <button title="Appointment Comment" data-modal-toggle="appointment-comment">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-md mt-6">
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2">
                <div class="col-span-3 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2" >Doctor Assignment</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="divide-y divide-gray-200" width="100%">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" width="25%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date
                                </th>
                                <th scope="col" width="30%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Doctor
                                </th>
                                <th scope="col" width="30%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Comment
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>

                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointmentLogs as $appointmentLog)
                                @php
                                    $apptDetailJson = json_decode($appointmentLog->appointment_details);
                                    $apptDetailJsonCmt = isset($apptDetailJson->appointment_comment) ? $apptDetailJson->appointment_comment : "";
                                @endphp
                                <tr>
                                    <td class="p-4 text-center font-medium text-gray-900" width="25%">
                                        @if($appointmentLog->created_at)
                                            {{ date('d/m/Y H:i', strtotime($appointmentLog->created_at)) }}
                                        @endif
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="30%">
                                        @if(!\App\Services\CommonService::doStringMatch($appointmentLog->status, 'REQUESTED'))
                                            {{$sales->doctor_name }}
                                        @endif
                                    </td>

                                    <td class="p-4  text-center font-medium text-gray-900" width="25%">
                                        {!! \App\Services\CommonService::breakLineOnWord($apptDetailJsonCmt, 'for') !!}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="15%">
                                        <div class="flex-shrink-0">&nbsp;</div>
                                        @if(Auth::check() )
                                            @if($loop->last)
                                                @if(Auth::User()->role=='admin')
                                                    @if($appointmentLog->status !='REJECTED' && $sales->status != "Cancelled")
                                                    @if(strtolower($sales->doctor_status)!='confirmed')
                                                    <button title="Assign Doctor" data-modal-toggle="assign-doctor">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                        </svg>
                                                    </button>
                                                    @endif
                                                    @endif
                                                @endif
                                                @if($appointmentLog->status =='REJECTED' && Auth::User()->role=='admin')
                                                    <button title="Assign Doctor" data-modal-toggle="assign-doctor">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                                <!-- This will ensure the buttons only appear on the last row -->
                                            @if(in_array($sales->status, ['REQUESTED', 'BOOKED', 'RESCHEDULED', 'CONFIRMED']))
                                                @if(Auth::User()->role!='patient')
                                                    <!-- Confirm Button -->
                                                     @if(strtolower($sales->doctor_status)!='confirmed')
                                                     @if(ucfirst(strtolower($sales->doctor_status)) != 'Yet to be assigned')
                                                    <button class="mx-2" title="Appointment Confirm" onclick="confirmAppointment()">
                                                        <i class="fas fa-check test"></i>
                                                    </button>
                                                    @endif
                                                    @endif
                                                @endif
                                                @if(Auth::User()->role=='patient' && $appointmentLog->status !='Acknowledged' && $appointmentLog->status !='RESCHEDULED' && strtolower($sales->doctor_status)=='confirmed')
                                                    <!-- Confirm Button -->
                                                    <button class="mx-2" title="Appointment Confirm" onclick="confirmPatientAppointment()">
                                                        <i class="fas fa-check test2"></i>
                                                    </button>
                                                @endif
                                                @if(Auth::User()->role!='patient')
                                                    <!-- Reschedule Button -->
                                                    <button class="mx-2" title="Appointment Reschedule" onclick="rescheduleAppointment()">
                                                        <i class="fas fa-calendar"></i>
                                                    </button>
                                                    <!-- Reject Button -->
                                                    <button class="mx-2" title="Appointment Reject" onclick="rejectAppointment()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <div class="flex flex-col bg-white rounded-md mt-6">
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2">
                <div class="col-span-3 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2" >Appointment Documents</h3>
                    @if(Auth::check() &&  Auth::User()->role!='patient')
                        <button type="button" data-modal-toggle="add-attachement-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto text-right float-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload mr-2" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg>
                            Upload
                        </button>
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="divide-y divide-gray-200" width="100%">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Document
                                </th>
                                <th scope="col" width="18%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Document Type
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date Generated
                                </th>
                                <th scope="col" width="37%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Comment
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>

                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales_files as $file)
                                <tr>
                                    <td class="p-4  text-center font-medium text-gray-900" width="15%">
                                        <a href="javascript:void(0)" data-src="{{$file->src}}" data-modal-toggle="popup-modal-invoices" class="text-gray-700 hover:text-gray-900 inline-flex items-center show-appointment-file">
                                            {{$file->name}}
                                        </a>

                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="18%">
                                        {{$file->type}}
                                    </td>

                                    <td class="p-4  text-center font-medium text-gray-900" width="15%">
                                        {{ date('d/m/Y H:i', strtotime($file->created_at)) }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="37%">
                                        {{ $file->appointment->consultation_end_comments??'' }}
                                    </td>
                                    <td class="p-4  text-right font-medium text-gray-900" width="15%">
                                        <a href="{{$file->src}}" class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Download
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

        <div class="flex flex-col bg-white rounded-md mt-6">
            <h3 class="font-semibold text-xl text-center mt-2 mb-2">Appointment Billables</h3>
            <div class="col-span-2 text-right  mb-2">
                <!--<a  href="{{ route('appointment-pending-amount-pdf',$sales->id) }}" type="button"  class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Update Proforma Invoice
                </a>-->
                @if(Auth::check() &&  Auth::User()->role!='patient')
                    <button type="button" data-modal-toggle="add-new-item" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add Item
                    </button>
                @endif
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="divide-y divide-gray-200" width="100%">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" width="30%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Item
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Unit Price
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Quantity
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Tax
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Frequency
                                </th>
                                <th scope="col" width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col" width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($appointmentBillableProduct as $item)

                                <tr class="hover:bg-gray-100">
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{ $item->product_name }}

                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        @if($appointmentBillable->currency == "MUR")
                                            {{$sumbol_currency}} {{ number_format($item->order_price,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif
                                        @else
                                            Rs {{ number_format($item->order_price,2,".",",") }} / {{$sumbol_currency}} {{ number_format($item->order_price_converted,2,".",",") }} @if(!empty($item->product_unit)) / {{$item->product_unit}} @endif
                                        @endif
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">{{ $item->quantity }}</td>
                                    <td class="p-4  text-center font-medium text-gray-900">{{$sumbol_currency}}
                                        @if($item->tax_sale != "Zero Rated" && $item->tax_sale != "VAT Exempt")
                                            @if($appointmentBillable->currency == "MUR")
                                                {{ number_format(($item->order_price*$item->quantity) * 0.15,2,".",",") }}
                                            @else
                                                {{ number_format($item->order_price_converted * 0.15,2,".",",") }}
                                            @endif
                                        @else
                                            @if($appointmentBillable->currency == "MUR")
                                                0.00
                                            @else
                                                0.00 (Rs 0.00)
                                            @endif
                                        @endif

                                        <br><span class="text-gray-500 text-xs">Tax: {{ $item->tax_sale }}</span>
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        @if($item->frequency)
                                            {{$item->frequency}}
                                        @else
                                            Recurring
                                        @endif
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">{{$sumbol_currency}}
                                        @if(isset($item->discount) && $item->discount > 0)
                                            @if($appointmentBillable->currency == "MUR")
                                                {{ number_format((int)$item->quantity * ($item->order_price - (($item->order_price*$item->quantity)*$item->discount/100)),2,".",",") }}
                                            @else
                                                {{ number_format((int)$item->quantity * ($item->order_price_converted - ($item->order_price_converted*$item->discount/100)),2,".",",") }} (Rs {{ number_format($item->quantity * ($item->order_price - ($item->order_price*$item->discount/100)),2,".",",") }})
                                            @endif
                                            <br><small>(Discount {{$item->discount}}%)</small>
                                        @else
                                            @if($appointmentBillable->currency == "MUR")
                                                @if($item->tax_sale != "Zero Rated" && $item->tax_sale != "VAT Exempt" )
                                                    {{ number_format(((int)$item->quantity * (int)$item->order_price) + (($item->order_price*$item->quantity) * 0.15),2,".",",") }}
                                                @else
                                                    {{ number_format((int)$item->quantity * $item->order_price,2,".",",") }}
                                                @endif
                                            @else
                                                {{ number_format($item->quantity * $item->order_price_converted,2,".",",") }} (Rs {{ number_format($item->quantity * $item->order_price,2,".",",") }})
                                            @endif
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                        @if(Auth::check() &&  Auth::User()->role=='admin' && $sales->status == 'Booked')
                                            <div class="flex items-center justify-center space-x-4">
                                                <button title="Update Item Sale" data-modal-toggle="update-item" onclick="updateItemSale('{{$item->id}}','{{ $item->tax_sale }}', '{{$item->order_price}}', '{{$item->product_variations_id}}', '{{$appointmentBillable->currency}}', '{{$item->quantity}}','{{$item->frequency}}')" class="focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil inline" viewBox="0 0 16 16">
                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                                                    </svg>
                                                </button>

                                                <form action="{{ route('destroy_appointment_item',$item->id) }}" method="POST"
                                                      onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="focus:outline-none">
                                                        <svg width="16" height="16" fill="currentColor" class="h-5 w-5 inline" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col bg-white rounded-md mt-6" id="bloc_payment_sales">
            <div class="grid grid-cols-7 gap-4 mt-2 mb-2">
                <div class="col-span-1 text-center"><h3 class="font-semibold text-sm mt-2 mb-2">Amount Due:
                        @if($sales->status != "Booked")
                            {{$sumbol_currency}} {{ number_format($amount_due,2,".",",") }}
                        @else
                            {{$sumbol_currency}} 0
                        @endif</h3>
                </div>
                <div class="col-span-1 text-center"><h3 class="font-semibold text-sm mt-2 mb-2">Amount Paid:
                        {{$sumbol_currency}} {{ number_format($amount_paied,2,".",",") }}</h3>
                </div>
                <div class="col-span-3 text-center">
                    <h3 class="font-semibold text-xl mt-2 mb-2">Invoices & Payments </h3>
                </div>
                <div class="col-span-2 text-right">
                    @if(count($appointmentBillableProduct) > 0)
                        @if(Auth::check() &&  Auth::User()->role=='admin' && $sales->status != "Booked")
                            <button type="button" data-modal-toggle="add-payment-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Add Payment
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="divide-y divide-gray-200" width="100%">
                            <thead class="bg-gray-100">
                            <tr >
                                <th scope="col"   width="5%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col"  width="20%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Date
                                </th>
                                <th scope="col"  width="20%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Payment Mode
                                </th>
                                <th scope="col"  width="20%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Reference
                                </th>
                                <th scope="col"   width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col"  width="10%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Balance
                                </th>
                                <th scope="col"   width="15%" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <?php $counter = 1;?>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @if(count($appointmentBillableProduct) > 0 && !empty($appointmentBillable))
                                <tr>
                                    <td class="p-4  text-center font-medium text-gray-900"  width="5%">
                                        {{$counter}}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%">
                                        {{ date('d/m/Y H:i', strtotime($appointmentBillable->created_at)) }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%"></td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%">
                                        <a href="javascript:void(0)" data-modal-toggle="popup-modal-sales"
                                           onclick="view_pdf_sales('{{ route('export-appointment-proforma',$sales->id) }}','appointment-proforma-{{$sales->id}}.pdf?v={{ time() }}','{{$pdf_src}}')"
                                           class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                            proforma-invoice-{{$sales->id}}.pdf
                                        </a>
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="10%">
                                        {{$sumbol_currency}} {{ number_format($appointmentBillable->amount,2,".",",") }}
                                        @if($appointmentBillable->tax_amount > 0)
                                            <br><span class="text-gray-500 text-xs">Tax: 15% VAT</span>
                                        @endif

                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="10%">
                                        {{$sumbol_currency}} 0.00
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="15%">

                                        <a href="{{ route('export-appointment-proforma',$appointmentBillable->id) }}"
                                           class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @if($sales->status != "Booked" && $sales->status != "Confirmed" && !empty($appointmentBillable))
                                    <?php $counter++;?>
                                <tr>
                                    <td class="p-4  text-center font-medium text-gray-900"  width="5%">
                                        {{$counter}}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%">
                                        {{ date('d/m/Y H:i', strtotime($appointmentBillable->created_at)) }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%"></td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="20%">
                                        <a href="javascript:void(0)" data-modal-toggle="popup-modal-sales"
                                           onclick="view_pdf_sales('{{ route('export-appointment',$sales->id) }}','appointment-{{$sales->id}}.pdf?v={{ time() }}','{{$pdf_src}}')"
                                           class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                                            invoice-{{$sales->id}}.pdf
                                        </a>
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="10%">{{$sumbol_currency}} {{ number_format($appointmentBillable->amount,2,".",",") }}</td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="10%">
                                        {{$sumbol_currency}} {{ number_format($appointmentBillable->amount,2,".",",") }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900" width="15%">

                                        <a href="{{ route('export-appointment',$sales->id) }}"
                                           class="text-gray-700 hover:text-gray-900 inline-flex items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            @foreach ($sales_payments as $payment)
                                <tr>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{ $counter++ }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{ date('d/m/Y', strtotime($payment->payment_date)) }} {{ date('H:i', strtotime($payment->created_at)) }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        @if(!is_null($payment->payment_method))
                                            {{ $payment->payment_method->payment_method }}
                                        @else
                                            Payment method ID: {{ $payment->payment_mode }}
                                        @endif
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{ $payment->payment_reference }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{$sumbol_currency}} {{ number_format($payment->amount,2,".",",") }}
                                    </td>
                                    <td class="p-4  text-center font-medium text-gray-900">
                                        {{$sumbol_currency}} {{ number_format($payment->due_amount,2,".",",") }}
                                    </td>
                                    <td class="p-4 text-center font-medium text-gray-900">


                                        @if(Auth::check() &&  Auth::User()->role=='admin')
                                            <form class="p-1" action="{{ route('appointment-payments.destroy',$payment->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                                  style="margin:0">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <button type="submit"
                                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
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

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Payment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('appointment-payments.index') }}" method="POST">
                    @if(!$amount_due)
                        <div
                            class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <span class="font-medium">No payment can be added. Amount due is 0</span>
                        </div>
                    @endif
                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="payment_date" value="{{old('payment_date')}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Payment">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_mode" class="text-sm font-medium text-gray-900 block mb-2">Payment Mode</label>
                                <select id="payment_mode" name="payment_mode" value="{{old('payment_mode')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($payment_mode as $payment)
                                        @if($payment->payment_method != "Credit Sale")
                                            <option value="{{ $payment->id }}"  {{ (old('payment_mode') == $payment->id  ? 'selected':'') }}>{{ $payment->payment_method }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" max="{{  $amount_due }}"
                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="Amount" value='{{ number_format($amount_due,2,".","") }}'
                                       required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">

                        Update Price / Vat Type
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('update-item-appointment',$sales->id) }}" method="POST">
                    @csrf

                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <input type="hidden" name="sales_id" value="{{ $sales->id }}">
                                            <input type="hidden" name="product_id" value="" id="item_id_sale">
                                            <input type="hidden" name="product_variations_id" value="" id="product_variations_id">
                                            <input type="hidden" name="currency" value="" id="currency">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_unit_price">
                                                    Unit Price (Rs)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                       type="number"
                                                       id="item_unit_price"
                                                       name="item_unit_price"
                                                       placeholder="Unit Price"
                                                       value=""
                                                       step="0.01"
                                                       pattern="^\d+(\.\d{0,2})?$"
                                                       oninput="validateDecimal(this)">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_quantity">
                                                    Quantity
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="item_quantity" name="item_quantity" placeholder="Quantity" value="" step="1">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    VAT
                                                </label>
                                                <select id="item_vat" name="item_vat"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        placeholder="VAT">
                                                    <option value="VAT Exempt" >VAT Exempt</option>
                                                    <option value="15% VAT">15% VAT</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                </select>
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    Frequency
                                                </label>
                                                <select id="item-frequency" name="frequency"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        placeholder="Frequency">
                                                    <option value="One-Off" >One-Off</option>
                                                    <option value="Recurring">Recurring</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Update Item" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-new-item" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">

                        Add New Item
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-new-item">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('add-new-item-appointment',$sales->id) }}" method="POST">
                    @csrf

                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-4 ">
                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <div class="grid md:grid-cols-2">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    Item
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text" id="rental_product_name" name="rental_product_name" placeholder="Item" value="" >

                                            </div>
                                            <input type="hidden" name="sales_id" value="{{ $sales->id }}">

                                            <input type="hidden" name="currency" value="" id="currency">
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_unit_price">
                                                    Unit Price (Rs)
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                       type="number"
                                                       id="add_item_unit_price"
                                                       name="new_item_unit_price"
                                                       placeholder="Unit Price"
                                                       value=""
                                                       step="0.01"
                                                       pattern="^\d+(\.\d{0,2})?$"
                                                       oninput="validateDecimal(this)">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_quantity">
                                                    Quantity
                                                </label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="number" id="item_quantity" name="new_item_quantity" placeholder="Quantity" value="" step="1">
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    VAT
                                                </label>
                                                <select id="new_item_vat" name="new_item_vat"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        placeholder="VAT">
                                                    <option value="VAT Exempt" >VAT Exempt</option>
                                                    <option value="15% VAT">15% VAT</option>
                                                    <option value="Zero Rated">Zero Rated</option>
                                                </select>
                                            </div>
                                            <div class="mb-6 relative pl-4 pr-4 z-0 mb-6 w-full group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="item_vat">
                                                    Frequency
                                                </label>
                                                <select id="new_item-frequency" name="new_frequency"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        placeholder="Frequency">
                                                    <option value="One-Off" >One-Off</option>
                                                    <option value="Recurring">Recurring</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <input type="submit" name="update_item" id="update_item" value="Save Item" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 cursor-pointer"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="appointment-comment" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Appointment Comment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="appointment-comment">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('update-appointment-comment', $sales->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Comment</label>
                                <textarea rows="4" id="appointment_comment" name="appointment_comment" value="{{$sales->appointment_comment}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">{{$sales->appointment_comment}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="assign-doctor" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">
           
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Assign Doctor
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="assign-doctor">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            

                <form action="{{ route('appointment-doctor-assign', $sales->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Doctor Name</label>
                                <select id="doctor_id" name="doctor_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="">Select Doctor</option>
                                    @foreach ($doctor_list as $item)
                                        <option value="{{$item->id}}" @if ($sales->doctor_id == $item->id) selected @endif>{{$item->first_name}} {{$item->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Comment</label>
                                <textarea rows="4" id="doctor_comment" name="doctor_comment" value="{{$sales->doctor_comment}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">{{$sales->doctor_comment}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="appointment-status-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Appointment Status
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="appointment-status-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('appointment-update', $sales->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Status</label>
                                <select id="status" name="status" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    @if($sales->status == 'Booked' || $sales->status == "Confirmed")<option value="Booked" @if($sales->status == "Booked") selected @endif>Booked</option>@endif
                                    <option value="Pending Payment" @if($sales->status == "Pending Payment") selected @endif>Pending Payment</option>
                                    <option value="Paid" @if($sales->status == "Paid") selected @endif>Paid</option>
                                    <option value="Cancelled" @if($sales->status == "Cancelled") selected @endif>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-order-ref" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Order Reference
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-order-ref">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('appointment_update_order_reference', $sales->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="order_reference" class="text-sm font-medium text-gray-900 block mb-2">Order Reference</label>
                                <input type="text" name="order_reference" id="order_reference" value="{{old('order_reference', $sales->order_reference)}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Order Reference">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Payment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('appointment-payments.index') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="payment_date" value="{{old('payment_date')}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Payment">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($amount_due - $amount_paied,2,".","") }}' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-payment-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Payment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-payment-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- route('appointment-payments.update_post') -->
                <form action="" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="payment_id" name="id" value="" required>
                        <input type="hidden" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="payment_date" class="text-sm font-medium text-gray-900 block mb-2">Date Payment</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="payment_date" id="update_payment_date" value="{{old('payment_date')}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Date Payment">
                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="payment_reference" class="text-sm font-medium text-gray-900 block mb-2">Payment Reference</label>
                                <input type="text" name="payment_reference" id="update_payment_reference" value="{{old('payment_reference')}}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Payment Reference">
                            </div>
                            <div class="col-span-full">
                                <label for="update_amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="update_amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add Journal
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('add-journal-sale') }}" method="POST">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" id="sales_id" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date" value="{{old('date', date('d/m/Y', strtotime($sales->created_at)))}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit" class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit" required name="debit" value="{{old('debit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>

                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit" class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit" required name="credit" value="{{old('credit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>

                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($sales->amount,2,".","") }}' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-journal-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Journal
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-journal-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('update-journal-sale') }}" method="POST">
                    @csrf
                    <div class="p-6">

                        <input type="hidden" id="journal_id" name="journal_id" value="">
                        <input type="hidden" id="journal_id_debit" name="journal_id_debit" value="">
                        <input type="hidden" id="journal_id_credit" name="journal_id_credit" value="">
                        <input type="hidden" id="sales_id" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="journal_date" class="text-sm font-medium text-gray-900 block mb-2">Date Journal</label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date" required id="journal_date_edit" value="{{old('date', date('d/m/Y', strtotime($sales->created_at)))}}" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date Journal">

                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="journal_debit_edit" class="text-sm font-medium text-gray-900 block mb-2">Debit</label>
                                <select id="journal_debit_edit" required name="debit" value="{{old('debit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No debit</option>

                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="journal_credit_edit" class="text-sm font-medium text-gray-900 block mb-2">Credit</label>
                                <select id="journal_credit_edit" required name="credit" value="{{old('credit')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">No credit</option>

                                </select>
                            </div>

                            <div class="col-span-full">
                                <label for="amount" class="text-sm font-medium text-gray-900 block mb-2">Amount</label>
                                <input type="number" name="amount" id="amount_edit" step=".01" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Amount" value='{{ number_format($sales->amount,2,".","") }}' required="">
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="add-attachement-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Attachment
                    </h3>
                   
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-attachement-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                   
                </div>

                <form action="{{ route('appointment-add-sale-files') }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        <input type="hidden" name="sales_id" value="{{$sales->id}}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-full">
                                <label for="document_type" class="text-sm font-medium text-gray-900 block mb-2">Document Type</label>
                                <select id="document_type" name="document_type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value="Invoice">Invoice</option>
                                    <option value="Delivery Note">Delivery Note</option>
                                    <option value="Proof of payment">Proof of payment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-span-full">
                                <label class="block">
                                    <span class="sr-only">Choose profile file</span>
                                    <input type="file" name="file_upload" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100
                            " />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-payment-mode-modal" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Upload Payment Mode
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-payment-mode-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden" id="update-sale-customer" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Patient
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="update-sale-customer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('appointments.update_customer', $sales->id) }}" method="POST" enctype="multipart/form-data">

                    <div class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mt-2">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    First Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="firstname" placeholder="Contact First Name" value="{{old('firstname', $sales->patient_firstname)}}">

                            </div>
                            <div class="w-full mt-2">
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Last Name
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="lastname" placeholder="Contact Last Name" value="{{old('lastname', $sales->patient_lastname)}}">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 1
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address1" placeholder="Address 1" value="{{old('address1', @$customer->address1)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="address1">
                                    Address 2
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="address2" placeholder="Address 2" value="{{old('address2', $customer->address2)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="city">
                                    Village/Town
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="city" placeholder="Village/Town" value="{{old('city', $customer->city)}}">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3  md:gap-6">
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="email">
                                    Email
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="email" name="email" placeholder="Email" value="{{old('email',$sales->patient_email)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="phone" placeholder="Phone" value="{{old('phone', $customer->phone)}}">
                            </div>
                            <div class="w-full mt-4">
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Mobile
                                </label>

                                <input
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="mobile_no" placeholder="Mobile" value="{{old('phone', $customer->mobile_no)}}">
                            </div>

                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 rounded-b">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
            integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div id="popup-modal-sales" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-sales">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_sale" style="min-height: 75vh"  ></iframe>
                </div>
            </div>
        </div>
    </div>

    <div id="popup-modal-invoices" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-invoices">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <iframe class="w-full h-full" id="pdf_view_invoice" style="min-height: 75vh"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const appointmentId = {{$sales->id}}; // Replace with the actual appointment ID

        // Assuming these values are populated from your PHP backend dynamically
        let doctorFirstName = "<?php echo @$doctor_name->first_name; ?>";  // Replace with dynamic value
        let doctorLastName = "<?php echo @$doctor_name->last_name; ?>";    // Replace with dynamic value
        let doctorFee = "<?php echo @$doctor_name->fee; ?>";                 // Replace with dynamic value (fee from profile)

        // Function to confirm the patient's appointment
        function confirmPatientAppointment(appointmentId) {
            Swal.fire({
                title: 'Confirm Appointment',
                text: `Doctor ${doctorFirstName} ${doctorLastName} has confirmed your appointment. Please acknowledge to confirm your appointment. The doctor's consultation fee is Rs ${doctorFee}. Additional fees can be charged during consultation.`,
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading while processing confirmation
                    Swal.fire({
                        title: 'Processing...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    // Send AJAX request for confirmation
                    $.ajax({
                        url: '/appointment-update/' + appointmentId,
                        method: 'POST',
                        data: {
                            status: 'Acknowledged',  // Send status as acknowledged
                            _token: "<?php echo csrf_token(); ?>"  // CSRF token for Laravel
                        },
                        success: function(response) {
                            // Close loading and show success
                            Swal.close();
                            Swal.fire('Confirmed!', 'Your appointment has been acknowledged.', 'success');

                            // Reload the page after 3 seconds
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function() {
                            Swal.close();
                            Swal.fire('Error!', 'An error occurred while confirming.', 'error');
                        }
                    });
                }
            });   
        }
        
    @if(Auth::User()->role=='patient' && $appointmentLog->status !='Acknowledged' && strtolower($sales->doctor_status)=='confirmed')    
        // Confirm Appointment
        /*function confirmPatientAppointment(){
            // Assuming you have the doctor's first name, last name, and consultation fee
            let doctorFirstName = "<?php echo @$doctor_name->first_name;?>";  // Replace with dynamic value
            let doctorLastName = "<?php echo @$doctor_name->last_name;?>";    // Replace with dynamic value
            let doctorFee = <?php echo @$doctor_name->fee;?>;          // Replace with dynamic value (fee from profile)


            Swal.fire({
                title: ``,
                text: `Doctor ${doctorFirstName} ${doctorLastName} has confirmed your appointment. Please acknowledge to confirm your appointment. The doctor's consultation fee is Rs ${doctorFee}. Additional fees can be charged during consultation.`,
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    // Send AJAX request for confirmation
                    $.ajax({
                        url: '/appointment-update/'+appointmentId,
                        method: 'POST',
                        data: {
                            status: 'Acknowledged', // Send status as confirmed
                            _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire('Confirmed!', 'Acknowledged has been confirmed.', 'success');

                            // Reload page after 3 seconds
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function() {
                            Swal.fire('Error!', 'An error occurred while confirming.', 'error');
                        }
                    });
                }
            });
        }*/
    @endif

    function rejectAppointment(){
        Swal.fire({
            title: 'Do you want to reject the appointment?',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Send AJAX request for rejection
                $.ajax({
                    url: '/appointment-update/'+appointmentId,
                    method: 'POST',
                    data: {
                        status: 'REJECTED', // Send status as rejected
                        _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                    },
                    success: function(response) {
                        Swal.close();
                        Swal.fire({
                            title: 'Rejected!',
                            text: 'Appointment has been rejected.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
                            }
                        });

                        // Reload page after 3 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while rejecting.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
                            }
                        });
                    }
                });
            }
        });
    }

    // Reschedule Appointment
    function rescheduleAppointment(){
        Swal.fire({
            title: 'Select new date and time',
            html: '<input type="text" id="datepicker" class="input text-center">',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
            },
            didOpen: () => {
                flatpickr("#datepicker", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let selectedDate = document.getElementById('datepicker').value;

                if (selectedDate) {
                    Swal.fire({
                        title: 'Processing...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    // Send AJAX request for reschedule
                    $.ajax({
                        url: '/appointment-update/'+appointmentId,
                        method: 'POST',
                        data: {
                            status: 'RESCHEDULED',
                            new_date: selectedDate, // Send the new date and time
                            _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire({
                                title: 'Rescheduled!',
                                text: 'Appointment has been rescheduled.',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
                                }
                            });

                            // Reload page after 3 seconds
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while rescheduling.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select a date and time.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
                        }
                    });
                }
            }
        });
    }
    // Confirm Appointment
    function confirmAppointment(){
        Swal.fire({
            title: 'Do you want to confirm the appointment?',
            showCancelButton: true,
            confirmButtonText: 'Yes, confirm',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                cancelButton: 'bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Send AJAX request for confirmation
                $.ajax({
                    url: '/appointment-update/'+appointmentId,
                    method: 'POST',
                    data: {
                        status: 'BOOKED', // Send status as confirmed
                        _token: "{{ csrf_token() }}" // Add CSRF token for Laravel
                    },
                    success: function(response) {
                        Swal.close();
                        Swal.fire('Confirmed!', 'Appointment has been confirmed.', 'success');

                        // Reload page after 3 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function() {
                        Swal.fire('Error!', 'An error occurred while confirming.', 'error');
                    }
                });
            }
        });
    }
        function updateItemSale(product_id ,tax_sale , order_price,product_variations_id,currency,quantity,frequency){

            $('#update-item #item_id_sale').val(product_id);
            $('#update-item #item_vat').val(tax_sale).change();
            $('#update-item #item_unit_price').val(order_price);
            $('#update-item #item_quantity').val(quantity);
            $('#update-item #currency').val(currency);
            $('#update-item #item-frequency').val(frequency);
        }

        function changeJournal(id,date,debit,credit,amount,id_debit,id_credit){
            // $('#journal_id').val(id);
            $('#journal_id_debit').val(id_debit);
            $('#journal_id_credit').val(id_credit);
            $('#journal_date_edit').val(date);

            $('#journal_debit_edit option').attr('selected',false);
            $('#journal_credit_edit option').attr('selected',false);

            $('#journal_debit_edit option').each(function (){
                let debit_val = $(this).attr('value');
                if(debit_val == debit) $(this).attr('selected',true);
            });
            $('#journal_credit_edit option').each(function (){
                let credit_val = $(this).attr('value');
                if(credit_val == credit) $(this).attr('selected',true);
            });


            $('#amount_edit').val(amount);
        }

        function view_pdf_sales(pdf,name_pdf,src_pdf){
            $('#pdf_view_sale').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=1');
        }
        function view_pdf_invoice(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=1');
        }
        function view_pdf_delivery_note(pdf,name_pdf,src_pdf){
            $('#pdf_view_invoice').attr('src','/pdf/'+src_pdf+'/'+name_pdf+'#toolbar=1');
        }
        $(document).on('click','.show-appointment-file',function(){

            $('#pdf_view_invoice').attr('src',$(this).data('src')+'#toolbar=1');

        });
    </script>

    <script>
        function load_payment(id,payment_date,payment_mode,payment_reference,amount){
            $("#payment_id").val(id);
            $("#update_payment_date").val(payment_date);
            $("#update_payment_mode").val(payment_mode);
            $("#update_payment_reference").val(payment_reference);
            $("#update_amount").val(amount);
        }
        function validateDecimal(input) {
            let value = input.value;
            let regex = /^\d+(\.\d{0,2})?$/;

            if (!regex.test(value)) {
                input.value = value.slice(0, -1);
            }
        }
    </script>

    <script>
        

    </script>

</x-app-layout>

