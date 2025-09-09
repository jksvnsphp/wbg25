@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card my-4 rounded-0 " id="category_card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Edit State
                    </div>
                    <form method="post" action="{{ route('admin.update.state') }}" enctype="multipart/form-data"
                        class="card-body pb-0">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <input type="text" name="state_name" id="name" class="form-control"
                                    placeholder="Enter the state name" value="{{ $state->name }}">
                                <input type="hidden" name="id" value="{{ $state->id }}">
                                @error('state_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4 form-group">
                                <input type="file" name="image" id="image">
                                <small class="d-block">State Image</small>
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if ($state->image!='')
                                    <img src="{{asset('uploads/state_banners/'.$state->image)}}" style="height:4rem;" alt="">
                                @endif
                            </div>

                            <div class="mb-3 col-md-4 px-3">
                                <button type="submit" class="btn btn-sm btn-primary">Update State</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>


    </div>
@endsection
