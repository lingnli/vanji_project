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
                        <h2 class="breadcrumb-title">最新系列</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">最新系列</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap shop-page section-ptb">
            <div class="container">
                <div class="row">

                    <?php include("quote/news_sidebar.php"); ?>

                    <div class="col-lg-7 order-lg-2 oreder-2 offset-lg-1">

                        <div class="row">

                            <div class="col-lg-12 blog-details-area">
                                <div class="blog-details-image mt-30">
                                    <img src="<?= base_url() ?><?= ($news_data['cover'] == "") ? "assets/images/blog/bt01.png" : $news_data['cover'] ?>" alt="">
                                </div>
                                <div class="" style="margin-top:30px;">
                                    <h4><?= $news_data['title'] ?><br></h5>
                                        <div class="post_meta">
                                            <ul>
                                                <li>
                                                    <p><?= date("d M Y", strtotime($news_data['date'])) ?></p>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                                <div class="our-blog-contnet" style="margin-bottom:50px;">


                                    <?= $news_data['content'] ?>
                                </div>

                            </div>

                            <!-- blog-details-wrapper -->
                            <div class="col-lg-12 review_address_inner">
                                <h5>留言區</h5>
                                <!-- Single Review -->
                                <?foreach($comment as $c){?>
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

                                <?if($c['replay']!=""){?>
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
                                <?}?>
                                <?}?>
                                <!--// Single Review -->
                                <!-- Single Review -->

                                <!--// Single Review -->
                            </div>

                            <?if($isLogin == 1){?>

                            <div class="col-lg-12">
                                <div class="comments-reply-area">
                                    <h5 class="comment-reply-title mb-30">留言</h5>
                                    <form id="contactform" method="post" action="<?= base_url() ?>news/comment/<?= $news_data['id'] ?>" class="comment-form-area">
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
                            <?}?>
                            <!--// blog-details-wrapper -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->

        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function callback() {
                console.log(123)


                $('#contactform').submit();

                grecaptcha.reset();
            }
        </script>

        <?php include("quote/footer.php"); ?>