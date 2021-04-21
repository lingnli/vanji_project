<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('post_max_size','1024M');
ini_set('upload_max_filesize','1024M');
require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Bill extends Base_Controller {
	private $th_title = ["訂單編號", "訂購者資訊","訂購商品", "付款方式","狀態", "取貨方式","金額","出貨", "建立時間", "動作"]; //, "置頂"
	private $th_width = ["20px", "", "250px", "","","80px","90px","","", "100px"];
	private $order_column = ["id", "sort","", "","", "","","create_date", ""]; //, "is_head"
	private $can_order_fields = [0, 6];



	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "bill";
		
	}

	//報名者總攬
	public function index(){
		$this->data['sub_active'] = 'bill';
		$this->data['title'] = '訂單管理';
		//連線傳送動作
		$this->data['action'] = base_url()."mgr/bill/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增文章', base_url()."mgr/product/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 0;
		$this->data['default_order_direction'] = 'DESC';

		//報名者列表
		$this->load->view('mgr/template_list', $this->data);
		
	}

	public function del(){

		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update($this->order, array("is_delete"=>1))){
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
		
		//抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get($this->order)->row_array();


		$oridata['products'] = unserialize($oridata['products']);
		$products_srt = "";
		foreach ($oridata['products'] as $p) {
			$products_srt .= 	 "#" . $p['name'] . " x " . $p['quantity'] . " $" . $p['sale_price'] * $p['quantity'] . "<br>";
		}
		$shop_str ="";
		if($oridata['delivery_status']==1){
			$shopinfo = unserialize($oridata['convenient_data']);
			
			if ($shopinfo['LogisticsSubType'] == 'FAMIC2C') {
				$store_type = '全家店到店';
			} else if (
				$shopinfo['LogisticsSubType'] == 'UNIMARTC2C'
			) {
				$store_type = '7-ELEVEN 超商交貨便';
			} else if ($shopinfo['LogisticsSubType'] == 'HILIFEC2C') {
				$store_type = '萊爾富店到店';
			} else if ($shopinfo['LogisticsSubType'] == 'OKMARTC2C:OK') {
				$store_type = 'OK店到店';
			}
			$shop_str = $store_type.'<br>CVSStoreID：'.$shopinfo['CVSStoreID'].'<br>門市：'.$shopinfo['CVSStoreName'];
		}

		$param = [
								["姓名", "username", "plain", $oridata['username']],
								["手機", "phone", "plain", $oridata['phone']],
								["email", "email", "plain", $oridata['email']],																							
								["訂單編號", "order_no", "plain", $oridata['order_no']],
								["訂單內容", "products_str", "plain", $products_srt],																							
								["付款方式", "payment", "select", $oridata['payment'], ["id","payment"]],
								["運送方式", "delivery", "select", $oridata['delivery'], ["id","delivery"]],
								["狀態", "status", "select", $oridata['status'], ["id","status"]],
								["是否出貨", "delivery_success", "select", $oridata['delivery_success'], ["id", "delivery_success"]],
								["訂單日期", "create_date", "plain", $oridata['create_date']],
								["超取資訊", "", "plain", $shop_str]
						];
						

		if ($_POST) {
			
			$data = array();
			foreach ($param as $item) {
				$data[$item[1]] = $this->input->post($item[1]);	
			}
			
			$save = array(
				'payment' => $data['payment'],
				'status' => $data['status'],
				'delivery_success' => $data['delivery_success'],
			);

			$res = $this->db->where(array("id"=>$id))->update($this->order, $save);

			if ($res) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/bill");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '訂單管理：'.$oridata['order_no'];
			$this->data['parent'] = '訂單管理';
			$this->data['parent_link'] = base_url()."mgr/bill";
			$this->data['action'] = base_url()."mgr/bill/edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";


		//付款方式選項列表
			$this->data['select']['payment'] = 
			array(
				0=>array(
					'id'=>'credit',
					'payment'=>'信用卡一次付清'),
				1=>array(
					'id'=> 'credit_3',
					'payment'=>"信用卡分三期"),
				2 => array(
					'id' => 'atm',
					'payment' => "銀行轉帳"
				),
			);

			//付款方式選項列表
			$this->data['select']['delivery_success'] =
			array(
				0 => array(
					'id' => 0,
					'delivery_success' => '未出貨'
				),
				1 => array(
					'id' => 1,
					'delivery_success' => "已出貨"
				)
			);	

		//付款方式選項列表
			$this->data['select']['delivery'] = 
			array(
				0=>array(
					'id'=>'convenient',
					'delivery'=>'超商取貨'),
				1=>array(
					'id'=>'home',
					'delivery'=>"宅配"),					
			);


			//報名狀態選項列表
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'paid',
					'status'=>'已付款'),
				1=>array(
					'id'=>'pending',
					'status'=>"處理中"),
				2=>array(
					'id'=>'cancel',
					'status'=>"取消"),
				3=>array(
					'id'=>'delete',
					'status'=>"刪除")				
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
		$eventsearch      = ($this->input->post("eventsearch"))?$this->input->post("eventsearch"):"";
	
		// $eventsearch      = $this->input->post("eventsearch");

		$order_column = $this->order_column;

		// print_r($search);
		// exit;
		
						
		$canbe_search_field = ["O.username","O.order_no","O.email"];

		$syntax = "O.is_delete = 0 AND O.status <> 'delete'";
		
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




		
		$total = $this->db->from($this->order." O")
						//  ->join($this->recommend." C", "C.code = P.recommend", "left")
						 ->where($syntax)->get()->num_rows();

						 
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "O.create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = "O.".$order_column[$order]." ".$direction.", ".$order_by;
				}
				
		$list = $this->db->select("O.*")
						 ->from($this->order." O")
						//  ->join($this->recommend." C", "C.code = P.recommend AND C.is_delete =0", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$index=0;
		foreach($list as $l){
		$list[$index]['array']= unserialize($l['products']);		

		$index++;
		}
	

		$total_num = $this->db->get_where($this->order, array("is_delete"=>0))->num_rows();

		//報名者總覽
		$html = "";
		foreach ($list as $item) {
			$products = unserialize($item['products']);		
			$html .= $this->load->view("mgr/items/bill_item.php", array(
				"item"  =>	$item,
				"total" =>	$total_num,
				"products"=>$products
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);
		
		if ($eventsearch != "") $html = preg_replace('/'.$eventsearch.'/i', '<mark data-markjs="true">'.$eventsearch.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page,
			"list"       =>	$list
		));
	}


}
