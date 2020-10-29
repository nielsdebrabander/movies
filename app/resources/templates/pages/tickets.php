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

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Add ticket</h3>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_content">
                                <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" novalidate="">
                                    <div class="field item form-group <?php if (!$titleOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Title
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" data-validate-length-range="6" name="title" placeholder="Title" required="required" value="<?php echo htmlentities($titleValue); ?>">
                                        </div>
                                        <?php if (!$titleOk) { echo '<div class="alert">' . $msgTitle . '</div>'; } ?>
                                    </div>
                                    <div class="field item form-group <?php if (!$companyOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Company
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control" data-validate-length-range="6" name="company" required="required">
                                                <option value="Select company" <?php if ($companyValue == 'Select company') { echo ' selected="selected"'; } ?>>Select company</option>
                                                <?php foreach ($companyObj as $company) { ?>
                                                    <option value="<?php echo urlencode($company->getName()); ?>" <?php if (urldecode($companyValue) == $company->getName()) { echo ' selected="selected"'; } ?>>
                                                        <?php echo htmlentities($company->getName()); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if (!$companyOk) { echo '<div class="alert">' . $msgCompany . '</div>'; } ?>
                                    </div>
                                    <div class="field item form-group <?php if (!$dateOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Date
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="date" class="form-control" data-validate-length-range="6" name="date" placeholder="Date" required="required" value="<?php if ($dateValue !== '') { echo htmlentities($dateValue); } else { echo htmlentities($today); } ?>">
                                        </div>
                                        <?php if (!$dateOk) { echo '<div class="alert">' . $msgDate . '</div>'; } ?>
                                    </div>

                                    <div class="field item form-group <?php if (!$shortDescOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Short description
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea rows="5" name="shortDesc">
                                                <?php echo htmlentities($shortDescValue); ?>
                                            </textarea>
                                        </div>
                                        <?php if (!$shortDescOk) { echo '<div class="alert">' . $msgShortDesc . '</div>'; } ?>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Long description
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea rows="5" name="longDesc">
                                                <?php echo htmlentities($longDescValue); ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Preferred situation
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea rows="5" name="preferred_situation">
                                                <?php echo htmlentities($preferredSituationValue); ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="field item form-group <?php if (!$priorityOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Priority
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control" data-validate-length-range="6" name="priority" required="required">
                                                <option value="select priority" <?php if ($priorityValue == 'select priority') { echo ' selected="selected"'; } ?>>Select prioirity</option>
                                                <option value="low" <?php if ($priorityValue == 'laag') { echo ' selected="selected"'; } ?>>Low</option>
                                                <option value="middle" <?php if ($priorityValue == 'middel') { echo ' selected="selected"'; } ?>>Middle</option>
                                                <option value="high" <?php if ($priorityValue == 'hoog') { echo ' selected="selected"'; } ?>>High</option>
                                            </select>
                                        </div>
                                        <?php if (!$priorityOk) { echo '<div class="alert">' . $msgPriority . '</div>'; } ?>
                                    </div>
                                    <div class="field item form-group <?php if (!$mailOk) { echo 'bad'; } ?>">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            Manager of client
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" data-validate-length-range="6" name="mail" placeholder="john.doe@example.com" required="required" value="<?php echo htmlentities($mailValue); ?>">
                                        </div>
                                        <?php if (!$mailOk) { echo '<div class="alert">' . $msgMail . '</div>'; } ?>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">
                                            File upload
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" name="file">
                                        </div>
                                        <?php if (!$fileOk) { echo '<div class="alert">' . $msgFile . '</div>'; } ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 offset-md-3">
                                            <input type="hidden" name="moduleAction" value="Submit-ticket" />
                                            <button type="submit" value="Save-ticket" class="btn btn-primary">Save</button>
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
