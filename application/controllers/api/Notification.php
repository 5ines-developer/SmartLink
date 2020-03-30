<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Notification extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apiModel/M_noti','m_noti');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}



	/**
	*	Agent Notification
	*	@method : get
	*	@url 	: api/agent/notification
	*/ 
	public function notiGet_get($value='')
	{

		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output['noti'] = $this->m_noti->all_noti($value->sid); //get all notification
			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'Notification retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No result found!'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
			}

		}else{

				$message=array(
				'status' => FALSE,
				'message' => 'Invalid Token'
				);
			$this->response($message, REST_Controller::HTTP_NOT_FOUND);
		}
	}

		/**
	*	Agent Notification
	*	@method : get
	*	@url 	: api/agent/notification/$id
	*/ 
	public function single_noti_get($id='')
	{

		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_noti->single_noti($id,$value->sid); //get all notification
			$itemid = $output['thing_id'];
			$notiid = $output['notification_id'];
			$this->m_noti->noti_seen($notiid); //reduce the notification seen count
		    if ($output['notification_type'] == '1') {
            	$output1 = $this->m_noti->single_referal($itemid,$value->sid); //get referal
	        } elseif ($output['notification_type'] == '2') {
	        	$output1 = $this->m_noti->single_claim($itemid,$value->sid); //get claimdetail
	        }elseif ($output['notification_type'] == '3') {
	        	$output1 = $this->m_noti->single_push($id); //get pushnoti
	        }



			if (!empty($output) AND !empty($output1) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output1,
				'message' => 'Single Notification retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'Some error occured, Please try again Later!'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
			}

		}else{

				$message=array(
				'status' => FALSE,
				'message' => 'Invalid Token'
				);
			$this->response($message, REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function notiCount_get($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_noti->notiCount($value->sid); //get all notification
			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> count($output),
				'message' => 'Notification retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No result found!'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
			}

		}else{

				$message=array(
				'status' => FALSE,
				'message' => 'Invalid Token'
				);
			$this->response($message, REST_Controller::HTTP_NOT_FOUND);
		}
	}
}