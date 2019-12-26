<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agent_model extends CI_Model
{

    /**
     * Agent -> get agents list
     * url : manage-agent
     */
    public function get_agents()
    {
        $this->db->order_by('agent_id', 'desc');
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * delete agent
     * @url : delete-agent
     * @param : id
     *
     */
    public function deletedomain($id)
    {
        $this->db->where('agent_id', $id);
        return $this->db->delete('agent');
    }

    public function viewagent($id = null)
    {
        $this->db->where('agent_id', $id);
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {

            return $query->row_array();
        } else {
            return false;
        }

    }

    public function delete_agent($id='')
    {
        $this->db->where('agent_id', $id)->delete('agent');
        if ($this->db->affected_rows() > 0) {

            return true;
        } else {
            return false;
        }
    }

    //get total referrals
    public function referals($id = null)
    {
        $this->db->where('agent_id', $id);
        $query = $this->db->get('referral');
        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return false;
        }

    }
    //get approval referrals count
    public function ref_count($id = null)
    {
        $this->db->select('referee_id');
        $this->db->where('agent_id', $id);
        $this->db->where('referee_status','1');
        $query = $this->db->get('referral');
        return $query->num_rows();
    }

    //get approval referrals count
    public function service($id = null)
    {
        $this->db->select('service');
        $this->db->where('uniq', $id);
        $query = $this->db->get('product')->row_array();
        return $query['service'];
    }

}
