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
			$this->db->select('ref.*,ag.agent_id as agentId,ag.agent_name,pr.service,pr.it_service');

			if (!empty($filter)) {
				if ($filter == 'approved') {
					$this->db->where('ref.referee_status', '1');
				}else if ($filter == 'rejected') {
					$this->db->where('ref.referee_status', '2');
				}else if ($filter == 'pending'){
					$this->db->where('ref.referee_status', '0');
				}
			}
			$this->db->order_by('ref.referee_id', 'desc');
			$this->db->from('referral ref');
			$this->db->join('agent ag', 'ag.agent_id  = ref.agent_id', 'left');
			$this->db->join('product pr', 'pr.uniq  = ref.sub_product', 'left');
			return $this->db->get()->result();
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
         * view referals 
         * @url : delete-referals
         * @param : id
         * 
        */
        public function single_referal($id)
		{
			$this->db->select('ref.*,ag.agent_id as agentId,ag.agent_name,pr.service,pr.it_service');
			$this->db->where('ref.uniq', $id);
			$this->db->order_by('ref.referee_id', 'desc');
			$this->db->from('referral ref');
			$this->db->join('agent ag', 'ag.agent_id  = ref.agent_id', 'left');
			$this->db->join('product pr', 'pr.uniq  = ref.sub_product', 'left');
			return $this->db->get()->row_array();
			$query = $this->db->get('referral');
		}

		public function get_noti($id=null)
		{
			$this->db->where('noti_to_type ', 'admin');
			$this->db->where('notification_seen ', '0');
			$this->db->order_by('added_on', 'desc');
			return $this->db->get('notification')->result();
		}

		public function noti_seen($uniq=null)
		{
			$this->db->where('noti_to_type ', 'admin');
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

			$this->db->select('no.notification_id,no.added_on,no.notification_subject,no.notification_description,no.notification_type,no.notification_seen,no.thing_id, no.uniq, no.added_by_type,no.noti_to,ag.agent_name')
			->where('no.noti_to_type ', 'admin')
			->order_by('no.added_on', 'desc')
			->from('notification no')
			->join('agent ag', 'ag.agent_id  = no.added_by', 'inner');
			return $this->db->get()->result();
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
		
		// get product reward if its exist
		public function product_reward($uniq = '')
		{
			$this->db->select('reward_points,reward_expiry_date');
			$this->db->where('uniq', $uniq);
			$query = $this->db->get('product');
			if ($query->num_rows() > 0) 
            {
				return $query->row_array();
			}
            else
            {
                return false;
            }
			
		}

		// get refered by 
		public function refered_by($id = null)
		{
			$this->db->select('agent_name');
			$this->db->where('agent_id',$id);
			$query = $this->db->get('agent')->row_array();
			return $query['agent_name'];
		}
		

}