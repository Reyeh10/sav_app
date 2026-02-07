<!--?php $page = 'employees'; ?-->
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Congé</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href=""><i class="ti ti-users"></i></a>
                            </li>
                            <!--li class="breadcrumb-item">
                              Employé(e)
                            </li-->
                            <li class="breadcrumb-item active" aria-current="page">Liste des reliquats congés</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">

                    <div class="me-2 mb-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="ti ti-file-export me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="{{ route('admin.ReliquatCongé.index') }}"  class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2">
                        <a href= "{{ route('admin.ReliquatCongé.formulairereliquatcongé') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un reliquat congé</a>
                        <!--a href="#" data-bs-toggle="modal" data-bs-target="#add_employee" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Employee</a-->
                    </div>
                    <div class="head-icons ms-2">
                        <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                            <i class="ti ti-chevrons-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="row">

                <!-- Total Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Total des Employé(e)s</p>
                                    <!--h4>{ { $count }}</h4-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Total Plans -->

                <!-- Total Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-pink  rounded-circle"><i class="ti ti-user-share"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Femme</p>
                                    <!--h4>{ { $womenCount }}</h4-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Total Plans -->

                <!-- Inactive Plans -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-info rounded-circle"><i class="ti ti-user-pause"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Homme</p>
                                    <!--h4>{ { $menCount }}</h4-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Inactive Companies -->

                <!-- No of Plans  -->
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center overflow-hidden">
                                <div>
                                    <span class="avatar avatar-lg bg-warning rounded-circle"><i class="ti ti-users"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Stagiaire</p>
                                    <!--h4>{ { $stagiaire }}</h4-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- /No of Plans -->

            </div>

            <div class="card">

                <!--   --------------------------- new code --------------------------- -->
                <div class="card-body p-0">
                    <div class="custom-datatable-filter table-responsive">
                        <table class="table datatable">
                            <!--thead class="thead-light"-->
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th>ID Reliquat Congé</th>
                                     <th>Crédit année</th>
                                    <th>Debit année</th>
                                    <!--th>Date de reprise</th>
                                    <th>Status du congé</th-->


                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <!--th></th-->
                                </tr>
                            <!--/thead-->
                            <tbody>
                            <!-- -------------  fill out the table -------------------- -->



                                 @foreach ($viewData["reliquatcongés"] as $reliquatcongé)
          <tr>

            <td>
                <div class="form-check form-check-md">
                    <input class="form-check-input" type="checkbox">
                </div>
            </td>
              <td><small>{{ $reliquatcongé->getid() }}</small></td>
              <td><small>{{ $reliquatcongé->getcredit_année() }}</small></td>
              <td><small>{{ $reliquatcongé->getdebit_année() }}</small></td>
              <!--td><small>{ { $congé->getreprise() }}</small></td>
              <td><small>{ { $congé->getstatus() }}</small></td-->





        <td>

            <a href="{{ route('admin.ReliquatCongé.edit', ['id'=> $reliquatcongé->getid()]) }}" >
                <button class="btn btn-success" style="font-size:08px">
                     <i class="bi-pencil"></i>
                </button>
            </a>
        </td>

        <td>
              <form action="{{route('admin.ReliquatCongé.delete', $reliquatcongé->getid())}}" method="POST" >

                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" style="font-size:08px">
                    <i class="ti ti-trash"></i>
                    </button>
            </form>
        </td>
          </tr>
          @endforeach


                         <!-- ----------------- End the data --------------------- -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
            <p class="mb-0">2014 - 2025 &copy; SmartHR.</p>
            <p>Designed &amp; Developed By <a href="javascript:void(0);" class="text-primary">Dreams</a></p>
        </div>

    </div>
    <!-- /Page Wrapper -->

    @component('components.modal-popup')
    @endcomponent

@endsection

<!-- ------------------------------- New code ------------------------ -->

<!-- END ------------------------------- New code ---------------------- -->
