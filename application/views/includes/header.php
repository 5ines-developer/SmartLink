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
    <nav class="grey lighten-4" id="secondnavbar">
        <div class="nav-wrapper container-wrap2 ">
            <a href="#!" class="brand-logo"><img src="<?php echo base_url()?>assets/images/logo.png" alt=""></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="sass.html">About Us</a></li>
                <li><a href="badges.html">Team</a></li>
                <li><a href="collapsible.html">Mission & Vision</a></li>
                <li><a href="mobile.html">Product & Service</a></li>
                <li><a class="register-nav" href="<?php echo base_url () ?>register">Register</a></li>
                <li><a href="<?php echo base_url () ?>login">login</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="sass.html">About Us</a></li>
        <li><a href="badges.html">Team</a></li>
        <li><a href="collapsible.html">Mission & Vision</a></li>
        <li><a href="mobile.html">Product & Service</a></li>
        <li><a href="mobile.html">Refer & Earn</a></li>
        <li><a href="<?php echo base_url () ?>register">Register</a></li>
        <li><a href="<?php echo base_url () ?>login">Log in</a></li>
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
                    <?php   }} ?>

                    <li class="divider"></li>
                    <li><a class="center-align see-all" href="#!">See All</a></li>
                </ul>
                <!-- <li><a href="<?php echo base_url () ?>register"><i class="material-icons dp48">notifications_none</i><span class="notibadge bg-red"> 3 </span></a></li> -->
                <li><a href="<?php echo base_url () ?>logout">logout <i class="fas fa-sign-out-alt"></i></a></li>


            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="sass.html">About Us</a></li>
        <li><a href="badges.html">Team</a></li>
        <li><a href="collapsible.html">Mission & Vision</a></li>
        <li><a href="mobile.html">Product & Service</a></li>
        <li><a href="mobile.html">Refer & Earn</a></li>
        <li><a href="<?php echo base_url () ?>register">Register</a></li>
        <li><a href="<?php echo base_url () ?>login">Log in</a></li>
    </ul>

    <?php } ?>


    <div class="hederHight"></div>
</header>