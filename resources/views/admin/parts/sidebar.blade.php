<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-2 py-5">
            <img src="{{ asset('dashboard/img/logo.png') }}" style="height: 100%; width: 100%" alt="" />
        </div>
    </a>

    <li class="nav-item">
        <a href="" class="nav-link">Welcome <strong>Administrator</strong></a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>General Setting</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="{{ route('admin.general.setting') }}">General Setting</a>
                <a class="collapse-item" href="{{ route('admin.member.package') }}">Member Package</a>
                <a class="collapse-item" href="{{ route('admin.password.change') }}">Change Admin Password</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-users"></i>
            <span>User Management</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item" href="{{ route('admin.show.buyers') }}">Show all Buyers</a>
                <a class="collapse-item" href="{{ route('admin.all.sellers') }}">Show all Sellers</a>

            </div>
        </div>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-envelope "></i>
            <span>Approval Center</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item" href="{{ route('admin.product.approval') }}">Product Approval</a>
                
                <a class="collapse-item" href="{{ route('admin.buy.tender.approval') }}">RFQ Approval</a>
                <a class="collapse-item" href="{{ route('admin.sell.tender.approval') }}">Tenders Approval</a>
                 <a class="collapse-item" href="{{ route('admin.seller.approval') }}">Sellers Approval</a>
            </div>
        </div>
    </li> -->

     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-users "></i>
            <span>Profile Images</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">


                <a class="collapse-item" href="{{ route('admin.company-logos.index') }}">Company logo`s</a>
                
                <a class="collapse-item" href="{{ route('admin.profile-pictures.index') }}">Profile Pictures </a>
                <a class="collapse-item" href="{{ route('admin.profile-banners.index') }}">Profile  Banners</a>
                <a class="collapse-item" href="{{ route('admin.profile-galleries.index') }}">Profile  Gallery</a>
                <a class="collapse-item" href="{{ route('admin.certificates.index') }}">Certifications</a>
            </div>

        </div>
    </li> 

     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupon"
            aria-expanded="true" aria-controls="collapseCoupon">
            <i class="fa-solid fa-fw fa-phone"></i>
            <span>Support Inquiry</span>
        </a>
        <div id="collapseCoupon" class="collapse" aria-labelledby="headingCoupon" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="{{ route('admin.inquiries.index') }}">Buyer Inquiry`s</a>
                <a class="collapse-item" href="{{ route('admin.sellerinquiries.index') }}">Seller Inquiry`s</a> 
                 <a class="collapse-item" href="#">Users Communications</a>
            </div>
        </div>
    </li>
    <li class="nav-item "> 
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
            aria-expanded="true" aria-controls="collapseProduct">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Product Management</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="{{ route('admin.product.manager') }}">All listed normal Products</a>
                <a class="collapse-item" href="#">All Normal sell out Products</a>
            </div>
        </div>
    </li>

    <li class="nav-item "> 
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStore"
            aria-expanded="true" aria-controls="collapseStore">
            <i class="fas fa-fw fa-store"></i>
            <span>Store Management</span>
        </a>
        <div id="collapseStore" class="collapse" aria-labelledby="headingStore" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="#">All listed  multiply Products</a>
                <a class="collapse-item" href="#">Multiply sell out Products</a>
                 <a class="collapse-item" href="{{route('admin.stores.index')}}">All Store</a>
            </div>
        </div>
    </li>

     <li class="nav-item "> 
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVideo"
            aria-expanded="true" aria-controls="collapseVideo">
            <i class="fas fa-fw fa-video"></i>
            <span>Video Management</span>
        </a>
        <div id="collapseVideo" class="collapse" aria-labelledby="headingVideo" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="{{route('admin.videos.index')}}">All Products Videos</a>
 
            </div>
        </div>
    </li>
    <li class="nav-item ">
        <a class="nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapseSix"
            aria-expanded="true" aria-controls="collapseSix">

            <i class="fas fa-fw fa-money-bill-trend-up "></i>
            <span>Tender Management</span>
        </a>
        <div id="collapseSix" class="collapse " aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item " href="{{ route('admin.sell.trade.list') }}">All listed Tenders</a>
                <a class="collapse-item" href="{{ route('admin.buy.trade.list') }}">All Tender Deals</a>


            </div>
        </div>
    </li>
     <li class="nav-item "> 

            <a class="nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapseQuotation"
            aria-expanded="true" aria-controls="collapseQuotation">

           <i class="fas fa-fw fa-credit-card "></i>
            <span>Quotation Management</span>
        </a>
        <div id="collapseQuotation" class="collapse " aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item " href="{{ route('admin.all.buy.quotations') }}">All listed  FRQ`s </a>
                <a class="collapse-item" href="{{ route('admin.buy.trade.list') }}">All Quotation Deals</a>


            </div>
        </div>
    </li>

    

    <li class="nav-item ">
        <a class="nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapse10"
            aria-expanded="true" aria-controls="collapse10">

            <i class="fa-solid fa-fw fa-tv "></i>
            <span>News Management</span>
        </a>
        <div id="collapse10" class="collapse " aria-labelledby="headingEight" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item " href="{{route('admin.all.news') }}">All listed News</a>
                <!-- <a class="collapse-item" href="{{route('admin.add.news')}}">Add News</a> -->

            </div>
        </div>
    </li>

   
     <li class="nav-item">
        <a class="nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapseProvision"
            aria-expanded="true" aria-controls="collapseProvision">

            <i class="fa-solid fa-fw fa-shopping-basket "></i>
            <span>Sale Provision</span>
        </a>
        <div id="collapseProvision" class="collapse " aria-labelledby="headingEight" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item " href="#">Include Sale Provision</a>
                <a class="collapse-item"  href="#">Additional Sale Provision</a>

            </div>
        </div>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.payment.center') }}">

            <i class="fas fa-fw fa-money-bill "></i>
            <span>Payment Center</span></a>
    </li>
   
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupon"
            aria-expanded="true" aria-controls="collapseCoupon">
            <i class="fas fa-fw fa-gift"></i>
            <span>Promotion Management</span>
        </a>
        <div id="collapseCoupon" class="collapse" aria-labelledby="headingCoupon" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">
                <a class="collapse-item" href="{{ route('admin.all.coupon') }}">Promotions</a>
                <a class="collapse-item" href="{{ route('admin.create.coupon') }}">Add Promotion</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">

            <i class="fas fa-fw fa-chart-bar "></i>
            <span>Categories</span>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item" href="{{route('admin.all.attribute')}}">Attributes & Values</a>
                <a class="collapse-item" href="{{ route('admin.show.all.productCategory') }}">Products & Tenders</a>
                <a class="collapse-item" href="{{ route('admin.all.custome.category') }}">Suppliers & Quotations</a>

            </div>
        </div>
    </li>
    

    

    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.ads.banners') }}">
            <i class="fas fa-fw fa-tag "></i>
            <span>Ads & Banners</span></a>
    </li>
   
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.seo.manager') }}">
            <i class="fa-solid fa-fw fa-network-wired"></i>

            <span>SEO</span></a>
    </li>
    <!-- <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.all.enquiries') }}">
            <i class="fa-solid fa-fw fa-phone"></i>

            <span>Inquiry Box</span></a>
    </li> -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.all.countries') }}">
            <i class="fa-solid fa-fw fa-location-dot"></i>

            <span>Location Management</span></a>
    </li>
    <!-- <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.all.enquiries.admin') }}">
            <i class="fa-solid fa-fw fa-phone"></i>

            <span>Admin Inquiry</span></a>
    </li> -->

    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.home.setting') }}">
            <i class="fa-solid fa-fw fa-file"></i>

            <span>Home Page Management</span></a>
    </li>
    
     <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.send.bulk.mail') }}">

            <i class="fa-solid fa-envelopes-bulk"></i>
            <span>Bulk Mail</span></a>
    </li>
    <!-- <li class="nav-item ">
        <a class="nav-link  collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSix">

            <i class="fa-solid fa-fw fa-file "></i>
            <span>Web Page Creater</span>
        </a>
        <div id="collapseSeven" class="collapse " aria-labelledby="headingSeven" data-parent="#accordionSidebar">
            <div class="bg-white  collapse-inner ">

                <a class="collapse-item " href="{{ route('admin.add.static.page') }}">Add Static Page</a>
                <a class="collapse-item" href="{{ route('admin.all.static.page') }}">Static Page List</a>
                <a class="collapse-item" href="{{ route('admin.cms.static.page') }}">CMS Page List</a>


            </div>
        </div>
    </li> -->
    <!-- <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.import.customers') }}">

            <i class="fas fa-fw fa-download "></i>
            <span>Import Customer</span></a>
    </li> -->
   
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.all.email.templates') }}">
            <i class="fa-solid fa-fw fa-message"></i>

            <span>eMail Template</span></a>
    </li>
    <!-- <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.videos.index') }}">
            <i class="fa-solid fa-fw fa-video"></i>

            <span>Video Show</span></a>
    </li> -->


    

    <li class="nav-item ">
        <a class="nav-link" href="{{route('admin.advertisement.enquiries')}}">
            <i class="fa-solid fa-fw fa-tv"></i>

            <span>Advertisements Enquiries</span></a>
    </li>



    <div class="text-center d-none d-md-inline mt-4">
        <button class="-circle border-0" id="sidebarToggle"></button>
    </div>


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
