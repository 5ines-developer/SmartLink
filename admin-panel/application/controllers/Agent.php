<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agent extends CI_Controller
{

    /*--construct--*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('agent_model');
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
	 * Agent -> get agents list
	 * url : manage-agents
	*/
    public function index()
    {
        $data['title'] = 'Manage Agents - Smart Link';
        $data['alert']   = $this->data;
        $data['agent'] = $this->agent_model->get_agents();
		$this->load->view('agent/manage-agent',$data);
    }

        /**
         * agent -> delete agent
         * url : delete-agent
         * @param : id
        */
        public function delete_agent($id='')
        {
                // send to model
                if($this->agent_model->delete_agent($id)){
                    $this->session->set_flashdata('success', 'Agent Deleted Successfully');
                    redirect('manage-agents','refresh'); // if you are redirect to list of the data add controller name here
                }else{
                    $this->session->set_flashdata('error', 'Something went to wrong. Please try again later!');
                    redirect('manage-agents','refresh'); // if you are redirect to list of the data add controller name here
                }
        }

               /**
        * agent -> view agent 
         * url : view-agent
         * @param:id
         */
        public function view_agent($id="")
        {
            $data['title'] = 'View agent - Siemens';
            $data['agent']   = $this->agent_model->viewagent($id);
            $data['referal']      = $this->agent_model->referals($id);
            $this->load->view('agent/view-agent',$data);
        }


    // notification
    public function notification($id = '')
    {
        $datas = $this->referal_model->get_noti();
        return $datas;
    }
}
