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
            <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/style.css">
               <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/index.css">
            <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
        </head>
        <body class="white">
            <?php $this->load->view('includes/header.php'); ?>
          <section class=" section-p">
        <div class="container-fluide">
            <div class="row">
                <div class="col l12">
                    <h5 class="faq">Terms & Condition</h5>
                    <div class="ban">
                        <div class="row m0">
                            <div class="col offset-l2 l8 m12 s12">
                                <div class="refer-frd">
                                    <!-- <h6>Frequenty Asked Question</h6> -->
                                    <div class="faq-detail">
                                        <ul class="collapsible">
                                            <li class="active">
                                                <div class="collapsible-header ch-faq">HOW WILL I KNOW ABOUT PROGRESS OF MY REFErals</div>
                                                <div class="collapsible-body cb-faq"><span>user will receive notification on app or web portal , on approval of submission, progress, activation, rewarded point & when you claim you reward.</span></div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">HOW CAN I EARN MONEY</div>
                                                <div class="collapsible-body cb-faq">
                                                    <span>User should refer a friend who has business telecom requirement such as ( broadband,landline,business mobile plan etc.) once the reference is submitted all possible leads will be verified by admin for approval. After approval the reference will be in progress for activation , user will be notified about the progress. Once the reference is activated user will be rewarded with points based on total activation which can be claimed and encashed</span>
                                                    <p class="tt-red">Admin reserve all the rights to reject / approve any reference, reward points or claims at any point of time.</p>
                                                    <p class="blue-text claim-table">( Click here to view the point sheet )</p>
                                                    <table class="striped bor-ffs ">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="" class="center">Product Name</th>
                                                                <th colspan="" class="center">Reward Point (1point=AED 1)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="center">Business Complete</td>
                                                                <td class="center">500 Points</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="center ">Business Postpaid Plan</td>
                                                                <td class="center ">50% Of MRC (AED 100 PLAN = 50)</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="center ">Home Broadband</td>
                                                                <td class="center ">350 Points</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">HOW CAN I COLLECT MY REWARD POINTS AS CASH</div>
                                                <div class="collapsible-body cb-faq"><span>User will receive a one-time  smart code in their app or web portal which should be used to collect cash from nearest RAK bank ATM counter through mobile cash by entering SMART CODE & AMOUNT) all smart code are valid only for 24 hours !)</span></div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">WHAT IF MY SUBMIITED REFERNCE IS APPROVED</div>
                                                <div class="collapsible-body cb-faq"><span>All submissions are verified by Admin for possible errors and will notify user if approved or rejected.
                                                            Admin reserve all the rights to reject or approve any reference or claims by a user.
                                                            </span></div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">What if I don’t claim my points</div>
                                                <div class="collapsible-body cb-faq"><span>All reward points will be accumulated in users dash board, user can encash reward points in multiples of 100 , minimum of AED 100 & maximum of AED 2000</span></div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">How much I can claim in a day</div>
                                                <div class="collapsible-body cb-faq"><span>All reward points will be accumulated in users dash board, user can encash reward points in multiples of 100 , minimum of AED 100 & maximum of AED 2000.</span></div>
                                            </li>
                                            <li>
                                                <div class="collapsible-header ch-faq">What is SMART CODE</div>
                                                <div class="collapsible-body cb-faq"><span>A Smart code is a Onetime password generated when user claim a reward point entering mobile number and password.</span>
                                                    <p class="tr-smart">User has to enter First Reward point ( Amount ) & Then Smart Code ( Mobile Cash ) in to any RAK bank ATM to encash reward points</p>
                                                    <p class="tr-smart">All SMART CODE are valid only for 20 hours.</p>
                                                    <p class="tr-smart">Admin will not be responsible for delay or misuse of smart code.</p>
                                                    <p class="tr-smart">User can contact Admin for any assistance if required.</p>
                                                    <p class="tt-red">All claims are subject to admin approval.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
            <script type="text/javascript">
                        $(document).ready(function() {
                        $('.collapsible').collapsible();

        });
                                $(document).ready(function() {
            $(".claim").click(function() {
                $(".a-para").toggle();
            });
        });
        $(document).ready(function() {
            $(".claim-table").click(function() {
                $(".bor-ffs").toggle();
            });
        });
            </script>
        </body>
    </html>