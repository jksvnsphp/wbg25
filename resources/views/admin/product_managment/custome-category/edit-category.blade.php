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
                        <a href="{{route('admin.all.custome.category')}}" class="btn btn-sm btn-primary">Back</a>
                        Edit Category
                    </div>
                    <form class="card-body pb-0" method="post" action="{{ route('admin.update.custome-category') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <input type="text" name="name" value="{{ $pcat->category_name }}" id="name"
                                    class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                    placeholder="Enter the category name">
                                <input type="hidden" name="id" value="{{ $pcat->id }}">
                                <input type="hidden" name="parent_id" value="{{ $pcat->parent_id }}">
                                
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid  @enderror" id="title"
                                    placeholder="Enter the title." value="{{ $pcat->title }}">
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" name="keyword"
                                    class="form-control @error('keyword') is-invalid  @enderror" id="keyword"
                                    placeholder="Enter the keyword(s)." value="{{ $pcat->keyword }}">
                                @error('keyword')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="file" name="image" id="image">
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if ($pcat->image != '')
                                    <img src="{{ asset('uploads/category-images/'. $pcat->classified_image) }}" style="height: 4rem;"
                                        class="mt-2" alt="">
                                @endif

                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="description" id="meta_description"
                                    class="form-control @error('description') is-invalid  @enderror" placeholder="Enter the desciption">{{ $pcat->description }}</textarea>
                                @error('description')
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
