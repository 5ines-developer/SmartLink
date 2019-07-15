<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title ?></title>
    <!--Import materialize.css-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!--Import Google Icon Font-->
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/style.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<body>

<?php $this->load->view('includes/header.php'); ?>
  

    <section>
        <div class="container-wrap3">
            <div class="row mb-0">
                <div class="col offset-l3 l6 m6 s12 pad40">
                    <div class="register-form loginpad">
                        <div class="register-icon center-align">
                            <h5 class="register-title">Forgot Password</h5>
                            <p class="forgot-para">Enter your mobile number to request a password reset</p>
                        </div>
                        <div>
                            <form action="<?php echo base_url('forgot-password') ?>" method="post"  class="col l12 m12 s12" id="login-form">
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Mobile No." id="mobile" type="text" name="mobile" required>
                                        <label for="mobile">Mobile No.</label>
                                    </div>
                                </div>
                                <button class="btn  left-align register-formbutton" value="submit"
                                    >Submit</button>
                            </form>
                            <div class="col l12 m12 s12">
                                <p class="login-link">Go back to<a href="<?php echo base_url('login') ?>">Login?</a></p>
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </section>

<?php $this->load->view('includes/footer.php'); ?>

    <!-- javascript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.sidenav').sidenav();
    });
    </script>
  <script>
    $(document).ready(function() {
        $("#login-form").validate({
            rules: {
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength:10
                    },
                },
            messages: {
                mobile: {
                        required: "Please enter your Mobile number",
                        number:"Please enter a valid Mobile number",
                        minlength: "Your Mobile number at least 10 digits",
                        maxlength:"Your Mobile number must be 10 digits",
                }
            }
        });
    });
    </script>

</body>

</html>