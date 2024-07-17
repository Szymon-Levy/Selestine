<?php 
  $article_slug = $url[1] ?? null;
?>

<?php if ($article_slug) { ?>
  <!-- show article page -->
  <?php
  $article_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar 
                    FROM articles 
                    INNER JOIN categories ON articles.category_id = categories.id 
                    INNER JOIN users ON articles.user_id = users.id 
                    WHERE categories.is_active = 1 AND articles.slug = :slug
                    ORDER BY create_date DESC;';
  $article = db_query($pdo, $article_query, ['slug' => $article_slug])->fetch();

  if ($article) {
    //add comment logic
    if (isset($_POST['addcomment'])) {
      $comment = trim($_POST['comment']);
      
      //validation
      $errors = [];

      if (empty($comment)) {
        $errors['comment'] = 'Comment field cannot be empty!';
      }
      else if (strlen($comment) > 250) {
        $errors['comment'] = 'Comment cannot be longer than 250 characters!';
      }

      //save comment into db
      if (empty($errors)) {
        $add_comment_query = 'INSERT INTO comments (article_id, user_id, content)
                              VALUES (:article_id, :user_id, :content);';
        $arguments['article_id'] = $article['id'];
        $arguments['user_id'] = get_logged_user_data($pdo)['id'];
        $arguments['content'] = $comment;
        db_query($pdo, $add_comment_query, $arguments);

        $comment = '';
        $_SESSION['COMMENT_ADDED'] = true;
        redirect('blog/' . $article['slug'] . '#comment' . $pdo->lastInsertId());
      }
    }

    //load structure files
    $page_title = $article['title'];
    include '../app/pages/includes/top.php';

    include '../app/pages/includes/single-article.php';
    include '../app/pages/includes/comments.php';

    //update article views column
    $add_visitor_query = 'UPDATE articles SET visits = visits + 1 WHERE id = :id';
    db_query($pdo, $add_visitor_query, ['id' => $article['id']]);
  }
  else {
    $page_title = 'Blog';
    include '../app/pages/includes/top.php';

    $message_block = generate_alert('Article not found.', 'error');
  }

  if(isset($_SESSION['COMMENT_ADDED']) && $_SESSION['COMMENT_ADDED'] === true) {
    unset($_SESSION['COMMENT_ADDED']);
    $message_block = generate_alert('Comment has been added successfully.', 'success');
  }

  if(isset($_SESSION['DELETE_COMMENT_ERROR_AUTHOR']) && $_SESSION['DELETE_COMMENT_ERROR_AUTHOR'] === true) {
    unset($_SESSION['DELETE_COMMENT_ERROR_AUTHOR']);
    $message_block = generate_alert('You are not the author of the comment.', 'error');
  }

  if(isset($_SESSION['DELETE_COMMENT_SUCCESS']) && $_SESSION['DELETE_COMMENT_SUCCESS'] === true) {
    unset($_SESSION['DELETE_COMMENT_SUCCESS']);
    $message_block = generate_alert('The comment has been successfully removed.', 'success');
  }
  ?>

<?php } 

else { ?>
  <?php
    $page_title = 'Blog';
    include '../app/pages/includes/top.php';
  ?>
  <!-- show articles grid -->

  <!-- === BLOG === -->
  <section class="blog">
    <div class="container">
      <div class="row blog__row blog__row--horizontal-view">
        <?php 
        // pagination settings
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
        $results_limit = 4;
        $results_offset = $results_limit * ($page - 1);
        $articles_number_query = 'SELECT COUNT(*) FROM articles INNER JOIN categories ON articles.category_id = categories.id WHERE categories.is_active = 1;';
        $articles_number = db_query($pdo, $articles_number_query)->fetchColumn();

        $arguments['results_limit']  = $results_limit;
        $arguments['results_offset'] = $results_offset;
        $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar
                          FROM articles 
                          INNER JOIN categories ON articles.category_id = categories.id 
                          INNER JOIN users ON articles.user_id = users.id 
                          WHERE categories.is_active = 1 
                          ORDER BY create_date DESC 
                          LIMIT :results_limit 
                          OFFSET :results_offset;';
        $articles = db_query($pdo, $articles_query, $arguments)->fetchAll();
        if ($articles) {
          foreach ($articles as $article) {
            include '../app/pages/includes/article-card.php';
          }
        } else {
          echo'No articles found.';
        }
        ?>
      </div>
      <!-- generate pagination -->
      <?php
        if ($articles_number > $results_limit && $articles) {
          generate_pagination($articles_number, $results_limit, $page, '/blog');
        }
      ?>
    </div>
  </section>

  <?php
    if(isset($_SESSION['DELETE_COMMENT_ERROR_INVALID_ID']) && $_SESSION['DELETE_COMMENT_ERROR_INVALID_ID'] === true) {
      unset($_SESSION['DELETE_COMMENT_ERROR_INVALID_ID']);
      $message_block = generate_alert('Invalid comment id.', 'error');
    }

    if(isset($_SESSION['DELETE_COMMENT_ERROR_NOT_FOUND']) && $_SESSION['DELETE_COMMENT_ERROR_NOT_FOUND'] === true) {
      unset($_SESSION['DELETE_COMMENT_ERROR_NOT_FOUND']);
      $message_block = generate_alert("Comment doesn't exist.", 'error');
    }
  ?>

<?php } ?>

<?php include '../app/pages/includes/bottom.php'; ?>