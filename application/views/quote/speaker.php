        <!-- testimonial-area start -->
        <div class="testimonial-area testimonial-bg bg-gray overly-image section-ptb">
          <div class="container">
            <div class="row">
              <div class="col-lg-8 offset-md-2 col-md-8 col-sm-12">
                <div class="testimonial-slider">
                  <?foreach($down as $d){?>
                  <div class="testimonial-inner text-center">
                    <div class="test-cont">
                      <img src="<?= base_url() ?>assets/images/icon/quite.png" alt="">
                      <p class="p16"><?= $d['content'] ?></p>
                    </div>
                    <div class="test-author">
                      <h5><?= $d['speaker'] ?></h5>
                    </div>
                  </div>
                  <?}?>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- testimonial-area end -->