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
                        <h2 class="breadcrumb-title">忘記密碼</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>home/login_register">登入/註冊</a></li>
                            <li class="breadcrumb-item">忘記密碼</li>
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
                                <div class="active" data-toggle="tab" href="#lg1">
                                    <p style="font-size: 18px;"> 我們將發送重置密碼的連結至您的電子郵件 </p>
                                </div>
                            </div>
                            <!-- login-register-tab-list end -->
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active bg-fqwhite">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="<?= base_url() ?>home/forget_pwd" method="post">
                                                <div class="login-input-box">
                                                    <input type="text" name="email" placeholder="Email">
                                                </div>
                                                <div class="button-box">
                                                    <div class="login-toggle-btn">

                                                    </div>
                                                    <div class="button-box">
                                                        <button class="login-btn btn" type="submit">送出</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="lg2" class="tab-pane bg-fqwhite">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="#" method="post">
                                                <div class="login-input-box">
                                                    <input type="text" name="user-name" placeholder="帳號">
                                                    <input type="password" name="user-password" placeholder="密碼">
                                                    <input name="user-email" placeholder="Email" type="email">
                                                </div>
                                                <div class="button-box">
                                                    <button class="register-btn btn" type="submit"><a href="my-account.html">註冊</a></button>
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