<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head>
    <!-- Basic Page Needs -->
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Techno Store - My Account</title>
    <meta name="author" content="CreativeLayers">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Boostrap style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/stylesheets/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/stylesheets/style.css">
    <!-- Reponsive -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/stylesheets/responsive.css">
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/favicon/<?php echo base_url() ?>assets/favicon.png">

</head>

<body class="header_sticky">
    <div class="boxed">

        <?php  $this->load->view('includes/header');?>

        <section class="flat-account background">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-register">
                            <div class="title">
                                <h1>Reset Password</h1>
                            </div>
                            <form id="signupForm" method="post" action="<?php echo base_url('forgot-password-set') ?>">
                                
                                <input type="hidden" value="<?php echo $_GET['regid'] ?>" name="refid">
                                <div class="form-box">
                                    <label for="email">Email address <span class="error">*</span> </label>
									<input type="text" id="email" name="email" required />
									<span class="error"><?php echo form_error('email'); ?></span>
                                </div><!-- /.form-box -->
                                <div class="form-box">
                                    <label for="password">New Password <span class="error">*</span></label>
									<input type="password" id="password" name="password" required />
									<span class="error"><?php echo form_error('password'); ?></span>
                                </div><!-- /.form-box -->
                                <div class="form-box">
                                    <label for="cpassword">Confirm Password <span class="error">*</span></label>
									<input type="password" id="cpassword" name="cpassword" required />
									<span class="error"><?php echo form_error('cpassword'); ?></span>
                                </div><!-- /.form-box -->
                                <div class="form-box btn-track">
                                    <button type="submit" class="">Reset Password</button>
                                </div><!-- /.form-box -->
                            </form><!-- /#form-register -->
                        </div><!-- /.form-register -->
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-account -->

        <section class="flat-row flat-iconbox style1 background">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="<?php echo base_url() ?>assets/images/icons/car.png" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Worldwide Shipping</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="<?php echo base_url() ?>assets/images/icons/order.png" alt="">
                                </div>
                                <div class="box-title">
									<h3>Order Online Service</h3>
									<?php echo validation_errors(); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="<?php echo base_url() ?>assets/images/icons/payment.png" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Payment</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="<?php echo base_url() ?>assets/images/icons/return.png" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Return 30 Days</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-iconbox -->

        <?php  $this->load->view('includes/footer');?>

    </div><!-- /.boxed -->

    <!-- Javascript -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/tether.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/waypoints.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.circlechart.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/easing.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.zoom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/owl.carousel.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtRmXKclfDp20TvfQnpgXSDPjut14x5wk&region=GB"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/gmap3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/waves.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.countdown.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/main.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#signupForm").validate({
            rules: {
                
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },

            },
            messages: {
               
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                cpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",

            }
        });
    });
    </script>

</body>

</html>