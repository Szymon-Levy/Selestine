<?php
/**
 * Queries the database with a given query and returns found data.
 * @param object $pdo PDO object.
 * @param string $sql SQL query to execute in the database.
 * @param array $arguments Values to use in prepared statement.
 * @return array Array of found row/rows.
 */
function db_query (PDO $pdo, string $sql, array $arguments = null) {
  try {
    if (!$arguments) {
      return $pdo->query($sql);
    }
    else {
      $result = $pdo->prepare($sql);
      $result->execute($arguments);
      return $result;
    }
  } catch (PDOException $error) {
    echo 'Query failed: ' . $error->getMessage();
  }
}

/**
 * Redirects to a given page and stops further code execution.
 * @param string $page Page to redirect to.
 */
function redirect (string $page) {
  header('Location: ' . ROOT . '/' . $page);
  die();
}

/**
 * Returns database data of currently logged in user.
 * @return array Array user user data from database.
 */
function get_logged_user_data (PDO $pdo) {
  $arguments = ['id' => $_SESSION['USER']];
  $user_query = 'SELECT * FROM users WHERE id = :id;';
  return db_query($pdo, $user_query, $arguments)->fetch();
}

/**
 * Login user into page.
 * @param array $user_id Id of user to log in.
 */
function authenticate_user (int $user_id) {
  $_SESSION['USER'] = $user_id;
}

/**
 * Checks if user is currently logged in.
 * @return bool True - logged in, false - logged out.
 */
function is_user_logged_in () {
  if (!empty($_SESSION['USER'])) {
    return true;
  }
  return false;
}

/**
 * Checks if user is an admin.
 * @return bool True - user is admin, false - user is not admin.
 */
function is_user_admin (PDO $pdo) {
  if (!empty($_SESSION['USER']) && get_logged_user_data($pdo)['account_type'] === 'admin') {
    return true;
  }
  return false;
}

/**
 * Converts password into hashed version.
 * @param string $password Password to hash.
 * @return string Hashed password.
 */
function hash_password (string $password) {
  $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
  return $hashed_password;
}

/**
 * Creates slug from given string.
 * @return string Converted slug.
 */
function generate_slug (string $string) {
  $string = str_replace("'", '', $string);
  $string = preg_replace('~[^\\pL0-9_]+~u', '-', $string);
  $string = trim($string, '-');
  $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
  $string = strtolower($string);
  $string = preg_replace('~[^-a-z0-9_]+~', '', $string);

  return $string;
}

/**
 * Returns proper path to the file from given filepath starting from images folder.
 * @param string $image_path Path to image from /assets/images folder.
 * @return string Full path to the image.
 */
function get_image_path (string $image_path) {
  return ROOT . '/assets/images/' . $image_path;
}

/**
 * Deletes file from given filepath starting from images folder.
 * @param string $image_path Path to image from /assets/images folder.
 */
function delete_image (string $image_path) {
  $path_to_image = FILESYSTEM_PATH . '/assets/images/' . $image_path;
  if (file_exists($path_to_image)) {
    unlink($path_to_image);
  }
}

/**
 * Adds root path to all images sources in html tags.
 * @param string $content Html content where there are images to change sources.
 * @return string Content with replaced sources
 */
function add_root_to_src (string $content) {
  preg_match_all('/<img[^>]+/', $content, $maches);
  if (is_array($maches)) {
    foreach ($maches[0] as $img) {
      $correct_src = str_replace('src="', 'src="' . ROOT . '/assets/images/', $img);
      $content = str_replace($img, $correct_src, $content);
    }
  }

  return $content;
}

/**
 * Changes date into readable format.
 * @param string $date.
 * @return string Converted date.
 */
function format_date (string $date) {
  $date = strtotime($date);
  return date('F d, Y', $date);
}

/* === HTML FUNCTIONS === */

/**
 * Get images from a certain directory and creates slider items to bottom slider gallery.
 */
