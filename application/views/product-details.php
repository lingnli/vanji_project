<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>



        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <? if ($top_bg[7]['cover'] == "") : ?> style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? else : ?> style=" background: url(<?= base_url() . $top_bg[7]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">產品細節</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">全部商品</li>
                            <li class="breadcrumb-item">產品細節</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb product-details-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-6">
                        <div class="product-details-images">
                            <div class="product_details_container">
                                <!-- product_big_images start -->
                                <div class="product_big_images-right">
                                    <div class="portfolio-full-image tab-content">
                                        <? if ($images == array()) { ?>
                                            <div role="tabpanel" class="tab-pane active product-image-position" id="img-tab-5">
                                                <a href="<?= base_url() ?>assets/images/product/details/l01.jpg" class="img-poppu">
                                                    <img src="<?= base_url() ?>assets/images/product/details/l01.jpg" alt="#">
                                                </a>
                                            </div>
                                            <div role="tabpanel" class="tab-pane product-image-position" id="img-tab-6">
                                                <a href="<?= base_url() ?>assets/images/product/details/l02.jpg" class="img-poppu">
                                                    <img src="<?= base_url() ?>assets/images/product/details/l02.jpg" alt="#">
                                                </a>
                                            </div>
                                            <div role="tabpanel" class="tab-pane product-image-position" id="img-tab-7">
                                                <a href="<?= base_url() ?>assets/images/product/details/l03.jpg" class="img-poppu">
                                                    <img src="<?= base_url() ?>assets/images/product/details/l03.jpg" alt="#">
                                                </a>
                                            </div>
                                            <div role="tabpanel" class="tab-pane product-image-position" id="img-tab-8">
                                                <a href="<?= base_url() ?>assets/images/product/details/l04.jpg" class="img-poppu">
                                                    <img src="<?= base_url() ?>assets/images/product/details/l04.jpg" alt="#">
                                                </a>
                                            </div>
                                            <div role="tabpanel" class="tab-pane product-image-position" id="img-tab-9">
                                                <a href="<?= base_url() ?>assets/images/product/details/l03.jpg" class="img-poppu">
                                                    <img src="<?= base_url() ?>assets/images/product/details/l03.jpg" alt="#">
                                                </a>
                                            </div>
                                        <? } else { ?>
                                            <? $i = 0;
                                            foreach ($images as $m) {
                                                if ($i == 0) {
                                            ?>
                                                    <div role="tabpanel" class="tab-pane product-image-position active" id="img-tab-<?= $i ?>">
                                                        <a href="<?= base_url() . $m ?>" class="img-poppu">
                                                            <img src="<?= base_url() . $m ?>" alt="#">
                                                        </a>
                                                    </div>
                                                <? } else { ?>
                                                    <div role="tabpanel" class="tab-pane product-image-position" id="img-tab-<?= $i ?>">
                                                        <a href="<?= base_url() . $m ?>" class="img-poppu">
                                                            <img src="<?= base_url() . $m ?>" alt="#">
                                                        </a>
                                                    </div>
                                            <? }
                                                $i++;
                                            } ?>
                                        <? } ?>
                                    </div>
                                </div>
                                <!-- product_big_images end -->

                                <!-- Start Small images -->
                                <ul class="product_small_images-left vartical-product-active nav" role="tablist">
                                    <? if ($images == array()) { ?>
                                        <li role="presentation" class="pot-small-img active">
                                            <a href="#img-tab-5" role="tab" data-toggle="tab">
                                                <img src="<?= base_url() ?>assets/images/product/details/s01.jpg" alt="#">
                                            </a>
                                        </li>
                                        <li role="presentation" class="pot-small-img">
                                            <a href="#img-tab-6" role="tab" data-toggle="tab">
                                                <img src="<?= base_url() ?>assets/images/product/details/s02.jpg" alt="#">
                                            </a>
                                        </li>
                                        <li role="presentation" class="pot-small-img">
                                            <a href="#img-tab-7" role="tab" data-toggle="tab">
                                                <img src="<?= base_url() ?>assets/images/product/details/s03.jpg" alt="#">
                                            </a>
                                        </li>
                                        <li role="presentation" class="pot-small-img">
                                            <a href="#img-tab-8" role="tab" data-toggle="tab">
                                                <img src="<?= base_url() ?>assets/images/product/details/s04.jpg" alt="#">
                                            </a>
                                        </li>
                                        <li role="presentation" class="pot-small-img">
                                            <a href="#img-tab-9" role="tab" data-toggle="tab">
                                                <img src="<?= base_url() ?>assets/images/product/details/s03.jpg" alt="#">
                                            </a>
                                        </li>
                                    <? } else { ?>
                                        <? $i = 0;
                                        foreach ($images as $m) {
                                            if ($i == 0) {
                                        ?>
                                                <li role="presentation" class="pot-small-img active">
                                                    <a href="#img-tab-<?= $i ?>" role="tab" data-toggle="tab">
                                                        <img src="<?= base_url() . $m ?>" alt="#">
                                                    </a>
                                                </li>
                                            <? } else { ?>
                                                <li role="presentation" class="pot-small-img">
                                                    <a href="#img-tab-<?= $i ?>" role="tab" data-toggle="tab">
                                                        <img src="<?= base_url() . $m ?>" alt="#">
                                                    </a>
                                                </li>
                                        <? }
                                            $i++;
                                        } ?>
                                    <? } ?>

                                </ul>
                                <!-- End Small images -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-6">
                        <!-- product_details_info start -->
                        <div class="product_details_info">
                            <h2><?= $product['name'] ?></h2>
                            <!-- pro_rating start -->

                            <!-- pro_rating end -->
                            <!-- pro_details start -->
                            <div class="pro_details p16">
                                <p><?= $product['sub_title'] ?><br><br></p>
                            </div>
                            <!-- pro_details end -->
                            <!-- pro_dtl_prize start -->
                            <ul class="pro_dtl_prize">
                                <? if ($product['price'] != 0) : ?>
                                    <li class="old_prize"> $<?= $product['price'] ?></li>
                                <? endif; ?>

                                <? if ($all_check == 1) { ?>
                                    <li style="text-decoration: line-through;"> $<?= $product['sale_price'] ?></li>
                                    <li> $<?= $product['sale_price'] * ($all_discount / 100) ?></li>
                                <? } else { ?>
                                    <li> $<?= $product['sale_price'] ?></li>
                                <? } ?>

                            </ul>


                            <form action="<?= base_url() ?>cart/add/<?= $product['id'] ?>" method="post">
                                <div class="product-quantity-action">
                                    <div class="prodict-statas"><span>庫存 :</span></div>
                                    <div class="product-quantity">
                                        <div class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input style="
    width: 50px;" value="<?= $product['number'] ?>" type="number" name="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <ul class="pro_dtl_btn">
                                    <li>

                                        <div class="cart-plus-minus">
                                            <input value="1" type="number" name="quantity" style="    height: 40px;
    width: 50px;">
                                        </div>

                                    </li>
                                    <li><button type="submit" class="buy_now_btn" style="background-color: #fff;border: 1px solid #dddddd;display: block;font-size: 20px;height: 40px;line-height: 40px;text-align: center;">放入購物車</button></li>
                                    <li><a class="heart" data-id="<?= $product['id'] ?>"><i class="ion-heart"></i></a></li>
                                </ul>
                            </form>

                            <div class="pro_social_share d-flex">
                                <button data-id="<?= $product['id'] ?>" class="btn title_2 copy">複製連結</button>
                            </div>
                            <!-- pro_social_share end -->
                        </div>
                        <!-- product_details_info end -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-details-tab mt-60">
                            <ul role="tablist" class="mb-50 nav">
                                <li class="active" role="presentation">
                                    <a data-toggle="tab" role="tab" href="#description" class="active">產品描述</a>
                                </li>

                                <li role="presentation">
                                    <a data-toggle="tab" role="tab" href="#reviews">留言及評論</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="product_details_tab_content tab-content">
                            <!-- Start Single Content -->
                            <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                                <div class="product_description_wrap">
                                    <div class="product_desc mb--30">
                                        <h2 class="title_3">產品細節</h2>
                                        <p class="p16"><?= $product['detail'] ?></p>
                                    </div>
                                    <div class="pro_feature">
                                        <h2 class="title_3">產品特色</h2>
                                        <ul class="feature_list p16">
                                            <?= $product['special'] ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->

                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-7">


                                        <div class="col-lg-12 review_address_inner">
                                            <h5>評論區</h5>

                                            <? foreach ($comment as $c) { ?>
                                                <div class="pro_review">

                                                    <div class="review_details">
                                                        <div class="review_info">
                                                            <h5><?= $c['name'] ?></h5>
                                                            <div class="rating_send">
                                                                <!-- <a href="#">回復</a> -->
                                                            </div>
                                                        </div>
                                                        <div class="review_date">
                                                            <span><?= date("d M , Y H:i", strtotime($c['create_date'])) ?></span>
                                                        </div>
                                                        <p><?= $c['content'] ?></p>

                                                    </div>
                                                </div>

                                                <? if ($c['replay'] != "") { ?>
                                                    <div class="pro_review">
                                                        <div class="review_details" style="padding-left: 120px;">
                                                            <div class="review_info">
                                                                <h5>店長</h5>
                                                                <div class="rating_send">
                                                                    <!-- <a href="#">回復</a> -->
                                                                </div>
                                                            </div>
                                                            <div class="review_date">
                                                                <span><?= date("d M , Y H:i", strtotime($c['update_time'])) ?></span>
                                                            </div>
                                                            <p><?= $c['replay'] ?></p>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>

                                        </div>

                                        <? if ($isLogin == 1) { ?>

                                            <div class="col-lg-12">
                                                <div class="comments-reply-area">
                                                    <h5 class="comment-reply-title mb-30">留言</h5>
                                                    <form id="contactform" method="post" action="<?= base_url() ?>product/comment/<?= $product['id'] ?>" class="comment-form-area">
                                                        <div class="comment-input">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <p class="comment-form">
                                                                        <input type="text" required="required" name="name" placeholder="姓名 *">
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <p class="comment-form">
                                                                        <input type="email" required="required" name="email" placeholder="Email *">
                                                                    </p>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <p class="comment-form-comment">
                                                                        <textarea class="comment-notes" name="content" required="required" placeholder="留言 *"></textarea>
                                                                    </p>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="comment-form-submit">
                                                                        <button class="g-recaptcha comment-submit" type="submit" data-sitekey="6Ld0nzIaAAAAAIJ-eMqmXG4vbNoVSN5rqGLarbiW" data-callback="callback">送出</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <? } ?>
                                        <!--// blog-details-wrapper -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <script>
            $('.copy').on('click', function(e) {
                console.log(123)
                var temp = $('<input>'); // 建立input物件

                $('body').append(temp); // 將input物件增加到body

                var url = `<?= base_url() ?>` + '/product/detail/' + $(this).data('id'); // 取得要複製的連結

                temp.val(url).select(); // 將連結加到input物件value

                document.execCommand('copy'); // 複製

                temp.remove(); // 移除input物件
                alert('連結已複製');
            });

            var is_login = "<?= $is_login ?>";
            //加入最愛
            $(document).on('click', ".heart", function(event) {


                if (is_login == 0) {
                    alert("請先登入，才可以加入最愛");
                    return false;
                }

                var id = $(this).data("id");
                // console.log('id:' + id);

                $.ajax({
                    url: '<?= base_url() ?>/member/add_favorite',
                    data: {
                        id: id,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function(msg) {
                        if (msg.status) {
                            alert('已加入喜愛清單');


                        } else {
                            alert('已加入喜愛清單');
                        }
                    }
                });



            })
        </script>

        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function callback() {
                console.log(123)


                $('#contactform').submit();

                grecaptcha.reset();
            }
        </script>

        <?php include("quote/footer.php"); ?>