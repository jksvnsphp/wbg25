@extends('external-user.external-frame')


@section('meta_data')
    @if (request('country') != '')
        <title>Suppliers by Region across the Globe on World Business Guide</title>
        <meta name="description"
            content="Find Manufacturer, Wholesaler, Retailer & Service Provider listed by Region on World Business Guide – WBG24.com – Your international Market.">
        <meta name="keywords" content="Suppliers by Region, Manufacturer by Region, Wholesaler by Region">
        <meta name="author" content="WBG24.com">
    @else
        <title>Find Suppliers across the Globe on World Business Guide – WBG24</title>
        <meta name="description"
            content="Manufacturer, Wholesaler, Retailer & Service Provider meet across Industries worldwide in Order to fathom new Sale Markets and new Business Contacts.">
        <meta name="keywords" content="Manufacturer, Wholesaler, Retailer, Service Provider, Industries, Business Contacts">
        <meta name="author" content="WBG24.com">
    @endif
@endsection



@section('external-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-4 d-flex justify-content-end align-items-start sidebar">
                <nav class="navbar navbar-expand-lg w-100">
                    <p></p>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse w-100 navbar-collapse mx-0" style="margin-top: 1rem !important"
                        id="navbarSupportedContent">
                        <div class="w-100">
                            <h5 class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-filter me-2"></i> Filter
                            </h5>
                            <form method="get" action="{{ route('all.suppliers') }}" class="accordion my_filters w-100"
                                id="accordionExample">
                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fas fa-globe"></i>
                                                </span>
                                                <span>By Area</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <select id="selectCountry" name="country"
                                                    class="form-control form-control-sm">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->name }}"
                                                            {{ request('country') == $country->name ? 'selected' : '' }}>
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                </select>
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
                                            <div class="form-group mb-3">
                                                <select class="form-control form-control-sm" name="category"
                                                    id="categorySelect">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <select name="subcategory" class="form-control form-control-sm"
                                                    id="subCategorySelect">
                                                    <option value="">Select Subcategory</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingSeven">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fa fa-trophy"></i>
                                                </span>
                                                <span>By Business Type</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group ">
                                                <select name="business_type" class="form-control form-control-sm">
                                                    <option value="">Business Type</option>
                                                    @php
                                                        $businessTypes = [
                                                            'Manufacturer',
                                                            'Wholesaler',
                                                            'Retailer',
                                                            'Service Provider',
                                                        ];
                                                    @endphp
                                                    @foreach ($businessTypes as $type)
                                                        <option value="{{ $type }}"
                                                            {{ request('business_type') == $type ? 'selected' : '' }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item pt-2 w-100">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            <a href="#" class="d-flex align-items-center">
                                                <span class="me-2">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                                <span>By Product or Service</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group ">
                                                <input type="text" name="product_service"
                                                    value="{{ request('product_service') }}"
                                                    class="form-control form-control-sm" placeholder="Product & Service">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn w-100 btn-secondary mt-2">
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
                    
                </nav>
            </div>
            <div class="col-md-10 mb-4">
                <nav aria-label="breadcrumb" class="mb-2 mt-4 d-flex align-items-center justify-content-between">
                 <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}" class="text-primary">Back</a></li>
                        <li class="breadcrumb-item"><a href="/" class="text-primary">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Suppliers
                        </li>
                    </ol>
                                                    </nav>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        @forelse ($suppliers as $seller)
                            <div class="card mt-4 shadow rounded-0">
                                <div class="row">
                                    <div class="col-md-9 position-relative">
                                        <img src="https://flagcdn.com/40x30/{{ strtolower($seller->country->iso2) }}.png"
                                            class="position-absolute" style="top: 15px; right: 10px" alt="" />
                                        <div class="row product_describes">
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('seller.profile.view', $seller->ref_no) }}"
                                                    class="fs-5 text-primary fw-bolder"
                                                    style="font-weight: 900 !important;">{{ isset($seller->company->name) ? $seller->company->name : 'NA' }}</a>
                                                <div class="mt-2" style="font-size: 13px !important">
                                                    @php
                                                        $rating = $seller->average_rating ?? 0;
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
                                            <div class="mt-2">
                                                <div class="d-flex flex-wrap pt-2">
                                                    <h6 class="text-muted me-2">
                                                        Company Registered Year:
                                                    </h6>
                                                    <h6 class="d-block fw-bold">
                                                        {{ isset($seller->company->company_registeration_year) ? $seller->company->company_registeration_year : date('Y') }}
                                                    </h6>
                                                </div>
                                                <div class="d-flex flex-wrap pt-2">
                                                    <h6 class="text-muted me-2">Business Type:</h6>
                                                    <h6 class="text-one-line fw-bolder">
                                                        {{ isset($seller->company->business_type) ? $seller->company->business_type : 'NA' }}
                                                    </h6>
                                                </div>
                                                <div class="d-flex flex-xl-nowrap flex-wrap pt-2">
                                                    <h6 class="text-muted me-2" style="text-wrap: nowrap !important">
                                                        Products and Services:
                                                    </h6>
                                                    <h6 class="text-two-line fw-bolder">
                                                        {{ isset($seller->company['key1']) && $seller->company['key1'] != '' ? $seller->company['key1'] : '' }}
                                                        @for ($i = 2; $i <= 10; $i++)
                                                            {{ isset($seller->company['key' . $i]) && $seller->company['key' . $i] != '' ? ', ' . $seller->company['key' . $i] : '' }}
                                                        @endfor
                                                    </h6>
                                                </div>
                                                <div class="d-flex flex-wrap pt-4">
                                                    <h6 class="text-muted me-2" style="text-wrap: nowrap !important">
                                                        No Of Employees
                                                    </h6>
                                                    <h6 class="fw-bolder">
                                                        {{ isset($seller->company->key_personnal) ? $seller->company->key_personnal : '0' }}
                                                        People</h6>
                                                </div>
                                            </div>

                                            <div class="text-start icon_product justify-content-start flex-wrap px-0 mb-1">
                                                @php
                                                    $icons = $seller->symbols;
                                                @endphp
                                                @if ($icons)
                                                    @if ($icons->isTradeAssurance)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Trade Assurance">
                                                            <img src="{{ asset('world-business/images/icons/ic1.jpg') }}"
                                                                style="height: 40px" alt="Trade Assurance" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isTrustSeal)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Trust Seal">
                                                            <img src="{{ asset('world-business/images/icons/ic2.jpg') }}"
                                                                style="height: 40px" alt="Trust Seal" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isAssessedSupplier)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Assessed Supplier">
                                                            <img src="{{ asset('world-business/images/icons/ic3.jpg') }}"
                                                                style="height: 40px" alt="Assessed Supplier" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isOnsiteChecked)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Onsite Checked (Advance)">
                                                            <img src="{{ asset('world-business/images/icons/ic4.jpg') }}"
                                                                style="height: 40px" alt="Onsite Checked" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isProductVerified)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Production Verified">
                                                            <img src="{{ asset('world-business/images/icons/ic5.jpg') }}"
                                                                style="height: 40px" alt="Production Verified" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isStoreFavorite)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Store Favorite">
                                                            <img src="{{ asset('world-business/images/icons/ic6.jpg') }}"
                                                                style="height: 40px" alt="Store Favorite" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isEmailVerified)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Email Verified">
                                                            <img src="{{ asset('world-business/images/icons/ic7.jpg') }}"
                                                                style="height: 40px" alt="Email Verified" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isCategoryBest)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Category Best">
                                                            <img src="{{ asset('world-business/images/icons/ic8.jpg') }}"
                                                                style="height: 40px" alt="Category Best" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isSecureTransaction)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Secure Transaction">
                                                            <img src="{{ asset('world-business/images/icons/ic9.jpg') }}"
                                                                style="height: 40px" alt="Secure Transaction" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isSecurity)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Security">
                                                            <img src="{{ asset('world-business/images/icons/ic10.jpg') }}"
                                                                style="height: 40px" alt="Security" />
                                                        </a>
                                                    @endif

                                                    @if ($icons->isSupport)
                                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="24*7 Support">
                                                            <img src="{{ asset('world-business/images/icons/ic11.jpg') }}"
                                                                style="height: 40px" alt="24*7 Support" />
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3" style="border-left: 1px solid #ddd">
                                        <div class="d-flex mb-3 justify-content-center py-4" style="height: 7rem">
                                            <img style="height: 6rem; width: 100%; object-fit: contain"
                                                src="
                                                @if (isset($seller->company->company_logo) && $seller->company->company_logo != '') {{ asset('uploads/profile/' . $seller->company->company_logo) }}
                                                    @else
                                                    {{ asset('uploads/logo/default-logo.png') }} @endif
                                                "
                                                alt="" />
                                        </div>
                                        <div class="card-body">
                                            @if(isset($seller->sellerPackageOne->package->type) && ($seller->sellerPackageOne->package->type=="platinum" || $seller->sellerPackageOne->package->type=="gold"))
                                              <a href="{{ route('seller.spotlight', $seller->ref_no) }}" class="btn w-100 btn-secondary mt-2">Spotlight Store</a>
                                            @endif
                                            <a href="{{ route('seller.profile.view', $seller->ref_no) }}"
                                                class="btn w-100 btn-primary mt-2">Business Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h4 class="text-danger fw-bold text-center mt-3">Sorry! suppliers not found!</h4>
                        @endforelse
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 d-flex justify-content-center">
                        <div class="col-12 mt-5">
                            <div class="d-flex justify-content-center ">
                                {{ $suppliers->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>

                </div>
            </div>
        </div>
    </section>
   @include('external-user.inc-parts.listCard')
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
                                <input type="hidden" name="receiver_id" id="receiverid" value="">

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
        function fetchSubCategory() {
            let categoryId = $('#categorySelect').val();
            // alert(categoryId);
            if (categoryId) {
                $.ajax({
                    url: '{{ route('all.supplier-subcategory') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: categoryId
                    },
                    success: function(response) {
                        let subCategorySelect = $('#subCategorySelect');
                        subCategorySelect.empty();
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            var oldSubCategory = "{{ request('subcategory') }}";
                            $.each(data, function(key, subcategory) {
                                var selected = (oldSubCategory == subcategory.id) ? 'selected' : '';
                                subCategorySelect.append('<option ' + selected + ' value="' +
                                    subcategory.id +
                                    '">' +
                                    subcategory.category_name + '</option>');
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
        }
        $('#categorySelect').on('change', function() {
            fetchSubCategory();
        });
        fetchSubCategory();
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
            $('.openmodalbtn').on('click', function() {
                const dataId = $(this).data('id');
                $('#receiverid').val(dataId);
            });
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
