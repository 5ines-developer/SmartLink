<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

          /**
         * insert new product 
         * @url : add-product
         * @param : product data
         * 
        */
        public function insert($insert)
		{
			$this->db->where('uniq', $insert['uniq']);
			$query = $this->db->get('product');
			if ($query->num_rows() > 0) 
			{
				$this->db->where('uniq', $insert['uniq']);
				return $this->db->update('product', $insert);
			}
			else
			{
				return $this->db->insert('product',$insert);
			}
        }

        /**
         * get products 
         * @url : manage-product
         * 
        */
        public function getproduct()
		{
			
			$this->db->order_by('id', 'desc');
			$query = $this->db->get('product');
			if ($query->num_rows() > 0) 
			{
				
				return $query->result();
			}
			else
			{
				return false;
			}
		}

		/**
         * delete product 
         * @url : delete-product
         * @param : id
         * 
        */
        public function delete_product($id)
		{
			$this->db->where('uniq', $id);
			return $this->db->delete('product');
		}

		/**
         * edit product 
         * @url : edit-product
         * @param : id
         * 
        */
        public function edit_product($id)
		{
			$this->db->where('uniq', $id);
			$query = $this->db->get('product');
			if ($query->num_rows() > 0) 
			{
				
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}


}