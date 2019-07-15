<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	/*--construct--*/
	function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('referal_model');
        $this->load->library('email');          
        $this->load->library('session'); 
        $this->load->library('form_validation'); 
		$this->load->library('session'); 
        $this->load->helper('url'); 
        $this->data =  $this->notification();
        if($this->session->userdata('unique_id') == '') 
        {
            $this->session->set_flashdata('error', 'Please login and try again');
            redirect('dashboard'); 
        }
    }

    /**
	 * product -> add product
	 * url : add-product
	*/
    public function index()
    {
        $data['alert']   = $this->data;
        $data['title'] = 'Add Product - Smart Link';
		$this->load->view('product/add-product',$data);
    }


        /**
		* product -> insert product 
		* @url : insert-product
		*/
		public function insert_product()
		{
			$service        = $this->input->post('service');
			$it_service 	= $this->input->post('it_service');
			$user_type 	    = $this->input->post('user_type');
			$telecom_for 	= $this->input->post('telecom_for');
			$category 	    = $this->input->post('category');
            $reward_points 	= $this->input->post('reward_points');
            $uniq           = $this->input->post('uniq');
            $reward_expiry 	= $this->input->post('reward_expiry');

            if ($category == 'it') {
                $insert =  array( 'category'      =>  $category,
                'it_service'    =>  $it_service,
                'added_by'      => $this->session->userdata('unique_id'),
                'uniq'          =>  $uniq,
                'telecom_for'   => '' ,
                'reward_points' =>  '' ,
                'user_type'     =>  '' ,
                'reward_expiry_date' => '',
                'service'       =>  ''   );
            }else{

                 $insert =  array(
                'category'      =>  $category,
                'added_by'      => $this->session->userdata('unique_id'),
                'telecom_for'   => $telecom_for ,
                'it_service'    =>  '',
                'user_type'     =>  $user_type,
                'service'       =>  $service,
                'reward_points' =>  $reward_points,
                'uniq'          =>  $uniq
            );

            }
           

            if ($category == 'telecom' && $telecom_for=='business' && $reward_points !='' && $reward_expiry == '') {
                $insert['reward_expiry_date'] = '90 days';
            }else if ($category == 'telecom' && $telecom_for=='business' && $reward_points !='' && $reward_expiry != '') {
                $insert['reward_expiry_date'] = $reward_expiry;
            }

            
			if($this->product_model->insert($insert))
			{
				$this->session->set_flashdata('success', 'Product Added Successfully');
				redirect('manage-product','refresh');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong please try again!');
				redirect('add-product','refresh');
			}
        }

         /**
        * Products -> manage Products
         * url : manage-product
         */
        public function get_product($filter='')
        {
            $filter = $this->input->get('filter');
            $data['title'] = 'Manage Producrs - Smart Link';
            $data['alert']   = $this->data;
            $data['product']   = $this->product_model->getproduct();
            $this->load->view('product/manage-product',$data);
        }

        

        /**
        * Products -> delete Products
         * url : delete-product
         * @param : uniq
        */
        public function delete_product($id='')
        {
                // send to model
                if($this->product_model->delete_product($id)){
                    $this->session->set_flashdata('success', 'Product Deleted Successfully');
                    redirect('manage-product','refresh'); // if you are redirect to list of the data add controller name here
                }else{
                    $this->session->set_flashdata('error', 'Something went to wrong. Please try again later!');
                    redirect('manage-product','refresh'); // if you are redirect to list of the data add controller name here
                }
        }


        /**
         * Products -> edit Products
         * url : edit-Product
         * @param : id
        */
        public function edit_product($id='')
        { 
            $data['title']      = 'View Referals - Smart Link';
            $data['alert']      = $this->data;
            $data['product']    = $this->product_model->edit_product($id);
            $this->load->view('product/add-product',$data);
        }


            // notification 
          public function notification($id='')
          {
            $datas = $this->referal_model->get_noti();
            return $datas;
          }
    

}