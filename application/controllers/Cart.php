<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Login_model");
		$this->load->model("Member_model");
		$this->load->model("Pay_model");
		
	}


	//有選擇規格的加入購物車
	public function add($p_id)
	{
						
		$quantity            =	$this->input->post("quantity")? $this->input->post("quantity"):1;

		if ($quantity == "") {

			echo "<script> alert('請選擇數量'); history.back(); </script>";
			return;
		}

		//session中抓出使用者id去判斷是否登入
		$u_id =	$this->encryption->decrypt($this->session->uid);


		$product = array();
		$product['p_id'] = $p_id;
		$product['quantity'] = $quantity;

		//無$u_id->未登入，將購物車記錄在session
		if (!$u_id) {

			$temp_cart = $this->session->userdata('temp_cart');
			//判斷是否已有$temp_cart在session


			//是->已加入過商品
			if ($temp_cart) {
				//比對加入商品是否已存在temp_cart				

				//比對是否有重複的商品
				$is_inarray = FALSE; //是否在array中
				$i = 0;

				foreach ($temp_cart as $t) {
					
					if ($t['p_id'] == $p_id) {
						//若產品id及spec_id相同->增加數量
						$temp_cart[$i]['quantity'] += $product['quantity'];
						// print_r('111');exit;
						$_SESSION['temp_cart'] = $temp_cart;
						$is_inarray = TRUE;
						$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
					}
					
					$i++;
				}

				if (!$is_inarray) {
					//產品id不同spec_id不同->增加資料
					array_push($temp_cart, $product);
					$_SESSION['temp_cart'] = $temp_cart;
					$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
				}
			} else {
				//不存在$temp_cart，第一次加入商品

				//建立暫時購物車
				$temp_cart = array();
				array_push($temp_cart, $product);
				


				//將temp_cart存入session
				$_SESSION['temp_cart'] = $temp_cart;
				$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
			}

			//有u_id 若有購物車存在cart table
		} else {
			//$u_id存在，已登入

			//先確認是否存在未結購物車
			$check_cart = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->num_rows();

			// 若不存在，創立新cart list
			if ($check_cart == 0) {

				$cart_array = array();
				array_push($cart_array, $product);

				$data = array(
					"u_id" =>	$u_id,
					//存進去db的array需轉換
					"content" =>	serialize($cart_array)
				);

				$res =  $this->db->insert($this->cart, $data);

				$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);

				//若存在	
			} else {


				//取出此cart_id
				$cart = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->row_array();
				
				//取出此張購物車的content
				$oridata = $this->db->where(array("id" => $cart['id'], "u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->row_array();

				//取出舊商品array
				$content = unserialize($oridata['content']);
				
				//比對是否有重複的商品
				$is_inarray = FALSE; //是否在array中
				$i = 0;
				if($content!=array()){
				foreach ($content as $t) {

					if (isset($t['p_id'])) {
						if ($t['p_id'] == $p_id) {
							//若產品id及spec_id相同->增加數量
							$content[$i]['quantity'] += $product['quantity'];
							// print_r('111');exit;
							$data['content'] = serialize($content);
							$this->db->where(array("u_id" => $u_id))->update($this->cart, $data);
							$is_inarray = TRUE;
							$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
						}
					}
					$i++;
				}
				
				
				if (!$is_inarray) {
					//產品id不同->增加資料
					array_push($content, $product);

					$data['content'] = serialize($content);
					$this->db->where(array("u_id" => $u_id))->update($this->cart, $data);

					$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
				}
				}else{
					$product_item = array($product);
					$data['content'] = serialize($product_item);
					$this->db->where(array("u_id" => $u_id))->update($this->cart, $data);
					$this->js_output_and_redirect("加入購物車成功", $_SERVER['HTTP_REFERER']);
				}
			}
		}
	}

	//cart頁面 刪除商品
	public function del($p_id)
	{

		//從session中取得u_id
		$u_id = $this->encryption->decrypt($this->session->uid);
		
		if($u_id !=""){
			//取出未結購物車
			$cart = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->row_array();
			//取出購物車內容
			$cart_array = unserialize($cart["content"]);

			//array中找對應的值後刪去

			foreach ($cart_array as $key => $value) {

				if ($value['p_id'] == $p_id) {

					unset($cart_array[$key]);
				}
			}

			//存進資料庫
			$data = array(
				"content" =>	serialize($cart_array)
			);

			$res = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->update($this->cart, $data);
			if ($res) {
				$this->js_output_and_redirect("刪除商品成功", $_SERVER['HTTP_REFERER']);
			} else {
				$this->js_output_and_redirect("刪除商品失敗", $_SERVER['HTTP_REFERER']);
			}
		}else{
			$cart_content = $this->session->userdata('temp_cart');
			
			foreach ($cart_content as $key => $value) {

				if ($value['p_id'] == $p_id) {

					unset($cart_content[$key]);
				}
			}
			$_SESSION['temp_cart'] = $cart_content;
			$this->js_output_and_redirect("刪除商品成功", $_SERVER['HTTP_REFERER']);
		}



	}


	public function index() //購物車頁面
	{

		//判斷是否登入
		// $user_id = $this->encryption->decrypt($this->session->uid);w

		// if(!$user_id){
		// 	$this->js_output_and_redirect("請先登入後再進行結帳", base_url()."home/login_register");
		// 	exit;
		// }

		//運費
		
		// $ship =$this->db->get_where('funiture_info', array("id=" => 10))->row_array();
		// $this->data['ship'] = $ship['content'];
		// print_r($this->data['ship']);exit;


		// $city = $this->get_zipcode()['city'];
		// $this->data['city'] = $city;

		//判斷是否登入
		$user_id = $this->encryption->decrypt($this->session->uid);
		if($user_id){
			//已登入
			$this->data['user'] = $this->db->where(array("id" => $user_id))->get($this->user)->row_array();			
			$cart = $this->db->where(array("u_id" => $user_id, "is_checkout" => 0))->get($this->cart)->row_array();
			$cart_content = unserialize($cart['content']);
		}else{
			//未登入
			$cart_content = $this->session->userdata('temp_cart');
		}
		


		$total_price = 0;
		$total_num = 0;
		$product = array();
		
		if($cart_content != array()){
			foreach($cart_content as $c){
				
			$p_id = $c['p_id'];			
			$product_item =
				$this->db->select('P.*')
				->from("product P")																
				->where("P.id=$p_id")				
				->get()->row_array();				

				$product_item['number'] = $c['quantity'];
				$product_item['images'] = unserialize($product_item['images']);
				$total_price += $product_item['sale_price']*$c['quantity'];
				$total_num += $c['quantity'];

				array_push($product,$product_item);
		}
		}

		$this->data['product'] = $product;
		$this->data['total_price'] = $total_price;
		// $this->data['total_price_ship'] = $total_price + (int)$this->data['ship'];
		$this->data['total_price_ship'] = $total_price ;
		$this->data['product_num'] = $total_num;	
		// print_r($this->data);exit;


		$this->load->view('cart', $this->data);
	}


	//商品數量增加存入db
	public function update_amount()
	{
		//接收傳來
		$p_id = $this->input->post("p_id");
		$num = $this->input->post("num");

		//從session中取得u_id
		$u_id = $this->encryption->decrypt($this->session->uid);
		//從是否存在$u_id判斷登入狀態

		if($u_id != ""){
			//取出未結購物車
			$cart = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->row_array();
			//取出購物車內容
			$cart_array = unserialize($cart["content"]);

			//根據spec_id去找對應的array
			$i = 0;
			foreach ($cart_array as $p) {
				if ($p['p_id'] == $p_id) {
					$cart_array[$i]['quantity'] = $num;
				}
				$i++;
			}


			//存進資料庫
			$data = array(
				"content" =>	serialize($cart_array)
			);

			//總金額 數量
			$total_price = 0;

			foreach ($cart_array as $p) {
				$p_item_id = $p['p_id'];
				$product_spec_price = $this->db->where(array("id" => $p_item_id))->get($this->product)->row_array();

				$total_price += $product_spec_price['sale_price'] * $p['quantity'];
			}
			$res = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->update($this->cart, $data);


			//該商品總金額		
			$product_choose = $this->db->where(array("id" => $p_id))->get($this->product)->row_array();
			$product_price = $product_choose['sale_price'] * $num;


			if ($res) {
				$this->output(TRUE, '成功', array('total_price' => $total_price, 'product_price' => $product_price));
			} else {
				$this->output(FALSE, '加入購物車發生問題');
			}
		}else{

			//取出購物車內容
			$cart_array = $this->session->userdata('temp_cart');;
			
			//根據spec_id去找對應的array
			$i = 0;
			foreach ($cart_array as $p) {
				if ($p['p_id'] == $p_id) {
					$cart_array[$i]['quantity'] = $num;
				}
				$i++;
			}

			//總金額 數量
			$total_price = 0;

			foreach ($cart_array as $p) {
				$p_item_id = $p['p_id'];
				$product_spec_price = $this->db->where(array("id" => $p_item_id))->get($this->product)->row_array();

				$total_price += $product_spec_price['sale_price'] * $p['quantity'];
			}

			$_SESSION['temp_cart'] = $cart_array;


			//該商品總金額		
			$product_choose = $this->db->where(array("id" => $p_id))->get($this->product)->row_array();
			$product_price = $product_choose['sale_price'] * $num;

			$this->output(TRUE, '成功', array('total_price' => $total_price, 'product_price' => $product_price));

		}
	
	}

	//確認優惠代碼
	public function coupon_check()
	{
		//接收傳來spec_id
		$coupon = $this->input->post("coupon");

		//判斷coupon是否存在且可使用
		$coupon_check = $this->db->select("C.*, count(U.id) as used")
							->from("coupon C")
							->join("coupon_use U", "U.coupon_id = C.id AND U.status ='used'", "left")
							->where("C.is_delete=0 AND C.code = '$coupon'")
							->get()->row_array();
		
		
		if ($coupon_check['id']!= null) {
			if($coupon_check['use_limit']==-1 ||$coupon_check['use_limit']<$coupon_check['used']){
				$this->output(TRUE, '成功', array('discount' => $coupon_check['discount']));	
			}else{
				$this->output(FALSE, '失敗');
			}
			
		} else {
			$this->output(FALSE, '失敗');
		}
	}

	//結帳頁面
	public function check() 
	{

		// print_r($_POST);exit;

		$coupon            =	$this->input->post("coupon");
		$delivery            =	$this->input->post("delivery") ? $this->input->post("delivery") : "";
		$payment            =	$this->input->post("payment") ? $this->input->post("payment") : "";

		if ($payment == "") {
			$this->js_output_and_back("請選擇付款方式");
			exit();
		}
		if ($delivery == "") {
			$this->js_output_and_back("請選擇運送方式");
			exit();
		}		
		//判斷是否登入
		$user_id = $this->encryption->decrypt($this->session->uid);

		// if (!$user_id) {
		// $this->js_output_and_redirect("請先登入後再進行結帳", base_url() . "home/login_register");
		// exit;

		// }




		//抓出user的id
		if ($user_id) {
			$this->data['user'] = $this->db->where(array("id" => $user_id))->get($this->user)->row_array();
			$cart = $this->db->where(array("u_id" => $user_id, "is_checkout" => 0))->get($this->cart)->row_array();

			$cart_content = unserialize($cart['content']);
		}else{
			$cart_content = $this->session->userdata('temp_cart');
		}


		$total_price = 0;
		$total_amount = 0;
		
		$product = array();
		
		if ($cart_content != array()) {
			foreach ($cart_content as $c) {

				$p_id = $c['p_id'];
				$product_item =
					$this->db->select('P.*')
					->from("product P")
					->where("P.id=$p_id")
					->get()->row_array();

				$product_item['number'] = $c['quantity'];
				$product_item['images'] = unserialize($product_item['images']);
				$total_price += $product_item['sale_price'] * $c['quantity'];
				$total_amount += $c['quantity'];

				array_push($product, $product_item);
			}
		}
		
		$coupon_discount = 0;
		//優惠卷 
		if($coupon!=""){
			
			$this->data['coupon'] = $this->db->where(array("code" => $coupon))->get($this->coupon)->row_array();
			$coupon_discount = $this->data['coupon']['discount'];
		}else{
			
			$this->data['coupon'] = "";
		}
		
		$total_price = $total_price - $coupon_discount;

		$this->data['coupon_code'] = $coupon;
		$this->data['delivery'] = $delivery;
		$this->data['payment'] = $payment;
		$this->data['product'] = $product;

		$discount_type = (int)$this->data['discount_type'];
		$this->data['discount_type_code'] = $discount_type;
		$today = date('Y-m-d H:i:s');
		$discount_str = "";
		$discount_number = 0;

		if ($discount_type == 1) {

			$discount_type = '滿額折扣';	
			
			//取得所有滿額折扣
			$discount_array
			=
			$this->db->select('P.*')
			->from("discout P")
			->where("P.is_delete = 0 AND P.discount_type = 1 AND( '$today' Between P.start_date and P.end_date) ")
			->order_by("P.price_limit DESC")
			->get()->result_array();

			//找到對應折扣
			$discount_select_array = array();
			foreach($discount_array as $d){
				if($total_price >= $d['price_limit']){
					$discount_select_array = $d;
					break;
				}
			}

			if($discount_select_array != array()){
				$discount_limit = (int)$discount_select_array['price_limit']; //金額
				$discount_percent = $discount_select_array['discount'];
				$discount_number = (int)$discount_select_array['discount'];
				$discount_type = $discount_select_array['title'];


				if ($total_price >= $discount_limit) {
					$total_price = $total_price * ($discount_number / 100);
					if (strpos($discount_percent, '0')) {
						$discount_percent = substr($discount_percent, 0, -1);
						$discount_str = $discount_percent . '折';
					} else {
						$discount_str = $discount_percent . '折';
					}
				}
			}


		} elseif ($discount_type == 2) {
			

			$discount_type = '滿件折扣';

			//取得所有滿件折扣
			$discount_array
			=
			$this->db->select('P.*')
			->from("discout P")
			->where("P.is_delete = 0 AND P.discount_type = 2 AND( '$today' Between P.start_date and P.end_date) ")
			->order_by("P.quantity_limit DESC")
			->get()->result_array();

			//找到對應折扣
			$discount_select_array = array();
			foreach ($discount_array as $d) {
				if ($total_amount >= $d['quantity_limit']) {
					$discount_select_array = $d;
					break;
				}
			}

			if($discount_select_array != array()){
				$discount_limit = (int)$discount_select_array['quantity_limit']; //件數
				$discount_percent = $discount_select_array['discount'];
				$discount_number = (int)$discount_select_array['discount'];
				$discount_type = $discount_select_array['title'];

				if ($total_amount >= $discount_limit) {

					$total_price = $total_price * ($discount_number / 100);

					if (strpos($discount_percent, '0')) {
						$discount_percent = substr($discount_percent, 0, -1);
						$discount_str = $discount_percent . '折';
					} else {
						$discount_str = $discount_percent . '折';
					}
				}
			}



		}
		
		
		$this->data['discount_type'] = $discount_type;
		$this->data['discount_str'] = $discount_str;		
		
		$this->data['discount_percent_code'] = (int)$discount_number;

		$this->data['total_price'] = $total_price;
		$this->data['ship'] = (int)$this->data['ship'];
		$this->data['total_price_ship'] = $total_price + (int)$this->data['ship'];
		


				
		
		$this->load->view('checkout', $this->data);
	}

	//綠界付款頁面
	public function pay()
	{


		$username = $this->input->post("username");
		$phone    = $this->input->post("phone");
		$email    = $this->input->post("email");
		$addr     = $this->input->post("addr");
		$coupon     = $this->input->post("coupon");
		$remark  = $this->input->post("remark");
		$payment  = $this->input->post("payment");
		$delivery     = $this->input->post("delivery");
		$discount_type_code     = $this->input->post("discount_type_code") ? $this->input->post("discount_type_code") : 0;
		$discount_percent_code     = $this->input->post("discount_percent_code") ? $this->input->post("discount_percent_code") : "";

		//防呆
		if ($username == "" ||$phone == ""|| $addr == ""|| $email == ""
		) {
			$this->js_output_and_back("請確認必填欄位是否填寫");
			exit();
		}

		if ($username == "") {
			$this->js_output_and_back("使用者名稱不可為空");
			exit();
		}

		$emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
		if ($email == "" || !preg_match($emailregex, $email)) {
			$this->js_output_and_back("請確認email格式");
			exit();
		}

		$mobileregex = "/^09[0-9]{8}$/";
		if ($phone == "" || !preg_match($mobileregex, $phone)) {
			$this->js_output_and_back("請確認手機");
			exit();
		}


		//抓出user的id
		$u_id =	$this->encryption->decrypt($this->session->uid);

		if($u_id){
			//取出未結購物車
			$cart = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->get($this->cart)->row_array();

			$cart_array = unserialize($cart["content"]);
		}else{
			//未登入
			$u_id =0 ;
			$cart_array = $this->session->userdata('temp_cart');
		}

		/*
			＊產生訂單編號
			*/
		$order_no = date("YmdHis") . rand(100, 999);

		//product抓出資料
		$total = 0;
		$product_data_array = array();

		foreach ($cart_array as $t) {
			
			$product_data = $this->db->select("T.*")
			->from($this->product . " T")			
			->where('T.is_delete = 0 AND T.id = ' . $t['p_id'])
			->get()->row_array();
			

			$product_data['quantity'] = $t['quantity'];

			$total += $product_data['sale_price'] * $product_data['quantity'];			

			array_push($product_data_array, $product_data);
		}

		
		$coupon_discount = 0;
		//優惠卷 
		if ($coupon != "") {

			$this->data['coupon'] = $this->db->where(array("code" => $coupon))->get($this->coupon)->row_array();
			$coupon_discount = $this->data['coupon']['discount'];
		} else {

			$this->data['coupon'] = "";
		}

		$total = $total - $coupon_discount;



		if($discount_type_code!=0){
			$total = $total *((int)$discount_percent_code/100);
		}
		//運費
		$ship = (int)$this->data['ship'];

		$total += $ship;

		$amount = $total;

		/*
			商品描述存成string，顯示在綠界結帳介面中
			*/
		$products_str = "";

		//產品資訊
		foreach ($product_data_array as $c) {
			if ($products_str != "") $products_str .= "#";
			$products_str .= $c['name'] . " × " . $c['quantity'] . " NT$" . $c['sale_price'] * $c['quantity'] . " ";
		}


		//總訂單
		$data = array(
			"order_no" =>	$order_no, //訂單編號
			"user_id" =>	$u_id,						
			"username" =>	$username,
			"phone"    =>	$phone,
			"addr"     =>	$addr,
			"email"    =>	$email,
			"payment"  =>	$payment, //結帳方式->credit
			"delivery"    =>	$delivery,
			"remark"    =>	$remark,
			"products" =>	serialize($product_data_array), //將cart轉成存入db的格式
			"amount"   =>	$amount,
			"products_str"   =>	$products_str,
			"fee"   =>	$ship,
			"coupon"   =>	$coupon,
			"coupon_discount"   =>	$coupon_discount,			
			"status"   =>	"pending", //第一次將訂單存入db中，狀態為處理中
			"discount_type"   =>	$discount_type_code,
			"discount_percent"   =>	$discount_percent_code,
		);
		// print_r($products_str);exit;

		//存入order db
		$res = $this->db->insert("order", $data);		

		if ($res) {

			//送到Pay model的pay function做處理
			$this->Pay_model->pay(
				$order_no, 											//訂單編號
				$product_data_array, 						//商品內容(array)
				$amount, 												//總金額
				$products_str, 											//訂單描述
				$payment,												//付款方式(optional) 預設為all
				base_url() . "cart/paysuccess",		//付款完成通知接收post
				base_url() . "cart/payresult",	//付款完成通知return_url
				"",											//cvsextend 超商選擇
				"",																//信用卡，定期定額, D/M/Y
				""																//信用卡，定期周期
			);

			// }

		} else {
			$this->js_output_and_back("下單發生錯誤，請聯繫管理員 ");
		}
	}

	//結帳成功畫面
	public function payment($order_no)
	{

		// $this->Login_model->is_login();
		// print_r($order_no);exit;


		$user_id = $this->encryption->decrypt($this->session->uid);

		if($user_id){
			// 將未結購物車 is_checkout 改為1
			$this->db->where(array("u_id" => $user_id))->update($this->cart, array("is_checkout" => 1));
		}else{
			//將session的temp_cart清除
			$this->session->unset_userdata('temp_cart');
		}


		//取出對應訂單
		$cart = $this->db->where(array("order_no" => $order_no))->get($this->order)->row_array();

		$cart['products'] = unserialize($cart['products']);

		
		$order = $this->db->where(array("order_no" => $order_no))->get($this->order)->row_array();
		
		if($order['status']=='paid' && $order['is_check'] == 0){

			$this->db->where(array("order_no" => $order_no))->update($this->order, array("is_check" => 1));
				
			if($order['coupon']!=""){
				//coupon加入coupon_use	
				$coupon_code = $order['coupon'];

				$coupon = $this->db->where(array("code" => $coupon_code))->get($this->coupon)->row_array();

				$coupon_use = array(
					'coupon_id' => $coupon['id'],
					'u_id'      => $user_id,
					'status'    => 'used'
				);

				$this->db->insert($this->coupon_use, $coupon_use);
			}

			//庫存數量減少
			foreach ($cart['products'] as $p) {
				$product = $this->db->where(array("id" => $p['id']))->get($this->product)->row_array();

				$num = $product['number'] - $p['quantity'];

				$this->db->where(array("id" => $p['id']))->update($this->product, array("number" => $num));
			}			

		}
			$this->data['discount_str'] ="";
		if($order['discount_type'] != 0) {
			if (strpos($order['discount_percent'], '0')) {
				$discount_percent = substr($order['discount_percent'], 0, -1);
					$this->data['discount_str'] = "打".$discount_percent . '折';
			} else {
				$this->data['discount_str'] = "打" . $order['discount_percent'] . '折';
			}
			
		}

		if ($order['discount_type'] == 1) {
			$this->data['discount_type'] = '滿額折扣';
		}elseif($order['discount_type'] == 2) {
			$this->data['discount_type'] = '滿件折扣';
		}
		
		$this->data['cart'] = $cart;
		


		$this->load->view('cart-history.php', $this->data);
	}

	//綠界 信用卡 or ATM 付完款後
	public function paysuccess()
	{
		$f = fopen("log.txt", "a+");
		fwrite($f, "Pay success\n" . date("Y-m-d H:i:s") . "\n" . json_encode($_POST) . "\n\n");
		fclose($f);

		$data = array(
			"TradeNo"              =>	$this->input->post("MerchantTradeNo"),
			"RtnCode"              =>	$this->input->post("RtnCode"),
			"RtnMsg"               =>	$this->input->post("RtnMsg"),
			"TradeAmt"             =>	$this->input->post("TradeAmt"),
			"TotalAmount"          =>	$this->input->post("TradeAmt"),
			"PaymentDate"          =>	$this->input->post("PaymentDate"),
			"PaymentType"          =>	$this->input->post("PaymentType"),
			"PaymentTypeChargeFee" =>	$this->input->post("PaymentTypeChargeFee"),
			"SimulatePaid"         =>	$this->input->post("SimulatePaid"),
			"CheckMacValue"        =>	$this->input->post("CheckMacValue"),
			"paymentinfo"          =>	serialize($_POST),
			"PeriodType"           =>	$this->input->post("PeriodType"),
			"Frequency"            =>	$this->input->post("Frequency"),
			"ExecTimes"            =>	$this->input->post("ExecTimes"),
			"Amount"               =>	$this->input->post("Amount"),
			"Gwsr"                 =>	$this->input->post("Gwsr"),
			"ProcessDate"          =>	$this->input->post("ProcessDate"),
			"AuthCode"             =>	$this->input->post("AuthCode"),
			"FirstAuthAmount"      =>	$this->input->post("FirstAuthAmount"),
			"TotalSuccessTimes"    =>	$this->input->post("TotalSuccessTimes")
		);

		$this->db->insert("transaction", $data);

		//付款交易成功後
		if ($this->input->post("RtnCode") == 1) {
			$this->db->where(array("order_no" => $this->input->post("MerchantTradeNo")))->update("order", array("status" => "paid"));


			//存入coupon_use
			
		}

		echo "1|OK";
	}

	//綠界 前端返回頁面
	public function payresult()
	{

		// print_r($_POST);exit;

		if ($_POST) {
			$trade_no = $this->input->post("MerchantTradeNo");
			$payment_type = $this->input->post("PaymentType");
			if ($payment_type == "CVS_CVS") {
				//超商繳費
				// $payment_no = $this->input->post("PaymentNo");
				// $expire_date = $this->input->post("ExpireDate");
				$payment_method = serialize($_POST);
				$this->db->where(array("order_no" => $trade_no))->update("order", array("payment_method" => $payment_method, "status" => "wait"));
			} else if (substr($payment_type, 0, 3) == "ATM") {
				//ATM繳費
				$bank_code = $this->input->post("BankCode");
				$v_account = $this->input->post("vAccount");
				$expire_date = $this->input->post("ExpireDate");
				$payment_method = serialize($_POST);
				$this->db->where(array("order_no" => $trade_no))->update("order", array("payment_method" => $payment_method, "bankcode" => $bank_code, "vaccount" => $v_account, "expired_date" => $expire_date, "status" => "wait"));
			}
			$data = $this->db->get_where("order", array("order_no" => $trade_no))->row_array();

			//恢復登入狀態
			if($data['user_id']!=0){
				$user_id = $data['user_id'];
				$user_data = $this->db->get_where("user", array("id" => $user_id))->row_array();


				$this->Login_model->login(array(
					"uid"      =>	$this->encryption->encrypt($user_id),
					"id" => 	$user_id,
					"uemail"    =>	$user_data['email'],
					"level"    =>	$this->encryption->encrypt($user_data['level'])
				));
			}

	

			header("Location: " . base_url() . "cart/payment/" . $trade_no);
			exit();
		} else {
			show_404();
		}
	}




}

