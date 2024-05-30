<?php

if (!empty($_SESSION['USER'])) {
  unset($_SESSION['USER']);

  $_SESSION['LOGGED_OUT'] = true;
}
redirect('home');