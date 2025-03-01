@if(isset($search_product) && $search_product != '')
<div class="flex items-center justify-between mb-5 relative lg:mb-10 px-4">
    <p class="text-sm lg:text-base"><span class="js-adv-filter__results-count">Search results for {{ $search_product }}  </span></p>
</div>
@endif
@if(count($products) > 0)
    <div class="flex items-center justify-between mb-5 relative lg:mb-10 px-4">
        <p class="text-sm lg:text-base"><span class="js-adv-filter__results-count">Displaying @if($last != $first ){{ $first }}-{{ $last }} @else {{ $last }} @endif of {{ $products_all }}</span> products
            @if(!empty($filter_by)) filtered by {{ $filter_by }}  @endif @if(empty($filter_by) && !empty($filter_filter)) filtered by   @endif @if(!empty($filter_filter)) {{ $filter_filter }}   @endif</p>
    </div>
    <ul class="grid w-full max-w-full sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-3 relative js-adv-filter__gallery" id="adv-filter-gallery">
        @foreach ($products as $product)
        <li class="bg-white bg-contrast-lower min-h-64 flex justify-center items-center relative md:p-3 item_product_filter">
            <div class="flex bg-white gap-2 lg:gap-2 flex-wrap justify-center ">
                <div class="flex flex-col">
                    <a href="{{ route('product', ['id' => $product->slug]) }}">
                        <img class="hover:grow hover:shadow-lg h-64 sm:w-80 md:w-full lg:w-w-full object-scale-down "
                         @if(isset($product->product_image) && !empty($product->product_image))
                        src="{{ $product->product_image->src }}"
                        @else
                            @if(isset($company) && isset($company->logo) && !empty($company->logo))
                                src="{{@$company->logo}}"
                            @else
                                src="{{url('front/img/ECOM_L.png')}}"
                            @endif
                        @endif>
                    </a>
                    <a href="{{ route('product', ['id' => $product->slug]) }}">
                        <div class="pt-3 flex items-center justify-between cursor-pointer">
                                @if (str_contains(request()->getSchemeAndHttpHost(), 'bata'))
                                    @if (!empty($product['product_api']->description))
                                        {{$product['product_api']->description}}
                                    @else
                                        @if($product->description)
                                            {!! $product->description !!}
                                        @else
                                            {{ $product->name }}
                                        @endif
                                    @endif
                                @else
                                    <p class="">  {{ $product->name }}</p>
                                @endif
                            <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style='display:none' onclick="">
                                <path d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z"></path>
                                <circle cx="10.5" cy="18.5" r="1.5"></circle>
                                <circle cx="17.5" cy="18.5" r="1.5"></circle>
                            </svg>
                        </div>
                    </a>
                    @if(isset($product->product_api->price->original_price) && isset($product->product_api->price->current_price) && $product->product_api->price->current_price != $product->product_api->price->original_price)
                        <div class="pt-1 flex text-gray-900"><div class="w-fit mr-2 font-sizes">Rs {{ number_format($product->product_api->price->current_price,2,".",",") }}</div> <div class="italic w-fit strike font-sizes">Rs {{ number_format($product->product_api->price->original_price,2,".",",") }}</div></div>
                    @else
                        <p class="pt-1 text-gray-900">Rs {{ number_format($product->price,2,".",",") }}</p>
                    @endif
                </div>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="md:flex lg:flex xl:flex 2xl:flex">
        <div id="pagination" class="text-center relative sm:w-full mt-4 mx-auto lg:pt-6 sm:pt-4 max-w-xs">
            {{ $products->links("pagination::shop_pagination") }}
        </div>
    </div>
@else
<ul class="grid grid-cols-12 gap-2 lg:gap-3 " id="adv-filter-gallery">
<div class="mt-5 lg:mt-8 w-full" id="adv-filter-gallery">
    <p class="text-contrast-medium text-center  lg:whitespace-nowrap" id="no_product">No results</p>
</div>
</ul>
@endif
<div id="loader_ajax_filter" class="is-hidden">
    <div class="circle-loader circle-loader--v1 " role="alert">
        <p class="circle-loader__label">Item(s)s is loading...</p>
        <div aria-hidden="true">
          <div class="circle-loader__circle"></div>
        </div>
      </div>

</div>

