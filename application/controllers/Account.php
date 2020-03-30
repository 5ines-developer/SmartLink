<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('sid') == '') {
            redirect('login', 'refresh');
        }
        $this->load->model('m_account');
        $this->load->model('m_authendication');
        $this->data = $this->get_notification();
    }
    //  profile
    public function index()
    {
        $data['breadcrumbs'] = false;
        $data['title']       = 'Account - Smart Link';
        $uid                 = $this->session->userdata('sid');
        $data['alert']       = $this->data;
        $input               = $this->input->post();
        if (count($input) > 0) {
            $this->form_validation->set_rules('name', 'Name', 'trim');
            if ($this->form_validation->run() == true) {
                $insert = array(
                    'agent_name' => $input['name'],
                    // 'agent_email' => $input['email'],
                    // 'agent_address' => $input['address'],
                    'agent_phone' => $input['phone']
                );
                if ($this->m_account->updateProfile($insert, $uid)) {
                    $this->session->set_flashdata('success', 'Profile details has been updated successfully!');
                    redirect('account', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Unable to update your profile details, Please try again later!');
                    redirect('account', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Unable to update your profile details, Please try again later!');
                redirect('account', 'refresh');
            }
        } else {
            $data['profile'] = $this->m_account->profileGet($uid);
            $this->load->view('account/account', $data, false);
        }
    }

    // refer a friend -> agent
    public function refer_friend($var = null)
    {
        $data['alert']   = $this->data;
        $data['title']   = 'Refer a Friend - Smart Link';
        $data['product'] = $this->m_account->product();
        $this->load->view('account/refer-friend', $data, false);
    }

    public function insert_refer($var = null)
    {
        $data['alert'] = $this->data;
        $data['title'] = 'Refer a Friend - Smart Link';
        $this->form_validation->set_rules('name', 'Name', 'trim');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if ($this->form_validation->run() == true) {
            $name          = $this->input->post('name');
            $phone         = $this->input->post('phone');
            $email         = $this->input->post('email');
            $company       = $this->input->post('company');
            $location      = $this->input->post('location');
            $product       = $this->input->post('category');
            $area          = $this->input->post('area');
            $telecom_type  = $this->input->post('telecom_type');
            $it_type       = $this->input->post('it_type');
            $customer_type = $this->input->post('customer_type');
            $sub_product   = $this->input->post('service');
            $description   = $this->input->post('description');
            $agentId       = $this->session->userdata('sid');
            $uniq          = $this->input->post('uniq');
            $edit          = $this->input->post('edit');
            $notiuniq      = $this->input->post('notiuniq');
            
            $insert        = array(
                'agent_id' => $agentId,
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
                if ($product =='telecom') {
                    $insert['product'] = $product;
                    $insert['telecom_type'] = $telecom_type;
                    $insert['customer_type'] = $customer_type;
                    $insert['sub_product'] = $sub_product;
                    $insert['it_type'] = '';
                }else if ($product =='it'){
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
            $output        = $this->m_account->insert_referrals($insert);

            $notification  = array(
                'notification_subject' => 'Refer a friend',
                'notification_description' => 'new refer a friend request added by ' . $name . ' , check and verify',
                'added_by' => $this->session->userdata('sid'),
                'thing_id' => $uniq,
                'notification_type' => '1',
                'added_by_type' => 'agent',
                'noti_to_type' => 'admin'
            );
            if (!empty($edit)) {
                 $notification['uniq'] = $notiuniq;
            }else{
                $notification['uniq'] = random_string('alnum', 10);
            }
                $notioutput    = $this->notification($notification);
            $emailoutput   = $this->sendreferrals($insert);
            if ($output != '' && $notioutput != '') {
                $this->session->set_flashdata('success', 'Friend reference has been Submitted Successfully');
                redirect('referal-list', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                if (!empty($edit)) {
                   redirect('refer-a-friend/edit/'.$uniq, 'refresh');
                }else{
                    redirect('refer-a-friend', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Something went wrong please try again!');
                if (!empty($edit)) {
                   redirect('refer-a-friend/edit/'.$uniq, 'refresh');
                }else{
                    redirect('refer-a-friend', 'refresh');
                }
        }
    }
    //  send refer a friend request to admin
    public function sendreferrals($insert = '')
    {

        $this->load->config('email');
        $this->load->library('email');
        $from = $this->config->item('smtp_user');
        $msg  = '<!DOCTYPE html>
            <html>
                <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                                <p style="width: 80%">Refer a friend request from ' . $this->session->userdata('suser') . ' </p> <br>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <table>
                                    <tr>
                                        <th>Agent : </th>
                                        <td>' . $this->session->userdata('suser') . '</td>
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
                                                    <td>' . $insert['sub_product'] . '</td>
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
            </html>
';
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Smart Link');
        $this->email->to('Info@smartlink.ae');
        $this->email->cc('Naeem.k@smartlink.ae');
        // $this->email->to('rishabhm@5ine.in');
        $this->email->subject('Refer a friend request');
        $this->email->message($msg);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    // refer a friend -> edit
    public function edit_refer($id = null)
    {
        $data['alert']   = $this->data;
        $data['title']   = 'Refer a Friend - Smart Link';
        $data['product'] = $this->m_account->product();
        $data['refer'] = $this->m_account->edit_refer($id);
        $this->load->view('account/refer-friend', $data, false);
    }

    // refer a friend -> delete
    public function delete_refer($id = null)
    {
        $data['alert']   = $this->data;
        $data['title']   = 'Refer a Friend - Smart Link';
        if($this->m_account->delete_refer($id))
        {
            $this->session->set_flashdata('success', 'Friend reference has been deleted Successfully');
            redirect('referal-list', 'refresh'); 
        }else{
            $this->session->set_flashdata('error', 'Something went wrong please try again!');
            redirect('referal-list', 'refresh');
        }
        
    }


    public function view_refer($id='')
    {
       $data['alert']   = $this->data;
       $data['title']   = 'Refer a Friend - Smart Link';
       $data['refer'] = $this->m_account->edit_refer($id);
       $this->load->view('account/view-referal', $data, false);
    }



    // change password
    public function change_psw()
    {
        $data['alert']       = $this->data;
        $data['breadcrumbs'] = false;
        $data['title']       = 'Change password';
        $uid                 = $this->session->userdata('sid');
        $input               = $this->input->post();
        if (count($input) > 0) {
            $this->form_validation->set_rules('current_pws', 'Current Password', 'trim|required|callback_checkpsw_check');
            $this->form_validation->set_rules('new_pws', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('conf_pws', 'Password Confirmation', 'trim|required|matches[new_pws]');
            if ($this->form_validation->run() == true) {
                $hash  = $this->bcrypt->hash_password($input['new_pws']);
                $datas = array(
                    'agent_password' => $hash
                );
                if ($this->m_account->changePassword($datas, $uid, $input['current_pws'])) {
                    $this->session->set_flashdata('success', 'Your password has been Changed successfully');
                    redirect('change-password', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Invalid Current password!');
                    redirect('change-password', 'refresh');
                }
            } else {
                $this->load->view('account/change-psw', $data, false);
            }
        } else {
            $this->load->view('account/change-psw', $data, false);
        }
    }
    // phone number function
    public function phone_check($phone)
    {
        if ($this->m_account->phone_check($phone)) {
            return true;
        } else {
            $this->form_validation->set_message('phone_check', 'Invalid {field}');
            return false;
        }
    }
    // refer a friend -> agent
    public function referal_list($refid = null)
    {
        $data['alert']   = $this->data;
        $data['title']   = 'List Of Referals - Smart Link';
        $data['referal'] = $this->m_account->referal_list($refid);
        $this->load->view('account/referal-list', $data, false);
    }
    //reward-point -> agent
    public function reward_point($var = null)
    {
        $data['alert']   = $this->data;
        $data['reward']  = $this->m_account->reward_point();
        $data['claimed'] = $this->m_account->claimed_point();
        $this->load->view('account/reward-point', $data);
    }
    //claim reward point
    public function claim_reward($var = null)
    {
        $this->form_validation->set_rules('reward', 'Reward Point', 'trim|required');
        if ($this->form_validation->run() == true) {
            $claimed_points = $this->input->post('reward');
            $agent_id       = $this->session->userdata('sid');
            $uniq           = $this->input->post('uniq');
            $insert         = array(
                'claimed_points' => $claimed_points,
                'agent_id' => $agent_id,
                'uniq' => $uniq
            );

            $eligible = $this->m_account->eligible_check($insert);
            if (!empty($eligible) && $eligible!=FALSE) {
            $ouput1         = $this->m_account->insert_claimrequest($insert);
            $notification   = array(
                'notification_subject' => 'Claim reward points',
                'notification_description' => 'agent has requested to claim the reward points',
                'added_by' => $this->session->userdata('sid'),
                'thing_id' => $uniq,
                'notification_type' => '2',
                'uniq' => random_string('alnum', 10),
                'added_by_type' => 'agent',
                'noti_to_type' => 'admin'
            );
            $ouput2         = $this->notification($notification);
            if ($ouput1 != '' && $ouput2 != '') {
                $this->session->set_flashdata('success', 'Reward points claim request has been submitted successfully');
                redirect('reward-points', 'refresh');
            }

        }else{
                $this->session->set_flashdata('error', 'Unable to complete the redemption request, you have insufficient Reward Points');
                redirect('reward-points', 'refresh');
        }
        } else {
            $this->session->set_flashdata('error', 'Unable to process your request, Please try again!');
            redirect('reward-points', 'refresh');
        }
    }
    //list of claims
    public function claims($refid = null)
    {
        $data['alert'] = $this->data;
        $data['title'] = 'List Of Claims - Smart Link';
        $data['claim'] = $this->m_account->claim_list($refid);
        $this->load->view('account/claim-list', $data);
    }
    public function code_auth(Type $var = null)
    {
        $name     = $this->input->post('name');
        $password = $this->input->post('password');
        $claimid  = $this->input->post('claimid');
        $output   = $this->checkpsw_check($password);
        if ($output != '') {
            if ($data['claim'] = $this->m_account->check_user($name)) {
                $data['coupon'] = $this->m_account->coupon($claimid);
                echo $data['coupon'];
            } else {
                echo 'error';
            }
            
        } else {
            echo 'wrong password';
        }
    }
    //**forgot password
    public function claim_forgot($value = '')
    {
        $mobile        = $this->input->post('mobile');
        $otp           = random_string('numeric', '6');
        $country_code = '971';
        $data['phone'] = $country_code.$mobile;
        if ($result = $this->m_account->forgotPassword($mobile, $otp,$country_code)) {
            $msg  = 'Your One time Password For Smart Link Password reset is ' . $otp . ' . Do not share with anyone';
            $data = $this->otpsend($data['phone'], $otp, $msg);
            echo $data;
        } else {
            echo 'wrong mobile';
        }
        
    }
    //  otp Forgot password
    public function otpsend($phone, $otp, $msg)
    {
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
    public function forgot_verify()
    {
        $otp            = $this->input->Post('otp');
        $phone          = $this->input->Post('phone');
        $country_code = '971';

        $data['output'] = $this->m_authendication->forgot_verify($otp, $phone,$country_code);
        if ($data['output'] == '') {
            $this->session->set_flashdata('error', 'you have tried more than 2 attempts, Please enter your mobile number and try again');
            echo $data['output'];
        } else if (!empty($data['output']['agent_id'])) {
            $this->session->set_flashdata('success', 'OTP has been verified Successfully, you can set a new password now');
            echo 'success';
        } else if (!empty($data['output']['otpcount'])) {
            $this->session->set_flashdata('error', 'Invalid OTP!, Please try again with valid OTP');
            echo $data['output']['otpcount'];
        }
    }
    // forgot password set
    public function forgot_password_set()
    {
        $refid          = random_string('numeric', 6);
        $mobile         = $this->input->post('s_phone');
        $otp            = $this->input->post('otp_code');
        $password       = $this->input->post('n_password');
        $cpass          = $this->input->post('c_password');
        $hash           = $this->bcrypt->hash_password($password);
        $datas          = array(
            'otp' => $refid,
            'agent_password' => $hash
        );
        $data['output'] = $this->m_authendication->setPassword($datas, $mobile, $otp);
        if ($data['output'] != '') {
            $this->session->set_flashdata('success', 'Your password has been updated successfully, you can login now with the new password!');
            echo "success";
        } else {
            $this->session->set_flashdata('error', 'Invalid Phone Number');
            echo "error";
        }
    }
    public function resend_code($value = '')
    {
        $phone         = $this->input->get('mobile');
        $otp           = random_string('numeric', '6');
        $country_code = '971';
        $data['phone'] = $country_code.$phone;
        $msg           = 'Your One time Password For Smart Link reset password is ' . $otp . ' . Do not share with anyone';
        $data['phone'] = $phone;
        if ($this->m_authendication->resend_code($phone, $otp,$country_code)) {
            if ($this->otpsend($data['phone'], $otp, $msg)) {
                echo 'success';
            } else {
                $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                echo 'error';
            }
        } else {
            echo 'wrong mobile';
        }
    }
    // insert notification
    public function notification($notification = '')
    {
        if ($this->m_account->insert_notification($notification)) {
            return true;
        } else {
            return false;
        }
    }
    // notification
    public function get_notification($id = '')
    {
        $datas = $this->m_account->get_noti();
        return $datas;
    }
    public function noti_view($itemid = '', $notitype = '', $uniq = '')
    {
        $data['seen'] = $this->m_account->noti_seen($uniq);
        if ($notitype == '1') {
            redirect('referal-list/' . $itemid, 'refresh');
        } elseif ($notitype == '2') {
            redirect('claim-list/' . $itemid, 'refresh');
        }
    }
    //all notification
    public function notification_dash($id = '')
    {
        $data['noti']  = $this->m_account->all_noti();
        $data['title'] = 'Notification - Smart Link';
        $data['alert'] = $this->data;
        $this->load->view('account/notification', $data);
    }
    
    // psw check function
    public function checkpsw_check($psw)
    {
        if ($this->m_account->checkpsw($psw)) {
            return true;
        } else {
            $this->form_validation->set_message('checkpsw_check', 'Invalid {field}');
            return false;
        }
    }
}
/* End of file account.php */