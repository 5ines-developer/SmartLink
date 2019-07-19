<?php
$this->ci = &get_instance();
$this->ci->load->model('referal_model');
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
    <!-- Datatables -->
    <link href="<?php echo base_url() ?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
        rel="stylesheet">
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
    <style>
    p {
        font-size: 12px;
    }

    .banner-button {
        float: right;
    }
    </style>
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
                            <h3></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <?php if ($this->session->flashdata('success')) {?>
                                <div class="col-sm-12 ">
                                    <div class="alert alert-success" role="alert" id="message1">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        <p><strong>Success!
                                            </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('success') ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php }?>
                                <?php if ($this->session->flashdata('error')) {?>
                                <div class="col-sm-12 ">
                                    <div class="alert alert-danger" role="alert" id="message1">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        <p><strong>Error!
                                            </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('error') ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="x_title">
                                    <h2>Reward Points Claim Detail</h2>
                                    <div class="banner-button">
                                        <?php if (!empty($claim['claim_status']) && $claim['claim_status'] == '1') {?>
                                        <button type="button" class="btn btn-dsable">Approved</button>
                                        <?php } elseif (!empty($claim['claim_status']) && $claim['claim_status'] == '2') {?>
                                        <button type="button" class="btn btn-dsable">Rejected</button>
                                        <?php } elseif (empty($claim['claim_status']) && $claim['claim_status'] == '0') {?>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#approve-model">Approve</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#reject-modal">Reject</button>
                                        <?php }?>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table viedet" style="margin-bottom: 0px;">
                                        <tr>
                                            <th>Claimed By</th>
                                            <td><?php echo (!empty($claim['agent_name'])) ? $claim['agent_name'] : '' ?>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Total Reward Points</th>
                                            <td><?php if (!empty($reward)) { echo $reward; }  ?>
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <th>Claimed Reward Points</th>
                                            <td><?php 
                                            if (!empty($ap_claim)) { 
                                                echo $ap_claim; 
                                            } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Unclaimed Reward Points</th>
                                            <td><?php if (!empty($reward)) { $unclaimed = $reward - $ap_claim; } echo $unclaimed; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Requested Points</th>
                                            <td><?php echo (!empty($claim['claimed_points'])) ? $claim['claimed_points'] : '' ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <?php $this->load->view('includes/footer.php');?>
            <!-- /footer content -->
            <!-- Approve refer a friend modal -->
            <div id="approve-model" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Approve the request</h4>
                        </div>
                        <div class="modal-body">
                            <p>Please enter the password to approve the request</p>
                            <form action="<?php echo base_url() ?>approve-referal" method="post" id="referal-approve"
                                class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="ap_password">Password <span
                                                class="required">*</span>
                                        </label>
                                        <input type="password" id="ap_password" required="required"
                                            class="form-control col-md-7 col-xs-12" name="ap_password"> </div>
                                    <input type="hidden" name="approve" value="1">
                                    <input type="hidden" name="claimid" value="<?php echo (!empty($claim['uniq'])) ? $claim['uniq'] : '' ?>">
                                    <input type="hidden" name="noti_to"
                                        value="<?php echo (!empty($claim['agent_id'])) ? $claim['agent_id'] : '' ?>">
                                </div>
                                <p class="paswrd-error required"></p>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="smart_code">Smart Code<span
                                                class="required">*</span>
                                        </label>
                                        <input type="text" id="smart_code" required="required"
                                            class="form-control col-md-7 col-xs-12" name="smart_code"> </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Reject refer a friend modal -->
            <div id="reject-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Reject the request</h4>
                        </div>
                        <div class="modal-body">
                            <p>Please enter the password  to reject the request</p>
                            <form action="<?php echo base_url() ?>reject-claim" method="post" id="referal-reject"
                                class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12col-xs-12">
                                        <label class="control-label" for="rj_password">Password <span
                                                class="required">*</span>
                                        </label>
                                        <input type="password" id="rj_password" required="required"
                                            class="form-control col-md-7 col-xs-12" name="rj_password"> </div>
                                    <input type="hidden" name="reject" value="2">
                                    <input type="hidden" name="claimid"
                                        value="<?php echo (!empty($claim['uniq'])) ? $claim['uniq'] : '' ?>">
                                    <input type="hidden" name="noti_to"
                                        value="<?php echo (!empty($claim['agent_id'])) ? $claim['agent_id'] : '' ?>">
                                </div>
                                <p class="paswrd-error-reject required"></p>

                                <div class="form-group">
                                    <label class="control-label col-md-6 col-sm-6 col-xs-12"
                                        style="text-align: left;">Reward Point Return</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="flat" checked name="return_reward" value="1"> Return 
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="flat" name="return_reward" value="2"> Cancel 
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <div class="ln_solid"></div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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
    <script>
    $(document).ready(function() {
        $('#message1').toggleClass('in');
        setTimeout(function() {
            $('.alert').fadeOut(3000)
        }, 4000);
    });
    </script>


    <script>
    $(document).ready(function() {
        $("#referal-approve").on('submit', function(event) {
            event.preventDefault();
            var DataString = $("#referal-approve").serialize();
            $.ajax({
                url: "<?php echo base_url(); ?>approve-claim",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    console.log(data);
                    if (data == 'wrong password') {
                        $(".paswrd-error>span").remove();
                        $(".paswrd-error").append("<span>Wrong password</span>");
                    } else if (data == '1') {
                        location.href = "<?php echo base_url('manage-reward-claims') ?>"
                    } else if (data == '') {
                        $(".paswrd-error>span").remove();
                        $(".paswrd-error").append(
                            "<span>Unable to process your request please try again!</span>"
                        );
                    }
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $("#referal-reject").on('submit', function(event) {
            event.preventDefault();
            var DataString = $("#referal-reject").serialize();
            $.ajax({
                url: "<?php echo base_url(); ?>reject-claim",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    if (data == 'wrong password') {
                        $(".paswrd-error>span").remove();
                        $(".paswrd-error-reject").append("<span>Wrong password</span>");
                    } else if (data == '1') {
                        location.href = "<?php echo base_url('manage-reward-claims') ?>"
                    } else if (data == '') {
                        $(".paswrd-error>span").remove();
                        $(".paswrd-error-reject").append("<span>Unable to process your request please try again!</span>"
                        );
                    }
                }
            });
        });
    });
    </script>



</body>

</html>