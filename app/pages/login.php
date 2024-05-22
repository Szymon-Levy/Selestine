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
        <form action="" class="form login-form">
          <a href="<?=ROOT?>/home" class="form__logo">
            <img src="<?=ROOT?>/assets/images/logo/logo.png" alt="page logo">
          </a>
          <input type="text" name="email" id="email" placeholder="email">
          <input type="password" name="password" id="password" placeholder="password">

          
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