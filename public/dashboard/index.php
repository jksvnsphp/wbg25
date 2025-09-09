<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>WBG24 Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php require_once './part/sidebar.php' ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php require_once './part/topbar.php' ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12 mb-3">
              <div class="card bg-white rounded-0 p-3 font-weight-bolder text-dark">Today Approval</div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-light-success rounded-1 text-dark-success border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">
                      <i class="fa fa-thumbs-up fs-7 " aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                      <h4 class="">(0/0)</h4>
                      <div class="font-weight-bold ">Approval Products</div>
                    </div>
                  </div>
                </div>
                <a href="./product-approval.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-dark-success">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-light-info rounded-1 text-dark-info border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-2">
                      <i class="fas fa-rss fs-7"></i>

                    </div>
                    <div class="col-sm-10 text-right">
                      <h4 class="">(0/0)</h4>
                      <div class="font-weight-bold ">Approval Buy Tender</div>
                    </div>
                  </div>
                </div>
                <a href="./buy-tenders.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-danger rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-2">

                      <i class="fas fa-chart-line fs-7"></i>

                    </div>
                    <div class="col-sm-10 text-right ">
                      <h4 class="">(0/0)</h4>
                      <div class="font-weight-bold ">Approval Sell Tenders</div>
                    </div>
                  </div>
                </div>
                <a href="./seller-approval.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-danger">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-info rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-user-plus fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right ">
                      <h4 class="">(0/0)</h4>
                      <div class="font-weight-bold ">Approval Sellers</div>
                    </div>
                  </div>
                </div>
                <a href="./sell-tenders.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-info">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-lg-12 mb-3">
              <div class="card bg-white rounded-0 p-3 font-weight-bolder text-dark">All Updates</div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-info rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-user fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right ">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Users Registrations</div>
                    </div>
                  </div>
                </div>
                <a href="./show-buyers.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-info">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-success rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-tasks fs-7 " aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Trade leads sell out</div>
                    </div>
                  </div>
                </div>
                <a href="./show-sellers.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-dark-success">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-warning rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">
                       
                      <i class="fas fa-envelope  fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Today Inquiry</div>
                    </div>
                  </div>
                </div>
                <a href="./enquiry-box.php " class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-warning">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-primary rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-cart-plus fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right ">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Sell out Products</div>
                    </div>
                  </div>
                </div>
                <a href="./all-products.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-primary">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>


            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-secondary rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-2">

                      <i class="fas fa-chart-area  fs-7"></i>

                    </div>
                    <div class="col-sm-10 text-right ">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Sell out Buy Tenders</div>
                    </div>
                  </div>
                </div>
                <a href="./trade-buy-list.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-secondary">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-danger rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-2">

                      <i class="fa fa-random fs-7 " aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-10 text-right">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Sell out sell Tenders</div>
                    </div>
                  </div>
                </div>
                <a href="./trade-sell-list.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-danger">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-info rounded-1 text-light border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-bullhorn  fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Quotation Deals</div>
                    </div>
                  </div>
                </div>
                <a href="./all-tenders-products.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-info">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
              <div class="card  shadow ">
                <div class=" py-3 px-2 bg-light-info rounded-1 text-dark-info border-bottom-radius-0">
                  <div class="row">
                    <div class="col-sm-3">

                      <i class="fa fa-tags fs-7"></i>

                    </div>
                    <div class="col-sm-9 text-right ">
                      <h4 class="">0</h4>
                      <div class="font-weight-bold ">Suppliers News</div>
                    </div>
                  </div>
                </div>
                <a href="./all-buy-requirements.php" class="card-footer py-2 bg-white">
                  <div class="d-flex align-items-center justify-content-between text-dark-info">
                    <span class="font-weight-bold fs-2">View Details</span>
                    <i class="fa fa-arrow-circle-right fs-3"></i>

                  </div>
                </a>
              </div>
            </div>

          </div>

          <div class="row icon_cards_home mt-3">
            <div class="col-lg-12 mb-3">
              <div class="card bg-white rounded-0 p-3 font-weight-bolder text-dark">Usefull Links</div>
            </div>
            <a href="./general-setting.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a1.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    General Setting
                  </h6>
                </div>
              </div>
            </a>
            <a href="./show-buyers.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a2.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Buyer Management
                  </h6>
                </div>
              </div>
            </a>

            <a href="./show-sellers.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a3.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Seller Management
                  </h6>
                </div>
              </div>
            </a>

            <a href="./show-location.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a4.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Location Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./seo-managements.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a5.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    SEO Tools and Setting
                  </h6>
                </div>
              </div>
            </a>
            <a href="./email-templates.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a6.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Email Settings and Templates
                  </h6>
                </div>
              </div>
            </a>
            <a href="./all-banners.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a7.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Ads Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./all-advertisements-enquiry.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a8.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Advertisement Inquiries
                  </h6>
                </div>
              </div>
            </a>
            <a href="./all-payments.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a9.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Payments Overview
                  </h6>
                </div>
              </div>
            </a>

            <a href="./enquiry-box.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a10.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Inquiry Box
                  </h6>
                </div>
              </div>
            </a>
            <a href="./product-categories.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a11.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Categories
                  </h6>
                </div>
              </div>
            </a>
            <a href="./static-page-list.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a12.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Static Page List
                  </h6>
                </div>
              </div>
            </a>
            <a href="./tender-categories.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a13.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Tenders Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./all-products.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a14.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Products Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./home-page-management.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a15.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Homepage Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="notfound" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a16.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Franchise
                  </h6>
                </div>
              </div>
            </a>
            <a href="./import-customer.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a17.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Excel Import
                  </h6>
                </div>
              </div>
            </a>
            <a href="./export-customer.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a18.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Excel Export
                  </h6>
                </div>
              </div>
            </a>
            <a href="./currency-management.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a19.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Trade Lead Management
                  </h6>
                </div>
              </div>
            </a>

            <a href="./general-setting.php " class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a20.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Social Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./general-setting.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a21.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Google Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./general-setting.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a22.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Logo Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./member-package.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a23.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Member Package Management
                  </h6>
                </div>
              </div>
            </a>
            <a href="./perday-users.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a24.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Company Statistics
                  </h6>
                </div>
              </div>
            </a>
            <a href="./top-view-products.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a25.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    User Statistics
                  </h6>
                </div>
              </div>
            </a>
            <a href="./shows-news-list.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a26.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    News
                  </h6>
                </div>
              </div>
            </a>
            <a href="./trade-shows-list.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a27.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Product Video Show
                  </h6>
                </div>
              </div>
            </a>
            <a href="notfound" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a28.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Success Stories
                  </h6>
                </div>
              </div>
            </a>
            
            <a href="./sell-tenders.php" class="col-md-2 col-sm-4 col-6 mb-3">
              <div class="card shadow">
                <div class="card-body p-0 py-3 d-flex align-items-center flex-column">
                  <div class="icon_img mb-3">
                    <img src="./img/icons/a30.png" class="h-100 w-100" alt="">
                  </div>
                  <h6 class="fs-2 px-2 font-weight-bold text-center text-primary">
                    Approval Center
                  </h6>
                </div>
              </div>
            </a>
          </div>


        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once './part/footer.php' ?>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">
            Cancel
          </button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

 
</body>

</html>