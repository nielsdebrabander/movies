<!DOCTYPE html>
<html lang="en">
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
        <?php require_once $basePath . 'resources/templates/layout/parts/sidebar.php'?>
        <!-- /sidebar -->
        <!-- header -->
        <?php require_once  $basePath . 'resources/templates/layout/parts/header.php'?>
        <!-- /header -->
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Companies &
                            <contact>contacts</contact>
                        </h3>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                            <form method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="term" placeholder="Search for..."
                                        <?php if (array_key_exists('term', $_GET)) { ?>
                                            <?php $searchTerm = $_GET['term']; ?>
                                            value="<?php echo $searchTerm; ?>"
                                        <?php } ?>>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <div class="row" style="display: block;">
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Companies</h2>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="x_content">
                                <div class="row mb-3">
                                    <div class="col-sm-9">
                                        <p>This is an overview of all our companies</p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Name</th>
                                            <th class="column-title">Address</th>
                                            <th class="column-title">Zip</th>
                                            <th class="column-title">City</th>
                                            <th class="column-title">VAT</th>
                                            <th class="column-title">Activity</th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span></th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions (
                                                    <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                                </a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (count($companies) && count($companyObject)) { ?>
                                            <?php foreach ($companyObject as $counter => $company) { ?>
                                                <tr class="<?php echo $counter % 2 == 0 ? 'even' : 'odd'; ?>> pointer">
                                                    <td class="a-center ">
                                                        <input type="checkbox" class="flat" name="table_records">
                                                    </td>
                                                    <td class=" "><?php echo htmlentities($company->getName())?></td>
                                                    <td class=" "><?php echo htmlentities($company->formatAddress())?></td>
                                                    <td class=" "><?php echo htmlentities($company->getZip())?></td>
                                                    <td class=" "><?php echo htmlentities($company->getCity())?></td>
                                                    <td class=" "><?php echo htmlentities($company->getActivity())?></td>
                                                    <td class=" "><?php echo htmlentities($company->getVat())?></td>
                                                    <td class=" last"><a href="./company.php?search=<?php echo htmlentities($company->getName())?>">View</a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php echo 'Sorry opgegeven zoekterm heeft geen resultaten teruggevonden "' . $_GET['term'] . '"'; ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: block;">
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Contacts</h2>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="x_content">
                                <div class="row mb-3">
                                    <div class="col-sm-9">
                                        <p>This is an overview of all our contacts</p>
                                    </div>
                                </div>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr class="headings">
                            <th>
                                <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Client</th>
                            <th class="column-title">Email</th>
                            <th class="column-title">Phone</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions (
                                    <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($contacts)) {?>
                            <?php foreach ($contacts as $counter => $contact) {?>
                                <tr class="<?php echo $counter % 2 == 0 ? 'even' : 'odd'; ?>> pointer">
                                    <td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>
                                    <td class=" "><?php echo htmlentities($contact['name'])?></td>
                                    <td class=" "><?php echo htmlentities($contact['client'])?></td>
                                    <td class=" "><?php echo htmlentities($contact['email'])?></td>
                                    <td class=" "><?php echo htmlentities($contact['phone'])?></td>
                                    <td class=" last"><a href="./contact.php?<?php echo "name=" . $contact['name'] . "&client=" . $contact['client'] . "&email=" . $contact['email'] . "&phone=" . $contact['phone']?>">View</a></td>


                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <?php echo 'Sorry opgegeven zoekterm heeft geen resultaten teruggevonden "' . $_GET['term'] . '"'; ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /page content -->
        <!-- footer content -->
        <?php require_once $basePath . 'resources/templates/layout/parts/footer.php'?>
        <!-- /footer content -->
    </div>
</div>

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

</body>
</html>
