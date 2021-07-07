<?php include("quote/header.php"); ?>

<body>

    <div class="main-wrapper bg-pattern">

        <header class="fl-header bg-white">

            <?php include("quote/menu.php"); ?>

        </header>



        <!-- breadcrumb-area start -->
        <div class="breadcrumb-area section-ptb" <? if ($top_bg[2]['cover'] == "") : ?> style=" background: url(<?= base_url() ?>assets/images/bg/bgb.png); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? else : ?> style=" background: url(<?= base_url() . $top_bg[2]['cover'] ?>); background-size: cover;
            background-repeat: no-repeat;
            background-position: center;" <? endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">全部商品</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item">全部商品</li>
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

                    <?php include("quote/product_sidebar.php"); ?>

                    <div class="col-lg-9 order-lg-2 order-1">
                        <!-- shop-product-wrapper start -->
                        <div class="shop-product-wrapper">
                            <div class="row">
                                <div class="col">
                                    <!-- shop-top-bar start -->
                                    <div class="shop-sidebar mb-30 product-top-cate">
                                        <h4 class="title">分類</h4>
                                        <ul>
                                            <? foreach ($classify as $c) { ?>
                                                <li><a href="<?= base_url() ?>product/classify/<?= $c['id'] ?>"><?= $c['classify'] ?> <span>(<?= $c['num'] ?>)</span></a></li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                    <div class="shop-top-bar">
                                        <!-- product-view-mode start -->

                                        <div class="product-mode ">
                                            <!--shop-item-filter-list-->
                                            <ul class="nav shop-item-filter-list" role="tablist" style="display:inlineblock !important">
                                                <li class="active"><a class="active" data-toggle="tab" href="#grid"><i class="ion-ios-keypad-outline"></i></a></li>
                                                <li><a data-toggle="tab" href="#list"><i class="ion-ios-list-outline"></i></a></li>
                                            </ul>
                                            <!-- shop-item-filter-list end -->
                                        </div>
                                        <!-- product-view-mode end -->
                                        <!-- product-short start -->
                                        <div class="product-short">
                                            <select class="nice-select" name="sortby" id="sortby">
                                                <option value="trending">排序依據</option>
                                                <option value="rating_low">價格(低 > 高)</option>
                                                <option value="rating_high">價格(高 > 低)</option>
                                                <option value="time_new">上架時間(新 > 舊)</option>
                                                <option value="time_old">上架時間(舊 > 新)</option>
                                            </select>
                                        </div>
                                        <!-- product-short end -->
                                    </div>
                                    <!-- shop-top-bar end -->
                                </div>
                            </div>

                            <!-- shop-products-wrap start -->
                            <div class="shop-products-wrap">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="grid">
                                        <div class="shop-product-wrap">
                                            <div class="row" id="products"></div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="list">
                                        <div class="shop-product-list-wrap" id="products_list"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop-products-wrap end -->

                            <!-- 分頁-->
                            <div class="paginatoin-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12" id="pages">
                                    </div>
                                </div>
                            </div>

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
            var search = "<?= $search ?>";
            var sort = "";
            var min = "";
            var max = "";
            var is_login = "<?= $is_login ?>";

            $(document).ready(function($) {

                load_data(page);

                $(document).on("change", 'select#sortby', function() {
                    sort = $(this).val();
                    console.log(sort);
                    load_data(1);
                });


                $(".search").on('click', function(event) {

                    min = $("#min-price").val();
                    max = $("#max-price").val();

                    console.log(min);
                    console.log(max);
                    load_data(1);


                });


            });


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



            function load_data(goto_page) {

                page = goto_page;
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>product/data/tw",
                    data: {
                        page: page,
                        search: search,
                        sort: sort,
                        min: min,
                        max: max
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $("#products").html(data.html);
                            $("#products_list").html(data.list_html);
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