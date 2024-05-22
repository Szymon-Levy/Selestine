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
    $found_user_row = query($query, ['email' => $email]);

    if ($found_user_row && password_verify($password, $found_user_row[0]['pass'])) {
      //login into session
      authenticate_user($found_user_row[0]);

      redirect('admin');
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
  <title>Login - <?= APP_NAME ?> </title>
  <link rel="icon" href="<?=ROOT?>/assets/images/logo/favicon.png" type="image/png">
</head>
<body>
  <section class="login">
    <div class="container">
      <div class="row">
        <form method="post" class="form login-form" style="display: flex; flex-direction: column;align-items:center;">
          <a href="<?=ROOT?>/home" class="form__logo">
            <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="page logo">
          </a>
          <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

          <?php if (!empty($errors['email'])) { ?>
            <div class="form_error"> <?= $errors['email']; ?> </div>
          <?php } ?>

          <input type="password" name="password" id="password" placeholder="password">

          <?php if (!empty($errors['password'])) { ?>
            <div class="form_error"> <?= $errors['password']; ?> </div>
          <?php } ?>

          
          <label>
            <input type="checkbox" name="remember" id="remember" value="1">
            Remember me
          </label>
          
          <button type="submit">Sign in</button>

          <div class="form__text">Don't have an account? <a href="<?=ROOT?>/signup">Signup here.</a></div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>