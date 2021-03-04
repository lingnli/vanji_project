<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function edit($id, $data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->update_batch($this->product, $data, $id);
		}else{
			return $this->db->where(array("id"=>$id))->update($this->product, $data);
		}
	}

	public function add($data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->insert_batch($this->product, $data);
		}else{
			$this->db->insert($this->product, $data);
			$p_id = $this->db->insert_id();
			// return $this->db->insert($this->product, $data);
			return $p_id;
		}
	}

	public function get_data($id){
		return $this->db->get_where($this->product, array("is_delete"=>0,'id'=>$id))->row_array();
	}

	public function get_all_list($syntax = array()){
		if (count($syntax) == 0) {
			$syntax = array("is_delete"=>0, "status"=>"open", "show_type"=>"T");
		}
		return $this->db->get_where($this->product, $syntax)->result_array("event_uid");
	}

	public function get_list($syntax, $order_by, $page = 1, $page_count = 20){
		// $syntax .= " AND show_type = 'T'";
		$total = $this->db->where($syntax)->get($this->product)->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("*")
						 ->from($this->product)
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		return array(
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}
}