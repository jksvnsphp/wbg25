<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard All Payments</title>

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
                                    All Payments
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row my-3">
                                        <div class="col-sm-4">
                                            <select name="payment" id="payment" class="form-control">
                                                <option value="">Sort By Payment Status</option>
                                                <option value="1">Complete</option>
                                                <option value="2">Pending</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="package" id="package" class="form-control">
                                                <option value="">Sort By Package Type</option>
                                                <option value="1">Bronce</option>
                                                <option value="2">Silver</option>
                                                <option value="3">Gold</option>
                                                <option value="4">Platinum</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Package Type</th>
                                                    <th>Payment Status</th>
                                                    <th>Transaction Date</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Id</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="align-middle p-2">1</td>
                                                    <td class="align-middle p-2">Rihana Khan</td>
                                                    <td class="align-middle p-2">rihanakhan@gmail.com</td>
                                                    <td class="align-middle p-2">$49,00</td>
                                                    <td class="align-middle p-2">Silver</td>
                                                    <td class="align-middle p-2">Payment Completed</td>
                                                    <td class="align-middle p-2">23 Jan 2024</td>
                                                    <td class="align-middle p-2">PayPal</td>
                                                    <td class="align-middle p-2">paypal_764746</td>
                                                    <td class="align-middle p-2">
                                                        <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id2" value="1">
                                                            <div class="slider round"></div>
                                                        </label>
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

</body>

</html>