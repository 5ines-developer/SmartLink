<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Link</title>
    <!--Import materialize.css-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!--Import Google Icon Font-->
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/style.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<body class="white">

<?php $this->load->view('includes/header.php'); ?>
  

    <section>
        <div class="container-wrap3">
            <div class="row mb-0">
                <div class="col offset-l3 l6 offset-m3 m6 s12 pad40">
                    <div class="register-form loginpad">
                        <div class="register-icon center-align">
                        <i class="material-icons dp48">account_circle</i>
                            <h5 class="register-title">Login</h5>
                        </div>
                        <div>
                            <form action="<?php echo base_url('login') ?>" method="post" class="col l12 m12 s12" id="login-form">
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Nick Name or Mobile No." id="username" name="username" type="text" required>
                                        <label for="username">Nick Name or Mobile No.<span class="error">*</span> </label>
                                        <span class="error"><?php echo form_error('username'); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Password" id="password" name="password" type="password" required>
                                        <label for="password">Password <span class="error">*</span> </label>
                                        <span class="error"><?php echo form_error('password'); ?></span>
                                    </div>
                                </div>
                                <div class="form-valdation-error">

                                    <?php echo ($this->session->flashdata('error'))? '<span class="error">'.$this->session->flashdata('error').'</span>' : '' ?>
                                    
                                </div>
                                
                                <button class="btn  left-align register-formbutton" value="submit"
                                    name="submit">Submit</button>
                                    <a class="forgot-link" href="<?php echo base_url('forgot-password') ?>">Forgot Password?</a>
                            </form>
                            <div class="col l12 m12 s12">
                                <p class="login-link">Don't have an Account?<a href="<?php echo base_url('register') ?>">Sign Up</a></p>
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
                password: {
                    required: true,
                    minlength: 5
                },
                
                username: {
                    required: true,
                },

            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                username: "Please enter a valid Nick Name",
            }
        });
    });
    </script>
</body>

</html>