@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">My Bank Details</h6>
                <div class="card shadow rounded-0">
                    <div class="card-body">
                        <p>
                            Select & Leave Your Accepted payment method for your buyers.
                        </p>
                        <form method="post" action="{{ route('seller.add.bank.detail') }}"
                            class="row justify-content-between">
                            @csrf
                            <div class="col-md-10">
                                <div class="row justify-content-between">
                                    <div class="col-md-5 mb-4">
                                        <div class="card shadow rounded-0">
                                            <div class="card-header d-flex justify-content-between">
                                                <h6 class="pb-0 mb-0">Bank Details</h6>
                                                <div class="input-check d-flex align-items-center">
                                                    <input type="checkbox" class="input-check me-2" name="isBankDetail"
                                                        @checked(isset($bank->isBankDetail) && $bank->isBankDetail == 1) />
                                                    <label for="">Active</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h6 class="mb-0">Account Holder</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="account_holder" id="account_holder"
                                                            class="form-control"
                                                            value="{{ isset($bank->account_holder) ? $bank->account_holder : '' }}" />
                                                        @error('account_holder')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-5">
                                                        <h6 class="mb-0">Bank Name</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="bank_name" id="bank_name"
                                                            class="form-control"
                                                            value="{{ isset($bank->bank_name) ? $bank->bank_name : '' }}" />
                                                        @error('bank_name')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-5">
                                                        <h6 class="mb-0">Country</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="country" id="country"
                                                            class="form-control"
                                                            value="{{ isset($bank->country) ? $bank->country : '' }}" />
                                                        @error('country')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-5">
                                                        <h6 class="mb-0">IBAN</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="iban" id="iban"
                                                            class="form-control"
                                                            value="{{ isset($bank->iban) ? $bank->iban : '' }}" />
                                                        @error('iban')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-5">
                                                        <h6 class="mb-0">BIC</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="bic" id="bic"
                                                            class="form-control"
                                                            value="{{ isset($bank->bic) ? $bank->bic : '' }}" />
                                                        @error('bic')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-4">
                                        <div class="card shadow rounded-0 h-100">
                                            <div class="card-header d-flex justify-content-between">
                                                <h6 class="pb-0 mb-0">PayPal</h6>
                                                <div class="input-check d-flex align-items-center">
                                                    <input type="checkbox" name="isPayPal" @checked(isset($bank->isPayPal) && $bank->isPayPal == 1)
                                                        class="input-check me-2" />
                                                    <label for="">Active</label>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center">
                                                <div class="row w-100">
                                                    <div class="form-group">
                                                        <label for="">Your PayPal Emailaddress</label>
                                                        <input type="text" name="email" id="email"
                                                            class="form-control"
                                                            value="{{ isset($bank->email) ? $bank->email : '' }}" />
                                                        @error('email')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-4">
                                        <div class="card shadow rounded-0 h-100">
                                            <div class="card-header d-flex justify-content-between">
                                                <h6 class="pb-0 mb-0">GooglePay</h6>
                                                <div class="input-check d-flex align-items-center">
                                                    <input type="checkbox" name="isGooglePay" @checked(isset($bank->isGooglePay) && $bank->isGooglePay == 1)
                                                        class="input-check me-2" />
                                                    <label for="">Active</label>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center">
                                                <div class="row w-100">
                                                    <div class="form-group">
                                                        <label for="upi_google">Your GooglePay UPI/Number/Email</label>
                                                        <input type="text" name="upi_google" id="upi_google"
                                                            class="form-control"
                                                            value="{{ isset($bank->upi_google) ? $bank->upi_google : '' }}" />
                                                        @error('upi_google')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-4">
                                        <div class="card shadow rounded-0 h-100">
                                            <div class="card-header d-flex justify-content-between">
                                                <h6 class="pb-0 mb-0">Apple Pay</h6>
                                                <div class="input-check d-flex align-items-center">
                                                    <input type="checkbox" name="isOther" @checked(isset($bank->isOther) && $bank->isOther == 1)
                                                        class="input-check me-2" />
                                                    <label for="">Active</label>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex align-items-center">
                                                <div class="row w-100">
                                                    <div class="form-group mb-4 d-none">
                                                        <label for="other_method_name">Method Name</label>
                                                        <input type="text" name="other_method_name"
                                                            id="other_method_name" class="form-control"
                                                            value="Apple Pay" />
                                                        @error('other_method_name')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="other_value">Apple Pay: Id/UPI</label>
                                                        <input type="text" name="other_value" id="other_value"
                                                            class="form-control"
                                                            value="{{ isset($bank->other_value) ? $bank->other_value : '' }}" />
                                                        @error('other_value')
                                                            <small class="text-danger"> {{ $message }} </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-secondary">Save</button>
                    </div>
                </div>
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
