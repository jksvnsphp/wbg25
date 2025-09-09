@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Change Admin and Password
                    </div>
                    <div class="card-body pb-0">
                        <form method="post" action="{{route('admin.update.password')}}" class="form-group row">
                            @csrf
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Email
                                            :</label>
                                    </div>
                                    <div class="col-9 mb-3 ">

                                        <input value="{{auth()->user()->email}}" name="email" type="email"
                                            class="form-control form-control-user" placeholder="User email">
                                            
                                            @error('email')
                                                <span> {{$message}} </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Current
                                            password :</label>
                                    </div>
                                    <div class="col-9 mb-3 ">

                                        <input name="current_password" type="text" class="form-control form-control-user"
                                            placeholder="Current Password" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">New
                                            password :</label>
                                    </div>
                                    <div class="col-9 mb-3 ">

                                        <input name="new_password" type="text" class="form-control form-control-user"
                                            placeholder="New Password">
                                            @error('new_password')
                                                <span class="text-danger"> {{$message}} </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="" class="form-label fs-3 font-weight-bolder text-dark">Retype
                                            password :</label>
                                    </div>
                                    <div class="col-9 mb-3 ">

                                        <input name="confirm_password" type="text"
                                            class="form-control form-control-user">
                                            @error('confirm_password')
                                                <span class="text-danger"> {{$message}} </span>
                                            @enderror
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
