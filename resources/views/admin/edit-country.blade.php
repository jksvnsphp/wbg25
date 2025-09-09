@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card my-4 rounded-0 " id="category_card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Edit Country
                    </div>
                    <form method="post" action="{{ route('admin.update.country') }}" enctype="multipart/form-data"
                        class="card-body pb-0">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <input type="text" name="country_name" value="{{ $country->name }}" id="name"
                                    class="form-control" placeholder="Enter the country name">
                                <input type="hidden" name="id" value="{{ $country->id }}">

                                @error('country_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="capital" value="{{ $country->capital }}" class="form-control"
                                    id="capital" placeholder="Enter the capital of country.">
                                @error('capital')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="currency_symbol" value="{{ $country->currency_symbol }}"
                                    class="form-control" id="currency_symbol" placeholder="Enter the currency symbol.">
                                @error('currency_symbol')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" name="currency_name" value="{{ $country->currency_name }}"
                                    class="form-control" id="currency_name" placeholder="Enter the currency name.">
                                @error('currency_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" name="currency" value="{{ $country->currency }}" class="form-control"
                                    id="currency" placeholder="Enter the currency.">
                                @error('currency')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="file" name="image" id="image">
                                <small class="d-block">Flag Image</small>
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if ($country->image != '')
                                    <img style="height: 2rem;" class="mt-3"
                                        src="{{ asset('uploads/country_flags/' . $country->image) }}" alt="">
                                @endif
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="file" name="country_image" id="country_image">
                                <small class="d-block">Country Image</small>
                                @error('country_image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if ($country->banner_image!='')
                                    
                                <img style="height: 4rem;" class="mt-3 " src="{{asset('uploads/country_banners/'.$country->banner_image)}}" alt="">
                                @endif
                            </div>

                            <div class="mb-3 col-12 px-3">
                                <button type="submit" class="btn btn-sm btn-primary">Update Country</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>


    </div>
@endsection
