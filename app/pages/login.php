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
    $query = 'SELECT * FROM users WHERE email = :email;';
    $user = db_query($pdo, $query, ['email' => $email])->fetch();

    if ($user && password_verify($password, $user['pass'])) {
      //login into session
      authenticate_user($user['id']);

      $_SESSION['LOGGED_IN'] = true;
      if ($user['account_type'] === 'admin') {
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

<?php
  $page_title = 'Login';
  include '../app/pages/includes/top.php';
?>

<!-- === LOGIN FORM === -->
<section class="login authentication">
  <div class="container">
    <div class="row">
      <form method="post" class="form login__form authentication__form">
        <a href="<?=ROOT?>" class="authentication__form__logo">
          <img src="<?= get_image_path('logo/logo.png'); ?>" alt="page logo">
        </a>

        <div class="form__row">
          <div class="form__field">
            <label for="email" class="form__label form__label--required">Email</label>
            <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">
  
            <?php if (!empty($errors['email'])) { ?>
              <div class="form_error"> <?= $errors['email']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="password" class="form__label form__label--required">Password</label>
            <input type="password" name="password" id="password" placeholder="password">

            <?php if (!empty($errors['password'])) { ?>
              <div class="form_error"> <?= $errors['password']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row form__row--submit">
          <button class="btn btn--accent form__submit-btn" type="submit">Sign in</button>
        </div>
        

        <div class="authentication__form__question">Don't have an account? <a href="<?=ROOT?>/signup">Signup here.</a></div>
      </form>
    </div>
  </div>
</section>

<?php
  if(isset($_SESSION['REGISTERED']) && $_SESSION['REGISTERED'] === true) {
    unset($_SESSION['REGISTERED']);
    $message_block = generate_alert('Your account has been registered, you can now log in by providing the correct credentials.', 'success');
  }
?>

<?php include '../app/pages/includes/bottom.php'; ?>