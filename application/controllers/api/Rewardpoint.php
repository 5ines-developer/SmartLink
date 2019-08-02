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
	*	Agent dashboard
	*	@method : get
	*	@url 	: api/agent/dashboard
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

            echo "<pre>";
            print_r ($output);
            echo "</pre>";exit;

			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'Dashboard detail retrieved successfully'
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
}