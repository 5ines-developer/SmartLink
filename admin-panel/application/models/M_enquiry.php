<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_enquiry extends CI_Model {

	/**
	*gert enquiries 
	*
	**/
	public function getEnquiry($value='')
	{
		return $this->db->order_by('id', 'desc')->get('contact')->result();
	}


	public function singleEnquiry($id='')
	{
		return $this->db->where('id', $id)->get('contact')->row_array();
	}

}

/* End of file M_enquiry.php */
/* Location: ./application/models/M_enquiry.php */