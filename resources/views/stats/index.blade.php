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
                            <a href="{{ url('sales') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Sales</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Statistics</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Report of</h1>
        </div>
    </x-slot>

    <div class="mx-auto mt-2">
        <form action="{{route('statistics.index')}}" class="mb-2" method="get" enctype="multipart/form-data">
            <div class="col-md-2">
                <div class="w-full mt-4">
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row grid grid-cols-4 gap-2">
                <div class="col-md-2">
                    <div class="w-full">
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="date_begin" name="date_begin" required  datepicker datepicker-autohide  maxDate="{{date('d/m/Y')}}" datepicker-format="dd/mm/yyyy" value="{{ old('date_begin', date('d/m/Y',strtotime($date_d))) }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Date Begin" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="w-full">
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="date_end" name="date_end" required  datepicker datepicker-autohide  maxDate="{{date('d/m/Y')}}" datepicker-format="dd/mm/yyyy" value="{{ old('date_end',date('d/m/Y', strtotime($date_f))) }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 " placeholder="Date End" readonly="readonly">
                        </div>
                    </div>
                </div>
                {{-- {{dd($stores);}} --}}
                <div class="col-md-2">
                    <select id="store" name="store" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="" selected>Select store</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" @if($store->id == old('store',$id_store)) selected @endif @if($store->is_default == 'yes') selected @endif> {{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 flex flex-wrap max-w-full gap-2">
                    <button type="submit" name="search_button" class="bg-transparent hover:bg-green-700 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                        Display Stats
                    </button>
                    <button type="submit" name="select_button_export_xls" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Export Sales / Payment
                    </button>
                    <button type="submit" name="select_button_export_xls_orders" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Export Detailed Report
                    </button>
                    <button type="submit" name="select_button_export_xls_debtors" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Export Debtors
                    </button>
                    <button type="submit" name="select_button_export_xls_return" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Export Return
                    </button>
                </div>
            </div>
        </form>

        <div class="grid gap-2 mb-6 md:grid-cols-4">
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Pending Payment </h3>
                @foreach($methode_info as $mi)
                    @if($mi->pending)
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">{{$mi->payment_method}}: Rs {{ number_format($mi->pending,2,".",",") }} </label>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">
                <h3 class="font-semibold text-xl text-center mb-3">Paid </h3>
                @foreach($methode_info as $mi)
                    @if($mi->paid)
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">{{$mi->payment_method}}: Rs {{ number_format($mi->paid,2,".",",") }} </label>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Other </h3>
                @foreach($methode_info as $mi)
                    @if($mi->other)
                        <div class="mb-2">
                            <label class="block mb-2 text-sm font-medium">{{$mi->payment_method}}: Rs {{ number_format($mi->other,2,".",",") }} </label>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="border-white rounded-md shadow px-3 py-3 bg-white">

                <h3 class="font-semibold text-xl text-center mb-3">Total</h3>

                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Total Pending Payment: Rs {{ number_format($totals_pending,2,".",",") }} </label>
                </div>
                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Total Paid : Rs {{ number_format($totals_paid,2,".",",") }} </label>
                </div>
                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Grand Total : Rs {{ number_format($totals,2,".",",") }} </label>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"
                integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </div>


</x-app-layout>

