@extends('seller-vendor.seller-frame')

@section('seller-main-content')
<div id="loadingOverlay"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
    <div class="spinner-border text-light" role="status"
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <h6 class="fs-5 text-light py-2 mt-2 px-3">My Multiply Product List </h6>
                    @php
                    $status = request()->segment(3) ?? 1;
                    @endphp
                    <a href="{{ route('seller.get.multiply.products', 1) }}"
                        class="btn btn-sm me-3 {{ $status == 1 ? 'btn-secondary disabled' : 'btn-light' }}">
                        Active
                    </a>

                    <a href="{{ route('seller.get.multiply.products', 2) }}"
                        class="btn btn-sm {{ $status == 2 ? 'btn-secondary disabled' : 'btn-light' }}">
                        Inactive
                    </a>
                </div>
                <a href="{{ route('seller.add.product') }}" class="btn btn-secondary">+ List Product</a>
            </div>

            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th colspan="2">Information</th>
                                    <th>Remaining Qty</th>
                                    <th>Min - Max Price</th>
                                    <th>Total Selling Amount</th>
                                    <th>Additional show case</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr data-product-id="{{ $product->id }}">
                                    <td>
                                        <a href="{{ route('product.detail', $product->slug) }}" class="table-img">
                                            @php

                                            $variants = is_string($product->variants)
                                            ? json_decode($product->variants, true)
                                            : $product->variants;
                                            $variants = is_array($variants) ? $variants : [];

                                            $allImages = [];
                                            foreach ($variants as $variant) {
                                            if (
                                            !empty($variant['images']) &&
                                            is_array($variant['images'])
                                            ) {
                                            $allImages = array_merge(
                                            $allImages,
                                            $variant['images'],
                                            );
                                            }
                                            }
                                            $previewImage = !empty($allImages)
                                            ? asset('uploads/products/' . $allImages[0])
                                            : null;
                                            if($product->isListingType=="spotlight"){
                                            $mainGallery = is_string($product->mainGallery)
                                            ? json_decode($product->mainGallery, true)
                                            : $product->mainGallery;

                                            $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                            $imgg=isset($mainGallery[0]['image'])?asset(
                                            'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                            $flImg=$imgg;

                                            }else{
                                            $flImg='https://placehold.co/600x400';
                                            }
                                            if (empty($previewImage)) {
                                            $previewImage =
                                            isset($product->gallery[0]->image) &&
                                            !empty($product->gallery[0]->image)
                                            ? asset(
                                            'uploads/products/gallery/' .
                                            $product->gallery[0]->image,
                                            )
                                            : $flImg;
                                            }
                                            @endphp
                                            <img src="{{ $previewImage }}" style="height: auto; width: 5rem"
                                                alt="Product Preview" />

                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-primary d-block"
                                            href="{{ route('product.detail', $product->slug) }}"
                                            style="width: 10rem;">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                        $totalQty = 0;

                                        if ($product->isMultiple == 1) {
                                        // Decode variants safely
                                        $variants = is_string($product->variants)
                                        ? json_decode($product->variants, true)
                                        : $product->variants;
                                        $variants = is_array($variants) ? $variants : [];
                                        foreach ($variants as $variant) {
                                        $totalQty += isset($variant['quantity'])
                                        ? (int) $variant['quantity']
                                        : 0;
                                        }
                                        } else {
                                        $totalQty = $product->totalQty ?? 0;
                                        }
                                        @endphp
                                        <p>{{ intVal($totalQty) - intVal($product->sold) }}/<span
                                                class="text-danger">{{ intVal($product->sold) }} Qty</span></p>
                                    </td>

                                    <td>
                                        <div style="width: 10rem">
                                            @if ($product->isMultiple == 0)
                                            <span class=" fw-bolder my-4 mt-2 mb-0 ">
                                                @if (isset($product->isPrice2) && $product->isPrice2 == 1)
                                                {{ $product->price2 }}
                                                @elseif (isset($product->isPrice1) && $product->isPrice1 == 1)
                                                {{ $product->price1 }}
                                                @else
                                                {{ $product->price0 }}
                                                @endif -

                                                @if (isset($product->isPrice0) && $product->isPrice0 == 1)
                                                {{ $product->price0 }}
                                                @elseif (isset($product->isPrice1) && $product->isPrice1 == 1)
                                                {{ $product->price1 }}
                                                @else
                                                {{ $product->price2 }}
                                                @endif
                                                {{ $product->currency0 == 'USD' ? "US$" : 'EU€' }}
                                            </span>
                                            @else
                                            @php
                                            $prices = [];

                                            if ($product->isMultiple == 1) {
                                            // Decode variants safely
                                            $variants = is_string($product->variants)
                                            ? json_decode($product->variants, true)
                                            : $product->variants;
                                            $variants = is_array($variants) ? $variants : [];

                                            // Collect all prices from the variants
                                            foreach ($variants as $variant) {
                                            if (
                                            isset($variant['price']) &&
                                            is_numeric($variant['price'])
                                            ) {
                                            $prices[] = $variant['price'];
                                            }
                                            }
                                            }

                                            // Calculate minPrice and maxPrice from collected prices
                                            $minPrice = !empty($prices)
                                            ? min($prices)
                                            : $product->minPrice ?? 1;
                                            $maxPrice = !empty($prices)
                                            ? max($prices)
                                            : $product->maxPrice ?? 1;
                                            @endphp

                                            <span class="fw-bolder my-4 mt-2 mb-0">
                                                @if ($minPrice == $maxPrice)
                                                {{ $minPrice }} US$
                                                @else
                                                {{ $minPrice }} - {{ $maxPrice }} US$
                                                @endif
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-0">US$ {{ $product->sold_price }}</p>
                                    </td>
                                    <td>
                                        <div class="add_sc d-flex">
                                            <div class="me-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            data-name="isLimitedOffer"
                                                            {{ $product->isLimitedOffer ? 'checked' : '' }} />
                                                        Limited Offers
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            data-name="isDailyDeal"
                                                            {{ $product->isDailyDeal ? 'checked' : '' }} />
                                                        Daily Deals
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            data-name="isBulkBuy"
                                                            {{ $product->isBulkBuy ? 'checked' : '' }} />
                                                        Bulk Buying
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            data-name="isHotProduct"
                                                            {{ $product->isHotProduct ? 'checked' : '' }} />
                                                        Hot Product
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch" title="Relist">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexSwitchCheckChecked" data-name="isList"
                                                {{ $product->isList ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>

                                        <a href="
                                                @if ($product->isMultiple == 1) {{ route('seller.edit.multiply-list', $product->id) }}
                                                  @else
                                                  {{ route('seller.edit.product', $product->id) }} @endif
                                                 "
                                            title="Edit" class="btn btn-info me-2">
                                            <i class="fa fs-5 text-white fa-pencil-square" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" title="Delete"
                                            class="btn btn-primary me-2 delete-product"
                                            data-product-id="{{ $product->id }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
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
    $(document).ready(function() {
        $('.form-check-input').on('change', function() {
            let checkbox = $(this);
            let key = checkbox.data('name');
            let value = checkbox.is(':checked') ? 1 : 0;
            let productId = checkbox.closest('tr').data(
                'product-id');

            $.ajax({
                url: '{{ route("seller.update.product.addons") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    key: key,
                    value: value
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        });
    });


    $(document).ready(function() {
        $('.delete-product').on('click', function(e) {
            e.preventDefault();

            let productId = $(this).data('product-id');

            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: '{{ route("seller.delete.product") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $(`a[data-product-id="${productId}"]`).closest('tr').remove();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred. Please try again.');
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection