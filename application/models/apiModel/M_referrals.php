<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_referrals extends CI_Model
{

	/**
	* refer a friend
	* 	@param : refer a friend {array}
     * insert a refer a friend details
     **/
    public function insert_referrals($insert)
    {
        $this->db->where('uniq', $insert['uniq']);
        $query = $this->db->get('referral');
        if ($query->num_rows() > 0) {
            $this->db->where('uniq', $insert['uniq']);
            return $this->db->update('referral', $insert);
        } else {
            return $this->db->insert('referral', $insert);
        }
    }

    public function product($value = '')
    {
        return $this->db->get('product')->result();
    }



    /**
     * insert a notification
     **/
    public function insert_notification($notification)
    {
    	
        $this->db->where('thing_id', $notification['thing_id']);
        $this->db->where('uniq', $notification['uniq']);
        $this->db->where('noti_to_type', 'admin');
        $this->db->where('notification_type', '1');
        $this->db->where('added_by_type', 'agent');
        $query = $this->db->get('notification');
        if ($query->num_rows() > 0) {
            $this->db->where('thing_id', $notification['thing_id']);
            $this->db->where('uniq', $notification['uniq']);
            $this->db->where('noti_to_type', 'admin');
            $this->db->where('notification_type', '1');
            $this->db->where('added_by_type', 'agent');
            $this->db->where('uniq', $notification['uniq']);
            return $this->db->update('notification', $notification);
        } else {
            return $this->db->insert('notification', $notification);
        }
    }

	/**
	* refer a friend edit
	* 	@param : id
    **/
    public function edit_refer($aid,$id)
    {
        $this->db->where('referee_id', $id);
        $this->db->where('agent_id',$aid);
        $this->db->where('is_deleted','0');
        $query = $this->db->get('referral');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }

    }

        public function notidet($itemid,$aid)
        {
            $this->db->select('uniq');
            $this->db->where('added_by', $aid);
            $this->db->where('thing_id', $itemid);
            $this->db->where('added_by_type', 'agent');
            $this->db->where('noti_to_type', 'admin');
            $this->db->where('notification_type', '1');
            $query = $this->db->get('notification')->row_array();
            return $query['uniq'];
        }



 
	/**
	* referal list
	* 	@param : id
    **/
    public function referal_list($id =null )
    {

        $this->db->select('ref.*,p.service as sub_product');
        $this->db->from('referral ref');
        $this->db->where('ref.agent_id',$id);
        $this->db->where('ref.is_deleted','0');
        $this->db->join('product p', 'p.uniq = ref.sub_product', 'left');
        $query = $this->db->get()->result();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }


    /**
	* delete referrals
	* 	@param : id
    **/
    public function delete_refer($itemd='',$aid)
    {
        $this->db->where('uniq', $itemd);
        $this->db->where('agent_id',$aid);
        $this->db->update('referral',array('is_deleted' => '1'));
        if ($this->db->affected_rows() > 0) {
        	return true;
        }else{
        	return false;
        }
    }

    /**
    * get service
    *   @param : id
    **/
    public function serviceGet($itemd)
    {
        $this->db->select('service');
        $this->db->where('uniq', $itemd);
        $result = $this->db->get('product')->row_array();
        if (!empty($result)) {
            return $result['service'];
        }else{
            return false;
        }
    }

    public function category($value='')
    {
        return $this->db->get('product')->result();
    }



}