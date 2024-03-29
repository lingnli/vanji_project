<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {
		private $th_title = ["輪播圖" ,"建立日期", "動作"];
		private $th_width = [ "", "150px", "",""];
		private $order_column = ["id",  "",  "","", "create_date", ""];
		private $can_order_fields = [0, 5];

		private $param = [
								["輪播圖<br><span class='text text-danger'>尺寸比例 1420 x 680</span>", "cover", "img",	"", 		TRUE, 	"", 	4, 		12, 1420/680],
								// ["手機版尺寸圖<br><span class='text text-danger'>尺寸比例 480 x 860</span>", "mobile_cover", "img",	"", 		TRUE, 	"", 	4, 		12, 480 / 860],								
								// ["標題", "title", "text","", 		FALSE, 	"", 	4, 		12],								
						];

		private $params = [
		["大圖<br><span class='text text-danger'>尺寸比例 440 x 270</span>", "cover", "img",	"", 		TRUE, 	"", 	4, 		12, 440 / 270],
		["標題", "title", "text", "", 		TRUE, 	"", 	4, 		12],
		["子標題", "sub_title", "text", "", 		TRUE, 	"", 	4, 		12],
	];

	private $down_params = [
		["發言人", "speaker", "text",	"", 		TRUE, 	"", 	4, 		12],
		["內文", "content", "text", "", 		TRUE, 	"", 	4, 		12],
		["背景圖<br><span class='text text-danger'>尺寸比例 1920 x 600</span>", "cover", "img",	"", 		FALSE, 	"", 	4, 		12, 1920 / 600],
	];

	private $down_params1 = [
		["發言人", "speaker", "text",	"", 		TRUE, 	"", 	4, 		12],
		["內文", "content", "text", "", 		TRUE, 	"", 	4, 		12],
		// ["背景圖<br><span class='text text-danger'>尺寸比例 1920 x 600</span>", "cover", "img",	"", 		FALSE, 	"", 	4, 		12, 1920 / 600],
	];	
						
	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "home";
	}

	public function index(){
		show_404();
	}

	//輪播圖
	public function carousel($path = FALSE, $id = FALSE){
		
		$this->data['sub_active'] = 'carousel';		
		


		if ($path === FALSE) {
			$this->data['title'] = '輪播圖管理';

			$this->data['action'] = base_url()."mgr/home/carousel/";

			$this->data['th_title'] = $this->th_title;
			$this->data['th_width'] = $this->th_width;
			$this->data['can_order_fields'] = $this->can_order_fields;
			$this->data['tool_btns'] = [
				['新增輪播圖', base_url()."mgr/home/carousel/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 1;
			$this->data['default_order_direction'] = 'ASC';

			$this->load->view('mgr/template_list', $this->data);
		}else if ($path == "data") {
			$page        = ($this->input->post("page"))?$this->input->post("page"):1;
			$search      = ($this->input->post("search"))?$this->input->post("search"):"";
			$order       = ($this->input->post("order"))?$this->input->post("order"):0;
			$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

			$order_column = $this->order_column;
			$canbe_search_field = ["title"];

			$syntax = "is_delete = 0";
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
			
			$total = $this->db->where($syntax)->get($this->carousel)->num_rows();
			$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

			$order_by = "create_date DESC";
	        if ($order_column[$order] != "") {
	            $order_by = $order_column[$order]." ".$direction.", ".$order_by;
	        }
			$list = $this->db->select("*")
							 ->from($this->carousel)
							 ->where($syntax)
							 ->order_by($order_by)
							 ->limit($this->page_count, ($page-1)*$this->page_count)
							 ->get()->result_array();

			$total_num = $this->db->get_where($this->carousel, array("is_delete"=>0))->num_rows();
			$html = "";
			foreach ($list as $item) {
				if ($search != "") {
					foreach ($item as $key => $value) {
						if (in_array($key, $canbe_search_field) && $key != "url") {
							$item[$key] = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $item[$key]);
						}
					}	
				}
				
				$html .= $this->load->view("mgr/items/carousel_item", array(
					"item"  =>	$item,					
					"total"	=>	$total_num
				), TRUE);
			}

			$this->output(TRUE, "成功", array(
				"html"       =>	$html,
				"page"       =>	$page,
				"total_page" =>	$total_page
			));
		}else if ($path == "add") {
			if ($_POST) {
				$data = array();

				$data = $this->process_post_data($this->param);			

				$res = $this->db->insert($this->carousel, $data);
				if ($res) {
					$this->js_output_and_redirect("新增成功", base_url()."mgr/home/carousel");
				}else{
					$this->js_output_and_back("發生錯誤");
				}
			}else{
				$this->data['title'] = '新增輪播圖';

				$this->data['parent'] = '輪播圖管理';
				$this->data['parent_link'] = base_url()."mgr/home/carousel";

				$this->data['action'] = base_url()."mgr/home/carousel/add";
				$this->data['submit_txt'] = "新增";

				$this->data['param'] = $this->param;
				$this->load->view("mgr/template_form", $this->data);
			}
		}else if($path == "edit"){
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id"=>$id))->get($this->carousel)->row_array();

			if ($_POST) {
				$data = array();

				$data = $this->process_post_data($this->param);			

				$res = $this->db->where(array("id"=>$id))->update($this->carousel, $data);
				if ($res) {
					$this->js_output_and_redirect("編輯成功", base_url()."mgr/home/carousel");
				}else{
					$this->js_output_and_back("發生錯誤");
				}
			}else{
				$this->data['title'] = '編輯輪播圖';

				$this->data['parent'] = '輪播圖管理';
				$this->data['parent_link'] = base_url()."mgr/home/carousel";

				$this->data['action'] = base_url()."mgr/home/carousel/edit/".$data['id'];
				$this->data['submit_txt'] = "確認編輯";

				$this->data['param'] =$this->set_data_to_param($this->param, $data);
				$this->load->view("mgr/template_form", $this->data);
			}
		}else if($path == "del"){
			$id = $this->input->post("id");			
			if (is_numeric($id)) {
				if($this->db->where(array("id"=>$id))->update($this->carousel, array("is_delete"=>1))){
					
					$this->output(TRUE, "success");
				}else{
					$this->output(FALSE, "fail");
				}
			}else{
				$this->output(FALSE, "post is not number");
			}
		}else if($path == "sort"){
			$id = $this->input->post("id");
			if (!is_numeric($id)) show_404();
			$sort = $this->input->post("sort");

			$index = 1;
			foreach ($this->db->order_by("sort ASC")->get_where($this->carousel, array("id<>"=>$id, "is_delete"=>0))->result_array() as $item) {
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
			$res = $this->db->update_batch($this->carousel, $data, "id");
			if ($res) {
				$this->output(TRUE, "成功");
			}else{
				$this->output(FALSE, "失敗");
			}
		}
	}

	//手機版圖
	public function banner($path = FALSE, $id = FALSE)
	{

		$this->data['sub_active'] = 'banner';



		if ($path === FALSE) {
			$this->data['title'] = '中間圖管理';

			$this->data['action'] = base_url() . "mgr/home/banner/";

			$this->data['th_title'] =["標題",  "電腦版圖", "子標題","建立日期", "動作"];
			$this->data['th_width'] =
			["", "150px", "", "",""];
			$this->data['can_order_fields'] = $this->can_order_fields;
			$this->data['tool_btns'] = [
				// ['新增輪播圖', base_url() . "mgr/home/banner/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 1;
			$this->data['default_order_direction'] = 'ASC';

			$this->load->view('mgr/template_list', $this->data);
		} else if ($path == "data") {
			$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
			$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
			$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
			$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

			$order_column = $this->order_column;
			$canbe_search_field = ["title"];

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

			$total = $this->db->where($syntax)->get($this->banner)->num_rows();
			$total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

			$order_by = "create_date DESC";
			if ($order_column[$order] != "") {
				$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
			}
			$list = $this->db->select("*")
			->from($this->banner)
				->where($syntax)
				->order_by($order_by)
				->limit($this->page_count, ($page - 1) * $this->page_count)
				->get()->result_array();

			$total_num = $this->db->get_where($this->banner, array("is_delete" => 0))->num_rows();
			$html = "";
			foreach ($list as $item) {
				if ($search != "") {
					foreach ($item as $key => $value) {
						if (in_array($key, $canbe_search_field) && $key != "url") {
							$item[$key] = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $item[$key]);
						}
					}
				}

				$html .= $this->load->view("mgr/items/banner_item", array(
					"item"  =>	$item,
					"total"	=>	$total_num
				), TRUE);
			}

			$this->output(TRUE, "成功", array(
				"html"       =>	$html,
				"page"       =>	$page,
				"total_page" =>	$total_page
			));
		} else if ($path == "add") {
			if ($_POST) {
				$data = array();

				$data = $this->process_post_data($this->params);

				$res = $this->db->insert($this->banner, $data);
				if ($res) {
					$this->js_output_and_redirect("新增成功", base_url() . "mgr/home/banner");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '新增中間圖';

				$this->data['parent'] = '中間圖管理';
				$this->data['parent_link'] = base_url() . "mgr/home/banner";

				$this->data['action'] = base_url() . "mgr/home/banner/add";
				$this->data['submit_txt'] = "新增";

				$this->data['param'] = $this->params;
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "edit") {
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id" => $id))->get($this->banner)->row_array();

			if ($_POST) {
				$data = array();
				$params
				= [
					["電腦版尺寸圖<br><span class='text text-danger'>尺寸比例 1200 x 800</span>", "cover", "img",	"", 		TRUE, 	"", 	4, 		12, 1200 / 800],
					["子標題", "sub_title", "text", "", 		TRUE, 	"", 	4, 		12],
					["標題", "title", "text", "", 		TRUE, 	"", 	4, 		12],
				];
				$data = $this->process_post_data($params);

				$res = $this->db->where(array("id" => $id))->update($this->banner, $data);
				if ($res) {
					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/home/banner");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '編輯中間圖';

				$this->data['parent'] = '中間圖管理';
				$this->data['parent_link'] = base_url() . "mgr/home/banner";

				$this->data['action'] = base_url() . "mgr/home/banner/edit/" . $data['id'];
				$this->data['submit_txt'] = "確認編輯";

				$params
				= [
					["電腦版尺寸圖<br><span class='text text-danger'>尺寸比例 1200 x 800</span>", "cover", "img",	"", 		TRUE, 	"", 	4, 		12, 1200 / 800],
					["子標題", "sub_title", "text", "", 		TRUE, 	"", 	4, 		12],
					["標題", "title", "text", "", 		TRUE, 	"", 	4, 		12],
				];

				$this->data['param'] = $this->set_data_to_param($params, $data);
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "del") {
			$id = $this->input->post("id");
			if (is_numeric($id)) {
				if ($this->db->where(array("id" => $id))->update($this->banner, array("is_delete" => 1))) {

					$this->output(TRUE, "success");
				} else {
					$this->output(FALSE, "fail");
				}
			} else {
				$this->output(FALSE, "post is not number");
			}
		} else if ($path == "sort") {
			$id = $this->input->post("id");
			if (!is_numeric($id)) show_404();
			$sort = $this->input->post("sort");

			$index = 1;
			foreach ($this->db->order_by("sort ASC")->get_where($this->banner, array("id<>" => $id, "is_delete" => 0))->result_array() as $item) {
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
			$res = $this->db->update_batch($this->banner, $data, "id");
			if ($res) {
				$this->output(TRUE, "成功");
			} else {
				$this->output(FALSE, "失敗");
			}
		}
	}

	//手機版圖
	public function down($path = FALSE, $id = FALSE)
	{

		$this->data['sub_active'] = 'down';



		if ($path === FALSE) {
			$this->data['title'] = '底部文案管理';

			$this->data['action'] = base_url() . "mgr/home/down/";

			$this->data['th_title'] = ["發言人",  "背景圖","內文", "建立日期", "動作"];
			$this->data['th_width'] = ["","","","",""];
			$this->data['can_order_fields'] = $this->can_order_fields;
			$this->data['tool_btns'] = [
				['新增文案', base_url() . "mgr/home/down/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 1;
			$this->data['default_order_direction'] = 'ASC';

			$this->load->view('mgr/template_list', $this->data);
		} else if ($path == "data") {
			$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
			$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
			$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
			$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

			$order_column = $this->order_column;
			$canbe_search_field = ["title"];

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

			$total = $this->db->where($syntax)->get($this->down)->num_rows();
			$total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

			$order_by = "create_date DESC";
			if ($order_column[$order] != "") {
				$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
			}
			$list = $this->db->select("*")
			->from($this->down)
				->where($syntax)
				->order_by($order_by)
				->limit($this->page_count, ($page - 1) * $this->page_count)
				->get()->result_array();

			$total_num = $this->db->get_where($this->down, array("is_delete" => 0))->num_rows();
			$html = "";
			foreach ($list as $item) {
				if ($search != "") {
					foreach ($item as $key => $value) {
						if (in_array($key, $canbe_search_field) && $key != "url") {
							$item[$key] = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $item[$key]);
						}
					}
				}

				$html .= $this->load->view("mgr/items/down_item", array(
					"item"  =>	$item,
					"total"	=>	$total_num
				), TRUE);
			}

			$this->output(TRUE, "成功", array(
				"html"       =>	$html,
				"page"       =>	$page,
				"total_page" =>	$total_page
			));
		} else if ($path == "add") {
			if ($_POST) {
				$data = array();

				$data = $this->process_post_data($this->down_params1);

				$res = $this->db->insert($this->down, $data);
				if ($res) {
					$this->js_output_and_redirect("新增成功", base_url() . "mgr/home/down");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '新增底部文案';

				$this->data['parent'] = '底部文案管理';
				$this->data['parent_link'] = base_url() . "mgr/home/down";

				$this->data['action'] = base_url() . "mgr/home/down/add";
				$this->data['submit_txt'] = "新增";

				$this->data['param'] = $this->down_params1;
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "edit") {
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id" => $id))->get($this->down)->row_array();

			if ($_POST) {
				$data = array();

				if($id==1){
					$data = $this->process_post_data($this->down_params);
				}else{
					$data = $this->process_post_data($this->down_params1);
				}
				

				$res = $this->db->where(array("id" => $id))->update($this->down, $data);
				if ($res) {
					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/home/down");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '編輯底部文案';

				$this->data['parent'] = '底部文案管理';
				$this->data['parent_link'] = base_url() . "mgr/home/down";

				$this->data['action'] = base_url() . "mgr/home/down/edit/" . $data['id'];
				$this->data['submit_txt'] = "確認編輯";

				if($id==1){
					$this->data['param'] = $this->set_data_to_param($this->down_params, $data);
				}else{
					$this->data['param'] = $this->set_data_to_param($this->down_params1, $data);
				}
				
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "del") {
			$id = $this->input->post("id");
			if (is_numeric($id)) {
				if ($this->db->where(array("id" => $id))->update($this->down, array("is_delete" => 1))) {

					$this->output(TRUE, "success");
				} else {
					$this->output(FALSE, "fail");
				}
			} else {
				$this->output(FALSE, "post is not number");
			}
		} else if ($path == "sort") {
			$id = $this->input->post("id");
			if (!is_numeric($id)) show_404();
			$sort = $this->input->post("sort");

			$index = 1;
			foreach ($this->db->order_by("sort ASC")->get_where($this->down, array("id<>" => $id, "is_delete" => 0))->result_array() as $item) {
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
			$res = $this->db->update_batch($this->down, $data, "id");
			if ($res) {
				$this->output(TRUE, "成功");
			} else {
				$this->output(FALSE, "失敗");
			}
		}
	}




}
