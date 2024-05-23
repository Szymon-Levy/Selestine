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

  <section class="bottom-gallery">
    <div class="container">
      <div class="row">
        
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <ul class="footer__socials">
          <li>
            <a href="" aria-label="twitter">
              <i class="ri-twitter-fill" aria-hidden="true"></i>
            </a>
          </li>
        </ul>

        <p class="footer__copy">
          &copy;
          <?= Date('Y') ?> Selestine blog <br>
          All Rights Reserved
        </p>
      </div>
    </div>
  </footer>
  

  <!-- ----- custom js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>