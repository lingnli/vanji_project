<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_logistic extends CI_Model {
	/* 正式c2c */
	private $HashKey    = 'Eg9AvMpW65j2EJNB';
	private $HashIV     = 'CUuk6pXxA9za9LZ1';
	private $MerchantID = 3172126;

	/* 測試c2c  */
	// private $HashKey    = 'XBERn1YOvpM9nfZc';
	// private $HashIV     = 'h1ONHk4P4yqbl5LK';
	// private $MerchantID = 2000933;
	// private $gateway_url = "https://logistics-stage.ecpay.com.tw/Express/Create";

	function __construct()
	{
		parent::__construct();
	}

	public function store_pay($trade_no, $sender, $bill, $isCollection, $server_reply, $logistics_c2c_server_reply, $LogisticsType = 'CVS', $LogisticsSubType = '')
	{


		/*
			trade_no										訂單編號
			bill 												訂單資訊 即存進db的資料
			isCollection 								是否取貨付款 
			server_reply 								物流狀態都會透過此 URL 通知。	
			logistics_c2c_server_reply	當 User 選擇取貨門市有問題時，會透過此 URL 通知特店，請特店通知 	 
																	User 重新選擇門市。
			LogisticsType 							物流類型 CVS:超商取貨, Home:宅配
			LogisticsSubType 				

			---B2C---
			FAMI:全家
			UNIMART:統一超商
			HILIFE:萊爾富
			---C2C---
			FAMIC2C:全家店到店
			UNIMARTC2C:統一超商交貨便 HILIFEC2C:
			萊爾富店到店
			---HOME---
			TCAT:黑貓
			ECAN:宅配通
			注意事項:
			1. 訂單有效日如下：
			FAMIC2C-建立訂單起 6 天；UNIMARTC2C、HILIFEC2C-建立訂單起7 天。
		*/
		// $f = fopen("log.txt", "a+");

		$this->load->library("ECPayLogistics");

		try {
			$product = "";
			foreach (unserialize($bill['products']) as $item) {
				if ($product != "") $product .= "#";
				$product .= $item['name'] . "x" . $item['quantity'];
			}
			$product = str_replace(" ", "", $product);
			if (mb_strlen($product) > 50) {
				$product = mb_substr($product, 0, 49);
			}

			$AL = new \ECPayLogistics();
			$AL->HashKey = $this->HashKey;
			$AL->HashIV = $this->HashIV;


			$send_data = array(
				'MerchantID'           => $this->MerchantID,
				'MerchantTradeNo'      =>
				date('YmdHis'),
				'MerchantTradeDate'    => date('Y/m/d H:i:s'),
				'LogisticsType'        => $LogisticsType,
				'LogisticsSubType'     => $LogisticsSubType,
				'GoodsAmount'          => intval($bill['amount']),
				'CollectionAmount'     => intval($bill['amount']),
				'IsCollection'         => $isCollection,
				'GoodsName'            => $product,
				'SenderName'           => $sender['username'],
				'SenderPhone'          => $sender['phone'],
				'SenderCellPhone'      => $sender['phone'],
				'ReceiverName'         => mb_substr($bill['username'], 0, 5, 'utf-8'),
				// 'ReceiverPhone'        => $bill['tel'],
				'ReceiverCellPhone'    => $bill['phone'],
				'ReceiverEmail'        => $bill['email'],
				'TradeDesc'            => $product,
				'ServerReplyURL'       => $server_reply,
				'LogisticsC2CReplyURL' => $logistics_c2c_server_reply,
				'Remark'               => $bill['remark'],
				'PlatformID'           => ''
			);

			$AL->Send = $send_data;
			
			if ($LogisticsType == "CVS") {
				$store = unserialize($bill['convenient_data']);

				$AL->SendExtend = array(
					//正式
					'ReceiverStoreID' => $store['CVSStoreID']
					//測試
					// 'ReceiverStoreID' => '991182'
				);
			}

			$Result = $AL->BGCreateShippingOrder();

			print_r($Result);
			exit;


			if ($Result['ResCode'] == 1) {

				// fwrite($f, "logistics: \n".date("Y-m-d H:i:s")."\n".json_encode($Result)."\n\n");

				$data = array(
					"trade_no"    =>  $Result['MerchantTradeNo'],
					"data"        =>  serialize($Result),
					"status"      =>  $Result['RtnMsg'],
					"action"      =>  "create"
				);
				$this->db->insert("logistics", $data);
				return array("status" => "success");
			} else {
				$data = array(
					"trade_no"    =>  $Result['MerchantTradeNo'],
					"data"        =>  serialize($Result),
					"status"      =>  $Result['RtnMsg'],
					"action"      =>  "err"
				);
				$this->db->insert("logistics", $data);
				return array("status" => "fail", "msg" => "Create bill fail");
			}
			// echo '<pre>' . print_r($Result, true) . '</pre>';
			// Array
			// (
			//     [ResCode] => 1
			//     [AllPayLogisticsID] => 2610630
			//     [BookingNote] => 
			//     [CheckMacValue] => C8ADE69419376E0DF271D3018E929CBA
			//     [CVSPaymentNo] => J7693721
			//     [CVSValidationNo] => 0644
			//     [GoodsAmount] => 730
			//     [LogisticsSubType] => UNIMARTC2C
			//     [LogisticsType] => CVS
			//     [MerchantID] => 3013942
			//     [MerchantTradeNo] => CV201710180129556337
			//     [ReceiverAddress] => 
			//     [ReceiverCellPhone] => 0975273573
			//     [ReceiverEmail] => 
			//     [ReceiverName] => anbon
			//     [ReceiverPhone] => 0975273573
			//     [RtnCode] => 300
			//     [RtnMsg] => 訂單處理中(已收到訂單資料)
			//     [UpdateStatusDate] => 2017/10/18 01:29:56
			// )
		} catch (Exception $e) {

			// 	fwrite($f, "============ \n");
			// fwrite($f, "logistics err: \n".date("Y-m-d H:i:s")."\n".$e->getMessage()."\n\n");
			// fclose($f);
			return array("status" => "error", "msg" => $e->getMessage());
		}
	}



	//選便利商店門市
	public function choose_store($Logistics_type, $IsCollection, $redirectURL)
	{

		// print_r($redirectURL);exit;

		$isMobile = ($this->is_moblie()) ? 1 : 0;


		$this->load->library("ECPayLogistics");

		try {


			$AL = new \ECPayLogistics();
			$AL->Send = array(
				'MerchantID' => $this->MerchantID,
				'MerchantTradeNo' => 'FL' . date('mdHis') . rand(100, 999),
				'LogisticsSubType' => $Logistics_type,
				'IsCollection' => $IsCollection,
				'ServerReplyURL' => $redirectURL . '#redirect',
				'ExtraData' => '',
				'Device' => $isMobile
			);



			$html = $AL->CvsMap('電子地圖');



			echo $html . "<script> ECPayForm.submit(); </script>";
		} catch (Exception $e) {



			echo $e->getMessage();
		}
	}

	private function is_moblie()
	{
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
			return TRUE;
		}
		return FALSE;
	}
}