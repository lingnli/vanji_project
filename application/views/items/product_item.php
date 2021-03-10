  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
    <!-- single-product-wrap start -->
    <div class="single-product-wrap">

      <div class="product-image" style="display: flex; justify-content: center;">
        <div class="shape-outer octagon2-none">
          <div class="shape-inner-none octagon2-none"><a href="<?= base_url() ?>product/detail/<?= $item['id'] ?>"><img src="<?= base_url() ?><?= ($item['images'] == array()) ? "assets/images/product/p1.jpg" : $item['images'][0] ?>" alt="Produce Images"></a></div>
        </div>
        <!-- <span class="label">15% Off</span>  -->
        <div class="product-action">
          <a href="<?= base_url() ?>cart/add/<?= $item['id'] ?>" class="add-to-cart"><i class="ion-bag"></i></a>
          <a class="wishlist heart" data-id="<?= $item['id'] ?>"><i class="ion-android-favorite-outline heart"></i></a>
        </div>
      </div>
      <div class="product-content">
        <h3><a href="<?= base_url() ?>product/detail"><?= $item['name'] ?></a></h3>
        <div class="price-box">
          <?if($item['price']!=0):?>
          <span class="old-price">$<?= $item['price'] ?></span>
          <?endif;?>
          <span class="new-price">$<?= $item['sale_price'] ?></span>
        </div>
      </div>
    </div>
    <!-- single-product-wrap end -->
  </div>