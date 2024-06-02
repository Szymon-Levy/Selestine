<?php

//add user
if ($action == 'add') {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get signup form values
    $user_name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['retype-password']);
    $type = $_POST['type'] ? 'admin' : 'user';
  
    //validate
    $errors = [];
  
    if (empty($user_name)) {
      $errors['user_name'] = 'User name cannot be empty!';
    }
    else if (str_contains($user_name, ' ')) {
      $errors['user_name'] = 'No spaces in user name!';
    }
    else if (strlen($user_name) < 6 || strlen($user_name) > 35) {
      $errors['user_name'] = 'Username cannot be shorter than 6 characters and longer than 35 characters!';
    }
  
    $email_query = 'SELECT id FROM users WHERE email = :email limit 1;';
    $is_email_in_db = query($pdo, $email_query, ['email' => $email]);
  
    if (empty($email)) {
      $errors['email'] = 'Email cannot be empty!';
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Wrong email format!';
    }
    else if ($is_email_in_db) {
      $errors['email'] = 'This email is already taken!';
    }
  
    if (empty($password)) {
      $errors['password'] = 'Password cannot be empty!';
    }
    else if (strlen($password) < 8) {
      $errors['password'] = 'Password cannot be shorter than 8 characters!';
    }
    else if ($password !== $password2) {
      $errors['password2'] = 'Passwords do not match!';
    }
  
    if(empty($errors)) {
      //save new user to database
      $data = [];
      $data['user_name']    = $user_name;
      $data['email']        = $email;
      $data['pass']         = hash_password($password);
      $data['account_type'] = $type;
      $query = 'INSERT INTO users (user_name, email, pass, account_type) VALUES (:user_name, :email, :pass, :account_type);';
      query($pdo, $query, $data);
      
      $_SESSION['USER_ADDED'] = true;
      redirect(ROOT . '/admin/users');
    }
  }
}
//edit user
else if ($action == 'edit') {
  $user_query = 'SELECT * FROM users WHERE id = :id LIMIT 1';
  $user_row = query($pdo, $user_query, ['id' => $id]);

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_row[0]) {
      //get signup form values
      $user_name = trim($_POST['username']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      $password2 = trim($_POST['retype-password']);
      $type = !empty($_POST['type']) ? 'admin' : 'user';
    
      //validate
      $errors = [];
    
      if (empty($user_name)) {
        $errors['user_name'] = 'User name cannot be empty!';
      }
      else if (str_contains($user_name, ' ')) {
        $errors['user_name'] = 'No spaces in user name!';
      }
      else if (strlen($user_name) < 6 || strlen($user_name) > 35) {
        $errors['user_name'] = 'Username cannot be shorter than 6 characters and longer than 35 characters!';
      }
    
      $email_query = 'SELECT id FROM users WHERE email = :email AND id != :id limit 1;';
      $is_email_in_db = query($pdo, $email_query, ['email' => $email, 'id' => $id]);
    
      if (empty($email)) {
        $errors['email'] = 'Email cannot be empty!';
      }
      else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Wrong email format!';
      }
      else if ($is_email_in_db) {
        $errors['email'] = 'This email is already taken!';
      }
    
      if (!empty($password) && strlen($password) < 8) {
        $errors['password'] = 'Password cannot be shorter than 8 characters!';
      }
      else if ($password !== $password2) {
        $errors['password2'] = 'Passwords do not match!';
      }
    
      if(empty($errors)) {
        //edit user in database
        $data =               [];
        $data['id']           = $id;
        $data['user_name']    = $user_name;
        $data['email']        = $email;
        $data['account_type'] = $type;
        
        if (empty($password)) {
          $query = 'UPDATE users SET user_name = :user_name, email = :email, account_type = :account_type WHERE id = :id LIMIT 1;';
        }
        else {
          $data['pass'] = hash_password($password);
          $query = 'UPDATE users SET user_name = :user_name, email = :email, pass = :pass, account_type = :account_type WHERE id = :id LIMIT 1;';
        }
        
        query($pdo, $query, $data);
        
        $_SESSION['USER_EDITED'] = true;
        redirect(ROOT . '/admin/users');
      }
    }
  }
}
//delete user
else if ($action == 'delete') {
  $user_query = 'SELECT * FROM users WHERE id = :id LIMIT 1';
  $user_row = query($pdo, $user_query, ['id' => $id]);

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_row[0]) {
      //delete user from database
      $data['id'] = $id;
      
      $delete_query = 'DELETE FROM users WHERE id = :id LIMIT 1;';
      
      query($pdo, $delete_query, $data);
      
      $_SESSION['USER_DELETED'] = true;
      redirect(ROOT . '/admin/users');

    }
  }
}