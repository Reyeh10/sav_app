@extends('layout.mainlayout')

@section('content')

<!--div class="page-wrapper">
    <div class="content"-->

        {{-- ✅ Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <!-- ✅ HEADER STYLE LOGISTIQUE (comme Vehicles) -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">

            <!-- LEFT : Title + Breadcrumb -->
            <div>
                <h2 class="mb-1">Clients</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ti ti-users"></i></a>
                    </li>
                    <li class="breadcrumb-item active">
                        Liste des clients
                    </li>
                </ol>
            </div>

            <!-- RIGHT : Actions -->
            <div class="d-flex align-items-center gap-2">

                {{-- ✅ Ajouter Client --}}
                @if(auth()->user()->isAdmin() || auth()->user()->isVendeur())
                <!--a href="{ { route('customers.create') }}"
                   class="btn btn-primary">
                    <i class="ti ti-circle-plus me-2"></i>
                    Ajouter client
                </a-->
                @endif


                {{-- ✅ Import Excel --}}
                @if(auth()->user()->isAdmin() || auth()->user()->isVendeur())
                <button class="btn btn-outline-success"
                        data-bs-toggle="modal"
                        data-bs-target="#importCustomerExcelModal">
                    📥 Importer Excel
                </button>
                @endif

            </div>

        </div>


        {{-- ✅ TABLE CLIENTS --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">

                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($customers as $customer)
                            <tr>

                                <!-- Avatar + Nom -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-2">
                                            <img src="{{ asset('admintemplate/assets/img/profiles/avatar-02.jpg') }}"
                                                 class="rounded-circle"
                                                 alt="Img">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $customer->name }}</h6>
                                            <small class="text-muted">
                                                Client #{{ $customer->id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>{{ $customer->email ?? '-' }}</td>
                                <td>{{ $customer->address ?? '-' }}</td>


                                <!-- Actions -->
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Edit --}}
                                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'vendeur')
                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        @endif

                                        {{-- Delete --}}
                                        @if(auth()->user()->role == 'admin')
                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Supprimer ce client ?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted p-4">
                                    Aucun client enregistré
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>


        {{-- ✅ IMPORT EXCEL MODAL --}}
        <div class="modal fade" id="importCustomerExcelModal" tabindex="-1">
            <div class="modal-dialog">

                <form action="{{ route('customers.import') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Importer une liste de clients (Excel)
                            </h5>
                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                            </button>
                        </div>

                        <div class="modal-body">
                            <label class="form-label">
                                Choisir un fichier Excel (.xlsx)
                            </label>

                            <input type="file"
                                   name="file"
                                   class="form-control"
                                   accept=".xlsx,.xls"
                                   required>

                            <small class="text-muted d-block mt-2">
                                Format attendu :
                                Nom | Téléphone | Email | Adresse
                            </small>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Importer
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>


    <!--/div>
</div-->

@endsection
