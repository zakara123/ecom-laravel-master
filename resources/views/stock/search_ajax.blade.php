<div class="overflow-x-auto">
    <div class="shadow" id="over_flowing">
        <table class="table-fixed min-w-full divide-y divide-gray-200">
            <table class="table-fixed min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="p-4 w-44 text-center text-xs font-medium text-gray-500 uppercase">
                            ID
                        </th>
                        {{-- <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                            Product ID
                        </th> --}}
                        <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                            Product
                        </th>
                        <th scope="col" class="p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase">
                            Product Variation
                        </th>
                        <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                            Store
                        </th>
                        <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                            Current Stock
                        </th>
                        <th scope="col" class="p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase">
                            Stock Take
                        </th>
                        <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                            SKU
                        </th>
                        <th scope="col" class="p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase">
                            Barcode
                        </th>
                        <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                            Date Received
                        </th>
                        <th scope="col" class="p-4 w-40  text-center text-xs font-medium text-gray-500 uppercase">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($stocks as $stock)
                        <tr class="hover:bg-gray-100">
                            <td class="p-4  text-center font-medium text-gray-900">
                                Stock : {{ $stock->id }}<br>
                                Product : {{ $stock->products_id }}<br>
                                Variation : @if (isset($stock->id) && $stock->id)
                                    @foreach ($stock->productVariationId as $variation)
                                        <div>{{ $variation->id }}</div>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="p-4 text-center font-medium text-gray-900">
                                {{ $stock->products_id }}
                            </td>
                            <td class="p-4 text-center font-medium text-gray-900">
                                {{ $stock->product_name }}
                            </td>
                            <td class="p-4  text-center font-medium text-gray-900">
                                @if (count($stock->variation_value_delete) == 0)
                                    <i>( No Variation )</i>
                                @else
                                    @foreach ($stock->variation_value_delete as $key => $var)
                                        {{ $var['attribute'] }}:{{ $var['attribute_value'] }}
                                        @if ($key !== array_key_last($stock->variation_value_delete))
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="p-4  text-center font-medium text-gray-900">
                                {{ $stock->name }}
                            </td>
                            <td class="p-4  text-center font-medium text-gray-900">
                                {{ $stock->quantity_stock }}
                            </td>
                            <td class="p-2  text-center font-medium text-gray-900">
                                <form method="POST" action="{{ route('stock.stock_take', $stock->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="quantity"
                                        class="w-full form-control bg-white bg-clip-padding border border-solid border-gray-300 rounded"
                                        placeholder="Qty">
                                    <button type="submit" name="stock_take"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-1 text-center mt-2"
                                        style="background-color:green">Take</button>
                                    <button type="submit" name="stock_add"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-1 text-center mt-2"
                                        style="background-color:green">Add</button>
                                </form>
                            </td>
                            <td class="p-4 text-center font-medium text-gray-900">
                                <form method="POST" action="{{ route('stock.update_sku', $stock->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="sku"
                                        class="w-full form-control bg-white bg-clip-padding border border-solid border-gray-300 rounded"
                                        placeholder="SKU" value="{{ $stock->sku }}">
                                    <button type="submit"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-1 text-center mt-2"
                                        style="background-color:green">Update</button>
                                </form>
                            </td>
                            <td class="p-4  font-medium text-gray-900">
                                {!! $stock->barcode_image !!}
                            </td>
                            <td class="p-4  text-center font-medium text-gray-900">
                                @if (!empty($stock->date_received))
                                    {{ date('d/m/Y', strtotime($stock->date_received)) }}
                                @endif
                            </td>
                            <td class="p-2  text-center font-medium text-gray-900">
                                <button onclick="get_stock_history('{{ $stock->id }}')"
                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="mr-1 h-5 w-5" viewBox="0 0 18 18">
                                        <path
                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                        <path
                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                    </svg>
                                    Stock History
                                </button><br>
                                <a href="{{ route('stock.edit', $stock->id) }}"
                                    class="text-white mt-1 bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST"
                                    onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                    style="margin:0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <button type="submit"
                                        class="mt-1 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 search_pagination">
                    {{ $stocks->links('pagination::tailwind') }}
                </div>
            </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.search_pagination .pagination li a').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var actionUrl = $(this).attr('href');
            var page_url = '&s=' + $('#search_input').val();
            $.ajax({
                type: "GET",
                url: actionUrl + page_url, // serializes the form's elements.
                beforeSend: function() {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function(data) {
                    $('#item_field').html(data);
                },
                error: function() {
                    console.log('Error');
                },
                complete: function() {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        });
    });
</script>
