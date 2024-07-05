<div class="article-card js-animation-fade-from-bottom">
  <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="article-card__image-wrapper">
    <img src="<?= get_image_path($article['thumbnail']); ?>" alt="<?= htmlspecialchars($article['title']); ?> article thumbnail">
  </a>

  <div class="article-card__content">
    <div class="article-card__content__info">
      <a href="<?= ROOT . '/category/' . $article['category_slug']; ?>" class="article-card__content__info__category"> <?= $article['category_name']; ?> </a>
      <span class="article-card__content__info__date"><?= format_date($article['create_date']); ?></span>
    </div>

    <h3 class="article-card__content__title">
      <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="title title--h3"><?= htmlspecialchars($article['title']); ?></a>
    </h3>

    <a href="<?= ROOT . '/profile/' . $article['user_id']; ?>" class="article-card__content__author"> 
      <img src="<?= get_image_path($article['avatar']); ?>" alt="<?= $article['author']; ?> avatar">
      <?= $article['author']; ?>
    </a>
  </div>
</div>