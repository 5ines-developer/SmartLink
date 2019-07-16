<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rewards extends CI_Controller
{

    /*--construct--*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reward_model');
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
     * reward point -> claimed reward points
     * url : manage-reward-claims
     */
    public function index($filter = '')
    {
        $filter = $this->input->get('filter');
        $data['title'] = 'Manage claimed reward points - Smart Link';
        $data['alert'] = $this->data;
        $data['claim'] = $this->reward_model->getclaimed($filter);
        $this->load->view('rewards/claim-reward-request', $data);
    }

    /**
     *  reward point -> delete claimed reward points
     * url : delete-referals
     * @param : id
     */
    public function delete_claims($id = '')
    {
        // send to model
        if ($this->reward_model->delete_claims($id)) {
            $this->session->set_flashdata('success', 'Reward Points Claim Request Deleted Successfully');
            redirect('manage-reward-claims', 'refresh'); // if you are redirect to list of the data add controller name here
        } else {
            $this->session->set_flashdata('error', 'Something went to wrong. Please try again later!');
            redirect('manage-reward-claims', 'refresh'); // if you are redirect to list of the data add controller name here
        }
    }

    /**
     *  reward point -> view claimed reward points
     * url : view-referal
     * @param : id
     */
    public function view_claims($id = '')
    {
        $data['title'] = 'View claimed reward points - Smart Link';
        $data['claim'] = $this->reward_model->view_claims($id);
        $data['alert'] = $this->data;
        $agentid = $data['claim']['agent_id'];
        $data['reward'] = $this->reward_model->reward_point($agentid);
        $data['claimed'] = $this->reward_model->claimed_point($agentid);
        $data['ap_claim'] = $this->reward_model->approved_point($agentid);
        $this->load->view('rewards/view-reward-request', $data);
    }

    /**
     * claim reward -> approve reward
     * url : approve-reward
     * @param : id
     */
    public function approve_rewards($resn = '')
    {
        $ap_password    = $this->input->post('ap_password');
        $approve        = $this->input->post('approve');
        $claimid        = $this->input->post('claimid');
        $noti_to        = $this->input->post('noti_to');
        $smart_code     = $this->input->post('smart_code');
        $Date           = date("Y-m-d");
        $reward_expiry_date = date('Y-m-d', strtotime($Date . ' + 90 days'));

        if ($this->checkpsw_check($ap_password)) {
            $change = array('claim_status' => $approve, 'coupon_code' => $smart_code,'validated_on' => date("Y-m-d h:i:s"));
            $output = $this->reward_model->claim_change($change,$claimid);
            $notification = array(
                'notification_subject' => 'Claim reward point success',
                'notification_description' => 'your request for claim reward point is succesfull.',
                'added_by' => $this->session->userdata('unique_id'),
                'thing_id' => $claimid,
                'notification_type' => '2',
                'uniq' => random_string('alnum', 10),
                'noti_to' => $noti_to,
                'added_by_type' => 'admin',
                'noti_to_type' => 'agent',
            );
            if ($output != '') {
                $this->insert_notification($notification);
                $this->session->set_flashdata('success', 'Claim Reward Point request has been Approved Successfully');
            }

            echo $output;
        } else {
            echo "wrong password";
        }
    }


    /**
     * claim reward -> reject reward
     * url : reject-reward
     * @param : id
     */
    public function reject_rewards($id = '')
    {

        $rj_password = $this->input->post('rj_password');
        $reject = $this->input->post('reject');
        $claimid        = $this->input->post('claimid');
        $noti_to = $this->input->post('noti_to');
        $return_reward = $this->input->post('return_reward');

        if ($this->checkpsw_check($rj_password)) {
            $change = array('claim_status' => $reject,'validated_on' => date("Y-m-d h:i:s"),'return_reward'=>$return_reward);
            $output = $this->reward_model->claim_change($change,$claimid);

            $notification = array(
                'notification_subject' => 'Claim reward point request rejected',
                'notification_description' => 'your request for claim reward point has been rejected.',
                'added_by' => $this->session->userdata('unique_id'),
                'thing_id' => $claimid,
                'notification_type' => '2',
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
}
