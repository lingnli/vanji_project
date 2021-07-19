 <div class="col-xl-4 col-lg-6 col-md-6 col-6" style="padding-left:3px;padding-right:3px" id="product_<?= $item['id'] ?>">
   <!-- single-product-wrap start -->
   <div class="single-product-wrap" style="margin-top:5px;">

     <div class="product-image" style="display: flex; justify-content: center;">
       <div class="shape-outer octagon2-none">
         <div class="shape-inner-none octagon2-none">
           <a class="detail_click" href="<?= base_url() ?>product/detail/<?= $item['id'] ?>">
             <img src="<?= base_url() ?><?= ($item['images'] == array()) ? "assets/images/product/p1.jpg" : $item['images'][0] ?>" alt="Produce Images">
           </a>
         </div>
       </div>
       <!-- <span class="label">15% Off</span>  -->
       <div class="product-action">
         <a href="<?= base_url() ?>cart/add/<?= $item['id'] ?>" class="add-to-cart"><i class="ion-bag"></i></a>
         <a class="wishlist heart" data-id="<?= $item['id'] ?>"><i class="ion-android-favorite-outline heart"></i></a>
       </div>
     </div>
     <div class="product-content product-cate">
       <h3><a class="detail_click" href="<?= base_url() ?>product/detail/<?= $item['id'] ?>"><?= $item['name'] ?></a></h3>
       <div class="price-box">
         <? if ($item['price'] != 0) : ?>
           <span class="old-price">$<?= $item['price'] ?></span>
         <? endif; ?>

         <? if ($all_check == 1) { ?>
           <span class="old-price" style="color:red;">$<?= $item['sale_price'] ?></span>
           <span class="new-price">$<?= $item['sale_price'] * ($all_discount / 100) ?></span>
         <? } else { ?>
           <span class="new-price">$<?= $item['sale_price'] ?></span>
         <? } ?>
       </div>
     </div>
   </div>
   <!-- single-product-wrap end -->
 </div>