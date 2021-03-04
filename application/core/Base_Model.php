<?php defined('BASEPATH') OR exit('No direct script access allowed');


class  Base_Model  extends  CI_Model  {
    //wish
    protected $order_table = "orders";
    protected $wish_table = "order_clients";
    protected $news_table = "news";

    protected $products_classify = "products_classify";
    protected $product = "product";

    protected $news_classify = "news_classify";
    protected $news = "news";
    protected $discount = "discout";

    protected $faq = "faq";
    protected $user = "user";
    protected $priv_menu_table = "privilege_menu";
    protected $priv_table = "privilege";
    protected $member_table = "member";
    protected $carousel = "carousel";
    protected $banner = "banner";
    protected $down = "down";
    protected $design = "design";
    protected $user_product_favorite = "user_product_favorite";
    protected $contact = "contact";
    protected $product_comment = "product_comment";
    protected $news_comment = "news_comment";
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Taipei");
		
	}

    public function timezone_transfrom($time, $timezone){
        $timezone = strtoupper($timezone);
        if ($timezone == 'TW') return $time;

        $t = explode(":", $time);
        $diff = $this->timezone_diff($timezone);
        
        $h = $t[0] - $diff[0];
        $m = $t[1] + 60 - $diff[1];
        if ($m > 60){
            $m -= 60;
            // $h++;
        } 
        if ($m == 60) $m -= 60;
        if ($m < 0){
            $m += 60;
            $h--;   
        } 

        if ($h >= 24) $h -= 24;
        if ($h < 0) $h += 24;
        
        return str_pad($h, 2, '0', STR_PAD_LEFT).":".str_pad($m, 2, '0', STR_PAD_LEFT);
    }

    public function timezone_diff($timezone){
        //TW
        $h = 8;
        $m = 60;

        static $c = FALSE;
        if ($c === FALSE) {
            $c = $this->db->get_where($this->country_table, array("country_code<>"=>"", "time_zone<>"=>""))->result_array("country_code");
        }
        
        $tz = trim(str_replace("UTC", "", str_replace(":", "", $c[$timezone]['time_zone'])));
        if (strlen($tz) == 5) {
            $base = 1;
            if (substr($tz, 0, 1) == '-') $base = -1;
            // echo intval(substr($tz, 1, 2))."<br>";
            // echo intval(substr($tz, 3, 2))."<br>";
            $diff_h = $h - intval(substr($tz, 1, 2)) * $base;
            $diff_m = $m - intval(substr($tz, 3, 2)) * $base;
            // echo $diff_h.", ".$diff_m."<br>";
            if ($diff_m > 60) {
                $diff_h++;
                $diff_m -= 60;
            }
            if ($diff_m == 60) $diff_m = 0;
            
            return array($diff_h, $diff_m);
        }else{
            return array(0, 0);
        }
    }

    private $use_lang = ["tw", "en"];
    public function localized($key, $lang = 'tw'){
        if (!in_array($lang, $this->use_lang)) $lang = 'tw';
        
        $param = array(
            "appoint_site_meeting"        =>  array("en"  =>  "Site Meeting",            "tw"    =>  "現場會議"),
            "appoint_online_meeting"      =>  array("en"  =>  "Online Meeting",          "tw"    =>  "線上會議"),
            "appoint_under_review"        =>  array("en"  =>  "Under Reivew",            "tw"    =>  "審核中"),
            "appoint_to_be_confirmed"     =>  array("en"  =>  "To Be Confirmed",         "tw"    =>  "需審核"),
            "appoint_scheduled"           =>  array("en"  =>  "Scheduled",               "tw"    =>  "會議未開始"),
            "appoint_in_meeting"          =>  array("en"  =>  "In The Meeting",          "tw"    =>  "會議進行中"),
            "appoint_meeting_end"         =>  array("en"  =>  "Closed",                  "tw"    =>  "已結束"),
            "appoint_quest_finished"      =>  array("en"  =>  "Questionnaire Completed", "tw"    =>  "已完成問卷"),
            "appoint_reject"              =>  array("en"  =>  "Rejected",                "tw"    =>  "審核未通過"),
            "appoint_cancel"              =>  array("en"  =>  "Cancel",                  "tw"    =>  "已取消"),
            "appoint_address_by_online"   =>  array("en"  =>  "Click To Get Online Link","tw"    =>  "點選報到取得會議連結"),
            "calendar_find_exhibitor"     =>  array("en"  =>  "Find Exhibitor",          "tw"    =>  "前往找廠商"),
            "calendar_find_buyer"         =>  array("en"  =>  "Find Buyer",              "tw"    =>  "前往找買主"),
            "calendar_available_session"  =>  array("en"  =>  "Available Session",       "tw"    =>  "尚未被報名"),
            "calendar_confirmed"          =>  array("en"  =>  "Confirmed",               "tw"    =>  "已確認"),
            "calendar_meetind_end"        =>  array("en"  =>  "Meeting End",             "tw"    =>  "已結束"),
            "calendar_under_review"       =>  array("en"  =>  "Under Review",            "tw"    =>  "等待審核中"),
            "calendar_to_be_confirmed"    =>  array("en"  =>  "To Be Confirmed",         "tw"    =>  "前往確認"),
            "match_session_status_open"   =>  array("en"  =>  "Open",                    "tw"    =>  "可預約"),
            "match_session_status_booked" =>  array("en"  =>  "Booked",                  "tw"    =>  "已預約"),
            "api_already_exist_match"     =>  array("en"  =>  "You have established an appointment with the other party", "tw"    =>  "您已經與對方建立預約行程"),
        );

        if (!array_key_exists($key, $param)) return $key;

        return $param[$key][$lang];
    }

	public function send_push($os, $registatoin_ids, $message, $data = FALSE) {
        // if ($os == "android") {
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$title = "BBTruck";
        $fields = array('to' => $registatoin_ids);

        //皆為 firebase 平台
        if ($os == "android") {
        	$fields['data'] = array(
				'title'   =>	$title,
				'message' =>	$message
        	);
			if ($data !== FALSE) {
	        	$fields['data'] = array_merge($fields['data'], $data);
	        }        	
        }else if($os == "ios"){
        	$fields['notification'] = array(
				'title' =>	$title , 
				'text'  =>	$message
        	);
        	if ($data !== FALSE) {
	        	$fields['notification'] = array_merge($fields['notification'], $data);
	        }    
        }

        // if ($data !== FALSE) {
        // 	$fields = array_merge($fields, $data);
        // }
 		
        $headers = array(
            'Authorization: key=AAAA9Sg37_w:APA91bFH3jxJe8pkoboujnmqOFGUS1xp0goqlCPvZDzL1KfkFTHUy4wE89UI7inoGv2KZsaI2-1gBIn1qZ1q7mDvHXcR3jV7IoYtv4qyCdX0kl3EDwQbv8SXFxtc9mcHtyByJOtrAeHW',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        $result = json_decode($result, true);

        return $result['success'];
    }

    protected function custom_encrypt($string,$operation,$key='KeyyE'){
        $replcae_str = "_Sl.";
        if($operation=='D'){
            $string = str_replace($replcae_str, "/", $string);
        }
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            $encryt_str = str_replace('=','',base64_encode($result));
            $encryt_str = str_replace("/", $replcae_str, $encryt_str);
            return $encryt_str;
        }
    }

    public function dateStr($date){
        $date = strtotime($date);
        if ((time()-$date)<60*10) {
            //十分鐘內
              return '剛剛';
        } elseif (((time()-$date)<60*60)&&((time()-$date)>=60*10)) {
            //十分鐘~1小時
              $s = floor((time()-$date)/60);
            return  $s."分鐘前";
        } elseif (((time()-$date)<60*60*24)&&((time()-$date)>=60*60)) {
            //1小時～24小時
              $s = floor((time()-$date)/60/60);
            return  $s."小時前";
        } elseif (((time()-$date)<60*60*24*3)&&((time()-$date)>=60*60*24)) {
            //1天~3天
              $s = floor((time()-$date)/60/60/24);
            return $s."天前";
        } else {
            //超过3天
            if (date('Y', strtotime($date)) == date('Y')) {
                //今年
                return date("m/d H:i", $date);
            }else{
                return date("Y/m/d", $date);
            }
        }
    }
}
