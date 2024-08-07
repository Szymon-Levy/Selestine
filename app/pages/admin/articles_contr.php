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
      $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $article_slug])->fetch();
      $slug_number = 1;
      
      while ($is_slug_in_db) {
        $article_slug .= $slug_number;
        $slug_number++;
        $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $article_slug])->fetch();
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
      $uploaded_thumbnail_path = 'articles/thumbnails/' . time() . basename($thumbnail['name']);
      move_uploaded_file($thumbnail['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_thumbnail_path);
      
      //upload full image
      $uploaded_fullimage_path = 'articles/full_images/' . time() . basename($full_image['name']);
      move_uploaded_file($full_image['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_fullimage_path);

      //save article to database
      $arguments = [];
      $arguments['title']              = $title;
      $arguments['slug']               = $article_slug;
      $arguments['user_id']            = $author;
      $arguments['category_id']        = $category;
      $arguments['thumbnail']          = $uploaded_thumbnail_path;
      $arguments['full_image']         = $uploaded_fullimage_path;
      $arguments['content']            = $content;
      $arguments['is_home_slider']     = $is_homeslider;
      $arguments['is_featured']        = $is_featured;
      $arguments['is_daily_featured']  = $is_dailyfeatured;
      $arguments['tags']               = $tags;
      
      $query = 'INSERT INTO articles (user_id, category_id, title, content, thumbnail, full_image, is_home_slider, is_featured, is_daily_featured, slug, tags) VALUES (:user_id, :category_id, :title, :content, :thumbnail, :full_image, :is_home_slider, :is_featured, :is_daily_featured, :slug, :tags);';

      db_query($pdo, $query, $arguments);
      
      $_SESSION['MESSAGE_SUCCESS'] = 'New article has been successfully added.';
      redirect('admin/articles');
    }
  }
}
//edit article
else if ($action == 'edit') {
  $article_query = 'SELECT * FROM articles WHERE id = :id';
  $article = db_query($pdo, $article_query, ['id' => $id])->fetch();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($article) {
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
      
        $slug_query = 'SELECT id FROM articles WHERE slug = :slug AND id != :id;';
        $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $article_slug, 'id' => $id])->fetch();
        $slug_number = 1;
        
        while ($is_slug_in_db) {
          $article_slug .= $slug_number;
          $slug_number++;
          $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $article_slug, 'id' => $id])->fetch();
        }
      }

      //validate thumbnail
      $current_thumbnail = null;
      $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
      if (!empty($thumbnail['name'])) {
        if (!in_array($thumbnail['type'], $allowed_images_types)) {
          $errors['thumbnail'] = 'JPG, PNG and WEBP only allowed!';
        } else if ($thumbnail['size'] > 300000) {
          $errors['thumbnail'] = 'Maximum filesize is 300kb!';
        }
        else {
          $uploaded_thumbnail_path = 'articles/thumbnails/' . time() . basename($thumbnail['name']);
          $current_thumbnail = $uploaded_thumbnail_path;
        }
      }

      //validate full image
      $current_fullimage = null;
      $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
      if (!empty($full_image['name'])) {
        if (!in_array($full_image['type'], $allowed_images_types)) {
          $errors['full_image'] = 'JPG, PNG and WEBP only allowed!';
        } else if ($full_image['size'] > 500000) {
          $errors['full_image'] = 'Maximum filesize is 500kb!';
        } else {
          $uploaded_fullimage_path = 'articles/full_images/' . time() . basename($full_image['name']);
          $current_fullimage = $uploaded_fullimage_path;
        }
      }

      if (!empty($tags)) {
        $tags = trim($tags, ',');
        $tags = trim($tags, ' ');
      }
      if (!empty($tags) && !preg_match('/^[a-zA-Z\, ]*$/', $tags)) {
        $errors['tags'] = 'Do not use special chars and numbers!';
      }
    
      if(empty($errors)) {
        //upload thumbnail and/or full image and remove the old one
        if ($current_thumbnail && !$current_fullimage) {
          move_uploaded_file($thumbnail['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_thumbnail_path);
          delete_image($article['thumbnail']);
        }
        else if ($current_fullimage && !$current_thumbnail) {
          move_uploaded_file($full_image['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_fullimage_path);
          delete_image($article['full_image']);
        }
        else if ($current_fullimage && $current_thumbnail) {
          move_uploaded_file($thumbnail['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_thumbnail_path);
          move_uploaded_file($full_image['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_fullimage_path);

          delete_image($article['thumbnail']);
          delete_image($article['full_image']);
        }

        //edit article in database
        $arguments = [];
        $arguments['id']                 = $id;
        $arguments['title']              = $title;
        $arguments['slug']               = $article_slug;
        $arguments['user_id']            = $author;
        $arguments['category_id']        = $category;
        $arguments['content']            = $content;
        $arguments['is_home_slider']     = $is_homeslider;
        $arguments['is_featured']        = $is_featured;
        $arguments['is_daily_featured']  = $is_dailyfeatured;
        $arguments['tags']               = $tags;
        
        if (!$current_thumbnail && !$current_fullimage) {
          $query = 'UPDATE articles SET user_id = :user_id, category_id = :category_id, title = :title, content = :content, is_home_slider = :is_home_slider, is_featured = :is_featured, is_daily_featured = :is_daily_featured, slug = :slug, tags = :tags WHERE id = :id;';
        }
        else if ($current_thumbnail && !$current_fullimage) {
          $arguments['thumbnail'] = $uploaded_thumbnail_path;
          $query = 'UPDATE articles SET user_id = :user_id, category_id = :category_id, title = :title, content = :content, thumbnail = :thumbnail, is_home_slider = :is_home_slider, is_featured = :is_featured, is_daily_featured = :is_daily_featured, slug = :slug, tags = :tags WHERE id = :id;';
        }
        else if ($current_fullimage && !$current_thumbnail) {
          $arguments['full_image'] = $uploaded_fullimage_path;
          $query = 'UPDATE articles SET user_id = :user_id, category_id = :category_id, title = :title, content = :content, full_image = :full_image, is_home_slider = :is_home_slider, is_featured = :is_featured, is_daily_featured = :is_daily_featured, slug = :slug, tags = :tags WHERE id = :id;';
        }
        else if ($current_thumbnail && $current_fullimage) {
          $arguments['thumbnail'] = $uploaded_thumbnail_path;
          $arguments['full_image'] = $uploaded_fullimage_path;
          $query = 'UPDATE articles SET user_id = :user_id, category_id = :category_id, title = :title, content = :content, thumbnail = :thumbnail, full_image = :full_image, is_home_slider = :is_home_slider, is_featured = :is_featured, is_daily_featured = :is_daily_featured, slug = :slug, tags = :tags WHERE id = :id;';
        }
        
        db_query($pdo, $query, $arguments);
        
        $_SESSION['MESSAGE_SUCCESS'] = 'Article data has been successfully edited.';
        redirect('admin/articles');
      }
    }
  }
}
//delete article
else if ($action == 'delete') {
  $article_query = 'SELECT * FROM articles WHERE id = :id';
  $article = db_query($pdo, $article_query, ['id' => $id])->fetch();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($article) {
      //delete images from article
      if (!empty($article['thumbnail'])) {
        delete_image($article['thumbnail']);
      }

      if (!empty($article['full_image'])) {
        delete_image($article['full_image']);
      }

      //delete article from database
      $arguments['id'] = $id;
      
      $delete_query = 'DELETE FROM articles WHERE id = :id LIMIT 1;';
      
      db_query($pdo, $delete_query, $arguments);
      
      $_SESSION['MESSAGE_SUCCESS'] = 'Article has been successfully deleted.';
      redirect('admin/articles');

    }
  }
}