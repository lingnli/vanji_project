<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Priv extends Base_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->data['active'] = "PRIV";

		if (!$this->encryption->decrypt($this->session->p) == "super") {
			die();
		}
	}

	public function index()
	{
		$this->db->select("*");
		$this->db->from("member");
		$this->db->where("role <> 'super'");
		$this->db->order_by("create_date asc");
		$this->data['list'] = $this->db->get()->result_array();

		$this->load->view('mgr/priv', $this->data);
	}

	public function add()
	{
		$this->load->view("mgr/priv_add", $this->data);
	}

	public function addaction()
	{
		$name             =	$this->input->post("name");
		$account          =	$this->input->post("account");
		$password         =	$this->input->post("password");
		$password_confirm =	$this->input->post("password_confirm");
		// $canuse           =	$this->input->post("canuse");

		// if (count($canuse) <= 0) {
		// 	echo "<script> alert('請至少選擇一種權限功能'); history.back(); </script>";
		// 	return;
		// }else{
		// 	$canuse = json_encode($canuse);
		// }

		if ($password != $password_confirm) {
			echo "<script> alert('兩次輸入密碼不同'); history.back(); </script>";
			return;
		}

		$data = array(
			"name"      =>	$name,
			"account"   =>	$account,
			"password"  =>	$this->encryption->encrypt(md5($password)),
			"privilege" =>	"mgr",
			"status"    =>	"open"
			// "canuse"		   =>	$canuse
		);

		$res = $this->db->insert("member", $data);



		if ($res) {
			echo "<script> alert('新增成功'); location.href='" . base_url() . "mgr/priv'; </script>";
		} else {
			echo "<script> alert('新增發生錯誤'); history.back(); </script>";
		}
	}

	public function detail($user_id)
	{
		$this->db->select("*");
		$this->db->from("member");
		$this->db->where(array("id" => $user_id));
		$r = $this->db->get()->row();

		if ($r == null) {
			show_404();
		} else {
			$this->data['data'] = array(
				"id"       =>	$r->id,
				"name"     =>	$r->name,
				"status"	=>	$r->status
				// "canuse"   =>	$r->canuse
			);
			$this->load->view("mgr/priv_edit", $this->data);
		}
	}

	public function edit()
	{
		$user_id          =	$this->input->post("user_id");
		$name             =	$this->input->post("name");
		$password         =	$this->input->post("password");
		$password_confirm =	$this->input->post("password_confirm");
		$status           =	$this->input->post("status");
		// $canuse           =	$this->input->post("canuse");

		// if (count($canuse) <= 0) {
		// 	echo "<script> alert('請至少選擇一種權限功能'); history.back(); </script>";
		// 	return;
		// }else{
		// 	$canuse = json_encode($canuse);
		// }

		$data = array(
			"name"     =>	$name,
			"status"   =>	$status
		);

		if ($password != "") {
			if ($password != $password_confirm) {
				echo "<script> alert('兩次輸入密碼不同'); history.back(); </script>";
				return;
			} else {
				$data['password'] = $this->encryption->encrypt(md5($password));
			}
		}

		$this->db->where(array("id" => $user_id));
		$res = $this->db->update("member", $data);

		if ($res) {
			echo "<script> alert('編輯成功'); location.href='" . base_url() . "mgr/priv'; </script>";
		} else {
			echo "<script> alert('編輯發生錯誤'); history.back(); </script>";
		}
	}

	public function del($id)
	{
		if (is_numeric($id)) {
			$res = $this->db->delete("member", array("id" => $id));
			if ($res) {
				echo "<script> alert('刪除成功'); location.href='" . base_url() . "mgr/priv'; </script>";
			} else {
				echo "<script> alert('發生錯誤'); history.back(); </script>";
			}
		}
	}
}
