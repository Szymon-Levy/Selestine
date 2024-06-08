<div class="article-card">
  <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="article-card__image-wrapper">
    <img src="<?= get_image_path($article['thumbnail']); ?>" alt="article thumbnail">
  </a>

  <div class="article-card__content">
    <div class="article-card__content__info">
      <a href="<?= ROOT . '/blog/category/' . $article['category_slug']; ?>" class="article-card__content__info__category"> <?= $article['category_name']; ?> </a>
      <span class="article-card__content__info__date"><?= date('F d, Y', strtotime($article['create_date'])); ?></span>
    </div>

    <h3 class="article-card__content__title">
      <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="title title--h3"><?= htmlspecialchars($article['title']); ?></a>
    </h3>
  </div>
</div>