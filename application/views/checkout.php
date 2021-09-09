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
                                <form action="<?= base_url() ?>cart/pay" method="POST" id='fform'>
                                    <h3 class="shoping-checkboxt-title">寄送資訊</h3>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="single-form-row">
                                                <label>姓名 <span class="required">*</span></label>
                                                <input type="text" name="username" required <? if (get_cookie("username", true)) { ?>value="<?= get_cookie("username", true) ?>" <? } ?>>
                                            </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="single-form-row">
                                                <label>手機 <span class="required">*</span></label>
                                                <input type="text" name="phone" required <? if (get_cookie("phone", true)) { ?>value="<?= get_cookie("phone", true) ?>" <? } ?>>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="single-form-row">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="text" name="email" required <? if (get_cookie("email", true)) { ?>value="<?= get_cookie("email", true) ?>" <? } ?>>
                                            </p>
                                        </div>

                                        <div class="col-lg-12">
                                            <p class="single-form-row">
                                                <label>收件地區 <span class="required">*</span></label>
                                                <input type="text" placeholder=" " name="addr" disabled value="<? if ($area == 'tw') : ?>台灣<? elseif ($area == 'hk') : ?>香港<? elseif ($area == 'sg') : ?>新加玻<? elseif ($area == 'au') : ?>澳門<? elseif ($area == 'ma') : ?>馬來西亞<? endif; ?>">
                                            </p>
                                        </div>
                                        <? if ($delivery == 'home') : ?>
                                            <div class="col-lg-12">
                                                <p class="single-form-row">
                                                    <label>收件地址 <span class="required">*</span></label>
                                                    <input type="text" placeholder=" " name="addr" required>
                                                </p>
                                            </div>
                                        <? endif; ?>
                                        <input type="hidden" name="coupon" value="<?= $coupon_code ?>">
                                        <input type="hidden" name="delivery" value="<?= $delivery ?>">
                                        <input type="hidden" name="payment" value="<?= $payment ?>">
                                        <input type="hidden" name="area" value="<?= $area ?>">





                                        <div class=" col-lg-12">
                                            <p class="single-form-row m-0">
                                                <label>備註</label>
                                                <textarea name="remark" class="remark" placeholder=" " class="checkout-mess" rows="2" cols="5"><? if (get_cookie("remark", true)) { ?><?= get_cookie("remark", true) ?> <? } ?></textarea>
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
                                                <? foreach ($product as $p) { ?>
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            <?= $p['name'] ?><strong class="product-quantity"> × <?= $p['number'] ?></strong>
                                                        </td>
                                                        <td class="product-total">
                                                            <span class="amount">$ <?= $p['number'] * $p['sale_price'] ?></span>
                                                        </td>
                                                    </tr>
                                                <? } ?>

                                                <? if ($coupon != "") { ?>
                                                    <tr class="cart_item">
                                                        <td class="product-name">
                                                            折價券：<?= $coupon['code'] ?><strong class="product-quantity"></strong>
                                                        </td>
                                                        <td class="product-total">
                                                            <span class="amount">- $ <?= $coupon['discount'] ?></span>
                                                        </td>
                                                    </tr>
                                                <? } ?>

                                            </tbody>
                                            <tfoot>

                                                <? if ($discount_str != "") { ?>
                                                    <tr class="cart-subtotal">
                                                        <th style="color:red"><?= $discount_type ?></th>
                                                        <td style="color:red"><span class="amount"><?= $discount_str ?></span></td>
                                                        <input type="hidden" name="discount_type_code" value="<?= $discount_type_code ?>">
                                                        <input type="hidden" name="discount_percent_code" value="<?= $discount_percent_code ?>">
                                                    </tr>
                                                <? } ?>

                                                <tr class="cart-subtotal">
                                                    <th>運費</th>
                                                    <td><span class="amount">$<?= $ship ?></span></td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>訂單總計</th>
                                                    <td><strong><span class="amount">$<?= $total_price_ship ?></span></strong>
                                                    </td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>付款方式</th>
                                                    <td>
                                                        <? if ($payment == 'credit') : ?>
                                                            信用卡一次付清
                                                        <? elseif ($payment == 'credit_3') : ?>
                                                            信用卡分三期
                                                        <? elseif ($payment == 'atm') : ?>
                                                            銀行轉帳
                                                        <? endif; ?>
                                                    </td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>運送方式</th>
                                                    <td>
                                                        <? if ($delivery == 'home') : ?>
                                                            宅配
                                                        <? elseif ($delivery == 'convenient') : ?>
                                                            超商取貨

                                                            <!-- 超商選擇 -->
                                                            <div class="product-short pdd10">
                                                                <select class="nice-select" name="con_choose">
                                                                    <option value="">請選擇取貨超商</option>
                                                                    <option value="UNIMARTC2C">711統一超商</option>
                                                                    <option value="FAMIC2C">全家便利商店</option>
                                                                    <option value="HILIFEC2C">萊爾富便利商店</option>
                                                                    <option value="OKMARTC2C">OK便利商店</option>
                                                                </select>
                                                            </div>

                                                            <div class="product-short pdd10 ">

                                                                <a href="javascript:choosecsv();" class="mx-auto" style="background: #000000;border: 0 none;color: #ffffff;cursor: pointer;display: inline-block;font-size: 12px;font-weight: 600;height: 36px;letter-spacing: 1px;line-height: 36px;padding: 0 14px;text-transform: uppercase;-webkit-transition: 0.3s;transition: 0.3s;width: inherit;">選擇取貨店家</a>
                                                            </div>
                                                            <? if ($shop != array()) : ?>
                                                                <div class="product-short pdd10 ">
                                                                    取貨方式：<?= $shop['store'] ?><br>
                                                                    取貨店家資訊：<?= $shop['CVSStoreName'] ?>
                                                                    <input type="hidden" name="shop[store_MerchantTradeNo]" value="<?= $shop['MerchantTradeNo'] ?>">
                                                                    <input type="hidden" name="shop[LogisticsSubType]" value="<?= $shop['LogisticsSubType'] ?>">
                                                                    <input type="hidden" name="shop[CVSStoreID]" value="<?= $shop['CVSStoreID'] ?>">
                                                                    <input type="hidden" name="shop[CVSStoreName]" value="<?= $shop['CVSStoreName'] ?>">
                                                                    <input type="hidden" name="shop[CVSAddress]" value="<?= $shop['CVSAddress'] ?>">
                                                                    <input type="hidden" name="shop[CVSTelephone]" value="<?= $shop['CVSTelephone'] ?>">
                                                                    <input type="hidden" name="shop[CVSOutSide]" value="<?= $shop['CVSOutSide'] ?>">
                                                                    <input type="hidden" name="shop[ExtraData]" value="<?= $shop['ExtraData'] ?>">
                                                                </div>
                                                            <? endif; ?>

                                                        <? endif; ?>
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
                                                <p><?= $checkout_other ?></p>
                                            </div>
                                            <!-- ACCORDION END -->
                                            <!-- ACCORDION START -->
                                            <h5><br>購買須知</h5>
                                            <div class="payment-content">
                                                <p><?= $checkout_buy ?></p>
                                            </div>
                                            <!-- ACCORDION END -->
                                            <!-- ACCORDION START -->
                                            <h5><br>注意事項</h5>
                                            <div class="payment-content">
                                                <p><?= $checkout_info ?></p>
                                            </div>
                                            <!-- ACCORDION END -->
                                        </div>
                                        <div class="order-button-payment">
                                            <input type="button" class="ssubmit" value="送出訂單">
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


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <script>
            $('.ssubmit').click(function() {
                console.log(123)
                delCookie("username")
                delCookie("phone")
                delCookie("email")
                delCookie("remark")
                $("#fform").submit();
            })

            function choosecsv() {

                createCookie('username', $("input[name=username]").val(), 3);
                createCookie('phone', $("input[name=phone]").val(), 3);

                createCookie('email', $("input[name=email]").val(), 3);
                createCookie('remark', $(".remark").val(), 3);

                // createCookie('delivery', $("#delivery").val(), 3);
                // createCookie('store', $("input[name=store]:checked").val(), 3);
                // console.log($("select[name=con_choose]").val());

                location.href = '<?= base_url() ?>cvs/map/' + $("select[name=con_choose]").val();
                // location.href = '<?= base_url() ?>cart/cvschoose/' + $("select[name=con_choose]").val();

            }

            function delCookie(name) {
                var exp = new Date();
                exp.setTime(exp.getTime() - 1);
                var cval = getCookie(name);
                if (cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
            }

            function getCookie(name) {
                var arr = document.cookie.match(new RegExp("(^| )" + name+  "=([^;]*)(;|$)"));
                if (arr != null) return unescape(arr[2]);
                return null;
            }
            //資料存進cookie
            function createCookie(name, value, days, path) {
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    var expires = "; expires=" + date.toGMTString();
                } else var expires = "";
                document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
            }
        </script>


        <?php include("quote/footer.php"); ?>