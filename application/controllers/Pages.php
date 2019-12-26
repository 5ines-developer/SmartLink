<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_account');
        $this->load->model('m_authendication');
        $this->load->library('form_validation');
    }


    public function terms($value='')
    {
        $this->load->view('pages/terms-condition.php');
    }
    // landing page
    public function index($value='')
    {
        $this->load->view('pages/index.php');
    }

    public function mobile_device($value='')
    {
        $this->load->view('pages/mobile-device.php');
    }

    public function fixed_service($value='')
    {
        $this->load->view('pages/fixed-service.php');
    }

    public function contact($value='')
    {
        $this->load->view('pages/contact-us.php');
    }


    public function send_contact($value='')
    {
        $n1 = $this->input->post('n1');
		$n2 = $this->input->post('n2');
		$result = $this->input->post('result');
        $s = $n1 + $n2;

        if($result == $s){
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');
            if ($this->form_validation->run() == TRUE) {
                $insert = array(
                    'name'  => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'subject' => $this->input->post('subject'),
                    'message' => $this->input->post('message'),
                    'uniq' => $this->input->post('uniq'),
                );

                if($this->m_account->contactInsert($insert))
                {// 
                    $this->sendEmail($insert);
                    // print_r($insert);exit;
                    $this->load->view('pages/thank-you');
                }else{
                    $this->session->set_flashdata('error','Unable to subit your request <br> Please try agin later.');
                    redirect(base_url(),'refresh');
                }
                
            } else {
                $error = validation_errors();
                $this->session->set_flashdata('formerror',$error);
                redirect(base_url(),'refresh');
            }
        }else{
            $this->session->set_flashdata('error','Invalid Human verification .');
            redirect(base_url(),'refresh');
        }

    }

    public function sendEmail($insert='')
    {
        $data['result'] = $insert;
        
        $this->load->config('email');
        $this->load->library('email');
        $from = $this->config->item('smtp_user');
        $msg = ' <!DOCTYPE html>
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
                                <h1>Enquiry</h1>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <p style="width: 80%">New enquiry has been submitted, details are mentioned below. </p> <br>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <table>
                                    <tr>
                                        <th>Name </th>
                                        <td>: '. (!empty($data['result']['name'])?$data['result']['name']:'')  .'</td>
                                    </tr>
                                    <tr>
                                        <th>Phone </th>
                                        <td>: '.(!empty($data['result']['phone'])?$data['result']['phone']:'')  .'</td>
                                    </tr>
                                    <tr>
                                        <th>Email </th>
                                       <td>: '. (!empty($data['result']['email'])?$data['result']['email']:'')  .'</td>
                                    </tr>
                                    <tr>
                                        <th>Subject </th>
                                        <td>: '. (!empty($data['result']['subject'])?$data['result']['subject']:'')  .'</td>
                                    </tr>
                                    <tr>
                                        <th>Message </th>
                                        <td>: '. (!empty($data['result']['message'])?$data['result']['message']:'')  .'</td>
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
            </html>
';
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Smart Link');
        $this->email->to('info@smartlink.ae');
        $this->email->cc('naeem.k@smartlink.ae');
        $this->email->subject('Enquiry - Smart Link');
        $this->email->message($msg);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }


    public function privacy_policy($value='')
    {
        $this->load->view('pages/privacy-policy.php');
    }

    public function copyright($value='')
    {
        $this->load->view('pages/copyright.php');
    }


    public function marketing($value='')
    {
        $this->load->view('pages/marketing.php');
    }

}