function generate_bottom_gallery () {
  $directory = 'assets/images/bottom-gallery';
  $images = array_diff(scandir($directory), array('..', '.'));

  if (!empty($images)) {
    foreach ($images as $i => $src) {
      echo '<div class="swiper-slide">';
      echo '<img src="' . get_image_path('bottom-gallery/' . $src) . '" alt="gallery image ' . $i . '">';
      echo '</div>';
    }
  }
}

/**
 * Returns class of active menu item if its page is currently opened.
 * @param string $href Href to the page in the menu item link.
 * @return string Class of menu item. If page doesn't match returns empty string.
 */
function is_menu_item_active(string $href) {
  if (PAGE_NAME == $href) {
    return 'active';
  }
  return '';
}

/**
 * Returns class of active menu item if its page is currently opened.
 * @param string $href Href to the page in the menu item link.
 * @param string $section Section name of current page.
 * @return string Class of menu item. If page doesn't match returns empty string.
 */
function is_menu_item_active_admin(string $href, string $section) {
  if ($section == $href) {
    return 'active';
  }
  return '';
}

/**
 * Generates alert message of certain type.
 * @param string $message Text of message.
 * @param string $type Type of alert (error, success, info).
 */
function generate_alert (string $message, string $type) {
  $alert  = '';
  $alert .= '<div class="alert alert--' . $type .' js-alert" role="alert">';
  $alert .=  '<p class="alert__message">' . $message . '</p>';
  $alert .=  '<button class="alert__close js-alert-close">';
  $alert .=    '<span class="visually-hidden">Close alert</span>';
  $alert .=    '<i aria-hidden="true" class="ri-close-line"></i>';
  $alert .=  '</button>';
  $alert .= '</div>';
  return $alert;
}

/**
 * Generates html of nav profile dropdown with links to profile, admin panel and logout.
 */
function generate_nav_profile (PDO $pdo) {
  $user = get_logged_user_data($pdo);

  echo '<div class="nav__profile js-nav-profile">';
  echo  '<button class="nav__profile__button js-nav-profile-button" aria-expanded="false">';
  echo    '<img class="nav__profile__button__avatar" src="' . get_image_path(htmlspecialchars($user['avatar'])) . '" aria-hidden="true"            alt="Profile picture">';
  echo    '<i class="ri-arrow-down-s-line nav__profile__button__arrow js-nav-profile-button-arrow" aria-hidden="true"></i>';
  echo    '<span class="visually-hidden">Show profile options</span>';
  echo  '</button>';

  echo  '<div class="nav__profile__menu js-nav-profile-menu">';
  echo    '<div class="nav__profile__menu__greeting">';
  echo      'Hi, ';
  echo      $user['first_name'] ? htmlspecialchars($user['first_name']) : htmlspecialchars($user['user_name']);
  echo    '</div>';
  echo    '<ul class="nav__profile__menu__list">';
  echo      '<li><a href="' . ROOT . '/profile-settings"><i class="ri-settings-2-fill" aria-hidden="true"></i> Profile settings</a></li>';
  echo      is_user_admin($pdo) ? '<li><a href="' . ROOT . '/admin" target="_blank"><i class="ri-dashboard-3-fill" aria-hidden="true"></i> Admin panel</a></li>' : '';
  echo      '<li><a href="' . ROOT . '/logout"><i class="ri-logout-box-r-fill" aria-hidden="true"></i> Logout</a></li>';
  echo    '</ul>';
  echo  '</div>';

  echo '</div>';
}

/**
 * Generates pagination element.
 * @param int $results_number Number of all items.
 * @param int $results_limit Limit of showing items.
 * @param int $page Currently opened page.
 * @param string $href Address of first page of results.
 * @param string $char Divider in query string.
 */
function generate_pagination(int $results_number, int $results_limit, int $page, string $href, string $char = '?') {
  $pages = ceil($results_number / $results_limit);
  echo '<div class="pagination">';
  echo '<ul class="pagination__list">';

  for ($i = 1; $i <= $pages; $i++) {
    $active_class = $i == $page ? 'active' : '';

    echo '<li>';
    echo '<a href="' . ROOT . $href . $char .'page=' . $i . '" class="' . $active_class . '">' . $i . '</a>';
    echo '</li>';
  }

  echo '</ul>';
  echo '</div>';
}