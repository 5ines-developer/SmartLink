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

			$output['agent_profile_file']	= base_url().$output['agent_profile_file'];

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


		/**
	*	change password
	*	@method : post
	*	@url 	: api/agent/account
	*/ 

	public function changePass_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('currentpass', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('newpass', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('confirmpass', 'Password Confirmation', 'trim|required|matches[newpass]');
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

				$currentpass 	= $this->input->post('currentpass', TRUE); // XSS Clean
				$newpass 		= $this->input->post('newpass', TRUE); // XSS Clean
				$confirmpass 	= $this->input->post('confirmpass', TRUE); // XSS Clean

				$output = $this->m_account->checkpsw($value->sid, $currentpass);

				$hash  = $this->bcrypt->hash_password($newpass);
                $datas = array(
                    'agent_password' => $hash
                );

                	if (!empty($output) AND $output != FALSE) {

                		$output1 = $this->m_account->changePassword($datas, $value->sid, $currentpass);
						if (!empty($output1) AND $output1 != FALSE) {
								$message=array(
								'status' => true,
								'message' => 'Password changed successfully'
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
						'message' => 'Invalid Current Password'
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


		/**
	*	My profile detail update
	*	@method : post
	*	@url 	: api/v1/update-profile
	*/ 
	public function profile_image_post()
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);

		//load authorization token library
			$this->load->library('Authorization_Token');

			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				$image      = $this->input->post('image');

				
				
				if (!empty($image)) {
					if (!is_dir('profile')) {
                		mkdir('profile', 0777, true);
            		}

					list($type, $image) = explode(';', $image);
            		list(, $image)      = explode(',', $image);
					$image 				= base64_decode($image);
					$imageName 			= time().'.png';
				
					file_put_contents('profile/'.$imageName, $image);
		            $path =  'profile/'.$imageName;
		            if (!empty($imageName)) {
		            	foreach ($is_valid_token as $key => $value) { } // XSS Clean
		            	$output = $this->m_account->profileImage($path,$value->sid);
		            	if (!empty($output) AND $output != FALSE) {
							$message=array(
							'status' => true,
							'message' => 'profile image updated successfully'
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
		            }


		        }else{
		        	$message=array(
					'status' => FALSE,
					'message' => 'Please select the image you want to upload!');
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