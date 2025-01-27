<?php global $s_v_data, $user, $title, $widgets, $revenue, $servicesales; ?>
<?= view( 'includes/head', $s_v_data ); ?>
<body>
    <!-- Header -->
    <?= view( 'includes/header', $s_v_data ); ?>

    <!-- Aside -->
    <?= view( 'includes/aside', $s_v_data ); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="craft-container">
            <div class="row craft-page-head">
                <div class="col-md-6">
                    <h3><?=  $title ; ?></h3>
                    <p class="text-gray-500">A summary of you data at a glance.</p>
                </div>
                <div class="col-md-6 header-right">
                    <a class="btn btn-outline-light" href="<?=  url('Sales@get') ; ?>"><span class="btn-svg-icon"><?=  icon('cart-outline') ; ?></span>View Sales</a>
                </div>
            </div>

            <!-- Widget One -->
            <div class="row space-nne">
                <div class="col-md-6">
                    <div class="row space-nne">
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Total Sales</h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->totalsales) ; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Revenue Today <sup class="text-muted"><?=  currency($user->parent->currency) ; ?></sup></h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->revenuetoday, 2) ; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Sales Today <sup class="text-muted">Total Sales</sup></h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->salestoday) ; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Total Revenue <sup class="text-muted"><?=  currency($user->parent->currency) ; ?></sup></h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->totalrevenue, 2) ; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Total Profits</h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->totalprofits) ; ?></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Total Clients</h6>
                                <h1 class="fw-bolder"><?=  number_format($widgets->totalclients) ; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="craft-card overview-widget">
                                <h6 class="text-gray-500">Service Sales Comparison <sup class="text-muted"><?=  currency($user->parent->currency) ; ?></sup></h6>
                                <div id="container" style="height: 328px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget One -->
            <div class="row space-nne">
                <div class="col-md-6">
                    <div class="craft-card overview-widget bg-danger text-white border-transparent">
                        <h6>Unpaid Amount <sup><?=  currency($user->parent->currency) ; ?></sup></h6>
                        <h1 class="fw-bolder"><?=  money($widgets->unpaid, $user->parent->currency) ; ?></h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="craft-card overview-widget bg-success text-white border-transparent">
                        <h6>Pending Payouts <sup><?=  currency($user->parent->currency) ; ?></sup></h6>
                        <h1 class="fw-bolder"><?=  money($widgets->payouts, $user->parent->currency) ; ?></h1>
                    </div>
                </div>
            </div>

            <div class="row space-nne">
                <div class="col-md-12">
                    <div class="craft-card overview-widget">
                        <h4 class="mb-1">Revenue last 12 months</h4>
                        <div><canvas id="revenue" height="400px"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script type="text/javascript">
        var servicesales = [<?=  implode(",", $servicesales) ; ?>];
        var currency = "<?=  $user->parent->currency ; ?>";

        var amounts = ["<?=  implode('", "', $revenue['amount']) ; ?>"];
        var labels = ["<?=  implode('", "', $revenue['labels']) ; ?>"];
    </script>

<?= view( 'includes/footer', $s_v_data ); ?>
<?= view( 'includes/scripts', $s_v_data ); ?>
    <script src="<?=  asset('assets/libs/chartjs/Chart.bundle.min.js') ; ?>"></script>
    <script src="<?=  asset('assets/js/echarts.min.js') ; ?>"></script>
    <script src="<?=  asset('assets/js/overview.js') ; ?>"></script>

</body>

</html>
<?php return;
