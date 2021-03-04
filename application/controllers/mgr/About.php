<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Base_Controller {
	private $th_title = ["標題/設計師" ,"顯示圖", "內文/簡介","日期","動作"]; //, "置頂"
	private $th_width = [  "160px", "200px", "", "120px","80px"];
	private $order_column = ["", "", "", "", "","",""]; //, "is_head"
	private $can_order_fields = [0];

	private $param = [
							["標題/設計師", 		"title", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
							["內文/簡介", 		"intro", 		"text", 				"", 		TRUE, 	"", 	4, 		12],							
							["顯示圖<br><span class='text text-danger'>尺寸比例 270 x 320</span>", 				"cover", 				"img", 					"", 		TRUE, 	"", 	4, 		12, 270/320],														
							
            ];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "about";

		$this->load->model("about_model");
		
		$this->data['city'] = $this->get_zipcode()['city'];
	}



	public function index()
	{
		$this->data['title'] = '關於/設計師管理';
		$this->data['sub_active'] = 'about';

		$this->data['action'] = base_url() . "mgr/about/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增案例', base_url() . "mgr/about/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add(){
		
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			
			if ($this->about_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/about/index");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '新增設計案例';

			$this->data['parent'] = '設計案例管理';
			$this->data['parent_link'] = base_url()."mgr/about/index";

			$this->data['action'] = base_url()."mgr/about/add";
			$this->data['submit_txt'] = "新增";

			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}


	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		

		if ($this->about_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			if ($id == '1') {
				$param = [
					["關於", 		"title", 		"plain", 				"", 		TRUE, 	"", 	4, 		12],
					// ["英文標題/子標題", 		"title_en", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
					["顯示圖", 				"cover", 				"img", 					"", 		TRUE, 	"", 	4, 		12, 1900 / 800],
					["內文", 		"intro", 			"textarea_plain", 		"", 		TRUE, 	"", 	6, 		12],

				];
				
				$data = $this->process_post_data($param);
				$data['title'] = '底部cover圖';
			} else {

				$data = $this->process_post_data($this->param);
			}

			// $data = $this->process_post_data($this->param);
			// print_r($data);exit;
			
			if ($this->about_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url(). "mgr/about/index");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$data = $this->about_model->get_data($id);
			$this->data['title'] = '關於/設計師';
			$this->data['parent'] = '';
			$this->data['parent_link'] = base_url()."mgr/about/index";
			$this->data['action'] = base_url(). "mgr/about/edit/".$id;
			$this->data['submit_txt'] = "確認編輯";

		if ($id == '1') {
				$param = [
					["關於", 		"title", 		"plain", 				"", 		TRUE, 	"", 	4, 		12],
					// ["英文標題/子標題", 		"title_en", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
					["顯示圖", 				"cover", 				"img", 					"", 		TRUE, 	"", 	4, 		12, 470 / 340],
					["內文", 		"intro", 			"textarea_plain", 		"", 		TRUE, 	"", 	6, 		12],

				];
				$this->data['param'] = $this->set_data_to_param($param, $data);
			}else{

			$this->data['param'] = $this->set_data_to_param($this->param, $data);
			}

			$this->data['data'] = $data;
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	public function data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
        $order       = ($this->input->post("order"))?$this->input->post("order"):0;
        $direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

        $order_column = $this->order_column;
		$canbe_search_field = ["title", 'intro'];

		$syntax = "is_delete = 0 ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		}
		
		$order_by = "create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = $order_column[$order]." ".$direction.", ".$order_by;
        }

		$data = $this->about_model->get_list($syntax, $order_by, $page, $this->page_count);

		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/about_item", array(
				"item"  =>	$item
			), TRUE);
		}
		if($search!="") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$data['total_page']
		));
	}

	// public function sort(){
	// 	$id = $this->input->post("id");
	// 	if (!is_numeric($id)) show_404();
	// 	$sort = $this->input->post("sort");

	// 	$index = 1;
	// 	foreach ($this->db->order_by("sort ASC")->get_where($this->event_table, array("id<>"=>$id, "is_delete"=>0))->result_array() as $item) {
	// 		if ($index == $sort) $index++;
	// 		$data[] = array(
	// 			"id"	=>	$item['id'],
	// 			"sort"	=>	$index
	// 		);
	// 		$index++;
	// 	}
	// 	$data[] = array(
	// 		"id"         =>	$id,
	// 		"sort"       =>	$sort
	// 	);
	// 	$res = $this->db->update_batch($this->event_table, $data, "id");
	// 	if ($res) {
	// 		$this->output(TRUE, "成功");
	// 	}else{
	// 		$this->output(FALSE, "失敗");
	// 	}
	// }
}
