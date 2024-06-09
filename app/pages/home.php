<?php
  $page_title = 'Home';
  include '../app/pages/includes/top.php';
?>

<!-- === BLOG CARDS === -->
<section class="blog">
<div class="container">
  <div class="row blog__row">
    <?php 
    $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                      FROM articles INNER JOIN categories 
                      ON articles.category_id = categories.id 
                      WHERE categories.is_active = 1 
                      ORDER BY create_date DESC LIMIT 4;';
    $found_articles = query($pdo, $articles_query);
    if ($found_articles) {
      foreach ($found_articles as $article) {
        include '../app/pages/includes/article-card.php';
      }
    } else {
      echo'No articles found.';
    }
    ?>
  </div>
</div>
</section>

<?php
  if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
    unset($_SESSION['LOGGED_IN']);
    $message_block = generate_alert('You have successfully logged in.', 'success');
  }
?>

<?php
  if(isset($_SESSION['LOGGED_OUT']) && $_SESSION['LOGGED_OUT'] === true) {
    unset($_SESSION['LOGGED_OUT']);
    $message_block = generate_alert('You have been successfully logged out.', 'success');
  }
?>

<?php include '../app/pages/includes/bottom.php'; ?>