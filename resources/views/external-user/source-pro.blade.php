@extends('external-user.external-frame')

@section('meta_data')
    <title>Source Pro across the Globe on World Business Guide – WBG24</title>
    <meta name="description"
        content="Source Pro on World Business Guide – WBG24.com - enable you to respond to individual and specific Product Requests in order to generate new Business Deals.">
    <meta name="keywords" content="Source Pro, Product Requests, B2B Requests, Business Deals">
    <meta name="author" content="WBG24.com">
@endsection

@section('external-main-content')
    <style>
        .clamped-text {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            -webkit-line-clamp: 1;
        }

        .clamped-text2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
        }
    </style>
    <!-- information section -->
    <section class="scp_hero mb-0 w-100">
        <img src="{{ asset('world-business/images/bant.jpg') }}" class="img-fluid w-100" alt="" />
    </section>
    <div class=" w-100">

        <section class="container  py-3 pt-0">
            <div class="row pb-3 pt-3 shadow" style="border: 1px solid #ddd">
                <div class="col-md-12">
                    <form method="get" action="{{ route('user.source-pro') }}" class="accordion my_filters py-3  w-100"
                        style="background-color: #fff !important;" id="accordionExample">
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <select class="form-control form-select" name="order_type" id="order_type">
                      <option @selected(request('order_type')=="all") value="all">All quotation</option>
                      <option @selected(request('order_type')=="expired-soon") value="expired-soon">Ending Soonest</option>
                      <option @selected(request('order_type')=="latest") value="latest">Newly Listed</option>
                    </select>
                                <button class="btn w-100 btn-primary d-none">
                                    Filter
                                    <i class="fa fa-filter" style="margin-left: 1rem" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-2 ">
                                <div class="accordion-item  w-100" style="background-color: #fff !important;">
                                    <h2 class="accordion-header " style="background-color: #fff !important;"
                                        id="headingThree">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree" style="background-color: #fff !important;">
                                            <a href="#" class="d-flex align-items-center">
                                                <span>Search By Country</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-2">
                                                <select id="selectCountry" name="country"
                                                    class="form-select form-select-sm">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option {{ request('country') == $country->name ? 'selected' : '' }}
                                                            value="{{ $country->name }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="accordion-item  w-100" style="background-color: #fff !important;">
                                    <h2 class="accordion-header " style="background-color: #fff !important;"
                                        id="headingSix">
                                        <button style="background-color: #fff !important;" type="button"
                                            class="collapse-btn" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                            aria-expanded="false" aria-controls="collapseSix">
                                            <a href="#" class="d-flex align-items-center">
                                                <span>By Keywords</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="form-group mb-1">
                                                <input type="text" value="{{ request('keywords') }}" name="keywords"
                                                    id="keywords" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="accordion-item  w-100" style="background-color: #fff !important;">
                                    <h2 class="accordion-header " style="background-color: #fff !important;"
                                        id="headingSeven">
                                        <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven" style="background-color: #fff !important;">
                                            <a href="#" class="d-flex align-items-center">
                                                <span>By Categories</span>
                                            </a>
                                            <span class="collapse-icon">+</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="d-flex main_pck flex-wrap flex-column" id="category_container">
                                                <div class="form-group mb-1">
                                                    <select class="form-control form-control-sm" name="category"
                                                        id="categorySelect">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option
                                                                {{ request('category') == $category->id ? 'selected' : '' }}
                                                                value="{{ $category->id }}"
                                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}
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
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn w-100 d-block btn-secondary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row my-4 pt-2">
                @foreach ($quotations as $quotation)
                    <div class="col-md-3 mb-2">
                        <div class="card shadow position-relative src_pr_card rounded-0">
                            <div class="card-img">
                                <img src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                    alt="{{ $quotation->product_service }}" />
                            </div>
                            <div class="card-body">
                                <h1 class="fs-5 text-center">
                                    <a class="clamped-text text-primary fw-bolder"
                                        href="{{ route('user.source-pro.detail', $quotation->slug) }}">{{ $quotation->product_service }}</a>
                                </h1>


                                <div class=" fw-bolder mt-2 text-center">Required Price: <span class="text-secondary">US ${{ number_format($quotation->price) }}</span> </div>
                                    <div class=" fw-bolder mt-1 text-center">Required Quality: <span class="text-secondary">{{ $quotation->quantity ?? ''}}</span></div>
                                    <div class=" fw-bolder mt-1 text-center">Expired On: <span class="text-secondary">{{ $quotation->expiry_date ?? '' }}</span></div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('user.source-pro.detail', $quotation->slug) }}"
                                        class="btn btn-secondary mt-3">
                                        View Details</a>
                                </div>
                            </div>
                            <img src="https://flagcdn.com/160x120/{{ strtolower($quotation->country->iso2) }}.png"
                                class="position-absolute" style="height: 1.5rem; top: 10px; right: 10px"
                                alt="" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col-md-12  d-flex justify-content-center">
                    <div class="d-flex justify-content-center ">
                        {{ $quotations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('external-user.inc-parts.listCard')
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
    $('#order_type').on('change', function () {
        let selected = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('order_type', selected);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection
