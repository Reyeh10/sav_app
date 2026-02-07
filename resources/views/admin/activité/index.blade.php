<!--?php $page = 'employees'; ?-->
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <!--h2 class="mb-1">Employé(e)</h2-->
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <!--li class="breadcrumb-item">
                                <a href=""><i class="ti ti-users"></i></a>
                            </li-->
                            <!--li class="breadcrumb-item">
                              Employé(e)
                            </li-->
                            <li class="breadcrumb-item active" aria-current="page"><h4 class="mb-1">Liste des codes activité</h4></li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">


                    <div class="mb-2">
                        <a href= "{{ route('admin.activité.formulairecodeactivité') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un code activité</a>
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

                <!-- /Total Plans -->

                <!-- Total Plans -->

                <!-- /Total Plans -->

                <!-- Inactive Plans -->

                <!-- /Inactive Companies -->

                <!-- No of Plans  -->


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
                                    <th>Code activité</th>
                                     <th>Nom de l'activité</th>

                                    <!--th>Edit</th-->
                                    <th>Delete</th>
                                    <!--th></th-->
                                </tr>
                            <!--/thead-->
                            <tbody>
                            <!-- -------------  fill out the table -------------------- -->



                                 @foreach ($viewData["activités"] as $activité)
          <tr>

            <td>
                <div class="form-check form-check-md">
                    <input class="form-check-input" type="checkbox">
                </div>
            </td>
              <td><small>{{ $activité->getcode_activité() }}</small></td>
              <td><small>{{ $activité->getnom_activité() }}</small></td>


        <!--td>
            <a href="{{ route('admin.activité.edit', ['code_activité'=> $activité->getcode_activité()]) }}" >
                <button class="btn btn-success" style="font-size:08px">
                     <i class="bi-pencil"></i>
                </button>
            </a>
        </td-->

        <td>
              <form action="{{route('admin.activité.delete', $activité->getcode_activité())}}" method="POST" >

                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" style="font-size:08px">
                    <i class="ti ti-trash"></i>
                    </button>
            </form>
        </td>
          </tr>
          @endforeach


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
