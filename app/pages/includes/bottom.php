</main>

<!-- === BOTTOM GALLERY === -->
<section class="bottom-gallery">
  <div class="container">
    <div class="row">
      <div class="swiper js-bottom-gallery-swiper">
        <div class="swiper-wrapper">
          <?php
            generate_bottom_gallery ();
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- === FOOTER === -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <ul class="footer__socials">
        <li>
          <a href="https://twitter.com/" aria-label="twitter link" target="_blank">
            <i class="ri-twitter-line" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://instagram.com/" aria-label="instagram link" target="_blank">
            <i class="ri-instagram-line" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://pinterest.com/" aria-label="pinterest link" target="_blank">
            <i class="ri-pinterest-line" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://facebook.com/" aria-label="facebook link" target="_blank">
            <i class="ri-facebook-line" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://www.behance.net/" aria-label="behance link" target="_blank">
            <i class="ri-behance-line" aria-hidden="true"></i>
          </a>
        </li>
      </ul>

      <p class="footer__copy">
        &copy;
        <?= Date('Y') . ' ' . APP_NAME?> <br>
        All Rights Reserved
      </p>
    </div>
  </div>
</footer>

<?php
  if (isset($message_block)) {
    $message_block;
  }
?>

<!-- ----- swiper js -----  -->
<script src="<?=ROOT?>/assets/js/swiper-bundle.min.js"></script>

<!-- ----- custom js -----  -->
<script src="<?=ROOT?>/assets/js/script.js"></script>

<!-- ----- general js -----  -->
<script src="<?=ROOT?>/assets/js/general.js"></script>

<!-- ----- scroll reveal js -----  -->
<script src="<?=ROOT?>/assets/js/scrollreveal.js"></script>

<!-- ----- animations js -----  -->
<script src="<?=ROOT?>/assets/js/animations.js"></script>
</body>
</html>