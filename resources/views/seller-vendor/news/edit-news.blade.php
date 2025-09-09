@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Edit News</h6>
                <div class="card shadow rounded-0">
                    <form method="post" enctype="multipart/form-data" action="{{ route('seller.save.news') }}"
                        class="card-body">
                        @csrf
                       
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <input type="hidden" name="id" value="{{ $news->id }}">
                                    <label for="title" class="form-label">Add Title
                                        <i class="fa fa-asterisk text-danger" style="font-size:12px;"
                                            aria-hidden="true"></i></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter your Add Title" value="{{ old('title', $news->title) }}" />
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label for="category" class="form-label">Select Category
                                        <i class="fa fa-asterisk text-danger" style="font-size:12px;"
                                            aria-hidden="true"></i></label>
                                    <select class="form-control" name="category" id="categorySelect">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option @selected(old('category', $news->category_id) == $category->id) value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label for="sub_category" class="form-label">Select Sub Category
                                        <i class="fa fa-asterisk text-danger" style="font-size:12px;"
                                            aria-hidden="true"></i></label>
                                    <select class="form-control" name="sub_category" id="subCategorySelect">
                                        <option value="">Select Subcategory</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option @selected(old('sub_category', $news->subcategory_id) == $subCategory->id) value="{{ $subCategory->id }}">
                                                {{ $subCategory->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label for="duration" class="form-label">Duration
                                        <i class="fa fa-asterisk text-danger" style="font-size:12px;"
                                            aria-hidden="true"></i></label>
                                    <select name="duration" id="duration" class="form-select">
                                        <option @selected(old('duration', $news->duration) == '7') value="7">7 Days</option>
                                        <option @selected(old('duration', $news->duration) == '10') value="10">10 Days</option>
                                        <option @selected(old('duration', $news->duration) == '21') value="21">21 Days</option>
                                        <option @selected(old('duration', $news->duration) == '28') value="28">28 Days</option>
                                        <option @selected(old('duration', $news->duration) == '30') value="30">1 Month</option>
                                    </select>
                                    @error('duration')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8 my-4">
                                <div class="card p-3 rounded-0" style="border: 2px solid grey">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group mb-3">
                                                    <label for="imageInput" class="form-label fw-bold">News Picture
                                                        <span class="text-secondary">(Max Size: 200X200 px)</span></label>
                                                    <input type="file" class="form-control" name="image"
                                                        id="imageInput" />
                                                </div>
                                                <label for="imageInput" class="btn btn-secondary mt-3 mx-3">
                                                    Upload
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 d-flex align-items-center">
                                            <h6 class="fw-bold fs-6 me-2">Show Image</h6>
                                            <div style="height: 6rem; width: 6rem">
                                                <img id="previewImage" src="{{ asset('uploads/news/' . $news->image) }}"
                                                    class="img-fluid rounded-2" style="height: 6rem; width:6rem;"
                                                    alt="Preview Image" />
                                            </div>
                                            <span class="btn btn-primary">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                           

                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="description" class="form-label">Add News
                                        <i class="fa fa-asterisk text-danger" style="font-size:12px;"
                                            aria-hidden="true"></i></label>
                                    <textarea name="news" id="div_editor1" rows="8" class="form-control">{{ old('news', $news->description) }}</textarea>
                                </div>
                                @error('news')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update News</button>
                                <a href="{{ route('seller.my.news') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        $('#categorySelect').on('change', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '{{ route('all.supplier-subcategory') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: categoryId
                    },
                    success: function(response) {
                        let subCategorySelect = $('#subCategorySelect');
                        subCategorySelect.empty(); // Clear existing options
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            $.each(data, function(key, subcategory) {
                                subCategorySelect.append('<option value="' + subcategory.id +
                                    '">' +
                                    subcategory.category_name + '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subCategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var $txtArea = $('#short_description');
            var $chars = $('#chars');
            var textMax = $txtArea.attr('maxlength');

            $chars.html(textMax + ' characters remaining');

            $txtArea.on('keyup', countChar);

            function countChar() {
                var textLength = $txtArea.val().length;
                var textRemaining = textMax - textLength;
                $chars.html(textRemaining + ' characters remaining');
            };
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#imageInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <script>
        // var editor1 = new RichTextEditor("#div_editor1");
    </script>
@endsection
