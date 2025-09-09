<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Add New Banner</title>

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
                        <div class="col-12">
                            <div class="card rounded-0">
                                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                    Banner on (Abstract & Contemporary Paintings) Page
                                </div>
                                <div class="card-body pb-0">
                                    <div class="form-group row">
                                        <div class="col-4 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Upload Banner Image: <span class="text-danger">*</span></label>
                                            
                                        </div>
                                        <div class="col-8 mb-3">
                                            <input name="image" type="file" accept="image/*">
                                            <small class="fs-1 font-weight-bolder d-block">	(only jpeg/jpg/png/swf  file are allowed)</small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Position: <span class="text-danger">*</span></label>
                                            
                                        </div>
                                        <div class="col-8 mb-3">
                                            <select name="position" id="position" class="form-control">
                                               <option value="">Please select</option>
                                               <option value="1">Top</option>
                                               <option value="2">Bottom</option>
                                               <option value="3">Left One</option>
                                               <option value="4">Left Two</option>
                                               <option value="5">Left Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Start Date: <span class="text-danger">*</span></label>
                                            
                                        </div>
                                        <div class="col-8 mb-3">
                                            <input type="date" name="start_date" id="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">End Date: <span class="text-danger">*</span></label>
                                            
                                        </div>
                                        <div class="col-8 mb-3">
                                            <input type="date" name="end_date" id="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4 mb-3 ">
                                            <label for="" class="form-label fs-3 font-weight-bolder text-dark">Ad URL: <span class="text-danger">*</span></label>
                                            
                                        </div>
                                        <div class="col-8 mb-3">
                                            <input type="url" name="ad_url" id="ad_url" class="form-control">
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

</body>

</html>