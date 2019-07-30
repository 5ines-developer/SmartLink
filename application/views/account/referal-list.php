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
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>
</head>

<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}
.tooltip  i{
    font-size: 15px;
    position: relative;
    top: 4px;
    color: #29bdca;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 4px;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  left: -35px;
    top: 20px;
    font-size: 12px;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>

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
                        <div class="card-content agent-right-content of-table">
                            <div class="agent-edit-title">
                                <h6 class="referal-list-title">List of Referal Detail
                            </div>
                            <table class="striped" id="referal-list">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Reward Points</th>
                                        <th>Expiry Date</th>
                                        <th>Actions 
                                        <div class="tooltip"> <i class="material-icons">info_outline</i>
                                                <span class="tooltiptext"><?php echo wordwrap("You can edit or delete the friend list within 10 Min", 40, "<br>", true); ?></span>
                                        </div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($referal)) {
                                       foreach ($referal as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo (!empty($value->referee_name))?$value->referee_name:''; ?></td>
                                        <td class="<?php if ($value->referee_status == '1') {
                                            echo "green-text";
                                        }else if ($value->referee_status == '0') {
                                             echo "blue-text";
                                        }else if ($value->referee_status == '2') {
                                             echo "red-text";
                                        }?>  "><?php if ($value->referee_status == '1') {
                                            echo "Success";
                                        }else if ($value->referee_status == '0') {
                                             echo "Process";
                                        }else if ($value->referee_status == '2') { ?>
                                             <?php echo "Failed"; ?>
                                             <div class="tooltip"> <i class="material-icons">info_outline</i>
                                                <span class="tooltiptext"><?php echo wordwrap($value->referee_failed_reason, 40, "<br>", true); ?></span>
                                        </div>
                                        <?php }?></td>
                                        <td><?php echo (!empty($value->reward_points))?$value->reward_points:'---'; ?></td>
                                        <td><?php echo (!empty($value->reward_expiry_date) && $value->reward_expiry_date !='0000-00-00')?$value->reward_expiry_date:'---'; ?></td>
                                        <td>

                                            <?php 
                                            $now = strtotime(date("Y-m-d H:i:s"));
                                            $status_date = strtotime($value->referee_addedon);
                                            $x = date($now-$status_date);
                                            $dif =  ($x/60);
                                            echo  ($dif <= '10') ? '<a class="reedit blue-text modal-trigger" href="'.base_url().'refer-a-friend/edit/'.$value->uniq.'"><i class="material-icons dp48">edit</i></a>&nbsp;&nbsp;<a class="redelete red-text exdelete" href="'.base_url().'refer-a-friend/delete/'.$value->uniq.'"><i class="material-icons dp48">delete</i></a>': '<a class="reedit grey-text"><i class="material-icons dp48">edit</i></a>&nbsp;&nbsp;<a class="redelete grey-text"><i class="material-icons dp48">delete</i></a>' ;
                                            ?>
                                            </td>
                                    </tr>
                                    <?php   } } ?>
                                </tbody>
                            </table>

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
    <script> $(document).ready(function(){
    $('.tooltipped').tooltip();
    $('.modal').modal()
  });</script>
  <script>
      $(document).ready(function(){
        $(".exdelete").click(function(){
                if (!confirm("Are you sure you want to delete this item?")){
                  return false;
                }
           });
      })
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