<?php
  //home slider
  $home_slides_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                       FROM articles INNER JOIN categories 
                       ON articles.category_id = categories.id 
                       WHERE categories.is_active = 1 AND articles.is_home_slider = 1
                       ORDER BY create_date ASC;';
  $home_slides = db_query($pdo, $home_slides_query)->fetchAll();

  //blog cards
  $articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar
                    FROM articles 
                    INNER JOIN categories ON articles.category_id = categories.id 
                    INNER JOIN users ON articles.user_id = users.id 
                    WHERE categories.is_active = 1 AND articles.is_home_slider = 0
                    ORDER BY create_date DESC LIMIT 4;';
  $main_articles = db_query($pdo, $articles_query)->fetchAll();

  //featured articles
  $featured_articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                              FROM articles INNER JOIN categories 
                              ON articles.category_id = categories.id 
                              WHERE categories.is_active = 1 AND articles.is_featured = 1
                              ORDER BY create_date DESC LIMIT 3;';
  $featured_articles = db_query($pdo, $featured_articles_query)->fetchAll();

  //daily featured
  $daily_featured_article_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                                    FROM articles INNER JOIN categories 
                                    ON articles.category_id = categories.id 
                                    WHERE categories.is_active = 1 AND articles.is_daily_featured = 1
                                    ORDER BY create_date DESC LIMIT 1;';
  $daily_featured_article = db_query($pdo, $daily_featured_article_query)->fetch();

  //fashion carousel
  $fashion_articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug 
                            FROM articles INNER JOIN categories 
                            ON articles.category_id = categories.id 
                            WHERE categories.is_active = 1 AND categories.category_name = "fashion"
                            ORDER BY create_date DESC;';
  $fashion_articles = db_query($pdo, $fashion_articles_query)->fetchAll();

  //most popular articles
  $popular_articles_query = 'SELECT articles.*, categories.category_name, categories.slug AS category_slug, users.user_name AS author, users.avatar 
                            FROM articles 
                            INNER JOIN categories ON articles.category_id = categories.id 
                            INNER JOIN users ON articles.user_id = users.id 
                            WHERE categories.is_active = 1
                            ORDER BY visits DESC LIMIT 5;';
  $popular_articles = db_query($pdo, $popular_articles_query)->fetchAll();
?>

<?php
  $page_title = 'Home';
  include '../app/pages/includes/top.php';
?>

