<?php
session_start();

require '../app/core/init.php';

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode('/', $url);

define('PAGE_NAME', trim($url[0]));
$file_name  = '../app/pages/' . PAGE_NAME . '.php';

//filesystem path
if ($_SERVER['SERVER_NAME'] == 'localhost') {
  define('FILESYSTEM_PATH', str_replace('\\', '/', __DIR__));
}
else {
  define('FILESYSTEM_PATH', str_replace('\\', '/', __DIR__));
}


if (file_exists($file_name)) {
  require_once $file_name;
} else {
  require_once '../app/pages/404.php';
}