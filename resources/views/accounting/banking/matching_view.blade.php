

        <div class="overflow-x-auto">
            <p class="p-4 text-gray-900">Matched Rs {{ number_format(abs($banking->amount - $total),2,".",",") }} out of Rs {{ number_format(abs($banking->amount),2,".",",") }}</p>
            <div class="align-middle inline-block min-w-full">
                <div  class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Item Matched
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Ordered
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
                        @foreach ($matching_petty_cashs as $matching_petty_cash)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    <a href="{{ url('petty_cash') }}">Petty Cash #{{ $matching_petty_cash->id }}</a>
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y', strtotime($matching_petty_cash->date)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format(abs($matching_petty_cash->amount),2,".",",") }}
                                </td>

                                <td class="p-4 whitespace-nowrap space-x-2">

                                    <form action="{{ route('delete-matching-petty-cash') }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                          style="margin:0">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_banking" value="{{ $matching_petty_cash->banking_matched }}">
                                        <input type="hidden" name="id_petty_cash" value="{{ $matching_petty_cash->id }}">

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
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($sales_payments as $sale_payment)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    <a href="{{ url('sales') }}?sale_id={{ $sale_payment->sales_id }}">Sale #{{ $sale_payment->sales_id }}</a>
                                    by
                                    <a href="{{ route('customer-details',$sale_payment->customer_id) }}"> {{ $sale_payment->customer_name }}</a>
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y', strtotime($sale_payment->date)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format(abs($sale_payment->amount),2,".",",") }}
                                </td>

                                <td class="p-4 whitespace-nowrap space-x-2">

                                    <form action="{{ route('delete-matching-banking-sales') }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                          style="margin:0">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_banking" value="{{ $sale_payment->matched_transaction }}">
                                        <input type="hidden" name="id_sale" value="{{ $sale_payment->sales_id }}">
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
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($bill_payments as $bill_payment)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    <a href="{{ url('bill') }}?bill_id={{ $bill_payment->bill_id }}">Bill #{{ $bill_payment->bill_id }}</a>
                                    by
{{--                                    <a href="{{ route('customer-details',$sale_payment->supplier_id) }}"> {{ $sale_payment->supplier_name }}</a>--}}
                                    {{ $bill_payment->supplier_name }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y', strtotime($bill_payment->date)) }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
                                    {{ number_format(abs($bill_payment->amount),2,".",",") }}
                                </td>

                                <td class="p-4 whitespace-nowrap space-x-2">

                                    <form action="{{ route('delete-matching-banking-bill') }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                          style="margin:0">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_banking" value="{{ $bill_payment->matched_transaction }}">
                                        <input type="hidden" name="id_bill" value="{{ $bill_payment->bill_id }}">

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
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
