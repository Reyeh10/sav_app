@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
    <div class="content"-->

        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">Modifier le prix de vente</h4>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('vehicles.updatePrice', $vehicle->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Prix de vente</label>

                        <input type="text"
                            name="sold_price"
                            class="form-control"
                            value="{{ old('sold_price', $vehicle->sale?->sold_price) }}"
                            placeholder="Ex: 1000000,50"
                            inputmode="decimal"
                            required>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Client</label>

                        <select name="customer_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>

                            @foreach(\App\Models\Customer::all() as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $vehicle->sale?->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            Enregistrer
                        </button>

                        <a href="{{ route('vehicles.sold') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
