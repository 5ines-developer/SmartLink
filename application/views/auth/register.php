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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/index.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<body class="white">
    <?php $this->load->view('includes/header.php'); ?>

    <section>
        <div class="container-wrap3">
            <div class="row mb-0">
                <div class="col l6 m12 s12 pad40">
                    <div class="register-form">
                        <div class="register-icon center-align">
                            <img src="<?php echo base_url()?>assets/images/register.png" alt="register">
                            <h5 class="register-title">Register Now</h5>
                        </div>
                        <div>
                            <form action="<?php echo base_url('register') ?>" method="post" id="signup-form"
                                class="col l12 m12 s12">
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Nick Name" id="username" name="username" required
                                            type="text">
                                        <label for="username">Nick Name <span class="error">*</span> </label>
                                        <span class="error"><?php echo form_error('username'); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                    <input class="col l2 m2 s2" placeholder="+971" id="country_code" name="country_code" type="text" value="+971" readonly="">
                                        <input class="col l10 m10 s10" placeholder="Mobile No." id="mobile" name="phone" type="text" required>
                                        <label for="mobile">Mobile No. <span class="error">*</span> </label>
                                        <span class="error"><?php echo form_error('phone'); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Password" id="password" name="password" type="password"
                                            required>
                                        <label for="password">Password <span class="error">*</span> </label>
                                        <span class="error"><?php echo form_error('password'); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Confirm Password" name="cpassword" id="confirmpassword"
                                            type="password" required>
                                        <label for="confirmpassword">Confirm Password <span class="error">*</span>
                                        </label>
                                        <span class="error"><?php echo form_error('cpassword'); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12">
                                        <input placeholder="Reference code" id="reference" name="ref_code" type="text">
                                        <label for="reference">Reference code </label>
                                    </div>
                                </div>
<<<<<<< HEAD
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s10 te-checkbox">
                                    <input type="checkbox" name="terms" id="terms-checkbox" class="terms-checkbox">I accept the terms & conditions
                                     <a class="term-ll" href="<?php echo base_url()?>terms-and-conditions"><i class="material-icons dp48">info_outline</i></a>
=======
                                <div class="row">
                                    <div class="input-field col l12 m12 s12 te-checkbox">
                                    <input type="checkbox" name="terms" id="terms-checkbox" class="terms-checkbox">I accept the
                                            terms & conditions
                                            <a href="<?php echo base_url()?>terms-and-conditions"><i
                                                    class="material-icons dp48">info_outline</i></a>
                                       
>>>>>>> 988c56be4d589cbdb11d5b6b7750b98e4e42c691
                                        <span class="error"><?php echo form_error('terms'); ?></span>
                                    </div>
                                </div>
                                <button class="btn  left-align register-formbutton" value="submit"
                                    name="submit">Submit</button>
                            </form>
                            <div class="col l12 m12 s12">
                                <p class="login-link">Already have account? <a href="<?php echo base_url('login') ?>">
                                        Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l6 m12  s12 ">
                    <div class="register-welcome">
                        <div class="register-welcome-image center-align">
                            <img class="brain-icon" src="<?php echo base_url()?>assets/img/Brain.png" alt="register">
                        </div>
                        <h4 class="register-welcome-title center-align">Welcome</h4>
                        <div class="register-welcome-content center-align tb-mb0">
                            <p class="register-welcome-content center-align">Incubated in the City of Gold, Dubai, UAE, Smart Link Telecommunications Trading L.L.C provides exemplary telecom solutions through innovation, technical expertise and fair business practices.
                            </p>
                            <!-- <a class="terms-link center-align" href="<?php echo base_url()?>terms-and-conditions">Terms & Condition</a> -->
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
        // side navigation bar
        $('.sidenav').sidenav();
        //tooltip terms and conditions
        $('.tooltipped').tooltip();

        $('select').formSelect();
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#signup-form").validate({
            rules: {
                username: {
                    required: true,
                },
                phone: {
                    required: true,
                    number: true,
                    minlength: 9,
                    maxlength: 9,
                },
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                country_code: {
                    required: true,
                },
                terms: {
                    required: true,
                },
            },
            messages: {
                phone: {
                    required: "Please enter your Mobile number",
                    number: "Please enter a valid Mobile number",
                    minlength: "Your Mobile number at least 9 digits",
                    maxlength: "Your Mobile number must be 9 digits",
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                cpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                username: "Please enter a valid Username",
                terms: "Please agree our terms and conditions",
                country_code: "Please select your country code",
            }
        });
    });
    </script>
    
</body>

</html>