<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require  'vendor/autoload.php';


use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Exceptions\RtnException;
use Ecpay\Sdk\Response\ArrayResponse;

class Cvs extends Base_Controller {

	/* 正式c2c */
	private $HashKey    = 'Eg9AvMpW65j2EJNB';
	private $HashIV     = 'CUuk6pXxA9za9LZ1';
	private $MerchantID = 3172126;
	private $map_url = 'https://logistics.ecpay.com.tw/Express/map';

	/* 測試c2c  */
	// private $HashKey    = 'XBERn1YOvpM9nfZc';
	// private $HashIV     = 'h1ONHk4P4yqbl5LK';
	// private $MerchantID = 2000933;
	// private $map_url = 'https://logistics-stage.ecpay.com.tw/Express/map';


	public function __construct(){
		parent::__construct();

	}

	//選擇超商
	public function map($con_choose = false)
	{

		if ($con_choose == false) {
			$this->js_output_and_back("請選擇取貨超商");
			exit();
		}


		try {
			$factory = new Factory([
				'hashKey' => $this->HashKey,
				'hashIv' 	=> $this->HashIV,
				'hashMethod' => 'md5',
			]);

			$autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

			$input = [
				'MerchantID' => $this->MerchantID,
				'MerchantTradeNo' => 'Test' . time(),
				'LogisticsType' => 'CVS',
				'LogisticsSubType' => $con_choose,
				'IsCollection' => 'N',

				// 請參考 example/Logistics/Domestic/GetMapResponse.php 範例開發
				'ServerReplyURL' => base_url().'cart/check',
			];
			$action = $this->map_url;

			echo $autoSubmitFormService->generate($input, $action);
		} catch (RtnException $e) {
			echo '(' . $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
		}
	}

	/*
	超商：取貨商店有問題時回傳
	*/
	public function map_response()
	{
		try {
			$factory = new Factory();
			$response = $factory->create(ArrayResponse::class);
			
			var_dump($response->get($_POST));
		} catch (RtnException $e) {
			echo '(' . $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
		}

	}

}