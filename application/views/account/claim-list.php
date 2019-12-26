<?php
  $this->ci =& get_instance();
  $this->ci->load->model('m_account');
?>
<!DOCTYPE html>

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
     <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/stylesheet/index.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<body>
    <?php  $this->load->view('includes/header');?>
    <section class="agent-profile">
        <div class="container-wrap3">
            <div class="row mb-0">
                <!-- sidebar -->
                <?php $this->load->view('includes/agent-sidebar.php'); ?>
                <!-- side bar end -->

                <div class="col  l9 m12 s12">
                    <div class="card agent-profile-right">
                        <div class="card-content agent-right-content">
                            <div class="agent-edit-title">
                                <h6 class="agent-edit-title-cn">List of Claim</h6>
                            </div>
                            <div class="claim-detail">
                                <div class="row">
                                    <div class="col xl12 l12 m12 s12 of-table">
                                        <table class="striped claim-table" id="">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Claimed Point</th>
                                                    <th>Status</th>
                                                    <th>Smart Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($claim) {
                                                  foreach ($claim as $key => $value) { ?>
                                                <tr>
                                                    <td><?php echo  $value->claimed_on ?></td>
                                                    <td><?php echo  $value->claimed_points ?></td>
                                                    <td class="<?php if ($value->claim_status == '1') {
                                                        echo "green-text";
                                                    }else if ($value->claim_status == '0') {
                                                        echo "blue-text";
                                                    }else if ($value->claim_status == '2') {
                                                        echo "red-text";
                                                    }?>  "><?php 
                                                    if ($value->claim_status == '1') {
                                                        echo 'Success';
                                                    }elseif ($value->claim_status == '2') {
                                                        echo 'Rejected';
                                                    }else{
                                                        echo 'Process';
                                                    }?></td>
                                                    <td class="show-smart"><?php 
                                                if ($value->claim_status == '1' && !empty($value->coupon_code)) { ?>
                                                        <a class="view-smart-code waves-effect waves-light btn-small modal-trigger"
                                                            id="<?php echo $value->claim_id ?>" href=".smartcode">View
                                                            Code</a>
                                                        <?php }else{ 
                                                    echo '-------';
                                                     }?></td>
                                                </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Structure -->

    <div id="smartcode" class="modal smartcode">
        <form id="code-view">
            <div class="modal-content mc-smartcode">
                <h4>Verify</h4>
                <p class="mod-title">To View Smart Code Please Enter the Below Detail</p>
                <div class="row">
                    <div class="col l12">
                        <div class="input-field">
                            <input class="" placeholder="Enter Your Mobile No. or Nick Name " id="name" name="name"
                                type="text" required="" autocomplete="off">
                            <label for="name" class="">Mobile No. or Nick Name</label>
                            <span class="error"><?php echo form_error('name'); ?></span>
                        </div>
                        <div class="input-field">
                            <input id="claimid" name="claimid" type="hidden">
                            <input class="" placeholder="Enter Your Password" id="password" name="password"
                                type="password" required="" autocomplete="off">
                            <label for="password" class="lable-claim">Password</label>
                            <span class="error"><?php echo form_error('password'); ?></span>
                            <p id="paswrd-error" class="paswrd-error error required"></p>
                        </div>
                        <?php $this->load->view('includes/pre-loader'); ?>
                        <button class="btn register-formbutton waves-light " value="submit" name="submit"
                            id="process-refer">Submit</button>
                        <a class="forgot-link modal-trigger" href="#forgotpass">Forgot Password?</a>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <div id="forgotpass" class="modal forgot-pass">
        <form id="forgot-password">
            <div class="modal-content mc-smartcode">
                <h4>Forgot Password</h4>
                <p class="mod-title">Please enter your registered Mobile No.</p>
                <div class="row">
                    <div class="col l12 s12">
                        <div class="input-field">
                        <input class="col l2 m2 s2" placeholder="+971" id="country_code" name="country_code" type="text" value="+971" readonly="">
                            <input class="col l10 m10 s10" placeholder="Enter Your Mobile No." id="mobile" name="mobile" type="text"
                                required="" autocomplete="off">
                            <label for="mobile" class="">Mobile No.</label>
                            <span class="error"><?php echo form_error('mobile'); ?></span>
                            <p id="mobile-error" class="mobile-error error required"></p>
                        </div>
                        <?php $this->load->view('includes/pre-loader'); ?>
                        <button class="btn register-formbutton waves-light " value="submit" name="submit"
                            id="process-refer">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div id="otpmodal" class="modal otpmodal">
        <form id="otp-form">
            <div class="modal-content mc-smartcode">
                <h4>Verify</h4>
                <p class="mod-title">Please enter the OTP number which has been sent to your Mobile</p>
                <div class="row">
                    <div class="col l12 s12">
                        <div class="input-field">
                            <input class="" placeholder="Enter the OTP" id="otp" name="otp" type="text" required=""
                                autocomplete="off">
                            <label for="otp" class="">Enter the OTP</label>
                            <span class="error"><?php echo form_error('otp'); ?></span>
                            <input type="hidden" class="" id="phone" name="phone">
                            <p id="otp-error" class="otp-error error required"></p>
                            <p id="resend-error" class="otp-error error required"></p>
                            <p id="resend-success" class="otp-error green-text  required"></p>
                        </div>
                        <?php $this->load->view('includes/pre-loader'); ?>
                        <button class="btn register-formbutton waves-light " value="submit" name="submit"
                            id="process-refer">Submit</button>
                        <a class="forgot-link right-align" id="resend-code" href="#">Resend Code?</a>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div id="newpass" class="modal newpass">
        <form id="set-pass">
            <div class="modal-content mc-smartcode">
                <h4>Verify</h4>
                <p class="mod-title">To View Smart Code Please Enter the Below Detail</p>
                <div class="row">
                    <div class="col l12">
                        <div class="input-field">
                            <input class="" placeholder="Enter Your Mobile No." id="s_phone" name="s_phone" type="text"
                                required="" autocomplete="off">
                            <label for="s_phone" class="">Mobile No.</label>
                            <span class="error"><?php echo form_error('s_phone'); ?></span>
                        </div>
                        <div class="input-field">
                            <input class="" placeholder="Enter the new Password" id="n-password" name="n_password"
                                type="password" required="" autocomplete="off">
                            <label for="n-password" class="lable-claim">New Password</label>
                            <span class="error"><?php echo form_error('n_password'); ?></span>
                        </div>
                        <div class="input-field">
                            <input type="hidden" class="" id="otp-code" name="otp_code">
                            <input class="" placeholder="Confirm the password" id="c_password" name="c_password"
                                type="password" required="" autocomplete="off">
                            <label for="c_password" class="lable-claim">New Password</label>
                            <span class="error"><?php echo form_error('c_password'); ?></span>
                            <p id="forgot-error" class="error required"></p>
                        </div>
                        <?php $this->load->view('includes/pre-loader'); ?>
                        <button class="btn register-formbutton waves-light " value="submit" name="submit"
                            id="process-refer">Submit</button>
                        <a class="forgot-link modal-trigger" href="#forgotpass">Forgot Password?</a>
                    </div>
                </div>
            </div>

        </form>
    </div>


    <!-- End Modal Structure -->
    <?php  $this->load->view('includes/footer');?>
    <!-- /.boxed -->
    <!-- Javascript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function() {

        $('.smartcode').modal();
        $('#otpmodal').modal();
        $('#newpass').modal();
        $('.forgot-pass').modal({
            onOpenStart: closeOther,
        });

        function closeOther() {
            $('.smartcode').modal('close');
        }

        // $('.forgot-pass').modal({dismissible:false});


    });
    </script>
    <script>
    $(document).ready(function() {
        $("#code-view").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },

                name: {
                    required: true,
                },

            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                name: "Please enter a valid Nick Name or Mobile No",
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#otp-form").validate({
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
        $("#forgot-password").validate({
            rules: {
                mobile: {
                    required: true,
                    number: true,
                    minlength: 9,
                    maxlength: 9
                },
            },
            messages: {
                mobile: {
                    required: "Please enter your Mobile number",
                    number: "Please enter a valid Mobile number",
                    minlength: "Your Mobile number at least 9 digits",
                    maxlength: "Your Mobile number must be 9 digits",
                }
            }
        });
    });
    </script>


    <script>
    $(document).ready(function() {
        $("#set-pass").validate({
            rules: {
                s_phone: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                },
                n_password: {
                    required: true,
                    minlength: 5
                },
                c_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#n-password"
                },
            },
            messages: {
                s_phone: {

                    required: "Please enter your Mobile number",
                    number: "Please enter a valid Mobile number",
                    minlength: "Your Mobile number at least 10 digits",
                    maxlength: "Your Mobile number must be 10 digits",

                },
                n_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                c_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },

            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {

        $(".view-smart-code").click(function() {
            var id = $(this).attr('id');
            $("#claimid").val(id);
        });


        // view code submit
        $("#code-view").on('submit', function(event) {
            event.preventDefault();
            var DataString = $("#code-view").serialize();
            var btnid = $("#claimid").val();
            loder(true);
            $.ajax({
                url: "<?php echo base_url();?>verify-credentials",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    if (data == 'wrong password') {
                        $("#paswrd-error>span").remove();
                        $("#paswrd-error").append("<span>Wrong password</span>");
                    } else if (data != 'wrong password' && data != 'error' && data != '') {
                        $('.smartcode').modal('close');;
                        $("#" + btnid).after("<div class ='code-displayed'> " + data +
                            " <input type='hidden' name='cop_cod' value=" + data +
                            " class='code-cop'> <span> <button class='clip-btn'><i class='material-icons dp48'>content_copy</i></button></span> </div>"
                            );

                        $("#" + btnid).remove();
                        $('.modal-overlay').css('display', 'none');
                    } else if (data == 'error') {
                        $("#paswrd-error>span").remove();
                        $("#paswrd-error").append(
                            "<span>Unable to process your request please try again, please enter the valid credentials</span>"
                        );
                    }
                    loder(false);
                }
            });
        });

        //forgot password submit
        $("#forgot-password").on('submit', function(event) {
            event.preventDefault();
            var DataString = $("#forgot-password").serialize();
            var mobile = $("#mobile").val();
            loder(true);
            $.ajax({
                url: "<?php echo base_url();?>account/claim_forgot",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    if (data == 'wrong mobile') {
                        $(".mobile-error>span").remove();
                        $(".mobile-error").append("<span>Invalid Mobile No.</span>");
                    } else if (data != 'wrong mobile' && data != '') {
                        $('.forgot-pass').modal('close');
                        $('#otpmodal').modal('open');
                        $("#phone").val(mobile);
                    } else if (data == 'error') {
                        $(".mobile-error>span").remove();
                        $(".mobile-error").append(
                            "<span>Unable to process your request please try again, please enter the valid Mobile No</span>"
                        );
                    }
                    loder(false);
                }
            });
        });

        //otform submit
        $("#otp-form").on('submit', function(event) {
            event.preventDefault();
            var otp = $("#otp").val();
            var phone = $("#phone").val();
            var max = '3';
            if (otp == '') {
                return false;
            } else {
                var DataString = $("#otp-form").serialize();
                loder(true);
                $.ajax({
                    url: "<?php echo base_url();?>account/forgot_verify",
                    type: "Post",
                    dataType: "html",
                    data: DataString,
                    success: function(data) {
                        console.log(data);
                        if (data == '') {
                            $(".otp-error>span").remove();
                            $(".otp-error").append(
                                "<span>You have entered invalid OTP, Please Resend the code and try again</span>"
                            );
                        } else if (data < '3' && data >= '1') {
                            $(".otp-error>span").remove();
                            $(".otp-error").append(
                                "<span>You have entered invalid OTP, You have only " + (
                                    max - data) + " attempts left</span>");
                        } else {
                            $('#otpmodal').modal('close');
                            $('#newpass').modal('open');
                            $("#otp-code").val(otp);
                        }
                        loder(false);
                    }
                });
            }
        });

        //set password submit
        $("#set-pass").on('submit', function(event) {
            event.preventDefault();
            var DataString = $("#set-pass").serialize();
            loder(true);
            $.ajax({
                url: "<?php echo base_url();?>account/forgot_password_set",
                type: "Post",
                dataType: "html",
                data: DataString,
                success: function(data) {
                    console.log(data);
                    if (data == 'error') {
                        $("#forgot-error>span").remove();
                        $("#forgot-error").append(
                            "<span>Unable to process your request please try again, please enter the valid Mobile No</span>"
                        );
                    } else if (data == 'success') {
                        $('#newpass').modal('close');
                        $('.smartcode').modal('open');
                    } else {
                        $("#forgot-error").append(
                            "<span>Unable to process your request please try again, please enter the valid Mobile No</span>"
                        );

                    }
                    loder(false);
                }
            });
        });

        //resend code
        $("#resend-code").click(function(event) {
            event.preventDefault();

            var otp = $("#otp").val();
            var phone = $("#phone").val();
            loder(true);
            $.ajax({
                url: "<?php echo base_url();?>account/resend_code",
                type: "get",
                dataType: "html",
                data: {
                    mobile: phone
                },
                success: function(data) {
                    console.log(data);
                    if (data == 'error') {
                        $("#resend-error>span").remove();
                        $("#resend-success>span").remove();
                        $("#resend-error").append(
                            "<span>Unable to process your request please try again, please enter the valid Mobile No</span>"
                        );
                    } else if (data == 'success') {
                        $("#resend-error>span").remove();
                        $("#resend-success>span").remove();
                        $('#resend-success').append("<span>'We have sent an OTP to " + phone + ", Please enter the OTP and verify your account</span>");
                    } else if (data == 'wrong mobile') {
                        $("#resend-error>span").remove();
                        $("#resend-success>span").remove();
                        $("#resend-error").append("<span>Invalid Mobile No.</span>");

                    }
                    loder(false);
                }
            });

        });


        //page loader
        function loder(status) {
            if (status == true) {
                $('.preloader-verfy').css('display', 'block');
            } else {
                $('.preloader-verfy').css('display', 'none');
            }
        }


        // $('#smartcode').modal({ dismissible: false });
        // $('#otpmodal').modal({ dismissible: false });
        // $('#newpass').modal({ dismissible: false });
        // $('#forgotpass').modal({ dismissible: false });
 

    });
    </script>

