@extends('external-user.external-frame')
@section('meta_data')
    <title>Spotlight Stores across the Globe with World Business Guide – WBG24</title>
    <meta name="description"
        content="Search to Spotlight Stores or create & promote your own Subdomain Spotlight Store on World Business Guide – www.WBG24.com /Your-Name">
    <meta name="keywords" content="Spotlight Store, Create Spotlight Store, Promote Spotlight Store">
    <meta name="author" content="WBG24.com">
@endsection
@section('external-main-content')
    <style>
        .spotcard {
            margin: 1rem 0.5rem !important;
        }

        .spotcard img {
            height: 100% !important;
            width: 100% !important;
        }
        .spotcard .banner {
    display: flex;
    justify-content: center;
    align-items: center;
}
.image-grid {
    display: flex;
    justify-content: center;
    align-items: center;
}
        
    </style>
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
                        <form method="get" action="{{ route('all.spotlight') }}" class="w-100">
                            <h5 class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-filter me-2"></i> Filter
                            </h5>
                            <div class="accordion my_filters w-100" id="accordionExample">
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
                                                        <option @selected(request('country') == $country->name) value="{{ $country->name }}">
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
                                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
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
                                                    @php
                                                        $businessTypes = [
                                                            'Manufacturer',
                                                            'Wholesaler',
                                                            'Retailer',
                                                            'Service Provider',
                                                        ];
                                                    @endphp
                                                    <option value="">Business Type</option>
                                                    @foreach ($businessTypes as $type)
                                                        <option @selected($type == request('business_type')) value="{{ $type }}">
                                                            {{ $type }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn w-100 btn-secondary mt-2">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
<div class="col-md-10 mb-4">
    <div class="row">
        <div class="col-md-12 mt-2">
            @forelse ($spotlights as $seller)
                @php
                    $company = $seller->company ?? null;
                    $logo = !empty($company->company_logo) 
                        ? asset('uploads/profile/' . $company->company_logo) 
                        : asset('uploads/logo/default-logo.png');
                    $banner = !empty($company->spotlight_banner) 
                        ? asset('uploads/profile/' . $company->spotlight_banner) 
                        : asset('uploads/logo/default-banner.png');
                    $rating = (int) ($seller->average_rating ?? 0);
                @endphp

                <div class="card mt-4 shadow rounded-0">
                    <div class="row">
                        {{-- Left Column (Logo + Name + Rating) --}}
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="mx-2 d-flex flex-row align-items-center">
                                <div class="bg-white p-1 rounded-1 me-2 border d-flex align-items-center justify-content-center" 
                                    style="height:4rem; width:4rem;">
                                    <img src="{{ $logo }}" 
                                        alt="{{ $company->name ?? 'Company Logo' }}" 
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>

                                <div class="d-flex flex-column">
                                    <a href="{{ route('seller.spotlight', $seller->ref_no) }}"
                                        class="fs-5 text-primary fw-bolder"
                                        style="font-weight: 900 !important;">
                                        {{ $company->name ?? 'NA' }}
                                    </a>
                                    <small class="text-muted">{{ $seller->sold }} Items sold</small>
                                    <div class="mt-1" style="font-size: 13px !important">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rating ? 'text-secondary' : '' }}" style="color:{{ $i > $rating ? 'gray' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Middle Column (Banner + Previews) --}}
                        <div class="col-md-4">
                            <div class="card p-1 rounded-0 spotcard border-5" style="border-color:#cfcfcf">
                                <div class="banner position-relative w-100">
                                    <img class="w-100" src="{{ $banner }}" alt="{{ $company->name ?? 'Spotlight Banner' }}">
                                    <div class="position-absolute bg-white p-1 rounded-1"
                                        style="height:2.4rem; width:2.4rem; left:50%; transform:translateX(-50%); bottom:-1%;">
                                        <img class="h-100 w-100" src="{{ $logo }}" alt="{{ $company->name ?? 'Company Logo' }}" style="object-fit: contain;">
                                    </div>
                                </div>
                                <div class="row g-2 mt-3 image-grid">
                                    @foreach (['spotlight_preview1','spotlight_preview2','spotlight_preview3','spotlight_preview4'] as $i => $preview)
                                        @if (!empty($company->$preview))
                                            <div class="col-3">
                                                <img class="rounded-1"
                                                    src="{{ asset('uploads/profile/' . $company->$preview) }}"
                                                    alt="Preview {{ $i+1 }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Right Column (Country + Business Type + Button) --}}
                        <div class="col-md-4 d-flex justify-content-center flex-column border-start">
                            <div class="d-flex justify-content-center pb-3">
                                <img style="width: 40px; height:30px;"
                                    src="https://flagcdn.com/40x30/{{ strtolower($seller->country->iso2 ?? 'in') }}.png"
                                    alt="{{ $seller->country->name ?? 'Country' }}" />
                            </div>
                            <h6 class="text-one-line text-center fw-bolder pb-3">
                                {{ $company->business_type ?? 'NA' }}
                            </h6>
                            <div class="text-center px-3">
                                <a href="{{ route('seller.spotlight', $seller->ref_no) }}"
                                    class="btn w-100 btn-primary mt-2">Visit Store</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="text-danger fw-bold text-center mt-3">Sorry! Stores not found!</h4>
            @endforelse
        </div>
    </div>
     <div class="row">
         

               <div class="row mt-5">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 d-flex justify-content-center">
                        <div class="col-12 mt-5">
                            <div class="d-flex justify-content-center ">
                                {{ $spotlights->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
  
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
                    url: '{{ route('all.supplier-subcategory') }}',
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
        });
    </script>
@endsection
