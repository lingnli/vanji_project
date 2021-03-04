<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Spgateway_Pay extends CI_Model {


    private $MerchantID =   "MS31015620";
    private $HashKey    =   "JWCKw5isqsQjmCDPPdNX0Jpr8OIT2TmM";
    private $HashIV     =   "PZwm5OOvhEPDgts5";
    private $url        =   "https://ccore.spgateway.com/MPG/mpg_gateway";   //測試
    // private $newebpay_url        =   "https://ccore.spgateway.com/MPG/period";   //測試
    //測試只能一次付清
    
    // private $MerchantID =   "MS3392702247";
    // private $HashKey    =   "NsEv7gvNF48HeB8aDHmwT1QP2LwLXGfN";
    // private $HashIV     =   "PU8VFtL0p9q4QiXC";
    // private $url        =   "https://core.spgateway.com/MPG/mpg_gateway";   //正式
    // private $newebpay_url        =   "https://core.spgateway.com/MPG/period";   //正式

	public function __construct() {
        
    }

    public function pay($paytype, $Email, $price, $order_no, $order_items, $ReturnURL, $NotifyURL){
        $Version         = "1.2";
        $MerchantOrderNo = $order_no;
        
        $RespondType     = "JSON";
        $TimeStamp       = time();
        $CheckValue_str  = "HashKey=".$this->HashKey."&Amt=".$price."&MerchantID=".$this->MerchantID."&MerchantOrderNo=".$order_no."&TimeStamp=".$TimeStamp."&Version=".$Version."&HashIV=".$this->HashIV;
        $CheckValue      = strtoupper(hash("sha256", $CheckValue_str));
        
        $LangType        = "zh-tw";
        $Amt             = $price;
        $ItemDesc        = $order_items;    //商品資訊，長度50字
        $LoginType       = 0;               //智付通會員 (1:需登入、0:不需登入)

        //快速結帳設定
        // $info = $this->db->get_where("user", array("email"=>$Email))->row_array();	
        
        // if($info['TokenTerm']==""){

        //     $str = array();
        //     for ($i=0; $i <= 9; $i++) array_push($str, $i);
        //     for ($i='a'; $i <= 'z'; $i++) array_push($str, $i);
        //     for ($i='A'; $i <= 'Z'; $i++) array_push($str, $i);


        //     $TokenTerm = $info['id'].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$str[rand(0, count($str))].$str[rand(0, count($str))].$str[rand(0, count($str))].rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            

        //     $TokenTermDemand = 3;

        //     //user
        //     $this->db->where(array("id"=>$info['id']))->update('user', array("TokenTerm"=>$TokenTerm));

        // }else{
        //     $TokenTerm = $info['TokenTerm'];
        //     $TokenTermDemand = 3;

        // }


        //credit一次付清
        if ($paytype == "credit") {
            $paytype = "<input type='text' name='CREDIT' value='1'><br>";
        }else if($paytype == "atm"){
            $paytype = "<input type='text' name='VACC' value='1'><br>";
        }else if($paytype == "cvs"){
            $paytype = "<input type='text' name='CVS' value='1'><br>";
        //indtflag value=3 分三期
        }else if($paytype == "instflag"){
            $paytype = "<input type='text' name='InstFlag' value='3'><br>";
        }else if($paytype == "instflag_six"){
            $paytype = "<input type='text' name='InstFlag' value='6'><br>";
        }

        return "
            <form id='pay_form' name='Pay2go' method='post' action='".$this->url."' style='display:none;''>
                <input type='text' name='Email' value='".$Email."'><br>
                ".$paytype."
                <input type='text' name='MerchantID' value='".$this->MerchantID."'><br>
                <input type='text' name='RespondType' value='".$RespondType."'><br>
                <input type='text' name='TimeStamp' value='".$TimeStamp."'><br>
                <input type='text' name='HashKey' value='".$this->HashKey."'><br>
                <input type='text' name='HashIV' value='".$this->HashIV."'><br>
                <input type='text' name='CheckValue' value='".$CheckValue."'><br>
                <input type='text' name='Version' value='".$Version."'><br>
                <input type='text' name='LangType' value='".$LangType."'><br>
                <input type='text' name='MerchantOrderNo' value='".$MerchantOrderNo."'><br>
                <input type='text' name='Amt' value='".$Amt."'><br>
                <input type='text' name='ItemDesc' value='".$ItemDesc."'><br>
                <input type='text' name='ReturnURL' value='".$ReturnURL."'><br>
                <input type='text' name='NotifyURL' value='".$NotifyURL."'><br>
                <input type='text' name='LoginType' value='".$LoginType."'><br>
                
                
                <input type='submit' id='form' value='Submit'>
            </form>
            <script>
                document.getElementById('pay_form').submit();
            </script>
        ";
    }

    public function newebpay( $Email, $price, $order_no, $order_items, $ReturnURL, $order_date){
        
        $Version         = "1.1";
        $MerchantOrderNo = $order_no;
        $RespondType     = "JSON";
        $TimeStamp       = time();
        $CheckValue_str  = "HashKey=".$this->HashKey."&PeriodAmt=".$price."&MerchantID=".$this->MerchantID."&MerOrderNo=".$order_no."&TimeStamp=".$TimeStamp."&Version=".$Version."&HashIV=".$this->HashIV;
        $CheckValue      = strtoupper(hash("sha256", $CheckValue_str));
        $LangType        = "zh-tw";
        $Amt             = $price;
        $ItemDesc        = $order_items;    //商品資訊，長度50字
        $LoginType       = 0;               //智付通會員 (1:需登入、0:不需登入)
        $PeriodType      = "Y";             //每年定期扣款
        $PeriodPoint     = $order_date;     //每年定期扣款日期
        $PeriodTimes     = 99;              //授權期數

        $BackURL = base_url();

        return "
            <form id='pay_form' name='Pay2go' method='post' action='".$this->newebpay_url."' style='display:none;''>                            
                <input type='text' name='MerchantID' value='".$this->MerchantID."'><br>
                <input type='text' name='RespondType' value='".$RespondType."'><br>
                <input type='text' name='TimeStamp' value='".$TimeStamp."'><br>
                <input type='text' name='Version' value='".$Version."'><br>
                <input type='text' name='LangType' value='".$LangType."'><br>
                <input type='text' name='ProdDesc' value='".$ItemDesc."'><br>
                <input type='text' name='PeriodAmt' value='".$Amt."'><br>
                <input type='text' name='PeriodType' value='".$PeriodType."'><br>
                <input type='text' name='PeriodPoint' value='".$PeriodPoint."'><br>
                <input type='text' name='PeriodStartType' value='2'><br>
                <input type='text' name='PeriodTimes' value='".$PeriodTimes."'><br>
                <input type='text' name='ReturnURL' value='".$ReturnURL."'><br>
                <input type='text' name='PayerEmail' value='".$Email."'><br>                            
                <input type='text' name='HashKey' value='".$this->HashKey."'><br>
                <input type='text' name='HashIV' value='".$this->HashIV."'><br>
                <input type='text' name='CheckValue' value='".$CheckValue."'><br>
                <input type='text' name='MerOrderNo' value='".$MerchantOrderNo."'><br>
                <input type='text' name='BackURL' value='".$BackURL."'><br>
                <input type='submit' id='form' value='go'>
            </form>
            <script>
                document.getElementById('pay_form').submit();
            </script>
        ";
    }    
}