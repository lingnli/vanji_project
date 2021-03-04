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
                        <h2 class="breadcrumb-title">登入 / 註冊</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">登入/註冊</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->

        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb lagin-and-register-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <!-- login-register-tab-list start -->
                            <div class="login-register-tab-list nav">
                                <a class="active" data-toggle="tab" href="#lg1">
                                    <h4> 登入 </h4>
                                </a>
                                <a data-toggle="tab" href="#lg2">
                                    <h4> 註冊 </h4>
                                </a>
                            </div>
                            <!-- login-register-tab-list end -->
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active bg-fqwhite">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="<?= base_url() ?>home/login_register" method="post">
                                                <div class="login-input-box">
                                                    <input type="text" name="email" placeholder="帳號">
                                                    <input type="password" name="password" placeholder="密碼">
                                                </div>
                                                <div class="button-box">
                                                    <div class="login-toggle-btn">
                                                        <!-- <input type="checkbox"> -->
                                                        <!-- <label>記住我</label> -->
                                                        <a href="<?= base_url() ?>home/forget">忘記密碼?</a>
                                                    </div>
                                                    <div class="button-box">
                                                        <button class="login-btn btn" type="submit">登入</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="lg2" class="tab-pane bg-fqwhite">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="<?= base_url() ?>home/register" method="post">
                                                <div class="login-input-box">
                                                    <input name="email" placeholder="Email" type="email">
                                                    <input type="password" name="password" placeholder="密碼">
                                                    <input type="password" name="password_confirm" placeholder="確認密碼">
                                                </div>
                                                <div class="button-box">
                                                    <button type="submit" class="register-btn btn" type="submit">註冊</button>
                                                </div>
                                            </form>
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