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
    <!-- Animate.css -->
    <link href="<?php echo base_url() ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

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
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url()?>assets/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>assets/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo base_url()?>assets/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">

        <?php if ($this->session->flashdata('success')) { ?>
                        <div class="col-sm-12 ">
                    <div class="alert alert-success" role="alert" id="message1">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                        <p><strong>Success! </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('success') ?></span></p>
                    </div>
                    </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="col-sm-12 ">
                    <div class="alert alert-danger" role="alert" id="message1">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                        <p><strong>Error! </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('error') ?></span></p>
                    </div>
                    </div>
                    <?php } ?>

                    
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo base_url() ?>login/check" method="post">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="email"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#signup" class="to_register"> Forgot password? </a>
                </p>

                <div class="clearfix"></div>
              

                <div>
                  <h1 style="margin: 10px 0 0px;"><img class="sim-logo" src="<?php echo base_url() ?>assets/images/logo.png" alt="logo"></h1>
                  <p>©<?php echo date("Y"); ?> Smart Link! All Rights Reserved. Developed by - <a href="http://www.5ines.com/" style="color: saddlebrown" target="_blank">5ine</a> </p> 
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="<?php echo base_url() ?>forgot/email-check" method="post" >
              <h1>Forgot Password</h1>
              
              <div>
                <input type="email" class="form-control" placeholder="Enter you e-mail" required="" name="femail" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <div>
                  <h1 style="margin: 10px 0 0px;"><img class="sim-logo" src="<?php echo base_url() ?>assets/images/logo.png" alt="logo"></h1>
                  <p>©<?php echo date("Y"); ?> Smart Link! All Rights Reserved .  Developed by - <a href="http://www.5ines.com/" style="color: saddlebrown" target="_blank">5ine</a> </p> 
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
    <script src="<?php echo base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>assets/vendors/fastclick/lib/fastclick.js"></script>
<script>
    $(document).ready(function () {
        $('#message1').toggleClass('in');
        setTimeout(function(){$('.alert').fadeOut(3000)},4000);
      });
</script>
