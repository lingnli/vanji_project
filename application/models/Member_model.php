<?php defined('BASEPATH') OR exit('No direct script access allowed');
include("./phpmailer/class.phpmailer.php");
require "./phpmailer/PHPMailerAutoload.php";
class Member_model extends CI_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}
	
	public function get_data($user_id, $fields = "*"){
		$this->db->select($fields);
		$this->db->from("user");
		$this->db->where(
			array("id"=>$user_id)
		);
		return $this->db->get()->row_array();
	}

	public function get_data_by_phone($phone, $fields = "*"){
		$this->db->select($fields);
		$this->db->from("user");
		$this->db->where(
			array("phone"=>$phone)
		);
		return $this->db->get()->row();
	}

	public function get_data_by_email($email, $fields = "*"){
		$this->db->select($fields);
		$this->db->from("user");
		$this->db->where(
			array("email"=>$email)
		);
		return $this->db->get()->row();
	}

	public function get_data_by_fbid($fbid, $fields = "*"){
		$this->db->select($fields);
		$this->db->from("user");
		$this->db->where(
			array("fb_id"=>$fbid)
		);
		return $this->db->get()->row();
	}

	public function fbaccount_exist($fb_id){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("fb_id"=>$fb_id)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function get_data_by_gid($gid, $fields = "*"){
		$this->db->select($fields);
		$this->db->from("user");
		$this->db->where(
			array("g_id"=>$gid)
		);
		return $this->db->get()->row();
	}

	public function gaccount_exist($g_id){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("g_id"=>$g_id)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function account_exist($email){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("email"=>$email)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function phone_exist($phone){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("phone"=>$phone, "status"=>"normal")
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	//確認帳號是否存在
	public function user_exsit_check($input)
	{
		$exit = $this->db->get_where("user", array("email" => $input))->row();
		if ($exit) {
			return TRUE;
		} else {
			return FALSE;
		}
	}	

	public function pwd_confirm($pwd_md5encrypt, $email){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("email"=>$email)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			if ($this->encryption->decrypt($r->password) == $pwd_md5encrypt) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function pwd_check($pwd_md5encrypt, $id)
	{
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("id" => $id)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		} else {
			if ($this->encryption->decrypt($r->password) == $pwd_md5encrypt) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}


	public function send_salon_changed_pwd($phone){
		$str = array();
		for ($i=0; $i <= 9; $i++) array_push($str, $i);
		for ($i='a'; $i <= 'z'; $i++) array_push($str, $i);
		for ($i='A'; $i <= 'Z'; $i++) array_push($str, $i);

		$new_pwd = $str[rand(0, count($str))].$str[rand(0, count($str))].$str[rand(0, count($str))];

		$this->db->where(array("phone"=>$phone));
		$this->db->update("salon", array("password"=>$this->encryption->encrypt(md5($new_pwd))));

		$salon = $this->db->get_where("salon", array("phone"=>$phone))->row_array();

		$this->send_sms($phone, "", $salon['name']."您好，您的新密碼是: ".$new_pwd);
	}

	public function send_changed_pwd($email){
		$str = array();
		for ($i=0; $i <= 9; $i++) array_push($str, $i);
		for ($i='a'; $i <= 'z'; $i++) array_push($str, $i);
		for ($i='A'; $i <= 'Z'; $i++) array_push($str, $i);

		$new_pwd = $str[rand(0, count($str))].$str[rand(0, count($str))].$str[rand(0, count($str))];

		$this->db->where(array("email"=>$email));
		$this->db->update("user", array("password"=>$this->encryption->encrypt(md5($new_pwd))));
		$this->send_mail($email, "您的新密碼是: ".$new_pwd, "忘記密碼信");
		// $this->send_sms($phone, "", "您的新密碼是: ".$new_pwd);
	}

	public function send_verify_code($phone){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("phone"=>$phone)
		);
		$r = $this->db->get()->row();
		$member_id = 0;
		if ($r == null) {
			$this->db->insert("user", array("phone"=>$phone));
			$member_id = $this->db->insert_id();
		}else{
			$member_id = $r->id;
		}

		$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

		$this->db->where(array("id"=>$member_id));
		$this->db->update("user", array("verify_code"=>$code));

		$this->send_sms($phone, "", "APODE驗證碼: ".$code);
	}

	public function can_send_sms($phone){
		$this->db->select("*");
		$this->db->from("sms_log");
		$this->db->where("phone = '{$phone}' AND create_date > '".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 60*3)."'");
		if($this->db->get()->num_rows() > 0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function exsit_check($phone){
		$exsit = $this->db->get_where("user", array("phone"=>$phone))->row();
		if ($exsit) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function verify_check($phone, $code){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where(
			array("phone"=>$phone, "verify_code"=>$code)
		);
		$r = $this->db->get()->row();
		if($r == null){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function send_sms($phone, $destName, $msg){
		$username = "54928667";
		$password = "1314520";
		
		$encoding = "UTF8";
		$dlvtime = "";			//預約簡訊YYYYMMDDHHNNSS，若為空則為即時簡訊
		$vldtime = "3600";		//簡訊有效時間YYYYMMDDHHNNSS，整數值為幾秒後內有限，不可超過24hr
		$smsbody = rawurlencode($msg);
								//簡訊內容，空白直接空白即可，換行請使用 chr(6)
		$response = "";			//簡訊狀態回報網址
		$ClientID = "";			//用於避免重複發送(不太會用到)

		$url = "http://smexpress.mitake.com.tw:9600/SmSendGet.asp?username=".$username."&password=".$password."&dstaddr=".$phone."&encoding=".$encoding."&DestName=".$destName."&dlvtime=".$dlvtime."&vldtime=".$vldtime."&smbody=".$smsbody."&response=".$response."&ClientID=".$ClientID;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		$r=curl_exec($ch);
		curl_close($ch);

		$this->db->insert("sms_log", array("phone"=>$phone, "content"=>$msg));
	}

	public function send_mail($email, $body, $subject = "")
	{
		if (!class_exists("phpmailer")) {
			include("./phpmailer/class.phpmailer.php");
			require_once "./phpmailer/PHPMailerAutoload.php";
		}
		$mail = new PHPMailer();                        // 建立新物件        

		//locolhost測試


		$mail->IsSMTP();                         // 設定使用SMTP方式寄信        
		$mail->SMTPAuth = true;                     		// 設定SMTP需要驗證
		$mail->SMTPSecure = "tls";                  		// Gmail的SMTP主機需要使用SSL連線   
		// $mail->SMTPDebug = 1;
		$mail->Host = "smtp.gmail.com";                  	// Gmail的SMTP主機        
		$mail->Port = 587;                        			// Gmail的SMTP主機的port為465      
		$mail->CharSet = "utf-8";
		//$mail->WordWrap = 50;                     // 每50個字元自動斷行

		$mail->Username = "vanjijewelry2020@gmail.com";     // 設定驗證帳號        
		$mail->Password = "mqcakioierkjgddu";                     // 設定驗證密碼        

		$mail->From = "vanji@service.com";         // 設定寄件者信箱        
		$mail->FromName = "梵日珠寶";                   // 設定寄件者姓名    

		$mail->Subject = $subject;                  // 設定郵件標題        

		$mail->IsHTML(true);                        // 設定郵件內容為HTML       
		$mail->AddAddress($email, $email);          // 收件者郵件及名稱 ***改這個
		$mail->Body = $body;

		if ($mail->Send()) {                         // 郵件寄出
			return array("status" => TRUE);
		} else {
			print_r('111');
			print_r($mail->ErrorInfo);
			exit;
			return array("status" => FALSE, "msg" => $mail->ErrorInfo);
		}
		$mail->ClearAddresses();
	}

	public function salon_verify($verify_code){
		$this->db->select("id");
		$this->db->from("salon");
		$this->db->where(array("verify_code"=>$verify_code, "status"=>"not_verify"));
		$r = $this->db->get()->row();

		if ($r != null) {
			$this->db->where(array("id"=>$r->id));
			$this->db->update("salon", array("status"=>"open", "verify_code"=>""));
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function salon_exist($email, $pwd_md5encrypt = FALSE){
		$this->db->select("*");
		$this->db->from("salon");
		$this->db->where(array("email"=>$email));
		$r = $this->db->get()->row_array();

		if ($pwd_md5encrypt === FALSE) {
			if ($r != null && is_array($r)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if ($r != null && is_array($r) && $this->encryption->decrypt($r['password']) == $pwd_md5encrypt) {
				return array("status"=>"success", "data"=>$r);
			}else{
				return array("status"=>"fail", "msg"=>"帳號/密碼錯誤");
			}
		}
	}
	public function salon_exist_by_phone($phone){
		$this->db->select("*");
		$this->db->from("salon");
		$this->db->where(array("phone"=>$phone));
		$r = $this->db->get()->row_array();

		if ($r != null ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_my_reserv($user_id){
		$this->db->select("B.*, B.service as select_service, S.name as service, SALON.name as salon, SALON.phone as salon_phone");
		$this->db->from("bill B");
		$this->db->join("service S", "B.service_id = S.id", "left");
		$this->db->join("salon SALON", "(B.salon_id = 0 AND S.salon_id = SALON.id) OR (B.salon_id > 0 AND SALON.id = B.salon_id)", "left");
		$this->db->where("B.user_id = '{$user_id}' AND B.status <> 'success'");
		$this->db->order_by("B.id ASC");
		return $this->db->get()->result_array();
	}

	public function get_my_history($user_id){
		$this->db->select("B.*, S.name as service_name, SALON.name as salon, D.name as designer, (SELECT value FROM evaluate WHERE bill_id = B.id) as is_evaluate");
		$this->db->from("bill B");
		$this->db->join("service S", "B.service_id = S.id", "left");
		$this->db->join("salon SALON", "(B.salon_id > 0 AND B.salon_id = SALON.id) OR (B.salon_id=0 AND S.salon_id = SALON.id)", "left");
		$this->db->join("designers D", "(B.assigned > 0 AND B.assigned = D.id) OR (B.assigned = 0 AND D.id = S.assigned)", "left");
		$this->db->where("B.user_id = '{$user_id}' AND B.status = 'success'");
		$this->db->group_by("B.id");
		return $this->db->get()->result_array();
	}
}