@extends('layout.mainlayout')
@section('content')


<div class="gradient-tabs">
    <ul class="nav nav-tabs" id="gradientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab3" data-bs-toggle="tab" data-bs-target="#home3" type="button" role="tab">
                Information de l'employé(e)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab3" data-bs-toggle="tab" data-bs-target="#profile3" type="button" role="tab">
                Affectation
            </button>
        </li>
        <!--li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab3" data-bs-toggle="tab" data-bs-target="#contact3" type="button" role="tab">
                        Contact
                    </button>
        </li-->
    </ul>
    <div class="tab-content" id="gradientTabsContent">
        <div class="tab-pane fade show active" id="home3" role="tabpanel">

            <!--h4>tab1 : Information de l'employé</h4-->
            <!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">


        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom mb-3 pb-3">
                            <h4>Profile Settings</h4>
                        </div>
                        <!--form action="{ { url('profile-settings') }}"-->
                        <form action="{{ url('profile-settings') }}">
                            <div class="border-bottom mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <h6 class="mb-3">Basic Information</h6>
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
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">First Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Last Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Email</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Phone</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom mb-3">
                                <h6 class="mb-3">Address Information</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label mb-md-0">Address</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">City</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">State</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>France</option>
                                                        <option>India</option>
                                                        <option>UK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Country</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Belgium</option>
                                                        <option>Turkey</option>
                                                        <option>Ukraine</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Postal Code</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
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



        </div>

        <div class="tab-pane fade" id="profile3" role="tabpanel">

            <!--h4>tab 2 : Affectation</h4-->
            <!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">


        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom mb-3 pb-3">
                            <h4>Profile Settings</h4>
                        </div>
                        <!--form action="{ { url('profile-settings') }}"-->
                        <form action="{{ url('profile-settings') }}">
                            <div class="border-bottom mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <h6 class="mb-3">Basic Information</h6>
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
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">First Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Last Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Email</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Phone</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--div class="border-bottom mb-3">
                                <h6 class="mb-3">Address Information</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-2">
                                                <label class="form-label mb-md-0">Address</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">City</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">State</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>France</option>
                                                        <option>India</option>
                                                        <option>UK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Country</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Belgium</option>
                                                        <option>Turkey</option>
                                                        <option>Ukraine</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Postal Code</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div-->
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-outline-light border me-3">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
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
        </div>
    </div>
</div>
</div>

@endsection

