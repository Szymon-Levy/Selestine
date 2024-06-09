<?php 
    $page_title = !empty($_GET['keyword']) ? $_GET['keyword'] : 'Search';
    include '../app/pages/includes/top.php'; 
?>

<!-- === BLOG === -->
<section class="blog">
<div class="container">
  <div class="row blog__row">
    <?php 
    $keyword = $_GET['keyword'] ?? null;

    if ($keyword) {
      $keyword = "%$keyword%";
      $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                        FROM articles INNER JOIN categories 
                        ON articles.category_id = categories.id 
                        WHERE categories.is_active = 1 AND articles.title LIKE :keyword
                        ORDER BY create_date DESC;';
      $found_articles = query($pdo, $articles_query, ['keyword' => $keyword]);

      if (!empty($found_articles)) {
        foreach ($found_articles as $article) {
          include '../app/pages/includes/article-card.php';
        }
      } else {
        echo'No articles found.';
      }
    }

    ?>
  </div>
</div>
</section>

<?php include '../app/pages/includes/bottom.php'; ?>