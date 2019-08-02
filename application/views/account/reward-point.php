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

<body >
        <?php  $this->load->view('includes/header');?>
        <section class="agent-profile">
            <div class="container-wrap3">
                <div class="row mb-0">
                    <!-- sidebar -->
                    <?php $this->load->view('includes/agent-sidebar.php'); ?>
                    <!-- side bar end -->
                    <div class="col  l9 m12  s12">
                        <div class="card agent-profile-right">
                            <div class="card-content agent-right-content">
                                <div class="agent-edit-title">
                                    <h6 class="agent-edit-title-cn">Reward Points</h6>
                                </div>
                                <div class="reward-detail">
                                    <div class="row">
                                        <div class="col xl5 m6 s12 l6">
                                            <div class="dashboard-reward" id="process-refer">
                                                <i class="fas fa-thumbs-up icon-reward"></i>
                                                <h5 class="m0 head-reward"><?php echo (!empty($reward['avil_reward_point']))?$reward['avil_reward_point']-$reward['temp_claimed']:'0' ; ?></h5>
                                                <p class="para-reward">Unclaimed Rewards Points</p>
                                            </div>
                                        </div>
                                        <div class="col xl5 m6 s12 l6">
                                            <div class="dashboard-reward" id="completed-refer">
                                                <i class="fas fa-thumbs-down icon-reward"></i>
                                                <h5 class="m0 head-reward"><?php echo (!empty($reward['avil_reward_point']))?$reward['claimed_points']+$reward['temp_claimed']:'0' ?></h5>
                                                <p class="para-reward">Claimed Rewards Points</p>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col xl6">
                                            <div class="claim-point">
                                                <h6 class="title-claim">Claim Rewards Point</h6>
                                                <form action="<?php echo base_url() ?>claim-points" method="post" id="signup-form">
                                                    <div class="input-field ">
                                                        <input placeholder="Enter reward point" name="reward"
                                                            id="reward" type="text" required>
                                                        <label for="reward" class="black-text">Enter reward point</label>
                                                        <input name="tot_reward" id="tot_reward" type="hidden" value="<?php echo (!empty($reward['avil_reward_point']))?$reward['avil_reward_point']:'' ?>">
                                                        <span class="helper-text"><strong>Note : </strong>Min 100 - Max 1000 You can claim</span>

                                                            <input  name="unclaimed" id="unclaimed" type="hidden" value="<?php echo (!empty($reward['avil_reward_point']))?$reward['avil_reward_point']-$reward['temp_claimed']:'' ?>">
                                                            <input  name="uniq" id="uniq" type="hidden"  value="<?php echo  random_string('alnum','10') ?>">
                                                            <p id="paswrd-error" class="error required"></p>
                                                    </div>
                                                    <button type="submit" class="btn register-formbutton" value="submit" name="submit"
                                                        id="process-claim">Claim</button>
                                                </form>
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
    <!-- Javascript -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/script.js"></script>
    <script src="<?php echo base_url() ?>assets/javascript/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function() {

        $("#process-claim").click(function () {

            var total_reward = $('#tot_reward').val();
            var unclaimed = $('#unclaimed').val();
            var reward = $("input[name=reward]").val();


            if (reward <= unclaimed) {
                $( "#signup-form" ).submit();
            } else{
                $("#paswrd-error>span").remove();
                $("#paswrd-error").append("<span>Please enter a reward point which is less than available points</span>");
                return false;

            }         

            });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#signup-form").validate({
            rules: {
                reward: {
                    required: true,
                    number: true,
                    min: 100,
                    max :1000
                },
            },
            messages: {
                reward: {
                    required: "Please enter the reward point that you want to claim",
                    number: "Please enter a valid reward points",
                    min: "Please enter reward points more than 100",
                    max: "Maximum you can claim 1000 reward points",
                },
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