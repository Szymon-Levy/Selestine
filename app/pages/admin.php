<?php
  if (!is_user_logged_in()) {
    redirect('login');
  }
  else if (!is_user_admin()) {
    redirect('');
  }

  $section = $url[1] ?? 'dashboard';
  $action = $url[2] ?? 'view';
  $id = $url[3] ?? 0;
  
  $file_name = '../app/pages/admin/' . $section . '.php';
  if (!file_exists($file_name)) {
    require_once '../app/pages/admin/404.php';
  }

  if ($section == 'users') {
    require_once '../app/pages/admin/users_contr.php';
  }
  else if ($section == 'categories') {
    require_once '../app/pages/admin/categories_contr.php';
  }
  else if ($section == 'articles') {
    require_once '../app/pages/admin/articles_contr.php';
  }

  
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- ----- favicon -----  -->
  <link rel="icon" href="<?= get_image_path('logo/favicon.png') ?>" type="image/png">

  <!-- ----- remix icon -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/remixicon.css">

  <!-- ----- custom css -----  -->
  <link rel="stylesheet" href="<?=ROOT?>/assets/css/admin_style.css">

  <!-- ----- summernote css -----  -->
  <link href="<?=ROOT?>/assets/summernote/summernote-lite.min.css" rel="stylesheet">

  <title>Admin panel - <?= APP_NAME ?> </title>
</head>
<body>

  <!-- === SIDEBAR === -->
  <aside class="sidebar js-sidebar">

    <button class="sidebar__toggler js-sidebar-toggler">
      <i class="ri-menu-unfold-line sidebar__toggler__icon--mobile js-sidebar-toggler-icon-mobile" aria-hidden="false"></i>
      <i class="ri-menu-fold-line sidebar__toggler__icon--desktop js-sidebar-toggler-icon-desktop" aria-hidden="false"></i>
    </button>

    <a href="<?= ROOT . '/admin' ?>" class="sidebar__logo">
      <img class="sidebar__logo__image" src="<?= get_image_path('logo/logo-white.png') ?>" alt="selestine logo">
      <div class="sidebar__logo__text">
        <span>A</span>dmin <span>P</span>anel
      </div>
      
    </a>

    <nav class="sidebar__nav">
      <ul class="sidebar__nav__list">
        <li>
          <a href="<?=ROOT?>/admin" class="<?= is_menu_item_active_admin('dashboard', $section) ?>">
            <i class="ri-dashboard-2-line" aria-hidden="true"></i>
            Dashboard
          </a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/users" class="<?= is_menu_item_active_admin('users', $section) ?>">
            <i class="ri-user-line" aria-hidden="true"></i>
            Users
          </a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/categories" class="<?= is_menu_item_active_admin('categories', $section) ?>">
            <i class="ri-folders-line" aria-hidden="true"></i>
            Categories
          </a>
        </li>

        <li>
          <a href="<?=ROOT?>/admin/articles" class="<?= is_menu_item_active_admin('articles', $section) ?>">
            <i class="ri-article-line" aria-hidden="true"></i>
            Articles
          </a>
        </li>

        <li>
          <a href="<?=ROOT?>" target="_blank">
            <i class="ri-external-link-line" aria-hidden="true"></i>
            Front Page
          </a>
        </li>
      </ul>
    </nav>

    <div class="sidebar__user">
      <div class="sidebar__user__image">
        <img src="<?= get_image_path($_SESSION['USER']['avatar']); ?>" alt="">
      </div>

      <div class="sidebar__user__info">
        <h4><?= htmlspecialchars($_SESSION['USER']['first_name']) ?? htmlspecialchars($_SESSION['USER']['user_name']); ?></h4>
        <span><?=htmlspecialchars($_SESSION['USER']['email']); ?></span>
      </div>

      <a class="sidebar__user__logout" href="<?= ROOT ?>/logout">
        <span class="visually-hidden">Logout</span>
        <i class="ri-logout-box-r-line" aria-hidden="true"></i>
      </a>
    </div>
  </aside>

  <!-- === MAIN CONTENT === -->
  <?php
    require_once $file_name;
  ?>


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