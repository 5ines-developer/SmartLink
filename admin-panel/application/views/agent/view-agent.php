<?php
$this->ci =& get_instance();
$this->ci->load->model('agent_model');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url() ?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url() ?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
        rel="stylesheet">
    <!-- PNotify -->
    <link href="<?php echo base_url() ?>assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url() ?>assets/build/css/custom.min.css" rel="stylesheet">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url() ?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url() ?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url() ?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url() ?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url() ?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url() ?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url() ?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo base_url() ?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url() ?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url() ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">


            <?php $this->load->view('includes/header.php');?>

            <?php $this->load->view('includes/sidebar.php');?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Agent</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-pills bg-whte" role="tablist" style="margin-top: 11px;">
                            <li role="presentation"><a href="#detsail"
                                    class="js-scroll-trigger nav-link active">Profile</a>
                            </li>
                            <li role="presentation"><a href="#bookedcustomer"
                                    class="js-scroll-trigger nav-link">Orders</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">

                            <div class="x_title" id="detsail">
                                <h2>Profile Detail</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="x_content">
                                    <table class="table viedet" style="margin-bottom: 0px;">
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo (!empty($agent['agent_name'])) ? $agent['agent_name'] : '---' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td><?php echo (!empty($agent['agent_phone'])) ? $agent['agent_phone'] : '---' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Employee Reference Id</th>
                                            <td><?php echo (!empty($agent['employee_reference_id'])) ? $agent['employee_reference_id'] : '---' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registered On</th>
                                            <td><?php echo (!empty($agent['agent_registered_on'])) ? $agent['agent_registered_on'] : '---' ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title" id="bookedcustomer">
                                <h2>Referrals</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Agent</th>
                                                <th>Refree Name</th>
                                                <th>Phone</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Status</th>
                                                <th>Location</th>
                                                <th>Requested On</th>
                                            </tr>
                                        </thead>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 0;if (!empty($referal)) {
                                        foreach ($referal as $key => $value) {$cont = $cont + 1;?>
                                        <tr>
                                            <td><?php echo (!empty($referal)) ? $cont : '' ?></td>
                                            <td><?php echo $this->ci->referal_model->refered_by((!empty($value->agent_id)) ? $value->agent_id : '---') ?>
                                            </td>
                                            <td><a href="<?php echo base_url('view-referals/').$value->uniq ?>" ><?php echo (!empty($value->referee_name)) ? $value->referee_name : '---' ?></a>
                                            </td>
                                            <td><?php echo (!empty($value->referee_phone)) ? $value->referee_phone : '---' ?>
                                            </td>
                                            <td><?php echo (!empty($value->product)) ? $value->product : '---' ?></td>
                                            <td><a href="<?php echo base_url('edit-product/').$value->sub_product ?>" ><?php echo (!empty($value->sub_product)) ? $this->ci->agent_model->service($value->sub_product) : '---' ?></a>
                                            </td>
                                            <td class="<?php echo 'refre_status' . $value->referee_status ?>"><?php if ($value->referee_status == '1') {
                                            echo 'Approved';
                                        } else if ($value->referee_status == '2') {
                                            echo 'Rejected';
                                        } else {
                                            echo 'Pending';
                                        }?></td>
                                            <td><?php echo (!empty($value->referee_location)) ? $value->referee_location : '---' ?>
                                            </td>
                                            <td><?php echo (!empty($value->referee_addedon)) ? date("d-M-y h:i:s", strtotime($value->referee_addedon)) : '---'; ?>
                                            </td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="clearfix"></div>
            </div>

            <!-- /page content -->

            <!-- footer content -->
            <?php $this->load->view('includes/footer');?>
            <!-- /footer content -->
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url() ?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url() ?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js">
    </script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js">
    </script>
    <script src="<?php echo base_url() ?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url() ?>assets/build/js/custom.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/jquery.easing.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#message1').toggleClass('in');
        setTimeout(function() {
            $('.alert').fadeOut(3000)
        }, 4000);
    });
    </script>

    <script>
    (function($) {
        "use strict";
        $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
            $('a.js-scroll-trigger').removeClass('active')
            $(this).addClass('active');
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location
                .hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: (target.offset().top - 72)
                    }, 1000, "easeInOutExpo");
                    return false;
                }
            }
        });
    })(jQuery);
    </script>

</body>

</html>