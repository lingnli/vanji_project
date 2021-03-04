<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page_count = 6;
    }

    public function index()
    {
        $this->flow_record("news");

        $this->data['classify'] =  $this->db->select('P.title,count(PD.id) as num,P.id')
        ->from($this->news_classify . " P")
            ->join("news PD", "PD.classify_id = P.id AND PD.is_delete=0", "left")
            ->where('P.is_delete=0')
            ->group_by('P.id')
            ->get()->result_array();

        $this->data['news'] = $this->db->limit(3)->where(array("is_delete" => 0))->order_by('create_date DESC')->get($this->news)->result_array();                   

        // print_r($this->data);exit;

        
        $this->load->view('news', $this->data);
    }

    public function data()
    {        
        $page     = ($this->input->post("page")) ? $this->input->post("page") : 1;
        $search   = ($this->input->post("search")) ? $this->input->post("search") : "";


        $syntax = "P.is_delete = 0";


        //若classify選到特定類別，只顯示對應類別問題	
        if ($search == "") {
            // $syntax .= " AND P.classify = '{$classify}'";
        } else {

            $canbe_search_field = ["P.title"];


            $index = 0;
            $syntax .= " AND (";
            foreach ($canbe_search_field as $field) {
                if ($index > 0) $syntax .= " OR ";
                $syntax .= $field . " LIKE '%" . $search . "%'";
                $index++;
            }
            $syntax .= ")";
        }

        $total = $this->db->from($this->news . " P")
            ->where($syntax)
            ->get()->num_rows();

        $total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

        $list = $this->db->select('P.*,PC.title as classify')
            ->from("news P")            
            ->join("news_classify PC", "P.classify_id = PC.id", "left")                                                
            ->where($syntax)
            ->limit($this->page_count, ($page - 1) * $this->page_count)
            ->get()->result_array();
        

        

        $html = "";

        foreach ($list as $item) {
            $html .= $this->load->view("items/news_item", array(
                "item"      =>    $item                
            ), TRUE);
        }

        if ($html == "") {
            $html .= '<h3 class="text-center">您搜尋的關鍵字無結果，請重新搜尋<h3>';
        }

        $this->output(TRUE, "成功", array(
            "html"       =>    $html,
            "page"       =>    $page,
            "list"       =>    $list,
            "total"       =>    $total,
            "total_page" =>    $total_page,
            "search" => $search
        ));
    }    

    public function classify($id) 
    {
        $this->flow_record("news/classify/" . $id);

        $this->data['classify'] =  $this->db->select('P.title,count(PD.id) as num,P.id')
        ->from($this->news_classify . " P")
            ->join("news PD", "PD.classify_id = P.id AND PD.is_delete=0", "left")
            ->where('P.is_delete=0')
            ->group_by('P.id')
            ->get()->result_array();

        $this->data['news'] = $this->db->limit(3)->where(array("is_delete" => 0))->order_by('create_date DESC')->get($this->news)->result_array();

        $this->data['classify_id'] = $id;
        $this->data['classify_top'] =  $this->db->where(array("is_delete" => 0, 'id' => $id))->get($this->news_classify)->row_array();             

        // print_r($this->data);exit;
        $this->load->view('news-classify',$this->data);
    }

    public function classify_data()
    {
        $classify_id     = ($this->input->post("classify_id")) ? $this->input->post("classify_id") : 1;
        $page     = ($this->input->post("page")) ? $this->input->post("page") : 1;
        $search   = ($this->input->post("search")) ? $this->input->post("search") : "";


        $syntax = "P.is_delete = 0 AND P.classify_id = $classify_id";


        //若classify選到特定類別，只顯示對應類別問題	
        if ($search == "") {
            // $syntax .= " AND P.classify = '{$classify}'";
        } else {

            $canbe_search_field = ["P.title"];


            $index = 0;
            $syntax .= " AND (";
            foreach ($canbe_search_field as $field) {
                if ($index > 0) $syntax .= " OR ";
                $syntax .= $field . " LIKE '%" . $search . "%'";
                $index++;
            }
            $syntax .= ")";
        }

        $total = $this->db->from($this->news . " P")
                ->join("news_classify PC", "P.classify_id = PC.id", "left")
                ->where($syntax)
                ->get()->num_rows();

        $total_page = ($total % $this->page_count == 0) ? floor(($total) / $this->page_count) : floor(($total) / $this->page_count) + 1;

        $list = $this->db->select('P.*,PC.title as classify')
            ->from("news P")
            ->join("news_classify PC", "P.classify_id = PC.id", "left")
            ->where($syntax)
            ->limit($this->page_count, ($page - 1) * $this->page_count)
            ->get()->result_array();




        $html = "";

        foreach ($list as $item) {
            $html .= $this->load->view("items/news_item", array(
                "item"      =>    $item
            ), TRUE);
        }
        // if($html==""){
        //     $html .='<h3 class="text-center">您搜尋的關鍵字無結果，請重新搜尋<h3>';
        // }

        $this->output(TRUE, "成功", array(
            "html"       =>    $html,
            "page"       =>    $page,
            "list"       =>    $list,
            "total"       =>    $total,
            "total_page" =>    $total_page,
            "search" => $search
        ));
    }  

    public function detail($id=false) 
    {
        $this->flow_record("news/detail/" . $id);
        $this->data['menu_active'] = 'news';

        $this->data['classify'] =  $this->db->select('P.title,count(PD.id) as num,P.id')
        ->from($this->news_classify . " P")
            ->join("news PD", "PD.classify_id = P.id AND PD.is_delete=0", "left")
            ->where('P.is_delete=0')
            ->group_by('P.id')
            ->get()->result_array();

        $this->data['news'] = $this->db->limit(3)->where(array("is_delete" => 0))->order_by('create_date DESC')->get($this->news)->result_array();

        //留言

        $comment =  $this->db->select('P.*')
            ->from("news_comment P")
            ->where("P.is_delete = 0 AND P.n_id = $id AND P.is_show = 1")
            ->get()->result_array();


        $news = $this->db->select('P.*')
                        ->from("news P")        
                        ->where("P.is_delete = 0 AND P.id = $id")
                        ->get()->row_array();

        $this->data['news_data'] = $news;
        $this->data['comment'] = $comment;        

        
        $this->load->view('news-detail', $this->data);
    }

    public function comment($n_id)
    {

        if ($_POST) {

            if ($this->input->post("g-recaptcha-response") && $this->input->post("g-recaptcha-response") != "") {

                // 建立CURL連線
                $ch = curl_init();

                // 設定擷取的URL網址
                curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($ch, CURLOPT_HEADER, false);
                //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //設定CURLOPT_POST 為 1或true，表示要用POST方式傳遞
                curl_setopt($ch, CURLOPT_POST, 1);
                //CURLOPT_POSTFIELDS 後面則是要傳接的POST資料。
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    "secret"    =>    "6Ld0nzIaAAAAAFPJtRBNpHQUKSDPBjnOzB4lQehi",
                    "response"    =>    $this->input->post("g-recaptcha-response"),
                    "remoteip"    =>    $this->get_client_ip()
                ));

                // 執行
                $result = curl_exec($ch);

                // 關閉CURL連線
                curl_close($ch);

                $r = json_decode($result, true);

                if (!$r['success']) {

                    $this->js_output_and_back("Validate Error");
                    return;
                }
            } else {
                $this->js_output_and_back("Validate Error");
                return;
            }
            $user_id = $this->session->id;
            if ($user_id == "") {
                $this->js_output_and_redirect("請登入後再進行留言", base_url() . "home/login");
                exit();
            }

            $text_params = ['name', 'email', 'content'];

            foreach ($text_params as $t) {
                $data[$t] = $this->input->post($t);
            }

            if ($data['name'] == "") {
                $this->js_output_and_back("使用者名稱不可為空");
                exit();
            }

            $emailregex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
            if ($data['email'] == "" || !preg_match($emailregex, $data['email'])) {
                $this->js_output_and_back("請確認email格式");
                exit();
            }


            if ($data['content'] == "" || strlen($data['content']) < 20) {
                $this->js_output_and_back("留言內容不可為空或字數少於20字");
                exit();
            }

            $data['user_id'] = $this->session->id;
            $data['n_id'] = $n_id;

            $res = $this->db->insert($this->news_comment, $data);


            if ($res) {

                $this->js_output_and_redirect("已留言成功，請靜待審核", $_SERVER['HTTP_REFERER']);
            } else {
                $this->js_output_and_back("留言發生錯誤，請重新留言！");
            }
        }
    }
}
