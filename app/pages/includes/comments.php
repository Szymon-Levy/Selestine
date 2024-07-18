<?php
  $count_comments_query = 'SELECT COUNT(*) FROM comments WHERE article_id = :article_id;';
  $comments_number = db_query($pdo, $count_comments_query, [$article['id']])->fetchColumn();
  $comments = null;

  if ($comments_number > 0) {
    $arguments['article_id'] = $article['id'];
    $arguments['user_id'] = is_user_logged_in() ? get_logged_user_data($pdo)['id'] : '';
    $comments_query = 'SELECT comments.*,
                      users.id AS author_id, users.first_name, users.user_name, users.avatar, users.account_type, 
                      (SELECT COUNT(*) FROM comments_likes WHERE comment_id = comments.id) AS likes,
                      (SELECT COUNT(*) FROM comments_likes WHERE comment_id = comments.id AND user_id = :user_id) AS user_like
                      FROM comments
                      INNER JOIN users ON comments.user_id = users.id
                      WHERE article_id = :article_id
                      ORDER BY comments.create_date DESC';
    $comments = db_query($pdo, $comments_query, $arguments)->fetchAll();
  }
?>

<section class="comments" id="comments">
  <div class="container">
    <div class="row">
      <div class="comments__counter">
        <?= $comments_number; ?> 
        <?= $comments_number === 1 ? 'comment' : 'comments'; ?>
        in discussion
      </div>

      <?php if (is_user_logged_in()) { ?>
        <form method="post" class="form comments__form">
          <div class="form__row">
            <div class="form__field">
              <label for="comment" class="form__label">Add Your comment</label>
              <textarea name="comment" id="comment" placeholder="Maximum 250 characters"><?= $comment ?? ''; ?></textarea>

              <?php if (!empty($errors['comment'])) { ?>
                <div class="form_error"> <?= $errors['comment']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row form__row--submit">
            <button class="btn btn--accent form__submit-btn" name="addcomment" type="submit">Make a comment</button>
          </div>
        </form>
      <?php }
      else { ?>
        <div class="comments__login-message">
          To add a comment you must <a href="<?= ROOT ?>/login">log in</a> into Your account.
        </div>
      <?php } ?>

      <?php if ($comments) { ?>

        <div class="comments__wrapper">
          <?php foreach($comments as $comment) { ?>
            <div class="comments__item <?= $comment['account_type'] == 'admin' ? 'comments__item--admin' : '' ?>" id="comment<?= $comment['id'] ?>" data-id="comment<?= $comment['id'] ?>">
              <div class="comments__item__inner">
                <div class="comments__item__likes">
                  <i class="ri-heart-fill" aria-hidden="true"></i>
                  <?= $comment['likes']; ?>
                </div>

                <div class="comments__item__info">
                  <a href="<?= ROOT ?>/profile/<?= $comment['author_id'] ?>" class="comments__item__info__author-avatar">
                    <img src="<?= get_image_path($comment['avatar']) ?>" alt="Comment's author avatar">
                  </a>
                  <div class="comments__item__info__content">
                    <a href="<?= ROOT ?>/profile/<?= $comment['author_id'] ?>" class="comments__item__info__author-name">
                      <?= $comment['first_name'] ? $comment['first_name'] : $comment['user_name'] ?>
                    </a>
                    
                    <span class="comments__item__info__date"><?= date('F d, Y, H:i', strtotime($comment['create_date'])) ?></span>
                  </div>
                </div>

                <div class="comments__item__content"><?= htmlspecialchars($comment['content']); ?></div>

                <?php if (is_user_logged_in()) { ?>
                  <div class="comments__item__controls">
                    <!-- <button class="comments__item__controls__btn">
                      Reply
                      <i class="ri-reply-line" aria-hidden="true"></i>
                    </button> -->

                    <a href="<?= ROOT ?>/like-comment?id=<?= $comment['id'] ?>" class="comments__item__controls__btn comments__item__controls__btn--like">
                      Like
                      <i class="ri-heart-<?= $comment['user_like'] ? 'fill' : 'line';?> <?= $comment['user_like'] ? 'active' : '';?>" aria-hidden="true"></i>
                    </a>

                    <?php if (get_logged_user_data($pdo)['id'] == $comment['author_id']) { ?>
                      <a href="<?= ROOT ?>/edit-comment?id=<?= $comment['id'] ?>" class="comments__item__controls__btn">
                        Edit
                        <i class="ri-edit-line" aria-hidden="true"></i>
                      </a>

                      <a href="<?= ROOT ?>/delete-comment?id=<?= $comment['id'] ?>" class="comments__item__controls__btn comments__item__controls__btn--delete">
                        Delete
                        <i class="ri-delete-bin-line" aria-hidden="true"></i>
                      </a>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</section>