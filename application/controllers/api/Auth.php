<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apiModel/M_auth','m_auth');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}

	/**
	*	register New Agent
	*	@method : post
	*	@url 	: api/agent/register
	*/ 
	public function register_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);

		$this->form_validation->set_rules('phone', 'Phone number', 'required|max_length[9]|min_length[9]|is_unique[agent.agent_phone]',array('is_unique' => 'This %s is already exist'));
        $this->form_validation->set_rules('nickname', 'Nick Name', 'required|is_unique[agent.agent_name]',array('is_unique' => 'This %s is already exist'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('terms', 'Terms & Condition', 'trim|required');
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

			$ref['output'] = '1';
			$country_code = '971';
			$otp = random_string('numeric', '6');
			$input = $this->input->post();

			if (!empty($input['ref_code'])) {
                $ref['output'] = $this->m_auth->isreference($input['ref_code']);
             }

              if (empty($ref['output']) AND $ref['output'] == FALSE) {

              			$message=array(
								'status' => FALSE,
								'message' => 'Invalid referrence code please enter the correct one or keep it blank'
							);

              			$this->response($message, REST_Controller::HTTP_NOT_FOUND);

				}else{


							$insert = array(
			              		  'agent_reference_id' => random_string('alnum', 50),
			              		  'agent_phone' => $input['phone'],
			                		'agent_password' => $this->bcrypt->hash_password($input['password']),
			              		  'agent_name' => $input['nickname'],
			              		  'agent_terms_condition' => '1',
			                		'employee_reference_id' => (!empty($input['ref_code'])?$input['ref_code']:''),
			               		 'agent_country_code' => $country_code,
			               		 'otp' => $otp,
			           		 );

					            $data['phone'] 	= $country_code.$input['phone'];
					            $data['mobile'] = $input['phone'];
					            $data['cntry'] 	= $country_code;

					            $output = $this->m_auth->register($insert);
					            $msg = 'Your One time Password For Smart Link registration is ' . $otp . ' . Do not share with anyone';

					            if ($output > 0 AND !empty($output)) {
					            	$output1 = $this->otpsend($data['phone'], $otp, $msg);
					            	if (!empty($output1)) {
					            		$message=array(
											'status' => true,
											'message' => 'We have sent an OTP to +' . $data['phone'] . ' , Please enter the OTP and verify your account'
										);
										// success 200 code send
										$this->response($message, REST_Controller::HTTP_OK);
					            	}else{
										$message=array(
										'status' => FALSE,
										'message' => 'Agent registration Failed'
										);
										$this->response($message, REST_Controller::HTTP_NOT_FOUND);
									}
					            }else{
									$message=array(
									'status' => FALSE,
									'message' => 'Agent registration Failed'
									);
									$this->response($message, REST_Controller::HTTP_NOT_FOUND);
								}


				}




		}

	}


	/**
	*	account activation
	*	@method : post
	*/ 
    public function otp_verify_post($var = null)
    {
     	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		$this->form_validation->set_rules('phone', 'Mobile No.', 'trim|required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
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
			$input = $this->input->post();
			$data['output'] = $this->m_auth->activateAccount($input['otp'],$input['phone'],$input['country_code']);



			if ((!empty($data['output'])) && $data['output'] == $input['otp']) {
				$message=array(
						'status' => TRUE,
						'message' => 'Your account has been activated successfully, you can login now'
						);
						$this->response($message, REST_Controller::HTTP_OK);

			}else if (empty($data['output']['otpcount'])  && $data['output']['otpcount'] =='') {
				$message=array(
					'status' => FALSE,
					'message' => 'Invalid OTP!, you have tried more than 2 attempts, Please register again'
					);
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);

			}else if (!empty($data['output']['otpcount'])) {
				$max= 3;
				$count = $max - $data['output']['otpcount'];
				$message=array(
					'status' => FALSE,
					'message' => 'Invalid OTP!, Please try again with valid OTP. You have only '.$count.' attempts left');
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);

			}

		}
    }


   	/**
	*	login
	*	@method : post
	*	@param : nickname/mobile and password
	*	@url 	: api/user/login
	*/ 

	public function login_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);

		$this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
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

			$input = $this->input->post();
			$deviceid = $this->input->post('deviceid');
			// $country_code = '971';
			$country_code = '91';
			$output = $this->m_auth->can_login($input['username'], $input['password'],$country_code);

			if (!empty($output) AND $output != FALSE) {
				//load authorization token library
				$this->load->library('Authorization_Token');

				// generate token
				$token_data['id'] = $output['agent_id'];
				$token_data['sid'] = $output['agent_id'];
				$token_data['suser'] =$output['agent_name'];
				$token_data['deviceid'] =$deviceid;
				$token_data['time'] = time();

				$user_token = $this->authorization_token->generateToken($token_data);

					$return_data=[
						'sid' 	=> $output['agent_id'],
						'suser' => $output['agent_name'],
						'token' => $user_token,
						'deviceid' => $deviceid,
					];

					if (!empty($deviceid)) {
						$this->m_auth->insertDeviceid($deviceid,$output['agent_id']);
					}
					$message=array(
						'status' => true,
						'data'	=> $return_data,
						'message' => 'User login successful'
					);
					// success 200 code send
					$this->response($message, REST_Controller::HTTP_OK);
				
			}else{
				$message=array(
					'status' => FALSE,
					'message' => 'Invalid Credentials'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}

	/**
	*	forgot password
	*	@method : post
	*	@param : mobile 
	*	@url 	: api/v1/forgot-password
	*/ 
	public function forgot_password_post()
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('phone', 'phone', 'required');
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

			$mobile = $this->input->post('phone');
            $otp = random_string('numeric', '6');
            $country_code = '971';
            $data['phone'] = $country_code.$mobile;
            $data['mobile'] = $mobile;
            $data['cntry'] = $country_code;



			//load authorization token library
			$this->load->library('Authorization_Token');
			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				foreach ($is_valid_token as $key => $value) { }
				$output = $this->m_auth->forgotPassword($mobile, $otp,$country_code,$value->sid);
			}else{
            	$output = $this->m_auth->forgotPassword($mobile, $otp,$country_code);
			}
            
            $msg = 'Your One time Password For Smart Link Password reset is ' . $otp . ' . Do not share with anyone';
            if ($output > 0 AND !empty($output)) {
            	$output1 = $this->otpsend($data['phone'], $otp, $msg);
            	if (!empty($output1)) {
            		$message=array(
						'status' => true,
						'message' => 'Enter the OTP which has been sent to your Mobile No. ' . $data['phone'] . ' to reset your password'
					);
					// success 200 code send
					$this->response($message, REST_Controller::HTTP_OK);
            	}else{
					$message=array(
					'status' => FALSE,
					'message' => 'Invalid Phone Number. Please use registered Phone number'
					);
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);
				}
            }else{
					$message=array(
					'status' => FALSE,
					'message' => 'Invalid Phone Number. Please use registered Phone number'
					);
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);
				}
		}
	}

	/**
	*	forgot password - otpverify
	*	@method : post
	*	@param : mobile,otp,country code
	*	@url 	: api/v1/forgot-password-verify
	*/ 
	public function forgot_verify_post()
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('phone', 'phone', 'required');
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
			$input = $this->input->post();
			// $country_code = '971';
			$country_code = '91';


			//load authorization token library
			$this->load->library('Authorization_Token');
			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				foreach ($is_valid_token as $key => $value) { }
				$data['output'] = $this->m_auth->forgot_verify($input['otp'], $input['phone'],$country_code,$value->sid);
			}else{
				$data['output'] = $this->m_auth->forgot_verify($input['otp'], $input['phone'],$country_code);
			}


			if ($data['output']== '') {
			$message=array(
				'status' => FALSE,
				'message' => 'Invalid OTP!, you have tried more than 2 attempts, Please enter your mobile number and try again'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);

			}else if (!empty($data['output']['agent_id'])) {
				$message=array(
						'status' => TRUE,
						'message' => 'OTP has been verified Successfully, you can set a new password now'
						);
						$this->response($message, REST_Controller::HTTP_OK);

			}else if (!empty($data['output']['otpcount'])) {
				$max= 3;
				$count = $max - $data['output']['otpcount'];
				$message=array(
					'status' => FALSE,
					'message' => 'Invalid OTP!, Please try again with valid OTP. You have only '.$count.' attempts left');
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);

		}

		}

    }

	/**
	*	forgot password
	*	@method : post
	*	@param : mobile,otp,password 
	*	@url 	: api/v1/set-password
	*/ 
	public function set_password_post()
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('mobile', 'Mobile No.', 'required');
        $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required|matches[newpassword]');
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
			$input = $this->input->post();
			$datas = array(
                    'otp' => random_string('numeric', 6),
                    'agent_password' => $this->bcrypt->hash_password($input['newpassword']),
                );

						//load authorization token library
			$this->load->library('Authorization_Token');
			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				foreach ($is_valid_token as $key => $value) { }
				$output = $this->m_auth->setPassword($datas, $input['mobile'], $input['otp'],$value->sid);
			}else{
				$output = $this->m_auth->setPassword($datas, $input['mobile'], $input['otp']);
			}

			if(!empty($output))
			{
				$message=array(
				'status' => TRUE,
				'message' => 'Your password has been successfully updated. Plaese login with new password'
				);

				$this->response($message, REST_Controller::HTTP_OK);
			}else{

				$message=array(
				'status' => FALSE,
				'message' => 'Unable to Reset your password , please try again later'
				);

				$this->response($message, REST_Controller::HTTP_NOT_FOUND);

			}
		}
	}

	/**
	*	resend otp for registration
	*	@method : post
	*	@param : phone
	*	@url 	: api/v1/resend-code
	*/ 
	public function resend_code_post()
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('mobile', 'Mobile No.', 'required');
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

			$phone = $this->input->post('mobile');
	        $country_code = '971';
	        $otp = random_string('numeric', '6');
	        $data['phone'] = $country_code.$phone;
	        $data['mobile'] = $phone;
	        $data['cntry'] = $country_code;
	        $msg = 'Your One time Password For Smart Link registration is ' . $otp . ' . Do not share with anyone';

        	//load authorization token library
			$this->load->library('Authorization_Token');
			$is_valid_token = $this->authorization_token->validateToken();
			if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
			{
				foreach ($is_valid_token as $key => $value) { }
				$output = $this->m_auth->resend_code($phone, $otp,$country_code,$value->sid);
			}else{
				$output = $this->m_auth->resend_code($phone, $otp,$country_code);
			}

	        if (!empty($output)) {
	        	$output1 =  $this->otpsend($data['phone'], $otp, $msg);
				if (!empty($output1)) {
					$message=array(
					'status' => true,
					'message' => 'We have sent an OTP to +' . $data['phone'] . ' , Please enter the OTP and verify your account'
					);
					// success 200 code send
					$this->response($message, REST_Controller::HTTP_OK);
				}else{
					$message=array(
					'status' => FALSE,
					'message' => 'Some error occured! Please contact our support team'
					);
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);
				}
	        }			
    	}
	}



    /**
	*	Otp send to mobile
	*	@method : post
	*/ 
    public function otpsend($phone, $otp, $msg)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
        /* API URL */
        $url = 'http://customers.smsmarketing.ae/app/smsapi/index.php';
        $param = 'key=5d380c6faed8b&campaign=6390&routeid=39&type=text&contacts='.$phone.'&senderid=SMART LINK&msg='.$msg;
        
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return $server_output;
    }


}