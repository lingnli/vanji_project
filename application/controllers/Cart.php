<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cart extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Login_model");
		$this->load->model("Member_model");
		$this->load->model("Pay_model");
		$this->load->model("EC_logistic");
		if ($this->data['discount_type'] == 3) {
			$this->all_discount = true;
		} else {
			$this->all_discount = false;
		}
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

		//判斷庫存是否足夠
		$check_quantity = $this->db->get_where('product', array("id" => $p_id))->row_array();
		if($check_quantity['number']< $quantity){
			$this->js_output_and_back("數量不足");
			exit();
		}

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


						$check_quantity = $this->db->get_where('product', array("id" => $p_id))->row_array();
						if ($check_quantity['number'] <$temp_cart[$i]['quantity']) {
							$this->js_output_and_back("數量不足");
							exit();
						}
	
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

								$check_quantity = $this->db->get_where('product', array("id" => $p_id))->row_array();
								if ($check_quantity['number'] < $content[$i]['quantity']) {
									$this->js_output_and_back("數量不足");
									exit();
								}

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

		//選超取後回傳到結帳頁面，接收超商的資訊
		if ($_POST) {
			$MerchantTradeNo  = $this->input->post("MerchantTradeNo");
			$LogisticsSubType = $this->input->post("LogisticsSubType");
			$CVSStoreID       = $this->input->post("CVSStoreID");
			$CVSStoreName     = $this->input->post("CVSStoreName");
			$CVSAddress       = $this->input->post("CVSAddress");
			$CVSTelephone     = $this->input->post("CVSTelephone");
			$CVSOutSide       = $this->input->post("CVSOutSide");
			$ExtraData        = $this->input->post("ExtraData");
			$this->data['shop'] = array(
				"MerchantTradeNo"  =>	$MerchantTradeNo,
				"LogisticsSubType" =>	$LogisticsSubType,
				"CVSStoreID"       =>	$CVSStoreID,
				"CVSStoreName"     =>	$CVSStoreName,
				"CVSAddress"       =>	$CVSAddress,
				"CVSTelephone"     =>	$CVSTelephone,
				"CVSOutSide"       =>	$CVSOutSide,
				"ExtraData"        =>	$ExtraData
			);
			// print_r($this->data['shop']);exit;
		} else {
			$this->data['shop'] = array();
		}


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
				
				if($product_item['number']==0){
					$product_item['check_number'] = 'zero';	
				}else if($product_item['number'] >= $c['quantity']){
					$product_item['number'] = $c['quantity'];
					$product_item['check_number'] = 'true';	
				} else if ($product_item['number'] < $c['quantity']) {
					$product_item['check_number'] = 'false';	
				}
				if($this->all_discount){
					$product_item['sale_price'] = $product_item['sale_price']* ($this->data['all_discount'] / 100);
				}
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
					//判斷庫存是否足夠
					$check_quantity = $this->db->get_where('product', array("id" => $p_id))->row_array();

					if ($check_quantity['number'] < $cart_array[$i]['quantity']) {

						$this->output(FALSE, '數量不足');
						exit();
					}
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
				if ($this->all_discount) {
					$product_spec_price['sale_price'] = $product_spec_price['sale_price'] * ($this->data['all_discount'] / 100);
				}
				$total_price += $product_spec_price['sale_price'] * $p['quantity'];
			}
			$res = $this->db->where(array("u_id" => $u_id, "is_checkout" => 0))->update($this->cart, $data);


			//該商品總金額		
			$product_choose = $this->db->where(array("id" => $p_id))->get($this->product)->row_array();
			$product_price = $product_choose['sale_price'] * $num;
			if ($this->all_discount) {
				$product_price = $product_choose['sale_price'] * ($this->data['all_discount'] / 100) * $num;
			} else {
				$product_price = $product_choose['sale_price'] * $num;
			}

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

					//判斷庫存是否足夠
					$check_quantity = $this->db->get_where('product', array("id" => $p_id))->row_array();

					if ($check_quantity['number'] < $cart_array[$i]['quantity']) {
						
						$this->output(FALSE, '數量不足');
						exit();
					}
				}
				$i++;
			}

			//總金額 數量
			$total_price = 0;

			foreach ($cart_array as $p) {
				$p_item_id = $p['p_id'];
				$product_spec_price = $this->db->where(array("id" => $p_item_id))->get($this->product)->row_array();
				if ($this->all_discount) {
					$product_spec_price['sale_price'] = $product_spec_price['sale_price'] * ($this->data['all_discount'] / 100);
				}
				$total_price += $product_spec_price['sale_price'] * $p['quantity'];
			}

			$_SESSION['temp_cart'] = $cart_array;


			//該商品總金額		
			$product_choose = $this->db->where(array("id" => $p_id))->get($this->product)->row_array();

			if ($this->all_discount) {				
				$product_price = $product_choose['sale_price']*($this->data['all_discount'] / 100) * $num;
			}else{
				$product_price = $product_choose['sale_price'] * $num;
			}

			

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
		
		// print_r($coupon_check);exit;
		if (isset($coupon_check['id'])) {
			if($coupon_check['use_limit']== -1 || $coupon_check['use_limit'] > $coupon_check['used']){
				$this->output(TRUE, '成功', array('discount' => $coupon_check['discount']));	
			}else{
				$this->output(FALSE, '失敗');
			}
			
		} else {
			$this->output(FALSE, '失敗');
		}
	}

	//選擇超商
	public function cvschoose($con_choose=false)
	{
		// $con_choose  =	$this->input->post("con_choose") ? $this->input->post("con_choose") : "";

		// print_r($con_choose);exit;
		if ($con_choose == false) {
			$this->js_output_and_back("請選擇取貨超商");
			exit();
		}

		

		$redirect_url = base_url()."cart/check";

		$this->EC_logistic->choose_store($con_choose, 'N', $redirect_url);
	}

	//結帳頁面
	public function check() 
	{


			if(array_key_exists("MerchantTradeNo", $_POST)){
				
				$MerchantTradeNo  = $_POST["MerchantTradeNo"];
				$LogisticsSubType = $_POST["LogisticsSubType"];
				$CVSStoreID       = $_POST["CVSStoreID"];
				$CVSStoreName     = $_POST["CVSStoreName"];
				$CVSAddress       = $_POST["CVSAddress"];
				$CVSTelephone     = $_POST["CVSTelephone"];
				$CVSOutSide       = $_POST["CVSOutSide"];
				$ExtraData        = $_POST["ExtraData"];
				$shop = array(
					"MerchantTradeNo"  =>	$MerchantTradeNo,
					"LogisticsSubType" =>	$LogisticsSubType,
					"CVSStoreID"       =>	$CVSStoreID,
					"CVSStoreName"     =>	$CVSStoreName,
					"CVSAddress"       =>	$CVSAddress,
					"CVSTelephone"     =>	$CVSTelephone,
					"CVSOutSide"       =>	$CVSOutSide,
					"ExtraData"        =>	$ExtraData
				);
				if ($shop['LogisticsSubType'] == 'FAMIC2C') {
					$shop['store'] = '全家店到店';
				} else if ($shop['LogisticsSubType'] == 'UNIMARTC2C') {
					$shop['store'] = '7-ELEVEN 超商交貨便';
				} else if ($shop['LogisticsSubType'] == 'HILIFEC2C') {
					$shop['store'] = '萊爾富店到店';
				} else if ($shop['LogisticsSubType'] == 'OKMARTC2C') {
					$shop['store'] = 'OK店到店';
				}

				$this->data['shop'] = $shop;

				$coupon  = $this->session->userdata('coupon');
				$area  = $this->session->userdata('area');
				$delivery  = $this->session->userdata('delivery');
				$payment  = $this->session->userdata('payment');				
			}else{
				$coupon            =	$this->input->post("coupon");
				$area            =	$this->input->post("area") ? $this->input->post("area") : "";
				$delivery            =	$this->input->post("delivery") ? $this->input->post("delivery") : "";
				$payment            =	$this->input->post("payment") ? $this->input->post("payment") : "";

				if ($area == "") {
					$this->js_output_and_back("請選擇運送地區");
					exit();
				}
				if ($payment == "") {
					$this->js_output_and_back("請選擇付款方式");
					exit();
				}
				if ($delivery == "") {
					$this->js_output_and_back("請選擇運送方式");
					exit();
				}
				$this->session->set_userdata('coupon', $coupon);
				$this->session->set_userdata('area', $area);
				$this->session->set_userdata('delivery', $delivery);
				$this->session->set_userdata('payment', $payment);

				$this->data['shop'] = array();
			}








		//選超取後回傳到結帳頁面，接收超商的資訊
		// if ($this->input->post("MerchantTradeNo")) {

		// 	$MerchantTradeNo  = $this->input->post("MerchantTradeNo");
		// 	$LogisticsSubType = $this->input->post("LogisticsSubType");
		// 	$CVSStoreID       = $this->input->post("CVSStoreID");
		// 	$CVSStoreName     = $this->input->post("CVSStoreName");
		// 	$CVSAddress       = $this->input->post("CVSAddress");
		// 	$CVSTelephone     = $this->input->post("CVSTelephone");
		// 	$CVSOutSide       = $this->input->post("CVSOutSide");
		// 	$ExtraData        = $this->input->post("ExtraData");
		// 	$shop= array(
		// 		"MerchantTradeNo"  =>	$MerchantTradeNo,
		// 		"LogisticsSubType" =>	$LogisticsSubType,
		// 		"CVSStoreID"       =>	$CVSStoreID,
		// 		"CVSStoreName"     =>	$CVSStoreName,
		// 		"CVSAddress"       =>	$CVSAddress,
		// 		"CVSTelephone"     =>	$CVSTelephone,
		// 		"CVSOutSide"       =>	$CVSOutSide,
		// 		"ExtraData"        =>	$ExtraData
		// 	);
		// 	if($shop['LogisticsSubType']== 'FAMIC2C'){
		// 		$shop['store'] = '全家店到店';
		// 	} else if ($shop['LogisticsSubType'] == 'UNIMARTC2C') {
		// 		$shop['store'] = '7-ELEVEN 超商交貨便';
		// 	} else if ($shop['LogisticsSubType'] == 'HILIFEC2C') {
		// 		$shop['store'] = '萊爾富店到店';
		// 	} else if ($shop['LogisticsSubType'] == 'OKMARTC2C') {
		// 		$shop['store'] = 'OK店到店';
		// 	}

		// 	$this->data['shop'] = $shop;
		// 	print_r($this->data['shop']);
		// 	exit;
		// 	$coupon  = $this->session->userdata('coupon');
		// 	$area  = $this->session->userdata('area');
		// 	$delivery  = $this->session->userdata('delivery');
		// 	$payment  = $this->session->userdata('payment');

		// } else {
		// 	$coupon            =	$this->input->post("coupon");
		// 	$area            =	$this->input->post("area") ? $this->input->post("area") : "";
		// 	$delivery            =	$this->input->post("delivery") ? $this->input->post("delivery") : "";
		// 	$payment            =	$this->input->post("payment") ? $this->input->post("payment") : "";

		// 	if ($area == "") {
		// 		$this->js_output_and_back("請選擇運送地區");
		// 		exit();
		// 	}
		// 	if ($payment == "") {
		// 		$this->js_output_and_back("請選擇付款方式");
		// 		exit();
		// 	}
		// 	if ($delivery == "") {
		// 		$this->js_output_and_back("請選擇運送方式");
		// 		exit();
		// 	}
		// 	$this->session->set_userdata('coupon', $coupon);
		// 	$this->session->set_userdata('area', $area);
		// 	$this->session->set_userdata('delivery', $delivery);
		// 	$this->session->set_userdata('payment', $payment);

		// 	$this->data['shop'] = array();
		// }


		//判斷是否登入
		$user_id = $this->encryption->decrypt($this->session->uid);

		//判斷此使用者是否有結帳完成訂單
		$order_check = $this->db->where(array("user_id" => $user_id,'is_delete'=>0,'status'=>'paid'))->get($this->order)->row_array();

		//抓出user的id
		if ($user_id) {
			$this->data['user'] = $this->db->where(array("id" => $user_id))->get($this->user)->row_array();
			$cart = $this->db->where(array("u_id" => $user_id, "is_checkout" => 0))->get($this->cart)->row_array();

			$cart_content = unserialize($cart['content']);

		}else{
			$cart_content = $this->session->userdata('temp_cart');
		}
		


		if ($cart_content == array() || $cart_content == ' ') {
			$this->js_output_and_redirect("請先選擇商品後進行結帳",base_url().'cart');

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
				if ($this->all_discount) {
					$product_item['sale_price'] = $product_item['sale_price'] * ($this->data['all_discount'] / 100);
				}
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
		$this->data['area'] = $area;
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
		
		if($user_id){
				$ship = 0;
		}else{
			if ($area != 'tw') {
				$ship = 200;
			} else {
				$ship = (int)$this->data['ship'];
			}
		}


		$this->data['discount_type'] = $discount_type;
		$this->data['discount_str'] = $discount_str;		
		
		$this->data['discount_percent_code'] = (int)$discount_number;

		$this->data['total_price'] = $total_price;

			$this->data['ship'] = $ship;

		
		$this->data['total_price_ship'] = $total_price + $ship;
		
		

				
		
		$this->load->view('checkout', $this->data);
	}

	//綠界付款頁面
	public function pay()
	{
		// print_r($_POST);exit;
		$user_id = $this->encryption->decrypt($this->session->uid);
		$username = $this->input->post("username");
		$phone    = $this->input->post("phone");
		$email    = $this->input->post("email");
		$addr     =
		$this->input->post("addr") ? $this->input->post("addr") : "";
		$coupon     = $this->input->post("coupon");
		$remark  = $this->input->post("remark");
		$payment  = $this->input->post("payment");
		$delivery     = $this->input->post("delivery");
		$area     = $this->input->post("area");
		$discount_type_code     = $this->input->post("discount_type_code") ? $this->input->post("discount_type_code") : 0;
		$discount_percent_code     = $this->input->post("discount_percent_code") ? $this->input->post("discount_percent_code") : "";
		$shop     = $this->input->post("shop") ? $this->input->post("shop") : "";
		// print_r($_POST);exit;

		if ($delivery == 'convenient') {
			if ($shop == "") {
				$this->js_output_and_back("請選擇超商");
				exit();
			}
		}

		//防呆
		if($delivery=='home'){
			if ($username == "" ||$phone == ""|| $addr == ""|| $email == ""
			) {
				$this->js_output_and_back("請確認必填欄位是否填寫");
				exit();
			}
		}else{
			if (
				$username == "" || $phone == ""  || $email == ""
			) {
				$this->js_output_and_back("請確認必填欄位是否填寫");
				exit();
			}
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

			if ($this->all_discount) {
				$product_data['sale_price'] = $product_data['sale_price'] * ($this->data['all_discount'] / 100);
			}
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
		// $ship = (int)$this->data['ship'];
		if($u_id){
			$ship =0;
		}else{
			if ($area != 'tw') {
				$ship = 200;
			} else {
				$ship = (int)$this->data['ship'];;
			}
		}
		

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

		if($delivery=='home'){
			$delivery_stauts = 0;
		} else if ($delivery == 'convenient') {
			$delivery_stauts = 1;
		}

		//總訂單
		$data = array(
			"order_no" 					=>	$order_no, //訂單編號
			"user_id"						=>	$u_id,						
			"username" 					=>	$username,
			"phone"  					  =>	$phone,
			"addr"   					  =>	$addr,
			"email" 				    =>	$email,
			"payment" 				  =>	$payment, //結帳方式->credit
			"delivery"  			  =>	$delivery,
			"remark"  				  =>	$remark,
			"products"				  =>	serialize($product_data_array), //將cart轉成存入db的格式
			"amount"  				  =>	$amount,
			"products_str"      =>	$products_str,
			"fee" 							=>	$ship,
			"coupon" 					  =>	$coupon,
			"area" 					  	=>	$area,
			"coupon_discount"   =>	$coupon_discount,			
			"status"  				  =>	"pending", //第一次將訂單存入db中，狀態為處理中
			"discount_type" 	  =>	$discount_type_code,
			"discount_percent"  =>	$discount_percent_code,
			'delivery_status'		=>	$delivery_stauts,
			'convenient_data'		=>	serialize($shop)
		);
		// print_r($payment);exit;
		//存入order db
		$res = $this->db->insert("order", $data);		

		if ($res) {

			$this->Pay_model->pay(
				$order_no, 												//訂單編號
				$product_data_array, 							//商品內容(array)
				$amount, 													//總金額
				$products_str, 										//訂單描述
				$payment,													//付款方式(optional) 預設為all
				base_url() . "cart/paysuccess",		//付款完成通知接收post
				base_url() . "cart/payresult",		//付款完成通知return_url
				"",																//cvsextend 超商選擇
				"",																//信用卡，定期定額, D/M/Y
				"",																//信用卡，定期周期
				""																//信用卡分期
			);


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
		
		if($order['is_check'] == 0){

			$this->db->where(array("order_no" => $order_no))->update($this->order, array("is_check" => 1));
			//發信寄送訂單編號
			$this->Member_model->send_mail($cart['email'], "感謝您的購買，您的訂單編號是: " . $order_no . "<br> 可至官網的「訂單查詢」頁面，輸入訂單編號即可查看訂單進度與資訊。", "訂單成立通知");

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
		$shop= unserialize($cart['convenient_data']);
		if($shop!=""){
			if ($shop['LogisticsSubType'] == 'FAMIC2C') {
				$store_type = '全家店到店';
			} else if (
				$shop['LogisticsSubType'] == 'UNIMARTC2C'
			) {
				$store_type = '7-ELEVEN 超商交貨便';
			} else if ($shop['LogisticsSubType'] == 'HILIFEC2C') {
				$store_type = '萊爾富店到店';
			} else if ($shop['LogisticsSubType'] == 'OKMARTC2C') {
				$store_type = 'OK店到店';
			}

			$this->data['store_type'] = $store_type;
			$this->data['store'] = $shop['CVSStoreName'];
		}

		// print_r($this->data['cart']);
		// exit;

		$this->load->view('cart-history.php', $this->data);
	}

	//綠界 信用卡ATM 付完款後
	public function paysuccess()
	{
		// $f = fopen("log.txt", "a+");
		// fwrite($f, "Pay success\n" . date("Y-m-d H:i:s") . "\n" . json_encode($_POST) . "\n\n");
		// fclose($f);

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
			
		}

		echo "1|OK";
	}

	//綠界 前端返回頁面
	public function payresult()
	{		

		if ($_POST) {
			$trade_no = $this->input->post("MerchantTradeNo");

			// 取得寄件人資訊
			$sender = array('username'=> '何逸中','phone'=> '0976105940');
			$order = $this->db->get_where("order", array("order_no" => $trade_no))->row_array();

			if($order['delivery_status']==1){
				$this->load->model("EC_logistic");
				//超商取貨付款
				$Result = $this->EC_logistic->store_pay(
					$trade_no, 							//訂單編號
					$sender,							//寄件人資訊:站台管理員id
					$order, 								//訂單資訊 即存進db的資料
					'N',								//是否代收
					base_url() . "cart/store_result",			//物流狀態都會透過此 URL 通知。	
					base_url() . "cart/store_reply",			//當 user 選擇取貨門市有問題時，會透過此 URL 通知特店，請特店通知 User 重新		選擇門市。
					'CVS',					//選擇超商取貨
					unserialize($order['convenient_data'])['LogisticsSubType']					//選擇超商取貨
				);
				$Result = $_POST;

				if ($Result['ResCode'] == 1) {

					$data = array(
						"trade_no"    =>  $Result['MerchantTradeNo'],
						"data"        =>  serialize($Result),
						"status"      =>  $Result['RtnMsg'],
						"action"      =>  "create"
					);
					$this->db->insert("logistics", $data);
					
				} else {
					$data = array(
						"trade_no"    =>  $Result['MerchantTradeNo'],
						"data"        =>  serialize($Result),
						"status"      =>  $Result['RtnMsg'],
						"action"      =>  "err"
					);
					$this->db->insert("logistics", $data);

				}

			}

			if($order['payment'] == 'atm'){
				$atm_data = [
					'BankCode' 	 => $_POST['BankCode'],
					'vAccount' 	 => $_POST['vAccount'],
					'ExpireDate' => $_POST['ExpireDate'],
				];
				
				$this->db->where(array("order_no" => $trade_no))->update('order',$atm_data);
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

	/*
	超商：物流狀態通知
	*/
	public function store_result()
	{

		// print_r($_POST);
		// exit;


		$data = array(
			"trade_no"    =>  $_POST['MerchantTradeNo'],
			"data"        =>  serialize($_POST),
			"status"      =>  $_POST['RtnMsg'],
			"action"      =>  "receive"
		);
		$res = $this->db->insert("logistics", $data);
		if ($res) {
			echo "1|OK";
		} else {
			echo "0|Error";
		}
	}

	/*
	超商：取貨商店有問題時回傳
	*/
	public function store_reply()
	{
		$data = array(
			"trade_no"    =>  $_POST['AllPayLogisticsID'], //綠界科技的物流交易編號
			"data"        =>  serialize($_POST),
			"status"      =>  $_POST['Status'],
			"action"      =>  "store_err"
		);
		$res = $this->db->insert("logistics", $data);
		if ($res) {
			echo "1|OK";
		} else {
			echo "0|Error";
		}
	}






	//訂單搜尋
	public function search()
	{
		if($_POST){
			$order_no = $this->input->post("order_no");
			if($order_no == ""){
				$this->js_output_and_back("訂單編號不可為空值");
				exit();
			}

			header("Location: " . base_url() . "cart/payment/" . $order_no);
			exit();
		}
		$this->load->view('cart-search.php', $this->data);
	}



	//綠界 前端返回頁面
	public function test_log()
	{

			$trade_no = $this->input->post("MerchantTradeNo");
			$payment_type = $this->input->post("PaymentType");

			// 取得寄件人資訊
			$sender = array('username'=> '何逸中','phone'=> '0976105940');
			$order = $this->db->get_where("order", array("order_no" => '20210511113422657'))->row_array();
		// print_r(unserialize($order['convenient_data']));exit;
		// print_r($order);exit;
			if($order['delivery_status']==1){
				// $this->load->model("EC_logistic");
				//超商取貨付款
				$Result = $this->EC_logistic->store_pay(
				'20210511113422657', 							//訂單編號
					$sender,							//寄件人資訊:站台管理員id
					$order, 								//訂單資訊 即存進db的資料
					'N',								//是否代收
					base_url() . "cart/store_result",			//物流狀態都會透過此 URL 通知。	
					base_url() . "cart/store_reply",			//當 user 選擇取貨門市有問題時，會透過此 URL 通知特店，請特店通知 User 重新		選擇門市。
					'CVS',					//選擇超商取貨
				unserialize($order['convenient_data'])['LogisticsSubType']					//選擇超商取貨

				);
				// print_r($Result);exit;
				// $Result = $_POST;

				if ($Result['ResCode'] == 1) {

					$data = array(
						"trade_no"    =>  $Result['MerchantTradeNo'],
						"data"        =>  serialize($Result),
						"status"      =>  $Result['RtnMsg'],
						"action"      =>  "create"
					);
					$this->db->insert("logistics", $data);
					
				} else {
					$data = array(
						"trade_no"    =>  $Result['MerchantTradeNo'],
						"data"        =>  serialize($Result),
						"status"      =>  $Result['RtnMsg'],
						"action"      =>  "err"
					);
				$this->db->insert("logistics", $data);

			}



			$data = $this->db->get_where("order", array("order_no" => $trade_no))->row_array();
			exit();
		} else {
			show_404();
		}
	}


}