<?php
  $tags = null;
  if (!empty($article['tags'])) {
    $tags = explode(',', $article['tags']);
  }
?>

<!-- === ARTICLE PAGE === -->
 <article class="article">
  <div class="article__hero" style="background-image: url('<?= get_image_path($article['full_image']) ?>');">
    <div class="article__hero__content">
      <div class="article__hero__content__info">
        <a href="<?= ROOT . '/category/' . $article['category_slug']; ?>" class="article__hero__content__info__category"> <?= $article['category_name']; ?> </a>
        <span class="article__hero__content__info__date"><?= format_date($article['create_date']); ?></span>
      </div>

      <h1 class="article__hero__content__title title title--h3">
        <?= htmlspecialchars($article['title']); ?>
      </h1>

      <a href="<?= ROOT . '/profile/' . $article['user_id']; ?>" class="article__hero__content__author"> 
        <img src="<?= get_image_path($article['avatar']); ?>" alt="<?= $article['author']; ?> avatar">
        <?= $article['author']; ?>
      </a>

      <div class="article__hero__content__visits">
        Visits: <?= $article['visits']; ?>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="article__body">
      <?= add_root_to_src($article['content']); ?>
    </div>

    <div class="article__footer">
      <?php if (!empty($tags)) { ?>
        <ul class="article__footer__tags">
          <?php foreach ($tags as $key => $tag) { ?>
            
            <?php if ($key === array_key_last($tags)) { ?>
              <li><?= $tag ?></li>
            <?php } else { ?>
              <li><?= $tag ?>, </li>
            <?php } ?>
          

          <?php } ?>
        </ul>
      <?php } ?>

      <ul class="article__footer_socials">
        <li>
          <a href="https://twitter.com/" aria-label="twitter link" target="_blank">
            <i class="ri-twitter-fill" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://instagram.com/" aria-label="instagram link" target="_blank">
            <i class="ri-instagram-fill" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://pinterest.com/" aria-label="pinterest link" target="_blank">
            <i class="ri-pinterest-fill" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://facebook.com/" aria-label="facebook link" target="_blank">
            <i class="ri-facebook-fill" aria-hidden="true"></i>
          </a>
        </li>

        <li>
          <a href="https://www.behance.net/" aria-label="behance link" target="_blank">
            <i class="ri-behance-fill" aria-hidden="true"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
 </article>