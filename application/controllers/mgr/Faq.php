<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Base_Controller {
	private $th_title = ["#", "標題", "分類", "說明", "建立日期","動作"]; //, "置頂"
	private $th_width = ["", "150px", "100px", "",  "150px","100px"];
	private $order_column = ["", "", "", "", "","",""]; //, "is_head"
	private $can_order_fields = [4];

	private $param = [
							["標題", 		"title", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
							["分類", 		"classify", "select", 				"", 		TRUE, 	"", 	4, 		12, 	["id", "text"]],
							// ["圖片", 		"cover", 		"img", 				"", 		TRUE, 	"", 	4, 		12 , 1000/500],
							["說明", 		"content", 		"textarea", 				"", 		TRUE, 	"", 	4, 		12],
							// ["日期", 		"date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
							
															            
            ];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "faq";

		$this->load->model("Faq_model");
		
		$this->data['city'] = $this->get_zipcode()['city'];
	}

	public function index(){
		$this->data['title'] = 'FAQ管理';
		$this->data['sub_active'] = 'index';

		$this->data['action'] = base_url()."mgr/Faq/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增FAQ', base_url()."mgr/Faq/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add(){
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			
			if ($this->Faq_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/Faq");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '新增FAQ';

			$this->data['parent'] = 'FAQ管理';
			$this->data['parent_link'] = base_url()."mgr/Faq";

			$this->data['action'] = base_url()."mgr/Faq/add";
			$this->data['submit_txt'] = "新增";

			//column
			//column
			$this->data['select']['classify'] =
			array(
				array("id" => "1", "text" => "常見問題"),
				array("id" => "2", "text" => "付款方式"),
				array("id" => "3", "text" => "退換貨"),
				array("id" => "4", "text" => "其他")

			);



			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}


	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		

		if ($this->Faq_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($this->Faq_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/Faq");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$data = $this->Faq_model->get_data($id);
			$this->data['title'] = 'FAQ編輯';
			$this->data['parent'] = 'FAQ管理';
			$this->data['parent_link'] = base_url()."mgr/faq";
			$this->data['action'] = base_url()."mgr/Faq/edit/".$id;
			$this->data['submit_txt'] = "確認編輯";


			//column
			$this->data['select']['classify'] =
			array(
				array("id" => "1", "text" => "常見問題"),
				array("id" => "2", "text" => "付款方式"),
				array("id" => "3", "text" => "退換貨"),
				array("id" => "4", "text" => "其他")

			);

		
			$this->data['param'] = $this->set_data_to_param($this->param, $data);

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
		$canbe_search_field = ["N.title", "N.content",'C.title'];

		$syntax = "N.is_delete = 0";
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
		
		$order_by = "N.create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = $order_column[$order]." ".$direction.", ".$order_by;
        }

		$data = $this->Faq_model->get_list($syntax, $order_by, $page, $this->page_count);




		$html = "";
		foreach ($data['list'] as $item) {
			
			$html .= $this->load->view("mgr/items/faq_item", array(
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

}
