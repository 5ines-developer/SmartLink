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
                                <h6 class="agent-edit-title-cn">List of Claim</h6>
                            </div>
                            <div class="claim-detail">
                                <div class="row">
                                    <div class="col xl12 l12 m12 s12">
                                        <table class="striped claim-table" id="">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Claimed Point</th>
                                                    <th>Status</th>
                                                    <th>Smart Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($claim) {
                                                  foreach ($claim as $key => $value) { ?>
                                                <tr>
                                                    <td><?php echo  $value->claimed_on ?></td>
                                                    <td><?php echo  $value->claimed_points ?></td>
                                                    <td><?php 
                                                if ($value->claim_status == '1') {
                                                    echo 'Success';
                                                }elseif ($value->claim_status == '2') {
                                                    echo 'Rejected';
                                                }else{
                                                    echo 'Process';
                                                }?></td>
                                                    <td class="show-smart"><?php 
                                                if ($value->claim_status == '1' && !empty($value->coupon_code)) { ?>
                                                        <a class="view-code modal-trigger"
                                                            id="<?php echo $value->claim_id ?>" href=".smartcode">View
                                                            Code</a>
                                                        <?php }else{ 
                                                    echo '-------';
                                                     }?></td>
                                                </tr>
                                                <?php }} ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Structure -->
   
    <div id="smartcode" class="modal smartcode">
        <form id="code-view">
            <div class="modal-content mc-smartcode">
                <h4>Verify</h4>
                <p>To View Smart Code Please Enter the Below Detail</p>
                <div class="row">
                    <div class="col l12">
                        <div class="input-field">
                            <input class="" placeholder="Enter Your Mobile No. or Nick Name " id="name" name="name"
                                type="text" required="">
                            <label for="name" class="">Mobile No. or Nick Name</label>
                            <span class="error"><?php echo form_error('name'); ?></span>
                        </div>
                        <div class="input-field">
                            <input id="claimid" name="claimid" type="hidden">
                            <input class="" placeholder="Enter Your Password" id="password" name="password"
                                type="password" required="">
                            <label for="password" class="lable-claim">Password</label>
                            <span class="error"><?php echo form_error('password'); ?></span>
                            <p id="paswrd-error" class="error required"></p>
                        </div>
                        <div class="form-valdation-error">

                            <?php echo ($this->session->flashdata('error'))? '<span class="error">'.$this->session->flashdata('error').'</span>' : '' ?>

                        </div>
                        <button class="btn register-formbutton waves-light " value="submit" name="submit"
                            id="process-refer">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <!-- End Modal Structure -->
    <?php  $this->load->view('includes/footer');?>
    <!-- /.boxed -->
    <!-- Javascript -->
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
        $("#code-view").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },

                name: {
                    required: true,
                },

            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                name: "Please enter a valid Nick Name or Mobile No",
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {

                $(".view-code").click(function() {
                    var id = $(this).attr('id');
                    $("#claimid").val(id);
                });



                $("#code-view").on('submit', function(event) {
                        event.preventDefault();
                        var DataString = $("#code-view").serialize();
                        var btnid = $("#claimid").val();
                        $.ajax({
                                url: "<?php echo base_url();?>verify-credentials",
                                type: "Post",
                                dataType: "html",
                                data: DataString,
                                success: function(data) {
                                    console.log(data);
                                    if (data == 'wrong password') {
                                        $("#paswrd-error>span").remove();
                                        $("#paswrd-error").append("<span>Wrong password</span>");
                                    } else if (data != 'wrong password' && data != 'error' && data != '') {
                                        $('.modal').modal('close');;
                                        $("#" + btnid).after("<a class = 'view-code' > "+ data +"</a>");
                                        $("#" + btnid).remove(); 
                                        $('.modal-overlay').css('display', 'none');
                                        }else if (data == 'error'){
                                            $("#paswrd-error>span").remove();
                                            $("#paswrd-error").append("<span>Unable to process your request please try again, please enter the valid credentials</span>"
                                            );
                                        }
                                    }
                                });
                        });
                });
    </script>


</body>

</html>