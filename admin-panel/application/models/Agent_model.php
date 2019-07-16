<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends CI_Model {

    /**
	 * Agent -> get agents list
	 * url : manage-agent
	*/
    public function get_agents()
    {
        $this->db->order_by('agent_id', 'desc');
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) 
        {
            
            return $query->result();
        }
        else
        {
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

        public function viewagent($id=null)
		{
            $this->db->where('agent_id', $id);
            $query = $this->db->get('agent');
            if ($query->num_rows() > 0) 
            {
                
                return $query->row_array();
            }
            else
            {
                return false;
            }

        }

        public function referals($id= null)
		{
            $this->db->where('agent_id', $id);
            $query = $this->db->get('referral');
            if ($query->num_rows() > 0) 
            {
                
                return $query->result();
            }
            else
            {
                return false;
            }

        }
        
        
        
        
        
        
}