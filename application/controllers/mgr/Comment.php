<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends Base_Controller {


	
						
	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "comment";
		$this->load->model("Product_model");
	}


	//產品留言
	public function product($path = FALSE, $id = FALSE)
	{

		// print_r($this->data);exit;

		$this->data['sub_active'] = "product";

		$th_title = ["#", "商品", "留言者資訊", "內文節錄", "顯示","日期", "動作"];
		$th_width = ["", "120px", "", "", "", "100px", ""];
		$order_column = ["id", "", "", "", "", "", "date", ""];
		$can_order_fields = [0, 6];

		$param = [
			["商品", "pid_name", "plain", "",],
			["內文", "content", "textarea", ""],		
			["顯示", "is_show", "select", "", ["id", "is_show"]],	
		];

		if ($path === FALSE) {
			$this->data['title'] = '產品留言管理';

			$this->data['action'] = base_url() . "mgr/comment/product/";

			$this->data['th_title'] = $th_title;
			$this->data['th_width'] = $th_width;
			$this->data['can_order_fields'] = $can_order_fields;
			$this->data['tool_btns'] = [
				// ['新增', base_url() . "mgr/comment/product/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 1;
			$this->data['default_order_direction'] = 'DESC';

			$this->load->view('mgr/template_list', $this->data);
		} else if ($path == "data") {
			$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
			$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
			$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
			$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

			$order_column = $order_column;
			$canbe_search_field = ["P.name","P.email", "P.content"];

			$syntax = "P.is_delete = 0";
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

			$total = $this->db->where($syntax)->get($this->product_comment." P")->num_rows();
			$total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

			// $order_by = "id DESC";
			// if ($order_column[$order] != "") {
			// 	$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
			// }
			$list = $this->db->select("P.*,U.name as product_name")
			->from($this->product_comment." P")
			->join($this->product . " U","U.id=P.p_id",'left')
			->where($syntax)
			->group_by("P.id")
			// ->order_by($order_by)
			->limit($this->page_count, ($page - 1) * $this->page_count)
			->get()->result_array();



			$total_num = $this->db->get_where($this->product_comment, array("is_delete" => 0))->num_rows();
			$html = "";



			foreach ($list as $item) {

				if ($search != "") {
					foreach ($item as $key => $value) {
						if (in_array($key, $canbe_search_field) && $key != "url") {
							$item[$key] = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $item[$key]);
						}
					}
				}

				$html .= $this->load->view("mgr/items/comment_p_item", array(
						"item"  =>	$item,
						
						"total"	=>	$total_num
					), TRUE);
			}

			$this->output(TRUE, "成功", array(
				"html"       =>	$html,
				"page"       =>	$page,
				"total_page" =>	$total_page,
				"list" =>	$list
			));
		} else if ($path == "edit") {
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id" => $id))->get($this->product_comment)->row_array();
			$product = $this->db->where(array("id" => $data['p_id']))->get($this->product)->row_array();
			$param = [
				["留言商品", "pid_name", "plain", $product['name']],
				["內文", "content", "textarea_plain", $data['content']],
				["回覆", "replay", "textarea_plain", $data['replay']],
				["顯示", "is_show", "select", $data['is_show'], ["id", "is_show"]],
				["留言日期", "create_date", "plain", $data['create_date']]

			];
			if ($_POST) {
				$data = array();
				foreach ($param as $item) {
					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
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
								// $data[$item[1]] = substr($yid[1], 0, 11);
							}
						} else {
							$data[$item[1]] = $this->input->post($item[1]);
						}
					}
				}

				unset($data['pid_name']);
				$res = $this->db->where(array("id" => $id))->update($this->product_comment, $data);



				if ($res) {

					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/comment/product");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '編輯文章';

				$this->data['parent'] = '文章管理';
				$this->data['parent_link'] = base_url() . "mgr/comment/product";

				$this->data['action'] = base_url() . "mgr/comment/product/edit/" . $data['id'];
				$this->data['submit_txt'] = "確認編輯";

				//前台列表選項
				$this->data['select']['is_show'] =
				array(
					0 => array(
						'id' => 0,
						'is_show' => '不顯示'
					),
					1 => array(
						'id' => 1,
						'is_show' => "顯示"
					),

				);



				$this->data['param'] = $param;
				$this->load->view("mgr/template_form_old", $this->data);
			}
		} else if ($path == "del") {
			$id = $this->input->post("id");
			if (is_numeric($id)) {
				if ($this->db->where(array("id" => $id))->update($this->product_comment, array("is_delete" => 1))) {

					//重整排序
					$this->output(TRUE, "success");
				} else {
					$this->output(FALSE, "fail");
				}
			} else {
				$this->output(FALSE, "fail");
			}
		}
	}

	//消息留言
	public function news($path = FALSE, $id = FALSE)
	{

		// print_r($this->data);exit;

		$this->data['sub_active'] = "news";

		$th_title = ["#", "消息", "留言者資訊", "內文節錄", "顯示", "日期", "動作"];
		$th_width = ["", "120px", "", "", "", "100px", ""];
		$order_column = ["id", "", "", "", "", "", "date", ""];
		$can_order_fields = [0, 6];

		$param = [
			["商品", "pid_name", "plain", "",],
			["內文", "content", "textarea_plain", ""],
			["內文", "replay", "textarea", ""],
			["顯示", "is_show", "select", "", ["id", "is_show"]],
		];

		if ($path === FALSE
		) {
			$this->data['title'] = '產品留言管理';

			$this->data['action'] = base_url() . "mgr/comment/news/";

			$this->data['th_title'] = $th_title;
			$this->data['th_width'] = $th_width;
			$this->data['can_order_fields'] = $can_order_fields;
			$this->data['tool_btns'] = [
				// ['新增', base_url() . "mgr/comment/news/add", "btn-primary"]
			];
			$this->data['default_order_column'] = 1;
			$this->data['default_order_direction'] = 'DESC';

			$this->load->view('mgr/template_list', $this->data);
		} else if ($path == "data") {
			$page        = ($this->input->post("page")) ? $this->input->post("page") : 1;
			$search      = ($this->input->post("search")) ? $this->input->post("search") : "";
			$order       = ($this->input->post("order")) ? $this->input->post("order") : 0;
			$direction   = ($this->input->post("direction")) ? $this->input->post("direction") : "ASC";

			$order_column = $order_column;
			$canbe_search_field = ["P.name", "P.email", "P.content"];

			$syntax = "P.is_delete = 0";
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

			$total = $this->db->where($syntax)->get($this->news_comment . " P")->num_rows();
			$total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

			$order_by = "id DESC";
			if ($order_column[$order] != "") {
				$order_by = $order_column[$order] . " " . $direction . ", " . $order_by;
			}
			$list = $this->db->select("P.*,U.title as news_name")
			->from($this->news_comment . " P")
			->join($this->news . " U", "U.id=P.n_id", 'left')
			->where($syntax)
			->group_by("P.id")
			->order_by($order_by)
			->limit($this->page_count, ($page - 1) * $this->page_count)
			->get()->result_array();



			$total_num = $this->db->get_where($this->news_comment, array("is_delete" => 0))->num_rows();
			$html = "";



			foreach ($list as $item) {

				if ($search != "") {
					foreach ($item as $key => $value) {
						if (in_array($key, $canbe_search_field) && $key != "url") {
							$item[$key] = preg_replace('/' . $search . '/i', '<mark data-markjs="true">' . $search . '</mark>', $item[$key]);
						}
					}
				}

				$html .= $this->load->view("mgr/items/comment_n_item", array(
						"item"  =>	$item,

						"total"	=>	$total_num
					), TRUE);
			}

			$this->output(TRUE, "成功", array(
				"html"       =>	$html,
				"page"       =>	$page,
				"total_page" =>	$total_page,
				"list" =>	$list
			));
		} else if ($path == "edit") {
			if (!is_numeric($id)) show_404();

			$data = $this->db->where(array("id" => $id))->get($this->news_comment)->row_array();
			$news = $this->db->where(array("id" => $data['n_id']))->get($this->news)->row_array();
			$param = [
				["留言商品", "pid_name", "plain", $news['title']
				],
				["內文", "content", "textarea_plain", $data['content']],
				["內文", "replay", "textarea_plain", $data['replay']],
				["顯示", "is_show", "select", $data['is_show'], ["id", "is_show"]],
				["留言日期", "create_date", "plain", $data['create_date']
				]

			];
			if ($_POST) {
				$data = array();
				foreach ($param as $item) {
					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
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
								// $data[$item[1]] = substr($yid[1], 0, 11);
							}
						} else {
							$data[$item[1]] = $this->input->post($item[1]);
						}
					}
				}

				unset($data['pid_name']);
				$res = $this->db->where(array("id" => $id))->update($this->news_comment, $data);



				if ($res) {

					$this->js_output_and_redirect("編輯成功", base_url() . "mgr/comment/news");
				} else {
					$this->js_output_and_back("發生錯誤");
				}
			} else {
				$this->data['title'] = '編輯文章';

				$this->data['parent'] = '文章管理';
				$this->data['parent_link'] = base_url() . "mgr/comment/news";

				$this->data['action'] = base_url() . "mgr/comment/news/edit/" . $data['id'];
				$this->data['submit_txt'] = "確認編輯";

				//前台列表選項
				$this->data['select']['is_show'] =
				array(
					0 => array(
						'id' => 0,
						'is_show' => '不顯示'
					),
					1 => array(
						'id' => 1,
						'is_show' => "顯示"
					),

				);



				$this->data['param'] = $param;
				$this->load->view("mgr/template_form_old", $this->data);
			}
		} else if ($path == "del") {
			$id = $this->input->post("id");
			if (is_numeric($id)) {
				if ($this->db->where(array("id" => $id))->update($this->news_comment, array("is_delete" => 1))) {

					//重整排序
					$this->output(TRUE, "success");
				} else {
					$this->output(FALSE, "fail");
				}
			} else {
				$this->output(FALSE, "fail");
			}
		}
	}
}
