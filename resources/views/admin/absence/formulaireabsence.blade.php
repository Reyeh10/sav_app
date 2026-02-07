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
                            <h4>Ajouter un nouvelle absence</h4>
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
        <form method="POST" action="{{ route('admin.absence.store') }}">
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
                                    <!--    --------- id_motif_absence ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">ID Motif d'absence</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="id_motif_absence" id="id_motif_absence" class="js-example-basic-single select2 @error('id') is-invalid @enderror" required>
                                                    <option value="">-- Sélectionner --</option>
                                                    @foreach ($motifabsences as $motifabsence)
                                                        <option value="{{ $motifabsence->id }}"
                                                            {{ old('id_motif_absence') == $motifabsence->id ? 'selected' : '' }}>
                                                            {{ $motifabsence->id }} - {{ $motifabsence->motif_absence }}
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

                                    <!--    --------- Date_debut ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date de début</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="Date_debut" value="{{ old('Date_debut') }}" type="date" placeholder="Date de début" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Date_fin ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date de fin</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="Date_fin" value="{{ old('Date_fin') }}" type="date" placeholder="Date de fin" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- commentaire ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Commentaire</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="commentaire" value="{{ old('commentaire') }}" type="text" placeholder="commentaire" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- status ---- ---------------------------- -->
                                    <!--div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Status</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="status" value="{{ old('status') }}" type="text" placeholder="status" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div-->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Status du congé</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="status" id="status" class="js-example-basic-single select2 @error('status') is-invalid @enderror" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="Validé" {{ old('status') == 'Validé' ? 'selected' : '' }}>Validé</option>
                                                    <option value="Annulé" {{ old('status') == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                                                    <option value="Demande" {{ old('status') == 'Demande' ? 'selected' : '' }}>Demande</option>
                                                </select>
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

