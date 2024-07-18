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
        $keyword_sql = '%' . $keyword . '%';

        // pagination settings
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
        $results_limit = 4;
        $results_offset = $results_limit * ($page - 1);
        $articles_number_query = 'SELECT COUNT(*) FROM articles INNER JOIN categories ON articles.category_id = categories.id WHERE categories.is_active = 1 AND articles.title LIKE :keyword;';
        $articles_number = db_query($pdo, $articles_number_query, ['keyword' => $keyword_sql])->fetchColumn();

        $arguments['results_limit']  = $results_limit;
        $arguments['results_offset'] = $results_offset;
        $arguments['keyword'] = $keyword_sql;
        $articles_query = 'SELECT articles.*, 
                          categories.category_name, categories.slug AS category_slug, 
                          users.user_name AS author, users.avatar,
                          (SELECT COUNT(*) FROM comments WHERE article_id = articles.id) AS comments
                          FROM articles 
                          INNER JOIN categories ON articles.category_id = categories.id 
                          INNER JOIN users ON articles.user_id = users.id 
                          WHERE categories.is_active = 1 AND articles.title LIKE :keyword
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
      }
      else {
        echo'No articles found.';
      }

      ?>
    </div>
    <!-- generate pagination -->
    <?php
      if ($articles_number > $results_limit && $articles) {
        generate_pagination($articles_number, $results_limit, $page, '/blog-search?keyword=' . $keyword, '&');
      }
    ?>
  </div>
</section>

<?php include '../app/pages/includes/bottom.php'; ?>