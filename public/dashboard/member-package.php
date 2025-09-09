<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboar Member Package</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                                    Member package
                                </div>
                                <div class="card-body pb-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Package Name</th>
                                                    <th>Price</th>
                                                    <th>Valid Days</th>
                                                    <th>No. Of Product Limit</th>
                                                    <th>Sell Tender Limit</th>
                                                    <th>Buy Tender Limit</th>
                                                    <th>News Limit</th>
                                                    <th>Trade Leads Included</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Bronce Package</td>
                                                    <td>0</td>
                                                    <td>90</td>
                                                    <td>10</td>
                                                    <td>12</td>
                                                    <td>12</td>
                                                    <td>3</td>
                                                    <td>100</td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit    "></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Silver Package</td>
                                                    <td>$49,00</td>
                                                    <td>365</td>
                                                    <td>50</td>
                                                    <td>48</td>
                                                    <td>48</td>
                                                    <td>24</td>
                                                    <td>500</td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit    "></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Gold Package</td>
                                                    <td>$99,00</td>
                                                    <td>365</td>
                                                    <td>100</td>
                                                    <td>72</td>
                                                    <td>72</td>
                                                    <td>36</td>
                                                    <td>1000</td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit    "></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Platinum Package</td>
                                                    <td>$199,00</td>
                                                    <td>365</td>
                                                    <td>500</td>
                                                    <td>144</td>
                                                    <td>144</td>
                                                    <td>60</td>
                                                    <td>2000</td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit    "></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mt-5">
                                <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Package Service
                                    <a href="./add-package-service.php" class="btn btn-secondary ">Add Package Service</a>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Service Name</th>
                                                    <th>Bronce</th>
                                                    <th>Silver</th>
                                                    <th>Gold</th>
                                                    <th>Platinum</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Company Business Profile</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id1" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Subdomain Micro Website</td>
                                                    <td>No </td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id2" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Company + Product Verified Seal</td>
                                                    <td>No </td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id3" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Company + Product Trust Seal</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id4" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Company + Product Promotions</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id5" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Company + Product SEO</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id6" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Product listing Prime Pack</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id7" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Company listing Ultra</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id8" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Quotation Service</td>
                                                    <td>No</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>Yes</td>
                                                    <td>
                                                    <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id9" checked value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>