

        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Patient ID
                                </th>
                                
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Email
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Phone
                                </th>

                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Created_At
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customers as $customer)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $customer->id }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $customer->firstname }} {{ $customer->lastname }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $customer->email }}</td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $customer->phone }}</td>

                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ date('d/m/Y H:i', strtotime($customer->created_at)) }}</td>
                                <td class="p-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Customer
                                    </a>

                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Delete Customer
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center search_pagination">
                    {{ $customers->links("pagination::tailwind") }}
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
                    var page_url = '&s=' + $('#search_input').val();
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
