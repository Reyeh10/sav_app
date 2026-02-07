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
                            <h4>Ajouter un nouveau motif d'absence</h4>
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
        <form method="POST" action="{{ route('admin.motif_absence.store') }}">
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
                                                <input name="id" value="{{ old('id') }}" type="text" placeholder="id" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>
                                <!--    --------- motif_absence---- ---------------------------- -->
                                    <div class="col-md-6">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label mb-md-0">Motif d'absence</label><span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!--input type="text" class="form-control"-->
                                                <input name="motif_absence" value="{{ old('motif_absence') }}" type="text" placeholder="Motif d'absence" class="form-control form-control-sm" id="smallsize-input"  required />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end">
                                <button type="reset" class="btn btn-outline-light border me-3" >Cancel</button>
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

