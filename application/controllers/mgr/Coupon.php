<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends Base_Controller {

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "coupon";
	}

	//學習優惠卷
	public function index()
	{
		$this->data['sub_active'] = "coupon";
		$this->db->select("C.*, count(U.id) as used");
		$this->db->from("coupon C");
		$this->db->join("coupon_use U", "U.coupon_id = C.id AND U.status ='used'", "left");
		$this->db->where("C.is_delete=0 ");
		$this->db->order_by("C.create_date desc");
		$this->db->group_by("C.id");
		$this->data['list'] = $this->db->get()->result_array();

		$this->load->view('mgr/coupon', $this->data);
	}

	public function delete($id){
		if (is_numeric($id)) {
			$this->db->where(array("id"=>$id));
			$this->db->update("coupon", array("is_delete"=>1));
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	public function add(){
		$code        = $this->input->post("code");
		$use_limit   = $this->input->post("use_limit");
		$expired_date = $this->input->post("expired_date");
		$discount    = $this->input->post("discount");		

		if($code==""|| $use_limit == ""|| $expired_date == ""|| $discount == ""){
			$this->js_output_and_back('請確認所有欄位皆已填寫');
		}
		if($discount==0|| !is_numeric($discount)){
			$this->js_output_and_back('請確認折扣金額');
		}
		if (!is_numeric($use_limit)) {
			$this->js_output_and_back('請確認使用次數');
		}
	

		$this->db->select("*");
		$this->db->from("coupon");
		$this->db->where("code='{$code}' AND is_delete = 0");
		$r = $this->db->get()->row();
		if ($r == null) {
			$data = array(
				"code"        =>	$code,
				"use_limit"   =>	$use_limit,
				"expired_date" =>	$expired_date,
				"discount"    =>	$discount				
			);

			$this->db->insert("coupon", $data);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}else{
			echo "<script> alert('此優惠代碼已存在'); history.back('".$_SERVER['HTTP_REFERER']."'); </script>";
		}
	}


}
