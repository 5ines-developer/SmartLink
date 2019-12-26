<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_account extends CI_Model {

	/**
	* users -> my profile
	* 	@param : email id
	*/
	public function profileGet($uid)
    {
        return $this->db->select('agent_name,agent_phone,agent_profile_file')->where('agent_id', $uid)->get('agent')->row_array();
    }

    //  update profile
    public function updateProfile($agent_name, $uid)
    {
        $this->db->where('agent_id', $uid)->update('agent', array('agent_name' => $agent_name));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

        //  update profile
    public function profileImage($image, $uid)
    {
        $this->db->where('agent_id', $uid)->update('agent', array(' agent_profile_file ' => $image));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
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

        // check pasw
    public function checkpsw($uid,$psw)
    {
        $this->db->where('agent_id', $uid);
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
}