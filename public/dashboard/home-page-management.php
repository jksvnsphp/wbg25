<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Home Page Management</title>

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
                        <div class="col-md-12 mb-3">
                            <div class="card rounded-0">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Home Page Banner
                                </div>
                                <style>
                                    .table_banner table img {
                                        height: 6rem !important;
                                    }
                                </style>
                                <div class="card-body pb-0">
                                    <div class="table_banner">
                                        <small style="color:#F00">Banner Image Size:1500x300px</small>
                                        <table class="table table-striped table-bordered table-responsive" cellpadding="0" cellspacing="0" width="100%">
                                            <form name="edit_homebanner" action="#" method="post" enctype="multipart/form-data"></form>
                                            <tbody>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner First</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner1">
                                                    </td>
                                                    <td><input type="hidden" value="1628148674.jpg" name="hid_banner1"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/1628148674.jpg" class="img-responsive ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner First text</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner1_text" value="Join Now">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner First link</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner1_link" value="login.html">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Second</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner2">
                                                    </td>
                                                    <td><input type="hidden" value="1628149157.jpg" name="hid_banner2" id="id_hid_banner2"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/1628149157.jpg" class="img-responsive  ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Second Text</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner2_text" value="products ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner second link</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner2_link" value="product.html">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Third</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner3">
                                                    </td>
                                                    <td><input type="hidden" value="1629284014.jpg" name="hid_banner3" id="id_hid_banner3"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/1629284014.jpg" class="img-responsive  ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Third Text</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner3_text" value="Get Quotation Now">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Third Link</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner3_link" value="product.html">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Forth</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner4">
                                                    </td>
                                                    <td><input type="hidden" value="15893514511.jpg" name="hid_banner4" id="id_hid_banner4"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/15893514511.jpg" class="img-responsive  ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Forth text</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner4_text" value="Join Now">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Forth link</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner4_link" value="login.html">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Fiveth</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner5">
                                                    </td>
                                                    <td><input type="hidden" value="1582074445.jpg" name="hid_banner5" id="id_hid_banner5"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/1582074445.jpg" class="img-responsive  ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Fiveth text</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner5_text" value="Join Now">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Banner Fiveth link</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner5_link" value="login.html">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <input class="btn btn-primary set-btn" type="submit" name="btn_banner" value="change">
                                                    </td>
                                                    <td></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-5">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Home Top Categoery
                                </div>
                                <style>
                                    .table_category table img {
                                        height: 100% !important;
                                        width: 100% !important;
                                    }
                                </style>
                                <div class="card-body pb-0">
                                    <div class="table_category">

                                        <small style="color:#F00">Image Size: 590x360PX</small>
                                        <table class="table table-striped table-bordered table-responsive table-responsive" cellpadding="0" cellspacing="0" width="100%">
                                            <form name="edit_homebanner" action="#" method="post" enctype="multipart/form-data"></form>
                                            <tbody>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">Image</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="file" class="form-control" name="banner1">
                                                    </td>
                                                    <td><input type="hidden" value="1588026484.jpg" name="hid_banner1"></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"></td>
                                                    <td class="last" width="50%">
                                                        <img src="./img/banner/1588026484.jpg" class="img-responsive ">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">First Title</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner1_text" value="Messages">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">First Short Content</strong></td>
                                                    <td class="last" width="50%">
                                                        <input type="text" class="form-control" name="banner2_text" value="Business to Business B2B">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td class="first" width="30%"><strong class="manten-th">First Detail</strong></td>
                                                    <td class="last" width="50%">
                                                        <textarea name="banner1_link" value="" class="form-control">.Business-to-business – “B2B” – refers to commerce between two businesses rather than to commerce between a business and an individual consumer. Transactions at the wholesale level are usually business-to-business.<br> The dollar value of business-to-business transactions is significantly higher than business-to-consumer activity because businesses are more likely to purchase higher priced goods and services and purchase more of them than consumers are. A bicycle manufacturer, for example, will purchase a truckload of bicycle tires or a coffee manufacturer will buy a massive, industrial bea</textarea>
                                                    </td>
                                                    <td width="300">
                                                        <div><span style="color: red;"></span> </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr class="bg">
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                            
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-5">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    RFQ & Featured Brands Panel
                                </div>
                                <style>
                                    .table_rfq table td {
                                       font-size: 15px !important;
                                    }
                                </style>
                                <div class="card-body pb-0">
                                    <div class="table_rfq">

                                        <table class="table table-striped  table-bordered table-responsive" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <th class="first" width="8%"><span class="manten-th">Sr.No.</span></th>
                                                    <th><span class="manten-th">Name</span></th>
                                                    <th><span class="manten-th">Title</span></th>
                                                    <th><span class="manten-th">Content</span></th>
                                                    <th><span class="manten-th">Icon</span></th>
                                                    <th class="last"><span class="manten-th">Action</span></th>
                                                </tr>
                                                <tr>
                                                    <td class="first style3">1</td>
                                                    <td>REQUEST FOR QUOTATION</td>
                                                    <td>Want to save time cost let us help you you</td>
                                                    <td>With EagleTrade, you can:.
                                                        Customize your Buying Request
                                                        Use professional purchasing agents
                                                        Get</td>
                                                    <td><img src="./img/logo/1631664035.png" width="50" height="50"></td>
                                                    <td class="last">
                                                        <a href="#"><button type="button" title="Edit" class="btn btn-info btn-sm" ><i class="fa fa-edit"></i></button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="first style3">2</td>
                                                    <td>Featured Brands</td>
                                                    <td>Discover Exclusive Global Trade at Incredible Prices</td>
                                                    <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean br
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis.</td>
                                                    <td><img src="./img/logo/01114990615681522240404.jpg" width="50" height="50"></td>
                                                    <td class="last">
                                                        <a href="#"><button type="button" title="Edit" class="btn btn-info btn-sm" ><i class="fa fa-edit"></i></button></a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>

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
    <!-- Page level plugins -->


</body>

</html>