<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Base_Controller {

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "setting";
	}

	public function index(){
		// print_r('222');exit;

		$this->data['list'] = $this->db->order_by("id asc")->get_where('settings', array("id<"=>13))->result_array();
		
		$this->load->view('mgr/setting', $this->data);
	}

	public function edit(){
		$id      = $this->input->post("id");
		$content = $this->input->post("content");

		if($id==5){
			$emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
			if ($content == "" || !preg_match($emailregex, $content)) {
				$this->output(false, "false");
				exit();
			}
		}

		if ($id == 11) {
			
			if (!is_numeric($content)) {
				$this->output(false, "false");
				exit();
			}
		}

		if ($id == 13 || $id == 15) {

			$content_array = explode(',',$content);
			if(count($content_array)!=2){
				$this->output(false, "false");
			}else{
				if(!($content_array[1]>0 && $content_array[1] < 100)){
					$this->output(false, "false");
				}
			}
			
		}

		if ($id == 17) {

			if (trim($content)!=1) {
				if (trim($content) != 2) {
				$this->output(false, "false");
				exit();
				}
			}
		}

		// $mobileregex = "/^09[0-9]{8}$/";
		// if ($phone == "" || !preg_match($mobileregex, $phone)) {
		// 	$this->js_output_and_back("請確認手機");
		// 	exit();
		// }


		$this->db->where(array("id"=>$id));
		$res = $this->db->update("settings", array("content"=>$content));
		
		if ($res) {
			$this->output(100, "success");
		}else{
			$this->output(400, "fail");
		}
		// header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}
