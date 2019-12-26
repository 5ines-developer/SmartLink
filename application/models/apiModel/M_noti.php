<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_noti extends CI_Model {


	//get all notification
    public function all_noti($id=null)
    {
        $this->db->where('noti_to', $id);
        $this->db->where('noti_to_type', 'agent');
        $this->db->where('notification_type !=', '3');
        $this->db->order_by('added_on', 'desc');
        return $this->db->get('notification')->result();
    }
    	//get all notification
    public function single_noti($id=null,$aid=null)
    {
        $this->db->where('notification_id', $id);
        $this->db->where('noti_to', $aid);
        $this->db->where('noti_to_type', 'agent');
        $this->db->where('notification_type !=', '3');
        return $this->db->get('notification')->row_array();
    }

    public function single_referal($refid =null,$uid=null)
    {
        $this->db->where('uniq', $refid);
        $this->db->where('agent_id', $uid);
        $this->db->where('is_deleted','0');
        $query = $this->db->get('referral');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

        // claim list
        public function single_claim($claimid =null,$uid=null)
        {
            $this->db->where('uniq', $claimid);
            $this->db->where('agent_id', $uid);
            $query = $this->db->get('claim_reward');
    
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return false;
            }
        }


    //update if notification seen
    public function noti_seen($notiid = null)
    {
        $this->db->where('notification_seen ', '0');
        $this->db->where('notification_id ', $notiid);
        $this->db->update('notification', array('notification_seen' => '1'));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

     //get all notification
    public function notiCount($id=null)
    {
        $this->db->where('noti_to', $id);
        $this->db->where('noti_to_type', 'agent');
        $this->db->where('notification_seen', '0');
        $this->db->where('notification_type !=', '3');
        $this->db->order_by('added_on', 'desc');
        return $this->db->get('notification')->result();
    }


    

}