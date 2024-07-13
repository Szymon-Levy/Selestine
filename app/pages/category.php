<?php 
  $category_slug = $url[1] ?? null;

  // pagination settings
  $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
  $results_limit = 4;
  $results_offset = $results_limit * ($page - 1);
  $articles_number_query = 'SELECT COUNT(*) FROM articles INNER JOIN categories ON articles.category_id = categories.id 
                            WHERE categories.is_active = 1 AND articles.category_id = (SELECT id FROM categories WHERE slug = :category_slug);';
  $articles_number = db_query($pdo, $articles_number_query, ['category_slug' => $category_slug])->fetchColumn();

  $arguments['category_slug']  = $category_slug;
  $arguments['results_limit']  = $results_limit;
  $arguments['results_offset'] = $results_offset;
  $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar 
                    FROM articles 
                    INNER JOIN categories ON articles.category_id = categories.id 
                    INNER JOIN users ON articles.user_id = users.id 
                    WHERE categories.is_active = 1 AND articles.category_id = (SELECT id FROM categories WHERE slug = :category_slug)
                    ORDER BY create_date DESC
                    LIMIT :results_limit 
                    OFFSET :results_offset;';
  $articles = db_query($pdo, $articles_query, $arguments)->fetchAll();

?>

<?php if ($category_slug) { ?>
  <?php 
    $page_title = $category_slug;
    include '../app/pages/includes/top.php'; 
  ?>

  <!-- === BLOG === -->
  <section class="blog">
    <div class="container">
      <?php if ($articles) { ?>
        <div class="blog__title title title--h1"><?= $articles[0]['category_name'] ?></div>
      <?php } ?>
      <div class="row blog__row">
        <?php 
        
        if ($articles) {
          foreach ($articles as $article) {
            include '../app/pages/includes/article-card.php';
          }
        } else {
          echo'Posts not found.';
        }
        ?>
      </div>
      <!-- generate pagination -->
      <?php
        if ($articles_number > $results_limit && $articles) {
          generate_pagination($articles_number, $results_limit, $page, '/category/' . $category_slug);
        }
      ?>
    </div>
  </section>

<?php } 
else { ?>

  <?php redirect('blog'); ?>

<?php } ?>

<?php include '../app/pages/includes/bottom.php'; ?>