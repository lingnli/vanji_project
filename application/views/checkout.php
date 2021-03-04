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
                        <h2 class="breadcrumb-title">結帳</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">購物車</li>
                            <li class="breadcrumb-item">結帳</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb checkout-page">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="coupon-area">
                            <!-- coupon-accordion start -->



                            <!-- coupon-accordion end -->
                            <!-- coupon-accordion start -->

                            <!-- coupon-accordion end -->
                        </div>
                    </div>
                </div>
                <!-- checkout-details-wrapper start -->
                <div class="checkout-details-wrapper">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <!-- billing-details-wrap start -->
                            <div class="billing-details-wrap">
                                <form action="<?= base_url() ?>cart/pay" method="POST">
                                    <h3 class="shoping-checkboxt-title">寄送資訊</h3>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="single-form-row">
                                                <label>姓名 <span class="required">*</span></label>
                                                <input type="text" name="username" required>
                                            </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="single-form-row">
                                                <label>手機 <span class="required">*</span></label>
                                                <input type="text" name="phone" required>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="single-form-row">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="text" name="email" required>
                                            </p>
                                        </div>

                                        <div class="col-lg-12">
                                            <p class="single-form-row">
                                                <label>收件地址 <span class="required">*</span></label>
                                                <input type="text" placeholder=" " name="addr" required>
                                            </p>
                                        </div>

                                        <input type="hidden" name="coupon" value="<?= $coupon_code ?>">
                                        <input type="hidden" name="delivery" value="<?= $delivery ?>">
                                        <input type="hidden" name="payment" value="<?= $payment ?>">





                                        <div class=" col-lg-12">
                                            <p class="single-form-row m-0">
                                                <label>備註</label>
                                                <textarea placeholder=" " class="checkout-mess" rows="2" cols="5"></textarea>
                                            </p>
                                        </div>
                                    </div>

                            </div>
                            <!-- billing-details-wrap end -->
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <!-- your-order-wrapper start -->
                            <div class="your-order-wrapper">
                                <h3 class="shoping-checkboxt-title">訂單詳細資訊</h3>
                                <!-- your-order-wrap start-->
                                <div class="your-order-wrap">
                                    <!-- your-order-table start -->
                                    <div class="your-order-table table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product-name">產品名稱</th>
                                                    <th class="product-total">金額</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?foreach($product as $p){?>
                                                <tr class="cart_item">
                                                    <td class="product-name">
                                                        <?= $p['name'] ?><strong class="product-quantity"> × <?= $p['number'] ?></strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <span class="amount">$ <?= $p['number'] * $p['sale_price'] ?></span>
                                                    </td>
                                                </tr>
                                                <?}?>

                                                <?if($coupon != ""){?>
                                                <tr class="cart_item">
                                                    <td class="product-name">
                                                        折價券：<?= $coupon['code'] ?><strong class="product-quantity"></strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <span class="amount">- $ <?= $coupon['discount'] ?></span>
                                                    </td>
                                                </tr>
                                                <?}?>

                                            </tbody>
                                            <tfoot>

                                                <? if($discount_str != ""){?>
                                                <tr class="cart-subtotal">
                                                    <th style="color:red"><?= $discount_type ?></th>
                                                    <td style="color:red"><span class="amount"><?= $discount_str ?></span></td>
                                                    <input type="hidden" name="discount_type_code" value="<?= $discount_type_code ?>">
                                                    <input type="hidden" name="discount_percent_code" value="<?= $discount_percent_code ?>">
                                                </tr>
                                                <?}?>

                                                <tr class="cart-subtotal">
                                                    <th>運費</th>
                                                    <td><span class="amount">$<?= $ship ?></span></td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>訂單總計</th>
                                                    <td><strong><span class="amount">$<?= $total_price_ship ?></span></strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- your-order-table end -->

                                    <!-- your-order-wrap end -->
                                    <div class="payment-method">
                                        <div class="payment-accordion">
                                            <!-- ACCORDION START -->
                                            <h5>其他提醒</h5>
                                            <div class="payment-content">
                                                <p>我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打高品質的珠寶不應該只適合少數人使用。</p>
                                            </div>
                                            <!-- ACCORDION END -->
                                            <!-- ACCORDION START -->
                                            <h5><br>購買須知</h5>
                                            <div class="payment-content">
                                                <p>我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打高品質的珠寶不應該只適合少數人使用。</p>
                                            </div>
                                            <!-- ACCORDION END -->
                                            <!-- ACCORDION START -->
                                            <h5><br>注意事項</h5>
                                            <div class="payment-content">
                                                <p>我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打高品質的珠寶不應該只適合少數人使用。</p>
                                            </div>
                                            <!-- ACCORDION END -->
                                        </div>
                                        <div class="order-button-payment">
                                            <input type="submit" value="送出訂單">
                                        </div>
                                    </div>
                                    <!-- your-order-wrapper start -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- checkout-details-wrapper end -->
            </div>
        </div>
        <!-- main-content-wrap end -->




        <?php include("quote/footer.php"); ?>