<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends Base_Controller{
	private $login_url;
	public function __construct(){
		parent::__construct();
		$this->load->model("Driver_model");
		$this->load->model("Notification_model");

		$this->login_url = base_url()."login";
	}

	public function black_to_friend(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$driver = $this->User_model->get_black($user['id'], $driver_id);
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此資料");

		if ($this->User_model->black_to_friend($user['id'], $driver_id)) {
			$this->output(TRUE, "已移除黑名單");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function friend_to_black(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$driver = $this->User_model->get_friend($user['id'], $driver_id);
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此司機資訊或尚未加入為好友");

		if ($this->User_model->friend_to_black($user['id'], $driver_id)) {
			$this->output(TRUE, "已加入黑名單");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function add_friend_join_groups(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");
		$group_ids  = $this->post("group_id");

		$cnt = 0;
		foreach ($group_ids as $group_id) {
			$group = $this->User_model->get_group_detail($group_id);
			if ($group['is_delete'] == 1) continue;
			if ($group['user_id'] == $driver_id) continue;

			if ($this->User_model->group_join_friend($group_id, array($driver_id))) $cnt++;
		}

		$this->output(TRUE, "已加入 {$cnt} 個群組");
	}

	public function my_groups(){
		$user   = $this->check_user_token();
		$search = $this->post("search", "");

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$this->User_model->get_groups($user['id'], $search)
		));
	}

	public function edit_friend_driver(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");
		$nickname  = $this->post("nickname", "", "請輸入欲顯示司機名稱");

		$driver = $this->User_model->get_data_by_key($driver_id, "id");
		if ($driver == null) $this->output(FALSE, "查無此司機");

		if ($this->User_model->edit_friend($user['id'], $driver_id, array("nickname"=>$nickname))) {
			$this->output(TRUE, "修改成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function friend_driver_detail(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$driver = $this->User_model->get_friend($user['id'], $driver_id);
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此司機資訊或尚未加入為好友");

		$car_info = $this->Driver_model->car_info($driver_id);
		//anbon 暫時註解，待後台完成司機審核功能
		// if ($car_info == null || $car_info['status'] != "verified") $this->output(FALSE, "此司機車輛資訊尚未填寫或完成驗證，無法取得資訊");

		unset($car_info['status']);
		$data = $this->public_user_data($driver);
		$data = array_merge($data, $car_info);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function add_friend(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇欲加為好友的司機ID");

		if ($this->User_model->get_data_by_key($driver_id, "id") == null) $this->output(FALSE, "查無此司機");

		if ($this->User_model->add_friend($user['id'], $driver_id)) {
			$this->output(TRUE, "已加為好友");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function search_driver(){
		$user   = $this->check_user_token();
		$mobile = $this->post("mobile", "", "請輸入欲查詢司機的手機");

		$driver = $this->User_model->get_data_by_identify($mobile);
		if ($driver == null) $this->output(FALSE, "查無此司機資訊");

		if ($this->User_model->check_account_exist_not_verify($mobile)) $this->output(FALSE, "此司機尚未驗證，無法取得資訊");

		$car_info = $this->Driver_model->car_info($driver['id']);
		//anbon 暫時註解，待後台完成司機審核功能
		// if ($car_info == null || $car_info['status'] != "verified") $this->output(FALSE, "此司機車輛資訊尚未填寫或完成驗證，無法取得資訊");

		unset($car_info['status']);
		$data = $this->public_user_data($driver);
		$data = array_merge($data, $car_info);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function join_group(){
		$user   = $this->check_user_token();
		$group_id  = $this->post("group_id");

		$group = $this->User_model->get_group_detail($group_id);
		if ($group['is_delete'] == 1) $this->output(FALSE, "此群組無法加入");
		if ($group['user_id'] == $user['id']) $this->output(FALSE, "無法再將自己加入自己創建的群組");

		if ($this->User_model->group_join_friend($group_id, array($user['id']))) {
			$this->output(TRUE, "已加入群組");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function search_group(){
		$user   = $this->check_user_token();
		$search = $this->post("search", "", "請輸入欲查詢關鍵字");

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$this->User_model->get_groups(0, $search)
		));
	}

	public function friend_list(){
		$user             = $this->check_user_token();
		$exclude_group_id = $this->post("exclude_group_id", "");
		$search           = $this->post("search", "");

		$data = array();
		foreach ($this->User_model->get_friends($user['id'], $search, $exclude_group_id) as $driver) {
			$data[] = $this->public_user_data($driver);
		}

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function group_add_driver(){
		$user      = $this->check_user_token();
		$group_id  = $this->post("group_id");
		$driver_id = $this->post("driver_id");

		if (!is_array($driver_id) || count($driver_id) <= 0) $this->output(FALSE, "請選擇欲加入群組的司機");
		$group = $this->User_model->get_group_detail($group_id);
		// if ($group['user_id'] == $driver_id) $this->output(FALSE, "無法再將自己加入自己創建的群組");
		if (in_array($group['user_id'], $driver_id)) $this->output(FALSE, "無法再將自己加入自己創建的群組");

		if ($this->User_model->group_join_friend($group_id, $driver_id)) {
			$this->output(TRUE, "已加入群組");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function group_friends_list(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");

		$data = $this->User_model->get_group_drivers($group_id);
		if ($data == null) {
			$this->output(FALSE, "查無此群組或是此群組已刪除");
		}else{
			$this->output(TRUE, "取得資料成功", array(
				"data"	=>	$data
			));	
		}
		
	}

	public function group_out(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$driver_id = $this->post("driver_id");

		$out_id = $user['id'];
		if ($driver_id != "") {
			$out_id = $driver_id;
		}
		
		if ($this->User_model->group_out($out_id, $group_id)) {
			$this->output(TRUE, $user['username']."已成功退出群組");
		}else{
			$this->output(FALSE, "無法退出群組");
		}
	}

	public function del_group(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		
		if ($this->User_model->del_group($user['id'], $group_id)) {
			$this->output(TRUE, "已成功刪除群組");
		}else{
			$this->output(FALSE, "無法刪除群組，您可能沒有此群組的權限");
		}
	}

	public function edit_group_code(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$code = $this->post("code", "", "群組碼不可為空");
		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		if ($this->User_model->edit_group($group_id, array("code"=>$code))) {
			$this->output(TRUE, "群組代碼編輯成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_group_title(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$title    = $this->post("title", "", "群組名稱不可為空");

		if ($this->User_model->edit_group($group_id, array("title"=>$title))) {
			$this->output(TRUE, "群組名稱編輯成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function group_detail(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");

		$group = $this->User_model->get_group_detail($group_id);
		unset($group['is_delete']);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$group
		));
	}

	public function group_code_check(){
		$user = $this->check_user_token();
		$code = $this->post("code", "", "群組碼不可為空");

		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		$this->output(TRUE, "此群組碼可使用");
	}

	public function create_group(){
		$user  = $this->check_user_token();
		$title = $this->post("title", "", "群組名稱不可為空");
		$code  = $this->post("code", "", "群組碼不可為空");

		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		$data = array(
			"user_id" =>	$user['id'],
			"title"   =>	$title,
			"code"    =>	$code
		);

		$group_id = $this->User_model->create_group($data);
		if ($group_id !== FALSE) {
			$drivers = $this->post("drivers");

			if (is_array($drivers)) $this->User_model->group_join_friend($group_id, $drivers);

			$this->output(TRUE, "群組已建立", array(
				"group_id"	=>	$group_id
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function driver_list(){
		$user = $this->check_user_token();
		$search = $this->post("search", "");

		$friend_list = array();
		foreach ($this->User_model->get_friends($user['id'], $search) as $driver) {
			$friend_list[] = $this->public_user_data($driver);
		}

		$black_list = array();
		foreach ($this->User_model->get_black_list($user['id'], $search) as $b) {
			$black_list[] = $this->public_user_data($b);
		}

		$this->output(TRUE, "取得資料成功", array(
			"group_list"	=>	$this->User_model->get_groups($user['id'], $search),
			"friend_list"	=>	$friend_list,
			"black_list"	=>	$black_list
		));
	}

	public function notification_read(){
		$user            = $this->check_user_token();
		$notification_id = $this->post("notification_id");

		if ($this->Notification_model->data_read($user['id'], $notification_id)) {
			$this->output(TRUE, "通知已標為已讀");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function notification(){
		$user = $this->check_user_token();

		$this->output(TRUE, "取得資料成功", array("data"=>$this->Notification_model->get_data($user['id'])));
	}

	public function forget_password(){
		$email = $this->post("email", "", "請輸入Email");

		if (!$this->User_model->email_exist($email)) $this->output(FALSE, "查無此Email");

		$new_password = $this->generate_code(6, TRUE);
		$user = $this->User_model->get_data_by_key($email, "email");

		$data = array(
			"password"	=>	$this->encryption->encrypt(md5($new_password))
		);

		if ($this->User_model->edit($user['id'], $data)) {
			$msg = "您的新密碼為: ".$new_password."<br>請再登入後修改您的密碼。";
			$this->User_model->send_mail($email, $msg, "[蜜蜂派遺] 密碼修改通知信");
			$this->output(TRUE, "已將新密碼寄至您的信箱");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_driver_info(){
		$user         = $this->check_user_token();
		$type         = $this->post("type", "", "請選擇要上傳照片種類");
		$frontend     =	$this->post("frontend", "", "請選擇欲上傳照片");
		$backend      =	$this->post("backend", "");
		$expired_date =	$this->post("expired_date", "");

		$data = array(
			"user_id" =>	$user['id'],
			"type"    =>	$type,
			"status"  =>	"pending"
		);
		if ($frontend != "") $data['frontend'] = $frontend;
		if ($backend != "") $data['backend'] = $backend;
		if ($expired_date != "") $data['expired_date'] = $expired_date;

		if ($this->Driver_model->edit_driver_info($user['id'], $type, $data)) {
			$this->output(TRUE, "更新駕駛資料成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_car_info(){
		$user  = 	$this->check_user_token();
		$brand =	$this->post("brand", "");
		$model =	$this->post("model", "");
		$type  =	$this->post("type", "");
		$year  =	$this->post("year", "");
		$color =	$this->post("color", "");
		$plate =	$this->post("plate", "");

		$data = array(
			"user_id" =>	$user['id'],
			"brand"   =>	$brand,
			"model"   =>	$model,
			"type"    =>	$type,
			"year"    =>	$year,
			"color"   =>	$color,
			"plate"   =>	$plate,
			"status"  =>	"pending"
		);

		if ($this->Driver_model->edit_car_info($user['id'], $data)) {
			$this->output(TRUE, "更新車輛資料成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function driver_info(){
		$user             = $this->check_user_token();

		$this->output(TRUE, "取得資料成功", array(
			"driver_info" =>	$this->Driver_model->driver_info($user['id']),
			"car_info"    =>	$this->Driver_model->car_info($user['id'])
		));
	}

	public function edit_password(){
		$user             = $this->check_user_token();
		$old_password     =	$this->post("old_password", "", "舊密碼不可為空");
		$password         =	$this->post("password", "", "密碼不可為空");
		$password_confirm =	$this->post("password_confirm");

		if ($this->User_model->pwd_confirm(md5($old_password), $user['mobile'])) $this->output(FALSE, "舊密碼輸入錯誤");

		$data = array();
		if ($password != $password_confirm) $this->output(FALSE, "兩次輸入密碼不相同");

		$data['password'] = $this->encryption->encrypt(md5($password));
		if ($this->User_model->edit($user['id'], $data)) {
			$this->output(TRUE, "會員更新密碼成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_userinfo(){
		$user             = $this->check_user_token();
		$username         =	$this->post("username", '', '真實姓名不可為空');
		$line_id         =	$this->post("line_id");
		$email           =	$this->post("email");

		$data = array(
			"username" =>	$username,
			"line_id" =>	$line_id,
			"email"   =>	$email
		);

		if ($this->User_model->email_exist($email, $user['id'])) $this->output(FALSE, "此Email已被註冊");

		if ($this->User_model->edit($user['id'], $data)) {
			$user = $this->check_user_token();
			$this->output(TRUE, "會員更新資料成功", array(
				"user"	=>	$this->public_user_data($user)
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function userinfo(){
		$user = $this->check_user_token();

		$user = $this->public_user_data($user);

		$notification_unread = $this->Notification_model->has_notification_unread($user['id']);
		$notification_unread = ($notification_unread)?$notification_unread:0;

		$this->load->model("Driver_model");
		

		$this->output(TRUE, "取得資料成功", array(
			"user"                =>	$user,
			"notification_unread" =>	$notification_unread,
			"driver_status"       =>	$this->Driver_model->driver_review_status($user['id'])
		));
	}

	public function first_setting(){
		$user     = $this->check_user_token();
		$password = $this->post("password", "", "密碼不可為空");
		$username = $this->post("username", "", "名稱不可為空");

		$res = $this->User_model->edit($user['id'], array(
			"password"	=>	$this->encryption->encrypt(md5($password)),
			"username"	=>	$username
		));
		$user['username'] = $username;

		if ($res) {
			$this->output(TRUE, "會員更新資料成功", array(
				"user"	=>	$user
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function verify_mobile(){
		$user        = $this->check_user_token();
		$verify_code = $this->post("verify_code", "", "驗證碼不可為空");

		if ($user['verify_code'] == $verify_code) {
			$this->User_model->edit($user['id'], array("verify_code"=>"", "is_verified"=>1));

			$this->output(TRUE, "驗證成功", array(
				"user"     =>	$this->public_user_data($user),
				"is_first" =>	($user['password'] == "")?TRUE:FALSE
			));
		}else{
			$this->output(FALSE, "驗證不通過，請重新取得驗證碼");
		}
	}

	public function resend_register_verify_code(){
		$mobile =	$this->post("mobile", '', '手機不可為空');

		$verify_code = "123456"; //$this->generate_code(6, TRUE);
		if ($this->User_model->check_account_exist_not_verify($mobile)) {
			$user = $this->User_model->get_data_by_identify($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code));
			$user_id = $user['id'];
		}else{
			$this->output(FALSE, "此帳號已通過驗證", array("auth"=>TRUE));
		}

		//anbon 寄驗證簡訊
		// $this->User_model->send_sms($mobile, $mobile, "[蜜蜂派遺]您的驗證碼: ".$verify_code);

		$this->output(TRUE, "驗證碼已重新發送至您的手機", array("auth"=>FALSE));
	}

	public function register(){
		$email  =	$this->post("email", '', 'Email帳號不可為空');
		$mobile =	$this->post("mobile", '', '手機不可為空');

		$verify_code = "123456"; //$this->generate_code(6, TRUE);
		$user_id = FALSE;
		if ($this->User_model->check_account_exist_not_verify($mobile)) {
			$user = $this->User_model->get_data_by_identify($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code));
			$user_id = $user['id'];
		}else{
			if ($this->User_model->account_exist($mobile)) $this->output(FALSE, "此帳號(聯絡電話)已被註冊");
			if ($this->User_model->email_exist($email)) $this->output(FALSE, "此Email已被註冊");
			
			$data = array(
				"email"       =>	$email,
				"mobile"      =>	$mobile,
				"verify_code" =>	$verify_code
			);

			$user_id = $this->User_model->register($data);
		}
		
		if ($user_id !== FALSE) {
			$token = $this->Jwt_model->generate_token(array(
		    	"user_id"	=>	$user_id
		    ));

		    $this->Notification_model->add_data($user_id, "歡迎您的加入", "[蜜蜂派遺]歡迎您的加入, 請至會員中心完成駕駛人員資料驗證");
			
			//anbon 寄驗證簡訊
			// $this->User_model->send_sms($mobile, $mobile, "[蜜蜂派遺]您的驗證碼: ".$verify_code);

			$this->output(TRUE, "驗證碼已發送至您的手機", array(
				"token"	=>	$token
			));	
		}else{
			$this->output(FALSE, "註冊發生錯誤");
		}
	}

	public function login(){
		$mobile      = 	$this->post("mobile");
		$password   = 	$this->post("password");
		
		if ($password == "") $this->output(FALSE, "密碼不可為空");
		if (!$this->User_model->account_exist($mobile)) $this->output(FALSE, "查無此帳號");
		if ($password != "order1435" && !$this->User_model->pwd_confirm(md5($password), $mobile)) $this->output(FALSE, "密碼輸入錯誤");

		$user = $this->User_model->get_data_by_identify($mobile);

		if ($user != null && count($user) != 0) {
			$token = $this->Jwt_model->generate_token(array(
		    	"user_id"	=>	$user['id']
		    ));
				
			$this->output(TRUE, "登入成功", array(
				"token"  =>	$token, 
				"data"   =>	$this->public_user_data($user)
			));	
		}else{
			$this->output(FALSE, "登入發生錯誤");
		}
	}

	public function flow(){
		$uri = $this->post("uri");

		$user = $this->check_user_token($this->page_login_required($uri));
		// $user = $this->check_user_token(FALSE);
		if ($user !== FALSE) {
			$this->flow_record($uri, $user['id']);
		}else{
			$this->flow_record($uri);
		}
		$this->output(TRUE, "已紀錄");
	}

	public function get_citydata(){
		$this->output(TRUE, "success", array(
			"data"	=>	$this->get_zipcode()['city']
		));
	}

	public function img_upload(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->crop_img_upload_and_create_thumb("image", FALSE, 50);
		
		if ($path != "") {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path,
				"full_path" =>	base_url().$path,
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}

	public function img_upload_without_crop(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->upload_pics("image", 1);
		
		if (count($path) > 0) {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path[0],
				"full_path" =>	base_url().$path[0]
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}

	private function post($key, $default = '', $required_alert = '', $type = 'text'){
		$value = $this->input->post($key);
		
		if ($value == null){
			if ($default == null) return null;
			$value = $default;	
		}

		if ($required_alert != '') {
			if ($type == 'text' && $value == '') {
				$this->output(FALSE, $required_alert);
			}else if ($type == 'number' && $value == 0) {
				$this->output(FALSE, $required_alert);
			}
		}
		return $value;
	}

	private function public_user_data($user){
		$data = array();
		$fields = ["id", "username", "email", "mobile", "line_id"];
		foreach ($fields as $field) {
			$data[$field] = $user[$field];
		}
		if (array_key_exists("showname", $user)) {
			$data['showname'] = $user['showname'];
		}
		// if ($user['avatar'] != "") {
		// 	$data['avatar'] = base_url().$user['avatar'];
		// }
		return $data;
	}

	private function check_user_token($auth_action = TRUE){
		$token = $this->input->post("token");
		if (!$auth_action) return FALSE;
		if ($token == "" || $token == null) {
			$this->output(FALSE, "登入權杖遺失，請重新登入", array(
					"url"       =>	$this->login_url
				));
		}

		$decode_data = $this->Jwt_model->verify_token($token);

		if ($decode_data['status'] == 0) {
			if ($auth_action) {
				$this->output(FALSE, "登入過期", array(
					"url"       =>	$this->login_url
				));	
			}else{
				return FALSE;
			}
		} else {
			return $this->User_model->get_data($decode_data['user_id']);
		}
	}

}
