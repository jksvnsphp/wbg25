@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Gallery Image</h6>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-11">
                                <form action="{{ route('vendor.upload.spotlight.picture') }}" method="POST"
                                    enctype="multipart/form-data" class="row justify-content-between">
                                    @csrf

                                    <div class="col-md-12">
                                        <div class="card shadow rounded-0 mt-4 p-3" style="border: 2px solid grey">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group mb-3">
                                                    <label for="profile_banner" class="form-label fw-bold">Spotlight
                                                        Banner
                                                        <span class="text-secondary">(Max Size: 2520X620 px)</span></label>
                                                    <input type="file" class="form-control" id="profile_banner"
                                                        name="spotlight_banner" />
                                                </div>
                                                <button type="button"
                                                    onclick="previewImage('profile_banner','profile_bannerPreview')"
                                                    class="btn btn-primary mt-3 mx-3">
                                                    Upload
                                                </button>
                                            </div>
                                            @if (isset($user->company->spotlight_banner) && $user->company->spotlight_banner != '')
                                                <h6 class="fw-bold fs-6">Show Image</h6>
                                                <div class="row">
                                                    <div class="col-sm-12 d-flex align-items-start">
                                                        <div class="d-flex w-100  " style="height: 10rem">
                                                            <img id="profile_bannerPreview"
                                                                src="{{ asset('uploads/profile/' . $user->company->spotlight_banner) }}"
                                                                class="img-fluid" alt="" style="height: 100%;" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <img id="profile_bannerPreview"  src="" class="img-fluid d-none" alt="" style="height: 10rem !important;" />
                                            @endif
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
