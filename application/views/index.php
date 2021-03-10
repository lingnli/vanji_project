<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>


        <!-- 輪播圖 -->
        <div class="hero-slider hero-slider-one">
            <?foreach($carousel as $c){?>
            <?if($c['cover']==""){?>
            <div class="single-slide" style="background-image: url(<?= base_url() ?>assets/images/slider/s02.JPG)"></div>
            <?}else{?>
            <div class="single-slide" style="background-image: url(<?= base_url() . $c['cover'] ?>)"></div>
            <?}?>

            <?}?>

        </div>
        <!-- Hero Section End -->

        <!-- 主打商品 -->
        <div class="porduct-area section-pt section-pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="section-title text-center">
                            <h2 data-aos="fade-up">主打商品</h2>
                            <p class="p16">我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打高品質的珠寶不應該只適合少數人使用。</p>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <?foreach($top as $t){?>
                    <div class="col-lg-3">

                        <div class="single-product-wrap">

                            <div class="product-image" style="display: flex; justify-content: center;">
                                <div class="shape-outer octagon2-none">
                                    <div class="shape-inner-none octagon2-none">
                                        <a href="<?= base_url() ?>product/detail/<?= $t['id'] ?>">
                                            <?
                                        $cover = unserialize($t['images']);
                                        
                                        if($cover==array()){?>
                                            <img src="<?= base_url() ?>assets/images/product/p1.jpg" alt="Produce Images">
                                            <?}else{?>
                                            <img src="<?= base_url() . $cover[0] ?>" alt="Produce Images">
                                            <?}?>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-action">
                                    <a href="<?= base_url() ?>cart/add/<?= $t['id'] ?>" class="add-to-cart"><i class="ion-bag"></i></a>
                                    <a class="wishlist heart" data-id="<?=$t['id']?>"><i class="ion-android-favorite-outline"></i></a>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="<?= base_url() ?>product/detail/<?= $t['id'] ?>"><?= $t['name'] ?></a></h3>
                                <div class="price-box">
                                    <span class="old-price">$<?= $t['price'] ?></span>
                                    <span class="new-price">$<?= $t['sale_price'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>


                </div>
            </div>
        </div>
        <!-- Start Product End -->

        <!--中間 -->
        <div class="banner-area section-pb">
            <div class="container-fluid">
                <div class="row">

                    <?foreach($banner as $b){?>
                    <div class="col-lg-4 col-md-6 h-100 d-flex justify-content-center">
                        <!-- Single Banner Start -->
                        <div class="single-banner mt-30">
                            <?if($b['cover']==""){?>
                            <img src="<?= base_url() ?>assets/images/banner/b01.jpg" alt="">
                            <?}else{?>
                            <img src="<?= base_url() . $b['cover'] ?>" alt="">
                            <?}?>
                            <div class="banner-content text-center">
                                <div class="banner-content-box">
                                    <h4><?= $b['title'] ?></h4>
                                    <p class="p16"><?= $b['sub_title'] ?></p>
                                    <a href="<?= base_url() ?>product" class="p16">現在去選購</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Banner End -->
                    </div>
                    <?}?>

                </div>
            </div>
        </div>
        <!-- Banner Area End -->

        <!-- Start Product Area -->
        <div class="porduct-area section-pb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="section-title text-center">
                            <h2 data-aos="fade-up">精選商品</h2>
                            <p class="p16">我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打高品質的珠寶不應該只適合少數人使用。</p>
                        </div>
                    </div>
                </div>

                <div class="row product-two-row-4">

                    <?foreach($second as $t){?>
                    <div class="col-lg-12">

                        <div class="single-product-wrap">

                            <div class="product-image" style="display: flex; justify-content: center;">
                                <div class="shape-outer octagon2-none">
                                    <div class="shape-inner-none octagon2-none">
                                        <a href="<?= base_url() ?>product/detail/<?= $t['id'] ?>">
                                            <?
                                        $cover = unserialize($t['images']);
                                        
                                        if($cover==array()){?>
                                            <img src="<?= base_url() ?>assets/images/product/p1.jpg" alt="Produce Images">
                                            <?}else{?>
                                            <img src="<?= base_url() . $cover[0] ?>" alt="Produce Images">
                                            <?}?>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-action">
                                    <a href="<?= base_url() ?>cart/add/<?= $t['id'] ?>" class="add-to-cart"><i class="ion-bag"></i></a>
                                    <a class="heart wishlist" data-id="<?=$t['id']?>"><i class="ion-android-favorite-outline"></i></a>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="<?= base_url() ?>product/detail/<?= $t['id'] ?>"><?= $t['name'] ?></a></h3>
                                <div class="price-box">
                                    <span class="old-price">$<?= $t['price'] ?></span>
                                    <span class="new-price">$<?= $t['sale_price'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>



                </div>
            </div>
        </div>
        <!-- Start Product End -->



        <?php include("quote/speaker.php"); ?>

        <!-- Blog Area Start -->
        <div class="blog-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="section-title text-center">
                            <h2 data-aos="fade-up">最新消息</h2>
                            <p class="p16">我們認為高品質的珠寶不應該只適合少數人使用，因此我們在提供合理價格的同時珠寶主打
                                高品質的珠寶不應該只適合少數人使用。</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?foreach($news as $n){?>
                    <div class="col-lg-6 col-md-6">
                        <!-- single-blog Start -->
                        <div class="single-blog mt-30">
                            <div class="blog-image">
                                <a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>">
                                    <?if($n['cover']==""){?>
                                    <img src="<?= base_url() ?>assets/images/blog/b01.png" alt="">
                                    <?}else{?>
                                    <img src="<?= base_url() . $n['cover'] ?>" alt="">
                                    <?}?>
                                </a>
                                <div class="meta-tag">
                                    <p><?= date("d/M", strtotime($n['date'])) ?></p>
                                </div>
                            </div>

                            <div class="blog-content">
                                <h4><a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>"><?= $n['title'] ?></a></h4>
                                <p class="p16"><?= mb_substr(strip_tags($n['content']), 0, 100) ?>...</p>
                                <div class="read-more">
                                    <a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>" class="p16">查看更多</a>
                                </div>
                            </div>
                        </div>
                        <!-- single-blog End -->
                    </div>
                    <?}?>

                </div>
            </div>
        </div>
        <!-- Blog Area End -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <script>
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

        <?php include("quote/footer.php"); ?>