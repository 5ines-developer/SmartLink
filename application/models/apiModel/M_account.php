<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_account extends CI_Model {

	/**
	* users -> my profile
	* 	@param : email id
	*/
	public function profileGet($uid)
    {
        return $this->db->select('agent_name,agent_phone')->where('agent_id', $uid)->get('agent')->row_array();
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
}