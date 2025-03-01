
<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    {{--  <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="#"
                                class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">E-commerce</a>
                        </div>
                    </li>  --}}
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                aria-current="page">Patient</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Medical Record of {{$customer->firstname}} {{$customer->lastname}}, UPI: {{$customer->upi}}</h1>
        
        </div>
    </x-slot>
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
    <div class="mx-2 my-4 w-full">
        @if (session()->has('message'))
        <div class="p-3 rounded bg-green-500 text-green-100 my-2">
            {{ session('message') }}
        </div>
        @endif
    </div>
    
    <div class="w-full flex gap-4" >
            @include('patient.patient_left_nav', ['customer_id' => $customer->id])
        <div class="w-4/5 bg-gray-100" id="item_field">
        <div class="p-2 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">

        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
            
                <div class="flex items-center sm:justify-end w-full">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Physicians</h1>
                    <a href="{{ route('add-patient-physicians', $customer->id) }}" 
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add New Physicians
                        
                    </a>
                    
                </div>
            </div>
        </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Type
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Phone
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customers as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">{{ $item->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $item->physician_name }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $item->physician_type }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $item->physician_phone }}</td>

                                <td class="p-4  space-x-2">                                
                                    <a href="{{ route('edit-patient-physicians', [$customer->id,$item->id]) }}"
                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('view-patient-physicians', [$customer->id,$item->id]) }}"
                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center">
                    {{ $customers->links("pagination::tailwind") }}
                    </div>
        
        </div>
        

    </div>



    
    <script type="text/javascript">
        function searchItem(page) {
            var form = $('#form_search');
            var actionUrl = form.data('action');
            var search = $('#search_input').val();
            var page_url = '?s=' + search;
            setTimeout(function(){
                $.ajax({
                    type: "GET",
                    url: actionUrl + page_url,
                    beforeSend: function(){
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function(data) {
                        $('#item_field').html(data);
                        // show response from the php script.
                    }, error: function(){
                        console.log('Error');
                    },
                    complete: function(){
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');
                    }
                });
            }, 500);
        }
        $(document).ready(function() {
                $('.search_pagination .pagination li a').click(function(e){
                    e.preventDefault();
                    var actionUrl = $(this).attr('href');
                    var page_url = '&s=' + $('#search_input').val();
                    $.ajax({
                    type: "GET",
                    url: actionUrl + page_url,// serializes the form's elements.
                    beforeSend: function(){
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function(data) {
                        $('#item_field').html(data);
                    }, error: function(){
                        console.log('Error');
                    },
                    complete: function(){
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');
                    }
                });
                });
        } );
    </script>

</x-app-layout>
