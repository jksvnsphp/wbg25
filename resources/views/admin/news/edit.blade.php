@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Edit News Page
                    </div>
                    <form method="post" action="{{ route('admin.update.news') }}" class="card-body pb-0"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image" class=" font-weight-bold fs-2">Upload Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="id" value="{{$news->id}}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="old-img mt-3" style="max-width: 8rem; height:5rem;">
                                        <img src="{{ asset('uploads/news/' . $news->image) }}" alt=""
                                            class="h-100 w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title" class=" font-weight-bold fs-2">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ $news->title }}">
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
                                    <input type="url" class="form-control" name="url" id="url"
                                        value="{{ $news->url }}">
                                    @error('url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class=" font-weight-bold fs-2">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="8" class="form-control">{{ $news->content }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
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
