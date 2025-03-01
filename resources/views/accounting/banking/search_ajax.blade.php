

        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div  class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Transaction ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Reference
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Description
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Debit
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Credit
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Balance
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bankings as $banking)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $banking->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($banking->date)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $banking->reference }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ $banking->description }}
                                </td>

                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format($banking->debit,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format($banking->credit,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format($banking->balance,2,".",",") }}
                                </td>

                                <td class="p-4 space-x-2">
                                    <div class="flex gap-2">
                                        <form action="{{ route('banking-petty-cash',$banking->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('You will matching on petty cash, do you confirm?') }}');"
                                              style="margin:0; display: inline-block">

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="date" value="{{$banking->date }}">
                                            <input type="hidden" name="debit" value="{{$banking->debit }}">
                                            <input type="hidden" name="credit" value="{{$banking->credit }}">
                                            <input type="hidden" name="description" value="{{$banking->description }}">
                                            <input type="hidden" name="reference" value="{{$banking->reference }}">
                                            <input type="hidden" name="amount" value="{{$banking->amount }}">

                                            <button type="submit" @if($banking->matching_status == 2) disabled @endif
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                                </svg>

                                            </button>
                                        </form>
                                        <button type="button" data-drawer-target="drawer-right-view-matching"
                                                data-drawer-show="drawer-right-view-matching"
                                                data-drawer-placement="right" aria-controls="drawer-right-view-matching"
                                                onclick="viewMatching('{{ $banking->id }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                        <button data-modal-toggle="edit-banking"
                                                onclick="updateBanking('{{ $banking->id }}','{{ date('d/m/Y', strtotime($banking->date)) }}','{{ $banking->debit }}','{{ $banking->credit }}','{{ $banking->amount }}','{{ $banking->reference }}','{{ $banking->description }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                      d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                      clip-rule="evenodd"></path>
                                            </svg>

                                        </button>
                                    </div>
                                    <div class="flex gap-2 pt-4">
                                        <form action="{{ route('banking.destroy',$banking->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                              style="margin:0; display: inline-block">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <button type="submit"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <button data-modal-toggle="matching-Banking" @if($banking->matching_status == 2) disabled @endif
                                        onclick="matchBanking('{{ $banking->id }}','{{ date('d/m/Y', strtotime($banking->date)) }}','{{ $banking->debit }}','{{ $banking->credit }}','{{ $banking->amount }}','{{ $banking->reference }}','{{ $banking->description }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            Match
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-md-12 search_pagination">

                            {{ $bankings->links('pagination::tailwind') }}

                        </div>

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
            function updateBankingAjax(id, date, debit, credit, amount, reference, description) {

                $('#banking_id').val(id);
                $('#banking_date_edit').val(date);
                $('#banking_reference_edit').val(reference);
                $('#description_banking_edit').text(description);
                $('#amount_edit').val(amount);
                $('#type_banking_edit option').attr('selected', false);

                $('#type_banking_edit option').each(function () {
                    let option_value = $(this).attr('value');
                    if (parseInt(debit)) {
                        if (option_value == 'Debit') $(this).attr('selected', true)
                    }

                    if (parseInt(credit)) {
                        if (option_value == 'Credit') $(this).attr('selected', true)
                    }
                });
                $('#close_edit_banking').click();
            }
        </script>
