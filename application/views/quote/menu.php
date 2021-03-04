<!-- Header Top Start -->
<div class="header-top-area d-none d-lg-block">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="header-top-inner">
          <div class="row">
            <div class="col-lg-4 col-md-3">
              <div class="social-top">
                <ul>
                  <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                  <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                  <li><a href="#"><i class="ion-social-tumblr"></i></a></li>
                  <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-8 col-md-9">
              <div class="top-info-wrap text-right">
                <ul class="top-info">
                  <li><?= $work_time ?></li>
                  <li><a><?= $web_phone ?></a></li>
                  <li><a><?= $web_email ?></a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Header Top End -->

<!-- haeader bottom Start -->
<div class="haeader-bottom-area header-sticky">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-2 col-md-4 col-5">
        <div class="logo-area vjlogo-size">
          <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo/vjlogo.png" alt=""></a>
        </div>
      </div>
      <div class="col-lg-8 d-none d-lg-block">
        <div class="main-menu-area text-center">
          <!--  Start Mainmenu Nav-->
          <nav class="main-navigation">
            <ul>
              <li class="active"><a href="<?= base_url() ?>">首頁</a>
              </li>
              <li><a href="<?= base_url() ?>home/about">關於</a>
              </li>
              <li><a href="<?= base_url() ?>product">全部商品</a>
              </li>
              <li><a href="<?= base_url() ?>home/faq">FAQ</a>
              </li>
              <li><a href="<?= base_url() ?>home/contact">聯絡我們</a>
              </li>
              <li><a href="<?= base_url() ?>news">最新消息</a>
              </li>
            </ul>
          </nav>

        </div>
      </div>

      <div class="col-lg-2 col-md-8 col-7">
        <div class="right-blok-box d-flex">
          <div class="search-wrap">
            <a href="#" class="trigger-search"><i class="ion-ios-search-strong"></i></a>
          </div>

          <div class="user-wrap">
            <a href="<?= base_url() ?>member/favorite"><i class="ion-android-favorite-outline"></i></a>
          </div>

          <div class="person-wrap" style="padding:0 20px 0 0;">
            <?if($isLogin == 0){?>
            <a href="<?= base_url() ?>home/login_register"><i class="ion-android-person"></i></a>
            <?}else{?>
            <a href="<?= base_url() ?>member/home"><i class="ion-android-person"></i></a>
            <?}?>
          </div>


          <div class="shopping-cart-wrap">
            <a><i class="ion-ios-cart-outline"></i> <span id="cart-total"><?= $menu_count ?></span></a>
            <ul class="mini-cart">
              <?foreach($menu_product as $p){?>
              <li class="cart-item">
                <div class="cart-image">
                  <a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>">
                    <img alt="" src="<?= base_url() ?><?= ($p['images'] == array()) ? "assets/images/product/p1.jpg" : $p['images'][0] ?>">
                  </a>
                </div>
                <div class="cart-title">
                  <a href="<?= base_url() ?>product/detail/<?= $p['id'] ?>">
                    <h4><?= $p['name'] ?></h4>
                  </a>
                  <span class="quantity"><?= $p['number'] ?> ×</span>
                  <div class="price-box"><span class="new-price">$<?= $p['sale_price'] ?></span></div>
                  <a class="remove_from_cart" href="#"><i class="icon-trash icons"></i></a>
                </div>
              </li>
              <?}?>

              <li class="subtotal-titles">
                <div class="subtotal-titles">
                  <h3>小計 :</h3><span>$ <?= $menu_total ?></span>
                </div>
              </li>
              <li class="mini-cart-btns">
                <div class="cart-btns">
                  <a href="<?= base_url() ?>cart/index">前往結帳</a>
                </div>
              </li>
            </ul>
          </div>

          <div class="mobile-menu-btn d-block d-lg-none">
            <div class="off-canvas-btn">
              <i class="ion-android-menu"></i>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- haeader bottom End -->

<!-- main-search start -->
<div class="main-search-active">
  <div class="sidebar-search-icon">
    <button class="search-close"><span class="ion-android-close"></span></button>
  </div>
  <div class="sidebar-search-input">
    <form>
      <div class="form-search">
        <input id="search" class="input-text" value="" placeholder="搜尋商品" type="search">
        <button class="search-btn" type="button">
          <i class="ion-ios-search"></i>
        </button>
      </div>
    </form>
  </div>
</div>
<!-- main-search start -->


<!-- off-canvas menu start -->
<aside class="off-canvas-wrapper">
  <div class="off-canvas-overlay"></div>
  <div class="off-canvas-inner-content">
    <div class="btn-close-off-canvas">
      <i class="ion-android-close"></i>
    </div>

    <div class="off-canvas-inner">

      <!-- mobile menu start -->
      <div class="mobile-navigation">

        <!-- mobile menu navigation start -->
        <nav>
          <ul class="mobile-menu">
            <li><a href="<?= base_url() ?>">首頁</a></li>
            <li><a href="<?= base_url() ?>home/about">關於</a></li>
            <li><a href="<?= base_url() ?>product">全部商品</a></li>
            <li><a href="<?= base_url() ?>home/faq">FAQ</a></li>
            <li><a href="<?= base_url() ?>home/contact">聯絡我們</a></li>
            <li><a href="<?= base_url() ?>news">最新消息</a></li>
          </ul>
        </nav>
        <!-- mobile menu navigation end -->
      </div>
      <!-- mobile menu end -->



      <!-- offcanvas widget area start -->
      <div class="offcanvas-widget-area">
        <div class="off-canvas-contact-widget">
          <ul>
            <li>
              周一 ~ 週五 : 9:00 - 18:00 02
            </li>
            <li>
              <a href="#">02 2665 5179</a>
            </li>
            <li>
              <a href="#">jewelry@gmail.com</a>
            </li>
          </ul>
        </div>
        <div class="off-canvas-social-widget">
          <a href="#"><i class="ion-social-facebook"></i></a>
          <a href="#"><i class="ion-social-twitter"></i></a>
          <a href="#"><i class="ion-social-tumblr"></i></a>
          <a href="#"><i class="ion-social-googleplus"></i></a>
        </div>

      </div>
      <!-- offcanvas widget area end -->
    </div>
  </div>
</aside>
<!-- off-canvas menu end -->