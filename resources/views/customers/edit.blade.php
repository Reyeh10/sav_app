@extends('layout.mainlayout')

@section('content')

        <div class="page-header mb-4">
            <h3 class="page-title">Modifier Client</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="name"
                            class="form-control"
                            value="{{ $customer->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Téléphone</label>
                        <input type="text" name="phone"
                            class="form-control"
                            value="{{ $customer->phone }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                            class="form-control"
                            value="{{ $customer->email }}">
                    </div>

                    <div class="mb-3">
                        <label>Adresse</label>
                        <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
                    </div>

                    <button class="btn btn-primary">✅ Enregistrer</button>
                </form>

            </div>
        </div>

@endsection
