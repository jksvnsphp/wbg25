<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboar All Customers</title>

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
                                    Customers
                                </div>
                                <div class="card-body pb-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Comapny Name</th>
                                                    <th>Email</th>
                                                    <th>Country Flag</th>
                                                    <th>City</th>
                                                    <th>Site URL</th>
                                                    <th>Join Date</th>
                                                    <th>Active/Inactive</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>J K B Pharma</td>
                                                    <td>anujkumar@gmail.com</td>
                                                    <td>
                                                        <img src="./img/country/1.jpg" style="height: 30px;" alt="">
                                                    </td>
                                                    <td>
                                                    Georgetown
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                    <td>
                                                        12 Jan 2023
                                                    </td>
                                                    <td>
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="id1" checked value="1" >
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a title="View" href="" class="btn m-1 btn-sm btn-secondary"> <i class="fas fa-eye    "></i> </a>
                                                        <a title="Edit" href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a title="Delete" href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Samsung Pvt Ltd</td>
                                                    <td>johndoe@gmail.com</td>
                                                    <td>
                                                        <img src="./img/country/1.jpg" style="height: 30px;" alt="">
                                                    </td>
                                                    <td>
                                                    Khurja
                                                    </td>
                                                    <td>
                                                    amul.com
                                                    </td>
                                                    <td>
                                                        02 March 2023
                                                    </td>
                                                    <td>
                                                        <label class="switch round_switch">
                                                            <input type="checkbox" id="id2" value="1" >
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a title="View" href="" class="btn m-1 btn-sm btn-secondary"> <i class="fas fa-eye    "></i> </a>
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