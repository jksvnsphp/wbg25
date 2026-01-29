@extends('external-user.external-frame')
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
                    <form method="get" action="{{ route('all.news.show') }}" class="w-100">
                        <h5 class="btn btn-primary d-flex  align-items-center">
                            <i class="fas fa-filter me-2"></i> Filter
                        </h5>
                        <div class="accordion my_filters w-100" id="accordionExample">
                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingSix">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fa-solid fa-calendar"></i>
                                            </span>
                                            <span>By Date</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0">
                                        <div class="form-group mb-1">
                                            <input name="date" value="{{ request('date') }}" type="date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingSix">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fa-solid fa-heading"></i>
                                            </span>
                                            <span>By Topic</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapse8" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0">
                                        <div class="form-group mb-1">
                                            <input name="topic" value="{{ request('topic') }}" type="text"
                                                class="form-control form-control-sm">
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
                                        <div class="form-group mb-2">
                                            <select name="category" class="form-control form-control-sm"
                                                id="categorySelect">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                <option @selected(request('category')==$category->id) value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <select class="form-control form-control-sm" name="subcategory"
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
                                        data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
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
                                                <option @selected(request('supplier')==$supplier->id) value="{{ $supplier->id }}">
                                                    {{ $supplier->company->name ?? 'NA' }}
                                                </option>
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
                                                <option @selected(request('country')==$country->name) value="{{ $country->name }}">
                                                    {{ $country->name }}
                                                </option>
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
            <nav aria-label="breadcrumb" class="mb-2 mt-4 d-flex justify-content-between align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary">Back</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        News
                    </li>
                </ol>
                <div>
                    <select class="form-control form-select" name="order_type" id="order_type">
                        <option @selected(request('order_type')=="all" ) value="all">All News</option>
                        <option @selected(request('order_type')=="expired-soon" ) value="expired-soon">Ending Soonest</option>
                        <option @selected(request('order_type')=="latest" ) value="latest">Newly Listed</option>
                    </select>
                </div>
            </nav>

            <div class="row mt-5">
                @forelse ($news as $article)
                <div class="col-md-12 mb-3">
                    <div class="card bg-white rounded-0 shadow">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-1">
                                    <img src="@if (isset($article->image) && $article->image != null) {{ asset('uploads/news/' . $article->image) }}
                                         @else
                                       https://placehold.co/200 @endif
                                    "
                                        alt="{{ $article->title }}"
                                        class="
                                        img-fluid rounded-2">
                                </div>
                                <div class="col-md-2">
                                    <h5 class="fw-bold text-primary">
                                        {{ isset($article->vendor->company->name) ? $article->vendor->company->name : '' }}
                                    </h5>
                                    <div class="d-flex mt-2 justify-content-start">
                                        @php
                                        $rating = $article->average_rating ?? 0;
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
                                <div class="col-md-3 d-flex align-items-center">
                                    <a href="{{ route('read.news', $article->slug) }}"
                                        class="fw-bold text-dark"> ddd {{ $article->title }}</a>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <h5 class="fw-bold text-secondary">
                                        {{ date('d M Y', strtotime($article->created_at)) }}
                                    </h5>
                                </div>

                                <div class="col-md-1  d-flex align-items-center">
                                    <img src="https://flagcdn.com/160x120/{{ strtolower($article->country->iso2) }}.png"
                                        style="height:2rem;" alt="">
                                </div>
                                <div style="border-left: 1px solid gray;"
                                    class="col-md-3 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('read.news', $article->slug) }}"
                                        class="btn btn-primary">Read Complete News</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                @if (request('q') != '')
                <h4 class="text-danger fw-bold text-center mt-3">Sorry! search news not found!</h4>
                @else
                <h4 class="text-danger fw-bold text-center mt-3">Sorry! news not found!</h4>
                @endif
                @endforelse
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center ">
                        {{ $news->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>


        </div>

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
    $('#categorySelect').on('change', function() {
        let categoryId = $(this).val();

        if (categoryId) {
            $.ajax({
                url: '{{ route("all.products-subcategory") }}',
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
    $('#order_type').on('change', function() {
        let selected = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('order_type', selected);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection