@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <!-- information section -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Profile Image Gallery</h6>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-11">
                                <div class="row justify-content-between">
                                    <div class="col-md-5">
                                        <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">
                                            <form method="post" enctype="multipart/form-data" action="{{route('buyer.update.profile.picture')}}" class="d-flex align-items-center">
                                                @csrf
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label fw-bold">Profile Picture
                                                        <span class="text-secondary">(Max Size: 200X200 px)</span></label>
                                                    <input type="file" accept="image/*" class="form-control" name="image" />
                                                    @error('image')
                                                        <span class="text-danger"> {{$message}} </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-secondary mt-3 mx-3">
                                                    Upload
                                                </button>
                                            </form>

                                            <h6 class="fw-bold fs-6">Show Image</h6>
                                            <div class="row">
                                                @if ($buyer->profile != '')
                                                    <div class="col-sm-6 d-flex align-items-start">
                                                        <div style="height: 6rem; width: 6rem">
                                                            <img src="{{ asset('uploads/profile/' . $buyer->profile) }} "
                                                                class="img-fluid" alt="" />
                                                        </div>
                                                        <a id="delete" href="{{route('buyer.delete.profile.picture')}}"  class="btn btn-primary">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
