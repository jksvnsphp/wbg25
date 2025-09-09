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
                        Edit Buyer
                    </div>
                    <form method="post" action="{{ route('admin.update.buyer') }}" enctype="multipart/form-data"
                        class="card-body pb-0">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    placeholder="Enter the buyer first name" value="{{ $buyer->first_name }}">
                                <input type="hidden" name="id" value="{{ $buyer->id }}">
                                @error('first_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    placeholder="Enter the last name" value="{{ $buyer->last_name }}">

                                @error('last_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter the email" value="{{ $buyer->email }}">

                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    placeholder="Enter the phone number" value="{{ $buyer->phone }}">

                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="account_type" class="form-label">Select Account Type</label>
                                <select name="account_type" id="account_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="buyer" @selected($buyer->account_type == 'buyer')>Buyer</option>
                                    <option value="seller" @selected($buyer->account_type == 'seller')>Seller</option>
                                </select>

                                @error('account_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>




                            <div class="mb-3 col-md-12 px-3">
                                <button type="submit" class="btn btn-sm btn-primary">Update Buyer</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>


    </div>
@endsection
