<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Selestine</title>
  <link rel="icon" href="assets/images/logo/favicon.png" type="image/png">
</head>
<body>

  <?php
    if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
      unset($_SESSION['LOGGED_IN']);
      generate_alert('You have successfully logged in.', 'success');
    }
  ?>
  
</body>
</html>