<?php if ($home_slides) { ?>
  <!-- === HOME SLIDER === -->
  <section class="home-slider">
    <div class="row">
      <div class="swiper home-slider__container js-home-slider slider">
        <div class="swiper-wrapper">
          <?php $i = 1; ?>
          <?php foreach ($home_slides as $slide) { ?>
            <div class="swiper-slide home-slider__slide" style="background-image: url('<?= get_image_path($slide['full_image']); ?>');">
              <div class="home-slider__slide__content">
                <div class="home-slider__slide__content__info">
                  <a href="<?= ROOT . '/category/' . $slide['category_slug']; ?>" class="home-slider__slide__content__info__category"> <?= $slide['category_name']; ?> </a>
                  <span class="home-slider__slide__content__info__date"><?= format_date($slide['create_date']); ?></span>
                </div>

                <h3 class="home-slider__slide__content__title title title--h2">
                  <?= htmlspecialchars($slide['title']); ?>
                </h3>

                <a href="<?= ROOT . '/blog/' . $slide['slug']; ?>" class="btn btn--primary">continue reading</a>
              </div>

              <div class="home-slider__container__counter">
                <span>0<?= $i; ?> / </span> 0<?= count($home_slides) ?>
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

<?php if ($main_articles) { ?>
  <!-- === BLOG CARDS === -->
  <section class="blog">
  <div class="container">
    <div class="row blog__row">
      <?php 
        foreach ($main_articles as $article) {
          include '../app/pages/includes/article-card.php';
        }
      ?>
    </div>
  </div>
  </section>
<?php } ?>

<?php if ($featured_articles) { ?>
  <!-- === FEATURED ARTICLES === -->
  <section class="featured">
    <div class="container">
      <h3 class="featured__title title title--h3">Featured articles</h3>
      <div class="row featured__row">
        <img class="featured__image js-animation-fade-from-left" src="<?= get_image_path('featured.jpg'); ?>" alt="featured image">

        <div class="featured__articles">
          <?php foreach ($featured_articles as $article) { ?>
            <div class="featured__articles__item js-animation-fade-from-right">
              <a href="<?= ROOT . '/blog/' . $article['slug'] ?>" class="featured__articles__item__image">
                <img src="<?= get_image_path($article['thumbnail']); ?>" alt="article image">
              </a>
            

              <div class="featured__articles__item__content">
                <div class="featured__articles__item__content__info">
                  <a href="<?= ROOT . '/category/' . $article['category_slug']; ?>" class="featured__articles__item__content__info__category"> <?= $article['category_name']; ?> </a>
                  <span class="featured__articles__item__content__info__date"><?= format_date($article['create_date']); ?></span>
                </div>

                <h3 class="featured__articles__item__content__title">
                  <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="title title--h5"><?= htmlspecialchars($article['title']); ?></a>
                </h3>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<?php if ($daily_featured_article) { ?>
  <?php $article = $daily_featured_article; ?>
  <!-- === DAILY FEATURED ARTICLE === -->
  <section class="daily-featured">
    <div class="container">
      <div class="row">
        <div class="daily-featured__article">
          <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="daily-featured__article__image js-animation-fade-from-bottom">
            <img src="<?= get_image_path($article['full_image']); ?>" alt="article image">
          </a>

          <div class="daily-featured__article__content js-animation-fade-from-bottom">
            <div class="daily-featured__article__content__info">
              <a href="<?= ROOT . '/category/' . $article['category_slug']; ?>" class="daily-featured__article__content__info__category"> <?= $article['category_name']; ?> </a>
              <span class="daily-featured__article__content__info__date"><?= format_date($article['create_date']); ?></span>
            </div>

            <h3 class="daily-featured__article__content__title">
              <a href="<?= ROOT . '/blog/' . $article['slug']; ?>" class="title title--h3"><?= htmlspecialchars($article['title']); ?></a>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<?php if ($fashion_articles) { ?>
  <!-- === HOME CAROUSEL === -->
  <section class="home-carousel">
    <div class="container">
      <div class="row">
        <div class="swiper home-carousel__container js-home-carousel slider">
          <div class="swiper-wrapper">
            <?php foreach ($fashion_articles as $slide) { ?>
              <div class="swiper-slide home-carousel__slide">
                <div class="home-carousel__slide__container">
                  <div class="home-carousel__slide__image">
                    <img src="<?= get_image_path($slide['thumbnail']); ?>" alt="article image">
                  </div>
                  <div class="home-carousel__slide__content">
                    <a href="<?= ROOT . '/category/' . $slide['category_slug']; ?>" class="home-carousel__slide__content__category"> <?= $slide['category_name']; ?> </a>
    
                    <h3 class="home-carousel__slide__content__title title title--h1">
                      <?= htmlspecialchars($slide['title']); ?>
                    </h3>
    
                    <a href="<?= ROOT . '/blog/' . $slide['slug']; ?>" class="btn btn--primary">continue reading</a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          
          <div class="home-carousel__container__controls slider__controls">
            <div class="slider__controls__button slider__controls__button--next">
              <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
            </div>
  
            <div class="slider__controls__button slider__controls__button--prev">
              <i class="ri-arrow-left-s-line" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<?php if ($popular_articles) { ?>
  <!-- === POPULAR ARTICLES === -->
  <section class="popular">
    <div class="container">
      <h3 class="popular__title title title--h1">Most popular</h3>

      <div class="row blog__row popular__row">
        <?php 
          foreach ($popular_articles as $article) {
            include '../app/pages/includes/article-card.php';
          }
        ?>
      </div>
    </div>
  </section>
<?php } ?>

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