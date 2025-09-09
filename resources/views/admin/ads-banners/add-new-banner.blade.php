@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Banner on (Abstract & Contemporary Paintings) Page
                    </div>
                    <div class="card-body pb-0">
                        <div class="form-group row">
                            <div class="col-4 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Upload Banner
                                    Image: <span class="text-danger">*</span></label>

                            </div>
                            <div class="col-8 mb-3">
                                <input name="image" type="file" accept="image/*">
                                <small class="fs-1 font-weight-bolder d-block"> (only jpeg/jpg/png/swf file are
                                    allowed)</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Position: <span
                                        class="text-danger">*</span></label>

                            </div>
                            <div class="col-8 mb-3">
                                <select name="position" id="position" class="form-control">
                                    <option value="">Please select</option>
                                    <option value="1">Top</option>
                                    <option value="2">Bottom</option>
                                    <option value="3">Left One</option>
                                    <option value="4">Left Two</option>
                                    <option value="5">Left Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Start Date: <span
                                        class="text-danger">*</span></label>

                            </div>
                            <div class="col-8 mb-3">
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">End Date: <span
                                        class="text-danger">*</span></label>

                            </div>
                            <div class="col-8 mb-3">
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Ad URL: <span
                                        class="text-danger">*</span></label>

                            </div>
                            <div class="col-8 mb-3">
                                <input type="url" name="ad_url" id="ad_url" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3 p-2 pb-0 mb-0">
                            <button class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('custom-js')
@endsection
