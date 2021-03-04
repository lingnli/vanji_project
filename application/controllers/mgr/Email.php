<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ini_set('post_max_size','1024M');
// ini_set('upload_max_filesize','1024M');
// require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Email extends Base_Controller {


	private $th_title = ["#", "訂閱email","訂閱日期", "動作"]; //, "置頂"
	private $th_width = ["", "","", "50px"];
	private $order_column = ["id", "", "", "", "", "create_date", ""]; //, "is_head"
	private $can_order_fields = [0, 4];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "index";
		$this->load->model("Member_model");
	}
	
	public function index(){
		$this->data['sub_active'] = "email";
		$this->data['title'] = '已訂閱電子報管理';

		$this->data['action'] = base_url()."mgr/email/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增email', base_url()."mgr/email/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		//email管理列表
		$this->load->view('mgr/template_list', $this->data);
	}

	public function del(){
		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update($this->email, array("is_delete"=>1))){

				$this->output(TRUE, "success");
			}else{
				$this->output(FALSE, "fail");
			}
		}else{
			$this->output(FALSE, "fail");
		}
	}



	public function data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.email","P.create_date"];

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
		
		$total = $this->db->from($this->email." P")
						//  ->join($this->email_classify_table." S", "S.id = P.classify", "left")
						 ->where($syntax)->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.create_date ASC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*")
						 ->from($this->email." P")
						//  ->join($this->email_classify_table." S", "S.id = P.classify", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->email, array("is_delete"=>0))->num_rows();

		
		$html = "";
		$i=1;
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/email_item", array(
				"item"  =>	$item,
				"total" =>	$total_num,
				"number" =>	$i
			), TRUE);

			$i++;
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}



}


