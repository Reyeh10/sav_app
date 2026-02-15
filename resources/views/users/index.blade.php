@extends('layout.mainlayout')

@section('content')

<div class="page-wrapper">
<div class="content">

<!-- HEADER + BOUTON ADD USER -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <h3 class="mb-0">Gestion des utilisateurs</h3>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="ti ti-user-plus me-1"></i>
        Ajouter utilisateur
    </a>
</div>


<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


<div class="card shadow-sm border-0">
<div class="card-body">

<div class="table-responsive">

<table class="table table-striped align-middle">

<thead class="table-light">
<tr>
    <th>Nom</th>
    <th>Email</th>
    <th>Rôle</th>
    <th width="150">Action</th>
</tr>
</thead>

<tbody>

@forelse($users as $user)
<tr>

    <!-- NOM -->
    <td class="fw-semibold">
        {{ $user->name }}
    </td>

    <!-- EMAIL -->
    <td>
        {{ $user->email }}
    </td>

    <!-- ROLE BADGE -->
    <td>

        @php
            $badge = match($user->role){
                'admin' => 'bg-danger',
                'vendeur' => 'bg-success',
                'logistique' => 'bg-primary',
                'mecanicien' => 'bg-warning',
                default => 'bg-secondary'
            };
        @endphp

        <span class="badge {{ $badge }}">
            {{ ucfirst($user->role) }}
        </span>

    </td>

    <!-- ACTION -->
    <td>

        <a href="{{ route('users.edit',$user->id) }}"
           class="btn btn-warning btn-sm">
            <i class="ti ti-edit"></i>
            Modifier
        </a>

    </td>

</tr>

@empty
<tr>
    <td colspan="4" class="text-center text-muted">
        Aucun utilisateur trouvé
    </td>
</tr>
@endforelse

</tbody>

</table>

</div>
</div>
</div>

</div>
</div>

@endsection
