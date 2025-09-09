<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Tender Categories</title>

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
                                <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    All Products

                                </div>

                                <div class="card-body pb-0">

                                    <style>
                                        td {
                                            padding: 2px 7px !important;
                                        }

                                        .product_img {
                                            height: 4rem !important;
                                            width: 4rem !important;
                                        }

                                        .nowrap {
                                            white-space: nowrap !important;

                                        }
                                    </style>
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Image</th>
                                                    <th class="nowrap">Product Details</th>
                                                    <th>Approved</th>
                                                    <th>Wholesale</th>
                                                    <th>Bulk</th>
                                                    <th>Daily</th>
                                                    <th>Hot</th>
                                                    <th>Limit Offer</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="align-middle">1</td>
                                                    <td class="align-middle">
                                                        <div>
                                                            <img src="./img/tender-category/1.jpg" class="product_img img-thumbnail" alt="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-primary pb-0 mb-0 font-weight-bolder fs-3 text-capitalize" title="MacBook Pro"><a href="#" target="_blank">MacBook Pro</a></p>
                                                        <div class="text-capitalize fs-2 font-weight-bold">Samsung</div>
                                                        <div class="text-muted">
                                                            <span class="badge badge-success" style="font-size:13px;">Price: 1299.00</span>
                                                            <span class="badge badge-warning" style="font-size:13px;">Qty: 0</span>
                                                        </div>
                                                        <small class="text-muted fs-1 nowrap">Entry Date: 2023-07-27</small>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="proId" name="wholesale_pro" value="N" checked>
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="dailyId" name="daily" value="N">
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="hotId" name="hot" value="N" checked>
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td class="align-middle">
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="limitId" name="limit" value="N">
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id2" value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a title="Edit" href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a title="Delete" href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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
    <script>
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>
</body>

</html>