<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class M_account extends CI_Model {

    // get profile detail
    public function profileGet($uid)
    {
        return $this->db->where('agent_id', $uid)->get('agent')->row_array();
    }

    //  update profile
    public function updateProfile($insert, $uid)
    {
        $this->db->where('agent_id', $uid)->update('agent', $insert);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
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
        } 
        else {
           return false;
        } 
    }

    // check password
    function getUsers($password) {
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if ($this->bcrypt->check_password($password, $result['agent_password'])) {
                return $result;
            } 
            else {
                return array();
            }
        } 
        else{
            return array();
        }
    } 

    // change password
    public function changePassword($datas, $uid, $opsw)
    {
        $this->db->where('agent_id', $uid)->update('agent', $datas);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function product($value='')
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
            if ($query->num_rows() > 0) 
            {
                $this->db->where('uniq', $insert['uniq']);
                return $this->db->update('referral', $insert);
            }
            else
            {
                return $this->db->insert('referral',$insert);
            }
        }

    // phone check
    public function phone_check($phone)
    {
        $this->db->where('agent_id', $this->session->userdata('sid'))->where('agent_phone',$phone);  
        $query = $this->db->get('agent');
 
        if ($query->num_rows() > 0) {
           return true;
        } 
        else {
           return false;
        } 
    }

        /**
    * insert a notification
    **/
        public function insert_notification($notification)
        {
            $this->db->where('uniq', $notification['uniq']);
            $query = $this->db->get('notification');
            if ($query->num_rows() > 0) 
            {
                $this->db->where('uniq', $notification['uniq']);
                return $this->db->update('notification', $notification);
            }
            else
            {
                return $this->db->insert('notification',$notification);
            }
        }

        
    // phone check
    public function referal_list()
    {
        $this->db->where('agent_id', $this->session->userdata('sid'));  
        $query = $this->db->get('referral');
 
        if ($query->num_rows() > 0) {
           return $query->result();
        } 
        else {
           return false;
        } 
    }


        


        



    
}

/* End of file M_account.php */