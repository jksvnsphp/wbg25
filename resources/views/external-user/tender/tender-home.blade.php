@extends('external-user.external-frame')
@section('external-main-content')
<style>
    .price-tag {
        width: 100px !important;
    }
</style>
<section class="scp_hero mb-0 w-100">
    <img src="{{ asset('world-business/images/Tender-Slider-Gallery.jpg') }}" class="img-fluid w-100" alt="" />
</section>
<section class="container-fluid">

    <div class="row pb-3 pt-3 shadow" style="border: 1px solid #ddd">
        <nav aria-label="breadcrumb" class="mb-2 mt-4 d-flex align-items-center justify-content-between">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" onclick="window.history.back()" class="text-primary">Back</a></li>
                <li class="breadcrumb-item"><a href="/" class="text-primary">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tenders
                </li>
            </ol>

            <div>
                <strong class="text-secondary">
                    Total Tenders: {{ $tenders->total() }}
                </strong>
            </div>
        </nav>
        <hr>
        <div class="col-md-12">

            <form method="get" action="{{ route('all.tenders') }}" class="accordion my_filters py-3  w-100"
                style="background-color: #fff !important;" id="accordionExample">
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <button class="btn w-100 btn-primary">
                            Filter
                            <i class="fa fa-filter" style="margin-left: 1rem" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="col-md-2 ">
                        <div class="accordion-item  w-100" style="background-color: #fff !important;">
                            <h2 class="accordion-header " style="background-color: #fff !important;" id="headingThree">
                                <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                                    style="background-color: #fff !important;">
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
                                        <select id="selectCountry" name="country" class="form-select form-select-sm">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option @selected(isset($_GET['country']) && $_GET['country']==$country->name) value="{{ $country->name }}">
                                                {{ $country->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 ">
                        <div class="accordion-item  w-100" style="background-color: #fff !important;">
                            <h2 class="accordion-header " style="background-color: #fff !important;" id="headingSix">
                                <button style="background-color: #fff !important;" type="button" class="collapse-btn"
                                    data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                    aria-controls="collapseSix">
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
                                        <input type="text" name="keywords" id="keywords"
                                            class="form-control form-control-sm" value="{{ $_GET['keywords'] ?? '' }}"
                                            placeholder="Keywords...." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="accordion-item  w-100" style="background-color: #fff !important;">
                            <h2 class="accordion-header " style="background-color: #fff !important;" id="headingSeven">
                                <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"
                                    style="background-color: #fff !important;">
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
                                            <select class="form-control form-control-sm" name="parentcategory"
                                                id="category_level1">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                <option @selected(isset($_GET['parentcategory']) && $_GET['parentcategory']==$category->id) value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
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
    <div class="col-md-12 px-3 d-flex justify-content-between align-items-center bg-body-secondary">
        <div>
            <h5 class="py-3 px-3 fw-semibold fs-5">
                All Tenders
            </h5>
        </div>
        <div>
            <select class="form-control form-select" name="order_type" id="order_type">
                <option @selected(request('order_type')=="all" ) value="all">All Tenders</option>
                <option @selected(request('order_type')=="expired-soon" ) value="expired-soon">Ending Soonest</option>
                <option @selected(request('order_type')=="latest" ) value="latest">Newly Listed</option>
            </select>
        </div>
    </div>
    <div class="col-12 my-4 mb-0">
        <div class="row">
            @forelse ($tenders as $tender)
            <div class="col-md-3 mt-2 col-sm-4 col-lg-2">
                <div class="card shadow latest_list rounded-0 position-relative">
                    <div class="card-img">
                        <a class="text-primary" href="{{ route('show.tender', $tender->slug) }}">
                            <img src="{{ asset('uploads/tender/' . $tender->image_1) }}" alt="" style="max-width:100% !important; height:unset !important;" />
                        </a>
                    </div>
                    <div class="card-footer bg-white">
                        <h6 class="text-one-line text-center fs-5 text-primary  fw-bolder" style="line-height: 2">
                            <a class="text-primary" href="{{ route('show.tender', $tender->slug) }}">{{ Str::limit($tender->name, 30) }}</a>
                        </h6>

                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div class=" fw-bolder mt-2">Tender Price: <span class="text-secondary">US ${{ number_format($tender->price) }}</span> </div>



                            <div class=" fw-bolder mt-2 text-danger">

                                Ends in: {{ $tender->expiry_date }}

                            </div>
                            <a class="btn btn-secondary my-2" href="{{ route('show.tender', $tender->slug) }}">View Details</a>
                        </div>
                    </div>
                    <img class="bg-white p-1"
                        src="https://flagcdn.com/160x120/{{ strtolower($tender->country->iso2) }}.png"
                        style="height: 35px;position:absolute;top:10px;right:10px;" alt="" />
                </div>
            </div>
            @empty
            <h4 class="text-danger fw-bold text-center mt-3">Sorry! Tenders not found!</h4>
            @endforelse

        </div>
        <div class="row mt-5 justify-content-center">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="d-flex justify-content-center ">
                    {{ $tenders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        <?php /* 
        <div class="row mt-5 justify-content-between align-items-center">
            <div class="col-md-6">
                <p>
                    Showing {{ $tenders->firstItem() }} to {{ $tenders->lastItem() }} of {{ $tenders->total() }} results
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <form method="get" action="{{ route('all.tenders') }}">
                    {{-- keep existing query filters --}}
                    @foreach(request()->except('pageItem','page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <select name="pageItem" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="25" @selected(request('pageItem')==25)>25</option>
                        <option value="50" @selected(request('pageItem')==50)>50</option>
                        <option value="100" @selected(request('pageItem')==100)>100</option>
                    </select>
                </form>
            </div>
        </div>
        */ ?>

    </div>
</section>


@include('external-user.inc-parts.listCard')

<div class="container-fluid my-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>


@endsection
@section('custom-js-external')
<script>
    function getLevel2() {
        var categoryId = $('#category_level1').val();
        var level2 = "{{ $_GET['subcategory'] ?? '' }}";
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
                            var selected = subCategory.id == level2 ? 'selected' : '';
                            subcategoryHtml += '<option ' + selected + ' value="' + subCategory
                                .id + '">' + subCategory.name + '</option>';
                        });
                        subcategoryHtml += '</select></div>';
                        $('#category_container').append(
                            subcategoryHtml);
                        getLevel3();
                    }
                }
            });
        } else {
            $('#category_container').find('#category_level22')
                .remove();
            $('#category_container').find('#category_level33')
                .remove();
            $('#category_container').find('#category_level44')
                .remove();
        }
    }

    function getLevel3() {
        var subCategoryId = $('#category_level2').val();
        var level3 = "{{ $_GET['childcategory'] ?? '' }}";

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
                            var selected = subSubCategory.id == level3 ? 'selected' : '';
                            subSubCategoryHtml += '<option ' + selected + ' value="' +
                                subSubCategory.id + '">' + subSubCategory.name +
                                '</option>';
                        });
                        subSubCategoryHtml += '</select></div>';
                        $('#category_container').append(
                            subSubCategoryHtml);
                        getLevel4();
                    }
                }
            });

        } else {
            $('#category_container').find('#category_level33')
                .remove();
            $('#category_container').find('#category_level44')
                .remove();
        }
    }

    function getLevel4() {
        var subSubCategoryId = $('#category_level3').val();
        var level4 = "{{ $_GET['endcategory'] ?? '' }}";
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
                            .remove();

                        var childCategoryHtml =
                            '<div class="form-group mb-2" id="category_level44">' +
                            '<select name="endcategory" id="category_level4" class="form-select form-select-sm">' +
                            '<option value="">Select End Category</option>';
                        $.each(response, function(index, childCategory) {
                            var selected = childCategory.id == level4 ? 'selected' : '';
                            childCategoryHtml += '<option ' + selected + ' value="' +
                                childCategory.id + '">' + childCategory.name +
                                '</option>';
                        });
                        childCategoryHtml += '</select></div>';
                        $('#category_container').append(
                            childCategoryHtml); // Append to category_container
                    }
                }
            });
        } else {
            $('#category_container').find('#category_level44').remove();
        }
    }

    $(document).ready(function() {

        // When parent category is selected
        $('#category_level1').change(function() {
            getLevel2();

        });
        getLevel2();

        // When subcategory is selected
        $(document).on('change', '#category_level2', function() {
            getLevel3();
        });

        // When sub-subcategory is selected
        $(document).on('change', '#category_level3', function() {
            getLevel4();
        });
    });
</script>

<script>
    $('#order_type').on('change', function() {
        let selected = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('order_type', selected);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection