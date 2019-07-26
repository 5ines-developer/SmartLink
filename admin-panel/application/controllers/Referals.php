<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Referals extends CI_Controller
{

    /*--construct--*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('referal_model');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->data = $this->notification();
        if ($this->session->userdata('unique_id') == '') {
            $this->session->set_flashdata('error', 'Please login and try again');
            redirect('dashboard');
        }
    }

    /**
     * Referal -> manage referals request
     * url : manage-referal
     */
    public function manage_referals($filter = '')
    {
        $filter = $this->input->get('filter');
        $data['title'] = 'Manage Referals - Smart Link';
        $data['alert'] = $this->data;
        $data['referal'] = $this->referal_model->getreferal($filter);
        $this->load->view('referrals/manage-referal-request', $data);
    }

    /**
     *  Referal -> delete referals request
     * url : delete-referals
     * @param : id
     */
    public function delete_referals($id = '')
    {
        // send to model
        if ($this->referal_model->deletereferals($id)) {
            $this->session->set_flashdata('success', 'Referal request Deleted Successfully');
            redirect('manage-referals', 'refresh'); // if you are redirect to list of the data add controller name here
        } else {
            $this->session->set_flashdata('error', 'Something went to wrong. Please try again later!');
            redirect('manage-referals', 'refresh'); // if you are redirect to list of the data add controller name here
        }
    }

    /**
     * Referal -> view referral details
     * url : view-referal
     * @param : id
     */
    public function view_referals($id = '')
    {
        $data['title'] = 'View Referals - Smart Link';
        $data['referal'] = $this->referal_model->single_referal($id);
        $data['alert'] = $this->data;
        if (!empty($data['referal']['sub_product'])) {
            $data['reward'] = $this->referal_model->product_reward($data['referal']['sub_product']);
        }
        $this->load->view('referrals/view-referals', $data);
    }

    /**
     * Referal -> approve referral
     * url : approve-referal
     * @param : id
     */
    public function approve_referals($resn = '')
    {

        $ap_password = $this->input->post('ap_password');
        $approve = $this->input->post('approve');
        $referalid = $this->input->post('referalid');
        $noti_to = $this->input->post('noti_to');
        $rewrd = $this->input->post('rewrd');
        $Date = date("Y-m-d");
        $exipry = $this->input->post('reward_expiry');
        $reward_expiry_date = date('Y-m-d', strtotime($Date . ' + '.$exipry));

        
        echo "<pre>";
        print_r ($reward_expiry_date);
        echo "</pre>";

        echo "<pre>";
        print_r ($exipry);
        echo "</pre>";exit;
        

        if ($this->checkpsw_check($ap_password)) {
            $change = array('referee_status' => $approve, 'reward_points' => $rewrd, 'reward_points' => $rewrd, 'reward_expiry_date' => $reward_expiry_date);
            $output = $this->referal_model->referal_change($change, $referalid);

            $notification = array(
                'notification_subject' => 'Refer a friend Success',
                'notification_description' => 'your refer a friend request is succesfull.',
                'added_by' => $this->session->userdata('unique_id'),
                'thing_id' => $referalid,
                'notification_type' => '1',
                'uniq' => random_string('alnum', 10),
                'noti_to' => $noti_to,
                'added_by_type' => 'admin',
                'noti_to_type' => 'agent',
            );
            if ($output != '') {
                $this->insert_notification($notification);
                $this->session->set_flashdata('success', 'Referal request Approved Successfully');
            }

            echo $output;
        } else {
            echo "wrong password";
        }
    }

    /**
     * Referal -> reject referral
     * url : reject-referal
     * @param : id
     */
    public function reject_referals($id = '')
    {

        $rj_password = $this->input->post('rj_password');
        $reject = $this->input->post('reject');
        $referalid = $this->input->post('referalid');
        $noti_to = $this->input->post('noti_to');
        $reject_reason = $this->input->post('reject_reason');

        if ($this->checkpsw_check($rj_password)) {
            $change = array('referee_status' => $reject, 'referee_failed_reason' => $reject_reason);
            $output = $this->referal_model->referal_change($change, $referalid);

            $notification = array(
                'notification_subject' => 'Refer a friend request rejected',
                'notification_description' => 'your refer a friend request has been rejected.',
                'added_by' => $this->session->userdata('unique_id'),
                'thing_id' => $referalid,
                'notification_type' => '1',
                'uniq' => random_string('alnum', 10),
                'noti_to' => $noti_to,
                'added_by_type' => 'admin',
                'noti_to_type' => 'agent',
            );
            if ($output != '') {
                $this->insert_notification($notification);
                $this->session->set_flashdata('success', 'Referal request Rejected');
            }

            echo $output;
        } else {
            echo "wrong password";
        }
    }

//
    //
    //
    // noti_to
    // reject_reason

    // insert notification
    public function insert_notification($notification = '')
    {
        if ($this->referal_model->insert_notification($notification)) {
            return true;
        } else {
            return false;
        }
    }

    // psw check function
    public function checkpsw_check($psw)
    {
        if ($this->referal_model->checkpsw($psw)) {
            return true;
        } else {
            $this->form_validation->set_message('checkpsw_check', 'Invalid {field}');
            return false;
        }
    }

    // notification
    public function notification($id = '')
    {
        $datas = $this->referal_model->get_noti();
        return $datas;
    }

    public function noti_view($itemid = '', $notitype = '', $uniq = '')
    {
        $data['seen'] = $this->referal_model->noti_seen($uniq);
        if ($notitype == '1') {
            redirect('view-referals/' . $itemid, 'refresh');
        }elseif ($notitype == '2') {
            redirect('view-reward-claims/' . $itemid, 'refresh');
        }
    }

    // notification
    public function all_notification($id = '')
    {
        $data['noti'] = $this->referal_model->all_noti();
        $data['title'] = 'Notification - Smart Link';
        $data['alert'] = $this->data;
        $this->load->view('site/all-notification', $data);

    }

}
