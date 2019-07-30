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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/style.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<body class="white">
    <?php $this->load->view('includes/header.php'); ?>

    <!-- otp-section -->
    <section>
        <div class="container-wrap3">
            <div class="row mb-0">
                <div class="col offset-l3 l6 offset-m3 m6 s12 pad40">
                    <div class="register-form loginpad">
                        <div class=" center-align">
                            <h5 class="register-title black-text">Verification Code</h5>
                            <p class="para">Use your device to reset your smart link account</p>
                            <center><img src="<?php echo base_url()?>assets/images/otp.png"
                                    class="img-responsive otp-img" alt="otp"></center>
                        </div>
                        <div>
                            <div class="center-align">
                                <h5 class="register-title black-text">Enter a verification Code</h5>
                                <p class="para">Enter the OTP which has been sent to your Mobile No.
                                    <?php echo $phone ?> to reset your password.</p>
                            </div>
                            <form action="<?php echo base_url('forgot-verify')?>" method="post" id="otpform"
                                class="col l12 m12 s12">
                                <div class="row mb-0">
                                    <div class="input-field col l12 m12 s12 m0">
                                        <input id="otp" type="text" placeholder="Enter the 6 digit code" name="otp"
                                            class="validate">
                                        <span class="error"><?php echo form_error('otp'); ?></span>
                                        <input type="hidden" id="phone" name="phone" value="<?php echo $mobile ?>" />
                                        <input type="hidden" id="cntry" name="cntry" value="<?php echo $cntry ?>" />
                                        <p id="paswrd-error" class="error required"></p>
                                    </div>
                                    <?php $this->load->view('includes/pre-loader'); ?>

                                </div>
                                <button class="btn  left-align sub-button" value="submit" name="submit"
                                    type="submit">Submit</button>
                            </form>
                            <form action="<?php echo base_url('forgot-password') ?>" method="post" id="resendotp-form">
                                <a class="forgot-link right-align" id="resend-code">Resend Code?</a>
                                <input type="hidden" id="mobile" name="mobile" value="<?php echo $mobile ?>" />
                            </form>
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

        $("#resend-code").click(function() {
            $("#resendotp-form").submit();

        });


    });
    </script>
    <script>
    $(document).ready(function() {
        $("#otpform").validate({
            rules: {
                otp: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    number: true
                },
            },
            messages: {
                otp: {
                    required: "Please enter a OTP",
                    minlength: "OTP must be 6 digit",
                    maxlength: "OTP must be 6 digit",
                    number: "Please enter a valid OTP"
                },
            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $("#otpform").on('submit', function(event) {
            event.preventDefault();
            var otp = $("#otp").val();
            var phone = $("#phone").val();
            var cntry = $("#cntry").val();
            var max = '3';
            if (otp == '') {
                return false;
            } else {
                var DataString = $("#otpform").serialize();
                loder(true);
                $.ajax({
                    url: "<?php echo base_url();?>forgot-verify",
                    type: "Post",
                    dataType: "html",
                    data: DataString,
                    success: function(data) {
                        console.log(data);
                        if (data == '') {
                            location.href = "<?php echo base_url('forgot-password')?>"
                        } else if (data < '3' && data >= '1') {

                            $("#paswrd-error>span").remove();
                            $("#paswrd-error").append(
                                "<span>You have entered invalid OTP, You have only " + (
                                    max - data) + " attempts left</span>");
                        } else {
                            $('#my_div').html(data);
                            $('body').html(data);
                        }
                        loder(false);
                    }
                });
            }
        });

        //page loader
        function loder(status) {
            if (status == true) {
                $('.preloader-verfy').css('display', 'block');
            } else {
                $('.preloader-verfy').css('display', 'none');
            }
        }
    });
    </script>
</body>

</html>