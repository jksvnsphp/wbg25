@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Edit Package Service
                    </div>
                    <div class="card-body pb-0">
                        <form method="post" action="{{route('admin.update.package.service')}}" class="form-group row">
                            @csrf
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Service
                                            Name :</label>
                                    </div>
                                    <div class="col-9 mb-3 ">

                                        <input name="service_name" type="text" class="form-control form-control-user"
                                            placeholder="Service Name" value="{{$service->serviceName}}">
                                            <input type="hidden" name="id" value="{{$service->id}}">
                                            @error('service_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                </div>
                                <h6 class="fs-3 mb-3 font-weight-bolder text-dark">Packages :-</h6>
                                <div class="row ">
                                    <div class="col-3 mb-3">

                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Bronce
                                            Package:</label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="input-check d-flex align-items-center">
                                            <label for="isBronceon"
                                                class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                            <input @checked($service->bronce==1) type="radio" name="isBronce" class="mx-2" id="isBronceon"
                                                value="1">
                                            <label for="isBronceoff"
                                                class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                            <input @checked($service->bronce==0) type="radio" name="isBronce" class="mx-2" id="isBronceoff"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-3 mb-3">

                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Silver
                                            Package:</label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="input-check d-flex align-items-center">
                                            <label for="isSilveron"
                                                class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                            <input @checked($service->silver==1) type="radio" name="isSilver" class="mx-2" id="isSilveron"
                                                value="1">
                                            <label for="isSilveroff"
                                                class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                            <input @checked($service->silver==0) type="radio" name="isSilver" class="mx-2" id="isSilveroff"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-3 mb-3">

                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Gold
                                            Package:</label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="input-check d-flex align-items-center">
                                            <label for="isGoldon"
                                                class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                            <input @checked($service->gold==1) type="radio" name="isGold" class="mx-2" id="isGoldon"
                                                value="1">
                                            <label for="isGoldoff"
                                                class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                            <input @checked($service->gold==0) type="radio" name="isGold" class="mx-2" id="isGoldoff"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-3 mb-3">

                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Platinum
                                            Package:</label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="input-check d-flex align-items-center">
                                            <label for="isPlatinumon"
                                                class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                            <input @checked($service->platinum==1) type="radio" name="isPlatinum" class="mx-2" id="isPlatinumon"
                                                value="1">
                                            <label for="isPlatinumoff"
                                                class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                            <input @checked($service->platinum==0) type="radio" name="isPlatinum" class="mx-2" id="isPlatinumoff"
                                                value="0">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-3 p-2 pb-0 mb-0">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
