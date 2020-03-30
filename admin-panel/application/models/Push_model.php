<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Push_model extends CI_Model
{

	     /**
         * insert push notification
         * @url : insert/push-notification
         * @param : push data
         * 
        */
        public function insert_notification($notification)
        {

            $this->db->where('uniq', $notification['uniq']);
            $query = $this->db->get('notification');
            if ($query->num_rows() > 0) 
            {
                $this->db->where('uniq', $notification['uniq']);
                return $this->db->update('notification', $notification);
            }
            else
            {
                return $this->db->insert('notification',$notification);
            }
		}


         public function get_push($notification='')
        {
            $this->db->where('notification_type', '3');
            $query = $this->db->get('notification');
            if ($query->num_rows() > 0) 
            {
                
                return $query->result();
            }
            else
            {
                return false;
            }
        }

        public function agent($id = null)
        {
            $this->db->select('agent_name');
            $this->db->where('agent_id',$id);
            $query = $this->db->get('agent')->row_array();
            return $query['agent_name'];
        }


        public function getdevice($agent='')
        {
            $this->db->select('device_id as deviceid');
            $this->db->where('user_id', $agent);
            return $output = $this->db->get('device_id')->result();
        }

}