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

        $this->db->select('cl.claim_id,cl.claim_status,cl.claimed_points,cl.claimed_on,cl.uniq,ag.agent_id,ag.agent_name,cl.coupon_code,cl.coupon_added_by');

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
            $this->db->select('SUM(remain_points) AS reward_points FROM referral');        
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

        public function approved_point($agentid = null)
        {        
            $this->db->select('SUM(claimed_points) AS claimed_points FROM claim_reward ');        
            $this->db->where('agent_id', $agentid);
            $this->db->where_in('claim_status', '1');
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

        // update claim reward table
        public function claim_change($change,$claimid)
		{
            if ((empty($change['return_reward'])) || ($change['return_reward']!=1)) {
                $result = $this->remainUpdate($claimid);
            }
			$this->db->where('uniq', $claimid);
			$this->db->update('claim_reward', $change);
			if ($this->db->affected_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}

        public function remainUpdate($claimid='')
        {
            $uppoint = '';
            $agent = $this->db->select('agent_id,claimed_points')->where('uniq',$claimid)->get('claim_reward')->row();
            if (!empty($agent->agent_id)) {
                $point = $this->db->where('agent_id', $agent->agent_id)->where('rem_status',0)->where('remain_points !=',null)->order_by('reward_expiry_date','asc')->get('referral')->result();

                if (!empty($point)) {
                    $this->pointUp($point,$claimid,$agent);
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }

        public function pointUp($point='',$claimid='',$agent='')
        {

            foreach ($point as $key => $value) {
                if (!empty($value->referee_id)) {
                    if ($agent->claimed_points > $value->remain_points) {
                        $uppoint = $agent->claimed_points - $value->remain_points;
                        $this->db->where('referee_id',$value->referee_id)->update('referral',array('remain_points' => 0, 'rem_status' => 1));
                    }else{
                        $uppoint = $value->remain_points - $agent->claimed_points;
                        $this->db->where('referee_id',$value->referee_id)->update('referral',array('remain_points' =>$uppoint, 'rem_status' => 0));
                    }

                    if (empty($uppoint)) {
                        break;
                    }

                }else{
                    return false;
                }
            }
        }
}
