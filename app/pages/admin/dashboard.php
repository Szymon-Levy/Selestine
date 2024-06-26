<?php
  $all_users_query = 'SELECT id FROM users';
  $found_users = db_query($pdo, $all_users_query);
  $users_number = !empty($found_users) ? count($found_users) : 0;

  $all_categories_query = 'SELECT id FROM categories';
  $found_categories = db_query($pdo, $all_categories_query);
  $categories_number = !empty($found_categories) ? count($found_categories) : 0;

  $all_articles_query = 'SELECT id FROM articles';
  $found_articles = db_query($pdo, $all_articles_query);
  $articles_number = !empty($found_articles) ? count($found_articles) : 0;
?>

<main class="main">
  <h1 class="main__title">Dashboard</h1>

  <div class="main__container">
    <!-- === BLOG STATS === -->
     <section class="stats">
      <div class="stats_block">
        <div class="stats_block__title stats_block__title--users">
          <i class="ri-user-line" aria-hidden="true"></i>
          Users
        </div>

        <div class="stats_block__number"><?= $users_number ?></div>

        <div class="stats_block__buttons">
          <a class="btn btn--secondary" href="<?=ROOT?>/admin/users">
            <i class="ri-user-line" aria-hidden="true"></i>
            Users list
          </a>
          <a class="btn btn--primary" href="<?=ROOT?>/admin/users/add">
            <i class="ri-user-add-line" aria-hidden="true"></i>
            Add new user
          </a>
        </div>
      </div>
      
      <div class="stats_block">
        <div class="stats_block__title stats_block__title--categories">
          <i class="ri-folders-line" aria-hidden="true"></i>
          Categories
        </div>

        <div class="stats_block__number"><?= $categories_number ?></div>

        <div class="stats_block__buttons">
          <a class="btn btn--secondary" href="<?=ROOT?>/admin/categories">
            <i class="ri-folders-line" aria-hidden="true"></i>
            Categories list
          </a>
          <a class="btn btn--primary" href="<?=ROOT?>/admin/categories/add">
            <i class="ri-folder-add-line" aria-hidden="true"></i>
            Add new category
          </a>
        </div>
      </div>

      <div class="stats_block">
        <div class="stats_block__title stats_block__title--articles">
          <i class="ri-article-line" aria-hidden="true"></i>
          Articles
        </div>

        <div class="stats_block__number"><?= $articles_number ?></div>

        <div class="stats_block__buttons">
          <a class="btn btn--secondary" href="<?=ROOT?>/admin/articles">
            <i class="ri-article-line" aria-hidden="true"></i>
            Articles list
          </a>
          <a class="btn btn--primary" href="<?=ROOT?>/admin/articles/add">
            <i class="ri-file-add-line" aria-hidden="true"></i>
            Add new article
          </a>
        </div>
      </div>
     </section>
  </div>
</main>