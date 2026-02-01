@extends('external-user.external-frame')
@section('meta_data')
<title>{{ $seller->store_meta->title ?? 'WBG24' }}</title>
<meta name="description" content="{{ $seller->store_meta->description ?? 'No Description' }}">
<meta name="keywords" content="{{ $seller->store_meta->keywords ?? '' }} @for ($i = 1; $i <= 10; $i++) {{ $seller['store_keys']['key' . $i] ?? '' }}, @endfor ">
<meta name="author" content="{{ $seller->company->name ?? '' }}">
@endsection
@section('external-main-content')
<style>
    .company_logo {
        position: absolute;
        left: 50%;
        bottom: 5%;
        transform: translateX(-50%);
        height: 10rem;
        border: 3px solid #fff;
        background: white;
        border-radius: 5px;
    }

    .accordion-button:focus,
    .accordion-button:hover {
        box-shadow: unset !important;
        border: 0px !important;
        background-color: unset !important;
        color: #000 !important;
    }

    .accordion-button {
        color: #000 !important;
        background-color: #fff !important;
        padding: 5px !important;
        border: none !important;
        box-shadow: unset !important;
        outline: none !important;
        font-size: 15px !important;
        font-weight: bold !important;
    }

    .accordion-body {
        padding: 5px !important;
    }

    .accordion-body ul {
        margin-left: 0px !important;
        padding-left: 0px !important;
        color: #000 !important;
    }

    .accordion-body ul li {
        margin-bottom: 10px !important;
        font-size: 15px !important;
    }

    .accordion-body ul li a {
        color: #000 !important;

    }

    .accordion-button .icon {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f067";
        /* Unicode for plus icon */
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    /* Expanded state: Minus icon */
    .accordion-button:not(.collapsed) .icon {
        content: "\f068";
        /* Unicode for minus icon */
    }

    .accordion-button::after {
        content: none !important;
        background: none !important;
    }

    .clamp-two-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .company_logo img {
        height: 100%;
        width: 100%;
        object-fit: contain;
        object-position: center;
    }

    .btn-outline-primary {
        border-color: midnightblue;
        color: midnightblue !important
    }
</style>
<section class="container-fluid">
    <div class="row">

        <div class="col-12 company_header bg-info position-relative" style="height: 17rem">
            <img src="@if (isset($seller->company->spotlight_banner) && $seller->company->spotlight_banner != '') {{ asset('uploads/profile/' . $seller->company->spotlight_banner) }}
                             @else
                             {{ asset('world-business/images/copy_icon.png') }} @endif"
                class="position-absolute h-100 w-100 object-fit-cover"
                style="top:0;bottom:0; right:0; left:0; object-position:center;" alt="">
            <div class="company_logo d-none overflow-hidden">
                <img src="@if (isset($seller->company->company_logo) && $seller->company->company_logo != '') {{ asset('uploads/profile/' . $seller->company->company_logo) }}
                             @else
                             {{ asset('uploads/logo/default-logo.png') }} @endif"
                    alt="">
            </div>
        </div>
        <div class="col-12">
            <div class="card rounded-0 border-0 bg-body-tertiary  ">
                <div class="card-body d-flex justify-content-between w-100">
                    <div class="company_info d-flex align-items-center ">
                        <div style="height: 5rem; width:auto; border:2px solid #a6a6a6;"
                            class="me-2 rounded-2 d-flex overflow-hidden justify-content-center align-items-center">
                            <img src="@if (isset($seller->company->company_logo) && $seller->company->company_logo != '') {{ asset('uploads/profile/' . $seller->company->company_logo) }}
                             @else
                             {{ asset('uploads/logo/default-logo.png') }} @endif"
                                class="h-100 w-100 " alt="">
                        </div>
                        <div class="company_data">
                            <h6 class="fs-5  text-capitalize" style="font-weight: 800 !important;">
                                {{ $seller->company->name }}
                            </h6>
                            <div class="rating_company d-flex  my-2">
                                @php
                                $rating = $seller->rating ?? 0;
                                $fullStars = floor($rating);
                                $emptyStars = 5 - $fullStars;
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star text-secondary"></i>
                                    @endfor
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fas fa-star " style="color:gray;"></i>
                                        @endfor
                            </div>
                            <small class="text-muted ">{{ $seller->total_sold ?? 0 }}+ Items sold</small>
                        </div>
                    </div>
                    <div
                        class="compnay_contact d-flex align-items-center justify-content-md-end justify-content-center ">
                        <!-- <a href="" class="text-dark me-2">
                            <i class="fa fa-share-alt-square " aria-hidden="true"></i>
                            Share
                        </a> -->
                        <a data-bs-toggle="modal" data-bs-target="#contactseller" href="javaScript:void(0)"
                            class="text-dark me-2">
                            <i class="fa fa-envelope " aria-hidden="true"></i>
                            Contact Seller
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-md-end justify-content-center">
                        <a href="{{ route('seller.profile.view', $seller->ref_no) }}"
                            class=" btn btn-primary fw-bolder">Business Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-3 col-sm-4 d-flex justify-content-end align-items-start">
            <div class="accordion mx-0 w-100" id="categoryAccordion">
                <!-- Loop through parent categories -->
                @foreach ($categoryTree as $parentCategory)
                <div class="accordion-item rounded-0 border-0">
                    <h2 class="accordion-header" id="heading{{ $parentCategory['id'] }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $parentCategory['id'] }}" aria-expanded="false"
                            aria-controls="collapse{{ $parentCategory['id'] }}">
                            {{ $parentCategory['name'] }}
                            <i class="fas fa-plus icon"></i>
                        </button>
                    </h2>
                    <div id="collapse{{ $parentCategory['id'] }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $parentCategory['id'] }}" data-bs-parent="#categoryAccordion">
                        <div class="accordion-body">
                            <ul>
                                <!-- Loop through child categories -->
                                @foreach ($parentCategory['categories'] as $category)
                                <li>
                                    <a
                                        href="{{ route('seller.spotlight', [$seller->ref_no, $category['slug']]) }}">{{ $category['name'] }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <div class="col-md-9 mb-4">
            <!-- Products -->

            <div class="card border-0 rounded-0">
                <div class="card-header bg-white border-0">
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <h4 class="fw-bolder fs-5">Our Products</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group rounded-pill">
                                <span class=" input-group-text bg-white rounded-start-pill border-right-0">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="search" class="form-control rounded-end-pill border-left-0 "
                                    placeholder="Search for products, brands,
                                    categories or more"
                                    aria-label="Search" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                @foreach ($products as $product)
                @php
                // Decode variants safely
                $variants = is_string($product->variants)
                ? json_decode($product->variants, true)
                : $product->variants;
                $variants = is_array($variants) ? $variants : [];

                // Collect all images from combinations
                $allImages = [];
                $prices = [];
                foreach ($variants as $variant) {
                if (!empty($variant['images']) && is_array($variant['images'])) {
                $allImages = array_merge($allImages, $variant['images']);
                }
                if (isset($variant['price']) && is_numeric($variant['price'])) {
                $prices[] = $variant['price'];
                }
                }

                // Pick the first valid image
                $previewImage = !empty($allImages) ? asset('uploads/products/' . $allImages[0]) : null;
                $minPrice = !empty($prices) ? min($prices) : $product->minPrice ?? 1;
                // Fallback to gallery or placeholder
                if (empty($previewImage)) {
                $previewImage =
                isset($product->gallery[0]->image) && !empty($product->gallery[0]->image)
                ? asset('uploads/products/gallery/' . $product->gallery[0]->image)
                : 'https://placehold.co/600x400';
                }
                @endphp
                <a href="{{ route('product.detail', $product->slug) }}" class="col-md-4 col-lg-3 mt-3 d-block">
                    <div class="card border-0 rounded-2">
                        <div class="card-img-top d-flex justify-content-center">
                            <img class="img-fluid rounded-2" style="max-height: 11rem;" src="{{ $previewImage }}"
                                alt="">
                        </div>
                        <div class="card-body pt-2 text-center">
                            <p class="fw-semibold clamp-two-lines" style="line-height:1.2;">
                                {{ $product->name }}
                            </p>
                            <span class="fw-bold d-block fs-6 mt-2">
                                Price: $
                                @if ($product->isMultiple == 1)
                                {{ number_format($minPrice, 2) }}
                                @else
                                @if (isset($product->isPrice0) && $product->isPrice0 == 1)
                                {{ $product->price0 }}
                                @elseif (isset($product->isPrice1) && $product->isPrice1 == 1)
                                {{ $product->price1 }}
                                @elseif (isset($product->isPrice2) && $product->isPrice2 == 1)
                                {{ $product->price2 }}
                                @else
                                {{ $product->price3 }}
                                @endif
                                @endif
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center ">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@include('external-user.inc-parts.listCard')

<div class="mt-3 px-3">
    <button type="button" onclick="window.history.back()" class="btn btn-primary text-light">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>
<div class="modal fade" id="contactseller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Contact Seller</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="contact_form" class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="receiver_id" value="{{ $seller->id }}">
                            <div class="form-group mb-2">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" />
                                <div id="name_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="subject" class="form-label">Subject:</label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ old('subject') }}" />
                                <div id="subject_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="message" class="form-label">Message:</label>
                                <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>
                                <div id="message_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="form-group d-flex flex-column mb-3">
                                <label for="image" class="form-label">Verification Code:</label>
                                <div class="d-flex align-items-center">
                                    {!! captcha_img('flat', ['id' => 'captcha_img']) !!}
                                    <i class="fa-solid fa-rotate mx-3" onclick="refreshCaptcha()"
                                        style="cursor: pointer !important"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="form-group mb-3">
                                <label for="ver_box" class="form-label">Enter Verification Code:</label>
                                <input type="text" value="{{ old('captcha') }}" class="form-control"
                                    name="captcha" id="captcha" />
                                <div id="captcha_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary mt-3">Send</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js-external')
<script>
    $(document).ready(function() {
        // When parent category is selected
        $('#category_level1').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{ route("public.get.subcategory") }}',
                    type: 'POST',
                    data: {
                        category_id: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#category_container').find('#category_level22')
                                .remove();
                            $('#category_container').find('#category_level33')
                                .remove();
                            $('#category_container').find('#category_level44')
                                .remove();

                            var subcategoryHtml =
                                '<div class="form-group mb-2" id="category_level22">' +
                                '<select name="subcategory" id="category_level2" class="form-select form-select-sm">' +
                                '<option value="">Select Sub Category</option>';
                            $.each(response, function(index, subCategory) {
                                subcategoryHtml += '<option value="' + subCategory
                                    .id + '">' + subCategory.name + '</option>';
                            });
                            subcategoryHtml += '</select></div>';
                            $('#category_container').append(
                                subcategoryHtml);
                        }
                    }
                });
            }
        });

        // When subcategory is selected
        $(document).on('change', '#category_level2', function() {
            var subCategoryId = $(this).val();
            if (subCategoryId) {
                $.ajax({
                    url: '{{ route("public.get.subsubcategory") }}',
                    type: 'POST',
                    data: {
                        sub_category_id: subCategoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#category_container').find('#category_level33')
                                .remove();
                            $('#category_container').find('#category_level44')
                                .remove();

                            var subSubCategoryHtml =
                                '<div class="form-group mb-2" id="category_level33">' +
                                '<select name="childcategory" id="category_level3" class="form-select form-select-sm">' +
                                '<option value="">Select Child Category</option>';
                            $.each(response, function(index, subSubCategory) {
                                subSubCategoryHtml += '<option value="' +
                                    subSubCategory.id + '">' + subSubCategory.name +
                                    '</option>';
                            });
                            subSubCategoryHtml += '</select></div>';
                            $('#category_container').append(
                                subSubCategoryHtml);
                        }
                    }
                });

            }
        });

        // When sub-subcategory is selected
        $(document).on('change', '#category_level3', function() {
            var subSubCategoryId = $(this).val();
            if (subSubCategoryId) {
                $.ajax({
                    url: '{{ route("public.get.childcategory") }}',
                    type: 'POST',
                    data: {
                        sub_sub_category_id: subSubCategoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#category_container').find('#category_level44')
                                .remove(); // Remove previous level 4 if exists

                            var childCategoryHtml =
                                '<div class="form-group mb-2" id="category_level44">' +
                                '<select name="endcategory" id="category_level4" class="form-select form-select-sm">' +
                                '<option value="">Select End Category</option>';
                            $.each(response, function(index, childCategory) {
                                childCategoryHtml += '<option value="' +
                                    childCategory.id + '">' + childCategory.name +
                                    '</option>';
                            });
                            childCategoryHtml += '</select></div>';
                            $('#category_container').append(
                                childCategoryHtml); // Append to category_container
                        }
                    }
                });
            }
        });



    });
