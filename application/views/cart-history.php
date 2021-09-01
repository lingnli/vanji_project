<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>




        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <? if ($top_bg[6]['cover'] == "") : ?> style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? else : ?> style=" background: url(<?= base_url() . $top_bg[6]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">我的訂單</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>member/home">會員專區</a></li>
                            <li class="breadcrumb-item">我的訂單</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb cart-page">
            <div class="container">

                <? if ($cart['status'] == 'paid' || ((($cart['status'] == 'pending') || ($cart['status'] == 'cancel')) && $cart['payment'] == 'atm')) { ?>
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form action="#" class="cart-table">
                                <div class="table-content table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="plantmore-product-thumbnail">產品圖</th>
                                                <th class="cart-product-name">產品名稱</th>
                                                <th class="plantmore-product-price">價格</th>
                                                <th class="plantmore-product-quantity">數量</th>
                                                <th class="plantmore-product-subtotal">金額</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($cart['products'] as $p) {
                                                $p['images'] = unserialize($p['images']);
                                            ?>
                                                <tr>
                                                    <td class="plantmore-product-thumbnail"><a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>"><img src="<?= base_url() ?><?= ($p['images'] == array()) ? "assets/images/other/o01.jpg" : $p['images'][0] ?>" alt=""></a></td>
                                                    <td class="plantmore-product-name"><a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>"><?= $p['name'] ?></a></td>
                                                    <td class="plantmore-product-price"><span class="amount">$<?= $p['sale_price'] ?></span></td>
                                                    <td class="plantmore-product-quantity">
                                                        <span><?= $p['quantity'] ?></span>
                                                    </td>
                                                    <td class="product-subtotal"><span class="amount">$<?= $p['sale_price'] * $p['quantity'] ?></span></td>

                                                </tr>
                                            <? } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="">

                                            <div class="cart-page-total">
                                                <h2></h2>
                                                <ul>
                                                    <li>寄送方式：
                                                        <? if ($cart['delivery_status'] == 0) { ?>
                                                            郵寄
                                                        <? } elseif ($cart['delivery_status'] == 1) { ?>
                                                            超商取貨<br> <?= $store_type ?> <?= $store ?>
                                                        <? } ?>
                                                    </li>
                                                    <li>付款方式：
                                                        <? if ($cart['payment'] == 'credit') { ?>
                                                            信用卡一次付清
                                                        <? } else if ($cart['payment'] == 'credit_3') { ?>
                                                            信用卡分三期
                                                        <? } else if ($cart['payment'] == 'atm') { ?>
                                                            【ATM匯款資料】<br>
                                                            銀行代號：<?= $cart['BankCode'] ?><br>
                                                            銀行帳號：<?= $cart['vAccount'] ?><br>
                                                            繳費期限：<?= $cart['ExpireDate'] ?><br>
                                                        <? } ?>
                                                    </li>
                                                    <li>付款狀態：
                                                        <? if ($cart['status'] == 'pending') { ?>
                                                            未轉帳
                                                        <? } elseif ($cart['status'] == 'paid') { ?>
                                                            已付款
                                                        <? } elseif ($cart['status'] == 'cancel') { ?>
                                                            過期未付款已取消
                                                        <? } ?>
                                                    </li>
                                                    <li>出貨狀態：
                                                        <? if ($cart['delivery_success'] == '0') { ?>
                                                            待出貨
                                                        <? } elseif ($cart['delivery_success'] == '1') { ?>
                                                            已出貨
                                                        <? } ?>
                                                    </li>
                                                </ul>

                                                <p class="text-center">您的訂單編號已傳送至您的EMAIL信箱<br>如需查詢訂單狀態請使用訂單查詢功能</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="cart-page-total">
                                            <h2>總計</h2>
                                            <ul style="    margin-bottom: 10px;">
                                                <? if ($discount_str != "") { ?>
                                                    <li><?= $discount_type ?>
                                                        <span><?= $discount_str ?></span>
                                                    </li>
                                                <? } ?>
                                                <li>商品金額 <span>$<?= $cart['amount'] + $cart['coupon_discount'] - $cart['fee'] ?></span></li>
                                                <? if ($cart['coupon'] != "") { ?>
                                                    <li>優惠碼<?= $cart['coupon'] ?> <span>-$<?= $cart['coupon_discount'] ?></span></li>
                                                <? } ?>
                                                <li>郵寄運費 <span>$<?= $cart['fee'] ?></span></li>
                                                <li>總金額 <span>$<?= $cart['amount'] ?></span></li>
                                            </ul>
                                            <p class="mb-2" style="color:red">※完成匯款後截圖訊息至粉絲頁</p>
                                            <div style="color:white;border:none;" class="openn btn btn-primary">粉絲頁收件匣</div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="cart-page-total">
                                            <h2>訂購人資訊</h2>
                                            <ul>
                                                <li>姓名: <span><?= $cart['username'] ?></span></li>
                                                <li>手機: <span><?= $cart['phone'] ?></span></li>
                                                <li>Email: <span><?= $cart['email'] ?></span></li>
                                                <li>地址: <span><?= $cart['addr'] ?></span></li>
                                                <li>備註: <span><?= $cart['remark'] ?></span></li>
                                            </ul>
                                        </div>
                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>

                <? } else { ?>
                    <div class="col-lg-12">
                        <div class="section-title text-center">

                            <h2>信用卡付款失敗！</h2>
                            <p class="p16">請重新下訂此商品後結帳<br><br></p>
                        </div>
                    </div>


                <? } ?>
            </div>
        </div>
        <!-- main-content-wrap end -->


        <?php include("quote/footer.php"); ?>
        <script>
            $(".openn").on('click', function(event) {

                window.location.href = 'https://www.facebook.com/messages/t/949142695176781';




            });
        </script>