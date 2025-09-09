@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Add News Page
                    </div>
                    <form method="post" action="{{route('admin.store.news')}}" class="card-body pb-0" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image" class=" font-weight-bold fs-2">Upload Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title" class=" font-weight-bold fs-2">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="url" class=" font-weight-bold fs-2">URL <span
                                            class="text-danger">*</span></label>
                                    <input type="url" class="form-control" name="url" id="url" value="{{old('url')}}">
                                    @error('url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class=" font-weight-bold fs-2">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="8" class="form-control">{{old('description')}}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('custom-js')
@endsection
