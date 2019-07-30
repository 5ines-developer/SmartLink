<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Authendication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data['breadcrumbs'] = false;
        $this->load->helper('string');
        $this->load->library('bcrypt');
        $this->load->library('form_validation');
        $this->load->model('m_authendication');
        $this->load->model('m_account');
        $this->data = $this->get_notification();

    }

    // registration
    public function register()
    {
        $this->load->library('form_validation');

        if ($this->session->userdata('sid') == '') {

            $data['breadcrumbs'] = false;
            $data['title'] = 'Register - Smart Link';

            $data['country_code'] = $this->m_authendication->country_code();
            $input = $this->input->post();
            if (count($input) >= 3) {

                $refid = random_string('alnum', 50);
                $phone = $this->input->post('phone');
                $country_code = '971';
                $password = $this->input->post('password');
                $cpassword = $this->input->post('cpassword');
                $hash = $this->bcrypt->hash_password($password);
                $username = $this->input->post('username');
                $ref_code = $this->input->post('ref_code');
                $terms = $this->input->post('terms');
                $otp = random_string('numeric', '6');
                

                $this->form_validation->set_rules('phone', 'Phone number', 'required|is_unique[agent.agent_phone]');
                $this->form_validation->set_rules('username', 'username', 'required|is_unique[agent.agent_name]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
                $this->form_validation->set_rules('terms', 'Terms & Condition', 'trim|required');
                $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
                if ($this->form_validation->run() == false) {
                    $this->load->view('auth/register', $data, false);
                } else {
                    if (!empty($ref_code)) {
                    $ref['output'] = $this->referencecode_check($ref_code);
                    if (empty($ref['output'])) {
                        $this->session->set_flashdata('error', 'Invalid referrence code please enter the correct one or keep it blank');
                        redirect('register', 'refresh');
                    }
                    }


                    $insert = array(
                        'agent_reference_id' => $refid,
                        'agent_phone' => $phone,
                        'agent_password' => $hash,
                        'agent_name' => $username,
                        'agent_terms_condition' => '1',
                        'employee_reference_id' => $ref_code,
                        'agent_country_code' => $country_code,
                        'otp' => $otp,
                    );
                    $data['phone'] = $country_code.$phone;
                    $data['mobile'] = $phone;
                    $data['cntry'] = $country_code;

                    if ($this->m_authendication->register($insert)) {
                        $msg = 'Your One time Password For smart link registration is ' . $otp . ' . Do not share with anyone';
                        if ($this->otpsend($data['phone'], $otp, $msg)) {
                            $this->session->set_flashdata('success', 'We have sent an OTP to ' . $data['phone'] . ' , Please enter the OTP and verify your account');
                            $data['title'] = 'Account verification - Smart Link';
                            $this->load->view('auth/otp-verify', $data);
                        } else {
                            $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                            redirect('register', 'refresh');
                        }

                    } else {
                        $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                        redirect('register', 'refresh');
                    }
                }
            } else {
                $this->load->view('auth/register', $data, false);
            }

        } else {

            redirect('login', 'refresh');
        }
    }

    public function resend_code($value = '')
    {
        $phone = $this->input->post('mobile');
        $country_code = '971';
        $otp = random_string('numeric', '6');
        $country_code = '971';
        $data['phone'] = $country_code.$phone;
        $data['mobile'] = $phone;
        $data['cntry'] = $country_code;
        $msg = 'Your One time Password For smart link registration is ' . $otp . ' . Do not share with anyone';
        if ($this->m_authendication->resend_code($phone, $otp,$country_code)) {
            if ($this->otpsend($data['phone'], $otp, $msg)) {
                $this->session->set_flashdata('success', 'We have sent an OTP to ' . $data['phone'] . ' , Please enter the OTP and verify your account');
                $data['title'] = 'Account verification - Smart Link';
                $this->load->view('auth/otp-verify', $data);
            } else {
                $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                redirect('register', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
            redirect('register', 'refresh');
        }

    }

    // account activation
    public function otp_verify($var = null)
    {
        $otp = $this->input->get('otp');
        $phone = $this->input->get('phone');
        $country = $this->input->get('country');
        $data['output'] = $this->m_authendication->activateAccount($otp, $phone,$country);

        if ($data['output'] == '') {

            $this->session->set_flashdata('error', 'you have tried more than 2 attempts, Please enter your mobile number and try again');
            echo $data['output'];

        } else if ((!empty($data['output'])) && $data['output'] == $otp) {

            $this->session->set_flashdata('success', 'Your account has been activated successfully, you can login now');
            echo $otp;

        } else if (!empty($data['output']['otpcount'])) {
            $this->session->set_flashdata('error', 'Invalid OTP!, Please try again with valid OTP');
            echo $data['output']['otpcount'];
        }

    }

    // login
    public function login($var = null)
    {
        $data['breadcrumbs'] = false;
        $data['title'] = 'Login';

        if ($this->session->userdata('sid') == '') {
            $input = $this->input->post();
            if (count($input) > 0) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('username', 'username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
                if ($this->form_validation->run() == false) {
                    $this->load->view('auth/login', $data, false);
                } else {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');

                    if ($result = $this->m_authendication->can_login($username, $password)) {
                        $session_data = array(
                            'suser' => $username,
                            'sid' => $result['agent_id'],
                        );

                        $this->session->set_userdata($session_data);
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('error', 'Invalid Username or Password');
                        redirect('login');
                    }
                }

            } else {
                $this->load->view('auth/login', $data, false);
            }

        } else {

            redirect('dashboard', 'refresh');
        }

    }

    // set login session
    public function enter()
    {
        if ($this->session->userdata('sid') != '') {
            $data['alert'] = $this->data;
            $data['title'] = 'Dashboard - Smart Link';
            $data['referal'] = $this->m_authendication->get_referal(); //get referals count
            $data['approved'] = $this->m_authendication->approved_referal(); //get referals count
            $data['pending'] = $this->m_authendication->pending_referal(); //get referals count
            $data['reward']  = $this->m_account->reward_point();
            $data['claimed'] = $this->m_account->claimed_point();
            $this->session->set_flashdata('referal', 'You have earned new reward points');
            $this->load->view('account/dashboard', $data);
        } else {
            redirect('login');
        }
    }

    /* --  logout -- */
    public function logout()
    {
        $this->session->unset_userdata($session_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Successfully Logged out');
        redirect('login');
    }

    // forgot password
    public function forgot_password($mobile = null)
    {

        $data['breadcrumbs'] = false;
        $data['title'] = 'Forgot password';
        if ($this->session->userdata('sid') == '') {

            $input = $this->input->post();
            if (count($input) > 0) {
                $mobile = $this->input->post('mobile');
                $otp = random_string('numeric', '6');
                $country_code = '971';
                $data['phone'] = $country_code.$mobile;
                $data['mobile'] = $mobile;
                $data['cntry'] = $country_code;

                if ($result = $this->m_authendication->forgotPassword($mobile, $otp,$country_code)) {

                    $msg = 'Your One time Password For smart link Password reset is ' . $otp . ' . Do not share with anyone';

                    if ($this->otpsend($data['phone'], $otp, $msg)) {
                        $this->session->set_flashdata('success', 'Enter the OTP which has been sent to your Mobile No. ' . $data['phone'] . ' to reset your password');
                        $this->load->view('auth/forgot-verify', $data);
                    } else {
                        $this->session->set_flashdata('error', 'Some error occured! Please contact our support team or try again');
                        $this->load->view('auth/forgotpassword', $data, false);
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid Phone Number. Please use registered Phone number');
                    redirect('forgot-password');
                }
            } else {
                $this->load->view('auth/forgotpassword', $data, false);

            }
        } else {
            redirect('login');
        }
    }

    public function forgot_verify()
    {
        $data['output']['agent_id'] = '';
        $data['title'] = 'Forgot password';
        $otp = $this->input->Post('otp');
        $phone = $this->input->Post('phone');
        $country = $this->input->Post('cntry');
        $data['output'] = $this->m_authendication->forgot_verify($otp, $phone,$country);

        if ($data['output'] == '') {
            $this->session->set_flashdata('error', 'you have tried more than 2 attempts, Please enter your mobile number and try again');
            echo $data['output'];
        } else if (!empty($data['output']['agent_id'])) {
            $this->session->set_flashdata('success', 'OTP has been verified Successfully, you can set a new password now');
            $load = $this->load->view('auth/set-newpassword', $data, true);
            echo $load;
        } else if (!empty($data['output']['otpcount'])) {
            $this->session->set_flashdata('error', 'Invalid OTP!, Please try again with valid OTP');
            echo $data['output']['otpcount'];
        }

    }

    // forgot password set
    public function forgot_password_set()
    {
        if ($this->session->userdata('sid') == '') {
            $data['breadcrumbs'] = false;
            $data['title'] = 'Reset password';
            $input = $this->input->post();

            $refid = random_string('numeric', 6);
            $mobile = $this->input->post('mobile');
            $otp = $this->input->post('otp');
            $password = $this->input->post('npass');
            $cpass = $this->input->post('cpass');
            $hash = $this->bcrypt->hash_password($password);

            $this->form_validation->set_rules('mobile', 'Mobile No.', 'required');
            $this->form_validation->set_rules('npass', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('cpass', 'Password Confirmation', 'trim|required|matches[npass]');
            if ($this->form_validation->run() == true) {
                $datas = array(
                    'otp' => $refid,
                    'agent_password' => $hash,
                );
                if ($this->m_authendication->setPassword($datas, $mobile, $otp)) {
                    $this->session->set_flashdata('success', 'Your password has been updated successfully, you can login now with the new password!');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('error', 'Invalid Phone Number');
                    redirect('forgot-password');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid Phone Number');
                redirect('forgot-password');
            }
        } else {
            redirect('login');
        }

    }

    //  email Forgot password
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

    public function referencecode_check($str)
    {
        if ($this->m_authendication->isreference($str) == false) {
            $this->session->set_flashdata('error', 'You have entered invalid reference code, please try again with the correct one!');
            return false;
        } else {
            return true;
        }
    }

    // notification
    public function get_notification($id = '')
    {
        $datas = $this->m_account->get_noti();
        return $datas;
    }

}

/* End of file Authendication.php */
