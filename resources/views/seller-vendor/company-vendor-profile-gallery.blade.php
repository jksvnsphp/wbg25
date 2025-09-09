@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Profile Image Gallery</h6>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-11">
                                <form action="{{ route('vendor.upload.profile.picture') }}" method="POST"
                                    enctype="multipart/form-data" class="row justify-content-between">
                                    @csrf
                                    <div class="col-md-5">
                                        <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">
                                            <div class="d-flex align-items-center ">
                                                <div class="form-group mb-3">
                                                    <label for="profile" class="form-label fw-bold">Profile Picture
                                                        <span class="text-secondary">(Max Size: 200X200
                                                            px)</span></label>
                                                    <input type="file" id="profile" class="form-control"
                                                        name="profile" />
                                                </div>
                                                <button type="button" onclick="previewImage('profile', 'profilePreview')"
                                                    class="btn btn-primary mt-3 mx-3">
                                                    Upload
                                                </button>
                                            </div>
                                            @if (auth()->user()->profile)
                                                <h6 class="fw-bold fs-6">Show Image</h6>
                                                <div class="row">
                                                    <div class="col-sm-6 d-flex align-items-start">
                                                        <div style="height: 6rem; width: 6rem">
                                                            <img id="profilePreview"
                                                                src="{{ asset('uploads/profile/' . auth()->user()->profile) }}"
                                                                class="img-fluid" alt=""
                                                                style="height: 6rem; width: 6rem" />
                                                        </div>
                                                        <div class="ml-3">

                                                            <button type="button" id="delete-profile-picture-btn"
                                                                class="btn  btn-primary">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <img id="profilePreview" class="img-fluid d-none"
                                                    style="height: 6rem; width: 6rem;" />
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-5">
                                        <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group mb-3">
                                                    <label for="company_logo" class="form-label fw-bold">Company Logo
                                                        <span class="text-secondary">(Max Size: 200X200 px)</span></label>
                                                    <input type="file" class="form-control" id="company_logo"
                                                        name="company_logo" />
                                                </div>
                                                <button type="button"
                                                    onclick="previewImage('company_logo', 'company_logoPreview')"
                                                    class="btn btn-primary mt-3 mx-3">
                                                    Upload
                                                </button>
                                            </div>
                                            @if (isset($user->company->company_logo) && $user->company->company_logo != '')
                                                <h6 class="fw-bold fs-6">Show Image</h6>
                                                <div class="row">
                                                    <div class="col-sm-6 d-flex align-items-start">
                                                        <div style="height: 6rem; width: 6rem">
                                                            <img style="height: 6rem; width: 6rem" id="company_logoPreview"
                                                                src="{{ asset('uploads/profile/' . $user->company->company_logo) }}"
                                                                class="img-fluid" alt="" />
                                                        </div>

                                                        <button type="button" id="delete-business-logo-picture-btn"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            @else
                                                <img style="height: 6rem; width: 6rem" id="company_logoPreview"
                                                    src="" class="img-fluid d-none" alt="" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card shadow rounded-0 mt-4 p-3" style="border: 2px solid grey">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group mb-3">
                                                    <label for="profile_banner" class="form-label fw-bold">Business Profile
                                                        Banner
                                                        <span class="text-secondary">(Max Size: 2520X620 px)</span></label>
                                                    <input type="file" class="form-control" id="profile_banner"
                                                        name="profile_banner" />
                                                </div>
                                                <button type="button"
                                                    onclick="previewImage('profile_banner', 'profile_bannerPreview')"
                                                    class="btn btn-primary mt-3 mx-3">
                                                    Upload
                                                </button>
                                            </div>
                                            @if (isset($user->company->profile_banner) && $user->company->profile_banner != '')
                                                <h6 class="fw-bold fs-6">Show Image</h6>
                                                <div class="row">
                                                    <div class="col-sm-12 d-flex align-items-start justify-content-start">
                                                        <div class="d-flex w-100 align-items-start justify-content-start " style="height: 6rem">
                                                            <img id="profile_bannerPreview"
                                                                src="{{ asset('uploads/profile/' . $user->company->profile_banner) }}"
                                                                class="img-fluid" alt="" style="height: 100%;" />
                                                         <button type="button" id="delete-business-banner-picture-btn"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <img id="profile_bannerPreview" src="" class="img-fluid d-none"
                                                    alt="" style="height: 6rem" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="row">
                                            <h5 class="fs-5 fw-bold">Business Profile Gallery</h5>
                                            <div class="col-md-6 mt-4">
                                                <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">

                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group mb-3">
                                                            <label for="image_1" class="form-label fw-bold">Image 1
                                                                <span class="text-secondary">(Max Size: 400X400
                                                                    px)</span></label>
                                                            <input type="file" id="image_1" class="form-control"
                                                                name="image_1" />
                                                            <input type="hidden" name="col[]" value="image_1">
                                                        </div>
                                                        <button type="button"
                                                            onclick="previewImage('image_1', 'image_1Preview')"
                                                            class="btn btn-primary mt-3 mx-3">
                                                            Upload
                                                        </button>
                                                    </div>

                                                    @if (isset($user->company->image_1) && $user->company->image_1 != '')
                                                        <h6 class="fw-bold fs-6">Show Image</h6>
                                                        <div class="row">
                                                            <div class="col-sm-6 d-flex align-items-start">
                                                                <div style="height: 8rem; width: 8rem">
                                                                    <img id="image_1Preview"
                                                                        src="{{ asset('uploads/profile/' . $user->company->image_1) }}"
                                                                        class="img-fluid" alt="" />
                                                                </div>
                                                                <a href="{{ route('delete.vendor.gallery', 'image_1') }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="image_1Preview" style="height: 8rem; width: 8rem"
                                                            src="" class="img-fluid d-none" alt="" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group mb-3">
                                                            <label for="image_2" class="form-label fw-bold">Image 2
                                                                <span class="text-secondary">(Max Size: 400X400
                                                                    px)</span></label>
                                                            <input type="file" id="image_2" class="form-control"
                                                                name="image_2" />
                                                            <input type="hidden" name="col[]" value="image_2">
                                                        </div>
                                                        <button type="button"
                                                            onclick="previewImage('image_2', 'image_2Preview')"
                                                            class="btn btn-primary mt-3 mx-3">
                                                            Upload
                                                        </button>
                                                    </div>
                                                    @if (isset($user->company->image_2) && $user->company->image_2 != '')
                                                        <h6 class="fw-bold fs-6">Show Image</h6>
                                                        <div class="row">
                                                            <div class="col-sm-6 d-flex align-items-start">
                                                                <div style="height: 8rem; width: 8rem">
                                                                    <img src="{{ asset('uploads/profile/' . $user->company->image_2) }}"
                                                                        class="img-fluid" alt="" />
                                                                </div>
                                                                <a href="{{ route('delete.vendor.gallery', 'image_2') }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="image_2Preview" style="height: 8rem; width: 8rem"
                                                            src="" class="img-fluid d-none" alt="" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">

                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group mb-3">
                                                            <label for="image_3" class="form-label fw-bold">Image 3
                                                                <span class="text-secondary">(Max Size: 400X400
                                                                    px)</span></label>
                                                            <input type="file" id="image_3" class="form-control"
                                                                name="image_3" />
                                                            <input type="hidden" name="col[]" value="image_3">
                                                        </div>
                                                        <button type="button"
                                                            onclick="previewImage('image_3', 'image_3Preview')"
                                                            class="btn btn-primary mt-3 mx-3">
                                                            Upload
                                                        </button>
                                                    </div>

                                                    @if (isset($user->company->image_3) && $user->company->image_3 != '')
                                                        <h6 class="fw-bold fs-6">Show Image</h6>
                                                        <div class="row">
                                                            <div class="col-sm-6 d-flex align-items-start">
                                                                <div style="height: 8rem; width: 8rem">
                                                                    <img src="{{ asset('uploads/profile/' . $user->company->image_3) }}"
                                                                        class="img-fluid" alt="" />
                                                                </div>
                                                                <a href="{{ route('delete.vendor.gallery', 'image_3') }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="image_3Preview" style="height: 8rem; width: 8rem"
                                                            src="" class="img-fluid d-none" alt="" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="card p-3 shadow rounded-0" style="border: 2px solid grey">

                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group mb-3">
                                                            <label for="" class="form-label fw-bold">Image 4
                                                                <span class="text-secondary">(Max Size: 400X400
                                                                    px)</span></label>
                                                            <input type="file" id="image_4" class="form-control"
                                                                name="image_4" />
                                                            <input type="hidden" name="col[]" value="image_4">
                                                        </div>
                                                        <button type="button"
                                                            onclick="previewImage('image_4', 'image_4Preview')"
                                                            class="btn btn-primary mt-3 mx-3">
                                                            Upload
                                                        </button>
                                                    </div>

                                                    @if (isset($user->company->image_4) && $user->company->image_4 != '')
                                                        <h6 class="fw-bold fs-6">Show Image</h6>
                                                        <div class="row">
                                                            <div class="col-sm-6 d-flex align-items-start">
                                                                <div style="height: 8rem; width: 8rem">
                                                                    <img id="image_4Preview"
                                                                        src="{{ asset('uploads/profile/' . $user->company->image_4) }}"
                                                                        class="img-fluid" alt="" />
                                                                </div>
                                                                <a href="{{ route('delete.vendor.gallery', 'image_4') }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="image_4Preview" style="height: 8rem; width: 8rem"
                                                            src="" class="img-fluid d-none" alt="" />
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button class="btn btn-secondary " type="submit">Save & Publish</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $('#delete-profile-picture-btn').on('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete the profile picture?')) {
                    $.ajax({
                        url: "{{ route('vendor.delete.profile.picture') }}",
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Profile picture deleted successfully!');
                                location.reload();
                            } else {
                                toastr.error('Failed to delete profile picture!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the error
                            toastr.error('Failed to delete the profile picture.');
                        }
                    });
                }
            });
            $('#delete-business-logo-picture-btn').on('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete the business logo?')) {
                    $.ajax({
                        url: "{{ route('company-logo.delete.picture') }}",
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Business deleted successfully!');
                                location.reload();
                            } else {
                                toastr.error('Failed to delete busness logo!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the error
                            toastr.error('Failed to delete the busness logo.');
                        }
                    });
                }
            });
            
            $('#delete-business-banner-picture-btn').on('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete the business profile banner?')) {
                    $.ajax({
                        url: "{{ route('business-banner.delete.picture') }}",
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Business Banner deleted successfully!');
                                location.reload();
                            } else {
                                toastr.error('Failed to delete busness banner!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the error
                            toastr.error('Failed to delete the busness banner.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add("d-none");
            }
        }
    </script>
@endsection
