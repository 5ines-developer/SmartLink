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
</head>

<body>
    <?php $this->load->view('includes/header.php'); ?>

    <section class="agent-profile">
        <div class="container-wrap3">
            <div class="row mb-0">

                <!-- sidebar -->

                <?php $this->load->view('includes/agent-sidebar.php'); ?>

                <!-- side bar end -->
                
                <div class="col  l9 offset-m2 m8 s12">
                    <div class="card agent-profile-right">
                        <div class="card-content agent-right-content">
                            <div class="agent-edit-title">
                                <h6 class="agent-edit-title-cn">Profile Detail
                                    <a class="btn-floating waves-effect waves-light  agent-edit right modal-trigger"
                                        href="#agent-edit"><i class="material-icons dp48">edit</i></a></h6>

                            </div>
                            <div class="agent-profile-table">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Name </th>
                                            <td><b>: </b> <?php echo(!empty($profile['agent_name']))?$profile['agent_name']:'' ; ?>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Phone </th>
                                            <td><b>: </b> <?php echo(!empty($profile['agent_phone']))?$profile['agent_phone']:'' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Employee Reference Code </th>
                                            <td><b>: </b> <?php echo(!empty($profile['employee_reference_id']))?$profile['employee_reference_id']:'' ; ?>
                                            </td>
                                        </tr> 
                                        <!-- <tr>
                                            <th class="pt-15">Address :</th>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col l6 m12 s12">
                                <p class="ag-pf-adrs">
                                    <?php echo(!empty($profile['agent_address']))?$profile['agent_address']:'' ; ?></p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- edit form -->
    <!-- Modal Structure -->
    <div class="col l7 m12 s12">
        <div id="agent-edit" class="modal">
            <div class="modal-content">
                <div class="row mb-0">
                    <form action="<?php echo base_url('account-setting') ?>" method="post" class="col l12 m12 s12"
                        id="edit-form">
                        <div class="row mb-0">
                            <div class="input-field col s12">
                                <input placeholder="Name" id="first_name" name="name" type="text" required value="<?php echo(!empty($profile['agent_name']))?$profile['agent_name']:'' ; ?>">
                                <label for="first_name">Name <span class="error">*</span></label>
                                <span class="error"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>
                        <!-- <div class="row mb-0">
                            <div class="input-field col s12">
                                <input placeholder="Email" id="Email" name="email" type="email" value="<?php echo(!empty($profile['agent_email']))?$profile['agent_email']:'' ; ?>">
                                <label for="Email">Email</label>
                            </div>
                        </div> -->


                        <div class="row mb-0">
                            <div class="input-field col s12">
                                <input placeholder="Phone" id="Phone" type="text" name="phone" required value="<?php echo(!empty($profile['agent_phone']))?$profile['agent_phone']:'' ; ?>" readonly="true">
                                <label for="Phone">Phone </label>
                                <span class="error"><?php echo form_error('phone'); ?></span>
                            </div>
                        </div>
                        <!-- <div class="row mb-0">
                            <div class="input-field col s12">
                                <textarea placeholder="Address" id="textarea1" name="address"
                                    class="materialize-textarea"><?php echo(!empty($profile['agent_address']))?$profile['agent_address']:'' ; ?></textarea>
                                <label for="textarea1">Address</label>
                            </div>
                        </div> -->
                        <button class="btn  right register-formbutton" value="submit" name="submit">Submit</button>
                        <a class="modal-close  right waves-effect waves-green btn-flat">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php $this->load->view('includes/footer.php'); ?>
    <!-- javascript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.modal').modal();
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#edit-form").validate({
            rules: {
                name: {
                    required: true,
                    name: true
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
                name: "Please enter a valid Nick Name",
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
            displayLength:4000,
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