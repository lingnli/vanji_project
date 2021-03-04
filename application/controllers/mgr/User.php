<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ini_set('post_max_size','1024M');
// ini_set('upload_max_filesize','1024M');
// require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class user extends Base_Controller
{
	private $th_title = ["#", "帳號", "使用者資訊", "狀態", "註冊日期", "動作"]; //, "置頂"
	private $th_width = ["", "", "", "", "", "95px", "50px"];
	private $order_column = ["id", "", "", "", "", "", "register_date", ""]; //, "is_head"
	private $can_order_fields = [0, 6];




	public function __construct()
	{
		parent::__construct();
		$this->is_mgr_login();
		$this->data['active'] = "user";
	}

	public function index()
	{
		$this->data['title'] = '會員管理';

		$this->data['action'] = base_url() . "mgr/user/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		//管理列表
		$this->load->view('mgr/template_list', $this->data);
	}

	public function edit($id)
	{
		if (!is_numeric($id)) show_404();

		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id" => $id))->get($this->user)->row_array();
		$param = [

			["帳號", 		"email", 		"text", 				$oridata['email'], 		TRUE, 	"", 	4, 		12],
			["姓名", 		"name", 		"text", 				$oridata['name'], 		false, 	"", 	4, 		12],
			["手機", 		"phone", 		"text", 				$oridata['phone'], 		false, 	"", 	4, 		12],
			["生日", 		"birthday", 		"day", 				$oridata['birthday'], 		false, 	"", 	4, 		12],
			["狀態", 		"status", 	"select", 		$oridata['status'], 		TRUE, 	"", 4, 		12,		['id', 'status']],
			["註冊日期", 		"register_date", 		"plain", 				$oridata['register_date'], 		TRUE, 	"", 	4, 		12],
		];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if ($item[1] == "email_verify") {
					//$email_verify不存入資料庫
					continue;
				} else {

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1] . "_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./" . $oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
							$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir . $idata['file_name'];
						}
					} else {
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							} else {
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						} else {
							$data[$item[1]] = $this->input->post($item[1]);
						}
					}
				}
			}




			$res = $this->db->where(array("id" => $id))->update($this->user, $data);

			if ($res) {

				$this->js_output_and_redirect("編輯成功", base_url() . "mgr/user");
			} else {
				$this->js_output_and_back("發生錯誤");
			}
		} else {
			//僅讀取edit頁面
			$this->data['title'] = '編輯會員 ' . $oridata['id'];
			$this->data['parent'] = '會員管理';
			$this->data['parent_link'] = base_url() . "mgr/user";
			$this->data['action'] = base_url() . "mgr/user/edit/" . $oridata['id'];
			$this->data['submit_txt'] = "確認編輯";

			$this->data['select']['status'] =
				array(
					0 => array(
						'id' => 'normal',
						'status' => '正常'
					),
					1 => array(
						'id' => 'closed',
						'status' => '封鎖'
					)					
				);



			$this->data['param'] = $param;
			$this->load->view("mgr/template_form", $this->data);
		}
	}

	public function data()
	{
		$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
		$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
		$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
		$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

		$order_column = $this->order_column;


		$canbe_search_field = ["P.name", "P.email", "P.phone", "P.status"];

		$syntax = "P.is_delete=0";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field . " LIKE '%" . $search . "%'";
				$index++;
			}
			$syntax .= ")";
		}

		$total = $this->db->from($this->user . " P")
			->where($syntax)
			->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

		$order_by = "P.register_date DESC";
		if ($order_column[$order] != "") {
			$order_by = "P." . $order_column[$order] . " " . $direction . ", " . $order_by;
		}
		$list = $this->db->select("P.*")
			->from($this->user . " P")			
			 ->where($syntax)
			->order_by($order_by)
			->limit($this->page_count, ($page - 1) * $this->page_count)
			->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/user_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}

	public function del()
	{
		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if ($this->db->where(array("id" => $id))->update($this->user, array("is_delete" => 1))) {

				$this->output(TRUE, "success");
			} else {
				$this->output(FALSE, "fail");
			}
		} else {
			$this->output(FALSE, "fail");
		}
	}

}
