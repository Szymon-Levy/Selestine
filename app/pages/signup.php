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
  $is_email_in_db = query($pdo, $email_query, ['email' => $email]);

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
    query($pdo, $query, $data);
    
    $_SESSION['REGISTERED'] = true;
    redirect('login');
  }
}

?>

<?php
  $page_title = 'Signup';
  include '../app/pages/includes/top.php';
?>

<!-- === SIGNUP FORM === -->
<section class="signup authentication">
  <div class="container">
    <div class="row">
      <form method="post" class="form signup__form authentication__form">
        <a href="<?=ROOT?>/home" class="authentication__form__logo">
          <img src="<?= get_image_path('logo/logo.png'); ?>" alt="page logo">
        </a>

        <div class="form__row">
          <label for="username" class="form__label form__label--required">User name</label>
          <div class="form__field">
            <input value="<?= $user_name ?? ''; ?>" type="text" name="username" id="username" placeholder="user name">

            <?php if (!empty($errors['user_name'])) { ?>
              <div class="form_error"> <?= $errors['user_name']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <label for="email" class="form__label form__label--required">email</label>
          <div class="form__field">
            <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

            <?php if (!empty($errors['email'])) { ?>
              <div class="form_error"> <?= $errors['email']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <label for="password" class="form__label form__label--required">password</label>
          <div class="form__field">
            <input type="password" name="password" id="password" placeholder="password">

            <?php if (!empty($errors['password'])) { ?>
              <div class="form_error"> <?= $errors['password']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <label for="retype-password" class="form__label form__label--required">retype password</label>
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
              <label for="terms"><span>Accept <a href="<?= ROOT ?>/privacy-policy"> privacy policy</a></span></label>
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

<?php include '../app/pages/includes/bottom.php'; ?>