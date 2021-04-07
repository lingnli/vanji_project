<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>

        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <?if($top_bg[6]['cover']=="" ):?>
            style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?else:?>
            style=" background: url(<?= base_url() . $top_bg[6]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?endif;?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">購物車</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">購物車</li>
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
                <div class="row">
                    <div class="col-12">
                        <form class="cart-table" action="<?= base_url() ?>cart/check" method="post">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="plantmore-product-thumbnail">產品圖</th>
                                            <th class="cart-product-name">產品名稱</th>
                                            <th class="plantmore-product-price">價格</th>
                                            <th class="plantmore-product-quantity">數量</th>
                                            <th class="plantmore-product-subtotal">總額</th>
                                            <th class="plantmore-product-remove">刪除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?foreach($product as $p){?>
                                        <tr>
                                            <td class="plantmore-product-thumbnail"><a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>"><img src="<?= base_url() ?><?= ($p['images'] == array()) ? "assets/images/other/o01.jpg" : $p['images'][0] ?>" alt="" style="height:200px;"></a></td>
                                            <td class="plantmore-product-name"><a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>"><?= $p['name'] ?></a></td>
                                            <td class="plantmore-product-price"><span class="amount">$<?= $p['sale_price'] ?></span></td>
                                            <td class="plantmore-product-quantity">
                                                <input id="detailPlus" min=0 value="<?= $p['number'] ?>" type="number" name="number" data-id="<?= $p['id'] ?>" data-price="<?= $p['sale_price'] ?>">
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">$<span class="product_amount_<?= $p['id'] ?>"><?= $p['number'] * $p['sale_price'] ?></span></span>
                                            </td>
                                            <td class="plantmore-product-remove">
                                                <a href="<?= base_url() ?>cart/del/<?= $p['id'] ?>">
                                                    <i class="ion-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?}?>

                                    </tbody>
                                </table>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="coupon-all">

                                        <div class="coupon">
                                            <h3>Coupon</h3>
                                            <p>請輸入優惠代碼</p>
                                            <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">

                                            <div class="coupon-check" style="background: #000000;border: 0 none;color: #ffffff;cursor: pointer;display: inline-block;font-size: 12px;font-weight: 600;height: 36px;letter-spacing: 1px;line-height: 36px;padding: 0 14px;text-transform: uppercase;-webkit-transition: 0.3s;transition: 0.3s;width: inherit;">確認</div>
                                            <!-- <input class="button coupon-check" name="apply_coupon" value=" 確認 " type="submit"> -->
                                            <div class="coupon_discount">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="coupon" name="coupon" value="">
                                <div class="col-md-4">
                                    <div class="cart-page-total">
                                        <h2>購買資訊</h2>
                                        <div class="product-short pdd10">
                                            <select class="nice-select" name="delivery">
                                                <option value="">請選擇運送方式</option>
                                                <!-- <option value="rating">郵寄</option> -->
                                                <!-- <option value="rating">超商取貨</option> -->
                                                <option value="home">宅配</option>
                                            </select>
                                        </div>
                                        <div class="product-short">
                                            <select class="nice-select" name="payment">
                                                <option value="">請選擇付款方式</option>
                                                <!-- <option value="rating">取貨付款</option> -->
                                                <option value="credit">信用卡</option>
                                                <!-- <option value="sales">paypal</option> -->
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cart-page-total">
                                        <h2>小計</h2>
                                        <ul>
                                            <li>金額 $<span class="total_price"><?= $total_price ?></span></li>
                                        </ul>
                                        <div class="al-right">
                                            <button type="submit" class="proceed-checkout-btn">下一步</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <script>
            var count;
            var output = $('.detailOutput');

            //優惠代碼 未
            $(document).on('click', ".coupon-check", function(event) {
                    var coupon = $('#coupon_code').val();

                    console.log(coupon);
                    // //資料送到後端
                    $.ajax({
                        url: '<?= base_url() ?>/cart/coupon_check',
                        data: {
                            coupon: coupon,
                        },
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                            if (data.status) {

                                console.log(data)
                                alert('優惠代碼使用成功')

                                $('.coupon_discount').text('折價$' + data.discount + '元');
                                $('.coupon').val(coupon);

                            } else {
                                alert('請確認優惠代碼')
                            }
                        }
                    });


                }

            );

            //商品數量增減
            $(document).on('click', "#detailPlus", function(event) {
                    var p_id = $(this).data('id');
                    console.log(p_id);

                    var price = $(this).data('price');
                    console.log(price);

                    var num = $(this).val();
                    console.log(num);

                    if (count < 100) {
                        count = parseInt(count) + 1;
                    }
                    // //資料送到後端
                    $.ajax({
                        url: '<?= base_url() ?>/cart/update_amount',
                        data: {
                            p_id: p_id,
                            num: num,
                        },
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                            if (data.status) {

                                // console.log(data)                                

                                $('.product_amount_' + p_id).text(data.product_price);
                                $('.total_price').text(data.total_price);

                            }
                        }
                    });


                }

            );
        </script>

        <?php include("quote/footer.php"); ?>