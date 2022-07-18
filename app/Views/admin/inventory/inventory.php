<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Data</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="public/assets/img/favicon.png" rel="icon">
    <link href="public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="public/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="public/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="public/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="public/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="public/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="public/assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <?php echo $this->include('admin/templates/header'); ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php echo $this->include('admin/templates/sidebar'); ?>
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                    <?php  echo "<pre>"; print_r($name[0]['name']); echo "</pre>" ?>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="table table-responsive" style="overflow-x:auto;" >
                            <h5 class="card-title">Datatables</h5>
                            <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p> -->
                            <?php
                            // Display the products as pagination with maximum products in a page.
                            $limit = 5;
                            $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
                            $paginationStart = ($page - 1) * $limit;

                            $db = mysqli_connect('localhost', 'rootuser', 'root', 'fithealth_db');
                            $query = "SELECT COUNT(*) AS id FROM product";
                            $result = mysqli_query($db, $query);
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            $total = $row['id'];
                            $pages = ceil($total / $limit);

                            $query1 = "SELECT * FROM product LIMIT $paginationStart,$limit";
                            $result1 = mysqli_query($db, $query1);


                            ?>
                            <!-- Table with stripped rows -->
                            <table class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Main Category</th>
                                        <th class="text-left">Sub Category</th>
                                        <th class="text-left">Price</th>
                                        <th class="text-left">Quantity</th>
                                        <th class="text-left">Detail</th>
                                        <th class="text-left">Image</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) { ?>
                                    <tr>
                                        <form method="post" id="the-form" enctype="multipart/form-data">
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo ($row1['id']);  ?>" readonly>
                                            <td><input type="text" class="form-control" name="name" value="<?php echo ($row1['name']); ?>" readonly></td>
                                            <td><input type="text" class="form-control" name="category" value="<?php echo ($row1['category']); ?>"></td>
                                            <input type="hidden" class="form-control" name="sub_category" value="<?php echo ($row1['sub_category']); ?>" readonly>
                                            
                                            <td><input type="number" class="form-control" name="price" value="<?php echo ($row1['price']); ?>"></td>
                                            <td><input type="number" class="form-control" name="quantity" value="<?php echo ($row1['quantity']); ?>"></td>
                                            <td><input type="text" class="form-control" name="detail" value="<?php echo ($row1['detail']); ?>"></td>
                                            
                                            <!-- <td><button type="submit" formaction="products-update.php" class="form-control">Update</button></td> -->
                                            <!-- <td><button type="submit" formaction="" class="form-control">Delete</button></td> -->
                                        </form>


                                    </tr>
                                <?php
                                } ?>

                            </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php echo $this->include('admin/templates/footer'); ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="public/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/vendor/chart.js/chart.min.js"></script>
    <script src="public/assets/vendor/echarts/echarts.min.js"></script>
    <script src="public/assets/vendor/quill/quill.min.js"></script>
    <script src="public/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="public/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="public/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="public/assets/js/main.js"></script>

</body>

</html>