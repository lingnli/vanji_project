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
                        <h2 class="breadcrumb-title">聯絡我們</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">聯絡我們</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->

        <!-- Page Conttent -->
        <main class="page-content section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-sm-12">
                        <div class="contact-form">
                            <div class="contact-form-info">
                                <div class="contact-title">
                                    <h3>留言給我們</h3>
                                </div>
                                <form id="contactform" action="<?= base_url() ?>home/contact_post" method="post">
                                    <div class="contact-page-form">
                                        <div class="contact-input">
                                            <div class="contact-inner">
                                                <label for="">姓名</label>
                                                <input name="name" type="text" placeholder="姓名 *" require>
                                            </div>
                                            <div class="contact-inner">
                                                <label for="">Email</label>
                                                <input name="email" type="email" placeholder="Email *" require>
                                            </div>
                                            <div class="contact-inner">
                                                <label for="">電話</label>
                                                <input name="phone" type="text" placeholder="電話 *" require>
                                            </div>
                                            <div class="contact-inner">
                                                <label for="">主旨</label>
                                                <input name="title" type="text" placeholder="主旨 *" require>
                                            </div>
                                            <div class="contact-inner contact-message">
                                                <label for="">留言</label>
                                                <textarea name="content" placeholder="訊息 *"></textarea>
                                            </div>
                                        </div>
                                        <div class="contact-submit-btn">
                                            <button class="g-recaptcha submit-btn" type="submit" data-sitekey="6Ld0nzIaAAAAAIJ-eMqmXG4vbNoVSN5rqGLarbiW" data-callback="callback">送出</button>
                                            <p class="form-messege"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <div class="contact-infor">
                            <div class="contact-title">
                                <h3>聯絡我們</h3>
                            </div>
                            <div class="contact-dec">
                                <p>簡易資訊描述鑽石戒指我們認為高品質的珠寶不應該只適合少
                                    數人使用，因此我在提供合理價格的同時珠寶主打高品質的珠
                                    寶不應該只適合少數使用。 </p>
                            </div>
                            <div class="contact-address">
                                <ul>
                                    <li><i class="zmdi zmdi-home"></i> 地址 : 台北市大安區大安街125段30號之2</li>
                                    <li><i class="zmdi zmdi-email"></i> jewelry@gmail.com</li>
                                    <li><i class="zmdi zmdi-phone"></i> 02 2665 5179</li>
                                </ul>
                            </div>
                            <div class="work-hours">
                                <h5>營業時間</h5>
                                <p><strong>周一 - 週三</strong>: 8:00 - 18:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function callback() {
                


                $('#contactform').submit();

                grecaptcha.reset();
            }
        </script>

        <!-- <script>
            function onSubmit(token) {



                var canSubmit = true;

                // 姓名驗證
                if ($("input[name=name]").val() == "") {
                    alert('請輸入姓名');
                    canSubmit = false;
                }

                // 信箱驗證
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if ($("input[name=email]").val() == "" || !$("input[name=email]").val().match(mailformat)) {
                    alert('請確認信箱是否正確');
                    canSubmit = false;
                }

                // 留言驗證
                if ($("textarea[name=comment]").val().length < 20) {
                    alert('留言字數不可少於20字');
                    canSubmit = false;
                }


                if (canSubmit) {

                    $('#contactform').submit();
                } else {
                    grecaptcha.reset();
                }
            }
        </script> -->

        <?php include("quote/footer.php"); ?>