<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Authendication extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $data['breadcrumbs'] = false;
        $this->load->helper('string');
        $this->load->library('bcrypt');
        $this->load->library('form_validation');
        $this->load->model('m_authendication');
        $this->load->model('m_account');

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
        if(count($input) >= 3){
            
            $refid 		= random_string('alnum', 50);
            $phone      = $this->input->post('phone');
            // $country_code = $this->input->post('country_code');
            $country_code = '91';
            $password 	= $this->input->post('password');
            $cpassword 	= $this->input->post('cpassword');
            $hash 		= $this->bcrypt->hash_password($password);
            $username	= $this->input->post('username');
            $ref_code	= $this->input->post('ref_code');
            $terms 		= $this->input->post('terms');
            $otp        = random_string('numeric','6');  

            $this->form_validation->set_rules('phone', 'Phone number', 'required|is_unique[agent.agent_phone]');
            $this->form_validation->set_rules('username', 'username', 'required|is_unique[agent.agent_name]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('terms', 'Terms & Condition', 'trim|required');
            $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE){
                $this->load->view('auth/register', $data, FALSE);
            }
            else{
                if ($ref_code !='') {
                    $this->referencecode_check($ref_code); 
                }

                $insert = array(
                    'agent_reference_id'    => $refid, 
                    'agent_phone'           => $phone, 
                    'agent_password'        => $hash, 
                    'agent_name'            => $username, 
                    'agent_terms_condition' => '1', 
                    'employee_reference_id' => $ref_code,
                    'agent_country_code'    =>  $country_code,
                    'otp'                   => $otp
                );
                    // $data['phone'] = '+'.$country_code.$phone;
                    $data['phone'] = $phone;


                    
                    
                    if($this->m_authendication->register($insert))
                    {
                        $msg = 'Your One time Password For smart link registration is '.$otp.' . Do not share with anyone';
                       if($this->otpsend($phone, $otp,$msg))
                       {
                        $this->session->set_flashdata('success', 'We have sent an OTP to '.$data['phone'].' , Please enter the OTP and verify your account');
                        $data['title'] = 'Account verification - Smart Link';
                        $this->load->view('auth/otp-verify', $data);
                       }else{
                        $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                        redirect('register','refresh');
                       }

                        
                    }else{
                        $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                        redirect('register','refresh');
                    }
            }
        }else{
            $this->load->view('auth/register', $data, FALSE);
        }

    }else{

          redirect('login', 'refresh');
        }
    }

    public function resend_code($value='')
    {
         $phone = $this->input->post('mobile');
         $otp   = random_string('numeric','6'); 
         $msg   = 'Your One time Password For smart link registration is '.$otp.' . Do not share with anyone';
         $data['phone'] = $phone;
         if ($this->m_authendication->resend_code($phone,$otp)) {
             if($this->otpsend($phone,$otp,$msg))
         {
          $this->session->set_flashdata('success', 'We have sent an OTP to '.$phone.' , Please enter the OTP and verify your account');
          $data['title'] = 'Account verification - Smart Link';
          $this->load->view('auth/otp-verify', $data);
         }else{
          $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
          redirect('register','refresh');
         }
         }else{
            $this->session->set_flashdata('error', 'Some error occured! Please contact our support team');
                        redirect('register','refresh');
         }
         
    }


    // account activation
    public function otp_verify($var = null)
    {
        $otp = $this->input->get('otp');
        $phone = $this->input->get('phone');
        $data['output'] = $this->m_authendication->activateAccount($otp,$phone);



            if ($data['output'] == '') {

                $this->session->set_flashdata('error', 'you have tried more than 2 attempts, Please enter your mobile number and try again');
                echo $data['output'];

            }else if ((!empty($data['output'])) && $data['output']== $otp){

                $this->session->set_flashdata('success', 'Your account has been activated successfully, you can login now');
                echo $otp;

            }else if (!empty($data['output']['otpcount'])){
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
        if(count($input) > 0){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
            if ($this->form_validation->run() == FALSE){
                $this->load->view('auth/login', $data, FALSE);
            }else{
                $username = $this->input->post('username'); 
                $password = $this->input->post('password');

				if($result = $this->m_authendication->can_login($username, $password)) 
					{
						$session_data = array(
							'suser' => $username,
                            'sid' 	=> $result['agent_id'],
                        ); 
                        
						$this->session->set_userdata($session_data); 
						redirect('authendication/enter'); 
					} 
				else 
					{
						$this->session->set_flashdata('error', 'Invalid Username or Password'); 
						redirect('login');
					}
            }

        }else{
            $this->load->view('auth/login', $data, FALSE);
        }

            }else{

          redirect('login', 'refresh');
        }
        
    }


    // set login session
    public function enter()
	{
		if($this->session->userdata('sid') != ''){ 
                $data['title'] = 'Account - Smart Link';
                $uid = $this->session->userdata('sid');
                $data['profile'] = $this->m_account->profileGet($uid);
                $this->load->view('account/account', $data, FALSE);
		} 
		else{
				redirect('login');
		} 
	}

    /* --  logout -- */ 
    public function logout() 
	{
		$this->session->unset_userdata($session_data);
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Successfully Logged out');
		redirect(base_url());
    } 
    

    // forgot password
    public function forgot_password($mobile = null)
    {
 
        $data['breadcrumbs'] = false;
        $data['title'] = 'Forgot password';
        if($this->session->userdata('sid') == ''){

        $input = $this->input->post();
        if(count($input) > 0){
            $mobile = $this->input->post('mobile');
            $otp        = random_string('numeric','6'); 
            $data['phone'] = $mobile;
       
            if($result = $this->m_authendication->forgotPassword($mobile,$otp)){

                $msg = 'Your One time Password For smart link Password reset is '.$otp.' . Do not share with anyone';
                $this->otpsend($mobile, $otp,$msg);
                $this->session->set_flashdata('success', 'Enter the OTP which has been sent to your Mobile No. '.$mobile.' to reset your password'); 
				$this->load->view('auth/forgot-verify', $data);
            }else{
                $this->session->set_flashdata('error', 'Invalid Phone Number. Please use registered Phone number'); 
				redirect('forgot-password');
            }
        }else{
            $this->load->view('auth/forgotpassword', $data, FALSE);
            
        }
        } 
        else{
                redirect('login');
        } 
    }

    public function forgot_verify()
    {
        $data['output']['agent_id']='';
        $data['title'] = 'Forgot password';
        $otp = $this->input->Post('otp');
        $phone = $this->input->Post('phone');
        $data['output'] = $this->m_authendication->forgot_verify($otp,$phone);

        if ($data['output'] == '') {
            $this->session->set_flashdata('error', 'you have tried more than 2 attempts, Please enter your mobile number and try again');
            echo $data['output'];
            }else if (!empty($data['output']['agent_id'])){
            $this->session->set_flashdata('success', 'OTP has been verified Successfully, you can set a new password now');
            $load=$this->load->view('auth/set-newpassword',$data, TRUE);
            echo $load ;
        }
        else if (!empty($data['output']['otpcount'])){
             $this->session->set_flashdata('error', 'Invalid OTP!, Please try again with valid OTP'); 
             echo $data['output']['otpcount'];
         }
        

    }

    // forgot password set
    public function forgot_password_set()
    {
        if($this->session->userdata('sid') == ''){
        $data['breadcrumbs'] = false;
        $data['title'] = 'Reset password';
        $input = $this->input->post();

            $refid 		= random_string('numeric', 6);
            $mobile 	= $this->input->post('mobile');
            $otp 	    = $this->input->post('otp');
            $password   = $this->input->post('npass');
            $cpass 	    = $this->input->post('cpass');
            $hash 		= $this->bcrypt->hash_password($password);

            $this->form_validation->set_rules('mobile', 'Mobile No.', 'required');
            $this->form_validation->set_rules('npass', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('cpass', 'Password Confirmation', 'trim|required|matches[npass]');
            if ($this->form_validation->run() == True){
                $datas = array(
                    'otp' => $refid,
                    'agent_password' => $hash,
                );
                if($this->m_authendication->setPassword($datas, $mobile,$otp)){
                    $this->session->set_flashdata('success', 'Your password has been updated successfully, you can login now with the new password!');
                    redirect('login');
                }else{
                    $this->session->set_flashdata('error', 'Invalid Phone Number');
                    redirect('forgot-password');
                }
            }else{
                $this->session->set_flashdata('error', 'Invalid Phone Number');
                redirect('forgot-password');
            }
        }else{
            redirect('login');
        }
        
    }



    //  email Forgot password
    function otpsend($phone, $otp,$msg)
    {
 
         /* API URL */
          $url = 'http://trans.smsfresh.co/api/sendmsg.php';
          $param ='user=5inewebsolutions&pass=5ine5ine&sender=PROPSB&phone='.$phone.'&text='.$msg.'&priority=ndnd&stype=normal';

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST,true);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$param);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          curl_close ($ch);

          return $server_output;
        
    }

    function referencecode_check($str)
    {
            if ($this->m_authendication->isreference($str) == FALSE)
            {
                 $this->session->set_flashdata('error', 'You have entered invalid reference code, please try again with the correct one!');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
    }

}

/* End of file Authendication.php */
