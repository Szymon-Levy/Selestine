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
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/admin_style.css">

  <title>Admin panel - <?= APP_NAME ?> </title>
</head>
<body>

  <!-- === SIDEBAR === -->
  <aside class="sidebar">

    <nav class="sidebar__nav">
      <ul class="sidebar__nav__list">
        <li>
          <a href="<?=ROOT?>/admin">Dashboard</a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/users">Users</a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/categories">Categories</a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/articles">Articles</a>
        </li>
      </ul>
    </nav>
  </aside>

  <main>
    <?php
      $section = $url[1] ?? 'dashboard';
      
      $file_name = '../app/pages/admin/' . $section . '.php';
      if (file_exists($file_name)) {
        require_once $file_name;
      }
      else {
        require_once '../app/pages/admin/404.php';
      }
    ?>
  </main>


  <?php
    if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
      unset($_SESSION['LOGGED_IN']);
      generate_alert('You have successfully logged in.', 'success');
    }
  ?>

  <!-- ----- general js -----  -->
  <script src="<?=ROOT?>/assets/js/general.js"></script>

  <!-- ----- custom js -----  -->
  <script src="<?=ROOT?>/assets/js/admin_script.js"></script>
</body>
</html>