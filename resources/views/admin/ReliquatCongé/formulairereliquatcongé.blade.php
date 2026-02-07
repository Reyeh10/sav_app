@extends('layout.mainlayout')
@section('content')

<!-- -------          Title -------------------------------- -->
<div class="page-wrapper">
    <div class="content">


        <div class="row">
            <!--div class="col-xl-9"-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom mb-3 pb-3">
                            <h4>Ajouter un nouveau reliquat congé</h4>
                        </div>

<!-- ------END---------- Title ---------------------------- -->


    <!-- ---------------------------- code ------------------------------------- -->
    @if($errors->any())
        <ul class="alert alert-danger list-unstyled">
                @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
        </ul>
    @endif
        <form method="POST" action="{{ route('admin.ReliquatCongé.store') }}">
            @csrf


    <!-- ---------------------------- END ----- Code ---------------------------- -->


                        <!--form action="{ { url('profile-settings') }}"-->
                            <div class="border-bottom mb-3">
                                <!--div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            </div>
                                        </div>
                                    </div>
                                </div-->
                                <div class="row">
                                    <!--    --------- ID ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">ID</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="id" value="{{ old('id') }}" type="text" placeholder="ID du congé" class="form-control form-control-sm" id="smallsize-input"  />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- id_congé ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">ID congé</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="id_congé" id="id_congé" class="js-example-basic-single select2 @error('id') is-invalid @enderror" required>
                                                    <option value="">-- Sélectionner --</option>
                                                    @foreach ($congés as $congé)
                                                        <option value="{{ $congé->id }}"
                                                            {{ old('id_congé') == $congé->id ? 'selected' : '' }}>
                                                            {{ $congé->id }} - {{ $congé->status }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- id_employé_key ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">ID Employé</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="id_employé_key" id="id_employé_key" class="js-example-basic-single select2 @error('id_employé') is-invalid @enderror" required>
                                                    <option value="">-- Sélectionner --</option>
                                                    @foreach ($employés as $employé)
                                                        <option value="{{ $employé->id_employé }}"
                                                            {{ old('id_employé_key') == $employé->id_employé ? 'selected' : '' }}>
                                                            {{ $employé->id_employé }} - {{ $employé->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- id_année ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">ID année</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="id_année" id="id_année" class="js-example-basic-single select2 @error('id') is-invalid @enderror" required>
                                                    <option value="">-- Sélectionner --</option>
                                                    @foreach ($années as $année)
                                                        <option value="{{ $année->id }}"
                                                            {{ old('id_année') == $année->id ? 'selected' : '' }}>
                                                            {{ $année->id }} - {{ $année->année }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Credit année ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Crédit année</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="credit_année" value="{{ old('credit_année') }}" type="text" placeholder="Crédit année" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- debit_année---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Débit année</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="debit_année" value="{{ old('debit_année') }}" type="text" placeholder="Débit année" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end">
                                <button type="reset" class="btn btn-outline-light border me-3">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                <!--/div>
            </div-->
        <!--/div>

</div-->
<!-- /Page Wrapper -->

        <!--/div-->


    <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
        <p class="mb-0">2014 - 2025 &copy; SmartHR.</p>
        <p>Designed &amp; Developed By <a href="javascript:void(0);" class="text-primary">Dreams</a></p>
    </div>
</div>
<!-- /Page Wrapper -->
        <!--/div>
    </div-->
<!--/div>
</div-->

@endsection

