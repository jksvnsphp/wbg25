@extends('external-user.external-frame')

@section('external-main-content')
<section class="container-fluid">
    <div class="row">

        <div class="col-md-12 bg-body-secondary">
            <div class="row mt-3 mb-3">
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" onclick="window.history.back()" class="text-primary">Back</a></li>
                            <li class="breadcrumb-item"><a href="/" class="text-primary">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Find suppliers by region
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <select class="form-control form-select" name="business_type" id="business_type">
                        <option @selected(request('business_type')=="all" ) value="all">All Suppliers</option>
                        <option @selected(request('business_type')=="Manufacturer" ) value="Manufacturer">Manufacturer</option>
                        <option @selected(request('business_type')=="Wholesaler" ) value="Wholesaler">Wholesaler</option>
                        <option @selected(request('business_type')=="Retailer" ) value="Retailer">Retailer</option>
                        <option @selected(request('business_type')=="Service Provider" ) value="Service Provider">Service Provider</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="col-12 px-2 my-4 mb-0">
            <div class="row">
                @foreach ($supplier_region as $country)
                <a href="{{ route('all.suppliers') }}?country={{$country->name}}" class="text-dark col-md-1 mt-2 col-sm-4 col-4">
                    <div class="card-img">
                        <img src="https://flagcdn.com/256x192/{{strtolower($country->iso2)}}.png" alt="{{$country->name}}" class="img-fluid" />
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-one-line pro_heading " style="line-height: 2">
                            <span class="text-dark">{{$country->name}}</span>
                        </small>

                    </div>
                </a>
                @endforeach
            </div>

        </div>
        <div class="col-12 mt-5">
            <div class="d-flex justify-content-center ">
                {{ $supplier_region->links('pagination::bootstrap-5') }}
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
    $('#business_type').on('change', function() {
        let selected = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('business_type', selected);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection