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
                                    <div class="input-field col l4 s2">
                                        <select name="country_code" required id="country_code">
                                            <option value="" disabled selected>ex: +971</option>
                                            <?php if (!empty($country_code)) {
                                                        foreach ($country_code as $key => $value) { ?>
                                            <option value="<?php echo $value->code ?>"><?php echo '+'.$value->code ?>
                                            </option>
                                            <?php   } } ?>

                                        </select>
                                        <label for="country_code">Country Code <span class="error">*</span></label>
                                    </div>
                                    <div class="input-field col l8 m12 s12">
                                        <input placeholder="Mobile No." id="mobile" name="phone" type="text" required>
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
                                <div class="row mb-0">
                                    <p class="terms-check">
                                        <label class="termlable" for="terms-checkbox"> <input type="checkbox"
                                                name="terms" id="terms-checkbox" class="terms-checkbox">I accept the
                                            terms & conditions
                                            <a href="<?php echo base_url()?>"><i
                                                    class="material-icons dp48">info_outline</i></a>
                                        </label>
                                        <!-- <label>
                                                <input class="filled-in" type="checkbox" name="terms" required/>
                                                <span class="register-checklabel">Terms & Conditions <span class="error">*</span></span>
                                            </label> -->
                                        <span class="error"><?php echo form_error('terms'); ?></span>
                                    </p>
                                </div>
                                <div class="form-valdation-error">
                                    <?php echo ($this->session->flashdata('error'))? '<span class="error">'.$this->session->flashdata('error').'</span>' : '' ?>
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
                            <img src="<?php echo base_url()?>assets/images/register-hi.png" alt="register">
                        </div>
                        <h4 class="register-welcome-title center-align">Welcome</h4>
                        <div class="register-welcome-content center-align tb-mb0">
                            <p class="register-welcome-content center-align">Lorem ipsum dolor sit amet consectetur,
                                adipisicing elit. Nemo
                                voluptatibus alias quis
                                ipsa similique ex earum? Ex, quidem voluptatum recusandae expedita, ipsum nobis id
                                repellendus modi voluptatem totam adipisci nisi?
                            </p>
                            <a class="terms-link center-align" href="<?php echo base_url()?>">Terms & Condition</a>
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
                    minlength: 10,
                    maxlength: 10,
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
                    minlength: "Your Mobile number at least 10 digits",
                    maxlength: "Your Mobile number must be 10 digits",
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