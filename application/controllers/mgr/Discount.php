<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends Base_Controller {

	private $param_1 = [
		["折扣名稱", 		"title", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
		["滿額折扣金額", "price_limit", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["滿額折扣折數<br>限制為 1-100", "discount", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["開始日期", 		"start_date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
		["結束日期", 		"end_date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
	];

	private $param_2 = [
		["折扣名稱", 		"title", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
		["滿件折扣件數", "quantity_limit", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["滿件折扣折數<br>限制為 1-100", "discount", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["開始日期", 		"start_date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
		["結束日期", 		"end_date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
	];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();

		$this->load->model("Discount_model");
		$this->data['active'] = "discount";
	}


	public function index()
	{
		//折扣方式
		$type = $this->db->where(array("id" => 17 ))->get('settings')->row_array();
		$this->data['type'] = $type['content'];

		//滿額
		$list_1 = $this->db->select("D.*")
			->from($this->discount . " D")
			->where('D.discount_type=1 AND D.is_delete=0')
			->order_by('D.price_limit ASC')			
			->get()->result_array();

		$this->data['list_1'] = $list_1;

		//滿件
		$list_2 = $this->db->select("D.*")
			->from($this->discount . " D")
			->where('D.discount_type=2 AND D.is_delete=0')
			->order_by('D.quantity_limit ASC')
			->get()->result_array();

		$this->data['list_2'] = $list_2;

		$this->load->view('mgr/discount', $this->data);
	}

	public function del(){

		$id   = $this->input->post("id");

			
		$res = 	$this-> db->where(array("id" => $id))->update("discout", array("is_delete"=>1));

		if ($res) {
			$this->output(TRUE, "success");
		} else {
			$this->output(FALSE, "fail");
		}
	}

	//新增折扣
	public function add($type)
	{
		$this->data['sub_active'] = 'index';
		if ($_POST) {

			//防呆
			if($_POST['discount']>=100 || $_POST['discount'] <= 0){
				$this->js_output_and_back("折扣數設定錯誤");
			}

			if (strtotime($_POST['start_date'])> strtotime($_POST['end_date']) ) {
				$this->js_output_and_back("開始日期不可晚於結束日期");
			}

			if($type==1){
				$data = $this->process_post_data($this->param_1);
			}else{
				$data = $this->process_post_data($this->param_2);
			}
			

			$data['discount_type'] = $type;
			if ($this->Discount_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url() . "mgr/discount");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			if ($type == 1) {
				$this->data['title'] = '新增滿額折扣方式';
				$this->data['param'] = $this->param_1;
			} else {
				$this->data['title'] = '新增滿件折扣方式';
				$this->data['param'] = $this->param_2;
			}
			

			$this->data['parent'] = '折扣方式管理';
			$this->data['parent_link'] = base_url() . "mgr/discount";

			$this->data['action'] = base_url() . "mgr/discount/add/".$type;
			$this->data['submit_txt'] = "新增";


			
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	public function edit($id)
	{
		$this->data['sub_active'] = 'index';
		$data = $this->Discount_model->get_data($id);
		if ($_POST) {
			
			//防呆
			if ($_POST['discount'] >= 100 || $_POST['discount'] <= 0) {
				$this->js_output_and_back("折扣數設定錯誤");
			}

			if (strtotime($_POST['start_date']) > strtotime($_POST['end_date'])) {
				$this->js_output_and_back("開始日期不可晚於結束日期");
			}

			if ($data['discount_type'] == 1) {
				$data = $this->process_post_data($this->param_1);
			} else {
				$data = $this->process_post_data($this->param_2);
			}

			if ($this->Discount_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/discount");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			
			if ($data['discount_type'] == 1) {
				$this->data['title'] = '編輯滿額折扣方式';
				$this->data['param'] = $this->set_data_to_param($this->param_1, $data);
			} else {
				$this->data['title'] = '編輯滿件折扣方式';
				$this->data['param'] = $this->set_data_to_param($this->param_2, $data);
			}
			
			$this->data['parent'] = '折扣管理';
			$this->data['parent_link'] = base_url() . "mgr/discount";
			$this->data['action'] = base_url() . "mgr/discount/edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";


			

			$this->data['data'] = $data;
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	//修改折扣方式
	public function edit_type()
	{
		
		$type   = $this->input->post("type");

		if($type == 'price'){
			$type = 1;
		}elseif($type == 'quantity'){
			$type = 2;
		}

		$this->db->where(array("id" => 17))->update('settings', array('content'=>$type));

		if($type==1){
			$this->js_output_and_redirect("已更新全站折扣方式為「滿額折扣」", $_SERVER['HTTP_REFERER']);
		}else{
			$this->js_output_and_redirect("已更新全站折扣方式為「滿件折扣」", $_SERVER['HTTP_REFERER']);
		}
		
	}

}
