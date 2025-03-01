@foreach ($bills as $bill)
    <option value="{{ $bill->id }}"> Bill {{ $bill->id }} - {{ date('d/m/Y H:i', strtotime($bill->created_at)) }} - Rs {{ number_format($bill->amount,2,".",",") }} </option>
@endforeach
