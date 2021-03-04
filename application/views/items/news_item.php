         <div class="col-lg-6 col-md-6">
           <!-- single-blog Start -->
           <div class="single-blog mt-30">
             <div class="blog-image">
               <a href="<?= base_url() ?>news/detail/<?= $item['id'] ?>"><img src="<?= base_url() ?><?= ($item['cover'] == "") ? "assets/images/blog/b01.png" : $item['cover'] ?>" alt=""></a>
               <div class="meta-tag">
                 <p><?= date("d / M", strtotime($item['date'])) ?></p>
               </div>
             </div>

             <div class="blog-content">
               <h4><a href="<?= base_url() ?>news/detail/<?= $item['id'] ?>"><?= $item['title'] ?></a></h4>
               <p><?= mb_substr(strip_tags($item['content']), 0, 100) ?>... </p>
               <div class="read-more">
                 <a href="<?= base_url() ?>news/detail/<?= $item['id'] ?>">查看更多</a>
               </div>
             </div>
           </div>
           <!-- single-blog End -->
         </div>