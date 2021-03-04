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
                        <h2 class="breadcrumb-title">我的收藏</h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">首頁</a></li>
                            <li class="breadcrumb-item ">我的收藏</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb-area end -->


        <!-- main-content-wrap start -->
        <div class="main-content-wrap section-ptb wishlist-page">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#" class="cart-table">
                            <div class=" table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="plantmore-product-thumbnail">產品圖</th>
                                            <th class="cart-product-name">產品名稱</th>
                                            <th class="plantmore-product-price">價格</th>
                                            <th class="plantmore-product-stock-status">庫存</th>
                                            <th class="plantmore-product-add-cart">加入購物車</th>
                                            <th class="plantmore-product-remove">移除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?foreach($product as $p){
                                            $p['images'] = unserialize($p['images']);
                                            ?>
                                        <tr>
                                            <td class="plantmore-product-thumbnail"><a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>"><img src="<?= base_url() ?><?= ($p['images'] == array()) ? "assets/images/other/o02.jpg" : $p['images'][0] ?>" alt=""></a></td>
                                            <td class="plantmore-product-name"><a href="#"><?= $p['name'] ?></a></td>
                                            <td class="plantmore-product-price"><span class="amount">$<?= $p['sale_price'] ?></span></td>
                                            <?if($p['number']!=0){?>
                                            <td class="plantmore-product-stock-status"><span class="in-stock">有庫存</span></td>
                                            <td class="plantmore-product-add-cart"><a href="<?= base_url() ?>cart/add/<?= $p['id'] ?>">加入購物車</a></td>
                                            <?}else{?>
                                            <td class="plantmore-product-stock-status"><span class="out-stock">缺貨</span></td>
                                            <td class="plantmore-product-remove"><span>-</span></td>
                                            <?}?>
                                            <td class="plantmore-product-remove"><a href="<?= base_url() ?>member/del_favorite/<?= $p['id'] ?>"><i class="ion-close"></i></a></td>
                                        </tr>
                                        <?}?>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content-wrap end -->



        <?php include("quote/footer.php"); ?>