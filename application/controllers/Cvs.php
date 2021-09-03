<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require  'vendor/autoload.php';


// use Ecpay\Sdk\Factories\Factory;
// use Ecpay\Sdk\Exceptions\RtnException;
// use Ecpay\Sdk\Response\ArrayResponse;

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


	private $method;

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

			$input = [
				'MerchantID' => $this->MerchantID,
				'MerchantTradeNo' => 'FL' . date('mdHis') . rand(100, 999),
				'LogisticsType' => 'CVS',
				'LogisticsSubType' => $con_choose,
				'IsCollection' => 'N',
				'ServerReplyURL' => base_url().'cart/check',
			];

			$sorted = $this->naturalSort($input);
			$combined = $this->toEncodeSourceString($sorted);
			$encoded = $this->ecpayUrlEncode($combined);
			$hash = $this->generateHash($encoded);
			$checkMacValue = strtoupper($hash);

			$html = '<!DOCTYPE html><html><head><meta charset="utf-8"></head>';
			$html .= '<body>';
			$html .= '<form id="ecpay-form" method="POST" target="_self" action="https://logistics.ecpay.com.tw/Express/map" ><input type="hidden" name="CheckMacValue" value="' . $checkMacValue . '"><input type="hidden" name="IsCollection" value="' . $input["IsCollection"] . '"><input type="hidden" name="LogisticsSubType" value="' . $input["LogisticsSubType"] . '"><input type="hidden" name="LogisticsType" value="CVS"><input type="hidden" name="MerchantID" value="' . $input["MerchantID"] . '"><input type="hidden" name="MerchantTradeNo" value="' . $input["MerchantTradeNo"] . '"><input type="hidden" name="ServerReplyURL" value="' . $input["ServerReplyURL"] . '"></form><script type="text/javascript">document.getElementById("ecpay-form").submit();</script></body></html>
			';


			echo $html;
		} catch (RtnException $e) {
			echo '(' . $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
		}
	}

	public function generateHash($source)
	{
		$hash = '';

		$hash = md5($source);

		return $hash;
	}

	public function ecpayUrlEncode($source)
	{
		$encoded = urlencode($source);
		$lower = strtolower($encoded);
		$dotNetFormat = $this->toDotNetUrlEncode($lower);

		return $dotNetFormat;
	}

	public function toDotNetUrlEncode($source)
	{
		$search = [
				'%2d',
				'%5f',
				'%2e',
				'%21',
				'%2a',
				'%28',
				'%29',
			];
		$replace = [
			'-',
			'_',
			'.',
			'!',
			'*',
			'(',
			')',
		];
		$replaced = str_replace($search, $replace, $source);

		return $replaced;
	}
    
	public function toEncodeSourceString($source)
	{
			$combined = 'HashKey=' . $this->HashKey;
			foreach ($source as $name => $value) {
					$combined .= '&' . $name . '=' . $value;
			}
			$combined .= '&HashIV=' . $this->HashIV;
			return $combined;
	}

	public function naturalSort($source)
	{
		uksort($source, function ($first, $second) {

			return strcasecmp($first, $second);
		});
		return $source;
	}


	//選擇超商
	public function map_test($con_choose = false)
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
				'MerchantTradeNo' => 'Test1111',
				'LogisticsType' => 'CVS',
				'LogisticsSubType' => $con_choose,
				'IsCollection' => 'N',

				// 請參考 example/Logistics/Domestic/GetMapResponse.php 範例開發
				'ServerReplyURL' => base_url() . 'cart/check',
			];
			$action = $this->map_url;
			echo $autoSubmitFormService->generate($input, $action);
		} catch (RtnException $e) {
			echo '(' . $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
		}
	}



	public function autoSubmitJs($formId)
	{
		$js = '<script type="text/javascript">';
		$js .= 'document.getElementById("' . $formId . '").submit();';
		$js .= '</script>';
		return $js;
	}

	/**
	 * 產生自動送出表單
	 *
	 * @param  array  $input
	 * @param  string $action
	 * @param  string $id
	 * @param  string $target
	 * @param  string $submitText
	 * @return string
	 */
	public function generate($input, $action, $target = '_self', $id = 'ecpay-form', $submitText = 'ecpay-button')
	{
		$request = $this->request->toArray($input);
		$html = $this->htmlService->header();
		$html .= '<body>';
		$html .= $this->htmlService->form($request, $action, $target, $id, $submitText);
		$html .= $this->autoSubmitJs($id);
		$html .= '</body>';
		$html .= $this->htmlService->footer();
		return $html;
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