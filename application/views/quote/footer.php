<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution="setup_tool" page_id="949142695176781">
</div>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v10.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<footer>
  <div class="footer-top section-pb section-pt-60" style="background-color:#D6D7D7">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="widget-footer mt-20">
            <div class="footer-logo vjlogo-size">
              <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo/vjlogo.png" alt=""></a>
            </div>
            <p><?= $footer_text ?></p>
            <div class="newsletter-footer">
              <form action="<?= base_url() ?>home/email" method="post">
                <input type="text" name="email" placeholder="您的Email">
                <div class="subscribe-button">
                  <button class="subscribe-btn p16" type="submit"> 訂閱</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="widget-footer mt-30">
            <h6 class="title-widget">連結</h6>
            <ul class="footer-list">
              <li><a href="<?= base_url() ?>">首頁</a></li>
              <li><a href="<?= base_url() ?>home/about">關於</a></li>
              <li><a href="<?= base_url() ?>product">全部商品</a></li>
              <li><a href="<?= base_url() ?>home/faq">FAQ</a></li>
              <li><a href="<?= base_url() ?>home/contact">聯絡我們</a></li>
              <li><a href="<?= base_url() ?>news">最新系列</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="widget-footer mt-30">
            <h6 class="title-widget">聯絡資訊</h6>
            <ul class="footer-contact">
              <li>
                <label><b>電話</b></label>
                <a><?= $web_phone ?></a>
              </li>
              <li>
                <label><b>Email</b></label>
                <a><?= $web_email ?></a>
              </li>
              <li>
                <label><b>地址</b></label>
                <?= $web_addr ?>
              </li>
            </ul>
          </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6">
          <div class="widget-footer mt-30">
            <h6 class="title-widget">最新系列</h6>
            <ul class="footer-blog">
              <?foreach($footer_news as $n){?>
              <li style="padding-bottom: 10px;">
                <div class="widget-blog-wrap">
                  <div class="widget-blog-image">
                    <a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>">
                      <?if($n['cover']==""){?>
                      <img src="<?= base_url() ?>assets/images/blog/sb1.png" alt="" style="width:70px;height:70px;">
                      <?}else{?>
                      <img src="<?= base_url() . $n['cover'] ?>" style="width:70px;height:70px;">
                      <?}?>
                    </a>
                  </div>
                  <div class="widget-blog-content">
                    <h6><a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>"><?= $n['title'] ?></a></h6>
                    <div class="widget-blog-meta">
                      <span><?= date("d M Y", strtotime($n['date'])) ?></span>
                    </div>
                  </div>
                </div>
              </li>
              <?}?>

            </ul>
          </div>
        </div> -->
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="copy-right-text text-center">
            <p><?= $web_copyright ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

</div>

<!-- JS
============================================ -->




<script>
  // $(".wishlist").on('click', function() {
  //   $('#like-store').fadeIn('slow', function() {
  //     $('#like-store').delay(1000).fadeOut();
  //   });
  // });
</script>

<!-- Modernizer JS -->
<script src="<?= base_url() ?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
<!-- jQuery JS -->
<script src="<?= base_url() ?>assets/js/vendor/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url() ?>assets/js/vendor/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/vendor/bootstrap.min.js"></script>

<!-- Slick Slider JS -->
<script src="<?= base_url() ?>assets/js/plugins/slick.min.js"></script>
<!--  Jquery ui JS -->
<script src="<?= base_url() ?>assets/js/plugins/jqueryui.min.js"></script>
<!--  Scrollup JS -->
<script src="<?= base_url() ?>assets/js/plugins/scrollup.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugins/ajax-contact.js"></script>

<!-- Main JS -->
<script src="<?= base_url() ?>assets/js/main.js"></script>

</body>

</html>