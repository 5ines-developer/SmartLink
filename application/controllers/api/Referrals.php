<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Referrals extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('apiModel/M_referrals','m_referrals');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}


	/**
	*	Refer A friend
	*	@method : Post
	*	@url 	: api/agent/refer-friend
	*/ 
	public function insertRefer_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|min_length[9]|max_length[9]');
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
				$agent = 	$value->suser;
				$input = $this->input->post();
				$uniq = random_string('alnum', 16);
				$name 			= $this->input->post('name');
				$phone 			= $this->input->post('phone');
				$location 		= $this->input->post('location');
				$email 			= $this->input->post('email');
				$area 			= $this->input->post('area');
				$company 		= $this->input->post('company');
				$description 	= $this->input->post('description');
				$product 		= $this->input->post('category');
				$telecom_type 	= $this->input->post('telecom_type');
				$customer_type 	= $this->input->post('customer_type');
				$sub_product 	= $this->input->post('service');
				$it_type 		= $this->input->post('it_type');


				$insert        = array(
	                'agent_id' => $value->sid,
	                'referee_name' => $name,
	                'referee_phone' => $phone,
	                'referee_location' => $location,
	                'refree_email' => $email,
	                'refree_area' => $area,
	                'refree_company' => $company,
	                'uniq' => $uniq,
	                'description' => $description
            	);

            	if (!empty($product)) {
	                if ($product =='telecom' || $product =='Telecom' ) {
	                    $insert['product'] = $product;
	                    $insert['telecom_type'] = $telecom_type;
	                    $insert['customer_type'] = $customer_type;
	                    $insert['sub_product'] = $sub_product;
	                    $insert['it_type'] = '';
	                }else if ($product =='it' || $product =='IT' || $product =='It'){
	                    $insert['product'] = $product;
	                    $insert['telecom_type'] = '';
	                    $insert['customer_type'] ='';
	                    $insert['sub_product'] = '';
	                    $insert['it_type'] = $it_type; 
	                }
	            }else{
	                $insert['product'] = '';
	                $insert['telecom_type'] = '';
	                $insert['customer_type'] ='';
	                $insert['sub_product'] = '';
	                $insert['it_type'] = '';
	            }
	           

	            $output        = $this->m_referrals->insert_referrals($insert);

	            if (!empty($output) AND $output != FALSE) {

	            	$notification  = array(
		                'notification_subject' => 'Refer a friend',
		                'notification_description' => 'New refer a friend request added by ' . $name . ' , check and verify',
		                'added_by' => $value->sid,
		                'thing_id' => $uniq,
		                'notification_type' => '1',
		                'added_by_type' => 'agent',
		                'noti_to_type' => 'admin',
		                'uniq' => random_string('alnum', 10)
            		);

	            	$emailoutput   = $this->sendreferrals($insert,$agent);
	            	$notioutput    = $this->notification($notification);

	            	if (!empty($output) AND $output != FALSE) {

	            		$message=array(
						'status' => true,
						'message' => 'Friend reference has been Submitted Successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);

	            	}else{

	            		$message=array(
						'status' => FALSE,
						'message' => 'Something went wrong please try again later!'
						);
						$this->response($message, REST_Controller::HTTP_NOT_FOUND);
	            	}
				}else{
					$message=array(
					'status' => FALSE,
					'message' => 'Something went wrong please try again later!'
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

	 //  send refer a friend request to admin
    public function sendreferrals($insert = '',$agent='')
    {
    	
    	$subprod        = $this->m_referrals->serviceGet($insert['sub_product']);
        $this->load->config('email');
        $this->load->library('email');
        $from = $this->config->item('smtp_user');
        $msg  = '<!DOCTYPE html>
            <html>
                <head>
                    <title>
                    </title>
                </head>
                <body style="background-color:rgb(224, 224, 224)">
                    <br><br>
                    <center>
                    <table bgcolor="#ffff"  width="60%" style="background-color:#ffff">
                        <tr>
                            <td>
                                <center>
                                <h1>Refer a friend request</h1>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <p style="width: 80%">Refer a friend request from ' . $agent . ' </p> <br>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <table>
                                    <tr>
                                        <th>Agent : </th>
                                        <td>' . $agent . '</td>
                                    </tr>
                                    <tr>
                                        <th>Refree Name : </th>
                                        <td>' .(!empty($insert['referee_name'])?$insert['referee_name']:'' ). '</td>
                                    </tr>
                                    <tr>
                                        <th>Refree Email : </th>
                                        <td>'.(!empty($insert['refree_email'])?$insert['refree_email']:'' ). '</td>
                                    </tr>
                                    <tr>
                                        <th>Referee Phone : </th>
                                        <td>' .(!empty($insert['referee_phone'])?$insert['referee_phone']:'') . '</td>
                                    </tr>
                                    <tr>
                                        <th>Referee Company : </th>
                                        <td>' . (!empty($insert['refree_company'])?$insert['refree_company']:'') . '</td>
                                    </tr>
                                    <tr>
                                        <th>Referee location : </th>
                                        <td>' . (!empty($insert['referee_location'])?$insert['referee_location']:''). '</td>
                                    </tr>
                                    <tr>
                                        <th>Referee Area : </th>
                                        <td>' .(!empty($insert['refree_area'])?$insert['refree_area']:''). '</td>
                                    </tr>
                                    <tr>
                                        <th>Category : </th>
                                        <td>' . (!empty($insert['product'])?$insert['product']:'' ). '</td>
                                    </tr> ';

                                    


                                    if(!empty($insert['product'])){
                                if ($insert['product'] == 'it' || $insert['product'] =='IT' || $insert['product'] =='It' ) {
                                    $msg .= ' <tr>
                                                    <th>Product : </th>
                                                    <td>' . (!empty($insert['it_type'])?$insert['it_type']:'' ). '</td>
                                                </tr>';
                                } else if ($insert['product'] =='telecom' || $insert['product'] =='Telecom' ) {
                                    $msg .= '<tr>
                                                    <th>Telecom Type : </th>
                                                    <td>' . (!empty($insert['telecom_type'])?$insert['telecom_type']:'' ). '</td>
                                                </tr>
                                                <tr>
                                                    <th>Service : </th>
                                                    <td>' .(!empty($subprod)?$subprod:'' ). '</td>
                                                </tr>';
                                }}
                    $msg .= ' <tr>
                                        <th>Customer Type : </th>
                                        <td>' . (!empty($insert['customer_type'])?$insert['customer_type']:'' ) . '</td>
                                    </tr>
                                    <tr>
                                        <th>Description : </th>
                                        <td>' . (!empty($insert['description'])?$insert['description']:'' ) . '</td>
                                    </tr>
                                </table>
                                </center>
                            </td>
                        </tr>
                        <tr >
                            <td >
                                <p style="width: 80%"><center></center></p><br>
                            </td>
                        </tr>
                    </table>
                    </center>
                    <br><br>
                </body>
            </html> ';
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Smart Link');
        $this->email->to('info@smartlink.ae');
        $this->email->to('naeem.k@smartlink.ae');
        $this->email->subject('Refer a friend request');
        $this->email->message($msg);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    // insert notification
    public function notification($notification = '')
    {
        if ($this->m_referrals->insert_notification($notification)) {
            return true;
        } else {
            return false;
        }
    }




   	/**
	*	Refer A friend List
	*	@method : get
	*	@url 	: api/v1/referrals
	*/ 
    public function referrals_get($id = null)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_referrals->referal_list($value->sid);

			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'Referrals retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No Results found'
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
	*	Refer A friend Edit
	*	@method : get
	*	@url 	: api/agent/refer-friend/edit//$id
	*/ 
    public function edit_refer_get($id = null)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_referrals->edit_refer($value->sid,$id);


		if (!empty($output) AND $output != FALSE) {

			$output1 = $this->m_referrals->product();
			$output2 = $this->m_referrals->notidet($output['uniq'],$value->sid);
			$now = strtotime(date("Y-m-d H:i:s"));
            $status_date = strtotime($output['referee_addedon']);
            $x = date($now-$status_date);
            $dif =  ($x/60);

            if ($dif <= '10') {
            	$message=array(
				'status' => true,
				'data'	=> $output,$output1,$output2,
				'message' => 'Referal retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
            }else{

            	$message=array(
				'status' => FALSE,
				'message' => 'You are not allowed to edit this data, you can edit the referral within 10 min from you submitted the request'
				);
				$this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }

        }else{
				$message=array(
				'status' => FALSE,
				'message' => 'No Results found'
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
	*	Refer A friend
	*	@method : Post
	*	@url 	: api/agent/refer-friend/update
	*/ 
	public function updateRefer_post($value='')
	{
		header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|min_length[9]|max_length[9]');
        $this->form_validation->set_rules('uniq', 'Referral id', 'required');
        $this->form_validation->set_rules('noti_id', 'Notification id', 'required');
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
				foreach ($is_valid_token as $key => $value) { } // XSS Clean
				$input = $this->input->post();
	            $uniq 			= $this->input->post('uniq');
	            $name 			= $this->input->post('name');
				$phone 			= $this->input->post('phone');
				$location 		= $this->input->post('location');
				$email 			= $this->input->post('email');
				$area 			= $this->input->post('area');
				$company 		= $this->input->post('company');
				$description 	= $this->input->post('description');
				$product 		= $this->input->post('category');
				$telecom_type 	= $this->input->post('telecom_type');
				$customer_type 	= $this->input->post('customer_type');
				$sub_product 	= $this->input->post('service');
				$it_type 		= $this->input->post('it_type');

				$insert        = array(
	                'agent_id' => $value->sid,
	                'referee_name' => $name,
	                'referee_phone' => $phone,
	                'referee_location' => $location,
	                'refree_email' => $email,
	                'refree_area' => $area,
	                'refree_company' => $company,
	                'uniq' => $uniq,
	                'description' => $description
            	);

            	if (!empty($product)) {
	                if ($product =='telecom' || $product =='Telecom' ) {
	                    $insert['product'] = $product;
	                    $insert['telecom_type'] = $telecom_type;
	                    $insert['customer_type'] = $customer_type;
	                    $insert['sub_product'] = $sub_product;
	                    $insert['it_type'] = '';
	                }else if ($product =='it' || $product =='IT' || $product =='It'){
	                    $insert['product'] = $product;
	                    $insert['telecom_type'] = '';
	                    $insert['customer_type'] ='';
	                    $insert['sub_product'] = '';
	                    $insert['it_type'] = $it_type; 
	                }
	            }else{
	                $insert['product'] = '';
	                $insert['telecom_type'] = '';
	                $insert['customer_type'] ='';
	                $insert['sub_product'] = '';
	                $insert['it_type'] = '';
	            }


	            $output   = $this->m_referrals->insert_referrals($insert);

	            if (!empty($output) AND $output != FALSE) {

	            	$notification  = array(
		                'notification_subject' => 'Refer a friend',
		                'notification_description' => 'New refer a friend request added by ' . $input['name'] . ' , check and verify',
		                'added_by' => $value->sid,
		                'thing_id' => $input['uniq'],
		                'notification_type' => '1',
		                'added_by_type' => 'agent',
		                'noti_to_type' => 'admin',
		                'uniq' => $input['noti_id']
            		);

	            	$emailoutput   = $this->sendreferrals($insert);
	            	$notioutput    = $this->notification($notification);

	            	if (!empty($output) AND $output != FALSE) {

	            		$message=array(
						'status' => true,
						'message' => 'Friend reference has been Submitted Successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);

	            	}else{

	            		$message=array(
						'status' => FALSE,
						'message' => 'Something went wrong please try again later!'
						);
						$this->response($message, REST_Controller::HTTP_NOT_FOUND);
	            	}
				}else{
					$message=array(
					'status' => FALSE,
					'message' => 'Something went wrong please try again later!'
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
	*	Refer A friend Edit
	*	@method : get
	*	@url 	: api/agent/refer-friend/delete/$id
	*/ 
    public function delete_refer_delete($id = null)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_referrals->edit_refer($value->sid,$id);
			$now = strtotime(date("Y-m-d H:i:s"));
            $status_date = strtotime($output['referee_addedon']);
            $x = date($now-$status_date);
            $dif =  ($x/60);
            if (!empty($output) AND $output != FALSE) {
            	if ($dif < '10') {
            		$output1 = $this->m_referrals->delete_refer($output['uniq'],$value->sid);

	            	if (!empty($output1) AND $output1 != FALSE) {
						$message=array(
						'status' => true,
						'message' => 'Referral deleted Successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);
					}else{
						$message=array(
						'status' => FALSE,
						'message' => 'Something went wrong please try again later!'
						);
						$this->response($message, REST_Controller::HTTP_NOT_FOUND);
					}
	            }else{

	            	$message=array(
					'status' => FALSE,
					'message' => 'You are not allowed to delete this data, you can edit the referral within 10 min from you submitted the request'
					);
					$this->response($message, REST_Controller::HTTP_NOT_FOUND);
	            }

            }else{

            	$message=array(
				'status' => FALSE,
				'message' => 'Invalid referral id'
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



    public function category_get($id = null)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_GET);
		//load authorization token library
		$this->load->library('Authorization_Token');
		$is_valid_token = $this->authorization_token->validateToken();
		if (!empty($is_valid_token) && $is_valid_token['status'] === true) 
		{
			foreach ($is_valid_token as $key => $value) { }
			$output = $this->m_referrals->category();

			if (!empty($output) AND $output != FALSE) {
				$message=array(
				'status' => true,
				'data'	=> $output,
				'message' => 'category retrieved successfully'
				);
				// success 200 code send
				$this->response($message, REST_Controller::HTTP_OK);
			}else{
				$message=array(
				'status' => FALSE,
				'message' => 'No Results found'
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
    
    
    
    public function shareFriend_post($id = null)
    {
    	header("Access-Control-Allow-Origin: *");
		$data = $this->security->xss_clean($_POST);
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[9]|max_length[9]');
        $this->form_validation->set_rules('name', 'Name', 'required');
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
				$mobile = $this->input->post('mobile');
				$name 	= $this->input->post('name');
				$uniq = random_string('alnum', 16);
				
				$country_code = '971';
				
				$phone  =  $country_code.$mobile;

				  $insert = array(
				     'agent_id' => $value->sid,
				  	'referee_name' => $name, 
				  	'referee_phone' => $mobile,
				  	'type' =>'1',
				  	'uniq' => random_string('alnum', 10),
				  );

				$output   = $this->m_referrals->insert_referrals($insert);

				$notification  = array(
		                'notification_subject' => 'Share with a friend',
		                'notification_description' => 'New share to friend request added by ' . $name . ' , check and verify',
		                'added_by' => $value->sid,
		                'thing_id' => $uniq,
		                'notification_type' => '1',
		                'added_by_type' => 'agent',
		                'noti_to_type' => 'admin',
		                'uniq' => random_string('alnum', 10)
            	);

	            	$notioutput    = $this->notification($notification);
	            	$notioutput    = $this->shareSms($phone);

	            	if (!empty($output) AND $output != FALSE) {

	            		$message=array(
						'status' => true,
						'message' => 'Share Link has been sent Successfully'
						);
						// success 200 code send
						$this->response($message, REST_Controller::HTTP_OK);

	            	}else{

	            		$message=array(
						'status' => FALSE,
						'message' => 'Something went wrong please try again later!'
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
	*	IOS Share sms links
	*	@method : post
	*/ 
    public function shareSms($phone='')
    {
    	$msg = 'Join me on Smarlink Telecom  by installing the app from below link to fulfill your requirements on telecom services.https://apps.apple.com/us/app/smartlink-telecom/id1481769188?ls=1';
    	

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