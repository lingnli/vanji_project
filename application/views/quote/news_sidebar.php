                    <div class="col-lg-3 order-lg-1 order-2">
                      <!-- shop-sidebar-wrap start -->
                      <div class="shop-sidebar-wrap">

                        <!-- shop-sidebar start -->
                        <div class="shop-sidebar mt-30 mb-30">
                          <h4 class="title">分類</h4>
                          <ul>
                            <?foreach($classify as $c){?>
                            <li><a href="<?= base_url() ?>news/classify/<?= $c['id'] ?>"><?= $c['title'] ?> <span>(<?= $c['num'] ?>)</span></a></li>
                            <?}?>
                          </ul>
                        </div>
                        <!-- shop-sidebar end -->


                        <!-- shop-sidebar start -->
                        <div class="sidbar-product shop-sidebar mb-30">
                          <h4 class="title">最新系列</h4>
                          <ul class="footer-blog">
                            <?foreach($news as $n){
                              ?>
                            <li style="margin-bottom:40px;">
                              <div class="widget-blog-wrap">
                                <div class="widget-blog-image">
                                  <a href="<?= base_url() ?>news/detail/<?= $n['id'] ?>"><img src="<?= base_url() ?><?= ($n['cover'] =="") ? "assets/images/blog/b01.png" : $n['cover'] ?>" alt=""></a>
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
                        <!-- shop-sidebar end -->

                      </div>
                      <!-- shop-sidebar-wrap end -->
                    </div>