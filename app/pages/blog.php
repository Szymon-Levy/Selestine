<?php 
  $article_slug = $url[1] ?? null;
?>

<?php include '../app/pages/includes/top.php'; ?>

<?php if ($article_slug) { ?>
  <!-- show article page -->

  <?php
  $article_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                    FROM articles INNER JOIN categories 
                    ON articles.category_id = categories.id 
                    WHERE categories.is_active = 1 AND articles.slug = :slug
                    ORDER BY create_date DESC;';
  $found_article = query($pdo, $article_query, ['slug' => $article_slug]);

  if (!empty($found_article)) {
    $article = $found_article[0];
    include '../app/pages/includes/single-article.php';
  }
  else {
    $message_block = generate_alert('Article not found.', 'error');
  }

  ?>

<?php } 
else { ?>
  <!-- show articles grid -->

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

<?php } ?>

<?php include '../app/pages/includes/bottom.php'; ?>