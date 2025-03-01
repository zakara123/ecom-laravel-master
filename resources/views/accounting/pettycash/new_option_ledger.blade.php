@if($ledger && isset($ledger))
    <option value="{{ $ledger->id }}" selected>{{ $ledger->name }}</option>
@endif
