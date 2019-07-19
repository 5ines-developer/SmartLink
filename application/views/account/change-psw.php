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
        <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
    </head>
    <body >
            <?php  $this->load->view('includes/header');?>
            <section class="agent-profile">
                <div class="container-wrap3">
                    <div class="row mb-0">
                        <!-- sidebar -->
                        <?php $this->load->view('includes/agent-sidebar.php'); ?>
                        <!-- side bar end -->
                        
                        <div class="col  l9 m8 s12">
                            <div class="card agent-profile-right">
                                <div class="card-content agent-right-content">
                                    <div class="agent-edit-title">
                                        <h6 class="agent-edit-title-cn">Change Password
                                    </div>
                                    <div class="change-password-detail">
                                        <form action="<?php echo base_url('change-password') ?>" method="post" class="col l12 m12 s12"id="edit-form">
                                            <div class="row">
                                                <div class="col  offset-l3 l6 m12 s12">
                                                    <div class="input-field">
                                                        <input placeholder="Enter Your Current Password" id="current_pws" name="current_pws" type="password" required>
                                                        <label for="current_pws">Current Password</label>
                                                        <span class="error"><?php echo form_error('current_pws'); ?></span>
                                                    </div>
                                                    <div class="input-field">
                                                        <input placeholder="Enter Your New Password" id="new_pws" name="new_pws" type="password" required>
                                                        <label for="new_pws">New Password</label>
                                                        <span class="error"><?php echo form_error('new_pws'); ?></span>
                                                    </div>
                                                    <div class="input-field">
                                                        <input placeholder="Enter Your Conform Password" id="conf_pws" name="conf_pws" type="password" required>
                                                        <label for="conf_pws">Confirm Password</label>
                                                        <span class="error"><?php echo form_error('conf_pws'); ?></span>
                                                    </div>
                                                    <div class="form-valdation-error">
                                                        <?php echo ($this->session->flashdata('error'))? '<span class="error">'.$this->session->flashdata('error').'</span>' : '' ?>
                                                        
                                                    </div>
                                                    <button class="btn  left register-formbutton" value="submit"
                                                    name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php  $this->load->view('includes/footer');?>
            <!-- /.boxed -->
            <!-- Javascript -->
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
            <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
            <script>
            $(document).ready(function() {
            $("#edit-form").validate({
            rules: {
            current_pws: { required: true, },
            new_pws: {
            required: true,
            minlength: 5
            },
            conf_pws: {
            required: true,
            minlength: 5,
            equalTo: "#new_pws"
            },
            },
            messages: {
            current_pws: "Please enter your current password",
            new_pws: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
            },
            conf_pws: {
            required: "Please provide a confirm password",
            minlength: "Your password must be at least 5 characters long",
            equalTo: "Please enter the same password as above"
            },
            }
            });
            });
            </script>
               <script>

<?php if (!empty($alert)) { 

    foreach ($alert as $key => $value) { ?>

        var toastHTML = '<span>You have earned New reward points</span><button class="btn-flat toast-action" onclick="toast()"><i class="material-icons dp48">close</i></button>';
        M.toast({
            html: toastHTML,
            displayLength:4000,
            classes:'white'
        });
    
        function toast() {
            var toastElement = document.querySelector('.toast');
      var toastInstance = M.Toast.getInstance(toastElement);
      toastInstance.dismiss(); 
        }
      <?php  } }  ?>

        

    </script>
        </body>
    </html>