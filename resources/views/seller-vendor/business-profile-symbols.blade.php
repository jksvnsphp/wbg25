@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <style>
        .btn-check:checked+.btn {
            background: orangered !important;
            background-color: orangered !important;
            color: white !important;
            border-color: orangered !important;
            outline: none !important;
        }
    </style>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3 pt-2">
                <h6 class="fs-5 text-light px-3 py-2">My Business Profile Symbol</h6>
                <div class="card rounded-0">
                    <div class="card-header">
                        <h6 class="fw-bold fs-6 pb-0 mb-0">Set Profile Symbol</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('business.add.symbols') }}" class="row">
                            @csrf
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Trade Assurance</h6>

                                        <input class="btn-check" type="checkbox" id="isTradeAssure" name="isTradeAssurance"
                                            @checked(isset($icons->isTradeAssurance) && $icons->isTradeAssurance == 1) autocomplete="off" />
                                        <label for="isTradeAssure" class="btn btn-primary">
                                            Apply Symbol
                                        </label>

                                    </div>
                                    <div class="card-body d-flex">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic1.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                        </a>
                                        <div class="text-center">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">To receive
                                                this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Trust Seal</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="isTrustSeal" name="isTrustSeal" @checked(isset($icons->isTrustSeal) && $icons->isTrustSeal == 1) />
                                            <label class="form-check-label" for="isTrustSeal">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="form-group d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic2.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                            <div class="text-center ">
                                                <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                    This symbol is only useable with the Platinum Member packages
                                                </p>
                                            </div>
                                            <img style="cursor: pointer;"
                                                title=" This Symbol will show on your Company Profile & Product Listings "
                                                src="{{ asset('info-symbol.jpg') }}" width="30" height="20" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Assessed Supplier</h6>
                                        <input class="btn-check" type="checkbox" id="isAssessed" name="isAssessedSupplier"
                                            @checked(isset($icons->isAssessedSupplier) && $icons->isAssessedSupplier == 1) autocomplete="off" />
                                        <label for="isAssessed" class="btn btn-primary">
                                            Apply Symbol
                                        </label>
                                    </div>
                                    <div class="card-body d-flex align-items-center">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic3.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                        </a>
                                        <div class="text-center ">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">To receive
                                                this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Onsite Checked</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="isOnsite" name="isOnsiteChecked" @checked(isset($icons->isOnsiteChecked) && $icons->isOnsiteChecked == 1) />
                                            <label class="form-check-label" for="isOnsite">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="form-group d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic4.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                            <div class="text-center ">
                                                <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                    This symbol is useable with Silver, Gold and Platinum Member packages
                                                </p>
                                            </div>
                                            <img style="cursor: pointer;"
                                                title="This Symbol will show on your Company Profile & Product Listings"
                                                src="{{ asset('info-symbol.jpg') }}" width="30" height="20" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Product verified </h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="isVerified" name="isProductVerified" @checked(isset($icons->isProductVerified) && $icons->isProductVerified == 1) />
                                            <label class="form-check-label" for="isVerified">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="form-group d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic5.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                            <div class="text-center ">
                                                <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                    This symbol is useable with Silver, Gold and Platinum Member packages
                                                </p>
                                            </div>
                                            <img style="cursor: pointer;"
                                                title="This Symbol will show on your Company Profile & Product Listings"
                                                src="{{ asset('info-symbol.jpg') }}" width="30" height="20" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Store Favorite</h6>
                                        <input class="btn-check" type="checkbox" id="isFavorite" name="isStoreFavorite"
                                            @checked(isset($icons->isStoreFavorite) && $icons->isStoreFavorite == 1) autocomplete="off" />
                                        <label for="isFavorite" class="btn btn-primary">
                                            Apply Symbol
                                        </label>
                                    </div>
                                    <div class="card-body d-flex">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic6.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">

                                        </a>
                                        <div class="text-center ">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">To
                                                receive
                                                this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Email Verified</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="isEmailVerified" name="isEmailVerified"
                                                @checked(isset($icons->isEmailVerified) && $icons->isEmailVerified == 1) />
                                            <label class="form-check-label" for="isEmailVerified">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="form-group d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic7.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                            <div class="text-center ">
                                                <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                    This symbol is useable with Silver, Gold and Platinum Member packages
                                                </p>
                                            </div>
                                            <img style="cursor: pointer;"
                                                title="This Symbol will show on your Company Profile & Product Listings"
                                                src="{{ asset('info-symbol.jpg') }}" width="30" height="20" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Category Best</h6>
                                        <input class="btn-check" type="checkbox" id="isBestCategory"
                                            name="isCategoryBest" @checked(isset($icons->isCategoryBest) && $icons->isCategoryBest == 1) autocomplete="off" />
                                        <label for="isBestCategory" class="btn btn-primary">
                                            Apply Symbol
                                        </label>
                                    </div>
                                    <div class="card-body d-flex">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic8.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">

                                        </a>
                                        <div class="text-center ">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                To receive this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Secure Transaction</h6>
                                        <input class="btn-check" type="checkbox" id="isSecureTransaction"
                                            name="isSecureTransaction" @checked(isset($icons->isSecureTransaction) && $icons->isSecureTransaction == 1) autocomplete="off" />
                                        <label for="isSecureTransaction" class="btn btn-primary">
                                            Apply Symbol
                                        </label>
                                    </div>
                                    <div class="card-body d-flex">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic9.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                        </a>
                                        <div class="text-center ">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                To receive this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">24*7 Support</h6>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input shadow-0" type="checkbox" role="switch"
                                                id="isSupport" name="isSupport" @checked(isset($icons->isSupport) && $icons->isSupport == 1) />
                                            <label class="form-check-label" for="isSupport">On/Off</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="form-group d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic11.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                            <div class="text-center ">
                                                <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">
                                                    This symbol is useable with all member packages</p>
                                            </div>
                                            <img style="cursor: pointer;"
                                                title="This Symbol will show on your Company Profile & Product Listings "
                                                src="{{ asset('info-symbol.jpg') }}" width="30" height="20" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="card rounded-0">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold fs-6 pb-0 mb-0">Security</h6>
                                        <input class="btn-check" type="checkbox" id="isSecurity" name="isSecurity"
                                            @checked(isset($icons->isSecurity) && $icons->isSecurity == 1) autocomplete="off" />
                                        <label for="isSecurity" class="btn btn-primary">
                                            Apply Symbol
                                        </label>
                                    </div>
                                    <div class="card-body d-flex">
                                        <a class="form-group me-2 d-flex justify-content-between align-items-center"
                                            href="">
                                            <img src="{{ asset('world-business/images/icons/ic10.jpg') }}"
                                                style="height:35px; width: 35px;" alt="">
                                        </a>
                                        <div class="text-center ">
                                            <h6 class="text-secondary mb-0">Comming soon</h6>
                                            <p class="text-primary fw-bold fs-6 mb-0 pb-0" style="line-height:1;">To
                                                receive
                                                this Symbol you need to meet some Requirements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div>
                                <button type="submit" class="btn btn-secondary mt-4">Save & Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
