<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('memory_limit', '1600M');
class Home extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Member_model");
	}

	public function index(){

		$this->flow_record("home");

		//輪播圖
		$this->data['carousel'] = $this->db->where(array("is_delete" => 0))->get($this->carousel)->result_array();

		//主打商品
		$this->data['top'] = $this->db->limit(4)->where(array("is_delete" => 0,'is_index'=>2))->get($this->product)->result_array();
		
		//中間
		$this->data['banner'] = $this->db->where(array("is_delete" => 0))->get($this->banner)->result_array();


		//主打商品
		$this->data['second'] = $this->db->limit(8)->where(array("is_delete" => 0, 'is_index' => 1))->get($this->product)->result_array();

		//新聞
		$this->data['news'] = $this->db->limit(2)->where(array("is_delete" => 0))->get($this->news)->result_array();

		$this->load->view('index', $this->data);
	}

	public function about()
	{
		$this->data['top'] = $this->db->where(array("is_delete" => 0, 'id' => 1))->get($this->design)->row_array();

		$this->data['design'] = $this->db->where(array("is_delete" => 0, 'id >' => 1))->get($this->design)->result_array();

		// print_r($this->data['design']);exit;
		$this->load->view('about', $this->data);
	}

	public function faq()
	{

		
		$this->data['faq1'] = $this->db->where(array("is_delete" => 0,'classify'=>1))->get($this->faq)->result_array();

		$this->data['faq2'] = $this->db->where(array("is_delete" => 0, 'classify' => 2))->get($this->faq)->result_array();

		$this->data['faq3'] = $this->db->where(array("is_delete" => 0, 'classify' => 3))->get($this->faq)->result_array();

		$this->data['faq4'] = $this->db->where(array("is_delete" => 0, 'classify' => 4))->get($this->faq)->result_array();

		// print_r($this->data);exit;
		$this->load->view('faq', $this->data);
	}

	public function contact()
	{


		$this->load->view('contact', $this->data);
	}

	//使用者登入
	public function login_register()
	{
		if ($_POST) {
			$this->load->model('Member_model');
			$this->load->model('Login_model');
			$this->flow_record("login");


			$email    = $this->input->post("email");
			$password = $this->input->post("password");


			if ($email == "" || $password == "") {

				$this->js_output_and_back("欄位不可為空");
			} else {
				if ($this->Member_model->pwd_confirm(md5($password), $email)) {
					$r = $this->Member_model->get_data_by_email($email);
					$member_id = $r->id;

					if ($r->status != "normal") {
						$this->js_output_and_back("您的帳號尚未驗證或發生問題，請聯繫管理員");
					}

					$this->Login_model->login(array(
						"uid"      =>    $this->encryption->encrypt($member_id),
						"id" =>     $r->id,
						"uemail"    =>    $r->email
					));




					//購物車處理
					//判斷session是否存在購物車
					$temp_cart = $this->session->userdata('temp_cart');

					if ($temp_cart) {
						//若存在temp購物車

						//比對cart table是否存在cart清單
						$check_cart = $this->db->where(array("u_id" => $member_id, "is_checkout" => 0))->get($this->cart)->num_rows();

						// print_r($check_cart);1=>有購物車 0=>無購物車

						//不存在cart->建立
						if ($check_cart == 0) {

							//將temp購物車資料丟到cart
							$cart_array = $temp_cart;

							$data = array(
								"u_id" =>    $member_id,
								//存進去db的array需轉換
								"content" =>    serialize($cart_array)
							);

							$res =  $this->db->insert($this->cart, $data);
							if ($res) {

								$this->js_output_and_redirect("登入成功",   base_url() . "member/home");
							} else {

								$this->js_output_and_redirect("已登入，但購物車發生問題",   base_url() . "member/home");
							}


							//存在cart->直接存入
						} else {

							//取出此cart_id
							$cart = $this->db->where(array("u_id" => $member_id, "is_checkout" => 0))->get($this->cart)->row_array();

							//將目前temp_cart中東西存入cart
							$data = array("content" =>    serialize($temp_cart));
							$res = $this->db->where(array("id" => $cart['id']))->update($this->cart, $data);

							// print_r($res);exit;
							$this->js_output_and_redirect("登入成功",   base_url() . "member/home");
						}
					} else {
						//不存在temp購物車->直接登入
						$this->js_output_and_redirect("登入成功",   base_url() . "member/home");
					}
				} else {

					$this->js_output_and_redirect("帳號/密碼錯誤", base_url() . "home/login_register");
				}
			}
		} else {
			$this->load->view("login_register.php", $this->data);
		}
	}

	//註冊
	public function register()
	{
		$this->load->model('Member_model');
		$this->load->model('Login_model');
		$this->flow_record("register");

		if ($_POST) {
			
			$email            = $this->input->post("email");			
			$password         = $this->input->post("password");
			$password2        = $this->input->post("password_confirm");
			
			//防呆區			
			if ($password2 != $password)
				$this->js_output_and_back("兩次輸入密碼不相同");

			if (!$this->Member_model->user_exsit_check($email)) {

				//user data save to db
				$res = $this->Login_model->register(array(					
					"email"       =>    $email,					
					"password"    =>    $this->encryption->encrypt(md5($password)),
					"status"      =>    "normal"
				));

				if ($res) {

					$this->js_output_and_redirect("註冊成功，登入後方可使用會員功能", base_url() . 'home/login_register');
				} else {
					$this->js_output_and_back("註冊發生問題，請聯繫管理員");
				}
			} else {
				$this->js_output_and_back("此帳號已被註冊");
			}
		}
	}

	//登出
	public function logout()
	{
		$this->session->sess_destroy();

		header("Location: " . base_url() . "home/login_register");
	}

	//忘記密碼頁面
	public function forget()
	{
		$this->load->view("forget", $this->data);
	}

	//忘記密碼 
	public function forget_pwd()
	{



		if ($this->input->post("email") && $this->Member_model->account_exist($this->input->post("email"))) {
			$this->Member_model->send_changed_pwd($this->input->post("email"));
			$this->js_output_and_redirect("已發送新密碼至您的信箱，請使用新密碼登入", base_url() . "home/login_register");
		} else {
			$this->js_output_and_back("查無此用戶");
		}
	}

	//訂閱電子報
	//電子報訂閱
	public function email()
	{
		$email  = $this->input->post("email");

		$emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
		if ($email == "" || !preg_match($emailregex, $email)) {
			$this->js_output_and_back("請確認email格式");
			exit();
		}

		//判斷email是否訂閱
		$email_check = $this->db->where(array("is_delete" => 0, "email" => $email))->get($this->email)->row_array();

		if(!$email_check){
			$data = array(
				"email"    =>	$email,
			);

			$res = $this->db->insert($this->email, $data);
			if($res){
				$this->js_output_and_redirect("訂閱成功！", base_url());
			}else{

				$this->js_output_and_back("訂閱發生問題，請聯絡客服");
			}
			
		}else{
			$this->js_output_and_back("此email已訂閱電子報");
		}
		
	}

	public function contact_post()
	{

		if ($_POST) {

			if ($this->input->post("g-recaptcha-response") && $this->input->post("g-recaptcha-response") != "") {

				// 建立CURL連線
				$ch = curl_init();

				// 設定擷取的URL網址
				curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
				curl_setopt($ch, CURLOPT_HEADER, false);
				//將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				//設定CURLOPT_POST 為 1或true，表示要用POST方式傳遞
				curl_setopt($ch, CURLOPT_POST, 1);
				//CURLOPT_POSTFIELDS 後面則是要傳接的POST資料。
				curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					"secret"	=>	"6Ld0nzIaAAAAAFPJtRBNpHQUKSDPBjnOzB4lQehi",
					"response"	=>	$this->input->post("g-recaptcha-response"),
					"remoteip"	=>	$this->get_client_ip()
				));

				// 執行
				$result = curl_exec($ch);

				// 關閉CURL連線
				curl_close($ch);

				$r = json_decode($result, true);

				if (!$r['success']) {

					$this->js_output_and_back("Validate Error");
					return;
				}
			} else {
				$this->js_output_and_back("Validate Error");
				return;
			}

			$text_params = ['name', 'email', 'content','phone','title'];

			foreach ($text_params as $t) {
				$data[$t] = $this->input->post($t);
			}

			if ($data['name'] == "") {
				$this->js_output_and_back("使用者名稱不可為空");
				exit();
			}

			$emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
			if ($data['email'] == "" || !preg_match($emailregex, $data['email'])) {
				$this->js_output_and_back("請確認email格式");
				exit();
			}

			$mobileregex = "/^09[0-9]{8}$/"; 
			if ($data['phone'] == "" || !preg_match($mobileregex, $data['phone'])) {
				$this->js_output_and_back("請確認手機");
				exit();
			}
			
			if ($data['title'] == "") {
				$this->js_output_and_back("主旨不可為空");
				exit();
			}

			if ($data['content'] == "" || strlen($data['content'])<20) {
				$this->js_output_and_back("留言內容不可為空或字數少於20字");
				exit();
			}

			

			$res = $this->db->insert($this->contact, $data);

			if ($res) {

				$this->js_output_and_redirect("已留言成功，請靜待客服聯絡",base_url()."home/contact");
			} else {
				$this->js_output_and_back("留言發生錯誤，請重新留言！");
			}
		}
	}
}
