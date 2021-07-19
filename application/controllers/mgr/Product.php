<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Base_Controller {


	
						
	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "product";
		$this->load->model("Product_model");
	}


	//產品分類
	public function classify($path = FALSE, $id = FALSE){
		
		$this->data['sub_active'] = 'classify';		


		$param = [                
								["產品分類", "classify", "text","", 		TRUE, 	"", 	4, 		12],								
						];


		if ($path === FALSE) {
			$this->data['list'] = $this->db->select("P.*")
																		 ->from($this->products_classify . " P")
																		 ->where("P.is_delete=0")
																		 ->order_by('P.id ASC')
																		 ->get()->result_array();

			$this->load->view('mgr/classify', $this->data);
		}else if ($path == "add") {
			if ($_POST) {
				
				
				$data['classify'] = trim($this->input->post("classify"));

				$check = $this->db->where(array("classify" => $data['classify']))->get($this->products_classify)->row_array();
				// print_r($check);
				// exit;
				if ($data['classify'] == "") {
					$this->js_output_and_back("請填寫分類名稱");
				}
				if($check ){
					$this->js_output_and_back("已有重複分類");
				}
				$res = $this->db->insert($this->products_classify, $data);
				if ($res) {
					$this->js_output_and_redirect("新增成功", base_url()."mgr/product/classify");
				}else{
					$this->js_output_and_back("發生錯誤");
				}
			}else{
				$this->data['title'] = '新增輪播圖';

				$this->data['parent'] = '輪播圖管理';
				$this->data['parent_link'] = base_url()."mgr/product/classify";

				$this->data['action'] = base_url()."mgr/product/classify/add";
				$this->data['submit_txt'] = "新增";

				$this->data['param'] = $param;
				$this->load->view("mgr/template_form", $this->data);
			}
		}else if($path == "edit"){
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id"=>$id))->get($this->products_classify)->row_array();

			if ($_POST) {
				// print_r(123);exit;
				$data = array();

				$data = $this->process_post_data($param);			

				$res = $this->db->where(array("id"=>$id))->update($this->products_classify, $data);
				if ($res) {
					$this->js_output_and_redirect("編輯成功", base_url()."mgr/product/classify");
				}else{
					$this->js_output_and_back("發生錯誤");
				}
			}else{
				
				$this->data['title'] = '編輯產品分類';

				$this->data['parent'] = '產品分類管理';
				$this->data['parent_link'] = base_url()."mgr/product/classify";

				$this->data['action'] = base_url()."mgr/product/classify/edit/".$data['id'];
				$this->data['submit_txt'] = "確認編輯";

				$this->data['param'] =$this->set_data_to_param($param, $data);
				$this->load->view("mgr/template_form", $this->data);
			}
		}else if($path == "delete"){
			if (is_numeric($id)) {
				$this->db->where(array("id" => $id));
				$this->db->update($this->products_classify, array("is_delete" => 1));
			}
			$this->js_output_and_redirect("您已刪除此類別", $_SERVER['HTTP_REFERER']);
			
		}else if($path == "sort"){
			$id = $this->input->post("id");
			if (!is_numeric($id)) show_404();
			$sort = $this->input->post("sort");

			$index = 1;
			foreach ($this->db->order_by("sort ASC")->get_where($this->products_classify, array("id<>"=>$id, "is_delete"=>0))->result_array() as $item) {
				if ($index == $sort) $index++;
				$data[] = array(
					"id"	=>	$item['id'],
					"sort"	=>	$index
				);
				$index++;
			}
			$data[] = array(
				"id"         =>	$id,
				"sort"       =>	$sort
			);
			$res = $this->db->update_batch($this->products_classify, $data, "id");
			if ($res) {
				$this->output(TRUE, "成功");
			}else{
				$this->output(FALSE, "失敗");
			}
		}
	}

	private $th_title = ["排序","顯示圖", "商品名稱", "產品分類", "定價/售價", "首頁商品","數量","建立日期", "動作"]; //, "置頂"
	private $th_width = ["180px", "", "", "",  "150px", "","","","130px"];
	private $order_column = ["", "", "", "", "", "", "", ""]; //, "is_head"
	private $can_order_fields = [];

	private $param = [

		["商品名稱", 		"name", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
		["商品簡介", 		"sub_title", 		"text", 				"", 		FALSE, 	"", 	4, 		12],				
		["定價", 		"price", 		"number", 				"", 		FALSE, 	"", 	4, 		12],
		["售價", 		"sale_price", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["數量", 		"number", 		"number", 				"", 		TRUE, 	"", 	4, 		12],
		["商品類別", 		"classify_id", 	"select", 		"", 		TRUE, 	"",4, 		12,		['id', 'classify']],

		["精選商品", 		"is_index", 	"select", 		"", 		FALSE, 	"", 4, 		12,		['id', 'text']],

		["產品細節", 		"detail", 		"textarea", 				"", 		FALSE, 	"", 	4, 		12],
		["產品特色", 		"special", 			"textarea", 		"", 		FALSE, 	"", 	6, 		12],		
		["圖片<br><span class='text text-danger'>尺寸比例1:1</span>", "images",	"test", 					"", 		TRUE, 	"", 	4, 		12, 1],

	];


	public function index()
	{
		$this->data['title'] = '商品管理';
		$this->data['sub_active'] = 'index';

		$this->data['action'] = base_url() . "mgr/product/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增商品', base_url() . "mgr/product/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add()
	{
		$this->data['sub_active'] = 'index';

		if ($_POST) {

			// print_r($_POST);exit;
			$data = $this->process_post_data($this->param);

			

			//若無上傳照片，名稱為空值，若名稱不為空值將照片存入			
			if ($_FILES['cover']['name'][0] != '') {
				$this->load->model("Pic_model");
				$photo_url = $this->Pic_model->upload_pics("cover");
				$data['images'] = serialize($photo_url);
			}

			$this->load->model("Product_model");
			$response_id = $this->Product_model->add($data);
			if ($response_id) {


				$this->js_output_and_redirect("新增成功", base_url() . "mgr/product/index");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->data['title'] = '新增商品';

			$this->data['parent'] = '商品管理';
			$this->data['parent_link'] = base_url() . "mgr/product";

			$this->data['action'] = base_url() . "mgr/product/add";
			$this->data['submit_txt'] = "新增";


			$this->data['select']['classify_id'] = $this->db->select("P.id,P.classify")
																						->from($this->products_classify . " P")																						
																						->where("P.is_delete = 0")																							
																						->get()->result_array();

			//column
			$this->data['select']['is_index'] =
			array(
				array("id" => "0", "text" => "無"),
				array("id" => "1", "text" => "精選商品"),
				array("id" => "2", "text" => "主打商品")				
			);
									

			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}


	public function del()
	{
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();


		$this->load->model("Product_model");
		if ($this->Product_model->edit($id, array("is_delete" => 1))) {
			$this->output(TRUE, "success");
		} else {
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id)
	{
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$d = $this->db->get_where($this->product, array("id" => $id))->row_array();
			$data = $this->process_post_data($this->param);

			//抓出刪除pic路徑
			$coverDeleted = $this->input->post("coverDeleted");

			//原本存在database的編輯前pic路徑
			$cover = ($d['images'] != "") ? unserialize($d['images']) : array();			

			if (count($_FILES['cover']['name']) > 10) {
				$this->js_output_and_back("上傳的照片不可超過4張");
			}
			if (count($_FILES['cover']['name']) > 0 && $_FILES['cover']['error'][0] != 4) {
				$this->load->model("Pic_model");
				$photo_url = $this->Pic_model->upload_pics("cover");
				$cover = array_merge($cover, $photo_url);
			}

			if ($coverDeleted != "") {
				$deleted = explode(",", $coverDeleted);
				for ($d = 0; $d < count($deleted) - 1; $d++) {
					if (in_array($deleted[$d], $cover)) {
						$key = array_search($deleted[$d], $cover);
						unset($cover[$key]);
					}
					if (file_exists($deleted[$d])) unlink($deleted[$d]);
				}
			}

			$data['images'] = serialize($cover);


			$this->load->model("Product_model");
			if ($this->Product_model->edit($id, $data)) {

				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/product/index");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			$this->load->model("Product_model");
			$data = $this->Product_model->get_data($id);
			$this->data['title'] = '商品編輯';
			$this->data['parent'] = '商品管理';
			$this->data['parent_link'] = base_url() . "mgr/prodect";
			$this->data['action'] = base_url() . "mgr/product/edit/" . $id;
			$this->data['submit_txt'] = "確認編輯";


			$this->data['select']['classify_id'] = $this->db->select("P.id,P.classify")
			->from($this->products_classify . " P")
			->where("P.is_delete = 0")
			->get()->result_array();

			//column
			$this->data['select']['is_index'] =
			array(
				array("id" => "0", "text" => "無"),
				array("id" => "1", "text" => "精選商品"),
				array("id" => "2", "text" => "主打商品")
			);

			$this->data['param'] = $this->set_data_to_param($this->param, $data);
			
			// print_r($this->data['param']);exit;



			


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
		$canbe_search_field = ["name", 'sub_title', "price",'sale_price'];

		$syntax = "is_delete = 0";
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

		$order_by = "sort ASC";
		if ($order_column[$order] != "") {
			$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
		}

		$this->load->model("Product_model");
		$data = $this->Product_model->get_list($syntax, $order_by, $page, $this->page_count);
		// print_r($data);exit;
		$i=0;
		foreach($data['list'] as $d){
			$classify_id = $d['classify_id'];

			$classify =$this->db->select("P.*")
										->from($this->products_classify . " P")										
										->where("P.id = $classify_id")
										->get()->row_array();

			$data['list'][$i]['classify'] = $classify['classify'];
			$i++;
		}
		
		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/product_item", array(
				"item"  =>	$item,
				"total" => $data['total']
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$data['total_page'],
			
		));
	}

	public function sort()
	{
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();
		$sort = $this->input->post("sort");
		
		$index = 1;
		foreach ($this->db->order_by("sort ASC")->get_where($this->product, array("id<>" => $id, "is_delete" => 0))->result_array() as $item) {
			if ($index == $sort) $index++;
			$data[] = array(
				"id"	=>	$item['id'],
				"sort"	=>	$index
			);
			$index++;
		}
		$data[] = array(
			"id"         =>	$id,
			"sort"       =>	$sort
		);
		
		$res = $this->db->update_batch($this->product, $data, "id");
		
		if ($res) {
			$this->output(TRUE, "成功");
		} else {
			$this->output(FALSE, "失敗");
		}
	}
}
