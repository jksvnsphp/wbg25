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
                                    Tender Categories
                                    <div class="d-flex">
                                        <a href="./tender-type.php" class="btn mx-3 btn-sm btn-secondary">Tender Type</a>
                                        <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Category</button>

                                    </div>
                                </div>

                                <div class="card-body pb-0">
                                    <div class="card my-4 rounded-0 d-none" id="category_card">
                                        <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                            Add Category
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter the category name">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <input type="file" name="image" id="image">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter the Title">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" placeholder="Enter the meta keyword(s).">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Enter the meta desciption"></textarea>
                                                </div>
                                                <div class="mb-3 px-3">
                                                    <button class="btn btn-sm btn-primary">Add Category</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        td {
                                            padding: 0px 7px !important;
                                        }
                                    </style>
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category</th>

                                                    <th>Category Image</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="align-middle">1</td>
                                                    <td class="align-middle">
                                                        <a href="">Industrial Supplies</a>
                                                    </td>

                                                    <td class="align-middle ">
                                                        <div style="height: 4rem; width:4rem;">
                                                            <img src="./img/tender-category/1.jpg" class="h-100 w-100" alt="">
                                                        </div>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle">2</td>
                                                    <td class="align-middle">
                                                        <a href="">Health & Medical</a>
                                                    </td>

                                                    <td class="align-middle ">
                                                        <div style="height: 4rem; width:4rem;">
                                                            <img src="./img/tender-category/2.jpg" class="h-100 w-100" alt="">
                                                        </div>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle">2</td>
                                                    <td class="align-middle">
                                                        <a href="">Fashion</a>
                                                    </td>

                                                    <td class="align-middle ">
                                                        <div style="height: 4rem; width:4rem;">
                                                            <img src="./img/tender-category/3.jpg" class="h-100 w-100" alt="">
                                                        </div>
                                                    </td>

                                                    <td class="align-middle">
                                                        <a href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                                        <a href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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