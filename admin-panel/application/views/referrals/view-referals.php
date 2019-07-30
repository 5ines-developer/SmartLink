<?php
$this->ci =& get_instance();
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
    <link href="<?php echo base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url()?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
        rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url()?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url()?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url()?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url()?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url()?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url()?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url()?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo base_url()?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url()?>assets/favicon/manifest.json">
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
            <?php $this->load->view('includes/header.php'); ?>
            <?php $this->load->view('includes/sidebar.php'); ?>
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
                                <?php if ($this->session->flashdata('success')) { ?>
                                <div class="col-sm-12 ">
                                    <div class="alert alert-success" role="alert" id="message1">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        <p><strong>Success!
                                            </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('success') ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error')) { ?>
                                <div class="col-sm-12 ">
                                    <div class="alert alert-danger" role="alert" id="message1">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        <p><strong>Error!
                                            </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('error') ?></span>
                                        </p>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="x_title">
                                    <h2>Referral Detail</h2>
                                    <div class="banner-button">
                                        <?php

                                                if(empty($referal['is_deleted'])) {
                                                if(!empty($referal['referee_status']) && $referal['referee_status']=='1'){ ?>
                                        <button type="button" class="btn btn-dsable">Approved</button>
                                        <?php } elseif (!empty($referal['referee_status']) && $referal['referee_status']=='2') { ?>
                                        <button type="button" class="btn btn-dsable">Rejected</button>
                                        <?php } elseif (empty($referal['referee_status']) && $referal['referee_status']=='0') { ?>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#approve-model">Approve</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#reject-modal">Reject</button>
                                        <?php } } 


                                                ?>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table viedet" style="margin-bottom: 0px;">
                                        <tr>
                                            <th>Refree Name</th>
                                            <td><?php echo (!empty($referal['referee_name']))?$referal['referee_name']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?php echo (!empty($referal['refree_email']))?$referal['refree_email']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td><?php echo (!empty($referal['referee_phone']))?$referal['referee_phone']:'---'  ?>
                                            </td>
                                        </tr>
                                        <?php
                                                if (!empty($referal['referee_status']) && $referal['referee_status'] == '1') { ?>
                                        <tr>
                                            <th>Reward Points</th>
                                            <td><?php echo (!empty($referal['reward_points']))?$referal['reward_points']:'---'  ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Reward Expiry Date</th>
                                            <td><?php echo (!empty($referal['reward_expiry_date']))?$referal['reward_expiry_date']:'---'  ?>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Refered by</th>
                                            <td><?php echo $this->ci->referal_model->refered_by((!empty($referal['agent_id']))?$referal['agent_id']:'')  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td><?php echo (!empty($referal['referee_location']))?$referal['referee_location']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refree Company</th>
                                            <td><?php echo (!empty($referal['refree_company']))?$referal['refree_company']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refree Area</th>
                                            <td><?php echo (!empty($referal['refree_area']))?$referal['refree_area']:'---'  ?>
                                            </td>
                                        </tr>
                                        <?php
                                                if (!empty($referal['product']) && $referal['product'] == 'it') { ?>
                                        <tr>
                                            <th>Service</th>
                                            <td><?php echo (!empty($referal['it_type']))?$referal['it_type']:'---'   ?>
                                            </td>
                                        </tr>
                                        <?php }else if(!empty($referal['product']) && $referal['product'] == 'telecom'){ ?>
                                        <tr>
                                            <th>category</th>
                                            <td><?php echo (!empty($referal['telecom_type']))?$referal['telecom_type']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Customer Type</th>
                                            <td><?php echo (!empty($referal['customer_type']))?$referal['customer_type']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Service</th>
                                            <td><?php if($referal['product'] == 'telecom'){
                                                        echo $referal['service'];
                                                        }else if($referal['product'] == 'it'){
                                                        echo $referal['it_service'];
                                                        }else{
                                                        echo '---';
                                                        }  ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Requested On</th>
                                            <td><?php echo (!empty($referal['referee_addedon']))?$referal['referee_addedon']:'---'  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td><?php echo (!empty($referal['description']))?$referal['description']:'---'  ?>
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
            <?php $this->load->view('includes/footer.php'); ?>
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
                                    <div class="col-md-12 col-sm-12col-xs-12">
                                        <label class="control-label" for="ap_password">Password <span
                                                class="required">*</span>
                                        </label>
                                        <input type="password" id="ap_password" required="required"
                                            class="form-control col-md-7 col-xs-12" name="ap_password"> </div>
                                    <input type="hidden" name="approve" value="1">
                                    <input type="hidden" name="referalid"
                                        value="<?php echo (!empty($referal['uniq']))?$referal['uniq']:''  ?>">
                                    <input type="hidden" name="noti_to"
                                        value="<?php echo (!empty($referal['agent_id']))?$referal['agent_id']:''  ?>">
                                </div>
                                <p class="paswrd-error required"></p>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12col-xs-12">
                                        <label class="control-label" for="rewrd">Reward Point <span
                                                class="required">*</span>
                                        </label>
                                        <input type="text" id="rewrd" required="required"
                                            class="form-control col-md-7 col-xs-12" name="rewrd"
                                            value="<?php echo (!empty($reward['reward_points']))?$reward['reward_points']:''  ?>"
                                            <?php echo (!empty($reward['reward_points']))?'readonly':''  ?>> </div>
                                </div>
                               
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12col-xs-12">
                                         <?php if (empty($reward['reward_expiry_date'])) {?>
                                        <label class="control-label" for="ex_date">Expiry Date<span
                                                class="required">*</span>
                                        </label>
                                        <?php } ?>
                                        <input id="ex_date" placeholder="Eg: 90 days" class="form-control col-md-7 col-xs-12" type="<?php echo (!empty($reward['reward_expiry_date']))?'hidden':'text'  ?>" name="reward_expiry"
                                        value="<?php echo (!empty($reward['reward_expiry_date']))?$reward['reward_expiry_date']:''  ?>">
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
                            <p>Please enter the password and reason to reject the request</p>
                            <form action="<?php echo base_url() ?>referals/reject" method="post" id="referal-reject"
                                class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12col-xs-12">
                                        <label class="control-label" for="rj_password">Password <span
                                                class="required">*</span>
                                        </label>
                                        <input type="password" id="rj_password" required="required"
                                            class="form-control col-md-7 col-xs-12" name="rj_password"> </div>
                                    <input type="hidden" name="reject" value="2">
                                    <input type="hidden" name="referalid"
                                        value="<?php echo (!empty($referal['uniq']))?$referal['uniq']:''  ?>">
                                    <input type="hidden" name="noti_to"
                                        value="<?php echo (!empty($referal['agent_id']))?$referal['agent_id']:''  ?>">
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="reject_reason">Reason <span
                                                class="required">*</span>
                                        </label>
                                        <textarea id="reject_reason" required="required"
                                            class="form-control col-md-7 col-xs-12" name="reject_reason"> </textarea>
                                    </div>
                                </div>
                                <p class="paswrd-error-reject required"></p>
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
    <script src="<?php echo base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url()?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url()?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url()?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js">
    </script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js">
    </script>
    <script src="<?php echo base_url()?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()?>assets/build/js/custom.min.js"></script>
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
                url: "<?php echo base_url();?>approve-referals",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    console.log(data);
                    if (data == 'wrong password') {
                        $(".paswrd-error").append("<span>Wrong password</span>");
                    } else if (data == '1') {
                        location.href = "<?php echo base_url('manage-referals')?>"
                    } else if (data == '') {
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
                url: "<?php echo base_url();?>reject-referals",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    if (data == 'wrong password') {
                        $(".paswrd-error-reject").append("<span>Wrong password</span>");
                    } else if (data == '1') {
                        location.href = "<?php echo base_url('manage-referals')?>"
                    } else if (data == '') {
                        $(".paswrd-error-reject").append(
                            "<span>Unable to process your request please try again!</span>"
                        );
                    }
                }
            });
        });
    });
    </script>
</body>

</html>