@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light px-3 pb-2">My Profile Search Keys</h6>
                <div class="card rounded-0">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold fs-6 pb-0 py-2 mb-0">Please enter Your individual Search Keys in Form of Products/Services through Your Business Profile will be listed.</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('seller.update.search.keys') }}" class="row">
                            @csrf
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="key{{ $i }}" class="form-label">Search Key {{ $i }}:</label>
                                        <input type="text" name="key{{ $i }}" id="key{{ $i }}" class="form-control"
                                            placeholder="Enter" value="{{ $seller['key'.$i] ?? old('key'.$i) }}" />
                                        @error('key'.$i)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror    
                                    </div>
                                </div>
                            @endfor

                            <div>
                                <button type="submit" class="btn btn-secondary mt-4">Save & Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
