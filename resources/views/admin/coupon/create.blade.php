@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Add Promotion
                    </div>
                    <div class="card-body pb-0">
                        <form method="post" action="{{ route('admin.save.coupon') }}" class="form-group row">
                            @csrf
                            <div class="col-12">
                                <div class="row">
                                    <!-- Coupon Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="coupon_code">Promotion Code</label>
                                        <input type="text" class="form-control" value="{{ old('code') }}"
                                            name="code" placeholder="Promotion Code">
                                        @error('code')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="coupon_name">Promotion Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" placeholder="Promotion Name">
                                        @error('name')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" value="{{ old('description') }}"
                                            name="description" placeholder="Description">
                                        @error('description')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                    <!-- Discount -->
                                    <div class="col-md-6 mb-3">
                                        <label for="discount">Discount </label>
                                        <input type="number" step="0.01" class="form-control" value="{{ old('discount') }}"
                                            name="discount" placeholder="Discount" min="1" max="100">
                                        @error('discount')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                   <!-- Percent Type -->
                                    <div class="col-md-6 mb-3">
                                        <label for="percent_type">Discount Type</label>
                                        <select name="percent_type" class="form-control">
                                            <option value="percentage" {{ old('percent_type') == 'percentage' ? 'selected' : '' }}>
                                                Percentage (%)
                                            </option>
                                            <option value="flat" {{ old('percent_type') == 'flat' ? 'selected' : '' }}>
                                                Flat  
                                            </option>
                                        </select>
                                        @error('percent_type')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                    <!-- Start Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" value="{{ old('start_date') }}"
                                            name="start_date">
                                        @error('start_date')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                    <!-- End Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" value="{{ old('end_date') }}"
                                            name="end_date">
                                        @error('end_date')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 p-2 pb-0 mb-0">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
