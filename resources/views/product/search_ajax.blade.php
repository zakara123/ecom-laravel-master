<input type="hidden" id="total_p" value="{{ $products->total() }}">

<div class="bg-gray-100">
    <div class="align-middle inline-block relative bg-gray-100 overflow-x-auto max-w-full">
        <div class="shadow" id="over_flowing">
            <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="sortby p-4 w-24 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'id')selected @endif" data-sortby="id" data-orderby="@if($sb == 'id' && $ob == 'ASC')DESC @elseif($sb == 'id' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'id');">
                        Item ID
                    </th>
                    <th scope="col" class="sortby p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'position' )selected @endif" data-sortby="position"  data-orderby="@if($sb == 'position' && $ob == 'ASC')DESC @elseif($sb == 'position' && $ob == 'DESC')ASC @else ASC @endif"  onclick="sortItem(this,'position');">
                        Position
                    </th>
                    <th scope="col" class="sortby p-4 w-64 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'name' )selected @endif" data-sortby="name" data-orderby="@if($sb == 'name' && $ob == 'ASC') DESC @elseif($sb == 'name' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'name');">
                        Name
                    </th>
                    <th scope="col" class="sortby p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'price' )selected @endif" data-sortby="price" data-orderby="@if($sb == 'price' && $ob == 'ASC')DESC @elseif($sb == 'price' && $ob == 'DESC')ASC @else ASC @endif"  onclick="sortItem(this,'price');">
                        Selling Price
                    </th>
                    <th scope="col" class="sortby p-4 w-32 text-center text-xs font-medium text-gray-500 uppercase @if($sb == 'price_buying' )selected @endif" data-sortby="price_buying"  data-orderby="@if($sb == 'price_buying' && $ob == 'ASC')DESC @elseif($sb == 'price_buying' && $ob == 'DESC')ASC @else ASC @endif" onclick="sortItem(this,'price_buying');">
                        Buying Price
                    </th>
                    <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                        Category
                    </th>
{{--                    <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">--}}
{{--                        Supplier--}}
{{--                    </th>--}}
                    <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                        Created_At
                    </th>
                    <th scope="col" class="p-4 w-36 text-center text-xs font-medium text-gray-500 uppercase">
                        View Image
                    </th>
                    <th scope="col" class="p-4 w-40 text-center text-xs font-medium text-gray-500 uppercase">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-100">
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ $product->id }}
                        </td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ $product->position }}
                        </td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ $product->name }}
                        </td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ number_format($product->price,2,".",",") }} @if(!empty($product->unit_selling_label))
                                / {{$product->unit_selling_label}} @endif
                        </td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ number_format($product->price_buying,2,".",",") }}</td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            @if(count($product->categoryproduct) > 0)
                                @foreach ($product->categoryproduct as $category)
                                    @if ($loop->last)
                                        {{ $category->category_name }}
                                    @else
                                        {{ $category->category_name }},
                                    @endif
                                @endforeach
                            @else
                                {{ __('Uncategorized') }}
                            @endif
                        </td>
{{--                        <td class="p-4  text-center font-medium text-gray-900">--}}
{{--                            @if(isset($product->supplier))--}}
{{--                                {{ $product->supplier }}--}}
{{--                            @endif--}}
{{--                        </td>--}}
                        <td class="p-4  text-center font-medium text-gray-900">
                            {{ date('d/m/Y H:i', strtotime($product->created_at)) }}
                        </td>
                        <td class="p-4  text-center font-medium text-gray-900">
                            @if(isset($product->product_image) && !empty($product->product_image))
                                <div class="w-20 ml-4 mb-2">
                                    <img class="h-auto" src="{{$product->product_image->src}}" alt="">
                                </div>
                            @endif
                            <a href="/item-images/{{ $product->id }}"> Show</a>
                        </td>
                        <td class="p-4  space-x-2">
                            <a href="{{ route('item.edit', $product->id) }}"
                               class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                    </path>
                                    <path fill-rule="evenodd"
                                          d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                Edit item
                            </a>
                            <button onclick="get_stock('{{ $product->id }}','stock')"
                                    class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                Stock
                            </button>
                            <a href="{{ route('product', ['id' => $product->slug]) }}" target="_blank"
                               class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                Show
                            </a>
                            <form action="{{ route('item.destroy',$product->id) }}" method="POST"
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
                                    Delete Item
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">

                <div class="col-md-12 search_pagination">

                    {{ $products->links('pagination::tailwind') }}

                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.search_pagination .pagination li a').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            var actionUrl = $(this).attr('href');
            var filter_image = $('#filter_image').val();
            var filter_category = $('#filter_category').val();
            // var page_url = '&s=' + $('#search_input').val()+'&fs=' + filter_image;
            var sortby = $('.sortby.selected').data('sortby');
            var orderby = $('.sortby.selected').data('orderby');
            var page_url = '&s=' + $('#search_input').val() +'&fs=' + filter_image +'&category=' + filter_category;
            $.ajax({
                type: "GET",
                url: actionUrl + page_url, // serializes the form's elements.
                beforeSend: function () {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function (data) {
                    $('#item_field').html(data);
                }, error: function () {
                    console.log('Error');
                },
                complete: function () {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        });
    });

    function sortItem(element,id_sort) {
        $('.sortby').removeClass('selected');
        $(element).addClass('selected');
        var form = $('#form_search');
        var actionUrl = form.data('action');
        var search = $('#search_input').val();
        var orderby = $('.sortby.selected').data('orderby');
        var filter_image = $('#filter_image').val();
        var filter_category = $('#filter_category').val();
        var page_url = '?s=' + search + '&fs=' + filter_image+ '&category=' + filter_category +'&sortby=' + id_sort + '&orderby=' + orderby;
        setTimeout(function () {
            $.ajax({
                type: "GET",
                url: actionUrl + page_url,
                beforeSend: function () {
                    $('.overlay').removeClass('is-hidden');
                    $('#loader_ajax_filter').removeClass('is-hidden');
                },
                success: function (data) {
                    $('#item_field').html(data);
                    let total_p = $('#total_p').val();
                    $('#total_displayd').html(total_p);
                    // show response from the php script.
                }, error: function () {
                    console.log('Error');
                },
                complete: function () {
                    $('.overlay').addClass('is-hidden');
                    $('#loader_ajax_filter').addClass('is-hidden');
                }
            });
        }, 500);
    }
