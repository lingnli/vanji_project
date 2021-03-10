<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>

        <style>
            .tab-pane p {
                word-wrap: break-word !important;
            }
        </style>

        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <?if($top_bg[3]['cover']=="" ):?>
            style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?else:?>
            style=" background: url(<?= base_url() . $top_bg[3]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;"
            <?endif;?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">FAQ</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">FAQ</li>
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
                                        <li><a href="#dashboard" data-toggle="tab" class="nav-link active">常見問題</a></li>
                                        <li> <a href="#pay" data-toggle="tab" class="nav-link">付款方式</a></li>
                                        <li><a href="#return" data-toggle="tab" class="nav-link">退換貨</a></li>
                                        <li><a href="#other" data-toggle="tab" class="nav-link">其他</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-12 col-lg-10">
                                    <!-- Tab panes -->
                                    <div class="tab-content dashboard-content">
                                        <div class="tab-pane active" id="dashboard">
                                            <?foreach($faq1 as $f){?>
                                            <h3>
                                                <?= $f['title'] ?>
                                            </h3>
                                            <p class="faq-pline">
                                                <?= $f['content'] ?>
                                            </p>
                                            <?}?>



                                        </div>
                                        <div class="tab-pane fade" id="pay">
                                            <?foreach($faq2 as $f){?>
                                            <h3>
                                                <?= $f['title'] ?>
                                            </h3>
                                            <p class="faq-pline">
                                                <?= $f['content'] ?>
                                            </p>
                                            <?}?>

                                        </div>

                                        <div class="tab-pane fade" id="return">
                                            <?foreach($faq3 as $f){?>
                                            <h3>
                                                <?= $f['title'] ?>
                                            </h3>

                                            <?= $f['content'] ?>
                                            <p class="faq-pline"></p>
                                            <?}?>
                                        </div>

                                        <div class="tab-pane fade" id="other">
                                            <?foreach($faq4 as $f){?>
                                            <h3>
                                                <?= $f['title'] ?>
                                            </h3>

                                            <p class="faq-pline">
                                                <?= $f['content'] ?>
                                            </p>
                                            <?}?>
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