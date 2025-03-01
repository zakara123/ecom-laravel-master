

        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div  class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Journal ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Debit
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Credit
                            </th>

                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Description
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Amount
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($journals as $journal)
                            <tr class="hover:bg-gray-100 " @if ($journal->credit)) style="border-top: none" @endif>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if ($journal->debit || ($journal->is_double <= 1))
                                        {{ $journal->journal_id }}
                                    @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if ($journal->debit || ($journal->is_double <= 1))
                                        {{ $journal->name }}
                                    @endif
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if ($journal->debit || ($journal->is_double <= 1))
                                        {{ date('d/m/Y H:i', strtotime($journal->date)) }}
                                    @endif
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    @if(isset($journal->debit_name ))
                                        <a href="{{ route('ledger.show',$journal->debit) }}">
                                            {{ $journal->debit_name }}
                                        </a>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    @if(isset($journal->credit_name ))
                                        <a href="{{ route('ledger.show',$journal->credit) }}">
                                            {{ $journal->credit_name }}
                                        </a>
                                    @endif
                                </td>

                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ $journal->description }}
                                </td>

                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ number_format($journal->amount,2,".",",") }}
                                </td>

                                <td class="p-4 whitespace-wrap space-x-2">
                                    @if ($journal->debit || ($journal->is_double <= 1))
                                        <a href="{{ route('journal.edit', $journal->id) }}"
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
                                        </a>
                                        <form action="{{ route('journal.destroy',$journal->journal_id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-md-12 search_pagination">

                            {{ $journals->links('pagination::tailwind') }}

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