</script>
<script type="text/javascript">

    $('#over_flowing').overlayScrollbars({
        className            : "os-theme-dark",
        resize               : "none",
        sizeAutoCapable      : true,
        clipAlways           : true,
        normalizeRTL         : true,
        paddingAbsolute      : false,
        autoUpdate           : null,
        autoUpdateInterval   : 33,
        updateOnLoad         : ["img"],
        nativeScrollbarsOverlaid : {
            showNativeScrollbars   : false,
            initialize             : true
        },
        overflowBehavior : {
            x : "scroll",
            y : "scroll"
        },
        scrollbars : {
            visibility       : "auto",
            autoHide         : "never",
            autoHideDelay    : 800,
            dragScrolling    : true,
            clickScrolling   : false,
            touchSupport     : true,
            snapHandle       : false
        },
        textarea : {
            dynWidth       : false,
            dynHeight      : false,
            inheritedAttrs : ["style", "class"]
        },
        callbacks : {
            onInitialized               : null,
            onInitializationWithdrawn   : null,
            onDestroyed                 : null,
            onScrollStart               : null,
            onScroll                    : null,
            onScrollStop                : null,
            onOverflowChanged           : null,
            onOverflowAmountChanged     : null,
            onDirectionChanged          : null,
            onContentSizeChanged        : null,
            onHostSizeChanged           : null,
            onUpdated                   : null
        }
    });

</script>
