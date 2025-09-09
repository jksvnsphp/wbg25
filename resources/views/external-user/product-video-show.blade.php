@extends('external-user.external-frame')
@section('meta_data')
    <title>Product Videos across the Globe on World Business Guide – WBG24</title>
    <meta name="description"
        content="View the newest Product Videos from Suppliers across the Globe and get detailed Informations on World Business Guide – WBG24.com – Your international Market.">
    <meta name="keywords" content="View Product Videos, List Product Video, Product Videos">
    <meta name="author" content="WBG24.com">
@endsection
@section('external-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-4 d-flex justify-content-end align-items-start sidebar">
                <nav class="navbar  navbar-expand-lg w-100">
                    <p></p>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse w-100 navbar-collapse mx-0" style="margin-top: 1rem !important"
                        id="navbarSupportedContent">
                        <form method="get" action="{{ route('all.product-video.show') }}" class="w-100">
                            <h5 class="btn btn-primary d-flex  align-items-center">
                                <i class="fas fa-filter me-2"></i> Filter
                            </h5>
                            <div class="accordion my_filters w-100" id="accordionExample">
                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fas fa-money-bill"></i>
                                                </span>
                                                <span>By Product</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <input name="product_name" value="{{ request('product_name') }}"
                                                    type="text" class="form-control form-control-sm"
                                                    placeholder="Product Name" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fa-solid fa-bars"></i>
                                                </span>
                                                <span>By Categories</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <select name="category" class="form-control form-control-sm"
                                                    id="categorySelect">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option @selected(request('category') == $category->id) value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-1">
                                                <select name="subcategory" class="form-control form-control-sm"
                                                    id="subCategorySelect">
                                                    <option value="">Select Subcategory</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fa-solid fa-trophy"></i>
                                                </span>
                                                <span>By Supplier</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <select name="supplier" class="form-control form-control-sm">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option @selected(request('supplier') == $supplier->id) value="{{ $supplier->id }}">
                                                            {{ $supplier->company->name ?? 'NA' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </span>
                                                <span>By Country</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <select name="country" id="selectCountry"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option @selected(request('country') == $country->name) value="{{ $country->name }}">
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-secondary mt-3 d-block w-100">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
            <div class="col-md-10 mb-4">



                <!-- Products -->
                <nav aria-label="breadcrumb" class="mb-2 mt-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="text-primary">Back</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-primary">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product Video Show
                        </li>
                    </ol>
                </nav>

                <div class="row mt-5">
                    @foreach ($products as $product)
                        <div class="col-md-4 col-sm-6 col-12 mb-3">
                            <div class="card bg-white rounded-0 shadow">
                                <div class=" card-header d-flex bg-white justify-content-between">
                                    <div>
                                        <h5 class="fw-bold fs-6"><a
                                                href="{{ route('seller.profile.view', $product->vendor->ref_no) }}"
                                                class="text-primary fw-bold">
                                                {{ $product->vendor->company->name ?? '' }}
                                            </a></h5>
                                        <div class="d-flex mt-2 justify-content-start">
                                            @php
                                                $rating = $product->average_rating ?? 0;
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
                                    </div>
                                    <img title="{{ $product->country->name }}" style="height:30px !important;"
                                        src="https://flagcdn.com/40x30/{{ strtolower($product->country->iso2) }}.png" />

                                </div>
                                <div class="card-body">

                                    <p><a href="{{ route('product.detail', $product->slug) }}"
                                            class="fw-semibold text-dark">{{ $product->name }}</a></p>
                                    <div class="mt-3 mx-auto" style="height: 9rem; width: 100%;">
                                        <video id="my-video" class="video-js vjs-default-skin" controls preload="auto"
                                            style="height: 100%; width:100%">
                                            <source
                                                src="{{ asset('uploads/products/videos/' . $product->video->video_url) }}"
                                                type="video/mp4" />
                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider
                                                upgrading to a web browser that supports HTML5 video</p>
                                        </video>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('product.detail', $product->slug) }}"
                                            class="btn btn-primary">View Offer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endsection
@section('custom-js-external')
    <script>
        $('#categorySelect').on('change', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '{{ route('all.products-subcategory') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: categoryId
                    },
                    success: function(response) {
                        let subCategorySelect = $('#subCategorySelect');
                        subCategorySelect.empty(); // Clear existing options
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            $.each(data, function(key, subcategory) {
                                subCategorySelect.append('<option value="' + subcategory.id +
                                    '">' +
                                    subcategory.name + '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subCategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#selectCountry').change(function() {
                var countryId = $(this).val();

                if (countryId) {

                    $.ajax({
                        url: '{{ route('all.country.states') }}',
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
        $(document).ready(function() {
            $('video.video-js').each(function() {
                var videoId = $(this).attr('id');
                videojs(videoId, {
                    controls: true,
                    autoplay: false,
                    preload: 'auto',
                    loop: false,
                    muted: false,
                    fluid: false
                });
            });
        });
    </script>
@endsection
