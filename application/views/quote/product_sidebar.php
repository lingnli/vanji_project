<div class="col-lg-3 order-lg-1 order-2">
  <!-- shop-sidebar-wrap start -->
  <div class="shop-sidebar-wrap">

    <!-- shop-sidebar start -->
    <div class="shop-sidebar mb-30 product-cate">
      <h4 class="title">依價格篩選</h4>
      <!-- filter-price-content start -->
      <div class="filter-price-content">
        <form action="#" method="post">
          <div class="d-flex count-block" style="">
            <input type="text" id="price-min" style="">
            <span class="pl-10 pr-10">-</span>
            <input type="text mr-10" id="price-max" style="margin-right: 5px;">
            <button class="btn price-count d-flex align-items justify-content-center search_b">GO</button>
          </div>
          <div id="price-slider" class="price-slider"></div>
          <div class="filter-price-wapper">
            <div class="filter-price-cont">
              <span>價格:</span>
              <div class="input-type">
                <input type="text" id="min-price" readonly="" style="width:70px;" />
              </div>
              <span>—</span>
              <div class="input-type">
                <input type="text" id="max-price" class="max-input" readonly="" style="width:70px;" />
              </div>
              <a class="add-to-cart-button search">
                <span>篩選</span>
              </a>
            </div>

          </div>
        </form>
      </div>
      <!-- filter-price-content end -->
    </div>
    <!-- shop-sidebar end -->

    <!-- shop-sidebar start -->
    <div class="shop-sidebar mb-30 product-cate">
      <h4 class="title">分類</h4>
      <ul>
        <? foreach ($classify as $c) { ?>
          <li><a href="<?= base_url() ?>product/classify/<?= $c['id'] ?>"><?= $c['classify'] ?> <span>(<?= $c['num'] ?>)</span></a></li>
        <? } ?>
      </ul>
    </div>
    <!-- shop-sidebar end -->


    <!-- shop-sidebar start -->
    <div class="sidbar-product shop-sidebar mb-30 product-cate">
      <h4 class="title">最佳銷售</h4>

      <? foreach ($best as $b) {
        $images = unserialize($b['images']); ?>
        <div class="sidbar-product-inner">
          <div class="product-image">
            <a href="<?= base_url() ?>product/detail/<?= $b['id'] ?>">

              <img src="<?= base_url() ?><?= ($images == array()) ? "assets/images/product/p1.jpg" : $images[0] ?>" alt=""></a>
          </div>
          <div class="product-content text-left">
            <h3><a href="<?= base_url() ?>product/detail/<?= $b['id'] ?>"><?= $b['name'] ?></a></h3>
            <div class="price-box">
              <? if ($b['price'] != 0) : ?>
                <span class="old-price">$<?= $b['price'] ?></span>
              <? endif; ?>
              <span class="new-price">$<?= $b['sale_price'] ?></span>
            </div>
          </div>
        </div>
      <? } ?>


    </div>
    <!-- shop-sidebar end -->

  </div>
  <!-- shop-sidebar-wrap end -->
</div>
<style>
  .count-block {
    max-width: 100px;
    max-height: 27px;
  }

  .count-block button {
    padding: 5px 20px;
    max-height: 27px;
    align-items: center;
  }

  .count-block input {
    max-width: 100px;
  }

  @media(max-width: 1211px) {
    .count-block input {
      max-width: 70px;
    }

    .count-block button {
      padding: 10px 15px;
    }
  }
</style>