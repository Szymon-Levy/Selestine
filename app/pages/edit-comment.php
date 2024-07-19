<?php

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
  $comment_query = 'SELECT comments.user_id, comments.content, articles.slug AS article_slug
                    FROM comments 
                    INNER JOIN articles ON comments.article_id = articles.id
                    WHERE comments.id = :id;';
  $comment = db_query($pdo, $comment_query, [$id])->fetch();

  if (!$comment) {
    $_SESSION['MESSAGE_ERROR'] = "Comment doesn't exist.";
    redirect('blog');
  }

  if (is_user_logged_in() && get_logged_user_data($pdo)['id'] == $comment['user_id']) {
    $content = $comment['content'];

    //edit comment post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $content = trim($_POST['comment']);
      
      //validation
      $errors = [];

      if (empty($content)) {
        $errors['comment'] = 'Comment field cannot be empty!';
      }
      else if (strlen($content) > 250) {
        $errors['comment'] = 'Comment cannot be longer than 250 characters!';
      }

      //edit comment in db
      if (empty($errors)) {
        $add_comment_query = 'UPDATE comments
                              SET content = :content
                              WHERE id = :id';
                              $arguments['id'] = $id;
                              $arguments['content'] = $content;
        db_query($pdo, $add_comment_query, $arguments);

        $_SESSION['MESSAGE_SUCCESS'] = 'Comment has been successfully modified.';
        redirect('blog/' . $comment['article_slug'] . '#comment' . $id);
      }
    }
  }
  else {
    $_SESSION['MESSAGE_ERROR'] = 'You are not the author of the comment.';
    redirect('blog');
  }
}
else {
  $_SESSION['MESSAGE_ERROR'] = 'Invalid comment id.';
  redirect('blog');
}

include '../app/pages/includes/top.php';
?>

<!-- === EDIT COMMENT === -->
<section class="edit-comment" style="padding: var(--section-block-space-400) 0;">
  <div class="container">
    <div class="row">
      <form method="post" class="form comments__form">
        <div class="form__row">
          <div class="form__field">
            <label for="comment" class="form__label">Edit Your comment</label>
            <textarea name="comment" id="comment" placeholder="Maximum 250 characters"><?= $content; ?></textarea>

            <?php if (!empty($errors['comment'])) { ?>
              <div class="form_error"> <?= $errors['comment']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row form__row--submit">
          <button class="btn btn--accent form__submit-btn" name="addcomment" type="submit">Edit comment</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include '../app/pages/includes/bottom.php'; ?>