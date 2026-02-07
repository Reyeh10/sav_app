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
                            <h4>Ajouter un nouveau employé</h4>
                        </div>

<!-- ------END---------- Title ---------------------------- -->



<div class="gradient-tabs">
    <!--ul class="nav nav-tabs" id="gradientTabs" role="tablist"-->
    <ul class="nav nav-underline" id="gradientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab3" data-bs-toggle="tab" data-bs-target="#home3" type="button" role="tab" aria-controls="home3" aria-selected="true">
                Information de l'employé(e)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab3" data-bs-toggle="tab" data-bs-target="#profile3" type="button" role="tab" aria-controls="profile3" aria-selected="false">
                Affectation
            </button>
        </li>
    </ul>
<hr>
    <div class="tab-content" id="gradientTabsContent">
        <div class="tab-pane fade show active" id="home3" role="tabpanel">

<!-- ---------------------------- code ------------------------------------- -->
    @if($errors->any())
        <ul class="alert alert-danger list-unstyled">
                @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
        </ul>
    @endif
        <form method="POST" action="{{ route('admin.employé.store') }}">
            @csrf


<!-- ---------------------------- END ----- Code ---------------------------- -->


                        <!--form action="{ { url('profile-settings') }}"-->
                            <div class="border-bottom mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <!--h6 class="mb-3">Informations personnelles de l'employé(é)</h6-->
                                            <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                                <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                    <i class="ti ti-photo text-gray-3 fs-16"></i>
                                                </div>
                                                <div class="profile-upload">
                                                    <div class="mb-2">
                                                        <h6 class="mb-1">Profile Photo</h6>
                                                        <p class="fs-12">Recommended image size is 40px x 40px</p>
                                                    </div>
                                                    <div class="profile-uploader d-flex align-items-center">
                                                        <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                                            Upload
                                                            <input type="file" class="form-control image-sign" multiple="">
                                                        </div>
                                                        <a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <!--    --------- ID Employe ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Id Employé</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="id_employé" value="{{ old('id_employé') }}" type="text" placeholder="Id Employé" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- Matricule CNSS ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Matricule CNSS</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="mat_cnss" value="{{ old('mat_cnss') }}" type="text" placeholder="Matricule CNSS" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- Nom complet ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Nom complet</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="name" value="{{ old('name') }}" type="text" placeholder="Nom complet" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- Date_naissance ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date de naissance</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="date_naissance" value="{{ old('date_naissance') }}" type="date"   data-date-format="mm/dd/yyyy" placeholder="Date de naissance" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- Date d'ancienneté ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date d'ancienneté</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="date_ancienneté" value="{{ old('date_ancienneté') }}" type="date"   data-date-format="mm/dd/yyyy" placeholder="date d'ancienneté" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Lieu de naissance ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Lieu de naissance</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="lieu_naissance" value="{{ old('lieu_naissance') }}" type="text" placeholder="Lieu de naissance" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- Tél: ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Télephone</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="phone" value="{{ old('phone') }}" type="tel" placeholder="77 00 00 00" class="form-control form-control-sm" id="smallsize-input" pattern="^\d{2} \d{2} \d{2} \d{2}$" required />
                                            </div>
                                        </div>
                                    </div>


                                <!--    --------- No CIN ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Numero CIN</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="cin" value="{{ old('cin') }}" type="number" placeholder="Numéro CIN" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>

                                <!--    --------- Email ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Email</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="email" value="{{ old('email') }}" type="email" placeholder="nom@exemple.com" class="form-control form-control-sm" id="smallsize-input" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                                            </div>
                                        </div>
                                    </div>

                                <!--    --------- Sexe ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Sexe</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                            <!--select class="js-example-basic-single select2">
                                                <option selected="selected">Choisir le sexe</option>
                                                <option value="1">Homme</option>
                                                <option value="2">Femme</option>
                                            </select-->
                                                <!--select name="sexe" id="sexe" class="form-select @ error('sexe') is-invalid @ enderror" required-->
                                                <select name="sexe" id="sexe" class="js-example-basic-single select2 @error('sexe') is-invalid @enderror" required>
                                                    <option value="">-- Selectionner --</option>
                                                    <option value="Male" {{ old('sexe') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('sexe') == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                <!--    --------- Situation_matrimonial ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Situation</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--select class="js-example-basic-single select2">
                                                    <option selected="selected">Choisir la Situation matrimonial</option>
                                                    <option value="1">Marié(e)</option>
                                                    <option value="2">Celibataire</option>
                                                    <option value="3">Veuf(ve)</option>
                                                    <option value="4">Divercé(e)</option>
                                                </select-->

                                                <select name="situation" id="situation" class="js-example-basic-single select2 @error('situation') is-invalid @enderror" required>
                                                    <option value="">-- Selectionner --</option>
                                                    <option value="Marié(e)" {{ old('situation') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                                                    <option value="Celibataire" {{ old('situation') == 'Celibataire' ? 'selected' : '' }}>Celibataire</option>
                                                    <option value="Veuf(ve)" {{ old('situation') == 'Veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                                                    <option value="Divercé(e)" {{ old('situation') == 'Divercé(e)' ? 'selected' : '' }}>Divercé(e)</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                <!--    --------- Status de l'employé ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Status</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--select class="js-example-basic-single select2">
                                                    <option selected="selected">Choisir le Status de l'employé(e)</option>
                                                    <option value="1">Conventionné</option>
                                                    <option value="2">fonctionnaire</option>
                                                </select-->

                                                <select name="status_employé" id="status_employé" class="fjs-example-basic-single select2 @error('status_employé') is-invalid @enderror" required>
                                                    <option value="">-- Selectionnner --</option>
                                                    <option value="Conventionné" {{ old('status_employé') == 'Conventionné' ? 'selected' : '' }}>Conventionné</option>
                                                    <option value="fonctionnaire" {{ old('status_employé') == 'fonctionnaire' ? 'selected' : '' }}>fonctionnaire</option>

                                                </select>

                                            </div>

                                        </div>
                                    </div>

                                <!--    --------- Code de l'activite ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Code activité</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="code_activité" value="{{ old('code_activité') }}" type="text" placeholder="code activité" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- Type de contrat ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Type de contrat</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--select class="js-example-basic-single select2">
                                                    <option selected="selected">Choisir le type de contrat</option>
                                                    <option value="1">CDI</option>
                                                    <option value="2">CDD</option>
                                                    <option value="3">Stagiaire</option>
                                                </select-->


                                                 <select name="type_contrat" id="type_contrat" class="js-example-basic-single select2 @error('type_contrat') is-invalid @enderror" required>
                                                    <option value="">-- Selectionner --</option>
                                                    <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                                    <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                                    <option value="Stagiaire" {{ old('type_contrat') == 'Stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                <!--    --------- Niveau_scolarite ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Niveau de scolarite</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="niveau_scolarité" id="niveau_scolarité" class="js-example-basic-single select2 @error('niveau_scolarité') is-invalid @enderror" required>
                                                    <option value="">-- Selectionner --</option>
                                                    <option value="Aucun" {{ old('niveau_scolarité') == 'Aucun' ? 'selected' : '' }}>Aucun</option>
                                                    <option value="Collège" {{ old('niveau_scolarité') == 'Collège' ? 'selected' : '' }}>Collège</option>
                                                    <option value="Lycée" {{ old('niveau_scolarité') == 'Lycée' ? 'selected' : '' }}>Lycée</option>
                                                    <option value="BAC" {{ old('niveau_scolarité') == 'BAC' ? 'selected' : '' }}>BAC</option>
                                                    <option value="BAC+2" {{ old('niveau_scolarité') == 'BAC+2' ? 'selected' : '' }}>BAC+2</option>
                                                    <option value="BAC+3" {{ old('niveau_scolarité') == 'BAC+3' ? 'selected' : '' }}>BAC+3</option>
                                                    <option value="BAC+4" {{ old('niveau_scolarité') == 'BAC+4' ? 'selected' : '' }}>BAC+4</option>
                                                    <option value="BAC+5" {{ old('niveau_scolarité') == 'BAC+5' ? 'selected' : '' }}>BAC+5</option>
                                                    <option value="DOCTORANT" {{ old('niveau_scolarité') == 'DOCTORANT' ? 'selected' : '' }}>DOCTORANT</option>
                                                    <option value="DOCTORAT" {{ old('niveau_scolarité') == 'DOCTORAT' ? 'selected' : '' }}>DOCTORAT</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                <!--    --------- Addresse ---- ------------------------------------------ -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Addresse</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="address" value="{{ old('address') }}" type="text" placeholder="Addresse" class="form-control form-control-sm" id="smallsize-input" required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- Commentaire ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Commentaire</label>
                                            </div>
                                            <div class="col-md-12">
                                                <!--input name="observation" value="{ { old('observation') }}" type="text" placeholder="Observation" class="form-control form-control-sm" id="smallsize-input" required /-->
                                                <textarea class="form-control" id="smallsize-input" name="commentaire" rows="2" placeholder="Écrire ici les observations..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                <!-- END   --------- ID Employe ---- ---------------------------- -->

                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-outline-light border me-3">Cancel</button>
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

        <div class="tab-pane fade" id="profile3" role="tabpanel">
        <!-- ---------------------------- code ------------------------------------- -->
    @if($errors->any())
        <ul class="alert alert-danger list-unstyled">
                @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
        </ul>
    @endif
        <form method="POST" action="{{ route('admin.affectation.store') }}">
            @csrf


<!-- ---------------------------- END ----- Code ---------------------------- -->
                        <!--form action="{ { url('profile-settings') }}"-->
                            <div class="border-bottom mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>

                                            </div-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <!--    --------- ID Affectation ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Id Affectation</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="id_affectation" value="{{ old('id_affectation') }}" type="text" placeholder="ID Affectation" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- Date de début ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date de début</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="Date_debut" value="{{ old('Date_debut') }}" type="date"   data-date-format="mm/dd/yyyy" placeholder="date de debut" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- Id Employé ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Id Employé</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="id_employé_key" value="{{ old('id_employé_key') }}" type="text" placeholder="ID Employé" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    ---------  ----Date de fin ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Date de fin</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="Date_fin" value="{{ old('Date_fin') }}" type="date"   data-date-format="mm/dd/yyyy" placeholder="date de fin" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Code poste ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Code poste</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="code_poste_key" value="{{ old('code_poste_key') }}" type="text" placeholder="Code poste" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>

                                    <!--    --------- Code service ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Code service</label><span class="text-danger">*</span></label>                                            </div>
                                            <div class="col-md-8">
                                                <input name="code_service_key" value="{{ old('code_service_key') }}" type="text" placeholder="Code service" class="form-control form-control-sm" id="smallsize-input" pattern="^[a-zA-Z0-9 ]+$" required />
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Status d'affectation ---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Status d'affectation</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">

                                                <select name="status" id="status" class="js-example-basic-single select2 @error('status') is-invalid @enderror" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="Actuelle" {{ old('status') == 'Actuelle' ? 'selected' : '' }}>Actuelle</option>
                                                    <option value="Ancienne" {{ old('status') == 'Ancienne' ? 'selected' : '' }}>Ancienne</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--    --------- Commentaire ---- ---------------------------- -->

                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Commentaire</label></label>
                                            </div>
                                            <div class="col-md-12">
                                                <!--input name="observation" value="{ { old('observation') }}" type="text" placeholder="Observation" class="form-control form-control-sm" id="smallsize-input" required /-->
                                                <textarea class="form-control" id="smallsize-input" name="commentaire" rows="2" placeholder="Écrire ici les observations..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-outline-light border me-3">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>


                <!--/div>
            </div>
        </div>
    </div-->
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

