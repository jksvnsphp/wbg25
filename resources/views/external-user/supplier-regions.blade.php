@extends('external-user.external-frame')

@section('external-main-content')
    <section class="container-fluid">
        <div class="row">

            <div class="col-md-12 bg-body-secondary">
                <div class="row">
                    <div class="col-md-5">
                        <h6 class="py-3 px-3 fw-semibold fs-6 d-flex">
                            <a href="">Home</a>/ <span>Find suppliers by region</span>
                            </h5>
                    </div>

                </div>
            </div>
            <div class="col-12 px-2 my-4 mb-0">
                <div class="row">
                    @foreach ($supplier_region as $country)
                        <a href="{{ route('all.suppliers') }}?country={{$country->name}}" class="text-dark col-md-1 mt-2 col-sm-4 col-4">
                            <div class="card-img">
                                <img src="https://flagcdn.com/256x192/{{strtolower($country->iso2)}}.png" alt="" class="img-fluid" />
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
@endsection
