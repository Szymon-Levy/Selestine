<?php include '../app/pages/includes/top.php'; ?>

<!-- === BLOG === -->
<section class="blog">
<div class="container">
  <div class="row blog__row">
    <?php 
    $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                      FROM articles INNER JOIN categories 
                      ON articles.category_id = categories.id 
                      WHERE categories.is_active = 1 
                      ORDER BY create_date DESC;';
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

<?php include '../app/pages/includes/bottom.php'; ?>