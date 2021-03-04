<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Base_Controller {
	private $th_title = ["#", "標題", "分類", "圖片", "介紹", "建立日期","動作"]; //, "置頂"
	private $th_width = ["", "150px", "", "150px", "", "", "150px",""];
	private $order_column = ["", "", "", "", "","",""]; //, "is_head"
	private $can_order_fields = [4];

	private $param = [
							["標題", 		"title", 		"text", 				"", 		TRUE, 	"", 	4, 		12],
							["分類", 		"classify_id", "select", 				"", 		TRUE, 	"", 	4, 		12, 	["id", "text"]],
							["圖片<br><span class='text text-danger'>尺寸比例 500 x 250</span>", 		"cover", 		"img", 				"", 		TRUE, 	"", 	4, 		12 , 1000/500],
							["介紹", 		"content", 		"textarea", 				"", 		TRUE, 	"", 	4, 		12],
							["日期", 		"date", 		"day", 				'', 		TRUE, 	"", 	4, 		12],
							
															            
            ];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "news";

		$this->load->model("News_model");
		
		$this->data['city'] = $this->get_zipcode()['city'];
	}

	//大分類
	public function classify($path = FALSE, $id = FALSE)
	{

		$this->data['sub_active'] = 'classify';
		$th_title = ["標題",  "大圖", "建立日期", "動作"];
		$th_width = ["", "300px", "", ""];
		$order_column = ["id",  "",  "", "", "create_date", ""];
		$can_order_fields = [0, 5];

		$param = [
			["分類", "title", "text", "", 		TRUE, 	"", 	4, 		12],
		];


		if ($path === FALSE) {
			$this->data['list'] = $this->db->select("P.*")
			->from($this->news_classify . " P")
			->where("P.is_delete=0")
			->order_by('P.id ASC')
			->get()->result_array();

			$this->load->view('mgr/news_classify', $this->data);
		} else if ($path == "add") {
			if ($_POST) {


				$data['title'] = $this->input->post("title");
				$check = $this->db->where(array("title" => $data['title']))->get($this->news_classify)->row_array();
				// print_r($check);
				// exit;
				if ($data['title'] == "") {
					$this->js_output_and_back("請填寫分類名稱");
				}
				if ($check) {
					$this->js_output_and_back("已有重複分類");
				}
				$res = $this->db->insert($this->news_classify, $data);
				if ($res) {
					$this->js_output_and_redirect("新增成功", base_url() . "mgr/news/classify");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '新增輪播圖';

				$this->data['parent'] = '輪播圖管理';
				$this->data['parent_link'] = base_url() . "mgr/news/classify";

				$this->data['action'] = base_url() . "mgr/news/classify/add";
				$this->data['submit_txt'] = "新增";

				$this->data['param'] = $param;
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "edit") {
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id" => $id))->get($this->news_classify)->row_array();

			if ($_POST) {
				$data = array();

				$data = $this->process_post_data($param);

				$res = $this->db->where(array("id" => $id))->update($this->news_classify, $data);
				if ($res) {
					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/news/classify");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '編輯消息分類';

				$this->data['parent'] = '消息分類管理';
				$this->data['parent_link'] = base_url() . "mgr/news/classify";

				$this->data['action'] = base_url() . "mgr/news/classify/edit/" . $data['id'];
				$this->data['submit_txt'] = "確認編輯";

				$this->data['param'] = $this->set_data_to_param($param, $data);
				$this->load->view("mgr/template_form", $this->data);
			}
		} else if ($path == "delete") {
			if (is_numeric($id)) {
				$this->db->where(array("id" => $id));
				$this->db->update($this->news_classify, array("is_delete" => 1));
			}
			$this->js_output_and_redirect("您已刪除此類別", $_SERVER['HTTP_REFERER']);
		} else if ($path == "sort") {
			$id = $this->input->post("id");
			if (!is_numeric($id)) show_404();
			$sort = $this->input->post("sort");

			$index = 1;
			foreach ($this->db->order_by("sort ASC")->get_where($this->news_classify, array("id<>" => $id, "is_delete" => 0))->result_array() as $item) {
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
			$res = $this->db->update_batch($this->news_classify, $data, "id");
			if ($res) {
				$this->output(TRUE, "成功");
			} else {
				$this->output(FALSE, "失敗");
			}
		}
	}

	public function index(){
		$this->data['title'] = '消息管理';
		$this->data['sub_active'] = 'index';

		$this->data['action'] = base_url()."mgr/news/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增消息', base_url()."mgr/news/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add(){
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);
			
			if ($this->News_model->add($data)) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/news");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '新增消息';

			$this->data['parent'] = '消息管理';
			$this->data['parent_link'] = base_url()."mgr/news";

			$this->data['action'] = base_url()."mgr/news/add";
			$this->data['submit_txt'] = "新增";

			//column
			$this->data['select']['classify_id']= $this->db->select("P.id,P.title as text")
																										->from($this->news_classify . " P")				
																										->where("P.is_delete = 0")
																										->get()->result_array();


			
			$this->data['param'] = $this->param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}


	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		

		if ($this->News_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		$this->data['sub_active'] = 'index';
		if ($_POST) {
			$data = $this->process_post_data($this->param);

			if ($this->News_model->edit($id, $data)) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/News");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$data = $this->News_model->get_data($id);
			$this->data['title'] = '消息編輯';
			$this->data['parent'] = '消息管理';
			$this->data['parent_link'] = base_url()."mgr/exhibit";
			$this->data['action'] = base_url()."mgr/News/edit/".$id;
			$this->data['submit_txt'] = "確認編輯";


			$this->data['select']['classify_id'] =$this->db->select("P.id,P.title as text")
																						->from($this->news_classify . " P")
																							->where("P.is_delete = 0")
																							->get()->result_array();

		
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

		$data = $this->News_model->get_list($syntax, $order_by, $page, $this->page_count);

		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/news_item", array(
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

	public function sort(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();
		$sort = $this->input->post("sort");

		$index = 1;
		foreach ($this->db->order_by("sort ASC")->get_where($this->event_table, array("id<>"=>$id, "is_delete"=>0))->result_array() as $item) {
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
		$res = $this->db->update_batch($this->event_table, $data, "id");
		if ($res) {
			$this->output(TRUE, "成功");
		}else{
			$this->output(FALSE, "失敗");
		}
	}
}
