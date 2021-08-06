<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends Base_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function atm_cron()
	{
		//判斷atm轉帳的訂單是否過期且未付款
		$date = date('Y/m/d');
		
		$syntax = "S.status = 'pending' AND S.payment = 'atm'";
		$syntax .= " AND (S.ExpireDate < '$date')";

		$list = $this->db->select("S.*")
			->from($this->order . " S")
			->where($syntax)
			->get()->result_array();
		
		if($list){
			foreach ($list as $l) {
				$products = unserialize($l['products']);
	
				foreach ($products as $p) {
					$product_id = $p['id'];
					$product = $this->db->where(array("id" => $product_id))->get($this->product)->row_array();
					$data = [
						'number' => $product['number'] + $p['quantity']
					];
	
					$this->db->where(array("id" => $product_id))->update($this->product, $data);
				}
				$this->db->where(array("id" => $l['id']))->update($this->order, array('status' => 'cancel'));
			}
		}else{
			echo '無資料';
		}


		
		
	}


}
