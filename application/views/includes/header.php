<header id="navbar">
    <!-- <nav class="transparent z-depth-0 hide-on-med-and-down" id="topbar">
            <div class="nav-wrapper container-wrap2">
                <a class="top-email" href="mailto:infosmartlink@gmail.com">infosmartlink@gmail.com</a>
                <a class="top-number" href="tel:+91 000-000-0000"> +91 000-000-0000</a>
                <ul class="right hide-on-med-and-down">
                    <li><a class="register-nav" href="sass.html">Register</a></li>
                    <li><a href="badges.html"> login</a></li>
                </ul>
            </div>
        </nav> -->


    <?php  if ($this->session->userdata('sid') == '') { ?>
    <nav class="white z-depth-1" id="secondnavbar">
            <div class="nav-wrapper container-wrap2 ">
            <a href="<?php echo base_url () ?>index" class="brand-logo"><img src="<?php echo base_url()?>assets/images/logo1.jpg" class="img-responsive logo-wi" alt=""></a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <!-- <a href="http://5ineprojects.com/smartlink/html/" class="brand-logo"><img src="<?php echo base_url()?>assets/images/logo.png" alt=""></a> -->
            <!-- <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a> -->
            <ul class="right hide-on-med-and-down">
                    <li><a href="<?php echo base_url () ?>#about">About Us</a></li>
                    <li><a href="<?php echo base_url () ?>#product">Product & Service</a></li>
                    <li><a href="<?php echo base_url () ?>#refer">Refer & Earn</a></li>
                <li><a class="" href="<?php echo base_url () ?>register">Sign Up</a></li>
                <li><a href="<?php echo base_url () ?>login">Sign In</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
       <li><a href="<?php echo base_url () ?>#about">About Us</a></li>
                    <li><a href="<?php echo base_url () ?>#product">Product & Service</a></li>
                    <li><a href="<?php echo base_url () ?>#refer">Refer & Earn</a></li>
        <li><a href="<?php echo base_url () ?>register">Sign Up</a></li>
        <li><a href="<?php echo base_url () ?>login">Login</a></li>
    </ul>
    <?php }else{ ?>
    <nav class="white" id="secondnavbar">
        <div class="nav-wrapper container-wrap2 ">
            <a href="#!" class="brand-logo"><img src="<?php echo base_url()?>assets/images/logo.png" alt=""></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="sass.html"><i class="material-icons dp48 left">account_circle</i>Profile</a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                            class="material-icons dp48">notifications_none</i>
                        <?php if (!empty($alert)) { ?>
                        <span class="notibadge bg-red"><?php echo (!empty($alert))?count($alert):''; ?> </span>
                        <?php } ?>
                    </a></li>
                <ul id="dropdown1" class="dropdown-content">
                    <?php
                    $status='1';
                    $i = 1;
                    if (!empty($alert)) {
                    foreach ($alert as $key => $value) {?>
                    <li><a
                            href="<?php echo base_url('noti-view/').$value->thing_id.'/'.$value->notification_type.'/'.$value->uniq ?>">
                            <span><?php echo ucfirst($value->notification_subject) ?></span>
                            <span class="right time"><?php echo date("d-M-y", strtotime($value->added_on)) ?></span>
                        </a></li>
                    <?php  if ($i++ == 5) break; }} ?>

                    <li class="divider"></li>
                    <li><a class="center-align see-all" href="<?php echo base_url('notifications')?>">See All</a></li>
                </ul>
                <!-- <li><a href="<?php echo base_url () ?>register"><i class="material-icons dp48">notifications_none</i><span class="notibadge bg-red"> 3 </span></a></li> -->
                <li><a href="<?php echo base_url () ?>logout">Logout <i class="fas fa-sign-out-alt"></i></a></li>


            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
    <li><a class="waves-effect <?php if($this->uri->segment(1)=="dashboard"){echo "active";}?>" href="<?php echo base_url('dashboard')?>">Dashboard</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="account"){echo "active";}?>  " href="<?php echo base_url('account')?>">Profile</a>
                                </li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="change-password"){echo "active";}?>" href="<?php echo base_url('change-password')?>">Change Password</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="refer-a-friend"){echo "active";}?>" href="<?php echo base_url('refer-a-friend')?>">Refer a friend</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="reward-points"){echo "active";}?>" href="<?php echo base_url('reward-points')?>">Reward Points</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="referal-list"){echo "active";}?>" href="<?php echo base_url('referal-list')?>">List of Referrals</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="claim-list"){echo "active";}?>" href="<?php echo base_url('claim-list')?>">List of Claims</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="notifications"){echo "active";}?>" href="<?php echo base_url('notifications')?>">Notifications<?php if (!empty($alert)) { ?>
                        <span class="notibadge bg-red"><?php echo (!empty($alert))?count($alert):''; ?> </span>
                        <?php } ?></a></li>
                        <li><a href="<?php echo base_url () ?>logout">Logout </a></li>
    </ul>

    <?php } ?>


 <!--    <div class="hederHight h84"></div> -->
</header>