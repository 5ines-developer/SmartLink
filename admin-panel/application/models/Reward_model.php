<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reward_model extends CI_Model
{

    /**
     * get claimed
     * @url :manage-reward-claims
     *
     */
    public function getclaimed($filter = '')
    {

        $this->db->select('cl.claim_id,cl.claim_status,cl.claimed_points,cl.claimed_on,cl.uniq,ag.agent_name,cl.coupon_code,cl.coupon_added_by');

        if (!empty($filter)) {
            if ($filter == 'approved') {
                $this->db->where('cl.claim_status', '1');
            }else if ($filter == 'rejected') {
                $this->db->where('cl.claim_status', '2');
            }else if ($filter == 'pending'){
                $this->db->where('cl.claim_status', '0');
            }
        }
        $this->db->order_by('cl.claimed_on', 'desc');
        $this->db->from('claim_reward cl');
        $this->db->join('agent ag', 'ag.agent_id  = cl.agent_id', 'left');
        return $this->db->get()->result();
    }

    	/**
         * delete   claimed 
         * @url : delete-rewars-claims
         * @param : id
         * 
        */
        public function deletereferals($id)
		{
			$this->db->where('uniq', $id);
			return $this->db->delete('claim_reward');
        }
        
        /**
         * view claimed reward points 
         * @url : view-reward-claims
         * @param : id
         * 
        */
        public function view_claims($id)
		{
            $this->db->select('ag.agent_id,cl.claim_id,cl.claim_status,cl.claimed_points,cl.claimed_on,cl.uniq,ag.agent_name,cl.coupon_code,cl.coupon_added_by');
			$this->db->where('uniq', $id);
            $this->db->order_by('cl.claimed_on', 'desc');
            $this->db->from('claim_reward cl');
            $this->db->join('agent ag', 'ag.agent_id  = cl.agent_id', 'left');
            return $this->db->get()->row_array();

        }
        
        public function reward_point($agentid = null)
        {
            $this->db->select('SUM(reward_points) AS reward_points FROM referral');        
            $this->db->where('agent_id', $agentid);
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


        public function claimed_point($agentid = null)
        {        
            $status = array(0, 1);
            $this->db->select('SUM(claimed_points) AS claimed_points FROM claim_reward ');        
            $this->db->where('agent_id', $agentid);
            $this->db->where_in('claim_status', $status);
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $key => $value) {
                }
                
                return $value->claimed_points;
            } else {
                return false;
            }
        }

        public function approved_point($agentid = null)
        {        
            $this->db->select('SUM(claimed_points) AS claimed_points FROM claim_reward ');        
            $this->db->where('agent_id', $agentid);
            $this->db->where('claim_status', '1');
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $key => $value) {
                }
                
                return $value->claimed_points;
            } else {
                return false;
            }
        }

        // update claim reward table
        public function claim_change($change,$claimid)
		{
			$this->db->where('uniq', $claimid);
			$this->db->update('claim_reward', $change);
			if ($this->db->affected_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}
}
