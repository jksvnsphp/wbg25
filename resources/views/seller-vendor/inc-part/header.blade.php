<header class="container-fluid px-0">
    <div class="row px-2">
        <div class="col-xl-2 d-xl-block d-none">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="mt-2" src="{{ asset('uploads/logo/' . $websiteData->logo) }}"
                    style="height: 75%; width: 100%" alt="" />
            </a>
        </div>
        <div class="col-xl-10">
            <nav class="navbar navbar-expand-xl p-0 bg-white">
                <a class="navbar-brand d-xl-none d-block" href="{{ route('home') }}">
                    <img src="{{ asset('uploads/logo/' . $websiteData->logo) }}" width="140" height="70"
                        alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav py-1 navbar-left me-md-5 me-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                For Buyers
                            </a>
                            <ul class="dropdown-menu p-3">

                                <li>
                                    <a class="dropdown-item fw-bolder mx-0 px-0"
                                        href="{{ route('buyer.quick.register') }}">Free Registration</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('user.get.quotes') }}">Get
                                        Quote</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.suppliers') }}">Suppliers</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.news.show') }}">Suppliers News</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.spotlight') }}">Spotlight Stores</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.products') }}">Products</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.product-video.show') }}">Product Videos</a>
                                </li>
                                
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','limited-offer') }}">Limited Offers</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','hot') }}">Hot Products</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','bulk-buying') }}">Bulk Buying</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','daily-deals') }}">Daily Deals</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.tenders') }}">Tenders</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                For Sellers
                            </a>
                            <ul class="dropdown-menu p-2 pl-3">
                                <li>
                                    <a class="dropdown-item fw-bolder mx-0 px-0"
                                        href="{{ route('user.member.package') }}">Join Member Package</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('user.source-pro') }}">Source
                                        Pro</a>
                                </li>

                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.suppliers') }}">Suppliers</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.news.show') }}">Suppliers News</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.spotlight') }}">Spotlight Stores</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.products') }}">Products</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.product-video.show') }}">Product Videos</a>
                                </li>
                                
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','limited-offer') }}">Limited Offers</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','hot') }}">Hot Products</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','bulk-buying') }}">Bulk Buying</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.type.products','daily-deals') }}">Daily Deals</a>
                                </li>
                                <li>
                                    <a class="dropdown-item mx-0 pb-1 px-0" href="{{ route('all.tenders') }}">Tenders</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ route('help.community') }}">
                                Help & Support
                            </a>

                        </li>
                    </ul>
                    <ul class="navbar-nav py-1 navbar-right ">

                        <li class="nav-item">
                            <a href="{{ route('all.suppliers') }}" class="nav-link">Suppliers |</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.spotlight') }}" class="nav-link">Stores |</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.products') }}" class="nav-link">Products |</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.tenders') }}" class="nav-link">Tenders</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav py-1 navbar-right">
                        <li>
                            <button type="button" class="btn btn-light rounded-0 custom-selected-language-btn"
                                data-bs-toggle="modal" data-bs-target="#customLanguageModal">
                                <img id="customSelectedFlag" src="https://flagcdn.com/w40/us.png" alt="Flag">
                                <span id="customSelectedLanguage">English</span>
                            </button>
                        </li>
                    </ul>

                    <div id="customGoogleTranslateElement" style="display: none;"></div>
                    <div class="navbar-nav py-1 d-flex justify-content-center">
                        <a href="{{ route('cart.product') }}" style="height: 3rem">
                            <img style="height: 100%" src="{{ asset('world-business/images/cartl.jpg') }}"
                                alt="" />
                        </a>
                    </div>
                </div>
            </nav>
            <div class="row d-xl-flex d-none align-items-center mt-0 mb-3">
                <div class="col-md-6 mt-2">
                    <div class="row">
                        <!-- Search -->
                        <div class="col-12">
                            <form method="get" action="{{ route('search') }}" class="form-search d-flex">
                                <select name="type-filter" id="type-filter">
                                    <option @selected(request('type-filter')=="products") value="products">Products</option>
                                    <option @selected(request('type-filter')=="stores") value="stores">Stores</option>
                                    <option @selected(request('type-filter')=="tenders") value="tenders">Tenders</option>
                                    <option @selected(request('type-filter')=="suppliers") value="suppliers">Suppliers</option>
                                </select>
                                <input type="search" value="{{ request('q') }}" name="search" placeholder="Search your requirement..." />
                                <button type="submit"
                                    class="btn btn-primary d-flex justify-content-around align-items-center">
                                    <i class="fa fa-search me-md-2 me-0"></i>
                                    <span class="d-md-block d-none">Search</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="row d-flex align-items-center justify-content-around">
                        <div class="col-md-4 mt-md-0 mt-3 d-flex justify-content-center log-profile">
                            <div class="d-flex align-items-center">
                                <!--<i class="fa-regular fs-1 fa-user" style="color: #8f8e8e;"></i>-->
                                <div class="profile">
                                    <img src=" @if (auth()->user()->profile != '') {{ asset('uploads/profile/' . auth()->user()->profile) }}
                                    @else
                                        {{ asset('world-business/images/signin.jpg') }} @endif "
                                        alt="" />
                                </div>
                                <div class="info-log">
                                    <h6>
                                        @if (Auth::check())
                                            <a
                                                href="
                                            @if (auth()->user()->account_type == 'buyer') {{ route('buyer.dashboard') }}
                                            @elseif(auth()->user()->account_type == 'seller')
                                            {{ route('seller.dashboard') }}
                                            @elseif(auth()->user()->account_type == 'admin')
                                            {{ route('admin.dashboard') }}
                                              @else
                                              {{-- {{ route('seller.dashboard') }} --}} @endif
                                            ">{{ explode(' ', Auth::user()->first_name)[0] }}</a>
                                        @else
                                            <a href="{{ route('login') }}">Sign In</a>
                                        @endif
                                    </h6>
                                    <p>
                                        @if (Auth::check())
                                            <a class="pt-2 d-block" href="{{ route('logout') }}">logout</a>
                                        @else
                                            <a href="{{ route('user.member.package') }}" class="pt-2 d-block">Join
                                                Free</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-md-0 mt-3 block-btn d-flex justify-content-around align-items-center">
                            <a href="{{ route('benefits.buyers') }}" class="btn hbtn btn-secondary px-4">Get
                                Quote</a>
                            <a href="{{ route('user.source-pro') }}" class="btn hbtn btn-primary px-4">Source PRO</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="row d-xl-none d-flex align-items-center my-4 mt-0">
                <div class="col-xl-6 mt-3">
                    <div class="row">
                        <!-- Search -->
                        <div class="col-xl-12">
                            <form method="get" action="{{ route('search') }}" class="form-search d-flex">
                                <select name="type-filter" id="type-filter">
                                    <option @selected(request('type-filter')=="products") value="products">Products</option>
                                    <option @selected(request('type-filter')=="stores") value="stores">Stores</option>
                                    <option @selected(request('type-filter')=="tenders") value="tenders">Tenders</option>
                                    <option @selected(request('type-filter')=="suppliers") value="suppliers">Suppliers</option>
                                </select>
                                <input type="search" value="{{ request('q') }}" name="search" placeholder="Search your requirement..." />
                                <button type="submit"
                                    class="btn btn-primary d-flex justify-content-around align-items-center">
                                    <i class="fa fa-search me-md-2 me-0"></i>
                                    <span class="d-md-block d-none">Search</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-3">
                    <div class="row d-flex align-items-center justify-content-around">
                        <div class="col-md-4 mt-md-0 mt-3 d-flex justify-content-center log-profile">
                            <div class="d-flex align-items-center">
                                <!-- <i class="fa-regular fs-1 fa-user" style="color: #8f8e8e;"></i> -->
                                <div class="profile">
                                    <img src="@if (auth()->user()->profile != '') {{ asset('uploads/profile/' . auth()->user()->profile) }}
                                    @else
                                        {{ asset('world-business/images/signin.jpg') }} @endif "
                                        alt="" />
                                </div>
                                <div class="info-log">
                                    <h6>
                                        @if (Auth::check())
                                            <a
                                                href="
                                            @if (auth()->user()->account_type == 'buyer') {{ route('buyer.dashboard') }}
                                            @elseif(auth()->user()->account_type == 'seller')
                                            {{ route('seller.dashboard') }}
                                            @elseif(auth()->user()->account_type == 'admin')
                                            {{ route('admin.dashboard') }}
                                              @else
                                              {{-- {{ route('seller.dashboard') }} --}} @endif
                                            ">{{ explode(' ', Auth::user()->first_name)[0] }}</a>
                                        @else
                                            <a href="{{ route('login') }}">Sign In</a>
                                        @endif
                                    </h6>
                                    <p>
                                        @if (Auth::check())
                                            <a class="pt-2 d-block" href="{{ route('logout') }}">logout</a>
                                        @else
                                            <a href="{{ route('user.member.package') }}" class="pt-2 d-block">Join
                                                Free</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-md-0 mt-3 block-btn d-flex justify-content-around align-items-center">
                            <a href="{{ route('benefits.buyers') }}" class="btn hbtn btn-secondary px-4">Get
                                Quote</a>
                            <a href="{{ route('user.source-pro') }}" class="btn hbtn btn-primary px-4">Source PRO</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row shadow">
    <div class="col-xl-12">
        <nav class="navbar bottomnav navbar-expand-xl bg-white">
            <p></p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown1" aria-controls="navbarNavDropdown1" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse subNav navbar-collapse" id="navbarNavDropdown1">
                <ul class="navbar-nav navbar-left mx-auto">

                    <li class="nav-item">
                        <a href="{{ route('seller.dashboard') }}" class="nav-link">
                            <i class="fa-solid fa-gauge"></i> Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('inbox.show') }}" class="nav-link">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-envelope"></i> Inbox
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-building"></i> Profile & Management
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0"
                                    href="{{ route('seller.edit.registration', auth()->user()->ref_no) }}"><i
                                        class="fa-solid me-2 fa-building"></i> Update
                                    Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.certificates') }}"><i
                                        class="fa-solid me-2 fa-certificate"></i>My Certifications</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.bank.detail') }}"><i
                                        class="fa-solid me-2 fa-bank"></i> My Bank Details</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.social-media') }}"><i
                                        class="fa-solid me-2 fa-globe"></i>My Social Media</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.vendor.gallery') }}"><i
                                        class="fa-solid me-2 fa-image"></i>Profile Images</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.search.keys') }}">
                                    <i class="fa-brands fa-searchengin me-2"></i>
                                    Profile Search Keys
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.profile.meta-data') }}">
                                    <i class="fa-brands fa-searchengin me-2"></i>
                                    Profile Meta Datas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.business.symbols') }}"><i
                                        class="fa-solid me-2 fa-globe"></i>Profile Symbols</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0"
                                    href="{{ route('seller.profile.preview', auth()->user()->ref_no) }}"><i
                                        class="fa-solid me-2 fa-id-card-clip"></i>View Profile</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-bars-progress"></i> Products &
                            Management
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.add.product') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>List Product</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.get.products') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>My listed Products</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.get.sold.products') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>My Sold Product</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.purchased.product') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>My Purchased Products</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-link"></i> Spotlight Store
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.multiple-listing') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>List Multiply Products</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0"
                                    href="{{ route('seller.get.multiply.products') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>My Listed Multiply Products</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.get.msold.products') }}"><i
                                        class="fa-solid me-2 fa-gift"></i>My Sold Multiply Product</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.spotlight.gallery') }}"><i
                                        class="fa-solid me-2 fa-images"></i> Store Images</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.spotlight.search.key') }}"><i
                                        class="fa-solid me-2 fa-search"></i> Store Search Keys</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.add.meta-data') }}">
                                    <i class="fa-solid me-2 fa-circle-info"></i>Store Meta Datas</a>
                            </li>

                            <li>
                                <a class="dropdown-item mx-0 px-0"
                                    href="{{ route('seller.spotlight', Auth::user()->ref_no) }}">
                                    <i class="fa-solid me-2 fa-store"></i> View Store</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-bullhorn"></i> Tenders & Management
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.add.tender') }}"><i
                                        class="fa-solid me-2 fa-bullhorn"></i>List Tender</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.get.tender') }}"><i
                                        class="fa-solid me-2 fa-bullhorn"></i>My listed Tenders</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.deal.offer.tender') }}"><i
                                        class="fa-solid me-2 fa-bullhorn"></i>My Tender Deals</a>
                            </li>
                           
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <i class="fa-solid fa-quote-right"></i>
                            Quotations & Management
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('user.get.quotes') }}"><i
                                        class="fa-solid me-2 fa-sheet-plastic"></i>List
                                    Request</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('myquotations.show') }}"><i
                                        class="fa-solid me-2 fa-sheet-plastic"></i> My Listed
                                    Requests</a>
                            </li>
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.quote-deal') }}">
                                    <i class="fa-solid me-2 fa-sheet-plastic"></i>
                                    My Quotation Deals
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="d-lg-inline d-none">|</span>
                            <img src="{{ asset('world-business/images/icons8-microphone-96.png') }}" height="17"
                                width="17" alt="" />
                            My News
                        </a>
                        <ul class="dropdown-menu p-2">
                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.add.news') }}"><i
                                        class="fa-solid me-2 fa-microphone"></i>List News</a>
                            </li>

                            <li>
                                <a class="dropdown-item mx-0 px-0" href="{{ route('seller.my.news') }}"><i
                                        class="fa-solid me-2 fa-microphone"></i>My Listed News
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>




<!-- Language Selection Modal -->
<div class="modal fade" id="customLanguageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="customLanguageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customLanguageModalLabel">Choose Your Language</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="customLanguageList">
                </div>
            </div>
        </div>
    </div>
</div>