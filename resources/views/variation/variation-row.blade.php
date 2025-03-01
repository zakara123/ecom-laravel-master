<tr class="hover:bg-gray-100">
    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">{{ $variation->id }}</td>
    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">
        @foreach ($variation->attributes as $attribute)
            @php
                // Get the selected values for the current attribute
                $selectedValues = $attribute->attributeValues->filter(function ($value) use ($attribute) {
                    return $attribute->pivot->attribute_value_id == $value->id;
                })->pluck('attribute_values')->join(', ');

                // If there are no selected values, set an empty string
                $displayValues = $selectedValues ? $selectedValues : '';
            @endphp
            {{ $attribute->attribute_name }}: {{ $displayValues }}
            @if (!$loop->last)
                |
            @endif
        @endforeach
        @if(count($variation->attributes) == 0)
            <i>( No Variation )</i>
        @endif
    </td>
    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs {{ number_format($variation->price,2,".",",") }}</td>
    <td class="p-4 whitespace-nowrap text-center font-medium text-gray-900">Rs {{ number_format($variation->price_buying,2,".",",") }}</td>
    <td class="p-4 text-center font-medium flex justify-center items-center text-gray-900">
        @if(!empty($variation->variationThumbnail))<img src="{{ $variation->variationThumbnail->src }}" class="img-responsive" alt="" width="150" height="150">@endif
    </td>
    <td>
        <a href="{{ route('variation.edit', $variation->id) }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
            </svg>
            Edit
        </a>
        <form action="{{ route('variation.destroy', $variation->id) }}" method="POST" onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Delete
            </button>
        </form>
    </td>
</tr>
