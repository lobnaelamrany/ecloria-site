@extends('layouts.app')
@section('title', 'Nouveau Retour — ÉCLORIA')

@section('content')
<div class="container py-5">
    <div class="section-title"><h2>Demande de retour</h2></div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4">
        <h6>Commande {{ $order->order_number }}</h6>
        <form method="POST" action="{{ route('returns.store', $order) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Raison du retour *</label>
                <textarea name="reason" class="form-control" rows="3" required>{{ old('reason') }}</textarea>
            </div>

            <h6 class="mt-4">Articles à retourner</h6>
            @foreach($order->items as $index => $item)
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $item->product_name }}</strong>
                        <span class="text-muted">Acheté: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} DH</span>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-4">
                            <input type="hidden" name="items[{{ $index }}][order_item_id]" value="{{ $item->id }}">
                            <label class="form-label small">Quantité à retourner</label>
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control form-control-sm" min="1" max="{{ $item->quantity }}" value="{{ $item->quantity }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">État</label>
                            <select name="items[{{ $index }}][item_condition]" class="form-select form-select-sm">
                                <option value="unopened">Non ouvert (revendable)</option>
                                <option value="opened">Ouvert</option>
                                <option value="damaged">Endommagé</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-ecloria-primary mt-3">Envoyer la demande</button>
            <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-outline-secondary mt-3 ms-2">Annuler</a>
        </form>
    </div>
</div>
@endsection
