@extends('external-user.external-frame')

@section('external-main-content')
<section class="container my-4">
    <div class="row">
        <div class="col-12 mb-4 d-flex align-items-center">
            <div style="height: 3rem; width: 3rem">
                <img src="{{ asset('uploads/icons/icon1.png') }}" style="height: 100%; width: 100%" class="rounded-circle"
                    alt="" />
            </div>

            <div class="px-3">
                <h6 class="fw-bolder text-primary pb-0 mb-0">
                    Request for Quotations
                </h6>
                <small class="text-muted pt-0 mt-0">One Request, Multiple Quotes</small>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-12 bg-primary d-flex justify-content-center align-items-center py-3">
                    <h6 class="text-white fw-bold mb-0 pb-0">
                        Tell us Your Buy Requirements
                    </h6>
                </div>
                <form method="post" action="{{ route('user.send.get.quotes') }}" class="col-12 px-lg-0 px-3"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="w-100 py-4">
                        <h6 class="fw-bolder">Complete Your RFQ</h6>
                        <p>
                            The more specific your information, the more accurately we can
                            match your request to the right suppliers
                        </p>
                    </div>
                    <div class="form-group mb-3 mt-4">
                        <label class="form-label fw-bolder" for="product_serv">Product/Services :</label>
                        <input class="form-control" type="text" name="product_service"
                            value="{{ old('product_service') }}"
                            placeholder="Please enter the product / services you want to buy" />
                        @error('product_service')
                        <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="requirement_det" class="form-label fw-bolder">Requirements in details :</label>
                        <textarea class="form-control" id="requirement_det" name="requirement_details"
                            placeholder="Provide key information like: Product Specifications, Features, Material, Packaging, Application or any special requirement. " rows="8">{{ old('requirement_details') }}</textarea>
                        @error('requirement_details')
                        <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_1" class="fw-bolder form-label">Image
                                    1 <small class="text-danger">(500px X 500px)</small>:</label>
                                <input type="file" class="form-control image-input" name="image_1" id="image_1"
                                    accept="image/*" />
                                <div class="mt-2">
                                    <img id="preview_1" src="#" alt="Preview 1"
                                        style="display: none; width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                </div>
                                @error('image_1')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_2" class="fw-bolder form-label">Image
                                    2 <small class="text-danger">(500px X 500px)</small>:</label>
                                <input type="file" class="form-control image-input" name="image_2" id="image_2"
                                    accept="image/*" />
                                <div class="mt-2">
                                    <img id="preview_2" src="#" alt="Preview 2"
                                        style="display: none; width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                </div>
                                @error('image_2')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_3" class="fw-bolder form-label">Image
                                    3 <small class="text-danger">(500px X 500px)</small>:</label>
                                <input type="file" class="form-control image-input" name="image_3" id="image_3"
                                    accept="image/*" />
                                <div class="mt-2">
                                    <img id="preview_3" src="#" alt="Preview 3"
                                        style="display: none; width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                </div>
                                @error('image_3')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_4" class="fw-bolder form-label">Image
                                    4 <small class="text-danger">(500px X 500px)</small> :</label>
                                <input type="file" class="form-control image-input" name="image_4" id="image_4"
                                    accept="image/*" />
                                <div class="mt-2">
                                    <img id="preview_4" src="#" alt="Preview 4"
                                        style="display: none; width: 150px; height: 150px; border-radius: 12px; border: 1px solid #ddd; object-fit: cover;">
                                </div>
                                @error('image_4')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="estimated" class="fw-bolder form-label">Required Quantity:</label>
                                <input type="text" name="quantity" value="{{ old('quantity') }}"
                                    placeholder="In Units, Tons, Pieces, etc" class="form-control" />
                                @error('quantity')
                                <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="required_price" class="fw-bolder form-label">Required Price:</label>
                                <input type="number" step="0.01" name="required_price" value="{{ old('required_price') }}"
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
                                    <option value="product_inquiry">Product Inquiry</option>
                                    <option value="service_inquiry">Service Inquiry</option>
                                    <option value="bulk_order">Bulk Order</option>
                                    <option value="customized_order">Customized Order</option>
                                    <option value="sample_request">Sample Request</option>
                                    <option value="one_time_purchase">One-time Purchase</option>
                                    <option value="recurring_order">Recurring Order</option>
                                    <option value="long_term_contract">Long-term Contract</option>
                                    <option value="urgent_requirement">Urgent Requirement</option>
                                    <option value="partnership_proposal">Partnership Proposal</option>
                                </select>
                                @error('type')
                                <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="duration" class="form-label fw-bolder ">Duration </label>
                                <select name="duration" id="duration" class="form-select">
                                    <option value="7">7 Days</option>
                                    <option value="10">10 Days</option>
                                    <option value="21">21 Days</option>
                                    <option value="28">28 Days</option>
                                    <option value="30">1 Months</option>
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
                                    <option @selected(old('category')==$category->id) value="{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category')
                                <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="subCategorySelect" class="fw-bolder form-label">Sub Category:</label>
                                <select name="subcategory" class="form-control form-select" id="subCategorySelect">
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
                                <label for="ver_box" class="fw-bolder form-label">Enter Verification Code in below
                                    box:</label>
                                <input type="text" value="{{ old('captcha') }}" class="form-control"
                                    name="captcha" id="captcha" />
                                @error('captcha')
                                <p class="text-danger pt-3"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn w-100 btn-secondary">
                                Get Quotation Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card rounded-0 border-0" style="background-color: #e6e6e6">
                <h1 class="fs-3 text-center py-3">
                    Benifits for <br />
                    Buyers
                </h1>
                <div class="card-body d-flex justify-content-center flex-column align-items-center">
                    <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                        style="height: 4rem; width: 4rem">
                        #1
                    </div>
                    <div class="py-3 text-center">
                        <h5>TELL US WHAT YOU NEED</h5>
                        <p>
                            Complete simple form and let us know about your requirement.
                        </p>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center flex-column align-items-center">
                    <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                        style="height: 4rem; width: 4rem">
                        #2
                    </div>
                    <div class="py-3 text-center">
                        <h5>RECEIVE QUOTES</h5>
                        <p>
                            You receive customized price quotes from qualified suppliers.
                        </p>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center flex-column align-items-center">
                    <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                        style="height: 4rem; width: 4rem">
                        #3
                    </div>
                    <div class="py-3 text-center">
                        <h5>CHOOSE BEST SUPPLIER & TRADE</h5>
                        <p>
                            Compare quotes and choose best supplier's. Its quick and easy
                        </p>
                    </div>
                    <ul>
                        <li class="mt-3 d-flex align-items-center">
                            <i class="fa fa-clock fs-5 text-danger me-3"></i> Save time in
                            search of supplier
                        </li>
                        <li class="mt-3 d-flex align-items-center">
                            <i class="fas fa-users fs-5 text-danger me-3"></i> Responses
                            directly from Verified suppliers
                        </li>
                        <li class="mt-3 d-flex align-items-center">
                            <i class="fas fa-envelope-open fs-5 text-danger me-3"></i>
                            Compare & Evakute the quotes
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js-external')
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
                url: '{{ route("all.supplier-subcategory") }}',
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
                        var oldSubCategory = "{{ request('subcategory') }}";
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
@endsection