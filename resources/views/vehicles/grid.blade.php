@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div>
                <h2 class="mb-1">Grille des voitures</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('vehicles.index') }}">
                            <i class="ti ti-car"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Grille des voitures</li>
                </ol>
            </div>

            {{-- Ajouter voiture → Admin + Logistique seulement --}}
            @if(in_array(auth()->user()->role, ['admin','logistique']))
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <i class="ti ti-circle-plus me-2"></i> Ajouter une voiture
                </a>
            @endif
        </div>

        <!-- Grid -->
<div class="row">

@foreach($vehicles as $vehicle)

    <!-- ================= CARD ================= -->
    <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
        <div class="card flex-fill shadow-sm border-0">

            <div class="card-body text-center">

                <!-- IMAGE VOITURE -->
                <div class="mb-3">

                    @if(!empty($vehicle->image))

                        <img src="{{ asset('storage/'.$vehicle->image) }}"
                            class="img-fluid rounded shadow-sm vehicle-image"
                            style="height:60px;width:40%;object-fit:cover;cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal{{ $vehicle->id }}"
                            alt="Vehicle Image">

                    @else

                        <span class="avatar avatar-xl bg-light rounded-circle shadow-sm">
                            <i class="ti ti-car text-primary fs-1"></i>
                        </span>

                    @endif

                </div>

                <!-- Vehicle Info -->
                <h5 class="mb-1 fw-semibold">
                    {{ $vehicle->brand }} {{ $vehicle->model }}
                </h5>

                <p class="text-muted small mb-2">
                    VIN : {{ $vehicle->vin }}
                </p>

                <!-- Stats -->
                <div class="d-flex justify-content-around mb-3">

                    <div>
                        <p class="mb-0 text-muted fs-12">Année</p>
                        <h6 class="fw-semibold">{{ $vehicle->year }}</h6>
                    </div>

                    <div>
                        <p class="mb-0 text-muted fs-12">KM</p>
                        <h6 class="fw-semibold">{{ number_format($vehicle->mileage) }}</h6>
                    </div>

                    <div>
                        <p class="mb-0 text-muted fs-12">Statut</p>

                        @php
                            $badge = match($vehicle->status){
                                'draft' => 'bg-secondary',
                                'approved' => 'bg-success',
                                'sold' => 'bg-warning',
                                'rejected' => 'bg-danger',
                                default => 'bg-dark'
                            };
                        @endphp

                        <span class="badge {{ $badge }} px-3 py-2">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </div>

                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-center gap-2">

                    <!-- VIEW -->
                    <a href="{{ route('vehicles.show', $vehicle->id) }}"
                       class="btn btn-sm btn-info">
                        <i class="ti ti-eye"></i>
                    </a>

                    <!-- EDIT -->
                    @if(in_array(auth()->user()->role, ['admin','logistique','mecanicien']))
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                           class="btn btn-sm btn-warning">
                            <i class="ti ti-edit"></i>
                        </a>
                    @endif

                    <!-- DELETE -->
                    @if(auth()->user()->role == 'admin')
                        <form method="POST"
                              action="{{ route('vehicles.destroy', $vehicle->id) }}">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        </div>
    </div>


    <!-- ================= MODAL IMAGE ================= -->
    @if(!empty($vehicle->image))
    <div class="modal fade"
         id="imageModal{{ $vehicle->id }}"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">

                <div class="modal-body text-center p-0">
                    <img src="{{ asset('storage/'.$vehicle->image) }}"
                         class="img-fluid rounded shadow-lg">
                </div>

            </div>
        </div>

    </div>
    @endif

@endforeach

</div>


    </div>
</div>

@endsection
