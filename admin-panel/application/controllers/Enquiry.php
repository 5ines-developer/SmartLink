<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {

		/*--construct--*/
	function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('referal_model');
        $this->load->model('m_enquiry');
        $this->data =  $this->notification();
        if($this->session->userdata('unique_id') == '') 
        {
            $this->session->set_flashdata('error', 'Please login and try again');
            redirect('dashboard'); 
        }
    }

	public function index()
	{
		$data['title']      = 	'Enquiries - Smart Link';
        $data['alert']      = 	$this->data;
        $data['result']		= 	$this->m_enquiry->getEnquiry();
        $this->load->view('enquiries/manage', $data, FALSE);
		
	}

	public function view($id='')
	{
		$data['title']      = 'Enquiries - Smart Link';
        $data['alert']      = $this->data;
        $data['result']		= 	$this->m_enquiry->singleEnquiry($id);
        $this->load->view('enquiries/detail', $data, FALSE);
	}

	// notification 
    public function notification($id='')
    {
      $datas = $this->referal_model->get_noti();
      return $datas;
    }

}

/* End of file Enquiry.php */
/* Location: ./application/controllers/Enquiry.php */