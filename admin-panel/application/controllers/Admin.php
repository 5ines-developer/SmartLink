<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    /*--construct--*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('referal_model');
		$this->data =  $this->notification();

    }

    /**
     * Admin login-> load view page
     * url : login
     */
    public function index()
    {
        if ($this->session->userdata('unique_id') == '') {
            $data['title'] = 'login - Smart Link';
            $this->load->view('auth/login', $data);
        } else {
            redirect('dashboard');
        }
    }

    /**
     * check admin exist
     * @url : login/check
     * @param : email or username , password
     *
     */
    public function form_validation()
    {
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run()) {

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $data['login'] = $this->admin_model->can_login($email, $password);

            if (!empty($data['login'])) {
                if (!empty($data['login']['admin_id'])) {
                    $id = $data['login']['admin_id'];
                    $email = $data['login']['admin_email'];
                }

                $session_data = array('unique_id' => $id, 'adminemail' => $email);
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                redirect('admin');
            }
        } else {

            $error = validation_errors();
            $this->session->set_flashdata('error', $error);
            redirect('admin');
        }
    }

    /**
     * enter admin panel if admin exist
     * @url : login/check
     * @param : email or username , password
     *
     */
    public function enter()
    {
        if ($this->session->userdata('unique_id') != '') {
			$data['alert']   = $this->data;
            $data['title'] = 'Dashboard - Smart Link';
            // $data['order']        = $this->admin_model->getorders();//fetch total orders count
            // $data['user']        = $this->admin_model->getusers();//fetch total users count
            // $data['product']    = $this->admin_model->getproducts();//fetch total products count
            // $data['category']    = $this->admin_model->getcategory();//fetch total categories count
            $this->load->view('site/dashboard.php', $data);
        } else {
            $this->session->set_flashdata('error', 'Please login and try again');
            redirect('admin');
        }
    }

    /**
     * get total orders by month to display in graph
     * @url : Admin/getordergraph
     *
     */
    // public function getordergraph()
    // {
    //     $startdate     = date('Y-m-d H:i:s',strtotime(date('Y-01-01'))); //start date of the year (jan first)
    //     $result        = $this->admin_model->getordergraph($startdate);
    //     echo json_encode($result);
    // }

    /**
     * logout
     * @url : logout
     *
     */
    public function logout()
    {
        $session_data = array(
            'unique_id' => $this->session->userdata('unique_id'),
            'adminemail'     => $this->session->userdata('adminemail'),
        );
        $this->session->unset_userdata($session_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout', 'You are logged out Successfully');
        redirect('admin');
    }

    /**
     * forget pasword mail check exist or not
     * @url : forgot/email-check
     * @param : email and forgot-id
     */
    public function forget_password()
    {
        $forgotid = random_string('alnum', 16);
        $email = $this->input->post('femail');
        $output = $this->admin_model->check_mail($email, $forgotid);

        if ($output = '') {
            $this->session->set_flashdata('error', 'invalid Email address');
            redirect('admin');
        } else {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'mail.smartlink.ae',
                'smtp_port' => 587,
                'smtp_user' => 'no-reply@smartlink.ae',
                'smtp_pass' => 's}t[xARFsONt',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
            );
            $this->email->initialize($config);
            $this->email->set_newline('\r\n');
            $this->load->library('email');
            // $this->email->clear(TRUE);

            $this->email->from('no-reply@smartlink.ae');
            $this->email->to($email);
            $this->email->subject('forgot password - Smart Link');
            $this->email->message('click here to set  a new password <a href="' . base_url() . 'set-password/' . $forgotid . '">Reset Password</a>');

            if ($this->email->send()) {

                $this->session->set_flashdata('success', 'Please confirm your registred email address');
                redirect('admin');
            } else {
                $this->session->set_flashdata('error', 'Please try again');
                redirect('admin');
            }

        }

    }

    /**
     * after forget pasword mail click
     * @url : forgot/email-check
     * @param : forgot-id
     */
    public function add_pass($id = '')
    {

        $data['title'] = 'admin-Forgot password - Smart Link';
        $data['id'] = $id;
        $this->load->view('auth/forgot-password.php', $data);
    }

    /**
     * forget pasword -> update New Password
     * @url : update-password
     * @param : email and forgot-id , new password
     */
    public function update_pass()
    {
        $forgotid = $this->input->post('refrnc');
        $this->form_validation->set_rules('remail', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('rpasswrd', 'New Password', 'required');
        $this->form_validation->set_rules('rcnpassword', 'Confirm Password', 'required|matches[rpasswrd]');
        if ($this->form_validation->run() == false) {
            $error = validation_errors();
            $this->session->set_flashdata('error', $error);
            redirect('set-password' . $forgotid, 'refresh');
        } else {

            $email = $this->input->post('remail');
            $newpass = $this->input->post('rpasswrd');

            if ($this->admin_model->addforgtpass($email, $newpass, $forgotid)) {
                $this->session->set_flashdata('success', 'Password updated Successfully');
                redirect('admin', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Email Id does not exist. please enter correct one!');
                redirect('set-password/' . $forgotid, 'refresh');
            }
        }
    }

    /**
     *Change pasword -> load view page
     * @url : change-password
     */
    public function change_password()
    {
        if ($this->session->userdata('unique_id') != '') {
			$data['alert']   = $this->data;
            $data['title'] = 'admin-profile - Smart Link';
            $this->load->view('auth/change-password.php', $data);
        } else {
            $this->session->set_flashdata('error', 'Please login');
            redirect('admin');
        }
    }

    /**
     *Change pasword -> Update New password
     * @url : update/change-password
     * @param : new password,confirm password,userid
     */
    public function password_validation()
    {
        $this->form_validation->set_rules('cpass', 'Current Password', 'callback_passwordcheck');
        $this->form_validation->set_rules('npass', 'New Password', 'required');
        $this->form_validation->set_rules('cnf_pass', 'Confirm Password', 'required|matches[npass]');
        if ($this->form_validation->run() == false) {
            $error = validation_errors();
            $this->session->set_flashdata('error', $error);
            redirect('change-password', 'refresh');
        } else {

            $cpass = $this->input->post('cpass');
            $npass = $this->input->post('npass');
            $admin = $this->session->userdata('unique_id');
            if ($this->admin_model->changepass($admin, $npass, $cpass)) {
                $this->session->set_flashdata('success', 'Password updated Successfully');
                redirect('change-password', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'unable to update your password!, Please try again');
                redirect('change-password', 'refresh');
            }
        }
    }

    public function passwordcheck($password)
    {

        $this->db->where('admin_id', $this->session->userdata('unique_id'));
        $this->db->where('admin_password', $password);
        $result = $this->db->get('admin');
        if ($result->num_rows() > 0) {
            return true;
        } else {
            $this->form_validation->set_message('passwordcheck', 'The {field} not Valid');
            return false;
        }
    }

    /**
     *account settings -> load view page
     * @url : profile
     */
    public function accntsttngs()
    {
        if ($this->session->userdata('unique_id') != '') {
            $data['alert'] = $this->data;
            $data['title'] = 'Account settings - Smart Link';
            $admin = $this->session->userdata('unique_id');
            $data['setting'] = $this->admin_model->account($admin);
            $this->load->view('auth/edit-profile.php', $data, false);
        } else {
            $this->session->set_flashdata('error', 'Please login');
            redirect('admin');
        }
    }

    /**
     *account settings -> Update account
     * @url : update-profile
     *@param : admin uniq id, name phone, date
     */
    public function updateacnt()
    {
        $data['title'] = 'Account settings - Smart Link';
        $ac_uniq = $this->input->post('ac_uniq');
        $acuname = $this->input->post('name');
        // $email     = $this->input->post('email');
        $acphone = $this->input->post('phone');
        $date = date('Y-m-d H:i:s');
        if ($this->admin_model->acupdte($ac_uniq, $acuname, $acphone, $date)) {
            $this->session->set_flashdata('success', 'Account updated Successfully');
            redirect('profile', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong please try again!');
            redirect('profile', 'refresh');
        }
    }

    // notification
    public function notification($id = '')
    {
        $datas = $this->referal_model->get_noti();
        return $datas;
    }

    public function reward_cron($value='')
    {
        $referal = $this->admin_model->expiredRefer();
        echo "<pre>";
        print_r ($referal);
        echo "</pre>";exit();
        
    }

}
