        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                 <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    <span class="fa fa-user" style="font-size: 20px;"></span> Account
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url() ?>profile"> Profile</a></li>
                    <li>
                      <a href="<?php echo base_url() ?>change-password">
                        <span>Change Password</span>
                      </a>
                    </li>
                    <li><a href="<?php echo base_url() ?>logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <?php if (!empty($alert)) { ?>
                    <span class="badge bg-green"> <?php echo (!empty($alert))?count($alert):''; ?> </span>
                    <?php } ?>
                  </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                          <?php
          $status='1';
          $i = 1;
          if (!empty($alert)) {
            
            foreach ($alert as $key => $value) {?>
                    <li>
                      <a href="<?php echo base_url('noti-view/').$value->thing_id.'/'.$value->notification_type.'/'.$value->uniq ?>">
                          <span><b><?php echo ucfirst($value->notification_subject) ?></b></span>
                          <span class="time"><?php echo $value->added_on ?></span>
                        </span>
                        <span class="message"><?php echo $value->notification_description ?>
                        </span>
                      </a>
                    </li>
                  <?php if ($i++ == 5) break; }}?>
                   <li>

                  <div class="text-center">
                        <a href="<?php echo base_url('all-notification')?>">
                          <strong>See All Notification</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>

                  </ul>
                
              </ul>
            </nav>
          </div>
        </div>
