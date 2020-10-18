<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico"/>

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/css/custom.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <!-- sidebar -->
        <?php require_once $basePath . 'resources/templates/layout/parts/sidebar.php' ?>
        <!-- /sidebar -->

        <!-- header -->
        <?php require_once $basePath . 'resources/templates/layout/parts/header.php' ?>
        <!-- /header -->

        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Add company</h3>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_content">
                                <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" novalidate="">
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" data-validate-length-range="6" name="name" placeholder="ex. Your Company" required="required" value="">
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Company
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control" id="city" name="city">
                                                <option value="Choose company">choose company</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field item form-group ">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Date
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-2 col-sm-2">
                                            <input type="date" id="date" name="date">
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            short description
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                           <textarea id="short" name="short" rows="4" cols="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Long description
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea id="long" name="long" rows="4" cols="50"></textarea>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            desired situation
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea id="situation" name="situation" rows="4" cols="50"></textarea>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            priority
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control" id="prior" name="prior">
                                                <option value="priority">priority</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            email
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="email" class="form-control" data-validate-length-range="6" name="email" placeholder="test@gmail.com" required="required" value="">
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            upload file
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                                Select image to upload:
                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                                <input type="submit" value="Upload" name="submit">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 offset-md-3">
                                            <input type="hidden" name="moduleAction" value="Submit-company" />
                                            <button type="submit" value="Save-company" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php require_once $basePath . 'resources/templates/layout/parts/footer.php' ?>
        <!-- /footer content -->

        <!-- jQuery -->
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- FastClick -->
        <script src="/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="/vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="/vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="/vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="/vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="/vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="/vendors/Flot/jquery.flot.js"></script>
        <script src="/vendors/Flot/jquery.flot.pie.js"></script>
        <script src="/vendors/Flot/jquery.flot.time.js"></script>
        <script src="/vendors/Flot/jquery.flot.stack.js"></script>
        <script src="/vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="/vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="/vendors/moment/min/moment.min.js"></script>
        <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="/js/custom.js"></script>
    </div>
</body>
</html>
