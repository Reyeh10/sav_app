<!--if(Auth::check())-->
<!--?php $page = 'employees'; ?-->
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Employé(e)</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{url('index')}}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Employé(e)
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des employé(e)s</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                    <!--div class="me-2 mb-2">
                        <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                            <a href="{ {url('employees')}}" class="btn btn-icon btn-sm active bg-primary text-white me-1"><i class="ti ti-list-tree"></i></a>
                            <a href="{ {url('employees-grid')}}" class="btn btn-icon btn-sm"><i class="ti ti-layout-grid"></i></a>
                        </div>
                    </div-->
                    <div class="me-2 mb-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="ti ti-file-export me-1"></i>Exporter
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Exporter comme PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Exporter comme Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2">
                        <!--a href="{ { route('admin.dashboard.index') }}" data-bs-toggle="modal" data-bs-target="#add_employee" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un(e) employé(e)</a-->
                        <a href= "{{ route('admin.employé.formulaireemployé') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un(e) employé(e)</a>
                        <!--a href= "{ { route('form-basic-inputs') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter</a-->


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
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Total Employee</p>
                                    <h4>1007</h4>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-soft-purple badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
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
                                    <span class="avatar avatar-lg bg-success rounded-circle"><i class="ti ti-user-share"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
                                    <h4>1007</h4>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-soft-primary badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
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
                                    <span class="avatar avatar-lg bg-danger rounded-circle"><i class="ti ti-user-pause"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
                                    <h4>1007</h4>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-soft-dark badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
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
                                    <span class="avatar avatar-lg bg-info rounded-circle"><i class="ti ti-user-plus"></i></span>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <p class="fs-12 fw-medium mb-1 text-truncate">New Joiners</p>
                                    <h4>67</h4>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-soft-secondary badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /No of Plans -->

            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>Liste des employés</h5>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <!--div class="me-3">
                            <div class="input-icon-end position-relative">
                                <input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
                                <span class="input-icon-addon">
                                    <i class="ti ti-chevron-down"></i>
                                </span>
                            </div>
                        </div-->
                        <div class="dropdown me-3">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                Designation
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Finance</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Developer</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Executive</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown me-3">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                Select Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Active</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Inactive</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                Sort By : Last 7 Days
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

<!--  New code ------------------------------------------------------------ -->
<div class="card shadow mb-4">
          <div class="card-body">
            <div class="table-responsive">
                <!--table class="table table-striped" id="dataTable" style="width:100%" cellspacing="0"-->
                <table class="table table-bordered table-striped table-sm">

      <thead>
        <tr>
           <!--td-->

              <th scope="col"><small><b><p class="a">Id Employé</p></b></small></th>
              <th scope="col"><small><b><p class="a">Matricule CNSS</p></b></small></th>
              <th scope="col"><small><b><p class="a">Nom complet</p></b></small></th>
              <th scope="col"><small><b><p class="a">Sexe</p></b></small></th>
              <th scope="col"><small><b><p class="a">Type de contrat</p></b></small></th>
              <!--th scope="col"><small><b><p class="a">Date_naissance</p></b></small></th-->
              <!--th scope="col"><small><b><p class="a">Tél:</p></b></small></th>
              <th scope="col"><small><b><p class="a">Nationnalité</p></b></small></th-->
              <!--th scope="col"><small><b><p class="a">No CIN</p></b></small></th-->
              <!--th scope="col"><small><b><p class="a">Email</p></b></small></th>
              <th scope="col"><small><b><p class="a">Situation</p></b></small></th>
              <th scope="col"><small><b><p class="a">Adresse</p></b></small></th-->
              <th scope="col"><small><b><p class="a">Edit</p></b></small></th>
              <th scope="col"><small><b><p class="a">Delete</p></b></small></th>

             <!--/td-->

            </tr>
            </thead>
            <tbody>

            @foreach ($viewData["employés"] as $employé)
          <tr>

            <!--   Extrasmall xs <576px & Small sm >=576px -->
      <!--body-->
              <!--td><small>{ { $employé->getimage() }}</small></td-->
              <td><small>{{ $employé->getid_employé() }}</small></td>
              <td><small>{{ $employé->getmat_cnss() }}</small></td>
              <td><small>{{ $employé->getNom() }}</small></td>
              <td><small>{{ $employé->getSexe() }}</small></td>
              <td><small>{{ $employé->gettype_contrat() }}</small></td>


              <!--td><small>{ { $employé->getDateNaissance() }}</small></td-->
              <!--td><small>{ { $employé->getPhone() }}</small></td>
              <td><small>{ { $employé->getCitoyennete() }}</small></td-->
              <!--td><small> { { $employé->getcodeposte() }}</small></td-->
              <!--td><small>{ { $employé->getCIN() }}</small></td>
              <td><small>{ { $employé->getEmail() }}</small></td-->
              <!--td><small>{ { $employé->getStatusMatrimonial() }}</small></td>
              <td><small>{ { $employé->getAddress() }}</small></td-->



    <!--/body-->



        <td>

        <!--a class="btn btn-primary" href="{ { route('admin.employee.edittemplate', ['id'=> $employee->getId()]) }}" role="button">EDIT</a-->
         <a class="fa fa-edit" href="{{ route('admin.employé.edit', ['id_employé'=> $employé->getid_employé()]) }}" style="font-size:24px;color"></a>



            <!--a class="btn btn-primary" href="{ { route('admin.employee.edittemplate', ['id'=> $employee->getId()]) }}">
            <button class="btn btn-primary">
            <i class="bi-pencil"></i>
            </button>
            </a-->
        </td>

        <td>
              <form action="{{route('admin.employé.delete', $employé->getid_employé())}}" method="POST">
              <!--form action="{ {route('admin.employee.delete', $employee->getMatricule())}}" method="POST"-->

             @csrf
             @method('DELETE')

             <button class="btn btn-danger">
             <!--i class="bi-trash"></i-->
             <i class="fa fa-trash-o" style="font-size:15px;color"></i>
             </button>
            </form>
          </td>
          </tr>
          @endforeach
          </tbody>
          </table>
             <!--  Pagination --------------- -->
             <!--{ { $viewData["employés"]->links('pagination::bootstrap-5') }}-->
            <!--END -  Pagination --------------- -->
            </div>
          </div>
        </div>
    <!--/div-->

<!-- -----END--  New code ------------------------------------------------------------ -->

<!-- END-------------------------- Table ---------------------------------- -->

            </div>
        </div>
<!-- ------------------------------ footer ------------------------------- -->
        <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
            <p class="mb-0">2014 - 2025 &copy; SmartHR.</p>
            <p>Designed &amp; Developed By <a href="javascript:void(0);" class="text-primary">Dreams</a></p>
        </div>
<!-- ----END-------------------------- footer -------------------------- -->

    </div>
    <!-- /Page Wrapper -->

    @component('components.modal-popup')
    @endcomponent

@endsection
