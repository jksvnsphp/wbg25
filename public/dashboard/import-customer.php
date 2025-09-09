<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Import Customer</title>

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
                                    Browse Only .csv extension File and Import their Records.
                                </div>
                                <style>
                                    .csv_format sup{
                                       font-size: 13px !important;
                                    }
                                </style>
                                <div class="card-body pb-0">
                                    <table class="table table-bordered">
                                        <tr class=" bg-light ">
                                            <td>
                                                <p class="font-weight-normal csv_format text-center   fs-2  ">
                                                    <span>(1) PERSON-NAME <sup class="text-danger">*</sup> </span>
                                                    <span>(2) Email <sup class="text-danger">*</sup> </span>
                                                    <span>(3) Company Name <sup class="text-danger">*</sup> </span>
                                                    <span>(4) Address</span>
                                                    <span>(5) Country <sup class="text-danger">*</sup> </span>
                                                    <span>(6) State <sup class="text-danger">*</sup> </span>
                                                    <span>(7) City <sup class="text-danger">*</sup> </span>
                                                    <span>(8) Category <sup class="text-danger">*</sup> </span>
                                                    <span>(9) Sub Category <sup class="text-danger">*</sup> </span>
                                                    <span>(10) Next Sub Category <sup class="text-danger">*</sup> </span>
                                                    <span>(11) Pin Code</span>
                                                    <span>(12) Mobile No <sup class="text-danger">*</sup> </span>
                                                    <span>(13) Package Type (A_F = Free/A_P = Silver/A_G = Gold/A_S = Platinum)<sup class="text-danger">*</sup> </span>
                                                        <span>(14) Description</span>
                                                    <span>(15) profile_complite <sup class="text-danger">*</sup> </span>
                                                </p>
                                                <p class="pb-0 mb-0"><strong class="text-danger">All * sign is mandatory. Maximum 1000 enters at time</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            You can download example file from here. <a href=""><i class="fa fa-download" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            **Please donot remove heading row from file
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group d-flex flex-column mb-0">
                                                    <label for="file" class="font-weight-bold fs-2">Import File:</label>
                                                    <input type="file" name="csv" id="file" accept=".csv" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary btn-sm">Import Data</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </table>
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