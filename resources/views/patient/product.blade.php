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

                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ url('customer') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Customers</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('customer-details', $customer->id) }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">{{$customer_name}}</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">
            All Products <a  href="{{ route('customer-export-item', $customer->id) }}" class="ml-2 float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export Items</a>

            </h1>


        </div>
    </x-slot>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
    </div>
    <div class="flex flex-col relative" id="item_field">
        <div class="overflow-x-auto">
                <div class="align-middle inline-block relative bg-gray-100 overflow-x-auto max-w-full">
                    <div class="shadow" id="over_flowing">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                            <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                                   Sales ID
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                    Sale Ref
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                   Customer Name
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                    Sale Date
                                </th>
                                <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product ID
                                </th>
                                <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                                   Product Name
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                   Selling price
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                   Buying price
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                   Unit
                                </th>
                                <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                                   Quantity
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                  Line Amount
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                  Order Amount
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                  VAT
                                </th>
                                <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                                 Description
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                    SKU
                                </th>
                                <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                                    Barcode
                                </th>
                                <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                    Category
                                </th>
                               <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                    Supplier
                                </th>
                               <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                                    Store
                                </th>
                               <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                                    Product variations
                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($productss as $product)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->sales_id }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->sale_ref }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->customer }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->sale_date }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->product_id }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->product_name }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ number_format($product->price_selling,2,".",",") }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ number_format($product->price_buying,2,".",",") }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->unit_selling_label }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->quantity }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ number_format($product->line_amount,2,".",",") }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ number_format($product->sale_amount,2,".",",") }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->vat }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->description }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->sku }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->barcode }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->category }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->supplier }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">{{ $product->store }}</td>
                                <td class="p-4  text-center font-medium text-gray-900">

                                @if(empty($product->variation))
                                            <i>( No Variation )</i>
                                        @else
                                            @foreach ($product->variation as $key=>$var)
                                                {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                                @if($key !== array_key_last($product->variation))
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center">
                    {{ $productss->links("pagination::tailwind") }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- <script type="text/javascript">
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
    </script> --}}

</x-app-layout>
