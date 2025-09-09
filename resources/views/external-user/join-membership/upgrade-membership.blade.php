@extends('external-user.external-frame')

@section('external-main-content')
<section class="package_bg">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="fs-1 text-center text-white fw-bolder my-3">
                    Upgrade Member Package
                </h1>
                <p class="text-white text-center lh-sm fw-semibold fs-5 mb-2">
                    Increase the potential and volume of your international sales market.
                </p>
                <p class="text-white text-center lh-sm fw-semibold fs-5 mb-4">
                    Benefit exclusively as sample your own subdomain spotlight store to reach even more customers.
                </p>
            </div>
        </div>
    </div>
</section>
<div class="w-100 bg-white">
    <div class="container-fluid">
        <div class="row">
            @foreach ($packages as $package)
            <div class="col-md-3 mt-4">
                <div class="card rounded-0" style="
              border: 1px solid;
              border-color: #000044;
              border-top: 2px solid #000044;
            ">
                    <div class="card-header bg-white">
                        <h1
                            class="d-flex text-primary justify-content-center align-items-center fs-4 fw-bolder py-2 fw-bolder text-center">
                            {{ $package->name }}
                            <img src="{{ asset('world-business/images/badge.png') }}" height="30" alt="" />
                        </h1>
                        <div class="w-100 d-flex justify-content-center my-4">
                            <div class="d-flex justify-content-center align-items-center flex-column text-white fw-bolder"
                                style="height: 8rem; background: url({{ asset('world-business/star.png') }}); width: 8rem;background-position: center center; background-size: contain;">
                                <span class="fs-5 fw-bolder mb-2">{{ $package->validDays }} Days</span>
                                <span class="fw-bolder fs-6">{{ $package->price == 0 ? 'For free' : 'US $' .
                                    number_format($package->price, 2, ',') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="package-pck">
                            <ul class="package-content list-unstyled">
                                <li><strong class="fw-bold">Features:</strong></li>
                                <li>{{ $package->name == 'Bronce Package' || $package->name == 'Silver Package'
                                    ? 'Single Product'
                                    : 'Single/Multiply Product' }}
                                    listing limit<span>{{ $package->productLimit }} <img style="cursor: pointer;" title="List & sell Products in Number of the Member Package included Limit. 
                                                     Normal Product listings works by Duration Time, Multiply Product listings works by Number of Quantity 
                                                     Before Seller can start to list Products on WBG24.com, the accepted Payment Method for Buyers need to save 
                                                     " src="{{ asset('info-symbol.jpg') }}" width="20"
                                            height="15" /></span></li>
                                <li>Tender listing Limit <span>{{ $package->sellTenderLimit }} <img
                                            style="cursor: pointer;"
                                            title="List & sell Tenders in Number of the Member Package included Limit. 
                                                    Before Seller can start to list Tenders on WBG24.com, the accepted Payment Method for Buyers need to save"
                                            src="{{ asset('info-symbol.jpg') }}" width="20" height="15" /></span></li>
                                <li>News listing limit <span>{{ $package->newsLimit }} <img style="cursor: pointer;"
                                            title="List Company News in Number of the Member Package included Limit."
                                            src="{{ asset('info-symbol.jpg') }}" width="20" height="15" /></span></li>
                                <li>Sell Provision included <span>${{ $package->tradeLeadsInclude }} <img
                                            style="cursor: pointer;"
                                            title="For all successful Sales Activities, WBG24 charges a Sales Commission of 5%.  
                                                    If you use up all of your included Sales Commission, you will have received your WBG24 Membership Package at                                                     half Price. 
                                                    After the included Sales Commission has been used up, the corresponding future Sales Commissions are due                                                     monthly through separate Invoicing. "
                                            src="{{ asset('info-symbol.jpg') }}" width="20" height="15" /></span></li>
                                @foreach ($services as $service)
                                <li>
                                    {{ $service->serviceName }}
                                    <span>
                                        @if ($service[$package->type] == '1')
                                        <img src="{{ asset('world-business/images/right.png') }}" width="15"
                                            height="15" />
                                        @else
                                        <img src="{{ asset('world-business/images/wrong.png') }}" width="15"
                                            height="15" />
                                        @endif
                                        <img style="cursor: pointer;" title="{{ $service->info ?? '' }}"
                                            src="{{ asset('info-symbol.jpg') }}" width="20" height="15" />
                                    </span>
                                </li>
                                @endforeach

                            </ul>
                            <form method="post" action="{{ route('seller.upgrade.membership.pay') }}"
                                class="upgradeForm package-footer">
                                @csrf
                                <input type="hidden" name="code" value="{{ $package->code }}">
                                <button type="submit" class="btn btn-primary">Upgrade</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection