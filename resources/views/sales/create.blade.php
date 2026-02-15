@extends('layout.mainlayout')

@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Vendre une voiture</h3>
        </div>
    </div>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" action="{{ route('sales.store') }}">
@csrf

{{-- ================= VEHICLE ================= --}}
<div class="form-group mb-3">
    <label class="form-label">Voiture approuvée</label>

    <select name="vehicle_id" class="form-control vehicle-select" required>
        <option value="">-- Sélectionner --</option>

        @foreach($vehiclesForSale as $vehicle)
        <option value="{{ $vehicle->id }}">
            {{ $vehicle->brand }} {{ $vehicle->model }}
            ({{ $vehicle->plate_number }})
        </option>
        @endforeach
    </select>
</div>

{{-- ================= CLIENT UNIQUE ================= --}}
<div class="form-group mb-3">
<label class="form-label">Client</label>

<div class="d-flex gap-2">

<select name="customer_id"
        id="customerSelect"
        class="form-control customer-select"
        required>

<option value="">-- Sélectionner un client --</option>

@foreach($customers as $customer)
<option value="{{ $customer->id }}">
    {{ $customer->name }} ({{ $customer->phone }})
</option>
@endforeach

</select>

<button type="button"
        class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#createCustomerModal">
    + Client
</button>

</div>
</div>

{{-- ================= PRIX ================= --}}
<div class="form-group mb-4">
<label class="form-label">Prix de vente</label>

<input type="number"
       name="sold_price"
       class="form-control"
       placeholder="Montant"
       required>
</div>

{{-- ================= SUBMIT ================= --}}
<button type="submit" class="btn btn-primary">
    <i class="ti ti-device-floppy me-1"></i>
    Confirmer la vente
</button>

</form>

</div>
</div>

</div>
</div>

{{-- ================= MODAL CREATE CUSTOMER ================= --}}
<div class="modal fade" id="createCustomerModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Créer Client</h5>
</div>

<div class="modal-body">

<input type="text"
       id="customerName"
       class="form-control mb-2"
       placeholder="Nom">

<input type="text"
       id="customerPhone"
       class="form-control mb-2"
       placeholder="Téléphone">

<input type="email"
       id="customerEmail"
       class="form-control"
       placeholder="Email">

<input type="text"
           name="address"
           class="form-control"
           placeholder="Adresse du client">

</div>

<div class="modal-footer">
<button type="button"
        class="btn btn-primary"
        onclick="createCustomer()">
    Enregistrer
</button>
</div>

</div>
</div>
</div>

{{-- ================= JS ================= --}}
<script>
function createCustomer()
{
    fetch("{{ route('customers.quickStore') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            name: document.getElementById('customerName').value,
            phone: document.getElementById('customerPhone').value,
            email: document.getElementById('customerEmail').value
        })
    })
    .then(res => res.json())
    .then(customer => {

        alert("Client créé avec succès");

        let select = document.getElementById('customerSelect');

        let option = new Option(
            customer.name + " (" + (customer.phone ?? '') + ")",
            customer.id,
            true,
            true
        );

        select.add(option);

        let modal = bootstrap.Modal.getInstance(
            document.getElementById('createCustomerModal')
        );
        modal.hide();
    })
    .catch(error => console.log(error));
}
</script>

@endsection
