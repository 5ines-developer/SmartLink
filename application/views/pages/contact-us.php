<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />
    <title>Smart Link</title>
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/style.css">
    <link rel="stylesheet" type="text/css" href="assets/stylesheet/index.css">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body>
<?php $this->load->view('includes/header.php'); ?>
    <section class="section contact-back">
        <div class="row">
            <div class="col l12 s12">
                <div class="inner-banner">
                    <h5>Contact Us</h5>
                    <P>Get in touch with us. We'll do our best to help you.</P>
                </div>
            </div>
        </div>
    </section>
    <section class="sect-tp">
        <div class="container-fluide">
            <div class="row">
                <div class="col l4">
                    <div class="cont-list">
                        <i class="fas fa-phone ll-ic"></i>
                        <p>Landline : <a href="tel:+971 42535555">+971 42535555</a> </p>
                    </div>
                </div>
                <div class="col l4">
                    <div class="cont-list">
                        <i class="fab fa-whatsapp ll-ic"></i>
                        <p>Whatsapp :
                            <a href="tel:0502904073">0502904073</a>
                        </p>
                    </div>
                </div>
                <div class="col l4">
                    <div class="cont-list">
                        <i class="far fa-envelope ll-ic"></i>
                        <p class="black-text">Email :
                            <a href="mailto:info@smartlink.ae" class="black-text">info@smartlink.ae </a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col offset-l1 l10 m12 s12 offset-s0">
                    <div class="form-cont">
                        <div class="get-touch">
                            <h5>GET IN TOUCH</h5>
                        </div>
                        <div class="form-contact">
                            <form action="">
                                <div class="row">
                                    <div class="col l6 s12">
                                        <div class="input-field ">
                                            <input id="name" type="text" class="validate" required>
                                            <label for="name" name="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col l6 s12">
                                        <div class="input-field ">
                                            <input id="phone" type="text" class="validate" required>
                                            <label for="phone" name="phone">Phone</label>
                                        </div>
                                    </div>
                                    <div class="col l6 s12">
                                        <div class="input-field ">
                                            <input id="email" type="text" class="validate">
                                            <label for="email" name="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col l6 s12">
                                        <div class="input-field ">
                                            <input id="last_name" type="text" class="validate" required>
                                            <label for="last_name" name="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col l12 s12 ">
                                        <div class="input-field ">
                                            <textarea id="textarea1" class="materialize-textarea"></textarea>
                                            <label for="textarea1">Message</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="butt-btn">
                                    <button type="submit" class="btn-con">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <div class="col l5">
                    <div class="get-address">
                        <h4>Contact No</h4>
                        <p>
                            <a tel:+971 42535555></a><b>Landline :</b> +971 42535555</a>
                        </p>
                        <p>
                            <a tel:+971 42535555></a><b>Whatsapp :</b> 0502904073</a>
                        </p>
                        <h4>Email</h4>
                        <p><a mailto:info@smartlink.ae><b>Sales :</b>info@smartlink.ae</a></p>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
<!--     <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.9403179910732!2d77.52152561404687!3d12.911557440895294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3fcf9271bc25%3A0xe806a9d57ba37b1b!2s5ine+Web+-+Best+Website+Design+%26+Digital+Marketing+Agency+in+RR+Nagar!5e0!3m2!1sen!2sin!4v1516776855209"
            style="border:0" allowfullscreen="" width="100%" height="450" frameborder="0"></iframe>
    </div> -->

 <?php $this->load->view('includes/footer.php'); ?>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="assets/javascript/script.js"></script>
    <script src="assets/javascript/jquery.validate.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal').modal();
            $('.tabs').tabs();

            instance.destroy();
        });
        $('.dropdown-trigger').dropdown();
    </script>
</body>

</html>