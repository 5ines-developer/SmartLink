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
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
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
				$insert        = array(
	                'agent_id' => $value->sid,
	                'referee_name' => $input['name'],
	                'referee_phone' => $input['phone'],
	                'referee_location' => $input['location'],
	                'refree_email' => $input['email'],
	                'refree_area' => $input['area'],
	                'refree_company' => $input['company'],
	                'uniq' => $uniq,
	                'description' => $input['description']
            	);

            	if (!empty($input['product'])) {
	                if ($input['product'] =='telecom') {
	                    $insert['product'] = $input['product'];
	                    $insert['telecom_type'] = $input['telecom_type'];
	                    $insert['customer_type'] = $input['customer_type'];
	                    $insert['sub_product'] = $input['sub_product'];
	                    $insert['it_type'] = '';
	                }else if ($product =='it'){
	                    $insert['product'] = $input['product'];
	                    $insert['telecom_type'] = '';
	                    $insert['customer_type'] ='';
	                    $insert['sub_product'] = '';
	                    $insert['it_type'] = $input['it_type']; 
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
		                'notification_description' => 'New refer a friend request added by ' . $input['name'] . ' , check and verify',
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
                                if ($insert['product'] == 'it') {
                                    $msg .= ' <tr>
                                                    <th>Product : </th>
                                                    <td>' . $insert['it_type'] . '</td>
                                                </tr>';
                                } else if ($insert['product'] == 'telecom') {
                                    $msg .= '<tr>
                                                    <th>Telecom Type : </th>
                                                    <td>' . $insert['telecom_type'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Telecom Type : </th>
                                                    <td>' . $insert['telecom_type'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Service : </th>
                                                    <td>' . $subprod . '</td>
                                                </tr>';
                                }}
                    $msg .= ' <tr>
                                        <th>Customer Type : </th>
                                        <td>' . $insert['customer_type'] . '</td>
                                    </tr>
                                    <tr>
                                        <th>Description : </th>
                                        <td>' . $insert['description'] . '</td>
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
        $this->email->to('prathwi@5ine.in');
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
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
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
				$uniq = random_string('alnum', 16);
				$insert        = array(
	                'agent_id' => $value->sid,
	                'referee_name' => $input['name'],
	                'referee_phone' => $input['phone'],
	                'referee_location' => $input['location'],
	                'refree_email' => $input['email'],
	                'refree_area' => $input['area'],
	                'refree_company' => $input['company'],
	                'uniq' => $input['uniq'],
	                'description' => $input['description']
            	);

            	if (!empty($input['product'])) {
	                if ($input['product'] =='telecom') {
	                    $insert['product'] = $input['product'];
	                    $insert['telecom_type'] = $input['telecom_type'];
	                    $insert['customer_type'] = $input['customer_type'];
	                    $insert['sub_product'] = $input['sub_product'];
	                    $insert['it_type'] = '';
	                }else if ($product =='it'){
	                    $insert['product'] = $input['product'];
	                    $insert['telecom_type'] = '';
	                    $insert['customer_type'] ='';
	                    $insert['sub_product'] = '';
	                    $insert['it_type'] = $input['it_type']; 
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
            if ($dif >= '10') {
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
				'message' => 'Invalid Token'
				);
			$this->response($message, REST_Controller::HTTP_NOT_FOUND);
		}
    }

}