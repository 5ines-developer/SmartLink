<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    /***admin login**/ 
	function can_login($email, $password)  
      {  
        
           $this->db->where('admin_password', $password); 
           $this->db->group_start(); 
            $this->db->where('admin_name', $email);  
            $this->db->or_where('admin_email', $email); 
           $this->db->group_end();
           $query = $this->db->get('admin');
           //SELECT * FROM users WHERE username = '$username' AND password = '$password'  
           if($query->num_rows() > 0)  
           {  
                return $query->row_array();  
           } else{
            return false;
           }
          
      } 


        /**
		* forget pasword mail check exist or not
		* @url : forgot/email-check
		* @param : email and forgot-id
		*/ 
		public function check_mail($email,$forgotid)
		{
        $this->db->where('admin_email', $email);
        $query = $this->db->get('admin');

        if($query->num_rows() > 0)  
           {
            $this->db->where('admin_email', $email);
            $this->db->update('admin',array('admin_forgot_link' =>$forgotid));
            return true;
           }  
           else  
           {
              return false;
           }
        }
        
        /**
		* forget pasword -> update new password
		* @url : update-password
		* @param : email and forgot-id , new password
		*/ 
        public function addforgtpass($email,$newpass,$forgotid)
		{
            $this->db->where('admin_email', $email);
			$this->db->where('admin_forgot_link', $forgotid);
			$query = $this->db->get('admin');

			if($query->num_rows() > 0)
			{
          

			    $this->db->where('admin_email', $email);
                $this->db->where('admin_forgot_link', $forgotid);
                $this->db->update('admin',  array(' admin_password ' =>$newpass,'admin_forgot_link'=>random_string('alnum',16)));
                if ($this->db->affected_rows() > 0) 
                {
                	return true;
                }else{
                	return false;
                }
			}else
			{
             return false;  
			}
			
        }
        
        /**
		*Change pasword -> Update New password
		* @url : change-password
		*/
        public function changepass($admin,$npass,$cpass)
        {
          
            $this->db->where('admin_id', $admin);
            $this->db->where('admin_password', $cpass);
            $query = $this->db->get('admin');
  
            if($query->num_rows() > 0)  
             {  
                  $this->db->where('admin_id', $admin);
                  $this->db->update('admin',  array('admin_password' =>$npass));
                  if ($this->db->affected_rows() > 0) 
                  {
                      return true;
                  }else{
                    
                      return false;
                  }
             }  
             else  
             {
                return false;
             } 
  
            
        }

         /**
		*Change pasword -> Update New password
		* @url : change-password
		*/
        public function account($value='')
        {
          $this->db->where('admin_id', $value);
          $query =  $this->db->get('admin');
      
          if ($query->num_rows()>0) 
          {
            return $query->row_array();
          }else{
            return false;
          }
        }

         /**
		*account settings -> Update account
        * @url : update-profile
        *@param : admin uniq id, name phone, date
		*/
        public function acupdte($ac_uniq,$acuname,$acphone,$date)
        {
        //   echo "<br>".$ac_uniq."<br>".$acuname."<br>".$acphone;exit();
          $this->db->where('admin_id', $ac_uniq);
          $this->db->update('admin',  array('admin_name' =>$acuname ,'admin_phone'=>$acphone,'admin_updated_on'=>$date ));
          if ($this->db->affected_rows() > 0) 
          {
           return true;
          }else{
            return false;
          }
        }


        /**
		    *Dashboard -> get total orders count
        */
        public function getorders()
        {
          $this->db->select('id');
          $query = $this->db->get('orders');
          if ($query->num_rows() > 0) {
            return $query->num_rows();
          }else{
            return false;
          }
        }

        /**
		    *Dashboard -> get total users count
        */
        public function getusers()
        {
          $this->db->select('id');
          $query = $this->db->get('employee');
          if ($query->num_rows() > 0) {
            return $query->num_rows();
          }else{
            return false;
          }
        }


        /**
		    *Dashboard -> get total Products count
        */
        public function getproducts()
        {
          $this->db->select('id');
          $query = $this->db->get('product');
          if ($query->num_rows() > 0) {
            return $query->num_rows();
          }else{
            return false;
          }
        }

        /**
		    *Dashboard -> get total Category count
        */
        public function getcategory()
        {
          $this->db->select('id');
          $query = $this->db->get('category');
          if ($query->num_rows() > 0) {
            return $query->num_rows();
          }else{
            return false;
          }
        }

        
      /**
      * get total orders by month to display in graph
      * @url : Admin/getordergraph
      * 
      */
      public function getordergraph($startdate)
      {
        
        $this->db->select('orderd_on');
        $now    = date("Y-m-d H:i:s");
        $this->db->where('orderd_on <=', $now);        
        $this->db->where('orderd_on >=', $startdate);
        $query = $this->db->get('orders')->result();

        foreach ($query as $key => $value) {
          $newData[]= date("M",strtotime($value->orderd_on));
        }
        $vals = array_count_values($newData);

        $counts = array();
        for ($m=1; $m<=12; $m++) {
          $month = date('M', mktime(0,0,0,$m, 1, date('Y')));
          
              if(!empty($vals[$month])){
                  $counts[]= array("valeus"=>$vals[$month] , "month"=>$month);
              }else{
                  $counts[]= array("valeus"=>0 , "month"=>$month);
              }
          }

        return $counts;

      }





       
}