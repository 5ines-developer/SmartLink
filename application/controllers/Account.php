<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{
    
    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('sid') == '') {
            redirect('login', 'refresh');
        }
        $this->load->model('m_account');
        
    }

    //  profile
    public function index()
    {
        $data['breadcrumbs'] = false;
        $data['title']       = 'Account - Smart Link';
        $uid                 = $this->session->userdata('sid');
        // $uid ="24";
        
        $input = $this->input->post();
        if (count($input) > 0) {
            $this->form_validation->set_rules('name', 'Name', 'trim');
            if ($this->form_validation->run() == TRUE) {
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
            $this->load->view('account/account', $data, FALSE);
        }
        
    }
    
    
    // refer a friend -> agent
    public function refer_friend($var = null)
    {
        $data['title']       = 'Refer a Friend - Smart Link';
        $data['product']     = $this->m_account->product();
        $this->load->view('account/refer-friend', $data, FALSE);

    }


 public function insert_refer($var = null)
 {

            $data['title']       = 'Refer a Friend - Smart Link';
            $this->form_validation->set_rules('name', 'Name', 'trim');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            if ($this->form_validation->run() == TRUE) {

                $name           = $this->input->post('name');
                $phone          = $this->input->post('phone');
                $email          = $this->input->post('email');
                $company        = $this->input->post('company');
                $location       = $this->input->post('location');
                $product        = $this->input->post('product');
                $area           = $this->input->post('area');
                $telecom_type   = $this->input->post('telecom_type');
                $it_type        = $this->input->post('it_type');
                $customer_type  = $this->input->post('customer_type');
                $sub_product    = $this->input->post('sub_product');
                $description    = $this->input->post('description');
                $agentId        = $this->session->userdata('sid');
                $uniq           = $this->input->post('uniq');

              $insert =  array(
                'agent_id'          =>  $agentId,
                'referee_name'      =>  $name,
                'referee_phone'     =>  $phone,
                'referee_location'  =>  $location,
                'refree_email'      =>  $email,
                'refree_area'       =>  $area,
                'refree_company'    =>  $company,
                'product'           =>  $product,
                'telecom_type'      =>  $telecom_type,
                'it_type'           =>  $it_type,
                'customer_type'     =>  $customer_type,
                'sub_product'       =>  $sub_product,
                'uniq'              =>  $uniq,
                'description'       =>  $description
            );

              $notification=array(
                'notification_subject' => 'Refer a friend',
                'notification_description' => 'new refer a friend request added by '.$name.' , check and verify',
                'added_by' => $this->session->userdata('sid'),
                'thing_id' => $uniq,
                'notification_type' => '1',
                'uniq'     =>   random_string('alnum',10)
              );

              $output       =   $this->m_account->insert_referrals($insert);
              $notioutput   =   $this->notification($notification);
              $emailoutput  =   $this->sendreferrals($insert);

            if($output!='' && $notioutput!='' && $emailoutput!='')
            {
                $this->session->set_flashdata('success', 'friend reference Added Successfully');
                redirect('refer-a-friend', 'refresh');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                redirect('refer-a-friend', 'refresh');
            }


                
            } else {
                $this->session->set_flashdata('error', 'Something went wrong please try again!');
                redirect('refer-a-friend', 'refresh');
            }
    }

    // insert notification
    public function notification($notification='')
    {
        if($this->m_account->insert_notification($notification))
            {
                return TRUE;
            }else{
                return false;
            }
    }


    //  send refer a friend request to admin
    function sendreferrals($insert='')
    {

        $this->load->config('email');
        $this->load->library('email');
        $from = $this->config->item('smtp_user');
        $msg = '<!DOCTYPE html>

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

                                                    <p style="width: 80%">Refer a friend request from '.$this->session->userdata('suser').' </p> <br>

                                                </center> 

                                            </td>

                                        </tr>

                                        <tr> 

                                            <td>

                                                <center>

                                                    <table>

                                                        <tr>

                                                            <th>Refree Name : </th>

                                                            <td>'.$insert['referee_name'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Refree Email : </th>

                                                            <td>'.$insert['refree_email'].'</td>

                                                        </tr>



                                                        <tr>

                                                            <th>Referee Phone : </th>

                                                            <td>'.$insert['referee_phone'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Referee Company : </th>

                                                            <td>'.$insert['refree_company'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Referee location : </th>

                                                            <td>'.$insert['referee_location'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Referee Area : </th>

                                                            <td>'.$insert['refree_area'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Category : </th>

                                                            <td>'.$insert['product'].'</td>

                                                        </tr> ';

                                                        if ($insert['product'] == 'it') {
                                                            
                                                           $msg .= ' <tr>

                                                            <th>Product : </th>

                                                            <td>'.$insert['it_type'].'</td>

                                                        </tr>';
                                                           
                                                        }else if ($insert['product'] == 'telecom'){

                                                           $msg .= '<tr>

                                                            <th>Telecom Type : </th>

                                                            <td>'.$insert['telecom_type'].'</td>

                                                        </tr>

                                                        

                                                        <tr>

                                                            <th>Telecom Type : </th>

                                                            <td>'.$insert['telecom_type'].'</td>

                                                        </tr>

                                                        <tr>

                                                            <th>Service : </th>

                                                            <td>'.$insert['sub_product'].'</td>

                                                        </tr>';
                                                        }

                                                        

                                                        $msg .= ' <tr>

                                                            <th>Customer Type : </th>

                                                            <td>'.$insert['customer_type'].'</td>

                                                        </tr>

                                                        



                                                        <tr>

                                                            <th>Description : </th>

                                                            <td>'.$insert['description'].'</td>

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
        $this->email->from($from , 'Smart Link');
        $this->email->to('prathwi@5ine.in');
        $this->email->subject('Refer a friend request'); 
        $this->email->message($msg);

        if($this->email->send())  
        {  
            return true;
        } 
        else
        {
            return false;
        }
        
    }
    
    // change password
    public function change_psw()
    {
        $data['breadcrumbs'] = FALSE;
        $data['title']       = 'Change password';
        $uid                 = $this->session->userdata('sid');
        
        $input = $this->input->post();
        if (count($input) > 0) {
            
            $this->form_validation->set_rules('current_pws', 'Current Password', 'trim|required|callback_checkpsw_check');
            $this->form_validation->set_rules('new_pws', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('conf_pws', 'Password Confirmation', 'trim|required|matches[new_pws]');
            
            if ($this->form_validation->run() == TRUE) {
                
                $hash  = $this->bcrypt->hash_password($input['new_pws']);
                $datas = array(
                    'agent_password' => $hash
                );
                if ($this->m_account->changePassword($datas, $uid, $input['current_pws'])) {
                    $this->session->set_flashdata('success', 'Your password has been reset successfully');
                    redirect('change-password', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Invalid Current password!');
                    redirect('change-password', 'refresh');
                }
                
            } else {
                $this->load->view('account/change-psw', $data, FALSE);
            }
        } else {
            $this->load->view('account/change-psw', $data, FALSE);
        }
        
    }
    
    // psw check function
    public function checkpsw_check($psw)
    {
        if ($this->m_account->checkpsw($psw)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkpsw_check', 'Invalid {field}');
            return FALSE;
        }
        
    }

        // phone number function
    public function phone_check($phone)
    {
        if ($this->m_account->phone_check($phone)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('phone_check', 'Invalid {field}');
            return FALSE;
        }
        
    }

        // refer a friend -> agent
        public function referal_list($var = null)
        {
            $data['title']       = 'List Of Referals - Smart Link';
            $data['referal']     = $this->m_account->referal_list();
            $this->load->view('account/referal-list', $data, FALSE);
    
        }



    


        // dashboard -> agent
    public function dashboard($var = null)
    {
        $this->load->view('account/dashboard');

    }


    // notification -> agent
    public function notification_dash($var = null)
    {
        $this->load->view('account/notification');

    }

    //reward-point -> agent
    public function reward_point($var = null)
    {
        $this->load->view('account/reward-point');

    }
    
}

/* End of file account.php */