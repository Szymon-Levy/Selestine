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
      $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar 
                        FROM articles 
                        INNER JOIN categories ON articles.category_id = categories.id 
                        INNER JOIN users ON articles.user_id = users.id 
                        WHERE categories.is_active = 1 AND articles.title LIKE :keyword
                        ORDER BY create_date DESC;';
      $articles = db_query($pdo, $articles_query, ['keyword' => $keyword])->fetchAll();

      if ($articles) {
        foreach ($articles as $article) {
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