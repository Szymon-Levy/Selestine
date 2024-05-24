<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  //get signup form values
  $user_name = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password2 = trim($_POST['retype-password']);
  $terms = $_POST['terms'] ?? 0;

  //validate
  $errors = [];

  if (empty($user_name)) {
    $errors['user_name'] = 'User name cannot be empty!';
  }
  else if (str_contains($user_name, ' ')) {
    $errors['user_name'] = 'No spaces in user name!';
  }
  else if (strlen($user_name) < 6 || strlen($user_name) > 35) {
    $errors['user_name'] = 'Username cannot be shorter than 6 characters and longer than 35 characters!';
  }

  $email_query = 'SELECT id FROM users WHERE email = :email limit 1;';
  $is_email_in_db = query($email_query, ['email' => $email]);

  if (empty($email)) {
    $errors['email'] = 'Email cannot be empty!';
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Wrong email format!';
  }
  else if ($is_email_in_db) {
    $errors['email'] = 'This email is already taken!';
  }

  if (empty($password)) {
    $errors['password'] = 'Password cannot be empty!';
  }
  else if (strlen($password) < 8) {
    $errors['password'] = 'Password cannot be shorter than 8 characters!';
  }
  else if ($password !== $password2) {
    $errors['password2'] = 'Passwords do not match!';
  }

  if (!$terms) {
    $errors['terms'] = 'You must accept the terms!';
  }

  if(empty($errors)) {
    //save new user to database
    $data = [];
    $data['user_name']    = $user_name;
    $data['email']        = $email;
    $data['pass']         = hash_password($password);
    $data['account_type'] = 'user';
    $query = 'INSERT INTO users (user_name, email, pass, account_type) VALUES (:user_name, :email, :pass, :account_type);';
    query($query, $data);
    
    redirect('login');
  }
}

?>

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

  <title>Signup - <?= APP_NAME ?> </title>
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
          <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="Selestine logo">
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
  <div class="nav" role="navigation">
    <div class="container">
      <div class="row">
        <button class="nav__toggle js-nav-toggler" aria-hidden="true">
          <i class="js-nav-toggler-icon ri-menu-3-line"></i>
        </button>

        <ul class="nav__list js-nav-list">
          <li><a href="home" class="<?= is_menu_item_active('home'); ?>">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Works</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="login" class="<?= is_menu_item_active('login'); ?>">Login</a></li>
          <li><a href="signup" class="<?= is_menu_item_active('signup'); ?>">signup</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- === SIGNUP FORM === -->
  <section class="signup authentication">
    <div class="container">
      <div class="row">
        <form method="post" class="form signup__form authentication__form">
          <a href="<?=ROOT?>/home" class="authentication__form__logo">
            <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="page logo">
          </a>

          <div class="form__row">
            <div class="form__field">
              <input value="<?= $user_name ?? ''; ?>" type="text" name="username" id="username" placeholder="username">

              <?php if (!empty($errors['user_name'])) { ?>
                <div class="form_error"> <?= $errors['user_name']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

              <?php if (!empty($errors['email'])) { ?>
                <div class="form_error"> <?= $errors['email']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input type="password" name="password" id="password" placeholder="password">

              <?php if (!empty($errors['password'])) { ?>
                <div class="form_error"> <?= $errors['password']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

              <?php if (!empty($errors['password2'])) { ?>
                <div class="form_error"> <?= $errors['password2']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <input class="form_checkbox__input" <?= !empty($terms) ? 'checked' : '' ?> type="checkbox" name="terms" id="terms" value="1">
                <label for="terms">Accept terms and conditions</label>
              </div>

              <?php if (!empty($errors['terms'])) { ?>
                <div class="form_error"> <?= $errors['terms']; ?> </div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form__row form__row--submit">
            <button class="btn btn--accent form__submit-btn" type="submit">Create account</button>
          </div>

          <div class="authentication__form__question">Already have an account? <a href="<?=ROOT?>/login">Login here.</a></div>
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

  <!-- ----- swiper js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/swiper-bundle.min.js"></script>

  <!-- ----- custom js -----  -->
  <script rel="stylesheet" src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>