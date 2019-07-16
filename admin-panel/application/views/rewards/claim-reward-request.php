<?php
  $this->ci =& get_instance();
  $this->ci->load->model('referal_model');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url()?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url()?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url()?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url()?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url()?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url()?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url()?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url()?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url()?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url()?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <style>
    p{font-size: 12px;}
    .banner-button{float: right;}
    </style>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php $this->load->view('includes/header.php'); ?>
        <?php $this->load->view('includes/sidebar.php'); ?>
        
        
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php if ($this->session->flashdata('success')) { ?>
                  <div class="col-sm-12 ">
                    <div class="alert alert-success" role="alert" id="message1">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                      <p><strong>Success! </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('success') ?></span></p>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($this->session->flashdata('error')) { ?>
                  <div class="col-sm-12 ">
                    <div class="alert alert-danger" role="alert" id="message1">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                      <p><strong>Error! </strong>&nbsp;&nbsp;<span><?php echo $this->session->flashdata('error') ?></span></p>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="x_title">
                    <h2>Reward Points Claim Request</h2>
                    <div class="banner-button">
                      <ul class="referal-filter">
                        <li class="dropdown">
                          <a class="referal-filter-button" href="#"><i class="fa fa-filter" aria-hidden="true"></i></a>
                          <ul class="dropdown-menu filter-menu">
                            <li><a class="refer-filter" href="<?php echo base_url() ?>manage-reward-claims"  >All</a></li>
                            <li><a class="refer-filter" href="<?php echo base_url() ?>manage-reward-claims?filter=approved" >Approved</a></li>
                            <li><a class="refer-filter" href="<?php echo base_url() ?>manage-reward-claims?filter=rejected" >Rejected</a></li>
                            <li><a class="refer-filter" href="<?php echo base_url() ?>manage-reward-claims?filter=pending" >Pending</a></li>
                          </ul>
                        </li>
                      </ul>
                      
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="loderbox">
                <div class="text-center">
                    <div class="spinner">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>
                </div>
            </div>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Sl No.</th>
                          <th>Claimed By </th>
                          <th>Points</th>
                          <th>Status</th>
                          <th>Claimed On</th>
                          <th>Operations</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  $cont = 0; if (!empty($claim))
                        {
                        foreach ($claim as $key => $value) {$cont = $cont + 1;?>
                          <tr>
                          <td><?php echo (!empty($claim))?$cont:'' ?></td>
                          <td><?php echo (!empty($value->agent_name))?$value->agent_name:''  ?></td>
                          <td><?php echo (!empty($value->claimed_points))?$value->claimed_points:''  ?></td>
                          <td class="<?php echo 'refre_status'.$value->claim_status?>"><?php if ($value->claim_status == '1') {
                            echo 'Approved';
                          }else if ($value->claim_status == '2') {
                            echo 'Rejected';
                          }else{
                            echo 'Pending';
                          } ?></td>
                          <td><?php echo (!empty($value->claimed_on))?date("d-M-y h:i:s", strtotime($value->claimed_on)):''; ?></td>
                          <td style="text-align:center;"><a href="<?php echo base_url('view-reward-claims/').$value->uniq?>" style="font-size: 22px;color: #2e9be0"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;&nbsp;
                          <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('delete-reward-claims/').$value->uniq?>" style="font-size: 22px;color: #e9160fe6" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                      </tr>
                      <?php } }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- /page content -->
      <!-- footer content -->
      <?php $this->load->view('includes/footer.php'); ?>
      <!-- /footer content -->
    </div>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url()?>assets/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url()?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url()?>assets/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="<?php echo base_url()?>assets/vendors/nprogress/nprogress.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url()?>assets/vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="<?php echo base_url()?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/jszip/dist/jszip.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url()?>assets/build/js/custom.min.js"></script>
  <script>
  $(document).ready(function () {
  $('#message1').toggleClass('in');
  setTimeout(function(){$('.alert').fadeOut(3000)},4000);
  $(".dropdown").click(function(){
  $(this).find(".dropdown-menu.filter-menu").slideToggle("fast");
  });
  });
  </script>

 

</body>
</html>