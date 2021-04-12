<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>




        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb">
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

                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2>已收到您的訂單!</h2>
                        <p class="p16">我們將盡快為您寄出。<br><br></p>
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
                                        <?foreach($cart['products'] as $p){
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
                                        <?}?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="">
                                        <!--coupon-all-->

                                        <!-- <div class="coupon">
                                            <h3>Coupon</h3>
                                            <p>使用優惠碼</p>
                                            <p style="border: 1px solid #ebebeb; background-color: #fff; width: 200px; padding: 5px 10px;">cc820 (折扣200)</p>
                                        </div> -->
                                        <div class="cart-page-total">
                                            <h2></h2>
                                            <ul>
                                                <li>寄送方式:
                                                    <?if($cart['delivery']=='home'){?>郵寄
                                                    <?}?> <span></span>
                                                </li>
                                                <li>付款方式:
                                                    <?if($cart['payment']=='credit'){?>信用卡付款
                                                    <?}?> <span></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="cart-page-total">
                                        <h2>寄送資訊</h2>
                                        <ul>
                                            <li>姓名: <span><?= $cart['username'] ?></span></li>
                                            <li>手機: <span><?= $cart['phone'] ?></span></li>
                                            <li>Email: <span><?= $cart['email'] ?></span></li>
                                            <li>地址: <span><?= $cart['addr'] ?></span></li>
                                            <li>備註: <span><?= $cart['remark'] ?></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="cart-page-total">
                                        <h2>總計</h2>
                                        <ul>
                                            <?if($discount_str!=""){?>
                                            <li><?= $discount_type?>
                                                <span><?= $discount_str ?></span>
                                            </li>
                                            <?}?>
                                            <li>商品金額 <span>$<?= $cart['amount'] + $cart['coupon_discount'] - $cart['fee'] ?></span></li>
                                            <?if($cart['coupon']!=""){?>
                                            <li>優惠碼<?= $cart['coupon'] ?> <span>-$<?= $cart['coupon_discount'] ?></span></li>
                                            <?}?>
                                            <li>郵寄運費 <span>$<?= $cart['fee'] ?></span></li>
                                            <li>總金額 <span>$<?= $cart['amount'] ?></span></li>
                                        </ul>
                                        <!-- <a href="checkout.html" class="proceed-checkout-btn">下一步</a> -->
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->


        <?php include("quote/footer.php"); ?>