<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>



        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <? if ($top_bg[5]['cover'] == "") : ?> style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? else : ?> style=" background: url(<?= base_url() . $top_bg[5]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">會員專區</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">會員專區</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->

        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb my-account-page">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="account-dashboard">

                            <div class="row">
                                <div class="col-md-12 col-lg-2">
                                    <!-- Nav tabs -->
                                    <ul role="tablist" class="nav flex-column dashboard-list">
                                        <li><a href="#account-details" data-toggle="tab" class="nav-link">個人資料修改</a></li>
                                        <li> <a href="#password" data-toggle="tab" class="nav-link">密碼修改</a></li>
                                        <li> <a href="#orders" data-toggle="tab" class="nav-link">我的訂單</a></li>
                                        <li><a href="<?= base_url() ?>home/logout" class="nav-link">登出</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-12 col-lg-10">
                                    <!-- Tab panes -->
                                    <div class="tab-content dashboard-content">

                                        <div class="tab-pane fade" id="orders">
                                            <h3>我的訂單</h3>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>訂單編號</th>
                                                            <th>訂購日期</th>
                                                            <th>訂單狀態</th>
                                                            <th>總額</th>
                                                            <th>動作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <? foreach ($order as $o) { ?>
                                                            <tr>
                                                                <td><a href="<?= base_url() ?>cart/payment/<?= $o['order_no'] ?>"><?= $o['order_no'] ?></a></td>
                                                                <td><?= date("Y-m-d", strtotime($o['create_date'])) ?></td>
                                                                <td>
                                                                    <? if ($o['delivery_status'] == 1) { ?>
                                                                        已出貨
                                                                    <? } else { ?>
                                                                        處理中
                                                                    <? } ?>
                                                                </td>
                                                                <td>$<?= $o['amount'] ?></td>
                                                                <td><a href="<?= base_url() ?>cart/payment/<?= $o['order_no'] ?>" class="view">查看</a></td>
                                                            </tr>
                                                        <? } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane " id="password">
                                            <h3>密碼修改 </h3>
                                            <div class="login bg-fqwhite">
                                                <div class="login-form-container">
                                                    <div class="account-login-form">
                                                        <form action="<?= base_url() ?>member/password" method="post">

                                                            <div class="account-input-box">
                                                                <label>舊密碼*</label>
                                                                <input type="text" name="old_password">
                                                                <label>新密碼*</label>
                                                                <input type="text" name="password">
                                                                <label>再次輸入新密碼*</label>
                                                                <input type="text" name="password2">

                                                            </div>

                                                            <div class="button-box">
                                                                <button class="btn default-btn" type="submit">儲存</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane active" id="account-details">
                                            <h3>個人資料修改 </h3>
                                            <div class="login bg-fqwhite">
                                                <div class="login-form-container">
                                                    <div class="account-login-form">
                                                        <form action="<?= base_url() ?>member/save" method="post">

                                                            <div class="account-input-box">
                                                                <label>姓名</label>
                                                                <input type="text" name="name" value="<?= $user['name'] ?>">
                                                                <label>手機</label>
                                                                <input type="text" name="phone" value="<?= $user['phone'] ?>">
                                                                <label>Email</label>
                                                                <input type="text" name="email" value="<?= $user['email'] ?>">
                                                                <label>生日</label>
                                                                <input type="date" name="birthday" max="<?= $today ?>" value="<?= $user['birthday'] ?>">
                                                            </div>
                                                            <div class="example">
                                                                (E.g.: 1970/05/31)
                                                            </div>
                                                            <div class="example">
                                                                ＊欲修改資料請輸入密碼
                                                            </div>
                                                            <div class="account-input-box">
                                                                <label>密碼</label>
                                                                <input type="password" name="password">
                                                                <label>確認密碼</label>
                                                                <input type="password" name="password_confirm">
                                                            </div>
                                                            <div class="button-box">
                                                                <button class="btn default-btn" type="submit">儲存</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->


        <?php include("quote/footer.php"); ?>