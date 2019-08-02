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
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!--Import Google Icon Font-->
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/stylesheet/style.css">
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
                <div class="col  l9 offset-m2 m8 s12">
                    <div class="card agent-profile-right">
                        <div class="card-content agent-right-content">
                            <div class="agent-edit-title">
                                <h6 class="agent-edit-title-cn">Dashboard
                            </div>
                            <div class="dashboard-detail">
                                <div class="row">
                                    <div class="col xl4 m6 s12 l6">
                                        <div class="dashboard-list" id="process-refer">
                                            <i class="fas fa-sync icon-dash"></i>
                                            <h5 class="m0"><?php echo (!empty($referal))?$referal:'0'; ?></h5>
                                            <p>Total no of Referral</p>
                                        </div>
                                    </div>
                                    <div class="col xl4 m6 s12 l6">
                                        <div class=" dashboard-list" id="completed-refer">
                                            <i class="fas fa-thumbs-up icon-dash"></i>
                                            <h5 class="m0"><?php echo (!empty($approved))?$approved:'0'; ?></h5>
                                            <p>Reference Completed</p>
                                        </div>
                                    </div>
                                    <div class="col xl4 m6 s12 l6">
                                        <div class=" dashboard-list" id="pending-refer">
                                            <i class="fas fa-thumbs-down icon-dash"></i>
                                            <h5 class="m0"><?php echo (!empty($pending))?$pending:'0'; ?></h5>
                                            <p>Reference Pending</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m0">
                                    <div class="col l12 m12 s12 xl6">
                                        <div class="dashboard-ref">
                                            <div class="row">
                                                <div class="col l3 m2 s3">
                                                    <span class="m0 count-ref"><?php echo (!empty($reward['avil_reward_point']))?$reward['avil_reward_point']-$reward['temp_claimed']:'0' ; ?></span>
                                                </div>
                                                <div class="col l9 m10 s9">
                                                    <span class="title-ref">Total Unclaimed Reward Point</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col l12 m12 s12 xl6">
                                        <div class="dashboard-ref">
                                            <div class="row">
                                                <div class="col l3 m2 s3">
                                                    <span class="m0 count-ref"><?php echo (!empty($reward['avil_reward_point']))?$reward['claimed_points']+$reward['temp_claimed']:'0' ?></span>
                                                </div>
                                                <div class="col l9 m10 s9">
                                                    <span class="title-ref">Total Claimed Reward Point</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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