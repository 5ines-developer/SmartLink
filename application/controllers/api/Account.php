<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Account extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apiModel/M_account','m_account');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}


	/**
	*	Agent account details
	*	@method : get
	*	@url 	: api/agent/account
	*/ 
	public function profile_get($value='')
	{

		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_account->profileGet($value->sid);
		
			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'profile retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'Account Doesnot exist'
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
	*	My profile detail update
	*	@method : post
	*	@url 	: api/v1/update-profile
	*/ 
	public function update_profile_post()
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('nickname', 'Nick Name', 'required');
		if($this->form_validation->run() == FALSE) 
		{
			//form_validation error
			$message=array(
				'status' => false,
				'error' => $this->form_validation->error_array(),
				'message' => validation_errors()
				);
			$this->response($message, REST_Controller::HTTP_NOT_FOUND);
		}else{
			//load authorization token library
			$this->load->library('Authorization_Token');

			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				foreach ($is_valid_token as $key => $value) { } // XSS Clean
				$agent_name = $this->input->post('nickname', TRUE); // XSS Clean
				$output = $this->m_account->updateProfile($agent_name, $value->sid);

					if (!empty($output) AND $output != FALSE) {
						$message=array(
						'status' => true,
						'message' => 'profile Updated successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);
					}else{
						$message=array(
						'status' => FALSE,
						'message' => 'Some error occured Please try again later'
						);
						$this->response($message, REST_Controller::HTTP_NOT_FOUND);
					}


			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'Invalid Token');
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
			}
		}

	}

}