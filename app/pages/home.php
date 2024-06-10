<?php
  //home slider
  $home_slides_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                       FROM articles INNER JOIN categories 
                       ON articles.category_id = categories.id 
                       WHERE categories.is_active = 1 AND articles.is_home_slider = 1
                       ORDER BY create_date DESC;';
  $found_home_slides = query($pdo, $home_slides_query);

  //blog cards
  $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                    FROM articles INNER JOIN categories 
                    ON articles.category_id = categories.id 
                    WHERE categories.is_active = 1 
                    ORDER BY create_date DESC LIMIT 4;';
  $found_articles = query($pdo, $articles_query);
?>

<?php
  $page_title = 'Home';
  include '../app/pages/includes/top.php';
?>

<?php if (!empty($found_home_slides)) { ?>
  <!-- === HOME SLIDER === -->
  <section class="home-slider">
    <div class="row">
      <div class="swiper home-slider__container js-home-slider slider">
        <div class="swiper-wrapper">
          <?php $i = 1; ?>
          <?php foreach ($found_home_slides as $slide) { ?>
            <div class="swiper-slide home-slider__slide" style="background-image: url('<?= get_image_path($slide['full_image']); ?>');">
              <div class="home-slider__slide__content">
                <div class="home-slider__slide__content__info">
                  <a href="<?= ROOT . '/category/' . $slide['category_slug']; ?>" class="home-slider__slide__content__info__category"> <?= $slide['category_name']; ?> </a>
                  <span class="home-slider__slide__content__info__date"><?= date('F d, Y', strtotime($slide['create_date'])); ?></span>
                </div>

                <h3 class="home-slider__slide__content__title title title--h2">
                  <?= htmlspecialchars($slide['title']); ?>
                </h3>

                <a href="<?= ROOT . '/blog/' . $slide['slug']; ?>" class="btn btn--primary">continue reading</a>
              </div>

              <div class="home-slider__container__counter">
                <span>0<?= $i; ?> / </span> 0<?= count($found_home_slides) ?>
              </div>
            </div>
            <?php $i++; ?>
          <?php } ?>
        </div>
        
        <div class="home-slider__container__controls slider__controls">
          <div class="slider__controls__button slider__controls__button--next">
            <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
          </div>

          <div class="slider__controls__button slider__controls__button--prev">
            <i class="ri-arrow-left-s-line" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<!-- === BLOG CARDS === -->
<section class="blog">
<div class="container">
  <div class="row blog__row">
    <?php 
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

<?php
  if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
    unset($_SESSION['LOGGED_IN']);
    $message_block = generate_alert('You have successfully logged in.', 'success');
  }
?>

<?php
  if(isset($_SESSION['LOGGED_OUT']) && $_SESSION['LOGGED_OUT'] === true) {
    unset($_SESSION['LOGGED_OUT']);
    $message_block = generate_alert('You have been successfully logged out.', 'success');
  }
?>

<?php include '../app/pages/includes/bottom.php'; ?>