<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-text mx-2 py-5">
            <img src="{{ asset('dashboard/img/logo.png') }}" style="height: 100%; width: 100%" alt="" />
        </div>
    </a>

    <li class="nav-item">
        <a href="#" class="nav-link">Welcome <strong>Administrator</strong></a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
    </li>

    <!-- General Setting -->
    <li class="nav-item {{ request()->routeIs('admin.general.setting','admin.member.package','admin.password.change') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo">
            <i class="fas fa-fw fa-tachometer-alt"></i><span>General Setting</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->routeIs('admin.general.setting','admin.member.package','admin.password.change') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.general.setting') ? 'active' : '' }}" href="{{ route('admin.general.setting') }}">General Setting</a>
                <a class="collapse-item {{ request()->routeIs('admin.member.package') ? 'active' : '' }}" href="{{ route('admin.member.package') }}">Member Package</a>
                <a class="collapse-item {{ request()->routeIs('admin.password.change') ? 'active' : '' }}" href="{{ route('admin.password.change') }}">Change Admin Password</a>
            </div>
        </div>
    </li>

    <!-- User Management -->
    <li class="nav-item {{ request()->routeIs('admin.show.buyers','admin.all.sellers') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree">
            <i class="fas fa-fw fa-users"></i><span>User Management</span>
        </a>
        <div id="collapseThree" class="collapse {{ request()->routeIs('admin.show.buyers','admin.all.sellers') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.show.buyers') ? 'active' : '' }}" href="{{ route('admin.show.buyers') }}">Show all Buyers</a>
                <a class="collapse-item {{ request()->routeIs('admin.all.sellers') ? 'active' : '' }}" href="{{ route('admin.all.sellers') }}">Show all Sellers</a>
            </div>
        </div>
    </li>

    <!-- Profile Images -->
    <li class="nav-item {{ request()->routeIs('admin.company-logos.index','admin.profile-pictures.index','admin.profile-banners.index','admin.profile-galleries.index','admin.certificates.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour">
            <i class="fas fa-fw fa-users"></i><span>Profile Images</span>
        </a>
        <div id="collapseFour" class="collapse {{ request()->routeIs('admin.company-logos.index','admin.profile-pictures.index','admin.profile-banners.index','admin.profile-galleries.index','admin.certificates.index') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.company-logos.index') ? 'active' : '' }}" href="{{ route('admin.company-logos.index') }}">Company Logo`s</a>
                <a class="collapse-item {{ request()->routeIs('admin.profile-pictures.index') ? 'active' : '' }}" href="{{ route('admin.profile-pictures.index') }}">Profile Pictures</a>
                <a class="collapse-item {{ request()->routeIs('admin.profile-banners.index') ? 'active' : '' }}" href="{{ route('admin.profile-banners.index') }}">Profile Banners</a>
                <a class="collapse-item {{ request()->routeIs('admin.profile-galleries.index') ? 'active' : '' }}" href="{{ route('admin.profile-galleries.index') }}">Profile Gallery</a>
                <a class="collapse-item {{ request()->routeIs('admin.certificates.index') ? 'active' : '' }}" href="{{ route('admin.certificates.index') }}">Certifications</a>
            </div>
        </div>
    </li>

    <!-- Action Images -->
    <li class="nav-item {{ request()->routeIs('admin.product.product_images','admin.product.multiply_product_images','admin.tender.tender_images','admin.quotation.images','admin.all.newsImages') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour21">
            <i class="fas fa-fw fa-users"></i><span>Action Images</span>
        </a>
        <div id="collapseFour21" class="collapse {{ request()->routeIs('admin.product.product_images','admin.product.multiply_product_images','admin.tender.tender_images','admin.quotation.images','admin.all.newsImages') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.product.product_images') ? 'active' : '' }}" href="{{ route('admin.product.product_images') }}">Product Images</a>
                <a class="collapse-item {{ request()->routeIs('admin.product.multiply_product_images') ? 'active' : '' }}" href="{{ route('admin.product.multiply_product_images') }}">Multiply Product Images</a>
                <a class="collapse-item {{ request()->routeIs('admin.tender.tender_images') ? 'active' : '' }}" href="{{ route('admin.tender.tender_images') }}">Tender Images</a>
                <a class="collapse-item {{ request()->routeIs('admin.quotation.images') ? 'active' : '' }}" href="{{ route('admin.quotation.images') }}">Quotation Images</a>
                <a class="collapse-item {{ request()->routeIs('admin.all.newsImages') ? 'active' : '' }}" href="{{ route('admin.all.newsImages') }}">News Images</a>
            </div>
        </div>
    </li>

    <!-- Store Images -->
    <li class="nav-item {{ request()->routeIs('admin.stores.images','admin.stores.banners') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStore">
            <i class="fas fa-fw fa-users"></i><span>Store Images</span>
        </a>
        <div id="collapseStore" class="collapse {{ request()->routeIs('admin.stores.images','admin.stores.banners') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.stores.images') ? 'active' : '' }}" href="{{ route('admin.stores.images') }}">Store Logos</a>
                <a class="collapse-item {{ request()->routeIs('admin.stores.banners') ? 'active' : '' }}" href="{{ route('admin.stores.banners') }}">Store Banners</a>
                <a class="collapse-item" href="#">Store Product Images</a>
            </div>
        </div>
    </li>

    <!-- Support Inquiry -->
    <li class="nav-item {{ request()->routeIs('admin.inquiries.index','admin.sellerinquiries.index','admin.userinquiries.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupon">
            <i class="fa-solid fa-fw fa-phone"></i><span>Support Inquiry</span>
        </a>
        <div id="collapseCoupon" class="collapse {{ request()->routeIs('admin.inquiries.index','admin.sellerinquiries.index','admin.userinquiries.index') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.inquiries.index') ? 'active' : '' }}" href="{{ route('admin.inquiries.index') }}">Buyer Inquiry`s</a>
                <a class="collapse-item {{ request()->routeIs('admin.sellerinquiries.index') ? 'active' : '' }}" href="{{ route('admin.sellerinquiries.index') }}">Seller Inquiry`s</a>
                <a class="collapse-item {{ request()->routeIs('admin.userinquiries.index') ? 'active' : '' }}" href="{{ route('admin.userinquiries.index') }}">Users Communications</a>
            </div>
        </div>
    </li>

    <!-- Product Management -->
    <li class="nav-item {{ request()->routeIs('admin.product.productmanagment','admin.product.productselloutmanagment') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct">
            <i class="fas fa-fw fa-briefcase"></i><span>Product Management</span>
        </a>
        <div id="collapseProduct" class="collapse {{ request()->routeIs('admin.product.productmanagment','admin.product.productselloutmanagment') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.product.productmanagment') ? 'active' : '' }}" href="{{ route('admin.product.productmanagment') }}">All listed normal Products</a>
                <a class="collapse-item {{ request()->routeIs('admin.product.productselloutmanagment') ? 'active' : '' }}" href="{{ route('admin.product.productselloutmanagment') }}">All Sellout Products</a>
            </div>
        </div>
    </li>

    <!-- Store Management -->
    <li class="nav-item {{ request()->routeIs('admin.product.storeproductmanagment','admin.product.storeselloutproductmanagment','admin.stores.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStorem">
            <i class="fas fa-fw fa-store"></i><span>Store Management</span>
        </a>
        <div id="collapseStorem" class="collapse {{ request()->routeIs('admin.product.storeproductmanagment','admin.product.storeselloutproductmanagment','admin.stores.index') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.product.storeproductmanagment') ? 'active' : '' }}" href="{{ route('admin.product.storeproductmanagment') }}">All listed multiply Products</a>
                <a class="collapse-item {{ request()->routeIs('admin.product.storeselloutproductmanagment') ? 'active' : '' }}" href="{{ route('admin.product.storeselloutproductmanagment') }}">Multiply sell out Products</a>
                <a class="collapse-item {{ request()->routeIs('admin.stores.index') ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">All Store</a>
            </div>
        </div>
    </li>

    <!-- Video Management -->
    <li class="nav-item {{ request()->routeIs('admin.videos.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVideo">
            <i class="fas fa-fw fa-video"></i><span>Video Management</span>
        </a>
        <div id="collapseVideo" class="collapse {{ request()->routeIs('admin.videos.index') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.videos.index') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">All Products Videos</a>
            </div>
        </div>
    </li>

    <!-- Tender Management -->
    <li class="nav-item {{ request()->routeIs('admin.sell.trade.list','admin.sell.trade.deal_list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix">
            <i class="fas fa-fw fa-money-bill-trend-up"></i><span>Tender Management</span>
        </a>
        <div id="collapseSix" class="collapse {{ request()->routeIs('admin.sell.trade.list','admin.sell.trade.deal_list') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.sell.trade.list') ? 'active' : '' }}" href="{{ route('admin.sell.trade.list') }}">All listed Tenders</a>
                <a class="collapse-item {{ request()->routeIs('admin.sell.trade.deal_list') ? 'active' : '' }}" href="{{ route('admin.sell.trade.deal_list') }}">All Tender Deals</a>
            </div>
        </div>
    </li>

    <!-- Quotation Management -->
    <li class="nav-item {{ request()->routeIs('admin.quotations','admin.buy.trade.list') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuotation">
            <i class="fas fa-fw fa-credit-card"></i><span>Quotation Management</span>
        </a>
        <div id="collapseQuotation" class="collapse {{ request()->routeIs('admin.quotations','admin.buy.trade.list') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.quotations') ? 'active' : '' }}" href="{{ route('admin.quotations') }}">All listed FRQ`s</a>
                <a class="collapse-item {{ request()->routeIs('admin.buy.trade.list') ? 'active' : '' }}" href="{{ route('admin.buy.trade.list') }}">All Quotation Deals</a>
            </div>
        </div>
    </li>

    <!-- News Management -->
    <li class="nav-item {{ request()->routeIs('admin.all.news') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse10">
            <i class="fa-solid fa-fw fa-tv"></i><span>News Management</span>
        </a>
        <div id="collapse10" class="collapse {{ request()->routeIs('admin.all.news') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.all.news') ? 'active' : '' }}" href="{{ route('admin.all.news') }}">All listed News</a>
            </div>
        </div>
    </li>

    <!-- Sale Provision -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProvision">
            <i class="fa-solid fa-fw fa-shopping-basket"></i><span>Sale Provision</span>
        </a>
        <div id="collapseProvision" class="collapse">
            <div class="bg-white collapse-inner">
                <a class="collapse-item" href="{{ route('admin.member.saleProvisionInclude') }}">Include Sale Provision</a>
                <a class="collapse-item" href="{{ route('admin.member.additionalSaleProvision') }}">Additional Sale Provision</a>
            </div>
        </div>
    </li>

    <!-- Payment Center -->
    <li class="nav-item {{ request()->routeIs('admin.payment.center') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.payment.center') }}">
            <i class="fas fa-fw fa-money-bill"></i><span>Payment Center</span>
        </a>
    </li>

    <!-- Promotion Management -->
    <li class="nav-item {{ request()->routeIs('admin.all.coupon','admin.create.coupon') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupon2">
            <i class="fas fa-fw fa-gift"></i><span>Promotion Management</span>
        </a>
        <div id="collapseCoupon2" class="collapse {{ request()->routeIs('admin.all.coupon','admin.create.coupon') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.all.coupon') ? 'active' : '' }}" href="{{ route('admin.all.coupon') }}">Promotions</a>
                <a class="collapse-item {{ request()->routeIs('admin.create.coupon') ? 'active' : '' }}" href="{{ route('admin.create.coupon') }}">Add Promotion</a>
            </div>
        </div>
    </li>

    <!-- Categories -->
    <li class="nav-item {{ request()->routeIs('admin.all.attribute','admin.show.all.productCategory','admin.all.custome.category') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive">
            <i class="fas fa-fw fa-chart-bar"></i><span>Categories</span>
        </a>
        <div id="collapseFive" class="collapse {{ request()->routeIs('admin.all.attribute','admin.show.all.productCategory','admin.all.custome.category') ? 'show' : '' }}">
            <div class="bg-white collapse-inner">
                <a class="collapse-item {{ request()->routeIs('admin.all.attribute') ? 'active' : '' }}" href="{{route('admin.all.attribute')}}">Attributes & Values</a>
                <a class="collapse-item {{ request()->routeIs('admin.show.all.productCategory') ? 'active' : '' }}" href="{{ route('admin.show.all.productCategory') }}">Products & Tenders</a>
                <a class="collapse-item {{ request()->routeIs('admin.all.custome.category') ? 'active' : '' }}" href="{{ route('admin.all.custome.category') }}">Suppliers & Quotations</a>
            </div>
        </div>
    </li>

    <!-- Ads & Banners -->
    <li class="nav-item {{ request()->routeIs('admin.ads.banners') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.ads.banners') }}">
            <i class="fas fa-fw fa-tag"></i><span>Ads & Banners</span>
        </a>
    </li>

    <!-- SEO -->
    <li class="nav-item {{ request()->routeIs('admin.seo.manager') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.seo.manager') }}">
            <i class="fa-solid fa-fw fa-network-wired"></i><span>SEO</span>
        </a>
    </li>

    <!-- Location Management -->
    <li class="nav-item {{ request()->routeIs('admin.all.countries') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.all.countries') }}">
            <i class="fa-solid fa-fw fa-location-dot"></i><span>Location Management</span>
        </a>
    </li>

    <!-- Home Page Management -->
    <li class="nav-item {{ request()->routeIs('admin.home.setting') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home.setting') }}">
            <i class="fa-solid fa-fw fa-file"></i><span>Home Page Management</span>
        </a>
    </li>

    <!-- Bulk Mail -->
    <li class="nav-item {{ request()->routeIs('admin.send.bulk.mail') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.send.bulk.mail') }}">
            <i class="fa-solid fa-envelopes-bulk"></i><span>Bulk Mail</span>
        </a>
    </li>

    <!-- eMail Template -->
    <li class="nav-item {{ request()->routeIs('admin.all.email.templates') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.email_templates.index') }}">
            <i class="fa-solid fa-fw fa-message"></i><span>eMail Template</span>
        </a>
    </li>

    <!-- Advertisement Enquiries -->
    <li class="nav-item {{ request()->routeIs('admin.advertisement.enquiries') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.advertisement.enquiries') }}">
            <i class="fa-solid fa-fw fa-tv"></i><span>Advertisements Enquiries</span>
        </a>
    </li>

</ul>


<script>
    @if (Session::has('message'))

        var type = "{{ Session::get('alert-type', 'info') }}";



        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':

                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
    @endif
</script>
