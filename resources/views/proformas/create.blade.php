@extends('layout.mainlayout')

@section('content')

<style>
    .proforma-create-page {
        width: 100%;
        padding: 26px 22px 48px;
    }

    .proforma-create-inner {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .proforma-create-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .proforma-create-header h4 {
        margin: 0 0 5px;
        font-size: 28px;
        font-weight: 800;
    }

    .proforma-create-header p {
        margin: 0;
        color: #64748b;
    }

    .proforma-form-card {
        overflow: hidden;
        border: 1px solid #e6e9ef;
        border-radius: 16px;
        box-shadow: 0 9px 28px rgba(15, 23, 42, .08);
    }

    .proforma-form-card .card-header {
        padding: 17px 22px;
        color: #fff;
        background: linear-gradient(135deg, #26328c, #3b49ad);
    }

    .proforma-form-card .card-header h5 {
        margin: 0;
        color: #fff;
        font-weight: 800;
    }

    .proforma-form-card .card-body {
        padding: 26px;
    }

    .proforma-form-card .form-label {
        margin-bottom: 7px;
        font-weight: 700;
    }

    .proforma-form-card .form-control,
    .proforma-form-card .form-select {
        min-height: 50px;
        border-radius: 9px;
    }

    .proforma-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 24px;
    }

    @media(max-width:767.98px) {
        .proforma-create-page {
            padding: 17px 11px 35px;
        }

        .proforma-create-header,
        .proforma-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .proforma-create-header .btn,
        .proforma-actions .btn {
            width: 100%;
        }

        .proforma-form-card .card-body {
            padding: 20px 14px;
        }
    }
</style>

<div class="proforma-create-page">
    <div class="proforma-create-inner">

        <div class="proforma-create-header">
            <div>
                <h4>Nouveau proforma</h4>
                <p>Créer une proposition commerciale similaire à la facture.</p>
            </div>

            <a
                href="{{ route('proformas.index') }}"
                class="btn btn-secondary"
            >
                <i class="ti ti-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form
            action="{{ route('proformas.store') }}"
            method="POST"
            id="proformaForm"
        >
            @csrf

            @include('proformas.form', ['mode' => 'create'])

            <div class="proforma-actions">
                <button
                    type="submit"
                    class="btn btn-primary px-4"
                >
                    <i class="ti ti-device-floppy me-1"></i>
                    Créer le proforma
                </button>

                <a
                    href="{{ route('proformas.index') }}"
                    class="btn btn-secondary px-4"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
