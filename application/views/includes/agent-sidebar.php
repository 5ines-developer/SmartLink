<div class="col l3 m4 s12 hide-on-med-and-down">
                    <div class="card" id="agent-sidebar">
                        <div class="card-content">
                            <ul class="agent-profile-sidebar">
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="dashboard"){echo "active";}?>" href="<?php echo base_url('dashboard')?>">Dashboard</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="account"){echo "active";}?>  " href="<?php echo base_url('account')?>">Profile</a>
                                </li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="change-password"){echo "active";}?>" href="<?php echo base_url('change-password')?>">Change Password</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="refer-a-friend"){echo "active";}?>" href="<?php echo base_url('refer-a-friend')?>">Refer a friend</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="reward-points"){echo "active";}?>" href="<?php echo base_url('reward-points')?>">Reward Points</a></li>
                                <li><a class="waves-effect <?php if(($this->uri->segment(1)=="referal-list") || ($this->uri->segment(1)=="referrals")){echo "active";}?>" href="<?php echo base_url('referal-list')?>">List of Referrals</a></li>
                                <li><a class="waves-effect <?php if($this->uri->segment(1)=="claim-list"){echo "active";}?>" href="<?php echo base_url('claim-list')?>">List of Claims</a></li>
                            </ul>
                        </div>
                    </div>
                </div>