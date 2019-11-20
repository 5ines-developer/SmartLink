<?php
  $this->ci =& get_instance();
  $this->ci->load->model('m_account');
?>
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
                #select-it{display: none;}
                #select-telecom-for{display: none;}
                #select-customer{display: none;}
                #select-service{display: none;}
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
                        <div class="col  l9 m12 s12">
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
                                                    <input placeholder="Enter Full Name" id="name" name="name" type="text" required value="<?php echo(!empty($refer['referee_name']))?$refer['referee_name']:''; ?>">
                                                    <label for="name">Full Name <span class="error">*</span></label>
                                                    <span class="error"><?php echo form_error('name'); ?></span>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Email" id="email" name="email" type="email" value="<?php echo(!empty($refer['refree_email']))?$refer['refree_email']:''; ?>">
                                                    <input  id="uniq" name="uniq" type="hidden" value="<?php echo(!empty($refer['uniq']))?$refer['uniq']:random_string('alnum',16);; ?>">
                                                    <input name="edit" type="hidden" value="<?php echo(!empty($refer['referee_name']))?'1':''; ?>">
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                            <?php
                                            if (!empty($refer['referee_name'])) { 
                                               $notiuniq =  $this->ci->m_account->notidet($refer['uniq']); ?>
                                               <input name="notiuniq" type="hidden" value="<?php echo(!empty($refer['referee_name']))?$notiuniq:''; ?>">
                                           <?php } ?>
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <input class="col l2 m2 s2" placeholder="+971" id="country_code" name="country_code" type="text" value="+971" readonly="">
                                                    <input class="col l10 m10 s10"  placeholder="Eg: 551234567"  id="phone" type="text" name="phone" required value="<?php echo(!empty($refer['referee_phone']))?$refer['referee_phone']:''; ?>">
                                                    <label for="phone">Mobile No. <span class="error">*</span></label>
                                                    <span class="error"><?php echo form_error('phone'); ?></span>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Company Name" id="company" type="text" name="company"  value="<?php echo(!empty($refer['refree_company']))?$refer['refree_company']:''; ?>">
                                                    <label for="company">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l6 m6 s12">
                                                    <input placeholder="Enter Location" id="location" type="text" name="location" value="<?php echo(!empty($refer['referee_location']))?$refer['referee_location']:''; ?>">
                                                    <label for="location">Location</label>
                                                </div>
                                                <div class="input-field col l6 m6 s12">
                                                    <textarea placeholder="Enter Area" id="area" name="area"
                                                    class="materialize-textarea"><?php echo(!empty($refer['refree_area']))?$refer['refree_area']:''; ?></textarea>
                                                    <label for="area">Area</label>
                                                </div>
                                                
                                            </div>
                                            <div class="row mb-0">
                                                <div id="select-category" >
                                                    <div class="input-field col l8 m8 s12">
                                                        <select name="category" id="category">
                                                            <option value="">Select the Category</option>
                                                            <option value="telecom" <?php echo(!empty($refer['product']) && $refer['product']=='telecom')?'selected':''; ?> >Telecom</option>
                                                            <option value="it" <?php echo(!empty($refer['product']) && $refer['product']=='it')?'selected':''; ?>>IT</option>
                                                        </select>
                                                        <label>Category</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-0" id="telecom-sub" >
                                                <div id="select-telecom-for" <?php echo(!empty($refer['telecom_type']))?'style="display:block;"':''; ?>>
                                                    <div class="input-field col l4 m4 s12">
                                                        <select name="telecom_type" id="telecom-for">
                                                            <option value="">Category in Telecom</option>
                                                            <option value="business" <?php echo(!empty($refer['telecom_type']) && $refer['telecom_type']=='business')?'selected':''; ?>>Business</option>
                                                            <option value="personal" <?php echo(!empty($refer['telecom_type']) && $refer['telecom_type']=='personal')?'selected':''; ?>>Personal</option>
                                                        </select>
                                                        <label>Choose a category in Telecom</label>
                                                    </div>
                                                </div>
                                                <div id="select-customer" <?php echo(!empty($refer['customer_type']))?'style="display:block;"':''; ?>>
                                                    <div class="input-field col l4 m4 s12">
                                                        <select name="customer_type" id="customer-type">
                                                            <option value="">Customer Type</option>
                                                            <option value="newcustomer" <?php echo(!empty($refer['customer_type']) && $refer['customer_type']=='newcustomer')?'selected':''; ?>>New Customer</option>
                                                            <option value="existingcustomer" <?php echo(!empty($refer['customer_type']) && $refer['customer_type']=='existingcustomer')?'selected':''; ?>>Existing Customer</option>
                                                        </select>
                                                        <label>select a customer type</label>
                                                    </div>
                                                </div>
                                                <div id="select-service" <?php echo(!empty($refer['sub_product']))?'style="display:block;"':''; ?>>
                                                    <div class="input-field col l4 m4 s12">
                                                        <select name="service" id="service">
                                                            <option value="">Product or Service</option>
                                                            <?php if (!empty($product)) {
                                                            foreach ($product as $key => $value) {
                                                            if ($value->category == 'telecom'){ ?>
                                                            <option value="<?php echo $value->uniq ?>" <?php echo(!empty($refer['sub_product']) && $refer['sub_product']==$value->uniq)?'selected':''; ?> ><?php echo $value->service ?></option>
                                                            <?php  } } } ?>
                                                        </select>
                                                        <label>select a product or Service</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div id="select-it" <?php echo(!empty($refer['it_type']))?'style="display:block;"':''; ?>>
                                                    <div class="input-field col l4 m4 s12">
                                                        <select name="it_type" id="it">
                                                            <option value="">Category in IT</option>
                                                            <option value="web developmnent" <?php echo(!empty($refer['it_type']) && $refer['it_type']=='web developmnent')?'selected':''; ?>>Web Development</option>
                                                            <option value="app development" <?php echo(!empty($refer['it_type']) && $refer['it_type']=='app development')?'selected':''; ?>>App Development</option>
                                                        </select>
                                                        <label>Choose a category in IT</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="input-field col l12 m12 s12">
                                                    <textarea placeholder="Enter Description" id="description" name="description"
                                                    class="materialize-textarea"><?php echo(!empty($refer['description']))?$refer['description']:''; ?></textarea>
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
            minlength: 9,
            maxlength: 9,
            },
            },
            messages: {
            phone: {
            required: "Please enter your Mobile number",
            number: "Please enter a valid Mobile number",
            minlength: "Your Mobile number at least 9 digits",
            maxlength: "Your Mobile number must be 9 digits",
            },
            name: "Please enter a valid Username",
            }
            });
            });
            </script>

            <script>
            $(document).ready(function() {
                $('#category').on('change', function() {
                    var category = this.value;
                        if (category == 'telecom') {
                            $('#select-telecom-for').show();
                            $('#select-it').hide();
                        }else if (category == 'it'){
                            $('#select-it').show();
                            $('#select-telecom-for').hide();
                            $('#select-customer').hide();
                            $('#select-service').hide();
                        }else{
                            $('#select-it').hide();
                            $('#select-telecom-for').hide();
                            $('#select-customer').hide();
                            $('#select-service').hide();
                        }
                });

            $('#telecom-for').on('change', function() {
                var telecomfor = this.value;
                if (telecomfor == 'business') {
                    $('#select-customer').show();
                    $('#select-service').hide();
                }else{
                    $('#select-customer').hide();
                    $('#select-service').hide();
                }
            });

            $('#customer-type').on('change', function() {
            var customertype = this.value;
            if (customertype != '') {
                $('#select-service').show();
            }else{
                $('#select-service').hide();
            }
            });
            
            
            
            
            });
            </script>
             <script>

<?php if (!empty($alert)) { 

    foreach ($alert as $key => $value) { 

        if ($value->notification_type == '1' && $value->notification_subject == 'Refer a friend Success') {
            $re_val = $this->ci->m_account->rewrd_val($value->thing_id);         
        ?>

        var toastHTML = '<span>You have earned <?php echo $re_val ?> reward points <a class="black-text" href="<?php echo base_url('noti-view/').$value->thing_id.'/'.$value->notification_type.'/'.$value->uniq ?>" style="text-decoration: underline;">View</a></span><button class="btn-flat toast-action" onclick="toast()"><i class="material-icons dp48">close</i></button>';
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