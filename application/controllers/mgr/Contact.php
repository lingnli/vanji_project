<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ini_set('post_max_size','1024M');
// ini_set('upload_max_filesize','1024M');
// require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Contact extends Base_Controller {


	private $th_title = ["#", "發問者資訊", "問題","建立日期", "動作"]; //, "置頂"
	private $th_width = ["", "", "150px", "", "","95px", "50px"];
	private $order_column = ["id", "", "", "", "", "create_date", ""]; //, "is_head"
	private $can_order_fields = [0, 4];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "contact";
		$this->load->model("Member_model");
	}
	
	public function index(){
		
		$this->data['title'] = '聯絡我們';

		$this->data['action'] = base_url()."mgr/contact/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增contact', base_url()."mgr/contact/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		//contact管理列表
		$this->load->view('mgr/template_list', $this->data);
	}

	public function del(){
		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update($this->contact, array("is_delete"=>1))){

				$this->output(TRUE, "success");
			}else{
				$this->output(FALSE, "fail");
			}
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get($this->contact)->row_array();

		$param = [
                
								["提問者", "name", "plain",$oridata['name']],
								["提問者信箱", "phone", "plain",$oridata['phone']],
								["提問者手機", "email", "plain",$oridata['email']],								
								["提問內容", "content", "plain",$oridata['content']],
								// ["回覆", "replay", "textarea_plain",$oridata['replay']],
								["提問日期", "create_date", "plain",$oridata['create_date']],
								// ["顯示留言", "is_show", "select", "", ["id", "is_show"]]	   	
            ];
		if ($_POST) {

			$data = array();
			foreach ($param as $item) {
				$data[$item[1]] = $this->input->post($item[1]);
			}
			
			//回覆存入資料庫
			// $res = $this->db->where(array("id"=>$id))->update($this->contact, $data);

			// if ($res) {
				

				$this->js_output_and_redirect("完成", base_url()."mgr/contact");
			// }else{
				// $this->js_output_and_back("發生錯誤");
			// }
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '回覆問題 '.$oridata['id'];
			$this->data['parent'] = '聯絡我們';
			$this->data['parent_link'] = base_url()."mgr/contact";
			$this->data['action'] = base_url()."mgr/contact/edit/".$oridata['id'];
			$this->data['submit_txt'] = "回上一頁";
			//前台列表選項
			$this->data['select']['is_show'] =
			array(
				0 => array(
					'id' => 0,
					'is_show' => '否'
				),
				1 => array(
					'id' => 1,
					'is_show' => "是"
				),
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}

	public function data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.content","P.name","P.email"];

		$syntax = "P.is_delete = 0";
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
		
		$total = $this->db->from($this->contact." P")
						//  ->join($this->contact_classify_table." S", "S.id = P.classify", "left")
						 ->where($syntax)->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*")
						 ->from($this->contact." P")
						//  ->join($this->contact_classify_table." S", "S.id = P.classify", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->contact, array("is_delete"=>0))->num_rows();

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/contact_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
}


