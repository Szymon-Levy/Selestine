<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- ----- favicon -----  -->
  <link rel="icon" href="<?=ROOT?>/assets/images/logo/favicon.png" type="image/png">

  <!-- ----- remix icon -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/remixicon.css">

  <!-- ----- custom css -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css">

  <!-- ----- swiper js -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/swiper-bundle.min.css">

  <title>Home - <?= APP_NAME ?> </title>
</head>
<body>


  <header class="header">
    <div class="container">
      <div class="row">
        <ul class="header__socials">
          <li>
            <a href="" aria-label="twitter">
              <i class="ri-twitter-fill" aria-hidden="true"></i>
            </a>
          </li>
        </ul>

        <a href="home" class="header__logo">
          <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="Selestine logo">
        </a>

        <form action="" class="header__search">
          <input type="text" name="" id="">
        </form>
      </div>
    </div>
  </header>

  <nav class="toolbar">
    <div class="container">
      <div class="row">

      </div>
    </div>
  </nav>

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
  

  <!-- ----- swiper js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/swiper-bundle.min.js"></script>

  <!-- ----- custom js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>