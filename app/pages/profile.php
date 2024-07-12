<?php
  $id = $url[1] ?? null;
  $page_title = 'User profile';
  
  if (is_numeric($id)) {
    $user_query = 'SELECT * FROM users WHERE id = :id;';
    $user = db_query($pdo, $user_query, ['id' => $id])->fetch();
    if ($user) {
      //update profile views
      $add_visitor_query = 'UPDATE users SET visits = visits + 1 WHERE id = :id';
      db_query($pdo, $add_visitor_query, ['id' => $user['id']]);

      //find written articles
      $articles_query = 'SELECT title, slug FROM articles WHERE user_id = :user_id;';
      $articles = db_query($pdo, $articles_query, ['user_id' => $user['id']])->fetchAll();

      $page_title = htmlspecialchars($user['user_name']);
    }
  }
  
  include '../app/pages/includes/top.php';
?>

<!-- === USER PROFILE === -->
<section class="profile">
  <div class="container">
      <?php if ($user) { ?>
        <div class="row">
          <div class="profile__side-col">
            <div class="profile__avatar-box">
              <button class="profile__picture-btn js-profile-picture-btn">
                <span class="visually-hidden">Enlarge profile picture</span>
                <img src="<?= get_image_path($user['avatar']); ?>" alt="<?= $user['user_name'] ?> profile picture" class="profile__picture-btn__image js-profile-picture-btn-image">
              </button>
              <h5 class="profile__user-name title title--h5"><?= htmlspecialchars($user['user_name']); ?></h5>
              <div class="profile__account-type profile__account-type--<?= $user['account_type']; ?>"><?= $user['account_type']; ?></div>
            </div>

            <div class="profile__social-box">
              <h3 class="title title--h4">Social media:</h3>

              <?php if ($user['instagram'] || $user['facebook'] || $user['twitter']) { ?>
                <ul class="profile__social-box__list">
                  <?php if ($user['instagram']) { ?>
                    <li>
                      <a href="https://www.instagram.com/<?= htmlspecialchars($user['instagram']); ?>">
                        <i class="ri-instagram-fill instagram-icon" aria-hidden="true"></i>
                        See my Instagram
                      </a>
                    </li>
                  <?php } ?>

                  <?php if ($user['facebook']) { ?>
                    <li>
                      <a href="https://www.facebook.com/<?= htmlspecialchars($user['facebook']); ?>">
                        <i class="ri-facebook-box-fill facebook-icon" aria-hidden="true"></i>
                        See my Facebook
                      </a>
                    </li>
                  <?php } ?>

                  <?php if ($user['twitter']) { ?>
                    <li>
                      <a href="https://www.twitter.com/<?= htmlspecialchars($user['twitter']); ?>">
                        <i class="ri-twitter-fill twitter-icon" aria-hidden="true"></i>
                        See my Twitter
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </div>
          </div>

          <div class="profile__main-col">
            <h1 class="title title--h1"><?= htmlspecialchars($user['first_name']); ?></h1>

            <div class="profile__info">
              <?php if ($user['about']) { ?>
                <div class="profile__info__item">
                  <h5 class="profile__info__item__title title title--h5">About me:</h5>
                  <div><?= htmlspecialchars($user['about']); ?></div>
                </div>
              <?php } ?>

              <div class="profile__info__item">
                <h5 class="profile__info__item__title title title--h5">E-mail:</h5>
                <div><?= htmlspecialchars($user['email']); ?></div>
              </div>

              <div class="profile__info__item">
                <h5 class="profile__info__item__title title title--h5">Profile visits:</h5>
                <div><?= htmlspecialchars($user['visits']); ?></div>
              </div>
            </div>

            <div class="profile__articles">
              <h3 class="profile__articles__title title title--h4">Written articles:</h3>
              <?php if ($articles) { ?>
                <?php foreach ($articles as $article) { ?>
                  <div class="profile__articles__item">
                    <a href="<?= ROOT . '/blog/' .  $article['slug']?>" class="profile__articles__item__link">
                      <i class="ri-article-line" aria-hidden="true"></i>
                      <?= htmlspecialchars($article['title']); ?>
                    </a>
                  </div>
                <?php } ?>
              <?php }
              else { ?>
                <p>No written articles</p>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php }
      else { ?>
        <p>User not found.</p>
      <?php } ?>
  </div>
</section>

<!-- === AVATAR ENLARGE === -->
<?php if ($user) { ?> 
  <div class="picture-enlarge js-picture-enlarge">
    <button class="picture-enlarge__close js-picture-enlarge-close">
      <span class="visually-hidden">Close popup</span>
      <i class="ri-close-line" aria-hidden="true"></i>
    </button>

    <img src="<?= get_image_path('/users/avatars/default-profile-picture.jpg'); ?>" class="picture-enlarge__image js-picture-enlarge-image" alt="Big profile picture">
  </div>
<?php } ?> 

<?php include '../app/pages/includes/bottom.php'; ?>