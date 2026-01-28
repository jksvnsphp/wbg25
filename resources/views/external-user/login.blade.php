@extends('external-user.external-frame')
@section('external-main-content')
<section class="container-fluid py-3 login_form">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row my-3 justify-content-around">
                <div class="col-xl-5 mt-3">
                    <div class="card h-100 shadow rounded-0 same_card">
                        <div class="card-header py-3">
                            <h4 class="fw-bold text-center fs-4">Login</h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('login.now') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt-2 mb-4">
                                            <label for="email" class="form-label fw-bolder">Email <span
                                                    class="text-danger">*</span></label>
                                            <input style="height: 43px;" type="text" value="{{ old('email_phone') }}"
                                                class="form-control"
                                                placeholder="Enter your Email address/ Phone Number .."
                                                name="email_phone" />
                                            @error('email_phone')
                                            <p class="text-secondary py-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group ">
                                            <label for="password" class="form-label fw-bolder">Password <span
                                                    class="text-danger">*</span></label>
                                            <input style="height: 43px;" type="password" class="form-control"
                                                placeholder="Enter your password.." name="password" />
                                        </div>
                                        <div class="mt-4 pt-2 mb-2">
                                            <button type="submit" class="btn me-3 btn-secondary">
                                                Sign In
                                            </button>
                                            <a href="{{ route('forget.password') }}" class="btn btn-primary ">Forget
                                                Password</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 mt-3">
                    <div class="card h-100 shadow rounded-0 same_card">
                        <div class="card-header py-3">
                            <h4 class="fw-bold fs-4 text-center">Not registered Yet?</h4>
                        </div>
                        <div class="card-body  p-4 px-0 pt-0">
                            <div class="row  justify-content-center">
                                <div class="col-sm-4 col-6 d-flex align-items-end justify-content-center">
                                    <img src="{{ asset('world-business/images/buyer-icon.png') }}"
                                        style="height: 85%;width: 85%;object-fit: fill;object-position: center;"
                                        alt="" />
                                </div>
                                <div class="col-sm-6 d-flex align-items-end justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('buyer.quick.register') }}"
                                            class="btn btn-primary me-2 mt-sm-0 mt-2">Register now
                                            for free</a>
                                        <img style="cursor: pointer;"
                                            title="With a free and Time unlimited Buyer Account you can: 
- Buy Products 
- Request for Quotation 
- Bid on & buy Tenders 
 
All Functionallities can be handle after Login on Buyer Dashboard 
"
                                            src="{{ asset('info-symbol.jpg') }}" alt="info" height="18"
                                            width="25" />
                                    </div>
                                </div>
                            </div>
                            <hr style="height: 5px;background: #ddd;border: #8f8e8e !important;" />
                            <div class="row mt-2 justify-content-center">
                                <div class="col-sm-4 col-6 d-flex align-items-end justify-content-center">
                                    <img src="{{ asset('world-business/images/seller-icon.png') }}"
                                        style="height: 85%;width: 85%;object-fit: fill;object-position: center;"
                                        alt="" />
                                </div>
                                <div class="col-sm-6 d-flex align-items-end justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('user.member.package') }}"
                                            class="btn btn-primary me-2 mt-sm-0 mt-2">Join Member package</a>
                                        <img style="cursor: pointer;"
                                            title="With a Time limited Seller Account you can: 
- Create a Business Profile 
- Create a Spotlight Store 
- List & buy normal & Multiply Products  
- List & bid on, or buy Tenders 
- Use Source Pro to close individual Deals 
- Publish Company News 
 
All Functionallities can be handle after Login on Seller Dashboard "
                                            src="{{ asset('info-symbol.jpg') }}" alt="info" height="18"
                                            width="25" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection