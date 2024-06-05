<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  //get login form values
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  //validate
  $errors = [];

  if (empty($email)) {
    $errors['email'] = 'Email cannot be empty!';
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Wrong email format!';
  }

  if (empty($password)) {
    $errors['password'] = 'Password cannot be empty!';
  }

  if(empty($errors)) {
    $query = 'SELECT * FROM users WHERE email = :email limit 1;';
    $found_user_row = query($pdo, $query, ['email' => $email]);

    if ($found_user_row && password_verify($password, $found_user_row[0]['pass'])) {
      //login into session
      authenticate_user($found_user_row[0]);

      $_SESSION['LOGGED_IN'] = true;
      if ($found_user_row[0]['account_type'] === 'admin') {
        redirect('admin');
      }
      else {
        redirect('');
      }

    }
    else {
      $errors['email'] = 'Wrong user data!';
      $errors['password'] = 'Wrong user data!';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ----- favicon -----  -->
  <link rel="icon" href="<?= get_image_path('logo/favicon.png'); ?>" type="image/png">

  <!-- ----- remix icon -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/remixicon.css">

  <!-- ----- custom css -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css">

  <!-- ----- swiper js -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/swiper-bundle.min.css">

  <title>Login - <?= APP_NAME ?> </title>
</head>
<body>
  <!-- === HEADER === -->
  <header class="header">
    <div class="container">
      <div class="row">
        <ul class="header__socials">
          <li>
            <a href="https://twitter.com/" aria-label="twitter link" target="_blank">
              <i class="ri-twitter-fill" aria-hidden="true"></i>
            </a>
          </li>

          <li>
            <a href="https://instagram.com/" aria-label="instagram link" target="_blank">
              <i class="ri-instagram-fill" aria-hidden="true"></i>
            </a>
          </li>

          <li>
            <a href="https://pinterest.com/" aria-label="pinterest link" target="_blank">
              <i class="ri-pinterest-fill" aria-hidden="true"></i>
            </a>
          </li>

          <li>
            <a href="https://facebook.com/" aria-label="facebook link" target="_blank">
              <i class="ri-facebook-fill" aria-hidden="true"></i>
            </a>
          </li>

          <li>
            <a href="https://www.behance.net/" aria-label="behance link" target="_blank">
              <i class="ri-behance-fill" aria-hidden="true"></i>
            </a>
          </li>
        </ul>

        <a href="home" class="header__logo">
          <img src="<?= get_image_path('logo/logo.png'); ?>" alt="Selestine logo">
        </a>

        <form action="" class="header__search form">
          <div class="form__field">
            <input type="text" name="" class="header__search__input" placeholder="search on blog">
            <button type="submit" class="form__submit">
              <span class="visually-hidden">Submit blog search form</span>
              <i class="ri-search-line"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </header>

  <!-- === NAVIGATION BAR === -->
  <div class="nav js-nav" role="navigation">
    <div class="container">
      <div class="row">
        <button class="nav__toggle js-nav-toggler" aria-hidden="true">
          <i class="js-nav-toggler-icon ri-menu-3-line"></i>
        </button>

        <ul class="nav__list js-nav-list">
          <li><a href="home" class="nav__list__link <?= is_menu_item_active('home'); ?>">Home</a></li>
          <li><a href="#" class="nav__list__link">About</a></li>
          <li><a href="#" class="nav__list__link">Works</a></li>
          <li><a href="#" class="nav__list__link">FAQ</a></li>
          <li><a href="#" class="nav__list__link">Contact</a></li>

          <?php if (!is_user_logged_in()) { ?>
            <li>
              <a href="login" class="nav__list__link <?= is_menu_item_active('login'); ?>">
                <i class="ri-user-fill" aria-hidden="true"></i>
                Login
              </a></li>
            <li>
              <a href="signup" class="nav__list__link <?= is_menu_item_active('signup'); ?>">
                <i class="ri-user-add-fill" aria-hidden="true"></i>
                signup
              </a>
            </li>
          <?php } ?>
        </ul>

        <?php if (is_user_logged_in()) { ?>
          <?php generate_nav_profile(); ?>
        <?php } ?>

        </div>
      </div>
    </div>
  </div>

  <!-- === LOGIN FORM === -->
  <section class="login authentication">
    <div class="container">
      <div class="row">
        <form method="post" class="form login__form authentication__form">
          <a href="<?=ROOT?>/home" class="authentication__form__logo">
            <img src="<?= get_image_path('logo/logo.png'); ?>" alt="page logo">
          </a>

          <div class="form__row">
            <div class="form__field">
              <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">
    
              <?php if (!empty($errors['email'])) { ?>
                <div class="form_error"> <?= $errors['email']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <input type="password" name="password" id="password" placeholder="password">
  
            <?php if (!empty($errors['password'])) { ?>
              <div class="form_error"> <?= $errors['password']; ?> </div>
            <?php } ?>
          </div>

          <div class="form__row form__row--submit">
            <button class="btn btn--accent form__submit-btn" type="submit">Sign in</button>
          </div>
          

          <div class="authentication__form__question">Don't have an account? <a href="<?=ROOT?>/signup">Signup here.</a></div>
        </form>
      </div>
    </div>
  </section>

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
    if(isset($_SESSION['REGISTERED']) && $_SESSION['REGISTERED'] === true) {
      unset($_SESSION['REGISTERED']);
      generate_alert('Your account has been registered, you can now log in by providing the correct credentials.', 'success');
    }
  ?>

  <!-- ----- swiper js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/swiper-bundle.min.js"></script>

  <!-- ----- custom js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/script.js"></script>

  <!-- ----- general js -----  -->
  <script src="<?=ROOT?>/assets/js/general.js"></script>
</body>
</html>