<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_noti extends CI_Controller {

	    /*--construct--*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('push_model');
        $this->load->model('referal_model');
        $this->load->model('agent_model');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('string');
        $this->data = $this->notification();
        if ($this->session->userdata('unique_id') == '') {
            $this->session->set_flashdata('error', 'Please login and try again');
            redirect('dashboard');
        }
    }


	/**
	*load all the push notification
	*
	**/
	public function index()
	{
        $data['title'] = 'Push Notification - Smart Link';
        $data['alert'] = $this->data;
        $data['push'] = $this->push_model->get_push();
        $this->load->view('site/push-notification', $data);
	}

	/**
	*load view page to send notification
	*
	**/
	public function send_view()
	{
        $data['title'] = 'Push Notification - Smart Link';
        $data['alert'] = $this->data;
        $data['agent'] = $this->agent_model->get_agents();
        $this->load->view('site/send-push', $data);
	}


	    /**
		* Push notification -> insert  
		* @url : insert/push-notification
		*/
		public function insert_push()
		{
			$description 	    = $this->input->post('description');
			$itemid 		    = $this->input->post('itemid');
			$title 			    = $this->input->post('title');
            $link               = $this->input->post('link');
			$agent 			    = $this->input->post('agent');


            for ($i=0; $i < count($agent) ; $i++) { 
                $notification = array(
                    'notification_subject' => $title,
                    'notification_description' => $description,
                    'added_by' => $this->session->userdata('unique_id'),
                    'thing_id' => $itemid,
                    'notification_type' => '3',
                    'uniq' => random_string('alnum', 10),
                    'noti_to' => $agent[$i],
                    'added_by_type' => 'admin',
                    'noti_to_type' => 'agent',
                    'link' => $link,
                );

                if($this->push_model->insert_notification($notification))
                {
                    $this->push_notification_android($description,$title,$agent[$i]);
                }
            }
            $this->session->set_flashdata('success', 'Push Notification sent successfully');
            redirect('push-notification','refresh');
        }


// 	    // notification
    function push_notification_android($message='',$title='',$agent=''){

        $output = $this->push_model->getdevice($agent);

 


        foreach ($output as $key => $value) {
                    //API URL of FCM
                $url = 'https://fcm.googleapis.com/fcm/send';

                /*api_key available in:
                Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
                $api_key = 'AAAAV9QtMTc:APA91bGpHOhDYDES-xvUZvLJj-Qq4j4pyHS_sS9bEqoSXITtbHlzw9HBExn2WcHHvSwNEOhlvt2zqUldLdIf9TjTx1gg6gpxLJZkOi4AFxiEnUoTUxxtUk1MZUm0MYovkCLO1W8Xq2b2';

                $to = $value->deviceid;
                

                $fields = array (
                    'to' =>( $to ),
                    'notification' => array (
                            "title" => $title,
                            "body" => $message
                    )
                );

                //header includes Content type and api key
                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: key='.$api_key
                );
                            
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                if ($result === FALSE) {
                    die('FCM Send Error: ' . curl_error($ch));
                }
                curl_close($ch);
                return $result;
        }
}


    //                 // notification
    // function push_notification_android($message='',$title='',$agent=''){


    //                 //API URL of FCM
    //             $url = 'https://fcm.googleapis.com/fcm/send';

    //             /*api_key available in:
    //             Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
    //             $api_key = 'AAAAV9QtMTc:APA91bGpHOhDYDES-xvUZvLJj-Qq4j4pyHS_sS9bEqoSXITtbHlzw9HBExn2WcHHvSwNEOhlvt2zqUldLdIf9TjTx1gg6gpxLJZkOi4AFxiEnUoTUxxtUk1MZUm0MYovkCLO1W8Xq2b2';


    //             $fields = array (
    //                 'to' =>( 'fjnpPzxImgQ:APA91bEF2ZJYeddyoJNWD0CNbk0sE3uAA3Kqs0H0VmEJ3xzKO0izITaD_Ik5ioHVtkwh77ULe-GCJWhIjwrvGEvAoXCnCTXVQeLaGO3m0WOzkRVo-KqRnTZ01163unjF5mW1D1AEesT2' ),
    //                 'notification' => array (
    //                         "title" => 'test',
    //                         "body" => 'testing'
    //                 )
    //             );

    //             //header includes Content type and api key
    //             $headers = array(
    //                 'Content-Type: application/json',
    //                 'Authorization: key='.$api_key
    //             );
                            
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //             $result = curl_exec($ch);
    //             echo "<pre>";
    //             print_r ($result);
    //             echo "</pre>";exit();
    //             if ($result === FALSE) {
    //                 die('FCM Send Error: ' . curl_error($ch));
    //             }
    //             curl_close($ch);
    //             return $result;
    // }



    public function notification($id = '')
    {
        $datas = $this->referal_model->get_noti();
        return $datas;
    }

}

/* End of file Push_noti.php */
/* Location: ./application/controllers/Push_noti.php */