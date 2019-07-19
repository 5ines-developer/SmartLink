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
            <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
            <style>
            #select-telecom{display: none;}
            #select-it{display: none;}
            #select-business{display: none;}
            #select-customer{display: none;}
            </style>
        </head>
        <body>
            <?php $this->load->view('includes/header.php'); ?>
            <section class="agent-profile refer-friend">
                <div class="container-wrap3">
                    <div class="row mb-0">
                        <!-- sidebar -->
                        <?php $this->load->view('includes/agent-sidebar.php'); ?>
                        <!-- side bar end -->
                        <div class="col  l9 m8 s12">
                            <div class="card agent-profile-right">
                                <div class="card-content agent-right-content">
                                    <div class="agent-edit-title">
                                        <h6 class="agent-edit-title-cn">Fill Friend Details </h6>
                                    </div>
                                    <div class="agent-profile-table">
                                        <form action="<?php echo base_url('add-refer-a-friend') ?>" method="post"
                                            class="col l12 m12 s12" id="edit-form">
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Full Name" id="name" name="name" type="text" required>
                                                    <label for="name">Full Name <span class="error">*</span></label>
                                                    <span class="error"><?php echo form_error('name'); ?></span>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Email" id="email" name="email" type="email">
                                                    <input  id="uniq" name="uniq" type="hidden" value="<?php echo random_string('alnum',16); ?>">
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Mobile No." id="phone" type="text" name="phone" required>
                                                    <label for="phone">Mobile No. <span class="error">*</span></label>
                                                    <span class="error"><?php echo form_error('phone'); ?></span>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Company Name" id="company" type="text" name="company">
                                                    <label for="company">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Location" id="location" type="text" name="location">
                                                    <label for="location">Location</label>
                                                </div>
                                                <div id="select-product">
                                                    <div class="input-field col l6 m6 s12">
                                                        <select name="product" id="product">
                                                            <option value="" disabled selected>Select the Product</option>
                                                            <option value="telecom">Telecom</option>
                                                            <option value="it">IT</option>
                                                        </select>
                                                        <label>Product</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <textarea placeholder="Enter Area" id="area" name="area"
                                                    class="materialize-textarea"></textarea>
                                                    <label for="area">Area</label>
                                                </div>
                                                <div id="select-telecom">
                                                    <div class="input-field col l6 m6 s12">
                                                        <select name="telecom_type" id="telecom">
                                                            <option value="" disabled selected>Telecom</option>
                                                            <option value="business">Business</option>
                                                            <option value="personal">Personal</option>
                                                        </select>
                                                        <label>Plaese Choose a category in  Telecom </label>
                                                    </div>
                                                </div>
                                                <div id="select-it">
                                                    <div class="input-field col l6 m6 s12">
                                                        <select name="it_type" id="it">
                                                            <option value="" disabled selected>IT</option>
                                                            <option value="web developmnent">Web Development</option>
                                                            <option value="app development">App Development</option>
                                                        </select>
                                                        <label>Plaese Choose a category in IT</label>
                                                    </div>
                                                </div>
                                                <div id="select-business">
                                                    <div class="input-field col l6 m6 s12">
                                                        <select name="customer_type" id="business">
                                                            <option value="" disabled selected>Business</option>
                                                            <option value="newcustomer">New Customer</option>
                                                            <option value="existingcustomer">Existing Customer</option>
                                                        </select>
                                                        <label>select a customer type</label>
                                                    </div>
                                                </div>
                                                <div id="select-customer">
                                                    <div class="input-field col l6 m6 s12">
                                                        <select name="sub_product" id="customer">
                                                            <?php if (!empty($product)) {
                                                            foreach ($product as $key => $value) {
                                                            if ($value->category == 'telecom'){ ?>
                                                            <option value="<?php echo $value->uniq ?>"><?php echo $value->service ?></option>
                                                            <?php  } } } ?>
                                                        </select>
                                                        <label>select a product</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l12 m12 s12">
                                                    <textarea placeholder="Enter Description" id="description" name="description"
                                                    class="materialize-textarea"></textarea>
                                                    <label for="description">Description</label>
                                                </div>
                                            </div>
                                            <div class="form-valdation-error">
                                                <?php echo ($this->session->flashdata('error'))? '<span class="error">'.$this->session->flashdata('error').'</span>' : '' ?>
                                            </div>
                                            <button class="btn  left register-formbutton" value="submit"
                                            name="submit">Submit</button>
                                        </form>
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
            $('.modal').modal();
            $('select').formSelect();
            });
            </script>
            <script>
            $(document).ready(function() {
            $("#edit-form").validate({
            rules: {
            name: {
            required: true,
            },
            phone: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
            },
            },
            messages: {
            phone: {
            required: "Please enter your Mobile number",
            number: "Please enter a valid Mobile number",
            minlength: "Your Mobile number at least 10 digits",
            maxlength: "Your Mobile number must be 10 digits",
            },
            name: "Please enter a valid Username",
            }
            });
            });
            </script>
            <script>
            $(document).ready(function() {
            $('#product').on('change', function() {
            var productval = this.value;
            if (productval == 'telecom') {
            $('#select-telecom').show();
            $('#select-it').hide();
            }else if (productval == 'it'){
            $('#select-it').show();
            $('#select-telecom').hide();
            $('#select-business').hide();
            $('#select-customer').hide();
            }else{
            $('#select-it').hide();
            $('#select-telecom').hide();
            $('#select-telecom').hide();
            $('#select-business').hide();
            $('#select-customer').hide();
            }
            });
            $('#telecom').on('change', function() {
            var productval = this.value;
            if (productval == 'business') {
            $('#select-telecom').hide();
            $('#select-business').show();
            }else{
            $('#select-it').hide();
            $('#select-telecom').show();
            $('#select-business').hide();
            }
            });
            $('#business').on('change', function() {
            var productval = this.value;
            if (productval != '') {
            $('#select-customer').show();
            $('#select-telecom').hide();
            $('#select-business').hide();
            }else{
            $('#select-it').hide();
            $('#select-telecom').hide();
            $('#select-business').hide();
            }
            });
            
            
            
            
            });
            </script>
            
        </body>
    </html>