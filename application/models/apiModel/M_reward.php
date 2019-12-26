<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_reward extends CI_Model
{

	/**
	* Total reward point
	* 	@param : agentid
	*/
	//get total referal count
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

    /**
	* total claimed points
	* 	@param : agentid
	*/
	//get total referal count
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



    /**
     * check eligibilty for claiming the reward points
     * @param : requestedpoint,agentid
     **/
    public function eligible_check($insert)
    {
        $this->db->select('SUM(reward_points) AS reward_points FROM referral');        
        $this->db->where('agent_id', $insert['agent_id']);
        $this->db->where('referee_status', '1');
        $this->db->where('reward_expiry_date >=', date('Y-m-d'));
        $query = $this->db->get()->result();
        
        if (!empty($query)) {
           $data = $this->claimed_point($insert['agent_id']);
            foreach ($query as $key => $value) {
            }
            if ($insert['claimed_points'] <= ($value->reward_points - $data)) {
               return true;
            }else{
                return false;
            }
        }else{
                return 'error';
        }
       
    }

    /**
     * insert reward claim request
     **/
    public function insert_claimrequest($insert)
    {
        $this->db->where('uniq', $insert['uniq']);
        $query = $this->db->get('claim_reward');
        if ($query->num_rows() > 0) {
            $this->db->where('uniq', $insert['uniq']);
            return $this->db->update('claim_reward', $insert);
        } else {
            return $this->db->insert('claim_reward', $insert);
        }
    }

            // claim list
        public function claim_list($aid =null )
        {
            $this->db->where('agent_id', $aid);
            $query = $this->db->get('claim_reward');
    
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
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


        // check pasw
    public function checkpsw($psw,$aid)
    {
        $this->db->where('agent_id', $aid);
        $result = $this->getUsers($psw);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    // check password
    public function getUsers($password)
    {
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if ($this->bcrypt->check_password($password, $result['agent_password'])) {
                return $result;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function check_user($username = null,$aid=null)
    {
        $this->db->where('agent_id', $aid);
        $this->db->group_start();
            $this->db->where('agent_phone', $username);
            $this->db->or_where('agent_name', $username);
        $this->db->group_end();
        $query = $this->db->get('agent');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function coupon($claimid,$aid=null)
    {
        $this->db->select('coupon_code');
        $this->db->where('agent_id', $aid);
        $this->db->where('claim_id', $claimid);
        $this->db->where('claim_status', '1');
        $query = $this->db->get('claim_reward')->row_array();
        return $query['coupon_code'];
    }


    public function claimcheck($claimid,$aid=null)
    {
        $this->db->where('agent_id', $aid);
        $this->db->where('claim_id', $claimid);
        $this->db->where('claim_status', '1');
        $query = $this->db->get('claim_reward');
        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    

}