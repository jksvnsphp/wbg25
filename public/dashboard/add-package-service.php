<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboar Add Package Service</title>

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
                        <div class="col-12 mb-3">
                            <div class="card rounded-0">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Add Package Service
                                </div>
                                <div class="card-body pb-0">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3 mb-3">
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Service Name :</label>
                                                </div>
                                                <div class="col-9 mb-3 ">

                                                    <input name="service_name" type="text" class="form-control form-control-user" placeholder="Service Name">
                                                </div>
                                            </div>
                                            <h6 class="fs-3 mb-3 font-weight-bolder text-dark">Packages :-</h6>
                                            <div class="row ">
                                                <div class="col-3 mb-3">
                                                    
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Bronce Package:</label>
                                                </div>
                                                <div class="col-9 mb-3">
                                                    <div class="input-check d-flex align-items-center">
                                                        <label for="isBronceon" class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                                        <input checked type="radio" name="isBronce" class="mx-2" id="isBronceon" value="1">
                                                        <label for="isBronceoff" class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                                        <input  type="radio" name="isBronce" class="mx-2" id="isBronceoff" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-3 mb-3">
                                                    
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Silver Package:</label>
                                                </div>
                                                <div class="col-9 mb-3">
                                                    <div class="input-check d-flex align-items-center">
                                                        <label for="isSilveron" class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                                        <input checked type="radio" name="isSilver" class="mx-2" id="isSilveron" value="1">
                                                        <label for="isSilveroff" class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                                        <input  type="radio" name="isSilver" class="mx-2" id="isSilveroff" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-3 mb-3">
                                                    
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Gold Package:</label>
                                                </div>
                                                <div class="col-9 mb-3">
                                                    <div class="input-check d-flex align-items-center">
                                                        <label for="isGoldon" class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                                        <input checked type="radio" name="isGold" class="mx-2" id="isGoldon" value="1">
                                                        <label for="isGoldoff" class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                                        <input  type="radio" name="isGold" class="mx-2" id="isGoldoff" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-3 mb-3">
                                                    
                                                    <label for="" class="form-label fs-3 font-weight-bolder text-dark">Platinum Package:</label>
                                                </div>
                                                <div class="col-9 mb-3">
                                                    <div class="input-check d-flex align-items-center">
                                                        <label for="isPlatinumon" class="  font-weight-bolder text-dark fs-2 mb-0 pb-0">Yes</label>
                                                        <input checked type="radio" name="isPlatinum" class="mx-2" id="isPlatinumon" value="1">
                                                        <label for="isPlatinumoff" class=" font-weight-bolder fs-2 text-dark mb-0 pb-0">No</label>
                                                        <input  type="radio" name="isPlatinum" class="mx-2" id="isPlatinumoff" value="0">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="mt-3 p-2 pb-0 mb-0">
                                            <button class="btn btn-sm btn-primary">Save</button>
                                        </div>
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

</body>

</html>