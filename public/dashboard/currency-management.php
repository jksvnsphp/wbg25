<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Inquiry Mail Box</title>

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
                            <div class="card rounded-0 mb-3">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Add New Currency Details
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency_name" class="font-weight-bold fs-3 form-label">Currency Name:</label>
                                                <input type="text" name="currency_name" class="form-control" id="currency_name" placeholder="Enter Currency">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency_symbol" class="font-weight-bold fs-3 form-label">Currency Symbol:</label>
                                                <input type="text" name="currency_symbol" class="form-control" id="currency_symbol" placeholder="Enter Symbol">
                                            </div>
                                        </div>
                                        <div class="m-2">
                                            <button class="btn btn-sm btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 mb-3">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Select Default Currency
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="currency_default" class="font-weight-bold fs-3 form-label">Currency Default:</label>
                                                <select name="currency_default" id="currency_default" class="form-control">
                                                    <option value="USD">Doller</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="m-2">
                                            <button class="btn btn-sm btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 ">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Show Currency Listing
                                </div>
                                <div class="card-body pb-0">
                                    <style>
                                        td {
                                            padding: 4px !important;
                                            font-size: 14px !important;
                                        }

                                        td p {
                                            font-size: 14px !important;
                                            padding: 0px !important;
                                            margin: 0px !important;
                                        }
                                    </style>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Currency Name</th>
                                                    <th>Symbol</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="align-middle">1</td>
                                                    <td class="align-middle">
                                                        Doller
                                                    </td>
                                                    <td class="align-middle">
                                                        $
                                                    </td>

                                                    <td class="align-middle">
                                                        <label title="Active/Inactive" class="switch round_switch">
                                                            <input type="checkbox" id="id2" value="1">
                                                            <div class="slider round"></div>
                                                        </label>
                                                        <a href=""  title="Edit" class="btn m-1 btn-sm btn-info"><i class="fas fa-edit    "></i></a>
                                                        <a href="" title="Delete" class="btn m-1 btn-sm btn-primary"><i class="fas fa-trash    "></i></a>

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