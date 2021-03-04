
<body class="skin-default">
<div class="preloader">
    <div class="loader_img"><img src="img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="<?=base_url() ?>mgr/" class="logo" style="color:#FFF; font-size: 24px;">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <!-- <img src="img/header.png" alt="logo" style="height:44px;"/> -->
            梵日珠寶管理系統
        </a>
        <!-- Header Navbar: style can be found in header-->
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                    class="fa fa-fw ti-menu"></i>
            </a>
        </div>

        <div id="toggle_exhibit">
            <ul class="nav navbar-nav">

            </ul>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=base_url() ?>" target="_blank"><div class="riot" style="padding-left: 0;"><i class="fa fa-fw fa-bolt"></i>觀看前台</div></a>
                </li>
                <!-- <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-fw ti-bell black"></i>
                        
                        <span class="label label-danger">&nbsp;</span>
                        
                    </a>
                    <ul class="dropdown-menu dropdown-messages table-striped" tabindex="0" style="overflow: hidden; outline: none;">
                        <li class="dropdown-title">今日の通知</li>
                        <li>
                            <a href="javascript:void(0);" class="message striped-col">
                                <div class="message-body"><strong>今日有一組會議未執行</strong>
                                    <br>
                                    廠商： XXX<br>
                                    買主： OOO
                                    <br>
                                    <small style="color: #AAA;">12:00</small>
                                    <? //if ($item['is_read'] == 0): ?>
                                    <span class="label label-danger label-mini msg-lable">New</span>
                                    <? //endif; ?>
                                </div>
                            </a>
                        </li>
                        <? //endforeach; ?>
                        <li class="dropdown-footer"><a href="<?=base_url() ?>mgr/">查看所有通知</a></li>
                    </ul>

                </li> -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle padding-user" data-toggle="dropdown">
                        <!-- <img src="<?=$this->session->avatar ?>" width="35" class="img-circle img-responsive pull-left"
                             height="35" alt="User Image"> -->
                        <div class="riot" style="padding: 5px;">
                            <div>
                                <?=$this->session->name ?>
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto;">
                            <!-- <img src="<?=$this->session->avatar ?>" class="img-circle" alt="User Image"> -->
                            <p> <?=$this->session->name ?><br><?=$this->session->priv_name ?></p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="p-t-3">
                            <a href="#">
                                <i class="fa fa-fw ti-user"></i> 個人資料
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            <a href="#">
                                <i class="fa fa-fw ti-settings"></i> 帳號設定
                            </a>
                        </li> -->
                        <li>
                            <a href="<?=base_url() ?>mgr/dashboard/changepwd">
                                <i class="fa fa-fw ti-settings"></i> 修改密碼
                            </a>
                        </li>
                        <li role="presentation" class="divider"></li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?=base_url() ?>mgr/lock">
                                    <i class="fa fa-fw ti-lock"></i>
                                    鎖定
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=base_url() ?>mgr/logout">
                                    <i class="fa fa-fw ti-shift-right"></i>
                                    登出
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">
                <div class="nav_profile">
                    <div class="media profile-left">
                        <!-- <a class="pull-left profile-thumb" href="#">
                            <img src="<?=$this->session->avatar ?>" class="img-circle" alt="User Image">
                        </a> -->
                        <div class="content-profile text-center">
                            <h4 class="media-heading">
                                <?=$this->session->name ?><br>
                                <span><?=$this->session->priv_name ?></span>
                            </h4>
                            <ul class="icon-list" style="padding: 0;">
                                <li><a href="<?=base_url() ?>mgr/lock"> <i class="fa fa-fw ti-lock"></i> </a></li>
                                <li><a href="<?=base_url() ?>mgr/dashboard/changepwd"> <i class="fa fa-fw ti-settings"></i> </a></li>
                                <li>
                                    <a href="<?=base_url() ?>mgr/logout">
                                        <i class="fa fa-fw ti-shift-right"></i>
                                    </a>
                                </li>
                            </ul>
                            <!-- <select onchange="gotoBrandPage(this)" class="select2" style="width: 100%;">
                                <option value="">FD_2020┃2020食品展</option>
                                <option value="">BY_2020┃2020腳踏車零件展</option>
                            </select> -->
                        </div>
                    </div>
                </div>
                <?
                    // $item = array(
                    //     // "home1"          =>  array("廠商現場報到", "ti-folder", 0),
                    //     // "home2"          =>  array("買主現場報到", "ti-folder", 0),
                    //     // "home3"          =>  array("異動作業", "ti-folder", 0),
                    //     // "home4"          =>  array("報表查詢", "ti-folder", 0),
                    //     // "home5"          =>  array("位置圖", "ti-folder", 0),
                    //     // "hr"    =>  array(),
                    //     "exhibit"         =>  array("Event列表", "icon/event.png", 0),
                    //     "meeting"         =>  array("採洽會議管理", "icon/meeting.png", 0,
                    //         array(
                    //             // "meeting/add"     =>  array("新增會議", "ti-package", 0),
                    //             "meeting"         =>  array("會議列表", "ti-package", 0),
                    //             "meeting/session" =>  array("會議場次維護", "ti-package", 0),
                    //             "schedule"  =>  array("與會人員管理", "ti-package", 0),
                    //             "schedule_site"  =>  array("設定現場買主", "ti-package", 0),
                    //         )
                    //     ),
                    //     "buyer"         =>  array("買主資料管理", "icon/buyer.png", 0,
                    //         array(
                    //             "buyer/add"         =>  array("新增買主", "ti-package", 0),
                    //             "buyer" =>  array("買主列表", "ti-package", 0),
                    //             "buyer/validate"    =>  array("買主資料審核", "ti-package", 'x'),
                    //             // "buyer/import"    =>  array("買主資料匯入", "ti-package", 0),
                    //         )
                    //     ),
                    //     "exhibitor"         =>  array("廠商資料管理", "icon/exhibitor.png", 0,
                    //         array(
                    //             "exhibitor/add"         =>  array("新增廠商", "ti-package", 0),
                    //             "exhibitor" =>  array("廠商列表", "ti-package", 0),
                    //             // "exhibitor/session"    =>  array("廠商資料審核", "ti-package", 'x'),
                    //             // "exhibitor/import"    =>  array("廠商資料匯入", "ti-package", 0),
                    //         )
                    //     ),
                    //     "webex"         =>  array("視訊會議管理", "icon/webex.png", 0,
                    //         array(
                    //             "https://globalpage-prod.webex.com/signin" =>  array("Cisco Webex", "ti-package", 0),
                    //             "webex"  =>  array("視訊會議列表", "ti-package", 0),
                    //             "webex/monitor"  =>  array("視訊會議監控", "ti-package", 0)
                    //         )
                    //     ),
                    //     "quest"         =>  array("問卷資料管理", "icon/quest.png", 0,
                    //         array(
                    //             "https://www.surveycake.com/admin/tw/"    =>  array("SurveyCake", "ti-package", 0),
                    //             "quest/list"   =>  array("問卷列表", "ti-package", 0),
                    //             // "quest/cron"   =>  array("問卷派送及排程", "ti-package", 'x'),
                    //             "quest/answer" =>  array("問卷答案管理", "ti-package", 'x')
                    //         )
                    //     ),
                    //     "mailer"         =>  array("信件管理", "icon/mailer.png", 0,
                    //         array(
                    //             "mailer/add" =>  array("新增信件範本", "ti-package", 0),
                    //             "mailer" =>  array("信件範本列表", "ti-package", 0),
                    //             "mailer/cron" =>  array("信件派送與排程", "ti-package", 0),
                    //             "mailer/log" =>  array("信件LOG", "ti-package", 0)
                    //         )
                    //     ),
                    //     "report"         =>  array("報表查詢", "icon/report.png", 0,
                    //         array(
                    //             "quest/add" =>  array("報表1", "ti-package", 'x'),
                    //             "quest/list" =>  array("報表2", "ti-package", 'x'),
                    //             "quest/list" =>  array("報表3", "ti-package", 'x'),
                    //             "quest/list" =>  array("報表4", "ti-package", 'x')
                    //         )
                    //     ),
                    //     "priv"         =>  array("帳號權限管理", "icon/privilege.png", 0,
                    //         array(
                    //             "member" =>  array("帳號管理", "ti-package", 0),
                    //             "priv"   =>  array("權限管理", "ti-package", 0)
                    //         )
                    //     ),
                    //     "system"         =>  array("系統管理", "icon/system.png", 0,
                    //         array(
                    //             "system" =>  array("API管理", "ti-package", 0),
                    //             "operate"   =>  array("系統操作記錄", "ti-package", 0)
                    //         )
                    //     )

                        
                    // );

                    // $sort = 1;
                    // foreach ($item as $key => $obj) {
                    //     $this->db->insert("privilege_menu", array(
                    //         "sort"      =>  $sort++,
                    //         "parent_id" =>  0,
                    //         "name"      =>  $obj[0],
                    //         "icon"      =>  $obj[1],
                    //         "url"       =>  (isset($obj[3]))?"":$key,
                    //         "function"  =>  strtoupper($key),
                    //         "status"    =>  "on"
                    //     ));

                    //     $parent_id = $this->db->insert_id();
                    //     if (isset($obj[3])) {
                    //         $sub_obj_sort = 1;
                    //         foreach ($obj[3] as $sub_key => $sub_obj) {
                    //             $this->db->insert("privilege_menu", array(
                    //                 "sort"      =>  $sub_obj_sort++,
                    //                 "parent_id" =>  $parent_id,
                    //                 "name"      =>  $sub_obj[0],
                    //                 "icon"      =>  $sub_obj[1],
                    //                 "url"       =>  $sub_key,
                    //                 "function"  =>  strtoupper($sub_key),
                    //                 "status"    =>  "on"
                    //             ));
                    //         }
                    //     }
                    // }
                ?>
                <ul class="navigation">
                    <li<?=($active=="dashboard")?' class="active"':"" ?>>
                        <a href="<?=base_url() ?>mgr">
                            <!-- <i class="menu-icon ti-desktop"></i> -->
                            <img src="icon/dashboard.png" style="width: 16px; margin: 3px;">
                            <span class="mm-text ">主控版</span>
                        </a>
                    </li>
                    <?
                        foreach ($nav as $obj) {
                            $func = $obj['function'];

                            if ($func == "hr") {
                                echo '</ul><hr><ul class="navigation">';
                                continue;
                            }
                    ?>
                        <li class="menu-dropdown<?=($active==$func)?' active':"" ?>">
                            <a href="<?=($obj['url']=="")?"#":base_url()."mgr/".$obj['url'] ?>">
                                <? if (strpos($obj['icon'], "png") !== FALSE): ?>
                                <img src="<?=$obj['icon'] ?>" style="width: 16px; margin: 3px;">
                                <? else: ?>
                                <i class="menu-icon <?=$obj['icon'] ?>"></i>
                                <? endif; ?>
                                <span class=""><?=$obj['name'] ?></span>
                                <? if (count($obj['sub_menu']) > 0): ?>
                                <span class="fa arrow"></span>
                                <? endif; ?>
                                <? if($obj['badge'] > 0){ ?>
                                <small class="badge" style="margin: 0 5px;"><?=$obj['badge'] ?></small>
                                <? }else if(!is_numeric($obj['badge'])){ ?>
                                <small class="badge" style="margin: 0 5px; background-color: #FE9BB1;"><?=$obj['badge'] ?></small>
                                <? } ?>
                            </a>
                            <? if (count($obj['sub_menu']) > 0): ?>
                                <ul class="sub-menu">
                                <?
                                    foreach ($obj['sub_menu'] as $sub_obj) {
                                        $sub_func = $sub_obj['function'];
                                ?>
                                <li<?=(isset($sub_active) && $sub_active == $sub_func)?' class="active"':'' ?>>
                                    <? if (substr($sub_obj['url'], 0, 4) == "http"): ?>
                                    <a href="<?=$sub_obj['url'] ?>" target="_blank">
                                    <? else: ?>
                                    <a href="<?=base_url()."mgr/".$sub_obj['url'] ?>">
                                    <? endif; ?>
                                        <?=$sub_obj['name'] ?>
                                        <? if($sub_obj['badge'] > 0){ ?>
                                        <small class="badge" style="margin: 0 5px;"><?=$sub_obj['badge'] ?></small>
                                        <? }else if(!is_numeric($sub_obj['badge'])){ ?>
                                        <small class="badge" style="margin: 0 5px; background-color: #FE9BB1;"><?=$sub_obj['badge'] ?></small>
                                        <? } ?>
                                    </a>
                                </li>

                                <?
                                    }
                                ?>
                                </ul>
                            <? endif; ?>
                        </li>
                    <?
                        }
                    ?>
                </ul>
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>