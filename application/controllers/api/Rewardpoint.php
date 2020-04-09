<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Rewardpoint extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apiModel/M_reward','m_reward');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}

	/**
	*	Reward Points
	*	@method : get
	*	@url 	: api/v1/reward-points
	*/ 
	public function reward_get($value='')
	{

		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
            $output['reward']  = $this->m_reward->reward_point($value->sid);
            $output['claimed'] = $this->m_reward->claimed_point($value->sid);
            $output['unclaimed'] =$output['reward'];

			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'Reward Points retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No Results found!'
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
	*	claim reward points
	*	@method : Post
	*	@url 	: api/v1/claim-points
	*/ 
	public function insertclaim_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('reward_points', 'Reward Point', 'trim|required|greater_than_equal_to[100]|less_than_equal_to[1000]');
        if ($this->form_validation->run() == False) {
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
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) {

	        	foreach ($is_valid_token as $key => $value) { }
	        	$claimed_points = $this->input->post('reward_points');
	        	$uniq = random_string('alnum','10');
	        	$insert         = array(
	                'claimed_points' => $claimed_points,
	                'agent_id' => $value->sid,
	                'uniq' => $uniq
	            );
	            $eligible = $this->m_reward->eligible_check($insert);
	            if (!empty($eligible) && $eligible!=FALSE) {

	            	$ouput1         = $this->m_reward->insert_claimrequest($insert);
	            	$notification   = array(
		                'notification_subject' => 'Claim reward points',
		                'notification_description' => 'agent has requested to claim the reward points',
		                'added_by' => $value->sid,
		                'thing_id' => $uniq,
		                'notification_type' => '2',
		                'uniq' => random_string('alnum', 10),
		                'added_by_type' => 'agent',
		                'noti_to_type' => 'admin'
            		);
            		 $ouput2         = $this->m_reward->insert_notification($notification);


            		 if ($ouput1 != '' && $ouput2 != '') {

			            $output['reward']  = $this->m_reward->reward_point($value->sid);
			            $output['claimed'] = $this->m_reward->claimed_point($value->sid);
			            $output['unclaimed'] =  $output['reward'] - $output['claimed'];

            		 	$message=array(
						'status' => true,
						'data'	=> $output,
						'message' => 'Reward points claim request has been submitted successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);
            		 }

	            }else{
	            		$message=array(
						'status' => FALSE,
						'message' => 'Unable to complete the redemption request, you have insufficient Reward Points!'
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


    /**
	*	Claim points
	*	@method : get
	*	@url 	: api/v1/claims
	*/ 
	public function claims_get($value='')
	{

		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }

            $output = $this->m_reward->claim_list($value->sid);

			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'Reward Points Claim list retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No Results found!'
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
	*	login
	*	@method : post
	*	@param : nickname/mobile and password
	*	@url 	: api/user/login
	*/ 

	public function authcheck_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('nickname', 'Nickname or Mobile Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('claimid', 'Claim Id', 'required');
        if ($this->form_validation->run() == False) {
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
				foreach ($is_valid_token as $key => $value) { }

				$username = $this->input->post('nickname');
		        $password = $this->input->post('password');
		        $claimid  = $this->input->post('claimid');

				$output = 	$this->m_reward->checkpsw($password,$value->sid);
				if ($output != '' && $output != false) {
					$output1 = $this->m_reward->check_user($username,$value->sid);
					if ($output1 != '' && $output1 != false) {

						$claimcheck = $this->m_reward->claimcheck($claimid,$value->sid);
						if ($claimcheck != '' && $claimcheck != false) {

							$coupon = $this->m_reward->coupon($claimid,$value->sid);
							if ($coupon != '' && $coupon != false) {
								$message=array(
								'status' => true,
								'data'	=> $coupon,
								'message' => 'Smart code retrieved successfully');
								// success 200 code send
								$this->response($message, REST_Controller::HTTP_OK);
							}else{

								$message=array(
								'status' => FALSE,
								'message' => 'Claim request is in progress, you are not allowed to view the smart code');
								$this->response($message, REST_Controller::HTTP_NOT_FOUND);
							}

						}else{

							$message=array(
							'status' => FALSE,
							'message' => 'Invalid claim id'
							);
							$this->response($message, REST_Controller::HTTP_NOT_FOUND);

						}

					}else{
						$message=array(
						'status' => FALSE,
						'message' => 'Invalid Nickname or Mobile number'
						);
						$this->response($message, REST_Controller::HTTP_NOT_FOUND);
					}
				}else{
					$message=array(
					'status' => FALSE,
					'message' => 'Invalid password'
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


}