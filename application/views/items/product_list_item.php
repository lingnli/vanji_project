<div class="row product-layout-list">
  <div class="col-lg-4 col-md-5">
    <!-- single-product-wrap start -->
    <div class="single-product-wrap">
      <div class="product-image" style="display: flex; justify-content: center;">
        <div class="shape-outer octagon2-none">
          <div class="shape-inner-none octagon2-none"><a href="<?= base_url() ?>product/detail/<?= $item['id'] ?>"><img src="<?= base_url() ?><?= ($item['images'] == array()) ? "assets/images/product/p1.jpg" : $item['images'][0] ?>" alt="Produce Images"></a></div>
        </div>
        <div class="product-action">
          <a href="#" class="add-to-cart"><i class="ion-bag"></i></a>
          <a href="#" class="wishlist"><i class="ion-android-favorite-outline"></i></a>
        </div>
      </div>
    </div>
    <!-- single-product-wrap end -->
  </div>
  <div class="col-lg-8 col-md-7">
    <div class="product-content product-list-content">
      <h3><a href="<?= base_url() ?>product/detail"><?= $item['name'] ?></a></h3>
      <div class="price-box">
        <span class="old-price">$<?= $item['price'] ?></span>
        <span class="new-price">$<?= $item['sale_price'] ?></span>
      </div>
      <p><?= mb_substr(strip_tags($item['detail']), 0, 100) ?>... </p>
    </div>
  </div>
</div>