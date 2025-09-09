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
                        Edit Supplier Category
                    </div>
                    <form class="card-body pb-0" method="post" action="{{ route('admin.update.supplier.category') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <input type="text" name="name" value="{{ $pcat->name }}" id="name"
                                    class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                    placeholder="Enter the category name">
                                <input type="hidden" name="id" value="{{ $pcat->id }}">
                                
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="meta_keyword"
                                    class="form-control @error('meta_keyword') is-invalid  @enderror" id="meta_keyword"
                                    placeholder="Enter the meta keyword(s)." value="{{ $pcat->meta_keyword }}">
                                @error('meta_keyword')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="file" name="image" id="image">
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if ($pcat->image != '')
                                    <img src="{{ asset('uploads/supplier_category/' . $pcat->image) }}" style="height: 4rem;"
                                        class="mt-2" alt="">
                                @endif

                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="meta_description" id="meta_description"
                                    class="form-control @error('meta_description') is-invalid  @enderror" placeholder="Enter the meta desciption">{{ $pcat->meta_description }}</textarea>
                                @error('meta_description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 px-3">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>


    </div>
@endsection
