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
    $data['pass']         = password_hash($password, PASSWORD_DEFAULT);
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
  <title>Signup - <?= APP_NAME ?> </title>
  <link rel="icon" href="<?=ROOT?>/assets/images/logo/favicon.png" type="image/png">
</head>
<body>
  <section class="signup">
    <div class="container">
      <div class="row">
        <form method="post" class="form signup-form" style="display: flex; flex-direction: column;align-items:center;">
          <a href="<?=ROOT?>/home" class="form__logo">
            <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="page logo">
          </a>
          <input value="<?= $user_name ?? ''; ?>" type="text" name="username" id="username" placeholder="username">

          <?php if (!empty($errors['user_name'])) { ?>
            <div class="form_error"> <?= $errors['user_name']; ?> </div>
          <?php } ?>

          <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

          <?php if (!empty($errors['email'])) { ?>
            <div class="form_error"> <?= $errors['email']; ?> </div>
          <?php } ?>

          <input type="password" name="password" id="password" placeholder="password">

          <?php if (!empty($errors['password'])) { ?>
            <div class="form_error"> <?= $errors['password']; ?> </div>
          <?php } ?>

          <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

          <?php if (!empty($errors['password2'])) { ?>
            <div class="form_error"> <?= $errors['password2']; ?> </div>
          <?php } ?>

          <label>
            <input <?= !empty($terms) ? 'checked' : '' ?> type="checkbox" name="terms" id="terms" value="1">
            Accept terms and conditions
          </label>

          <?php if (!empty($errors['terms'])) { ?>
            <div class="form_error"> <?= $errors['terms']; ?> </div>
          <?php } ?>

          <button type="submit">Create account</button>

          <div class="form__text">Already have an account? <a href="<?=ROOT?>/login">Login here.</a></div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>