<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>



        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <? if ($top_bg[1]['cover'] == "") : ?> style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? else : ?> style=" background: url(<?= base_url() . $top_bg[1]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">最新系列</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>news">最新系列</a></li>
                            <li class="breadcrumb-item"><?= $classify_top['title'] ?></li>
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

                    <div class="col-lg-9 order-lg-2 order-1">
                        <!-- shop-product-wrapper start -->
                        <div class="blog-product-wrapper">

                            <div class="row" id="products"></div>

                            <!-- paginatoin-area start -->
                            <div class="paginatoin-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12" id="pages"></div>
                                </div>
                            </div>
                            <!-- paginatoin-area end -->
                        </div>
                        <!-- shop-product-wrapper end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->



        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script>
            var page = 1;
            var classify_id = "<?= $classify_id ?>";

            $(document).ready(function($) {

                load_data(page);

            });




            function load_data(goto_page) {

                page = goto_page;
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>news/classify_data/tw",
                    data: {
                        page: page,
                        classify_id: classify_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $("#products").html(data.html);

                            page = parseInt(data.page);
                            total = parseInt(data.total);
                            search = data.search;
                            generate_page(data.total_page);
                            $('html,body').animate({
                                scrollTop: 0,
                            }, 500)
                        }
                    },
                    failure: function(errMsg) {}
                });
            }



            var page_range = 10;

            function generate_page(total_page) {

                page = parseInt(page);
                html = '<ul class="pagination-box">';

                var first = Math.floor((page - 1) / page_range) * page_range + 1;
                if (page != 1) {
                    //上一頁
                    html += '<li><a href="javascript:load_data(' + (page - 1) + ');"><i class="ion-chevron-left"></i></a></li>';
                }

                for (var i = first; i < first + page_range && i <= total_page; i++) {
                    html += '<li><a class="';
                    if (i == page) html += 'active';
                    html += '" href="javascript: load_data(' + i + ');">' + i + '</a></li>';
                }

                if (total_page > 1 && page != total_page) {
                    //下一頁
                    html += '<li><a href="javascript:load_data(' + (page + 1) + ');"><i class="ion-chevron-right"></i></a></li>';
                }




                $("#pages").html(html);
            }
        </script>

        <?php include("quote/footer.php"); ?>