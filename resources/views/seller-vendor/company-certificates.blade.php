@extends('seller-vendor.seller-frame')
@section('seller-main-content')
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary ">
            <div class="d-flex flex-wrap align-items-center">
                <h6 class="fs-5 text-light py-3 px-3 me-5">
                    My Certifications
                </h6>
                <div class="d-flex">
                    <div class="input-check me-3">
                        <input onchange="statusCertificate(event)" @checked(isset($seller->company->isCertificate) && $seller->company->isCertificate == 1) type="radio"
                        id="check1" class="form-check-input" name="status" value="1">
                        <label for="check1">Active</label>
                    </div>
                    <div class="input-check">
                        <input onchange="statusCertificate(event)" @checked(isset($seller->company->isCertificate) && $seller->company->isCertificate == 0) type="radio"
                        id="check2" class="form-check-input" name="status" value="0">
                        <label for="check2">Inactive</label>
                    </div>
                </div>
            </div>

            <div class="card shadow rounded-0">
                <form id="certificateForm"
                    method="post"
                    action="{{ route('company.upload.certificate') }}"
                    enctype="multipart/form-data"
                    class="card-body">
                    <div class="row">
                        <h6 class="mt-3 fw-bold">Certification</h6>
                        <div class="col-md-12  my-4">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="row">
                                @php
                                $certifications = [
                                'HACCP',
                                'ISO 9001:2000',
                                'ISO 9001:2008',
                                'QS-9000',
                                'ISO 14001:2004',
                                'ISO/TS 16949',
                                'SA8000',
                                'ISO 17799',
                                'OHSAS 18001',
                                'TL 9000',
                                'Other',
                                ];
                                $selectedCertifications = [];
                                if (isset($seller->company->certifications)) {
                                $selectedCertifications = json_decode(
                                isset($seller->company->certifications)
                                ? $seller->company->certifications
                                : [],true
                                );
                                }
                                @endphp
                                @foreach (array_chunk($certifications, 2) as $chunk)
                                <div class="col-md-2">
                                    <ul class="mx-0 px-0 list-unstyled">
                                        @foreach ($chunk as $certification)
                                        <li class="d-flex mt-2">
                                            <input class="me-3"
                                                @if (is_array($selectedCertifications) && $certification=='Other' ) onchange="other_certificate_select(event)" @endif
                                                type="checkbox" @if (is_array($selectedCertifications) && in_array($certification, $selectedCertifications)) checked @endif
                                                name="certifications[]" value="{{ $certification }}"
                                                id="{{ $certification }}" />
                                            <label for="{{ $certification }}">{{ $certification }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                                <div class="col-md-4 mt-3">
                                    <div class="form-group" id="other_certificate_gp"
                                        @if (is_array($selectedCertifications) && in_array('Other', $selectedCertifications)) style="display: block;" @else style="display: none;" @endif>
                                        <label for="other_certificate" class="form-label mb-4">Other (please
                                            specify)</label>
                                        @if (is_array($selectedCertifications) && in_array('Other', $selectedCertifications))
                                        @if (isset($seller->company->other_certificate) && json_decode($seller->company->other_certificate) != null)
                                        @php
                                        $others = json_decode($seller->company->other_certificate);

                                        @endphp
                                        @endif
                                        @endif
                                        <div class="mb-3">
                                            <label for="other_certificate1" class="form-label">Certificate 1</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[0]) ? $others[0] : '' }}"
                                                id="other_certificate1" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate2" class="form-label">Certificate 2</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[1]) ? $others[1] : '' }}"
                                                id="other_certificate2" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate3" class="form-label">Certificate 3</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[2]) ? $others[2] : '' }}"
                                                id="other_certificate3" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate4" class="form-label">Certificate 4</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[3]) ? $others[3] : '' }}"
                                                id="other_certificate4" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate5" class="form-label">Certificate 5</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[4]) ? $others[4] : '' }}"
                                                id="other_certificate5" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <script>
                                    function other_certificate_select(e) {
                                        if (e.target.value == "Other") {
                                            document.getElementById('other_certificate_gp').style.display = 'block';
                                        } else {
                                            document.getElementById('other_certificate_gp').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 d-flex mt-3 align-items-center">
                            <div class="card shadow">
                                <div class="card-body">
                                    <label for="imageCertificatedGallery1" class="form-label fw-bold">Certificate Image 1 <small class="text-danger">(480px X 360px)</small> <i class="fa fa-asterisk text-secondary" style="font-size:10px;" aria-hidden="true"></i></label>
                                    <div class="input-group">
                                        <input type="file" id="imageCertificatedGallery1" class="form-control file-input" name="images[]" />
                                    </div>
                                    <div class="position-relative d-inline-block mt-2">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="imgpr2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">

                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-image-btn"
                                            style="position:absolute; top:5px; right:5px; display:none;">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                                @error('images.0')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 d-flex mt-3 align-items-center">
                            <div class="card shadow">
                                <div class="card-body">
                                    <label for="imageCertificatedGallery2" class="form-label fw-bold">Certificate Image 2 <small class="text-danger">(480px X 360px)</small></label>
                                    <div class="input-group">
                                        <input type="file" id="imageCertificatedGallery2" class="form-control file-input" name="images[]" />
                                    </div>
                                    <div class="position-relative d-inline-block mt-2">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="imgpr2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">

                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-image-btn"
                                            style="position:absolute; top:5px; right:5px; display:none;">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex mt-3 align-items-center">
                            <div class="card shadow">
                                <div class="card-body">
                                    <label for="imageCertificatedGallery3" class="form-label fw-bold">Certificate Image 3 <small class="text-danger">(480px X 360px)</small></label>
                                    <div class="input-group">
                                        <input type="file" id="imageCertificatedGallery3" class="form-control file-input" name="images[]" />
                                    </div>
                                    <div class="position-relative d-inline-block mt-2">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="imgpr2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">

                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-image-btn"
                                            style="position:absolute; top:5px; right:5px; display:none;">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex mt-3 align-items-center">
                            <div class="card shadow">
                                <div class="card-body">
                                    <label for="imageCertificatedGallery4" class="form-label fw-bold">Certificate Image 4 <small class="text-danger">(480px X 360px)</small></label>
                                    <div class="input-group">
                                        <input type="file" id="imageCertificatedGallery4" class="form-control file-input" name="images[]" />
                                    </div>
                                    <div class="position-relative d-inline-block mt-2">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="imgpr2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">

                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-image-btn"
                                            style="position:absolute; top:5px; right:5px; display:none;">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="mt-3 fs-6">Show Image</h6>
                        @foreach ($certificates as $certificate)
                        <div class="col-md-3 mt-2">
                            <div class="card shadow rounded-0 position-relative">
                                <img src="{{ asset('uploads/certificates/' . $certificate->image) }}"
                                    class="img-thumbnail" alt="" />
                                <a href="{{ route('company.delete.certificate', $certificate->id) }}"
                                    class="btn btn-primary rounded-0 position-absolute top-0" style="right: 0">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-12">
                            <button type="submit" class="btn btn-secondary mt-3">Save & Publish</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="mt-3">
                <button type="button" onclick="window.history.back()" class="btn text-light"><i class="fas fa-arrow-left "></i> Back</button>
            </div>
        </div>
    </div>
</section>
@endsection
@section('seller-custome-js')

<script>
    const hasExistingCertificates = <?php echo $certificates->count() > 0 ? 'true' : 'false'; ?>;

    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('certificateForm');

        const REQUIRED_WIDTH = 480;
        const REQUIRED_HEIGHT = 360;
        const MAX_SIZE_MB = 2;

        let image1Valid = false;

        document.querySelectorAll('#certificateForm .file-input')
            .forEach((input, index) => {

                const cardBody = input.closest('.card-body');
                const previewImg = cardBody.querySelector('img');
                const removeBtn = cardBody.querySelector('.remove-image-btn');

                input.addEventListener('change', function() {

                    clearError(input);
                    hidePreview();

                    const file = this.files[0];

                    if (!file) {
                        if (index === 0) image1Valid = false;
                        return;
                    }

                    // File size check
                    if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                        showError(input, `Image size must not exceed ${MAX_SIZE_MB}MB.`);
                        resetInput();
                        return;
                    }

                    // File type check
                    if (!['image/jpeg', 'image/png'].includes(file.type)) {
                        showError(input, 'Only JPG or PNG images are allowed.');
                        resetInput();
                        return;
                    }

                    const img = new Image();
                    img.onload = () => {
                        if (img.width !== REQUIRED_WIDTH || img.height !== REQUIRED_HEIGHT) {
                            showError(
                                input,
                                `Invalid image size. Please upload ${REQUIRED_WIDTH}px × ${REQUIRED_HEIGHT}px image (4:3 ratio).`
                            );
                            resetInput();
                            return;
                        }

                        // ✅ VALID IMAGE
                        previewImg.src = img.src;
                        previewImg.style.display = 'block';
                        removeBtn.style.display = 'block';

                        if (index === 0) image1Valid = true;
                    };

                    img.src = URL.createObjectURL(file);
                });

                // ❌ REMOVE IMAGE BUTTON
                removeBtn.addEventListener('click', function() {
                    resetInput();
                    hidePreview();
                    clearError(input);

                    if (index === 0) image1Valid = false;
                });

                function resetInput() {
                    input.value = '';
                }

                function hidePreview() {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                    removeBtn.style.display = 'none';
                }
            });

        // 🚫 STOP SUBMIT IF IMAGE 1 INVALID
        form.addEventListener('submit', function(e) {
            // If no certificates exist AND image 1 is invalid/missing
            if (!hasExistingCertificates && !image1Valid) {
                e.preventDefault();
                alert('Certificate Image 1 is required and must be valid (480 × 360).');
            }
        });

        // Helpers
        function showError(input, message) {
            const error = document.createElement('small');
            error.className = 'text-danger image-error d-block mt-1';
            error.innerText = message;
            input.closest('.card-body').appendChild(error);
        }

        function clearError(input) {
            const error = input.closest('.card-body').querySelector('.image-error');
            if (error) error.remove();
        }
    });
</script>

<script>
    function sendData(name, value) {
        $.ajax({
            url: "{{ route('seller.edit.shipping-options') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                value: value
            },
            success: function(response) {
                toastr.success('Data saved successfully');
            },
            error: function(xhr) {
                console.log('Error saving data');
            }
        });
    }


    function statusCertificate(e) {
        var valStatus = e.target.value;
        sendData('isCertificate', valStatus);
    }

    $(document).ready(function() {
        $(".upload-btn").click(function() {
            let inputId = $(this).data("input");
            let previewId = $(this).data("preview");
            let fileInput = $("#" + inputId)[0];
            let previewImage = $("#" + previewId);

            if (fileInput.files && fileInput.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.attr("src", e.target.result);
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    });
</script>
@endsection