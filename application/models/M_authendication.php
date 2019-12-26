<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_authendication extends CI_Model {

    // registration
    public function register($data = null)
    {
        $this->db->insert('agent', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }        
    }

           //  get the country code
        public function country_code()
        {
            $result = $this->db->get('country_code');
            if($result->num_rows() > 0){
                return $result->result();
            }else{
                return false;
            }
            
        }


        //  check the reference code of employee  is exist
        public function isreference($str)
        {
            $this->db->where('employee_ref_id', $str);
            $result = $this->db->get('employee');
            if($result->num_rows() > 0){
                return true;
            }else{
                return false;
            }
            
        }

    //  account activation
    public function activateAccount($otp,$phone,$cntry)
    {

        $this->db->select('agent_id');
        $this->db->where('agent_phone', $phone);
        $this->db->where('agent_country_code', $cntry);
        $this->db->where('otp', $otp);
        $result = $this->db->get('agent');
        
        if($result->num_rows() >= 1){
            $update =  array('otp' => random_string('numeric','6'), 'agent_is_active' => '1', 'agent_updated_on' => date('Y-m-d H:i:s'),'otp_check_count'=>'0');
            $this->db->where('agent_phone', $phone);
            $this->db->where('otp', $otp);
            $this->db->where('agent_country_code', $cntry);
            $this->db->update('agent', $update);
            if($this->db->affected_rows() > 0){
                return $otp;
            }else{
                return false;
            }             
        }else{
             $up = '1';
            $data = $this->otp_countcheck($phone,$up,$cntry);
            $datas['otpcount'] = $data;
            if ($datas['otpcount'] > '2') {
                $this->db->where('agent_phone', $phone);
                $this->db->where('agent_country_code', $cntry);
                $this->db->delete('agent');
            }
             return $datas;
        }
    }

    public function resend_code($phone,$otp,$cntry)
    {
        $this->db->where('agent_phone', $phone);
        $this->db->where('agent_country_code', $cntry);
        $result = $this->db->get('agent');
        if($result->num_rows() >= 1){
            $update =  array('otp' => $otp,'otp_check_count'=>'0');
            $this->db->where('agent_phone', $phone);
            $this->db->where('agent_country_code', $cntry);
            $this->db->update('agent', $update);
            if($this->db->affected_rows() > 0){
                return $otp;
            }else{
                return false;
            }  
        }else{
            return false;
        }
    }


    

    //  login
    function can_login($username, $password)  
    {
        $this->db->group_start();
           $this->db->where('agent_name', $username);  
           $this->db->or_where('agent_phone', $username); 
        $this->db->group_end(); 
        $this->db->where('agent_is_active', '1');  
        $result = $this->getUsers($password);

        if (!empty($result)) {
          return $result;
        } 
        else {
            return null;
        }  
    }

    // check password
    function getUsers($password) {

        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if ($this->bcrypt->check_password($password, $result['agent_password'])) {
                //We're good
                return $result;
            } 
            else {
                //Wrong password
                return array();
            }
        } 
        else{
            return array();
        }
    } 

    // forgot password
    public function forgotPassword($mobile, $otp,$country_code)
    {
        $this->db->where('agent_phone', $mobile);
        $this->db->where('agent_country_code', $country_code);
        $this->db->update('agent',array('otp'=>$otp,'otp_check_count'=>'0'));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }  
    }

    
        // forgot password
        public function forgot_verify($otp='',$mobile='',$country='')
        {
            
            $this->db->where('agent_phone', $mobile);
            $this->db->where('agent_country_code', $country);
            $this->db->where('otp', $otp);
            $query = $this->db->get('agent');
            if($query->num_rows() > 0){
                $up = '2';
                $data = $this->otp_countcheck($mobile,$up,$country);
                return $query->row_array();
            }else{
                $up = '1';
                if($data = $this->otp_countcheck($mobile,$up,$country))
                {
                    $datas['otpcount'] = $data;
                    return $datas;
                }else{
                    return false;
                }
            }  
        }


        public function otp_countcheck($mobile,$up,$cntry)
        {
            $this->db->select('otp_check_count');
            $this->db->where('agent_phone', $mobile);
            $this->db->where('agent_country_code', $cntry);
            $otpcheckcount = $this->db->get('agent')->row_array();
            if ($up == '2') {
                $inc = $otpcheckcount['otp_check_count'] - $otpcheckcount['otp_check_count'];
            }else if ($up == '1'){
                $inc = $otpcheckcount['otp_check_count'] + '1';
            }
            if ($otpcheckcount['otp_check_count'] < 2) {
                $this->db->where('agent_phone', $mobile);
                $this->db->where('agent_country_code', $cntry);
                $this->db->update('agent', array('otp_check_count' => $inc ));
                if ($this->db->affected_rows() > 0) {
                return $inc;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }
    




    // password reset
    public function setPassword($datas, $mobile,$otp)
    {
        $this->db->where('agent_phone', $mobile);
        $this->db->where('otp', $otp);
        $query = $this->db->update('agent', $datas);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    //get total referal count
    public function get_referal()
    {
        $this->db->select('referee_id');
        $this->db->where('agent_id', $this->session->userdata('sid'));
        $this->db->where('is_deleted', '0');
        $query = $this->db->get('referral');
        if( $query->num_rows() > 0){
            return $query->num_rows();
        }else{
            return false;
        }
    }
        //get total referal count
        public function pending_referal()
        {
            $this->db->select('referee_id');
            $this->db->where('agent_id', $this->session->userdata('sid'));
            $this->db->where('referee_status', '0');
            $this->db->where('is_deleted', '0');
            $query = $this->db->get('referral');
            if( $query->num_rows() > 0){
                return $query->num_rows();
            }else{
                return false;
            }
        }

         //get total referal count
         public function approved_referal()
         {
             $this->db->select('referee_id');
             $this->db->where('agent_id', $this->session->userdata('sid'));
             $this->db->where('referee_status', '1');
             $this->db->where('is_deleted', '0');
             $query = $this->db->get('referral');
             if( $query->num_rows() > 0){
                 return $query->num_rows();
             }else{
                 return false;
             }
         }

    





}

/* End of file M_authendication.php */
