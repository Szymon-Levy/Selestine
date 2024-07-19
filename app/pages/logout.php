<?php

if (!empty($_SESSION['USER'])) {
  unset($_SESSION['USER']);

  $_SESSION['MESSAGE_SUCCESS'] = 'You have been successfully logged out.';
}
redirect('');