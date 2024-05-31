<?php
session_start();

require '../app/core/init.php';

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode('/', $url);

define('PAGE_NAME', trim($url[0]));
$file_name  = '../app/pages/' . PAGE_NAME . '.php';

if (file_exists($file_name)) {
  require_once $file_name;
} else {
  require_once '../app/pages/404.php';
}