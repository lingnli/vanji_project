<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Login_model");
		$this->load->model("Member_model");
		$this->Login_model->is_login();
		$this->page_count = 5;
		
	}


	public function home()
	{
		$this->Login_model->is_login();
		$user_id = $this->session->id;

		$this->data['today'] = date('Y-m-d');
		//個人資料
		$this->data['user'] = $this->db->where(array("id" => $user_id))->get($this->user)->row_array();

		//我的訂單
		$this->data['order'] = $this->db->where(array("user_id" => $user_id))->get($this->order)->result_array();

		// print_r($this->data);exit;
		$this->load->view('my-account', $this->data);
	}

	//資料儲存
	public function save()
	{
		$user_id = $this->session->id;
		$password = $this->input->post('password');
		$password_confirm = $this->input->post('password_confirm');

		if ($password == "" || $password_confirm == "") {

			echo "<script> alert('若欲修改會員資料請輸入密碼'); history.back(); </script>";
			return;
		}

		if ($password != $password_confirm) {
			echo "<script> alert('兩次輸入密碼不同'); history.back(); </script>";
			return;
		}

		if (!$this->Member_model->pwd_check(md5($password), $user_id)) {
			echo "<script> alert('密碼錯誤'); history.back(); </script>";
			return;
		}

		//接收form傳來資料
		$text_params = ['email', 'name', 'phone', 'birthday'];
		foreach ($text_params as $t) {
			$data[$t] = $this->input->post($t)? $this->input->post($t):"";
		}

		if($data['email']!=""){
			$emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
			if ($data['email'] == "" || !preg_match($emailregex, $data['email'])) {
				$this->js_output_and_back("請確認email格式");
				exit();
			}
		}
		if ($data['phone'] != "") {
			$mobileregex = "/^09[0-9]{8}$/";
			if ($data['phone'] == "" || !preg_match($mobileregex, $data['phone'])) {
				$this->js_output_and_back("請確認手機");
				exit();
			}
		}

		// print_r($data);exit;
		$res = $this->db->where(array("id" => $user_id))->update($this->user, $data);



		$this->js_output_and_redirect("編輯成功", base_url() . "member/home");
	}

	//我的最愛
	public function favorite()
	{

		$user_id = $this->session->id;
		$product_favorite = $this->db->where(array("user_id" => $user_id))->get($this->user_product_favorite)->result_array();

		//產品id array
		$pro_arr = array();
		foreach ($product_favorite as $p) {
			array_push($pro_arr, $p['p_id']);
		}

		$product_data_array = array();


		foreach ($pro_arr as $t) {

			$product_data = $this->db->select("P.*")
			->from($this->product . " P")			
			->order_by("P.id")
			->where('P.is_delete = 0 AND P.id = ' . $t)
				->get()->row_array();


			array_push($product_data_array, $product_data);
		}


		$this->data['product'] = $product_data_array;



		$this->load->view('wishlist', $this->data);
	}

	//加入最愛
	public function add_favorite()
	{

		$p_id = $this->input->post("id");


		//防止不同類別有相同課程
		$this->db->select("*");
		$this->db->from("user_product_favorite");
		$this->db->where("user_id='{$this->session->id}' AND p_id = $p_id");
		$r = $this->db->get()->row();
		if ($r == null) {
			$data = array(
				'user_id' => $this->session->id,
				'p_id' => $p_id
			);
			$res =  $this->db->insert($this->user_product_favorite, $data);

			$this->output(TRUE, '成功加入喜愛清單');
		} else {
			$this->output(FALSE, "已加入過喜愛清單");
		}
	}

	//刪除最愛
	public function del_favorite($p_id)
	{

		
		//從session中取得u_id
		$u_id = $this->encryption->decrypt($this->session->uid);
		// print_r($u_id);
		// exit;
		$this->db->delete($this->user_product_favorite, array("p_id" => $p_id, "user_id" => $u_id));


		$this->js_output_and_redirect("已移除", base_url() . "member/favorite");
	}



	public function orderdetail($order_no) // 訂單詳情
	{
		$user_id = $this->session->id;
		$this->data['user'] = $this->db->where(array("id" => $user_id))->get($this->user)->row_array();


		$data = $this->db->get_where("order", array("order_no" => $order_no))->row_array();
		$data["products"] = unserialize($data["products"]);

		$product_num = 0;

		$i = 0;
		foreach ($data['products'] as $d) {
			$p_id = $d['p_id'];
			$item = $this->db->get_where("product", array("id" => $p_id))->row_array();
			$item['images'] = unserialize($item["images"]);

			$product_num += $d['quantity'];

			if ($item['images'] != array()) {
				$data['products'][$i]['cover'] = $item['images'][0];
			} else {
				$data['products'][$i]['cover'] = array();
			}
			$data['products'][$i]['sub_title'] = $item['sub_title'];
			$i++;
		}
		$data['product_num'] = $product_num;

		$this->data['data'] = $data;


				// print_r($data);exit;

		$this->load->view('orderDetail', $this->data);
	}








}
