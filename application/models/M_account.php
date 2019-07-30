<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_account extends CI_Model
{

    // get profile detail
    public function profileGet($uid)
    {
        return $this->db->where('agent_id', $uid)->get('agent')->row_array();
    }

    //  update profile
    public function updateProfile($insert, $uid)
    {
        $this->db->where('agent_id', $uid)->update('agent', $insert);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // check pasw
    public function checkpsw($psw)
    {
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $result = $this->getUsers($psw);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    // check password
    public function getUsers($password)
    {
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if ($this->bcrypt->check_password($password, $result['agent_password'])) {
                return $result;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    // change password
    public function changePassword($datas, $uid, $opsw)
    {
        $this->db->where('agent_id', $uid)->update('agent', $datas);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function product($value = '')
    {
        return $this->db->get('product')->result();
    }

    /**
     * insert a refer a friend details
     **/
    public function insert_referrals($insert)
    {

        $this->db->where('uniq', $insert['uniq']);
        $query = $this->db->get('referral');
        if ($query->num_rows() > 0) {
            $this->db->where('uniq', $insert['uniq']);
            return $this->db->update('referral', $insert);
        } else {
            return $this->db->insert('referral', $insert);
        }
    }

    public function edit_refer($id)
    {
        $this->db->where('uniq', $id);
        $this->db->where('agent_id',$this->session->userdata('sid'));
        $query = $this->db->get('referral');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }

    }

    public function delete_refer($id='')
    {
        $this->db->where('uniq', $id);
        $this->db->where('agent_id',$this->session->userdata('sid'));
        return $this->db->update('referral',array('is_deleted' => '1'));
    }

    


    // phone check
    public function phone_check($phone)
    {
        $this->db->where('agent_id', $this->session->userdata('sid'))->where('agent_phone', $phone);
        $query = $this->db->get('agent');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * insert a notification
     **/
    public function insert_notification($notification)
    {
        
        $this->db->where('thing_id', $notification['thing_id']);
        $this->db->where('uniq', $notification['uniq']);
        $this->db->where('noti_to_type', 'admin');
        $this->db->where('notification_type', '1');
        $this->db->where('added_by_type', 'agent');
        $query = $this->db->get('notification');
        if ($query->num_rows() > 0) {
            $this->db->where('thing_id', $notification['thing_id']);
            $this->db->where('uniq', $notification['uniq']);
            $this->db->where('noti_to_type', 'admin');
            $this->db->where('notification_type', '1');
            $this->db->where('added_by_type', 'agent');
            $this->db->where('uniq', $notification['uniq']);
            return $this->db->update('notification', $notification);
        } else {
            return $this->db->insert('notification', $notification);
        }
    }

    // get notification
    public function get_noti($id = null)
    {
        $this->db->where('noti_to', $this->session->userdata('sid'));
        $this->db->where('noti_to_type', 'agent');
        $this->db->where('notification_seen ', '0');
        $this->db->order_by('added_on', 'desc');
        return $this->db->get('notification')->result();
    }

    //update if notification seen
    public function noti_seen($uniq = null)
    {
        $this->db->where('notification_seen ', '0');
        $this->db->where('uniq ', $uniq);
        $this->db->update('notification', array('notification_seen' => '1'));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get all notification
    public function all_noti($id=null)
    {
        $this->db->where('noti_to', $this->session->userdata('sid'));
        $this->db->where('noti_to_type', 'agent');
        $this->db->order_by('added_on', 'desc');
        return $this->db->get('notification')->result();
    }

    // referal list
    public function referal_list($refid =null )
    {
        if ($refid !='') {
            $this->db->where('uniq', $refid);
        }
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $this->db->where('is_deleted','0');
        $query = $this->db->get('referral');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function reward_point($var = null)
    {
        
        $this->db->select('SUM(reward_points) AS reward_points FROM referral');        
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $this->db->where('referee_status', '1');
        $this->db->where('reward_expiry_date >=', date('Y-m-d'));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key => $value) {
            }
            return $value->reward_points;
        } else {
            return false;
        }
    }

    

    public function claimed_point($var = null)
    {        
        $status = array(0, 1);
        $this->db->select('SUM(claimed_points) AS claimed_points FROM claim_reward ');        
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $this->db->where_in('claim_status', $status);
        $this->db->or_where_in('return_reward','2');
            $this->db->or_where_in('claimed_points','2');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $value) {
            }
            
            return $value->claimed_points;
        } else {
            return false;
        }
    }

     /**
     * insert reward claim request
     **/
    public function insert_claimrequest($insert)
    {
        $this->db->where('uniq', $insert['uniq']);
        $query = $this->db->get('claim_reward');
        if ($query->num_rows() > 0) {
            $this->db->where('uniq', $insert['uniq']);
            return $this->db->update('claim_reward', $insert);
        } else {
            return $this->db->insert('claim_reward', $insert);
        }
    }

        // claim list
        public function claim_list($refid =null )
        {
            if ($refid !='') {
                $this->db->where('uniq', $refid);
            }
            $this->db->where('agent_id', $this->session->userdata('sid'));
            $query = $this->db->get('claim_reward');
    
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }

        public function check_user($name = null)
        {
            $this->db->where('agent_id', $this->session->userdata('sid'));
            $this->db->group_start();
                $this->db->where('agent_phone', $name);
                $this->db->or_where('agent_name', $name);
            $this->db->group_end();
            $query = $this->db->get('agent');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function coupon($claimid)
        {
            $this->db->select('coupon_code');
            $this->db->where('agent_id', $this->session->userdata('sid'));
            $this->db->where('claim_id', $claimid);
            $query = $this->db->get('claim_reward')->row_array();
            return $query['coupon_code'];

        }

     // forgot password
    public function forgotPassword($mobile,$otp,$country_code)
    {
        $this->db->where('agent_phone', $mobile);
        $this->db->where('agent_country_code',$country_code);
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $this->db->update('agent',array('otp'=>$otp,'otp_check_count'=>'0'));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }  
    }

        public function rewrd_val($itemid)
        {
            $this->db->select('reward_points');
            $this->db->where('agent_id', $this->session->userdata('sid'));
            $this->db->where('uniq', $itemid);
            $this->db->where('referee_status', '1');
            $query = $this->db->get('referral')->row_array();
            return $query['reward_points'];

        }

       public function notidet($itemid)
        {
            $this->db->select('uniq');
            $this->db->where('added_by', $this->session->userdata('sid'));
            $this->db->where('thing_id', $itemid);
            $this->db->where('added_by_type', 'agent');
            $this->db->where('noti_to_type', 'admin');
            $this->db->where('notification_type', '1');
            $query = $this->db->get('notification')->row_array();
            return $query['uniq'];
        }

    

    

}

/* End of file M_account.php */
