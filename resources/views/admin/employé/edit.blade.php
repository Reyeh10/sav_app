<!--?php $page = 'employee-details'; ?-->
@extends('layout.mainlayout')
@section('content')

@if($errors->any())
<ul class="alert alert-danger list-unstyled">
@foreach($errors->all() as $error)
<li>- {{ $error }}</li>
@endforeach
</ul>
@endif

<!--@ foreach ($viewData["employés"] as $employé)-->
    <!--tr-->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">



            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">

                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">

                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="row">
                <div class="col-xl-4 theiaStickySidebar">
                    <div class="card card-bg-1">
                        <div class="card-body p-0">
                            <span class="avatar avatar-xl avatar-rounded border border-2 border-white m-auto d-flex mb-2">
                                <img src="{{ asset('admintemplate/assets/img/users/user-13.jpg') }}" class="w-auto h-auto" alt="Img">
                            </span>
                            <div class="text-center px-3 pb-3 border-bottom">
                                <div class="mb-3">
                                    <h5 class="d-flex align-items-center justify-content-center mb-1">{{ $viewData['employé']->getNom() }}<i class="ti ti-discount-check-filled text-success ms-1"></i></h5>

                                </div>
                            <!-- Employee ID --------------------------------------- -->
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="ti ti-id me-2"></i>
                                            ID employé(e)
                                        </span>
                                        <!--p class="text-dark">{ { $employé->id_employé }}</p-->
                                        <p class="text-dark">{{ $viewData['employé']->getid_employé()  }}</p>
                                    </div>
                            <!-- Code poste --------------------------------------- -->
                                <!--div-->
                                    <!--div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="ti ti-id me-2"></i>
                                            Code poste
                                        </span>
                                        <p class="text-dark">{ { $viewData['employé']->affectations->getcode_poste_key()  }}</p>
                                    </div-->
                            <!-- Code service --------------------------------------- -->
                                <!--div-->
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="d-inline-flex align-items-center">
                                            <i class="ti ti-id me-2"></i>
                                            Code activité
                                        </span>
                                        <p class="text-dark">{{ $viewData['employé']->getcode_activité_key()  }}</p>
                                    </div>
                            <!-- Employee Phone --------------------------------------- -->


                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-phone me-2"></i>
                                        Tél:
                                    </span>
                                    <p class="text-dark">{{ $viewData['employé']->getPhone() }}</p>
                                </div>
                            <!-- Email --------------------------------------- -->


                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-mail-check me-2"></i>
                                        Email
                                    </span>
                                    <a href="javascript:void(0);" class="text-info d-inline-flex align-items-center">{{ $viewData['employé']->getemail() }}<i class="ti ti-copy text-dark ms-2"></i></a>
                                </div>
                            <!-- Sexe --------------------------------------- -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-gender-male me-2"></i>
                                        Sexe
                                    </span>
                                    <p class="text-dark text-end">{{ $viewData['employé']->getSexe() }}</p>
                                </div>
                            <!-- Birthday --------------------------------------- -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-cake me-2"></i>
                                        Date de naissance
                                    </span>
                                    <p class="text-dark text-end">{{ $viewData['employé']->getDateNaissance() }}</p>
                                </div>
                            <!-- Address --------------------------------------- -->

                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-map-pin-check me-2"></i>
                                        Address
                                    </span>
                                    <p class="text-dark text-end">{{ $viewData['employé']->getaddress() }}</p>
                                </div>

                            <!-- Employee ID --------------------------------------- -->
                                    <div class="row gx-2 mt-3">
                                        <div class="col-6">
                                            <div>
                                                <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="ti ti-edit me-1"></i>Edit Info</a>
                                            </div>
                                        </div>
                                        <div class="col-6">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-xl-8">
                    <div>
                        <div class="tab-content custom-accordion-items">
                            <div class="tab-pane active show" id="bottom-justified-tab1" role="tabpanel">
                                <div class="accordion accordions-items-seperate" id="accordionExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingOne">
                                            <div class="accordion-button">
                                                <div class="d-flex align-items-center flex-fill">
                                                    <h5>A propos de l'employé(e)</h5>
                                                    <a href="#" class="btn btn-sm btn-icon ms-auto" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="ti ti-edit"></i></a>
                                                    <a href="#" class="d-flex align-items-center collapsed collapse-arrow" data-bs-toggle="collapse" data-bs-target="#primaryBorderOne" aria-expanded="false" aria-controls="primaryBorderOne">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="primaryBorderOne" class="accordion-collapse collapse show border-top" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body mt-2">
                                            {{ $viewData['employé']->getcommentaire() }}
                                            </div>
                                        </div>
                                    </div>
                                     <!-- Carriere de l'employé -------------------------------------------------- -->
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingTwo">
                                            <div class="accordion-button">
                                                <div class="d-flex align-items-center flex-fill">
                                                    <h5>Carriere de l'employé</h5>
                                                    <a href="#" class="btn btn-sm btn-icon ms-auto" data-bs-toggle="modal" data-bs-target="#edit_bank"><i class="ti ti-edit"></i></a>
                                                    <a href="#" class="d-flex align-items-center collapsed collapse-arrow"  data-bs-toggle="collapse" data-bs-target="#primaryBorderTwo" aria-expanded="false" aria-controls="primaryBorderTwo">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="primaryBorderTwo" class="accordion-collapse collapse border-top" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <!--div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                           Status
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">{ { optional($viewData['employé']->affectations)->getstatus() ?? '---' }}</h6>
                                                    </div-->
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Date de début
                                                        </span>
                                                        <!--h6 class="d-flex align-items-center fw-medium mt-1">{ { $viewData['employé']->affectations->getDate_debut()  }}</h6-->
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">{{ optional($viewData['employé']->affectations)->getDate_debut() ?? '---' }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                           Date de fin
                                                        </span>
                                                        <!--h6 class="d-flex align-items-center fw-medium mt-1">{ { $viewData['employé']->affectations->getDate_fin()  }}</h6-->
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">{{ optional($viewData['employé']->affectations)->getDate_fin()  ?? '---' }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                          Service
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">{{ optional($viewData['employé']->affectations)->getcode_service_key() ?? '---' }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                           Status
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">{{ optional($viewData['employé']->affectations)->getstatus() ?? '---' }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Information bancaire -------------------------------------------------- -->
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingThree">
                                            <div class="accordion-button">
                                                <div class="d-flex align-items-center flex-fill">
                                                    <h5>Information bancaire</h5>
                                                    <a href="#" class="btn btn-sm btn-icon ms-auto" data-bs-toggle="modal" data-bs-target="#edit_bank"><i class="ti ti-edit"></i></a>
                                                    <a href="#" class="d-flex align-items-center collapsed collapse-arrow"  data-bs-toggle="collapse" data-bs-target="#primaryBorderTwo" aria-expanded="false" aria-controls="primaryBorderTwo">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="primaryBorderTwo" class="accordion-collapse collapse border-top" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Bank Name
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">Swiz Intenational Bank</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Bank account no
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">159843014641</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            IFSC Code
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">ICI24504</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Branch
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">Alabama USA</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--div class="card">
                                        <div class="card-body">
                                            <div class="contact-grids-tab p-0 mb-3">
                                                <ul class="nav nav-underline" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="info-tab2" data-bs-toggle="tab" data-bs-target="#basic-info2" type="button" role="tab" aria-selected="true">Projects</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="address-tab2" data-bs-toggle="tab" data-bs-target="#address2" type="button" role="tab" aria-selected="false">Assets</button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content" id="myTabContent3">
                                                <div class="tab-pane fade show active" id="basic-info2" role="tabpanel" aria-labelledby="info-tab2" tabindex="0">
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex">
                                                            <div class="card flex-fill mb-4 mb-md-0">
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                        <a href="{ {url('project-details')}}" class="flex-shrink-0 me-2">
                                                                            <img src="{ { asset('admintemplate/assets/img/social/project-03.svg') }}" alt="Img">
                                                                        </a>
                                                                        <div>
                                                                            <h6 class="mb-1"><a href="{ {url('project-details')}}">World Health</a></h6>
                                                                            <div class="d-flex align-items-center">
                                                                                <p class="mb-0 fs-13">8 tasks</p>
                                                                                <p class="fs-13"><span class="mx-1"><i class="ti ti-point-filled text-primary"></i></span>15 Completed</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Deadline</span>
                                                                                <p class="text-dark">31 July 2025</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Project Lead</span>
                                                                                <a href="#" class="fw-normal d-flex align-items-center">
                                                                                    <img class="avatar avatar-sm rounded-circle me-2" src="{{ asset('admintemplate/assets/img/profiles/avatar-01.jpg') }}" alt="Img">
                                                                                    Leona
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex">
                                                            <div class="card flex-fill mb-0">
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                        <a href="{ {url('project-details')}}" class="flex-shrink-0 me-2">
                                                                            <img src="{ { asset('admintemplate/assets/img/social/project-01.svg') }}" alt="Img">
                                                                        </a>
                                                                        <div>
                                                                            <h6 class="mb-1 text-truncate"><a href="{{url('project-details')}}">Hospital Administration</a></h6>
                                                                            <div class="d-flex align-items-center">
                                                                                <p class="mb-0 fs-13">8 tasks</p>
                                                                                <p class="fs-13"><span class="mx-1"><i class="ti ti-point-filled text-primary"></i></span>15 Completed</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Deadline</span>
                                                                                <p class="text-dark">31 July 2025</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Project Lead</span>
                                                                                <a href="#" class="fw-normal d-flex align-items-center">
                                                                                    <img class="avatar avatar-sm rounded-circle me-2" src="{ { asset('admintemplate/assets/img/profiles/avatar-01.jpg') }}" alt="Img">
                                                                                    Leona
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="address2" role="tabpanel" aria-labelledby="address-tab2" tabindex="0">
                                                    <div class="row">
                                                        <div class="col-md-12 d-flex">
                                                            <div class="card flex-fill">
                                                                <div class="card-body">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-8">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="{ {url('project-details')}}" class="flex-shrink-0 me-2">
                                                                                    <img src="{ { asset('admintemplate/assets/img/products/product-05.jpg') }}" class="img-fluid rounded-circle" alt="img">
                                                                                </a>
                                                                                <div>
                                                                                    <h6 class="mb-1"><a href="{ {url('project-details')}}">Dell Laptop - #343556656</a></h6>
                                                                                    <div class="d-flex align-items-center">
                                                                                            <p><span class="text-primary">AST - 001<i class="ti ti-point-filled text-primary mx-1"></i></span>Assigned on 22 Nov, 2022 10:32AM </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Assigned by</span>
                                                                                <a href="#" class="fw-normal d-flex align-items-center">
                                                                                    <img class="avatar avatar-sm rounded-circle me-2" src="{{ asset('admintemplate/assets/img/profiles/avatar-01.jpg') }}" alt="Img">
                                                                                    Andrew Symon
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="dropdown ms-2">
                                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="ti ti-dots-vertical"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                                    <li>
                                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#asset_info">View Info</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#refuse_msg">Raise Issue </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 d-flex">
                                                            <div class="card flex-fill mb-0">
                                                                <div class="card-body">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-8">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="{ {url('project-details')}}" class="flex-shrink-0 me-2">
                                                                                    <img src="{ { asset('admintemplate/assets/img/products/product-06.jpg') }}" class="img-fluid rounded-circle" alt="img">
                                                                                </a>
                                                                                <div>
                                                                                    <h6 class="mb-1"><a href="{ {url('project-details')}}">Bluetooth Mouse  - #478878</a></h6>
                                                                                    <div class="d-flex align-items-center">
                                                                                            <p><span class="text-primary">AST - 001<i class="ti ti-point-filled text-primary mx-1"></i></span>Assigned on 22 Nov, 2022 10:32AM </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div>
                                                                                <span class="mb-1 d-block">Assigned by</span>
                                                                                <a href="#" class="fw-normal d-flex align-items-center">
                                                                                    <img class="avatar avatar-sm rounded-circle me-2" src="{{ URL::asset('build/img/profiles/avatar-01.jpg') }}" alt="Img">
                                                                                    Andrew Symon
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="dropdown ms-2">
                                                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="ti ti-dots-vertical"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                                    <li>
                                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#asset_info">View Info</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#refuse_msg">Raise Issue </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
            <p class="mb-0">2014 - 2025 &copy; SmartHR.</p>
            <p>Designed &amp; Developed By <a href="#" class="text-primary">Dreams</a></p>
        </div>
    </div>
    <!-- /Page Wrapper -->

    @component('components.modal-popup')
    @endcomponent

    <!--/tr>
@ endforeach-->


@endsection
