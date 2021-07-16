<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper  bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>



        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <?if($top_bg[0]['cover']=="" ):?>
            style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?else:?>
            style=" background: url(<?= base_url() . $top_bg[0]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?endif;?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">關於</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">關於</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap">
            <!-- About Us Area -->
            <div class="about-us-area pb-40 pt-40">
                <div class="container">
                <div class="w-100 mb-20">
                    <h3>歡迎您來到 <span>梵日珠寶</span></h3>
                </div>
                    <div class="row align-items-start">
                        <div class="col-lg-6">
                            <div class="about-us-contents">
                                <!-- <h3>歡迎您來到 <span>梵日珠寶</span></h3> -->
                                <p>
                                    <?= $top['intro'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-us-image text-right">
                                <?if($top['cover']==""){?>
                                <img src="<?= base_url() ?>assets/images/other/ab1.png" alt="">
                                <?}else{?>
                                <img src="<?= base_url() . $top['cover'] ?>" alt="">
                                <?}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// About Us Area -->


            <!-- Our Team Area -->
            <!-- <div class="our-team-area section-ptb">
                <div class="container">
                    <div class="row">

                        <?foreach($design as $d){?>
                        <div class="col-lg-3">
                            <div class="single-team mt--30 single-team-pd">
                                <div class="single-team-image">
                                    <?if($d['cover']==""){?>
                                    <img src="<?= base_url() ?>assets/images/team/t1.png" alt="">
                                    <?}else{?>
                                    <img src="<?= base_url() . $d['cover'] ?>" alt="">
                                    <?}?>
                                </div>
                                <div class="single-team-info">
                                    <h5><?= $d['title'] ?></h5>
                                    <p><?= $d['intro'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?}?>

                    </div>
                </div>
            </div> -->
            <!--// Our Team Area -->



            <?php include("quote/speaker.php"); ?>

        </div>
        <!-- main-content-wrap end -->


        <?php include("quote/footer.php"); ?>