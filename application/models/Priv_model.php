<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Priv_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function priv_action(){
		return $this->db->get($this->priv_action_table)->result_array();
	}

	public function get_priv_menu_by_privilege_id($privilege_id){
		return $this->db->order_by("menu_id ASC")->get_where($this->privilege_menu_related_table, array("privilege_id"=>$privilege_id))->result_array();
	}

	public function priv_menu($show = "all"){ //all => 顯示所有的
		$list = $this->db->order_by("parent_id ASC, sort ASC")->get_where($this->priv_menu_table, array("status" => "on"))->result_array();

		//Current Logging member
		$member = $this->get_member_data($this->encryption->decrypt($this->session->id));
		if($member['privilege'] =='super'){
			$list = $this->db->order_by("parent_id ASC, sort ASC")->get_where($this->priv_menu_table, array("status" => "on"))->result_array();
		} else if ($member['privilege'] == 'mgr') {
			$list = $this->db->order_by("parent_id ASC, sort ASC")->get_where($this->priv_menu_table, array("status" => "on","is_employee"=>0))->result_array();
		}
		// print_r($member);exit;
		$priv_menu = array();

		if ($show == 'all') {
			foreach ($list as $obj) {
				$priv_menu[$obj['id']] = TRUE;
			}
		}else{
			foreach ($this->get_priv_menu_by_privilege_id($member['privilege_id']) as $obj) {
				if (!array_key_exists($obj['menu_id'], $priv_menu)) $priv_menu[$obj['menu_id']] = array();

				if ($show == "member" && $obj['action_id'] != 1) continue;
				$priv_menu[$obj['menu_id']] = ($obj['enabled'] == 1)?TRUE:FALSE;
			}	
		}

		$data = array();
		foreach ($list as $item) {
			if ($item['parent_id'] == 0) {
				if (array_key_exists($item['id'], $priv_menu)) {
					if ($show == "member" && !$priv_menu[$item['id']]) continue;
					$data[$item['id']] = array(
						"function" =>	$item['function'],
						"name"     =>	$item['name'],
						"icon"     =>	$item['icon'],
						"url"      =>	$item['url'],
						"action"   =>	$item['action'],
						"badge"    =>	0,
						"sub_menu" =>	array()
					);	
				}
				
			}else{
				if (!array_key_exists($item['parent_id'], $data)) continue;
				if (array_key_exists($item['id'], $priv_menu)) {
					if ($show == "member" && !$priv_menu[$item['id']]) continue;
					$data[$item['parent_id']]['sub_menu'][$item['id']] = array(
						"function" =>	$item['function'],
						"name"     =>	$item['name'],
						"icon"     =>	$item['icon'],
						"url"      =>	$item['url'],
						"action"   =>	$item['action'],
						"badge"    =>	0
					);
				}
			}
		}
		return $data;
	}

	public function update_priv_menu_rel($priv_id, $data){
		//Step 1 Delete all
		$this->db->delete($this->privilege_menu_related_table, array("privilege_id"=>$priv_id));

		//Step 2 Insert all
		$res = $this->db->insert_batch($this->privilege_menu_related_table, $data, "privilege_id");

		if ($res) {
			$this->db->where(array("id"=>$priv_id))->update($this->priv_table, array("update_date"=>date("Y-m-d H:i:s"), "update_by"=>$this->encryption->decrypt($this->session->id)));
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function add_priv($title){
		$res = $this->db->insert($this->priv_table, array(
			"title"     =>	$title,
			"create_by" =>	$this->encryption->decrypt($this->session->id)	
		));
		if ($res) {
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}

	public function get_all_priv(){
		return $this->db->order_by("id asc")->get_where($this->priv_table, array("is_delete"=>0))->result_array("id");
	}

	public function get_priv_data($id){
		return $this->db->get_where($this->priv_table, array("id"=>$id))->row_array();
	}

	public function get_priv_list($syntax, $order_by, $page = 1, $page_count = 20){
		$total = $this->db->where($syntax)->get($this->priv_table)->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("*")
						 ->from($this->priv_table)
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		
		return array(
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}

	public function get_member_event_related($member_id){
		$related = array();
		foreach ($this->db->get_where($this->member_event_related_table, array("member_id"=>$member_id))->result_array() as $item) {
			$related[] = $item['show_id'];
		}
		return $related;
	}

	public function clear_member_event_related($member_id){
		return $this->db->delete($this->member_event_related_table, array("member_id"=>$member_id));
	}

	public function member_event_related($member_event_data){
		return $this->db->insert_batch($this->member_event_related_table, $member_event_data);
	}

	public function member_edit($id, $data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->update_batch($this->member_table, $data, "id");
		}else{
			return $this->db->where(array("id"=>$id))->update($this->member_table, $data);
		}
	}

	public function member_add($data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->insert_batch($this->member_table, $data);
		}else{
			$res = $this->db->insert($this->member_table, $data);
			if ($res) return $this->db->insert_id();
			return FALSE;
		}
	}

	public function get_member_data($id){
		return $this->db->get_where($this->member_table, array("id"=>$id))->row_array();
	}

	public function get_all_member_list($without_privilege_super = TRUE, $index_with_member_id = FALSE){
		$syntax = array("is_delete"=>0);
		if ($without_privilege_super) {
			$syntax['role<>'] = 'super';
		}
		if ($index_with_member_id) {
			return $this->db->get_where($this->member_table, $syntax)->result_array("id");	
		}
		return $this->db->get_where($this->member_table, $syntax)->result_array();
	}

	public function get_member_list($syntax, $order_by, $contain_log = TRUE, $page = 1, $page_count = 20){
		$total = $this->db->where($syntax)->get($this->member_table)->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("*")
						 ->from($this->member_table)
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		if ($contain_log) {
			foreach ($list as $key => $item) {
				$log = $this->db->order_by("id desc")->get_where($this->log_record_table, array("member_id"=>$item['id']))->row_array();
				if ($log == null) {
					$list[$key]['last_action'] = "";
					$list[$key]['last_action_datetime'] = "";
				}else{
					$list[$key]['last_action'] = $log['msg'];
					$list[$key]['last_action_datetime'] = $this->dateStr($log['create_date']);//date("m/d H:i", strtotime($log['create_date']));
				}
			}
		}

		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['show_id'] = $this->db->get_where($this->member_event_related_table, array("member_id"=>$list[$i]['id']))->result_array();
		}
		
		return array(
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}
}