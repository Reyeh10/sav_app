@extends('layout.mainlayout')

@section('content')

        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Vendre une voiture</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/vehicles') }}">Gestion des voitures</a>
                        </li>
                        <li class="breadcrumb-item active">Vente</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <form method="POST" action="{{ route('sales.store') }}">
                            @csrf

                            {{-- ✅ Voiture --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Voiture approuvée</label>

                                <select name="vehicle_id"
                                        class="form-control vehicle-select"
                                        required>

                                    <option value="">-- Sélectionner --</option>

                                    @foreach($vehiclesForSale as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->brand }} {{ $vehicle->model }}
                                            ({{ $vehicle->plate_number }})
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- ✅ Client --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Client</label>

                               <select name="customer_id"
                                    class="form-control customer-select"
                                    required>
                                <option value="">-- Sélectionner un client --</option>

                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }} ({{ $customer->phone }})
                                    </option>
                                @endforeach
                            </select>

                            </div>


                            {{-- ✅ Prix --}}
                            <div class="form-group mb-4">
                                <label class="form-label">Prix de vente</label>

                                <input type="number"
                                    name="sold_price"
                                    class="form-control"
                                    placeholder="Montant"
                                    required>
                            </div>

                            {{-- ✅ Bouton --}}
                            <!--button type="submit" class="btn btn-orange">
                                ✅ Confirmer la vente
                            </button-->
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Confirmer la vente
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>

@endsection
