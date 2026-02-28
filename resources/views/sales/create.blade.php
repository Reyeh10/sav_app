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
<!--div class="form-group mb-3">
    <label class="form-label">Voiture approuvée</label-->
    <div class="form-group mb-3">
    <label class="form-label">Voiture approuvée</label>

    <select name="vehicle_id" class="form-control vehicle-select" required>
        <option value="">-- Sélectionner --</option>

        @foreach($vehiclesForSale as $v)
            <option value="{{ $v->id }}"
                {{ isset($vehicle) && $vehicle->id == $v->id ? 'selected' : '' }}>
                {{ $v->brand }} {{ $v->model }}
                ({{ $v->plate_number ?? $v->vin }})
            </option>
        @endforeach

    </select>
</div>
<!--/div-->

{{-- ================= TYPE CLIENT ================= --}}
<div class="form-group mb-3">
    <label class="form-label">Type de client *</label>
    <select name="type_client"
            id="saleTypeClient"
            class="form-control"
            required>
        <option value="">-- Sélectionner le type --</option>
        <option value="Particulier">Particulier</option>
        <option value="Gouvernement">Gouvernement</option>
        <option value="Para-public">Para-public</option>
        <option value="Privee">Privée</option>
    </select>
</div>

{{-- ================= CLIENT ================= --}}
<div class="form-group mb-3">
<label class="form-label">Client</label>

<div class="d-flex gap-2">

<select name="customer_id"
                id="customerSelect"
                class="form-control customer-select">

        <option value="">-- Sélectionner un client existant --</option>

        @foreach($customers as $customer)
        <option value="{{ $customer->id }}">
            {{  $customer->name }} ({{ $customer->phone }})
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

<small class="text-muted">
    Si le client n’existe pas, créez-le avec le bouton + Client
</small>
</div>

{{-- ================= PRIX ================= --}}
<div class="form-group mb-4">
<label class="form-label">Prix de vente</label>
<!--input type="number"
       name="sold_price"
       class="form-control"
       placeholder="Montant"
       required-->
<input type="number"
       name="sold_price"
       class="form-control"
       step="0.01"
       min="0"
       value="{{ old('sold_price') }}"
       required>
</div>


{{-- ================= TYPE DE PAIEMENT ================= --}}
<div class="form-group mb-3">
    <label class="form-label">Type de paiement *</label>

    <select name="payment_type"
        class="form-select payment-select"
        required>
        <option value="">-- Sélectionner le type de paiement --</option>
        <option value="Cash">Cash</option>
        <option value="Bon de commande">Bon de commande</option>
        <option value="Echeance">Échéance</option>
    </select>
</div>

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
       class="form-control mb-3"
       placeholder="Nom"
       required>

<select id="customerType"
        class="form-select typeclient-select mb-3"
        required>
    <option value="" selected disabled>-- Type de client --</option>
    <option value="Particulier">Particulier</option>
    <option value="Gouvernement">Gouvernement</option>
    <option value="Para-public">Para-public</option>
    <option value="Privee">Privée</option>
</select>

<input type="text"
       id="customerPhone"
       class="form-control mb-3"
       placeholder="77 12 34 56"
       required>

<input type="email"
       id="customerEmail"
       class="form-control mb-3"
       placeholder="exemple@gmail.com"
       required>

<input type="text"
       id="customerAddress"
       class="form-control mb-3"
       placeholder="Adresse du client"
       required>

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

{{-- ================= JAVASCRIPT COMPLET ================= --}}


<script>

function createCustomer()
{
    let name = $('#customerName').val().trim();
    let type = $('#customerType').val();
    let phone = $('#customerPhone').val().trim();
    let email = $('#customerEmail').val().trim();
    let address = $('#customerAddress').val().trim();

    if (!name || !type || !phone || !email || !address) {
        Swal.fire({
            icon: 'error',
            title: 'Champs obligatoires',
            text: 'Veuillez remplir tous les champs.'
        });
        return;
    }

    // Validation téléphone Djibouti
    let phonePattern = /^\d{2}\s\d{2}\s\d{2}\s\d{2}$/;
    if (!phonePattern.test(phone)) {
        Swal.fire('Erreur', 'Format téléphone : 77 12 34 56', 'error');
        return;
    }

    // Validation email
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        Swal.fire('Erreur', 'Email invalide.', 'error');
        return;
    }

    fetch("{{ route('customers.quickStore') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json", // ✅ important pour forcer Laravel à renvoyer du JSON
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({
        name: name,
        type_client: type,
        phone: phone,
        email: email,
        address: address
    })
})
.then(async (response) => {

    const contentType = response.headers.get("content-type") || "";
    const isJson = contentType.includes("application/json");
    const data = isJson ? await response.json() : null;

    // ✅ 419 = CSRF / session expirée
    if (response.status === 419) {
        Swal.fire({
            icon: "warning",
            title: "Session expirée",
            text: "Veuillez actualiser la page puis réessayer."
        });
        return;
    }

    // ✅ 422 = validation
    if (response.status === 422 && data && data.errors) {

        // doublon nom/email
        if (data.errors.name || data.errors.email) {
            Swal.fire({
                icon: "error",
                title: "Client déjà existant",
                text: "Le nom ou l’email existe déjà."
            });
            return;
        }

        // autres validations
        const messages = Object.values(data.errors).flat().join("<br>");
        Swal.fire({
            icon: "error",
            title: "Erreur de validation",
            html: messages
        });
        return;
    }

    // ✅ autres erreurs (500, 404, etc.)
    if (!response.ok) {
        Swal.fire({
            icon: "error",
            title: "Erreur",
            text: "Impossible de créer le client. Veuillez réessayer."
        });
        return;
    }

    // ✅ succès
    if (data && data.success) {
        const customer = data.customer;

        const select = document.getElementById("customerSelect");
        const option = new Option(
            customer.name + " (" + customer.phone + ")",
            customer.id,
            true,
            true
        );

        select.add(option);
        select.value = customer.id;

        document.getElementById("saleTypeClient").value = customer.type_client;

        Swal.fire({
            icon: "success",
            title: "Client créé",
            timer: 1200,
            showConfirmButton: false
        });

        bootstrap.Modal.getInstance(document.getElementById("createCustomerModal")).hide();

        $("#customerName").val("");
        $("#customerType").val(null).trigger("change");
        $("#customerPhone").val("");
        $("#customerEmail").val("");
        $("#customerAddress").val("");
        return;
    }

    // fallback si format inattendu
    Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "Réponse inattendue du serveur."
    });

})
.catch(() => {
    // ✅ si vraiment erreur réseau (serveur arrêté, etc.)
    Swal.fire({
        icon: "error",
        title: "Erreur réseau",
        text: "Impossible de contacter le serveur."
    });
});

}

// Auto format téléphone Djibouti
document.getElementById('customerPhone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.substring(0, 8);
    let formatted = value.replace(/(\d{2})(?=\d)/g, '$1 ');
    e.target.value = formatted.trim();
});


// Auto format téléphone Djibouti
document.getElementById('customerPhone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.substring(0, 8);
    let formatted = value.replace(/(\d{2})(?=\d)/g, '$1 ');
    e.target.value = formatted.trim();
});

</script>

@endsection
