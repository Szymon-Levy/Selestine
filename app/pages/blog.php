<?php 
  $article_slug = $url[1] ?? null;
?>

<?php if ($article_slug) { ?>
  <!-- show article page -->

  <?php
  $article_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                    FROM articles INNER JOIN categories 
                    ON articles.category_id = categories.id 
                    WHERE categories.is_active = 1 AND articles.slug = :slug
                    ORDER BY create_date DESC;';
  $article = db_query($pdo, $article_query, ['slug' => $article_slug])->fetch();

  if ($article) {
    $page_title = $article['title'];
    include '../app/pages/includes/top.php';

    include '../app/pages/includes/single-article.php';

    //update article views column
    $add_visitor_query = 'UPDATE articles SET visits = visits + 1 WHERE id = :id';
    db_query($pdo, $add_visitor_query, ['id' => $article['id']]);
  }
  else {
    $page_title = 'Blog';
    include '../app/pages/includes/top.php';

    $message_block = generate_alert('Article not found.', 'error');
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
      $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                        FROM articles INNER JOIN categories 
                        ON articles.category_id = categories.id 
                        WHERE categories.is_active = 1 
                        ORDER BY create_date DESC;';
      $articles = db_query($pdo, $articles_query)->fetchAll();
      if ($articles) {
        foreach ($articles as $article) {
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