<script>
        $(document).on("click",'.clip-btn', function(){
        // value = $(this).data('clipboard-text'); //Upto this I am getting value
        // val = $(this).val(); //Upto this I am getting value
        val = $(this).closest(".code-displayed").find("input[name='cop_cod']").val();
        var $temp = $("<input>");
          $("body").append($temp);
          $temp.val(val).select();
          document.execCommand("copy");
          alert('Copied Text : ' +val );
          $temp.remove();
    })
</script>
 <script>

<?php if (!empty($alert)) { 

    foreach ($alert as $key => $value) { 

        if ($value->notification_type == '1' && $value->notification_subject == 'Refer a friend Success') {
            $re_val = $this->ci->m_account->rewrd_val($value->thing_id);         
        ?>

        var toastHTML = '<span style="color:black;font-weight: 400;font-size: 14px;">You have earned <?php echo $re_val ?> reward points <a class="" href="<?php echo base_url('noti-view/').$value->thing_id.'/'.$value->notification_type.'/'.$value->uniq ?>" style="text-decoration: unset;background: #05afc9;color: white;padding: 5px 15px;font-size: 13px;margin-left: 35px;">View</a></span><button class="btn-flat toast-action" onclick="toast()"><i class="material-icons dp48">close</i></button>';
        M.toast({
            html: toastHTML,
            displayLength:100000,
            classes:'white'
        });
    
        function toast() {
            var toastElement = document.querySelector('.toast');
      var toastInstance = M.Toast.getInstance(toastElement);
      toastInstance.dismiss(); 
        }
      <?php  } }  }?>

        

    </script>


</body>

</html>