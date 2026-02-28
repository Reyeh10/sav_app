@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
    <div class="content"-->

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div>
                <h2 class="mb-1">Ajouter un client</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ti ti-users"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Clients</li>
                </ol>
            </div>

            <a href="{{ route('customers.index') }}" class="btn btn-light">
                ← Retour
            </a>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <!-- Nom -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Type de client -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type de client *</label>
                            <select name="type_client"
                                    class="form-control @error('type_client') is-invalid @enderror"
                                    required>

                                <option value="">-- Sélectionner --</option>
                                <option value="Particulier" {{ old('type_client')=='Particulier'?'selected':'' }}>Particulier</option>
                                <option value="Gouvernement" {{ old('type_client')=='Gouvernement'?'selected':'' }}>Gouvernement</option>
                                <option value="Para-public" {{ old('type_client')=='Para-public'?'selected':'' }}>Para-public</option>
                                <option value="Privee" {{ old('type_client')=='Privee'?'selected':'' }}>Privée</option>
                            </select>

                            @error('type_client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <!-- Adresse -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="address" class="form-control">
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-4">
                        <button type="reset" class="btn btn-light">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>

                </form>

            </div>
        </div>

    <!--/div>
</div-->

@endsection