</script>

<script>
    $(document).ready(function() {
        $('#selectCountry').change(function() {
            var countryId = $(this).val();

            if (countryId) {

                $.ajax({
                    url: '{{ route("all.country.states") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: countryId
                    },
                    success: function(data) {
                        $('#selectState').empty();
                        $('#selectState').append('<option value="">Select State</option>');

                        $.each(data.states, function(key, value) {
                            $('#selectState').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to load states.');
                    }
                });
            } else {
                $('#selectState').empty();
                $('#selectState').append('<option value="">Select State</option>');
            }
        });
    });
</script>

<script>
    function refreshCaptcha() {
        $.ajax({
            type: 'GET',
            url: "{{ route('refreshCaptcha') }}",
            success: function(data) {
                $('#captcha_img').attr('src', data);
            },
            error: function() {
                alert('Error refreshing CAPTCHA. Please try again.');
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#contact_form').on('submit', function(e) {
            e.preventDefault();
            $('#name_error').text('');
            $('#subject_error').text('');
            $('#message_error').text('');
            $('#captcha_error').text('');
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('send.contact.form2') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#contact_form')[0].reset();
                        $('#contactseller').modal('hide');
                    } else if (response.status === 'error') {
                        $.each(response.errors, function(key, value) {
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else if (response.status === 'unauth') {
                        Swal.fire({
                            title: "<h5 class='fw-bolder fs-5'>To use this option you need to</h5>",
                            text: "",
                            icon: "",
                            draggable: true,
                            confirmButtonText: "Sign in",
                            confirmButtonColor: "#FF7519",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "{{ route('login') }}";
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endsection