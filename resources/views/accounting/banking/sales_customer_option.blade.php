@foreach ($sales as $sale)
    <option value="{{ $sale->id }}"> Sale {{ $sale->id }} - {{ date('d/m/Y H:i', strtotime($sale->created_at)) }} - Rs {{ number_format($sale->amount,2,".",",") }} </option>
@endforeach
