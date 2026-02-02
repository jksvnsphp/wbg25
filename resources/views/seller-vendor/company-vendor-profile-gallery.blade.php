@extends('seller-vendor.seller-frame')
@section('seller-main-content')
<style>
    .preview-wrapper {
        position: relative;
        display: inline-block;
    }

    .preview-img {
        height: 8rem;
        width: 8rem;
        border: 1px solid #bcbcbc;
        border-radius: 4px;
        object-fit: cover;
    }

    .img-remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        padding: 2px 6px;
        line-height: 1;
        z-index: 10;
    }
</style>
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
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="form-group mb-2">
                                                <label for="profile" class="form-label fw-bold">
                                                    Profile Picture
                                                    <span class="text-secondary">(Max Size: 500 × 500 px)</span>
                                                </label>

                                                <input
                                                    type="file"
                                                    id="profile"
                                                    name="profile"
                                                    class="form-control image-validate"
                                                    data-width="500"
                                                    data-height="500">
                                            </div>

                                            <div class="preview-wrapper mt-2">
                                                <img
                                                    id="profilePreview"
                                                    class="preview-img {{ auth()->user()->profile ? '' : 'd-none' }}"
                                                    src="{{ auth()->user()->profile ? asset('uploads/profile/'.auth()->user()->profile) : '' }}">

                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm img-remove-btn {{ auth()->user()->profile ? '' : 'd-none remove-btn' }}"
                                                    data-input="profile"
                                                    data-preview="profilePreview"
                                                    id="{{ auth()->user()->profile ? 'delete-profile-picture-btn' : '' }}">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="card shadow">
                                        <div class="card-body">

                                            <div class="form-group mb-2">
                                                <label for="company_logo" class="form-label fw-bold">
                                                    Company Logo
                                                    <span class="text-secondary">(Max Size: 400 × 400 px)</span>
                                                </label>

                                                <input
                                                    type="file"
                                                    id="company_logo"
                                                    name="company_logo"
                                                    class="form-control image-validate"
                                                    data-width="400"
                                                    data-height="400">
                                            </div>

                                            <div class="preview-wrapper mt-2">
                                                <img
                                                    id="company_logoPreview"
                                                    class="preview-img {{ isset($user->company->company_logo) && $user->company->company_logo ? '' : 'd-none' }}"
                                                    src="{{ isset($user->company->company_logo) && $user->company->company_logo ? asset('uploads/profile/'.$user->company->company_logo) : '' }}"
                                                    alt="Company Logo">

                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm img-remove-btn {{ isset($user->company->company_logo) && $user->company->company_logo ? '' : 'd-none remove-btn' }}"
                                                    data-input="company_logo"
                                                    data-preview="company_logoPreview"
                                                    id="{{ isset($user->company->company_logo) && $user->company->company_logo ? 'delete-business-logo-picture-btn' : '' }}">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card shadow mt-4">
                                        <div class="card-body">

                                            <div class="form-group mb-2">
                                                <label for="profile_banner" class="form-label fw-bold">
                                                    Business Profile Banner
                                                    <span class="text-secondary">(Max Size: 2520 × 620 px)</span>
                                                </label>

                                                <input
                                                    type="file"
                                                    id="profile_banner"
                                                    name="profile_banner"
                                                    class="form-control image-validate"
                                                    data-width="2520"
                                                    data-height="620">
                                            </div>

                                            <div class="preview-wrapper mt-2 w-100">
                                                <img
                                                    id="profile_bannerPreview"
                                                    class="preview-img {{ isset($user->company->profile_banner) && $user->company->profile_banner ? '' : 'd-none' }}"
                                                    src="{{ isset($user->company->profile_banner) && $user->company->profile_banner ? asset('uploads/profile/'.$user->company->profile_banner) : '' }}"
                                                    alt="Business Banner"
                                                    style="width:100%; height:6rem; object-fit:cover;">

                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm img-remove-btn {{ isset($user->company->profile_banner) && $user->company->profile_banner ? '' : 'd-none remove-btn' }}"
                                                    data-input="profile_banner"
                                                    data-preview="profile_bannerPreview"
                                                    id="{{ isset($user->company->profile_banner) && $user->company->profile_banner ? 'delete-business-banner-picture-btn' : '' }}">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <h5 class="fs-5 fw-bold">Business Profile Gallery</h5>
                                        <div class="col-md-6 mt-4">
                                            <div class="card shadow">
                                                <div class="card-body">

                                                    <div class="form-group mb-2">
                                                        <label for="image_1" class="form-label fw-bold">
                                                            Image 1
                                                            <span class="text-secondary">(Max Size: 500 × 500 px)</span>
                                                        </label>

                                                        <input
                                                            type="file"
                                                            id="image_1"
                                                            name="image_1"
                                                            class="form-control image-validate"
                                                            data-width="500"
                                                            data-height="500">
                                                        <input type="hidden" name="col[]" value="image_1">
                                                    </div>

                                                    <div class="preview-wrapper mt-2">
                                                        <img
                                                            id="image_1Preview"
                                                            class="preview-img {{ isset($user->company->image_1) && $user->company->image_1 ? '' : 'd-none' }}"
                                                            src="{{ isset($user->company->image_1) && $user->company->image_1 ? asset('uploads/profile/'.$user->company->image_1) : '' }}"
                                                            alt="Gallery Image 1"
                                                            style="width:8rem;height:8rem;object-fit:cover;">

                                                        @if(isset($user->company->image_1) && $user->company->image_1)
                                                        <!-- SERVER DELETE -->
                                                        <a href="{{ route('delete.vendor.gallery', 'image_1') }}"
                                                            class="btn btn-danger btn-sm img-remove-btn confirm-delete">
                                                            ✕
                                                        </a>
                                                        @else
                                                        <!-- CLIENT SIDE REMOVE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm img-remove-btn remove-btn d-none"
                                                            data-input="image_1"
                                                            data-preview="image_1Preview">
                                                            ✕
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="card shadow">
                                                <div class="card-body">

                                                    <div class="form-group mb-2">
                                                        <label for="image_2" class="form-label fw-bold">
                                                            Image 2
                                                            <span class="text-secondary">(Max Size: 500 × 500 px)</span>
                                                        </label>

                                                        <input
                                                            type="file"
                                                            id="image_2"
                                                            name="image_2"
                                                            class="form-control image-validate"
                                                            data-width="500"
                                                            data-height="500">
                                                        <input type="hidden" name="col[]" value="image_2">
                                                    </div>

                                                    <div class="preview-wrapper mt-2">
                                                        <img
                                                            id="image_2Preview"
                                                            class="preview-img {{ isset($user->company->image_2) && $user->company->image_2 ? '' : 'd-none' }}"
                                                            src="{{ isset($user->company->image_2) && $user->company->image_2 ? asset('uploads/profile/'.$user->company->image_2) : '' }}"
                                                            alt="Gallery Image 2"
                                                            style="width:8rem;height:8rem;object-fit:cover;">

                                                        @if(isset($user->company->image_2) && $user->company->image_2)
                                                        <!-- SERVER DELETE -->
                                                        <a href="{{ route('delete.vendor.gallery', 'image_2') }}"
                                                            class="btn btn-danger btn-sm img-remove-btn confirm-delete">
                                                            ✕
                                                        </a>
                                                        @else
                                                        <!-- CLIENT SIDE REMOVE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm img-remove-btn remove-btn d-none"
                                                            data-input="image_2"
                                                            data-preview="image_2Preview">
                                                            ✕
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="card shadow">
                                                <div class="card-body">

                                                    <div class="form-group mb-2">
                                                        <label for="image_3" class="form-label fw-bold">
                                                            Image 3
                                                            <span class="text-secondary">(Max Size: 500 × 500 px)</span>
                                                        </label>

                                                        <input
                                                            type="file"
                                                            id="image_3"
                                                            name="image_3"
                                                            class="form-control image-validate"
                                                            data-width="500"
                                                            data-height="500">
                                                        <input type="hidden" name="col[]" value="image_3">
                                                    </div>

                                                    <div class="preview-wrapper mt-2">
                                                        <img
                                                            id="image_3Preview"
                                                            class="preview-img {{ isset($user->company->image_3) && $user->company->image_3 ? '' : 'd-none' }}"
                                                            src="{{ isset($user->company->image_3) && $user->company->image_3 ? asset('uploads/profile/'.$user->company->image_3) : '' }}"
                                                            alt="Gallery Image 3"
                                                            style="width:8rem;height:8rem;object-fit:cover;">

                                                        @if(isset($user->company->image_3) && $user->company->image_3)
                                                        <!-- SERVER DELETE -->
                                                        <a href="{{ route('delete.vendor.gallery', 'image_3') }}"
                                                            class="btn btn-danger btn-sm img-remove-btn confirm-delete">
                                                            ✕
                                                        </a>
                                                        @else
                                                        <!-- CLIENT SIDE REMOVE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm img-remove-btn remove-btn d-none"
                                                            data-input="image_3"
                                                            data-preview="image_3Preview">
                                                            ✕
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="card shadow">
                                                <div class="card-body">

                                                    <div class="form-group mb-2">
                                                        <label for="image_4" class="form-label fw-bold">
                                                            Image 4
                                                            <span class="text-secondary">(Max Size: 500 × 500 px)</span>
                                                        </label>

                                                        <input
                                                            type="file"
                                                            id="image_4"
                                                            name="image_4"
                                                            class="form-control image-validate"
                                                            data-width="500"
                                                            data-height="500">
                                                        <input type="hidden" name="col[]" value="image_4">
                                                    </div>

                                                    <div class="position-relative d-inline-block mt-2">
                                                        <img
                                                            id="image_4Preview"
                                                            class="preview-img {{ isset($user->company->image_4) && $user->company->image_4 ? '' : 'd-none' }}"
                                                            src="{{ isset($user->company->image_4) && $user->company->image_4 ? asset('uploads/profile/'.$user->company->image_4) : '' }}"
                                                            alt="Gallery Image 4"
                                                            style="width:8rem;height:8rem;object-fit:cover;">

                                                        @if(isset($user->company->image_4) && $user->company->image_4)
                                                        <!-- SERVER DELETE -->
                                                        <a href="{{ route('delete.vendor.gallery', 'image_4') }}"
                                                            class="btn btn-danger btn-sm img-remove-btn confirm-delete">
                                                            ✕
                                                        </a>
                                                        @else
                                                        <!-- CLIENT SIDE REMOVE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm img-remove-btn remove-btn d-none"
                                                            data-input="image_4"
                                                            data-preview="image_4Preview">
                                                            ✕
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
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

    document.addEventListener('DOMContentLoaded', function() {

        const MAX_SIZE_MB = 2;

        document.querySelectorAll('.image-validate').forEach(input => {

            input.addEventListener('change', function() {

                clearError(input);

                const file = input.files[0];
                if (!file) return;

                const maxWidth = parseInt(input.dataset.width);
                const maxHeight = parseInt(input.dataset.height);

                const preview = document.getElementById(input.id + 'Preview');
                const removeBtn = document.querySelector(
                    `.remove-btn[data-input="${input.id}"]`
                );

                // File size
                if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                    showError(input, `Image size must not exceed ${MAX_SIZE_MB}MB.`);
                    reset(input, preview, removeBtn);
                    return;
                }

                // File type
                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                    showError(input, 'Only JPG or PNG images are allowed.');
                    reset(input, preview, removeBtn);
                    return;
                }

                const img = new Image();
                img.onload = () => {

                    // ❌ Reject ONLY if both exceed
                    if (img.width > maxWidth && img.height > maxHeight) {
                        showError(
                            input,
                            `Image too large. Max allowed ${maxWidth}×${maxHeight}px.`
                        );
                        reset(input, preview, removeBtn);
                        return;
                    }

                    // ✅ VALID
                    preview.src = img.src;
                    preview.classList.remove('d-none');
                    removeBtn.classList.remove('d-none');
                };

                img.src = URL.createObjectURL(file);
            });
        });

        // REMOVE BUTTON HANDLER
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {

                const input = document.getElementById(this.dataset.input);
                const preview = document.getElementById(this.dataset.preview);

                input.value = '';
                preview.src = '';
                preview.classList.add('d-none');
                this.classList.add('d-none');

                clearError(input);
            });
        });

        function reset(input, preview, btn) {
            input.value = '';
            if (preview) preview.classList.add('d-none');
            if (btn) btn.classList.add('d-none');
        }

        function showError(input, message) {
            const error = document.createElement('small');
            error.className = 'text-danger image-error d-block mt-1';
            error.innerText = message;
            input.closest('.form-group')?.appendChild(error) ||
                input.parentNode.appendChild(error);
        }

        function clearError(input) {
            const error =
                input.closest('.form-group')?.querySelector('.image-error') ||
                input.parentNode.querySelector('.image-error');
            if (error) error.remove();
        }

    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.confirm-delete').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete this image?')) {
                    window.location.href = this.href;
                }
            });
        });
    });
</script>
@endsection