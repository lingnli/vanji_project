<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Top extends Base_Controller
{
	private $th_title = ["頁面", "圖片", "編輯日期", "動作"]; //, "置頂"
	private $th_width = ["", "", "200px", ""];
	private $order_column = ["", "", "", "", "", "", ""]; //, "is_head"
	private $can_order_fields = [4];

	private $param = [
		["頁面", 		"title", 		"plain", 				"", 		TRUE, 	"", 	4, 		12],
		// ["分類", 		"classify", "select", 				"", 		TRUE, 	"", 	4, 		12, 	["id", "text"]],
		["圖片", 		"cover", 		"img", 				"", 		FALSE, 	"", 	4, 		12 , 1920/320],
		// ["說明", 		"content", 		"textarea", 				"", 		TRUE, 	"", 	4, 		12],
		// ["日期", 		"date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],


	];

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->data['active'] = "top";

		$this->load->model("Top_model");

		$this->data['city'] = $this->get_zipcode()['city'];
	}

	public function index()
	{
		$this->data['title'] = '頂部橫幅圖管理';
		$this->data['sub_active'] = 'index';

		$this->data['action'] = base_url() . "mgr/top/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增top', base_url() . "mgr/top/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add()
	{
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($this->Top_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url() . "mgr/top");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['title'] = '新增頂部橫幅圖';

			$this->data['parent'] = '頂部橫幅圖管理';
			$this->data['parent_link'] = base_url() . "mgr/top";

			$this->data['action'] = base_url() . "mgr/top/add";
			$this->data['submit_txt'] = "新增";


			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}


	public function del()
	{
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();



		if ($this->Top_model->edit($id, array("is_delete" => 1))) {
			$this->output(TRUE, "success");
		} else {
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id)
	{
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);

			unset($data['title']);
			if ($this->Top_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/top");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$data = $this->Top_model->get_data($id);
			$this->data['title'] = '頂部橫幅圖編輯';
			$this->data['parent'] = '頂部橫幅圖管理';
			$this->data['parent_link'] = base_url() . "mgr/top";
			$this->data['action'] = base_url() . "mgr/top/edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";

			$this->data['param'] = $this->set_data_to_param($this->param, $data);

			$this->data['data'] = $data;
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	public function data()
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->order_column;
		$canbe_search_field = ["N.title", "N.content", 'C.title'];

		$syntax = "";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field . " LIKE '%" . $search . "%'";
				$index++;
			}
			$syntax .= ")";
		}

		$order_by = "N.id DESC";
		if ($order_column[$order] != "") {
			$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
		}

		$data = $this->Top_model->get_list($syntax, $order_by, $page, $this->page_count);




		$html = "";
		foreach ($data['list'] as $item) {

			$html .= $this->load->view("mgr/items/top_item", array(
				"item"  =>	$item
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$data['total_page']
		));
	}
}
