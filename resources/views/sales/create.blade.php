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
                <option
                    value="{{ $customer->id }}"
                    data-type="{{ $customer->type_client }}"
                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                >
                    {{ $customer->name }} ({{ $customer->phone ?? 'N/A' }})
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

<input type="text"
       name="sold_price"
       class="form-control"
       inputmode="decimal"
       placeholder="9800000,99"
       value="{{ old('sold_price') }}"
       required>
</div>


{{-- ================= TYPE DE PAIEMENT ================= --}}
<div class="form-group mb-3">
    <label class="form-label">Type de paiement *</label>

    <select name="payment_type"
            class="form-select payment-select">

        <option value="">-- Sélectionner le type de paiement --</option>

        <option value="Cash">Cash</option>
        <option value="Bon de commande">Bon de commande</option>
        <option value="Echeance">Échéance</option>

    </select>

    @error('payment_type')
        <div class="text-danger mt-1">
            {{ $message }}
        </div>
    @enderror
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
        onclick="createCustomer(event)">
    Enregistrer
</button>
</div>

</div>
</div>
</div>

{{-- ================= JAVASCRIPT COMPLET ================= --}}


<script>

async function createCustomer(event)
{
    if (event) event.preventDefault();

    // 🔹 Récupération sécurisée
    let name     = ($('#customerName').val() || '').trim();
    let type     = ($('#customerType').val() || '').trim();
    let phoneRaw = ($('#customerPhone').val() || '').trim();
    let emailRaw = ($('#customerEmail').val() || '').trim();
    let address  = ($('#customerAddress').val() || '').trim();

    // 🔹 Normaliser email
    let email = emailRaw !== '' ? emailRaw.toLowerCase() : null;

    // 🔹 Nettoyage téléphone
    let phone = phoneRaw.replace(/[\s\-()]/g, '');

    if (phone.startsWith("00")) {
        phone = "+" + phone.substring(2);
    }

    if (phone === '') {
        phone = null;
    }

    $('#customerPhone').val(phone || '');

    // ================= VALIDATIONS =================

    if (!name) {
        Swal.fire({
            icon: 'error',
            title: 'Nom obligatoire',
            text: 'Veuillez saisir le nom du client.'
        });
        return;
    }

    if (!type) {
        Swal.fire({
            icon: 'error',
            title: 'Type obligatoire',
            text: 'Veuillez sélectionner le type de client.'
        });
        return;
    }

    if (phone !== null) {
        let phonePattern = /^\+[1-9]\d{1,14}$/;
        if (!phonePattern.test(phone)) {
            Swal.fire({
                icon: 'error',
                title: 'Téléphone invalide',
                text: 'Format international requis. Exemple : +25377123456'
            });
            return;
        }
    }

    if (email !== null) {
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Email invalide',
                text: 'Veuillez entrer un email valide.'
            });
            return;
        }
    }

    // 🔒 Bloquer bouton pour éviter double clic
    const btn = event?.target;
    if (btn) btn.disabled = true;

    try {

        const response = await fetch("{{ route('customers.quickStore') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                name: name,
                type_client: type,
                phone: phone,
                email: email,
                address: address || null
            })
        });

        const contentType = response.headers.get("content-type") || "";
        const isJson = contentType.includes("application/json");
        const data = isJson ? await response.json() : null;

        // Session expirée
        if (response.status === 419) {
            Swal.fire({
                icon: "warning",
                title: "Session expirée",
                text: "Veuillez actualiser la page puis réessayer."
            });
            return;
        }

        // Validation Laravel
        if (response.status === 422 && data?.errors) {

                const errors = data.errors;

                let message = '';

                // 🔥 Priorité au nom
                if (errors.name) {
                    message = errors.name[0];
                }
                else if (errors.email) {
                    message = errors.email[0];
                }
                else if (errors.phone) {
                    message = errors.phone[0];
                }
                else if (errors.type_client) {
                    message = errors.type_client[0];
                }
                else {
                    message = Object.values(errors)[0][0];
                }

                Swal.fire({
                    icon: "error",
                    title: "Erreur de validation",
                    text: "Ce nom ou cet email existe déjà."
                });

                return;
            }
        // ================= SUCCÈS =================

        if (data?.success) {

            const customer = data.customer;
            const select = document.getElementById("customerSelect");

            if (select) {
                const option = new Option(
                    customer.name + (customer.phone ? " (" + customer.phone + ")" : ""),
                    customer.id,
                    true,
                    true
                );

                select.add(option);
                select.value = customer.id;
            }

            const saleType = document.getElementById("saleTypeClient");
            if (saleType) {
                saleType.value = customer.type_client;
            }

            Swal.fire({
                icon: "success",
                title: "Client créé avec succès",
                timer: 1200,
                showConfirmButton: false
            });

            const modalEl = document.getElementById("createCustomerModal");
            if (modalEl) {
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance?.hide();
            }

            // Reset champs
            $("#customerName").val("");
            $("#customerType").val("");
            $("#customerPhone").val("");
            $("#customerEmail").val("");
            $("#customerAddress").val("");
        }

    } catch (error) {

        Swal.fire({
            icon: "error",
            title: "Erreur réseau",
            text: "Impossible de contacter le serveur."
        });

    } finally {

        if (btn) btn.disabled = false;
    }
}

</script>

@endsection
