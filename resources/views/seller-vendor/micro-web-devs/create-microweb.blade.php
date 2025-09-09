@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="spinner-border text-light" role="status"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3 ">
                <h6 class="fs-6 text-light text-center py-3 px-3">
                    Create a spotlight store for your subdomain business profile on world
                    business guide -> www.wbg24.com/Your-Name
                </h6>
                <form method="post" enctype="multipart/form-data" action="{{ route('seller.update.domain') }}"
                    class="card shadow rounded-0">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="fs-6 text-primary text-center py-3 px-3">
                                    To use spotlight store option you need to use Gold,Platinum package.
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-header bg-body-secondary">
                        <span class="fw-bold fs-6">Set Your Sub Domain</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Company Sub-domain name</h6>
                                <div class="row align-items-center mb-3">
                                    <label for="" style="width: fit-content" class="fw-bold">www.wbg24.com/</label>
                                    <div class="col-md-4">
                                        <input type="text" name="spotlight_name" id="spotlight_name"
                                            placeholder="Enter your spotlight name" value="{{ $user->ref_no ?? '' }}"
                                            class="form-control me-2" />
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="check_availability" class="btn btn-primary">
                                            Check Availability
                                        </button>
                                    </div>
                                    <div id="availability_result" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header bg-body-secondary">
                        <span class="fw-bold fs-6">Set Spotlight Banner Picture</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="profile_banner" class="form-label fw-bold">Spotlight
                                                Banner
                                                <span class="text-secondary">(Max Size: 2520X620 px)</span></label>
                                            <input type="file" class="form-control" id="profile_banner"
                                                name="spotlight_banner" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="profile_banner" class="btn btn-primary mt-3 ">
                                            Upload
                                        </label>
                                    </div>
                                </div>
                                @if (isset($user->company->spotlight_banner) && $user->company->spotlight_banner != '')
                                    <h6 class="fw-bold fs-6">Show Image</h6>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex align-items-start">
                                            <div class="d-flex w-100  " style="height: 10rem">
                                                <img src="{{ asset('uploads/profile/' . $user->company->spotlight_banner) }}"
                                                    class="img-fluid" alt="" style="height: 100%;" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-header bg-body-secondary">
                        <span class="fw-bold fs-6">Set Spotlight Featured Picture</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="col-md-6 mb-4">
                                    <div class="form-group mb-3">
                                        <label for="spotlight_image{{ $i }}" class="form-label fw-bold">Spotlight
                                            Product Picture:
                                            <span class="text-danger">400X400 Pixel</span></label>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="file" name="spotlight_image{{ $i }}"
                                                    class="form-control spotlight-input"
                                                    id="spotlight_image{{ $i }}" accept="image/*" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="spotlight_image{{ $i }}"
                                                    class="btn btn-primary">Upload</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <div class="img-block my-2 me-2" style="width: 8rem;height: 8rem;">
                                                <img src="@if (isset($user->company->{'spotlight_preview' . $i}) && $user->company->{'spotlight_preview' . $i} != '') {{ asset('uploads/profile/' . $user->company->{'spotlight_preview' . $i}) }} 
                                                      @else 
                                                        {{ asset('uploads/products/gallery/Image_not_available.png') }} @endif"
                                                    id="previewImage{{ $i }}" class="rounded-2 preview-image"
                                                    style="height: 100%; width: 100%; border:1px solid #e6e4e4"
                                                    alt="Preview Image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary my-5">
                            Publish Your Spotlight Store
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $(".spotlight-input").on("change", function() {
                let input = this;
                let previewId = $(this).attr("id").replace("spotlight_image", "previewImage");

                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#" + previewId).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#check_availability').on('click', function() {
                let spotlightName = $('#spotlight_name').val().trim();
                let regex = /^[a-z0-9-_]+$/;

                if (!regex.test(spotlightName)) {
                    $('#availability_result').html(
                        '<span class="text-danger">Invalid input! Only lowercase letters, hyphens, and underscores are allowed.</span>'
                    );
                    return;
                }
                $.ajax({
                    url: '{{ route('seller.checkdomain.availability') }}',
                    type: 'GET',
                    data: {
                        spotlight_name: spotlightName
                    },
                    success: function(response) {
                        if (response.available) {
                            $('#availability_result').html(
                                '<span class="text-success">Spotlight name is available!</span>'
                            );
                        } else {
                            $('#availability_result').html(
                                '<span class="text-danger">Spotlight name is already taken.</span>'
                            );
                        }
                    },
                    error: function() {
                        $('#availability_result').html(
                            '<span class="text-danger">An error occurred. Please try again.</span>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
