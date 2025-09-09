@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <style>
        .table-img {
            height: 6rem !important;
            width: 5rem !important;
            display: flex;
            justify-content: center;
        }

        .table-img img {
            object-fit: fill !important;
            object-position: center center;
        }

        .add_sc {
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        .form-input:focus {
            outline: none !important;
        }
    </style>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-start mb-3">
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">Edit Quotation/Relist Quotation</h6>
                </div>
                <div class="card rounded-0">
                    <div class="row">
                        <div class="col-md-10">
                            <form action="{{ route('seller.update.quotation') }}" method="post" enctype="multipart/form-data"
                                class="card-body">
                                @csrf
                                <input type="hidden" name="id" value="{{ $quotation->id }}">
                                <div class="form-group mb-3 mt-4">
                                    <label class="form-label fw-bolder" for="product_serv">Product/Services :</label>
                                    <input class="form-control" type="text" name="product_service"
                                        value="{{ $quotation->product_service ?? '' }}"
                                        placeholder="Please enter the product / services you want to buy" />
                                    @error('product_service')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="requirement_det" class="form-label fw-bolder">Requirements in details
                                        :</label>
                                    <textarea class="form-control" id="requirement_det" name="requirement_details"
                                        placeholder="Provide key information like: Product Specifications, Features, Material, Packaging, Application or any special requirement. "rows="8">{{ $quotation->requirement_details ?? '' }}</textarea>
                                    @error('requirement_details')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image_1" class="fw-bolder form-label">Image
                                                1 <small class="text-danger">(480px X 360px)</small>:</label>
                                            <input type="file" class="form-control image-input" name="image_1"
                                                id="image_1" accept="image/*" />
                                            @if ($quotation->image_1 != '')
                                                <div style="width: 150px; height: 150px;border-radius: 12px;"
                                                    class="mt-2 position-relative">
                                                    <img id="preview_1"
                                                        src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                                        alt="Preview 1"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                    <span data-col="image_1" data-id="{{ $quotation->id ?? null }}"
                                                        class="removeImg position-absolute top-0  btn btn-sm btn-primary"
                                                        style="right:0;">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <img id="preview_1" src="https://placehold.co/400x400 " alt="Preview 1"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                </div>
                                            @endif
                                            @error('image_1')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image_2" class="fw-bolder form-label">Image
                                                2 <small class="text-danger">(480px X 360px)</small>:</label>
                                            <input type="file" class="form-control image-input" name="image_2"
                                                id="image_2" accept="image/*" />
                                            @if ($quotation->image_2 != '')
                                                <div style="width: 150px; height: 150px;border-radius: 12px;"
                                                    class="mt-2 position-relative">
                                                    <img id="preview_2"
                                                        src="{{ asset('uploads/quotation/' . $quotation->image_2) }}"
                                                        alt="Preview 2"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                    <span data-col="image_2" data-id="{{ $quotation->id ?? null }}"
                                                        class="removeImg position-absolute top-0  btn btn-sm btn-primary"
                                                        style="right:0;">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <img id="preview_2" src="https://placehold.co/400x400 " alt="Preview 2"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                </div>
                                            @endif
                                            @error('image_2')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image_3" class="fw-bolder form-label">Image
                                                3 <small class="text-danger">(480px X 360px)</small>:</label>
                                            <input type="file" class="form-control image-input" name="image_3"
                                                id="image_3" accept="image/*" />
                                           @if ($quotation->image_3 != '')
                                                <div style="width: 150px; height: 150px;border-radius: 12px;"
                                                    class="mt-2 position-relative">
                                                    <img id="preview_3"
                                                        src="{{ asset('uploads/quotation/' . $quotation->image_3) }}"
                                                        alt="Preview 2"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                    <span data-col="image_3" data-id="{{ $quotation->id ?? null }}"
                                                        class="removeImg position-absolute top-0  btn btn-sm btn-primary"
                                                        style="right:0;">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <img id="preview_3" src="https://placehold.co/400x400 " alt="Preview 3"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                </div>
                                            @endif
                                            @error('image_3')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image_4" class="fw-bolder form-label">Image
                                                4 <small class="text-danger">(480px X 360px)</small>:</label>
                                            <input type="file" class="form-control image-input" name="image_4"
                                                id="image_4" accept="image/*" />
                                            @if ($quotation->image_4 != '')
                                                <div style="width: 150px; height: 150px;border-radius: 12px;"
                                                    class="mt-2 position-relative">
                                                    <img id="preview_4"
                                                        src="{{ asset('uploads/quotation/' . $quotation->image_4) }}"
                                                        alt="Preview 4"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                    <span data-col="image_4" data-id="{{ $quotation->id ?? null }}"
                                                        class="removeImg position-absolute top-0  btn btn-sm btn-primary"
                                                        style="right:0;">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <img id="preview_4" src="https://placehold.co/400x400 " alt="Preview 4"
                                                        style="width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                                </div>
                                            @endif
                                            @error('image_4')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="estimated" class="fw-bolder form-label">Required
                                                Quantity:</label>
                                            <input type="text" name="quantity"
                                                value="{{ $quotation->quantity ?? '' }}"
                                                placeholder="In Units, Tons, Pieces, etc" class="form-control" />
                                            @error('quantity')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group mb-3">
                                      <label for="required_price" class="fw-bolder form-label">Required Price:</label>
                                      <input type="number" step="0.01" name="required_price" value="{{ $quotation->price ?? 00 }}"
                                        placeholder="Price" class="form-control" />
                                        @error('required_price')
                                          <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="type" class="fw-bolder form-label">Type:</label>
                                            <select class="form-select" name="type">
                                                <option @selected($quotation->type == 'product_inquiry') value="product_inquiry">Product
                                                    Inquiry
                                                </option>
                                                <option @selected($quotation->type == 'service_inquiry') value="service_inquiry">Service
                                                    Inquiry
                                                </option>
                                                <option @selected($quotation->type == 'bulk_order') value="bulk_order">Bulk Order</option>
                                                <option @selected($quotation->type == 'customized_order') value="customized_order">Customized
                                                    Order</option>
                                                <option @selected($quotation->type == 'sample_request') value="sample_request">Sample Request
                                                </option>
                                                <option @selected($quotation->type == 'one_time_purchase') value="one_time_purchase">One-time
                                                    Purchase</option>
                                                <option @selected($quotation->type == 'recurring_order') value="recurring_order">Recurring
                                                    Order
                                                </option>
                                                <option @selected($quotation->type == 'long_term_contract') value="long_term_contract">Long-term
                                                    Contract</option>
                                                <option @selected($quotation->type == 'urgent_requirement') value="urgent_requirement">Urgent
                                                    Requirement</option>
                                                <option @selected($quotation->type == 'partnership_proposal') value="partnership_proposal">
                                                    Partnership Proposal</option>
                                            </select>
                                            @error('type')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <label for="duration" class="form-label fw-bolder ">Duration </label>
                                            <select name="duration" id="duration" class="form-select">
                                                <option @selected($quotation->duration == '7') value="7">7 Days</option>
                                                <option @selected($quotation->duration == '10') value="10">10 Days</option>
                                                <option @selected($quotation->duration == '21') value="21">21 Days</option>
                                                <option @selected($quotation->duration == '28') value="28">28 Days</option>
                                                <option @selected($quotation->duration == '30') value="30">1 Months</option>
                                            </select>
                                            @error('duration')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="categories" class="fw-bolder form-label">Category:</label>
                                            <select class="form-select" name="category" id="categorySelect">
                                                @foreach ($categories as $category)
                                                    <option @selected($quotation->category_id == $category->id) value="{{ $category->id }}">
                                                        {{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="subCategorySelect" class="fw-bolder form-label">Sub
                                                Category:</label>
                                            <select name="subcategory" class="form-control form-select"
                                                id="subCategorySelect">
                                                <option value="">Select Subcategory</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group d-flex flex-column mb-3">
                                            <label for="image" class="fw-bolder form-label">Verification Code:</label>
                                            <div class="d-flex align-items-center">
                                                {!! captcha_img('flat', ['id' => 'captcha_img']) !!}
                                                <i class="fa-solid fa-rotate mx-3  " onclick="refreshCaptcha()"
                                                    style="cursor: pointer !important"></i>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="ver_box" class="fw-bolder form-label">Enter Verification Code in
                                                below
                                                box:</label>
                                            <input type="text" value="{{ old('captcha') }}" class="form-control"
                                                name="captcha" id="captcha" />
                                            @error('captcha')
                                                <p class="text-danger pt-3"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-secondary">
                                            Update Quotation
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        function refreshCaptcha() {
            $.ajax({
                type: 'GET',
                url: "{{ route('refreshCaptcha') }}",
                success: function(data) {
                    $('#captcha_img').attr('src', data);
                },
                error: function() {
                    alert('Error refreshing CAPTCHA. Please try again.');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".image-input").on("change", function() {
                const input = this;
                const id = $(this).attr("id").split("_")[1];
                const preview = $(`#preview_${id}`);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr("src", e.target.result);
                        preview.css("display", "block");
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.css("display", "none");
                    preview.attr("src", "#");
                }
            });
        });
    </script>

    <script>
        function fetchSubCategory() {
            let categoryId = $('#categorySelect').val();
            // alert(categoryId);
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
                        subCategorySelect.empty();
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            var oldSubCategory = "{{ $quotation->subcategory_id ?? '' }}";
                            $.each(data, function(key, subcategory) {
                                var selected = (oldSubCategory == subcategory.id) ? 'selected' : '';
                                subCategorySelect.append('<option ' + selected + ' value="' +
                                    subcategory.id +
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
        }
        $('#categorySelect').on('change', function() {
            fetchSubCategory();
        });
        fetchSubCategory();
    </script>

    <script>
        $(document).on('click', '.removeImg', function() {
            var id = $(this).data('id');
            var col = $(this).data('col');

            if (confirm("Are you sure you want to delete this image?")) {
                $.ajax({
                    url: '{{ route('delete.quotation-img') }}',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        column: col
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            location.reload();
                        } else {
                            toastr.error("Something went wrong.");
                        }
                    }
                });
            }
        });
    </script>
@endsection
