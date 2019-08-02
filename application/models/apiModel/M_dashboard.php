<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	/**
	* dashboard
	* 	@param : id
	*/
	//get total referal count
    public function get_referal($id='')
    {
        $this->db->select('referee_id');
        $this->db->where('agent_id', $id);
        $this->db->where('is_deleted', '0');
        $query = $this->db->get('referral');
        if( $query->num_rows() > 0){
            return $query->num_rows();
        }else{
            return false;
        }
    }

            //get pending referal count
        public function pending_referal($id='')
        {
            $this->db->select('referee_id');
            $this->db->where('agent_id', $id);
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
         public function approved_referal($id='')
         {
             $this->db->select('referee_id');
             $this->db->where('agent_id', $id);
             $this->db->where('referee_status', '1');
             $this->db->where('is_deleted', '0');
             $query = $this->db->get('referral');
             if( $query->num_rows() > 0){
                 return $query->num_rows();
             }else{
                 return false;
             }
         }

    public function reward_point($id = null)
    {
        
        $this->db->select('SUM(reward_points) AS reward_points FROM referral');        
        $this->db->where('agent_id', $id);
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


    public function claimed_point($id = null)
    {        
        $status = array(0, 1);
        $this->db->select('SUM(claimed_points) AS claimed_points FROM claim_reward ');        
        $this->db->where('agent_id', $id);
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

}