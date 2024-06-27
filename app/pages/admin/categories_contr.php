<?php

//add category
if ($action == 'add') {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get categories form values
    $category_name = trim($_POST['categoryname']);
    $is_active = !empty($_POST['activity']) && $_POST['activity'] ? '1' : '0';
  
    //validate
    $errors = [];

    if (empty($category_name)) {
      $errors['category_name'] = 'Category cannot be empty!';
    }
    else if (strlen($category_name) < 2 || strlen($category_name) > 35) {
      $errors['category_name'] = 'Category cannot be shorter than 2 characters and longer than 35 characters!';
    }

    $category_slug = generate_slug($category_name);
  
    $slug_query = 'SELECT id FROM categories WHERE slug = :slug limit 1;';
    $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $category_slug])->fetch();
    $slug_number = 1;
    
    while ($is_slug_in_db) {
      $category_slug .= $slug_number;
      $slug_number++;
      $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $category_slug])->fetch();
    }
  
    if(empty($errors)) {
      //save new category to database
      $arguments = [];
      $arguments['category_name'] = $category_name;
      $arguments['slug']          = $category_slug;
      $arguments['is_active']     = $is_active;
      
      $query = 'INSERT INTO categories (category_name, slug, is_active) VALUES (:category_name, :slug, :is_active);';
      db_query($pdo, $query, $arguments);
      
      $_SESSION['CATEGORY_ADDED'] = true;
      redirect('admin/categories');
    }
  }
}
//edit category
else if ($action == 'edit') {
  $category_query = 'SELECT * FROM categories WHERE id = :id LIMIT 1';
  $category = db_query($pdo, $category_query, ['id' => $id])->fetch();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($category) {
      //get edit category form values
      $category_name = trim($_POST['categoryname']);
      $is_active = !empty($_POST['activity']) && $_POST['activity'] ? '1' : '0';

      //validate
      $errors = [];

      if (empty($category_name)) {
        $errors['category_name'] = 'Category cannot be empty!';
      }
      else if (strlen($category_name) < 2 || strlen($category_name) > 35) {
        $errors['category_name'] = 'Category cannot be shorter than 2 characters and longer than 35 characters!';
      }

      $category_slug = generate_slug($category_name);
    
      $slug_query = 'SELECT id FROM categories WHERE slug = :slug AND id != :id limit 1;';
      $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $category_slug, 'id' => $id])->fetch();
      $slug_number = 1;
      
      while ($is_slug_in_db) {
        $category_slug .= $slug_number;
        $slug_number++;
        $is_slug_in_db = db_query($pdo, $slug_query, ['slug' => $category_slug])->fetch();
      }
    
      if(empty($errors)) {
        //edit category in database
        $arguments = [];
        $arguments['id'] = $id;
        $arguments['category_name'] = $category_name;
        $arguments['slug']          = $category_slug;
        $arguments['is_active']     = $is_active;

        $query = 'UPDATE categories SET category_name = :category_name, slug = :slug, is_active = :is_active WHERE id = :id;';
        
        db_query($pdo, $query, $arguments);
        
        $_SESSION['CATEGORY_EDITED'] = true;
        redirect('admin/categories');
      }
    }
  }
}
//delete category
else if ($action == 'delete') {
  $category_query = 'SELECT * FROM categories WHERE id = :id LIMIT 1';
  $category = db_query($pdo, $category_query, ['id' => $id])->fetch();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($category) {

      //delete category from database
      $arguments['id'] = $id;
      
      $delete_query = 'DELETE FROM categories WHERE id = :id LIMIT 1;';
      
      db_query($pdo, $delete_query, $arguments);
      
      $_SESSION['CATEGORY_DELETED'] = true;
      redirect('admin/categories');

    }
  }
}