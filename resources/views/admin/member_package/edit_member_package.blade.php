@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Edit Member package
                    </div>
                    <div class="card-body pb-0">
                        <form action="{{ route('admin.member.update.package') }}" class="row" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="package_name" class="form-control"
                                        value="{{ $package->name }}" required>
                                    <input type="hidden" name="id" value="{{ $package->id }}">
                                    @error('package_name')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" class="form-control" value="{{ $package->price }}"
                                        required>
                                    @error('price')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="validDays">Valid Days</label>
                                    <input type="number" name="validDays" class="form-control"
                                        value="{{ $package->validDays }}" required>
                                    @error('validDays')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="productLimit">Product Limit</label>
                                    <input type="number" name="productLimit" class="form-control"
                                        value="{{ $package->productLimit }}" required>
                                    @error('productLimit')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tenderLimit">Tender Limit</label>
                                    <input type="number" name="tenderLimit" class="form-control"
                                        value="{{ $package->sellTenderLimit }}" required>
                                    @error('tenderLimit')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="newsLimit">News Limit</label>
                                    <input type="number" name="newsLimit" class="form-control"
                                        value="{{ $package->newsLimit }}" required>
                                    @error('newsLimit')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sellProvisionInclude">Sell Provision Include</label>
                                    <input type="number" name="sellProvisionInclude" class="form-control"
                                        value="{{ $package->tradeLeadsInclude }}" required>
                                    @error('sellProvisionInclude')
                                        <small> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
							
							<div class="col-md-4">
                                <div class="form-group">
							
        <label>Package Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    @if($package->image)
        <div class="mt-2">
            <img src="{{ asset('uploads/member_packages/'.$package->image) }}"
                 width="150"
                 alt="Package Image">
        </div>
    @endif
	</div>						
							
							
							
							
							
							
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option @selected($package->status == 1) value="1">Active</option>
                                        <option @selected($package->status == 0) value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-4">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
