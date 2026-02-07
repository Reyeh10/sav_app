<!--@ if(Auth::user() && Auth::user()->role === 'admin')-->

<!--if(Auth::check())-->
<?php $page = 'index'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Admin Dashboard</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{url('index')}}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Dashboard
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
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
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-icon w-120 position-relative">
                            <span class="input-icon-addon">
                                <i class="ti ti-calendar text-gray-9"></i>
                            </span>
                            <input type="text" class="form-control yearpicker" value="2025">
                        </div>
                    </div>
                    <div class="ms-2 head-icons">
                        <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                            <i class="ti ti-chevrons-up"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <!-- Welcome Wrap -->
            <div class="card border-0">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
                    <div class="d-flex align-items-center mb-3">
                        <span class="avatar avatar-xl flex-shrink-0">
                            <img src="{{ asset('admintemplate/assets/img/profiles/avatar-31.jpg') }}" class="rounded-circle" alt="img">
                        </span>
                        <div class="ms-3">
                            <h3 class="mb-2">Welcome Back, Adrian <a href="javascript:void(0);" class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
                            <!--p>You have <span class="text-primary text-decoration-underline">21</span> Pending Approvals & <span class="text-primary text-decoration-underline">14</span> Leave Requests</p-->
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap mb-1">
                        <a href="#" class="btn btn-secondary btn-md me-2 mb-2" data-bs-toggle="modal" data-bs-target="#add_project"><i class="ti ti-square-rounded-plus me-1"></i>Add Project</a>
                        <a href="#" class="btn btn-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#add_leaves"><i class="ti ti-square-rounded-plus me-1"></i>Add Requests</a>
                    </div>
                </div>
            </div>
            <!-- /Welcome Wrap -->

            <div class="row">

                <!-- Widget Info -->
                <!--div class="col-xxl-8 d-flex">
                    <div class="row flex-fill">
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-primary mb-2">
                                        <i class="ti ti-calendar-share fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Attendance Overview</h6>
                                    <h3 class="mb-3">120/154 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                                    <a href="{{url('attendance-employee')}}" class="link-default">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-secondary mb-2">
                                        <i class="ti ti-browser fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Total No of Project's</h6>
                                    <h3 class="mb-3">90/125 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-2.1%</span></h3>
                                    <a href="{{url('projects')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-info mb-2">
                                        <i class="ti ti-users-group fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Total No of Clients</h6>
                                    <h3 class="mb-3">69/86 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
                                    <a href="{{url('clients')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-pink mb-2">
                                        <i class="ti ti-checklist fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Total No of Tasks</h6>
                                    <h3 class="mb-3">225/28 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>
                                    <a href="{{url('tasks')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-purple mb-2">
                                        <i class="ti ti-moneybag fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Earnings</h6>
                                    <h3 class="mb-3">$21445 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+10.2%</span></h3>
                                    <a href="{{url('expenses')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-danger mb-2">
                                        <i class="ti ti-browser fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Profit This Week</h6>
                                    <h3 class="mb-3">$5,544 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                                    <a href="{{url('purchase-transaction')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-success mb-2">
                                        <i class="ti ti-users-group fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">Job Applicants</h6>
                                    <h3 class="mb-3">98 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                                    <a href="{{url('job-list')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <span class="avatar rounded-circle bg-dark mb-2">
                                        <i class="ti ti-user-star fs-16"></i>
                                    </span>
                                    <h6 class="fs-13 fw-medium text-default mb-1">New Hire</h6>
                                    <h3 class="mb-3">45/48 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
                                    <a href="{{url('candidates')}}" class="link-default">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div-->
                <!-- Leaves Info -->
                <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-black-le">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-start">
                                    <p class="mb-1">Annual Leaves</p>
                                    <h4>05</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md d-flex">
                                            <i class="ti ti-calendar-event fs-32"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-secondary-transparent">Remaining Leaves : 07</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-blue-le">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-start">
                                    <p class="mb-1">Medical Leaves</p>
                                    <h4>11</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md d-flex">
                                            <i class="ti ti-vaccine fs-32"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-info-transparent">Remaining Leaves : 01</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-purple-le">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-start">
                                    <p class="mb-1">Casual Leaves</p>
                                    <h4>02</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md d-flex">
                                            <i class="ti ti-hexagon-letter-c fs-32"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-transparent-purple">Remaining Leaves : 10</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-pink-le">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-start">
                                    <p class="mb-1">Other Leaves</p>
                                    <h4>07</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md d-flex">
                                            <i class="ti ti-hexagonal-prism-plus fs-32"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-pink-transparent">Remaining Leaves : 05</span>
                        </div>
                    </div>
                </div>
                </div>
                <!-- /Leaves Info -->
                <!-- Leaves Info -->
                <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-green-img">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md rounded-circle bg-white d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user-check text-success fs-18"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1">Total Present</p>
                                    <h4>180/200</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-pink-img">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md rounded-circle bg-white d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user-edit text-pink fs-18"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1">Planned Leaves</p>
                                    <h4>10</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-yellow-img">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md rounded-circle bg-white d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user-exclamation text-warning fs-18"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1">Unplanned Leaves</p>
                                    <h4>10</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-blue-img">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <span class="avatar avatar-md rounded-circle bg-white d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user-question text-info fs-18"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1">Pending Requests</p>
                                    <h4>15</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <!-- /Leaves Info -->
                <!--    Emplyees ------------------------------------------------------- -->
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
                                    <h4>{{ $count }}</h4>
                                </div>
                            </div>
                            <!--div>
                                <span class="badge badge-soft-purple badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
                            </div-->
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
                                    <h4>{{ $womenCount }}</h4>
                                </div>
                            </div>
                            <!--div>
                                <span class="badge badge-soft-primary badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
                            </div-->
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
                                    <h4>{{ $menCount }}</h4>
                                </div>
                            </div>
                            <!--div>
                                <span class="badge badge-soft-dark badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
                            </div-->
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
                                    <h4>{{ $stagiaire }}</h4>
                                </div>
                            </div>
                            <!--div>
                                <span class="badge badge-soft-secondary badge-sm fw-normal">
                                    <i class="ti ti-arrow-wave-right-down"></i>
                                    +19.01%
                                </span>
                            </div-->
                        </div>
                    </div>
                </div>

                <!-- /No of Plans -->

            </div>
                <!-- /Widget Info -->

                <!-- Employees By Department -->
                <!--div class="col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                            <h5 class="mb-2">Employees By Department</h5>
                            <div class="dropdown mb-2">
                                <a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>This Week
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Last Week</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="emp-department"></div>
                            <p class="fs-13"><i class="ti ti-circle-filled me-2 fs-8 text-primary"></i>No of
                                Employees increased by <span class="text-success fw-bold">+20%</span> from last Week
                            </p>
                        </div>
                    </div>
                </div-->
                <!-- /Employees By Department -->

            </div>

            <div class="row">

                <!-- Total Employee -->
                <div class="col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                            <h5 class="mb-2">Employee Status</h5>
                            <div class="dropdown mb-2">
                                <a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>This Week
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <p class="fs-13 mb-3">Total Employee</p>
                                <h3 class="mb-3">154</h3>
                            </div>
                            <div class="progress-stacked emp-stack mb-3">
                                <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <div class="progress-bar bg-warning"></div>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <div class="progress-bar bg-secondary"></div>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Segment three" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                    <div class="progress-bar bg-danger"></div>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Segment four" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                    <div class="progress-bar bg-pink"></div>
                                </div>
                            </div>
                            <div class="border mb-3">
                                <div class="row gx-0">
                                    <div class="col-6">
                                        <div class="p-2 flex-fill border-end border-bottom">
                                            <p class="fs-13 mb-2"><i class="ti ti-square-filled text-primary fs-12 me-2"></i>Fulltime <span class="text-gray-9">(48%)</span></p>
                                            <h2 class="display-1">112</h2>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 flex-fill border-bottom text-end">
                                            <p class="fs-13 mb-2"><i class="ti ti-square-filled me-2 text-secondary fs-12"></i>Contract <span class="text-gray-9">(20%)</span></p>
                                            <h2 class="display-1">112</h2>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 flex-fill border-end">
                                            <p class="fs-13 mb-2"><i class="ti ti-square-filled me-2 text-danger fs-12"></i>Probation <span class="text-gray-9">(22%)</span></p>
                                            <h2 class="display-1">12</h2>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 flex-fill text-end">
                                            <p class="fs-13 mb-2"><i class="ti ti-square-filled text-pink me-2 fs-12"></i>WFH <span class="text-gray-9">(20%)</span></p>
                                            <h2 class="display-1">04</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="mb-2">Top Performer</h6>
                            <div class="p-2 d-flex align-items-center justify-content-between border border-primary bg-primary-100 br-5 mb-4">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <span class="me-2">
                                        <i class="ti ti-award-filled text-primary fs-24"></i>
                                    </span>
                                    <a href="{{url('employee-details')}}" class="avatar avatar-md me-2">
                                        <img src="{{ asset('admintemplate/assets/img/profiles/avatar-24.jpg') }}" class="rounded-circle border border-white" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="text-truncate mb-1 fs-14 fw-medium"><a href="employee-details">Daniel Esbella</a></h6>
                                        <p class="fs-13">IOS Developer</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="fs-13 mb-1">Performance</p>
                                    <h5 class="text-primary">99%</h5>
                                </div>
                            </div>
                            <a href="{{url('employees')}}" class="btn btn-light btn-md w-100">View All Employees</a>
                        </div>
                    </div>
                </div>
                <!-- /Total Employee -->

                <!-- Attendance Overview -->
                <!--div class="col-xxl-4 col-xl-6 d-flex">
                    <div class="card flex-fill"-->
                <div class="col-xxl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                            <h5 class="mb-2">Status des employés</h5>
                            <div class="dropdown mb-2">
                                <a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>Today
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo position-relative mb-4">
                                <canvas id="attendance" height="200"></canvas>
                                <div class="position-absolute text-center attendance-canvas">
                                    <p class="fs-13 mb-1">Total Attendance</p>
                                    <h3>120</h3>
                                </div>
                            </div>
                            <h6 class="mb-3">Status</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="f-13 mb-2"><i class="ti ti-circle-filled text-success me-1"></i>Present</p>
                                <p class="f-13 fw-medium text-gray-9 mb-2">59%</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="f-13 mb-2"><i class="ti ti-circle-filled text-secondary me-1"></i>Late</p>
                                <p class="f-13 fw-medium text-gray-9 mb-2">21%</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="f-13 mb-2"><i class="ti ti-circle-filled text-warning me-1"></i>Permission</p>
                                <p class="f-13 fw-medium text-gray-9 mb-2">2%</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="f-13 mb-2"><i class="ti ti-circle-filled text-danger me-1"></i>Absent</p>
                                <p class="f-13 fw-medium text-gray-9 mb-2">15%</p>
                            </div>
                            <div class="bg-light br-5 box-shadow-xs p-2 pb-0 d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center">
                                    <p class="mb-2 me-2">Total Absenties</p>
                                    <div class="avatar-list-stacked avatar-group-sm mb-2">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white" src="{{ asset('admintemplate/assets/img/profiles/avatar-27.jpg') }}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white" src="{{ asset('admintemplate/assets/img/profiles/avatar-30.jpg') }}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('admintemplate/assets/img/profiles/avatar-14.jpg') }}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('admintemplate/assets/img/profiles/avatar-29.jpg') }}" alt="img">
                                        </span>
                                        <a class="avatar bg-primary avatar-rounded text-fixed-white fs-10" href="javascript:void(0);">
                                            +1
                                        </a>
                                    </div>
                                </div>
                                <a href="{{url('leaves')}}" class="fs-13 link-primary text-decoration-underline mb-2">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Attendance Overview -->



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

<!--@ else
        <p>error, Access denied. Admins only.</p>
@ endif-->

