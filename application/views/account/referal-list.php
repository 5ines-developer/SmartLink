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

<body>
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
                                <h6 class="referal-list-title">List of Referal Detail
                            </div>
                            <table class="striped" id="referal-list">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Reward Points</th>
                                        <th>Expiry Date</th>
                                        <th>Actions <a class='tooltipped' data-position='bottom' data-tooltip='<?php echo wordwrap("You can edit or delete the friend list within 10 Min", 40, "<br>", true); ?>'><i class='far fa-question-circle'></i></a></th>
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
                                              <a class='tooltipped' data-position='right' data-tooltip='<?php echo wordwrap($value->referee_failed_reason, 40, "<br>", true); ?>'><i class='far fa-question-circle'></i></a>
                                        <?php }?></td>
                                        <td><?php echo (!empty($value->reward_points))?$value->reward_points:'---'; ?></td>
                                        <td><?php echo (!empty($value->reward_expiry_date) && $value->reward_expiry_date !='0000-00-00')?$value->reward_expiry_date:'---'; ?></td>
                                        <td>

                                            <?php 
                                            $now = strtotime(date("Y-m-d H:i:s"));
                                            $status_date = strtotime($value->referee_addedon);
                                            $x = date($now-$status_date);
                                            $dif =  ($x/60);
                                            echo  ($dif <= '10') ? '<a class="reedit blue-text modal-trigger" href="'.base_url().'refer-a-friend/edit/'.$value->uniq.'"><i class="material-icons dp48">edit</i></a>&nbsp;&nbsp;<a class="redelete red-text" href="'.base_url().'refer-a-friend/delete/'.$value->uniq.'"><i class="material-icons dp48">delete</i></a>': '<a class="reedit grey-text"><i class="material-icons dp48">edit</i></a>&nbsp;&nbsp;<a class="redelete grey-text"><i class="material-icons dp48">delete</i></a>' ;
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

</body>

</html>