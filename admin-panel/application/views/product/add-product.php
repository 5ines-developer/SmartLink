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
    <link href="<?php echo base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url()?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="<?php echo base_url()?>assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo base_url()?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo base_url()?>assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="<?php echo base_url()?>assets/vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

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
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo base_url()?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url()?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <style>
            #select-telecom_for{display: none;}
            #select-user_type{display: none;}
            #select-service{display: none;}
            #select-it_service{display: none;}
            #select-reward_points{display: none;}
            #select-reward_expiry{display: none;}
    </style>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <?php $this->load->view('includes/header.php'); ?>

            <?php $this->load->view('includes/sidebar.php'); ?>




            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left ">
                        </div>
                        <div class="title_right">
                        </div>
                    </div>

                    <?php if ($this->session->flashdata('success')) { ?>
                    <div class="col-sm-12 ">
                        <div class="alert alert-success" role="alert" id="message1">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                            <p><strong>Success!
                                </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('success') ?></span></p>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error')) { ?>
                    <div class="col-sm-12 ">
                        <div class="alert alert-danger" role="alert" id="message1">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                            <p><strong>Error!
                                </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('error') ?></span></p>
                        </div>
                    </div>
                    <?php } ?>


                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Add Product</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form action="<?php echo base_url() ?>insert-product" method="post" id="demo-form2"
                                        class="form-horizontal form-label-left">
                                        <div class="form-group" id="select-category" >
                                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                            <label for="category" class="control-label">Category </label>
                                                <select class="form-control" name="category" required="required"
                                                    id="category">
                                                    <option value="">-----Select-----</option>
                                                    <option value="telecom" <?php echo (!empty($product['category']) && $product['category']== 'telecom')?'selected':''  ?> >Telecom</option>
                                                    <option value="it" <?php echo (!empty($product['category']) && $product['category']== 'it')?'selected':''  ?>>IT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="select-telecom_for" <?php echo (!empty($product['telecom_for']) && $product['category']== 'telecom')?'style="display:block;"':'style="display:none;"'  ?> >
                                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                            <label for="telecom_for" class="control-label">Telecom For </label>
                                                <select class="form-control" name="telecom_for" 
                                                    id="telecom_for">
                                                    <option value="">-----Select-----</option>
                                                    <option value="business" <?php echo (!empty($product['telecom_for']) == 'business')?'selected':''  ?>>Business</option>
                                                    <option value="personal" <?php echo (!empty($product['telecom_for']) == 'personal')?'selected':''  ?>>Personal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="select-user_type" <?php echo (!empty($product['user_type']))?'style="display:block;"':'style="display:none;"'  ?>>
                                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                            <label for="user_type" class="control-label">User Type </label>
                                                <select class="form-control" name="user_type" id="user_type">
                                                    <option value="">-----Select-----</option>
                                                    <option value="new user" <?php echo (!empty($product['user_type']) == 'new user')?'selected':''  ?>>New User</option>
                                                    <option value="exisiting user" <?php echo (!empty($product['user_type']) == 'exisiting user')?'selected':''  ?>>Existing User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="select-it_service" <?php echo (!empty($product['it_service']) && $product['category']== 'it')?'style="display:block;"':'style="display:none;"'  ?>>
                                            <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                            <label for="it_service" class="control-label">IT Service </label>
                                                <select class="form-control" name="it_service" id="it_service">
                                                    <option value="">-----Select-----</option>
                                                    <option value="web development" <?php echo (!empty($product['it_service']) == 'web development')?'selected':''  ?>>Web development</option>
                                                    <option value="app development" <?php echo (!empty($product['it_service']) == 'app development')?'selected':''  ?>>App development</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="select-service" <?php echo (!empty($product['service']) && $product['category']== 'telecom')?'style="display:block;"':'style="display:none;"'  ?>>
                                            <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                                <label for="service" class="control-label">Service</label>
                                                <input id="service" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="service" value="<?php echo (!empty($product['service']))?$product['service']:''  ?>">
                                            </div>
                                        </div>
                                        <div class="form-group" id="select-reward_points" <?php echo (!empty($product['reward_points']) && $product['category']== 'telecom')?'style="display:block;"':'style="display:none;"'  ?>>
                                            <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                                <label for="reward_points" class="control-label">Reward Points</label>
                                                <input id="reward_points" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="reward_points" value="<?php echo (!empty($product['reward_points']))?$product['reward_points']:''  ?>">
                                            </div>
                                        </div>

                                        

                                            <div class="form-group" id="select-reward_expiry" <?php echo (!empty($product['reward_expiry_date']) && $product['category']== 'telecom')?'style="display:block;"':'style="display:none;"'  ?>>
                                            <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                                <label for="reward_expiry" class="control-label">Reward Points Expiry Date</label>
                                                <input id="reward_expiry" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="reward_expiry" value="<?php echo (!empty($product['reward_expiry_date']))?$product['reward_expiry_date']:''  ?>">
                                            </div>
                                        </div>

                                        

                                        <input type="hidden" value="<?php echo (!empty($product['uniq']))?$product['uniq']:random_string('alnum','20');  ?>"
                                                    name="uniq">

                                       

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button class="btn btn-primary" type="reset">Reset</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <?php $this->load->view('includes/footer.php'); ?>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url()?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url()?>assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url()?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url()?>assets/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?php echo base_url()?>assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?php echo base_url()?>assets/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="<?php echo base_url()?>assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="<?php echo base_url()?>assets/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="<?php echo base_url()?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="<?php echo base_url()?>assets/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url()?>assets/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="<?php echo base_url()?>assets/vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()?>assets/build/js/custom.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#message1').toggleClass('in');
        setTimeout(function() {
            $('.alert').fadeOut(3000)
        }, 4000);
    });
    </script>
    <script>
            $(document).ready(function() {
            $('#category').on('change', function() {
            var productval = this.value;
            if (productval == 'telecom') {
                $('#select-telecom_for').show();
                $('#select-it_service').hide();
            }else if (productval == 'it'){
                $('#select-it_service').show();
                $('#select-telecom_for').hide();
                $('#select-user_type').hide();
                $('#select-service').hide();
                $('#select-reward_points').hide();
                $('#select-reward_expiry').hide();
            }else{
                $('#select-it_service').hide();
                $('#select-telecom_for').hide();
                $('#select-user_type').hide();
                $('#select-service').hide();
                $('#select-reward_points').hide();
                $('#select-reward_expiry').hide();
                }
            });

            $('#telecom_for').on('change', function() {
            var productval = this.value;
            if (productval == 'business') {
            $('#select-user_type').show();
            }else{
                $('#select-it_service').hide();
                $('#select-user_type').hide();
                $('#select-service').hide();
                $('#select-reward_points').hide();
            }
            });
            $('#user_type').on('change', function() {
            var productval = this.value;
            if (productval != '') {
                $('#select-service').show();
                $('#select-user_type').show();
                $('#select-reward_points').show();
                $('#select-it_service').hide();
            }else{
                $('#select-service').hide();
                $('#select-it_service').hide();
                $('#select-user_type').hide();
                $('#select-reward_points').hide();
            }
            });
            
            
            
            
            });
            </script>

</body>

</html>