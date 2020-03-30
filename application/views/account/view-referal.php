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
     <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/assets/stylesheet/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/style.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>

    <style>
        .agent-profile-table th {
    width: 130px; }
    </style>
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
                                <h6 class="agent-edit-title-cn">Referral detail </div>
                            <div class="agent-profile-table">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Name </th>
                                            <td><?php echo (!empty($refer['referee_name']))?': '.$refer['referee_name']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email </th>
                                            <td><?php echo (!empty($refer['refree_email']))?': '.$refer['refree_email']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Phone </th>
                                            <td><?php echo (!empty($refer['referee_phone']))?': '.$refer['referee_phone']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Company Name</th>
                                            <td><?php echo (!empty($refer['refree_company']))?': '.$refer['refree_company']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Location </th>
                                            <td><?php echo (!empty($refer['referee_location']))?': '.$refer['referee_location']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Area </th>
                                            <td><?php echo (!empty($refer['refree_area']))?': '.$refer['refree_area']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Category </th>
                                            <td><?php echo (!empty($refer['product']))?': '.$refer['product']:': ---' ; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>User Type </th>
                                            <td><?php echo (!empty($refer['customer_type']))?': '.$refer['customer_type']:': ---' ; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Service </th>
                                            <?php  if ($refer['product'] == 'it' || $refer['product'] == 'IT') { ?>
                                                <td><?php echo (!empty($refer['it_type']))?': '.$refer['it_type']:': ---' ; ?> </td>

                                            <?php }else{ ?>
                                                <td><?php  $service = $this->ci->m_account->getsrvice($refer['sub_product']); echo (!empty($service))?': '.$service:': ---'   ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>Description </th>
                                            <td><?php echo(!empty($refer['description']))?':'.$refer['description']:': ---' ; ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
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
    });
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