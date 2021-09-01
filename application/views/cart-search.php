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
                        <h2 class="breadcrumb-title">訂單查詢</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>cart/search">訂單查詢</a></li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb cart-page">
            <div class="container text-center">
                <form action="<?= base_url() ?>cart/search" method="post">

                    <p>輸入您的訂單編號即可查詢。</p>
                    <input type="text" name="order_no"><br>

                    <button class='btn m-4'>查詢</button>

                </form>
            </div>
        </div>
        <!-- main-content-wrap end -->


        <?php include("quote/footer.php"); ?>