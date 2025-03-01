
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Appointment ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date created
                            </th>
                           
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Patient
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                 Appointment Date
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                 Appointment Time
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Status
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sales as $sale)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $sale->id }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"> {{ date('d/m/Y H:i', strtotime($sale->created_at)) }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $sale->patient_firstname }} {{ $sale->patient_lastname }}</td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"><?php if($sale->appointment_date){ echo date("d/m/y", strtotime($sale->appointment_date));}?></td>
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900"><?php if($sale->appointment_time){ echo date("h:i A", strtotime($sale->appointment_time));}?></td>
                                    
                                    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $sale->status }}</td>
                                    <td class="p-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('detail-rental', ['id' => $sale->id]) }}" data-modal-toggle="product-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye mr-2" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                            </svg>
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center search_pagination">
                    {{ $sales->links("pagination::tailwind") }}
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.search_pagination .pagination li a').click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var actionUrl = $(this).attr('href');
                    var filter_status = $('#filter_status').val();
                    var page_url = '&s=' + $('#search_input').val()+'&fs=' + filter_status +'&token={{ csrf_token() }}';
                    $.ajax({
                    type: "GET",
                    url: actionUrl + page_url, // serializes the form's elements.
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
