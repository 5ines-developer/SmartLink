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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/stylesheet/style.css">
    <link href="//fonts.googleapis.com/css?family=Muli:400,600,700,800,900" rel="stylesheet" async defer>

</head>

<body>
        <?php $this->load->view('includes/header');?>
        <section class="agent-profile">
            <div class="container-wrap3">
                <div class="row mb-0">
                    <!-- sidebar -->

                    <?php $this->load->view('includes/agent-sidebar.php');?>

                    <!-- side bar end -->
                    <div class="col  l9 m8 s12">
                        <div class="card agent-profile-right">
                            <div class="card-content agent-right-content">
                                <div class="agent-edit-title">
                                    <h6 class="agent-edit-title-cn">Notifications</h6>
                                </div>
                                <div class="notification-detail">
                                    <div class="row">
                                        <div class="col l12">
                                        <?php $cont = 0;if (!empty($noti)) {
                                        foreach ($noti as $key => $value) {$cont = $cont + 1;?>
                                            <div class="title-noti<?php if($value->notification_seen == '1'){echo '-see'; } ?>">
                                                <a href="<?php echo base_url('noti-view/').$value->thing_id.'/'.$value->notification_type.'/'.$value->uniq ?>">
                                                    <p class="spn-lef "><?php echo (!empty($value->notification_subject))?ucfirst($value->notification_subject):''  ?>
                                                        <span class="ss-date"><?php echo date("d-M-y", strtotime($value->added_on)) ?></span>
                                                    </p>
                                                    <p class="noti-li "><?php echo (!empty($value->notification_description))?$value->notification_description:''  ?></p>
                                                </a>
                                            </div>
                                            <?php }}?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $this->load->view('includes/footer');?>
  <!-- /.boxed -->
    <!-- Javascript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
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