<?php

//add article
if ($action == 'add') {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get article form values
    $title = trim($_POST['title']);
    $author = !empty($_POST['author']) ? trim($_POST['author']) : ADMIN_ID;
    $category = !empty($_POST['category']) ? trim($_POST['category']) : '';
    $thumbnail = $_FILES['thumbnail'] ?? null;
    $full_image = $_FILES['fullimage'] ?? null;
    $content = trim($_POST['content']);
    $is_homeslider = !empty($_POST['homeslider']) && $_POST['homeslider'] ? '1' : '0';
    $is_featured = !empty($_POST['featured']) && $_POST['featured'] ? '1' : '0';
    $is_dailyfeatured = !empty($_POST['dailyfeatured']) && $_POST['dailyfeatured'] ? '1' : '0';
    $tags = trim($_POST['tags']);

    //validate
    $errors = [];

    if (empty($title)) {
      $errors['title'] = 'Article title cannot be empty!';
    }
    else if (strlen($title) < 10 || strlen($title) > 250) {
      $errors['title'] = 'Article title cannot be shorter than 10 characters and longer than 250 characters!';
    }
    else {
      $article_slug = generate_slug($title);
    
      $slug_query = 'SELECT id FROM articles WHERE slug = :slug;';
      $is_slug_in_db = query($pdo, $slug_query, ['slug' => $article_slug]);
      $slug_number = 1;
      
      while ($is_slug_in_db) {
        $article_slug .= $slug_number;
        $slug_number++;
        $is_slug_in_db = query($pdo, $slug_query, ['slug' => $article_slug]);
      }
    }

    //validate thumbnail
    $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!empty($thumbnail['name'])) {
      if (!in_array($thumbnail['type'], $allowed_images_types)) {
        $errors['thumbnail'] = 'JPG, PNG and WEBP only allowed!';
      } else if ($thumbnail['size'] > 300000) {
        $errors['thumbnail'] = 'Maximum filesize is 300kb!';
      }
    }
    else {
      $errors['thumbnail'] = 'Thumbnail required!';
    }

    //validate full image
    $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!empty($full_image['name'])) {
      if (!in_array($full_image['type'], $allowed_images_types)) {
        $errors['full_image'] = 'JPG, PNG and WEBP only allowed!';
      } else if ($full_image['size'] > 500000) {
        $errors['full_image'] = 'Maximum filesize is 500kb!';
      }
    }
    else {
      $errors['full_image'] = 'Full image required!';
    }
  
    if (!empty($tags)) {
      $tags = trim($tags, ',');
      $tags = trim($tags, ' ');
    }
    if (!empty($tags) && !preg_match('/^[a-zA-Z\, ]*$/', $tags)) {
      $errors['tags'] = 'Do not use special chars and numbers!';
    }
  
    if(empty($errors)) {
      //upload thumbnail
      $uploaded_thumbnail_path = 'articles/' . time() . basename($thumbnail['name']);
      move_uploaded_file($thumbnail['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_thumbnail_path);
      
      //upload full image
      $uploaded_fullimage_path = 'articles/' . time() . basename($full_image['name']);
      move_uploaded_file($full_image['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_fullimage_path);

      //save article to database
      $data = [];
      $data['title']              = $title;
      $data['slug']               = $article_slug;
      $data['user_id']            = $author;
      $data['category_id']        = $category;
      $data['thumbnail']          = $uploaded_thumbnail_path;
      $data['full_image']         = $uploaded_fullimage_path;
      $data['content']            = $content;
      $data['is_home_slider']     = $is_homeslider;
      $data['is_featured']        = $is_featured;
      $data['is_daily_featured']  = $is_dailyfeatured;
      $data['tags']               = $tags;
      
      $query = 'INSERT INTO articles (user_id, category_id, title, content, thumbnail, full_image, is_home_slider, is_featured, is_daily_featured, slug, tags) 
                              VALUES (:user_id, :category_id, :title, :content, :thumbnail, :full_image, :is_home_slider, :is_featured, :is_daily_featured, :slug, :tags);';

      query($pdo, $query, $data);
      
      $_SESSION['ARTICLE_ADDED'] = true;
      redirect('admin/articles');
    }
  }
}
//edit article
else if ($action == 'edit') {
  $user_query = 'SELECT * FROM users WHERE id = :id LIMIT 1';
  $user_row = query($pdo, $user_query, ['id' => $id]);

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_row[0]) {
      //get signup form values
      $first_name = trim($_POST['firstname']) ?? NULL;
      $user_name = trim($_POST['username']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      $password2 = trim($_POST['retype-password']);
      $type = !empty($_POST['type']) ? 'admin' : 'user';
      $avatar = $_FILES['avatar'] ?? null;
    
      //validate
      $errors = [];

      //validate avatar
      $current_avatar = $user_row[0]['avatar'];
      $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
      if (!empty($avatar['name'])) {
        if (!in_array($avatar['type'], $allowed_types)) {
          $errors['avatar'] = 'JPG, PNG and WEBP only allowed!';
        } else if ($avatar['size'] > 300000) {
          $errors['avatar'] = 'Maximum filesize is 300kb!';
        } else {
          $uploaded_image_path = 'users/avatars/' . time() . basename($avatar['name']);
          move_uploaded_file($avatar['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_image_path);
          $current_avatar = $uploaded_image_path;
        }
      }

      if (strlen($first_name) > 50) {
        $errors['first_name'] = 'First name cannot be longer than 30 characters!';
      }
    
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
        $data['first_name']   = $first_name;
        $data['user_name']    = $user_name;
        $data['email']        = $email;
        $data['account_type'] = $type;
        $data['avatar']       = $current_avatar;
        
        if (empty($password)) {
          $query = 'UPDATE users SET first_name = :first_name, user_name = :user_name, email = :email, account_type = :account_type, avatar = :avatar WHERE id = :id;';
        }
        else {
          $data['pass'] = hash_password($password);
          $query = 'UPDATE users SET first_name = :first_name, user_name = :user_name, email = :email, pass = :pass, account_type = :account_type, avatar = :avatar WHERE id = :id;';
        }
        
        query($pdo, $query, $data);
        
        $_SESSION['USER_EDITED'] = true;
        redirect('admin/users');
      }
    }
  }
}
//delete article
else if ($action == 'delete') {
  $user_query = 'SELECT * FROM users WHERE id = :id LIMIT 1';
  $user_row = query($pdo, $user_query, ['id' => $id]);

  if ($id == 44) {
    $_SESSION['USER_DELETE_FORBIDDEN'] = true;
    redirect('admin/users');
    die();
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_row[0]) {
      //delete avatar of user
      if ($user_row[0]['avatar'] != 'users/avatars/default-profile-picture.jpg') {
        delete_image($user_row[0]['avatar']);
      }

      //delete user from database
      $data['id'] = $id;
      
      $delete_query = 'DELETE FROM users WHERE id = :id LIMIT 1;';
      
      query($pdo, $delete_query, $data);
      
      $_SESSION['USER_DELETED'] = true;
      redirect('admin/users');

    }
  }
}