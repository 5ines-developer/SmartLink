<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Referal_model extends CI_Model {

	    /**
         * get Referals 
         * @url : manage-referal-request
         * 
        */
        public function getreferal($filter='')
		{
			
			if (!empty($filter)) {
				if ($filter == 'approved') {
					$this->db->where('referee_status', '1');
				}else if ($filter == 'rejected') {
					$this->db->where('referee_status', '2');
				}else if ($filter == 'pending'){
					$this->db->where('referee_status', '0');
				}
			}
			
			$this->db->order_by('referee_id', 'desc');
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
		

		/**
         * delete referals 
         * @url : delete-referals
         * @param : id
         * 
        */
        public function deletereferals($id)
		{
			$this->db->where('uniq', $id);
			return $this->db->delete('referral');
		}


		/**
         * delete referals 
         * @url : delete-referals
         * @param : id
         * 
        */
        public function single_referal($id)
		{
			$this->db->where('uniq', $id);
			$query = $this->db->get('referral');
			if ($query->num_rows() > 0) 
			{
				
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}

		public function get_noti($id=null)
		{
			$this->db->where('notification_seen ', '0');
			$this->db->order_by('added_on', 'desc');
			return $this->db->get('notification')->result();
		}

		public function noti_seen($uniq=null)
		{
			$this->db->where('notification_seen ', '0');
			$this->db->where('uniq ', $uniq);
			$this->db->update('notification', array('notification_seen' => '1'));
			if ($this->db->affected_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function all_noti($id=null)
		{
			$this->db->order_by('added_on', 'desc');
			return $this->db->get('notification')->result();
		}


		public function checkpsw($psw)
		{
			$this->db->where('admin_id', $this->session->userdata('unique_id'));
			$this->db->where('admin_password', $psw);
			return $this->db->get('admin')->result();
		}



		public function referal_change($change,$referalid)
		{
			$this->db->where('uniq', $referalid);
			$this->db->update('referral', $change);
			if ($this->db->affected_rows() > 0) {
				return true;
			}else{
				return false;
			}
		}

		        /**
    * insert a notification
    **/
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

		



			
			
		

		

}