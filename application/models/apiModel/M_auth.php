<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model
{
    protected $user_table = 'devusers';

   	/**
     * agent Registration
     * @param: {array} agent Data
     */
    public function register($data = null)
    {
        $this->db->insert('agent', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }        
    }


    /**
     *  check the reference code of employee  is exist
     * @param: employee reference code
     */
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

    /**
     *  account activation
     * @param: otp,mobile,country code,
    */
    public function activateAccount($otp,$phone,$cntry)
    {

        $this->db->select('agent_id');
        $this->db->where('agent_phone', $phone);
        // $this->db->where('agent_country_code', $cntry);
        $this->db->where('otp', $otp);
        $result = $this->db->get('agent');
        
        if($result->num_rows() >= 1){
            $update =  array('otp' => random_string('numeric','6'), 'agent_is_active' => '1', 'agent_updated_on' => date('Y-m-d H:i:s'),'otp_check_count'=>'0');
            $this->db->where('agent_phone', $phone);
            $this->db->where('otp', $otp);
            // $this->db->where('agent_country_code', $cntry);
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
            if ($datas['otpcount'] == '') {
                $this->db->where('agent_phone', $phone);
                // $this->db->where('agent_country_code', $cntry);
                $this->db->delete('agent');
            }
             return $datas;
        }
    }


    //  login
    function can_login($username, $password,$country_code)  
    {
        $this->db->group_start();
           $this->db->where('agent_name', $username);
           $this->db->or_where('agent_phone', $username); 
        $this->db->group_end(); 
        $this->db->where('agent_is_active', '1'); 
        // $this->db->where('agent_country_code', $country_code);  
        $result = $this->getUsers($password);

        if (!empty($result)) {
          return $result;
        } 
        else {
            return null;
        }  
    }

    public function insertDeviceid($deviceid='',$userid='')
    {
        $insert = array ('device_id' => $deviceid, 'user_id' => $userid );
        return $this->db->insert('device_id', $insert);
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
    public function forgotPassword($mobile='', $otp='',$country_code='',$aid='')
    {
        if (!empty($aid)) {
           $this->db->where('agent_id', $aid);
        }
        
        $this->db->where('agent_phone', $mobile);
        // $this->db->where('agent_country_code', $country_code);
        $this->db->update('agent',array('otp'=>$otp,'otp_check_count'=>'0'));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }  
    }

            // forgot password
        public function forgot_verify($otp='',$mobile='',$country='',$aid='')
        {
            if (!empty($aid)) {
                $this->db->where('agent_id', $aid);
            }
        	
            $this->db->where('agent_phone', $mobile);
            // $this->db->where('agent_country_code', $country);
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


            // otp count check
        public function otp_countcheck($mobile,$up,$cntry)
        {
            $this->db->select('otp_check_count');
            $this->db->where('agent_phone', $mobile);
            // $this->db->where('agent_country_code', $cntry);
            $otpcheckcount = $this->db->get('agent')->row_array();
            
            if ($up == '2') {
                $inc = $otpcheckcount['otp_check_count'] - $otpcheckcount['otp_check_count'];
            }else if ($up == '1'){
                $inc = $otpcheckcount['otp_check_count'] + '1';
            }
            
            if ($otpcheckcount['otp_check_count'] < 2) {
                $this->db->where('agent_phone', $mobile);
                // $this->db->where('agent_country_code', $cntry);
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
    public function setPassword($datas, $mobile,$otp,$aid='')
    {
            if (!empty($aid)) {
                $this->db->where('agent_id', $aid);
            }

        $this->db->where('agent_phone', $mobile);
        $this->db->where('otp', $otp);
        $query = $this->db->update('agent', $datas);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

        //resend otp code
    public function resend_code($phone,$otp,$cntry,$aid='')
    {
            if (!empty($aid)) {
                $this->db->where('agent_id', $aid);
            }

        $this->db->where('agent_phone', $phone);
        // $this->db->where('agent_country_code', $cntry);
        $result = $this->db->get('agent');
        if($result->num_rows() >= 1){
            $update =  array('otp' => $otp,'otp_check_count'=>'0');
            $this->db->where('agent_phone', $phone);
            // $this->db->where('agent_country_code', $cntry);
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


}