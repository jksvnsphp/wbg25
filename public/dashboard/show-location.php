<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>WBG24 Dashboard Show Locations</title>

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
                                    Enter country
                                    <button type="button" onclick="toggleAddCategory()" class="btn btn-secondary">Enter New Country</button>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="card my-4 rounded-0 d-none" id="category_card">
                                        <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                            Enter New Country
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <input type="text" name="country_name" id="name" class="form-control" placeholder="Enter the country name">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="text" name="search_keyword" class="form-control" id="search_keyword" placeholder="Enter the search keyword.">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="file" name="image" id="image">
                                                    <small class="d-block">Flag Image</small>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="file" name="image2" id="image2">
                                                    <small class="d-block">Country Image</small>
                                                </div>

                                                <div class="mb-3 px-3">
                                                    <button class="btn btn-sm btn-primary">Add Country</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

                                        td a {
                                            font-weight: 700 !important;
                                        }
                                    </style>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Country</th>
                                                    <th>Flag</th>
                                                    <th>Banner</th>
                                                    <th>State</th>
                                                    <th>City</th>
                                                    <th>Action</th>
                                                    <th>Available Home Search</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-middle">1</td>
                                                    <td class="align-middle">
                                                        <a href="#">Afghanistan</a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <img src="./img/country/1.jpg" class="h-100" alt="">
                                                    </td>
                                                    <td class="align-middle">
                                                        <img src="./img/country/banner/default.jpg" style="height: 3rem;" alt="">
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="./show-state.php">2</a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="./show-city.php">2</a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="" class="btn btn-sm btn-info"><i class="fas fa-edit    "></i></a>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-trash    "></i></a>
                                                    </td>
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