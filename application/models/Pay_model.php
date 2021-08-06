<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pay_model extends CI_Model
{

	/*transaction接收EC回傳POST的table

		CREATE TABLE IF NOT EXISTS `transaction` (
		  `id` int(11) NOT NULL,
		  `TradeNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
		  `TradeDate` datetime NOT NULL,
		  `TotalAmount` int(11) NOT NULL,
		  `TradeDesc` longtext COLLATE utf8_unicode_ci NOT NULL,
		  `Payment` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
		  `Items` longtext COLLATE utf8_unicode_ci NOT NULL,
		  `RtnCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `RtnMsg` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `TradeAmt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `PaymentDate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `PaymentType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `PaymentTypeChargeFee` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `SimulatePaid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `CheckMacValue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `paymentinfo` longtext COLLATE utf8_unicode_ci NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

		ALTER TABLE `transaction`
		  ADD PRIMARY KEY (`id`);

		ALTER TABLE `transaction`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
	 */


	/* 測試 */
	// private $HashKey    = '5294y06JbISpM5x9';
	// private $HashIV     = 'v77hoKGq4kWxNNIS';
	// private $MerchantID = 2000132;

	/* 正式 */
	private $HashKey    = 'Eg9AvMpW65j2EJNB';
	private $HashIV     = 'CUuk6pXxA9za9LZ1';
	private $MerchantID = 3172126;
	/* 正式 */

	function __construct()
	{
		parent::__construct();
	}

	public function pay($MerchantTradeNo, $items, $totalAmount, $dec, $payType = "credit", $retureURL = FALSE, $ClientRedirectURL = FALSE, $cvsextend = "CVS", $periodType = "", $periodFrequency = "")
	{
		$this->load->library("ECPay_AllInOne");
		$obj = new ECPay_AllInOne();

		//服務位置-正式
		$obj->ServiceURL  = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5";  	

		//服務位置-測試
		// $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";

		$obj->HashKey     = $this->HashKey;
		$obj->HashIV      = $this->HashIV;
		$obj->MerchantID  = $this->MerchantID;

		$obj->EncryptType = '1';  //CheckMacValue加密類型，請固定填入1，使用SHA256加密

		$expire_time = 60 * 24 * 3; // Expire in 3 days
		$expire_date = 3;           // Expire in 3 days

		//基本參數(請依系統規劃自行調整)
		$obj->Send['ReturnURL']         = $retureURL;			  							//付款完成通知回傳的網址
		$obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                        	//訂單編號
		$obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                     	//交易時間
		$obj->Send['TotalAmount']       = $totalAmount;                             //交易金額
		$obj->Send['TradeDesc']         = $dec;                        				//交易描述
		$obj->Send['PaymentType']		= "aio";	//固定填入aio

		/*
		payType:判斷付款方式
		*/

		//付款方式:全功能
		if ($payType == "all") {
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ALL;

			//付款方式:ATM	
		} else if ($payType == "atm") {
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::ATM;
			$obj->SendExtend['ExpireDate']        = $expire_date;
			// $obj->SendExtend['PaymentInfoURL']    = $ClientRedirectURL;
			//Server 端背景回傳消費者付款方式相關資訊(例：銀行代碼、繳費虛擬帳號繳費期限…等)
			//若設定此參數 ClientRedirectURL 將無用

			$obj->SendExtend['ClientRedirectURL'] = $ClientRedirectURL;
			//若為ATM付款，則會導向此網頁，並夾帶對應參數，可參考function result

			//付款方式:Credit
		} else if ($payType == "credit") {
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit;
			
			//付款方式:Credit_3
		} else if ($payType == "credit_3") {
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit;
			$obj->SendExtend['CreditInstallment'] = '3';

			//定期定額付款
		} else if ($payType == "credit_period") {
			$obj->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit;
			$obj->SendExtend['PeriodAmount'] = $totalAmount;
			$obj->SendExtend['PeriodType'] = $periodType;
			$obj->SendExtend['Frequency'] = $periodFrequency;
			if ($periodType == "D") {
				$obj->SendExtend['ExecTimes'] = 3;	//3天，通常做測試用
			} else if ($periodType == "M") {
				$obj->SendExtend['ExecTimes'] = 36;	//36個月，三年
			} else if ($periodType == "Y") {
				$obj->SendExtend['ExecTimes'] = 3;	//三年
			}
			$obj->SendExtend['PeriodReturnURL'] = $retureURL;

			//超商付款
		} else if ($payType == "cvs") {
			$obj->Send['ChoosePayment']         = ECPay_PaymentMethod::CVS;
			$obj->Send['ChooseSubPayment']		= $cvsextend;
			$obj->SendExtend['ClientRedirectURL'] = $ClientRedirectURL;
			$obj->SendExtend['StoreExpireDate'] = $expire_time;
		}


		$obj->Send['Items']           = $dec;			//訂單的商品資料
		$obj->Send['ItemName']        = $dec;			//訂單的商品資料
		$obj->Send['OrderResultURL']	= $ClientRedirectURL;
		//為付款完成後，綠界科技將頁面導回到合作特店網址，並將付款結果帶回


		// print_r($obj);
		// exit;

		//產生訂單(auto submit至ECPay)
		$obj->CheckOut();

	}



	/*
	 電子發票
	 */
	public function receive($data)
	{
		if ($data['RtnCode'] == '1') {
			$sql = "UPDATE `heycpr_job` AS J 
					LEFT JOIN `transaction` AS T ON J.JobId = T.TradeDesc 
						SET `J`.`PayStatus` = '1'
						WHERE `T`.`TradeNo` = '{$data['MerchantTradeNo']}' ";
			$ret = $this->db->query($sql);
		}

		$this->db->where("TradeNo='" . $data['MerchantTradeNo'] . "'");
		$this->db->update('transaction', array("payreceive" => serialize($data)));

		$sMsg = '';
		require_once('./EC_Pay_assets/Ecpay_Invoice.php');
		$Invoiceobj = new EcpayInvoice;

		# 電子發票參數
		// 2.寫入基本介接參數 
		$Invoiceobj->Invoice_Method 			= 'INVOICE';
		$Invoiceobj->Invoice_Url 			= 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue';	//測試
		$Invoiceobj->MerchantID 			= '2000132';	//測試
		$Invoiceobj->HashKey 			= 'ejCk326UnaZWKisg';	//測試
		$Invoiceobj->HashIV 				= 'q9jcZX8Ib9LM8wYk';	//測試

		/*$ecpay_invoice->Invoice_Url 			= 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue' ;
		$Invoiceobj->MerchantID 			= '' ;
		$Invoiceobj->HashKey 			= '' ;
		$Invoiceobj->HashIV 				= '' ;*/
		$aItems	= array();
		// 商品資訊
		array_push(
			$Invoiceobj->Send['Items'],
			array(
				'ItemName' => '訂金',
				'ItemCount' => 1,
				'ItemWord' => '筆',
				'ItemPrice' => 1,
				'ItemTaxType' => 1,
				'ItemAmount' => 1,
				'ItemRemark' => '測試中'
			)
		);
		$Invoiceobj->Send['RelateNumber']       = $data['MerchantTradeNo'];
		$Invoiceobj->Send['CustomerID']         = '';
		$Invoiceobj->Send['CustomerIdentifier'] = '';
		$Invoiceobj->Send['CustomerName']       = '';
		$Invoiceobj->Send['CustomerAddr']       = '';
		$Invoiceobj->Send['CustomerPhone']      = '';
		$Invoiceobj->Send['CustomerEmail']      = 'wucjasson@gmail.com';
		$Invoiceobj->Send['ClearanceMark']      = '';
		$Invoiceobj->Send['Print']              = '0';
		$Invoiceobj->Send['Donation']           = '2';
		$Invoiceobj->Send['LoveCode']           = '';
		$Invoiceobj->Send['CarruerType']        = '';
		$Invoiceobj->Send['CarruerNum']         = '';
		$Invoiceobj->Send['TaxType']            = 1;
		$Invoiceobj->Send['SalesAmount']        = 1;
		$Invoiceobj->Send['InvoiceRemark']      = 'SDK TEST PHP V1.0.3';
		$Invoiceobj->Send['InvType']            = '07';
		$Invoiceobj->Send['vat']                = '';
		// 4.送出
		$aReturn_Info = $Invoiceobj->Check_Out();
	}

	public function paymentinfo($data)
	{
		$this->db->where("TradeNo='" . $data['MerchantTradeNo'] . "'");
		$this->db->update('transaction', array("paymentinfo" => serialize($data)));
	}




	/*
	超商取貨
	*/

	public function checkMacValue()
	{
		// $sMacValue = str_replace('%2d', '-', $sMacValue);
		// $sMacValue = str_replace('%5f', '_', $sMacValue);
		// $sMacValue = str_replace('%2e', '.', $sMacValue);
		// $sMacValue = str_replace('%21', '!', $sMacValue); 
		// $sMacValue = str_replace('%2a', '*', $sMacValue); 
		// $sMacValue = str_replace('%28', '(', $sMacValue); 
		// $sMacValue = str_replace('%29', ')', $sMacValue);
		return TRUE;
	}

	public function choose_seven($replyURL, $tradeNo = FALSE)
	{
		$isTestMode = 0;
		$szPaymentForm = '';

		$url = ($isTestMode == 1) ? "https://logistics-stage.ecpay.com.tw/Express/map" : "https://logistics.ecpay.com.tw/Express/map";

		$HashKey = $this->HashKey;
		$HashIV = $this->HashIV;
		$MerchantID = $this->MerchantID;

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		$isMobile = 0;
		if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
			$isMobile = 1;
		}

		if ($tradeNo === FALSE) {
			$tradeNo = 'FM' . date('YmdHis');
		}

		$this->load->library("ECPayLogistics");
		// require('./ECPay.Logistics.Integration.php');
		// vendor('ECPAY.ECPAY.Logistics.Integration', '' ,'.php');
		try {
			$AL = new \ECPayLogistics();
			$AL->Send = array(
				'MerchantID' => $MerchantID,
				'MerchantTradeNo' => $tradeNo,
				'LogisticsSubType' => "UNIMARTC2C",
				'IsCollection' => 'Y',
				'ServerReplyURL' => $replyURL,
				'ExtraData' => '',
				'Device' => $isMobile
			);
			// CvsMap(Button名稱, Form target)
			$html = $AL->CvsMap('電子地圖(統一)');
			echo $html . "<script> ECPayForm.submit(); </script>";
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function create_order($bill)
	{
		$tradeNo = 'FM' . rand(10, 99) . strtotime(date("YmdHis")) . rand(10, 99);
		$bill['trade_no'] = $tradeNo;

		$res = $this->db->insert("bill", $bill);
		if ($res) {
			return $tradeNo;
		} else {
			return false;
		}
	}
}
