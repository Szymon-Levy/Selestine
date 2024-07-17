<?php

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
  $comment_query = 'SELECT comments.user_id, articles.slug AS article_slug
                    FROM comments 
                    INNER JOIN articles ON comments.article_id = articles.id
                    WHERE comments.id = :id;';
  $comment = db_query($pdo, $comment_query, [$id])->fetch();

  if (!$comment) {
    $_SESSION['DELETE_COMMENT_ERROR_NOT_FOUND'] = true;
    redirect('blog');
  }

  if (is_user_logged_in() && get_logged_user_data($pdo)['id'] == $comment['user_id']) {
    $delete_comment_query = 'DELETE FROM comments WHERE id = :id;';
    db_query($pdo, $delete_comment_query, [$id]);
    $_SESSION['DELETE_COMMENT_SUCCESS'] = true;
  }
  else {
    $_SESSION['DELETE_COMMENT_ERROR_AUTHOR'] = true;
  }

  //redirect to article where the comment was assigned
  redirect('blog/' . $comment['article_slug'] . '#comments');
}
else {
  $_SESSION['DELETE_COMMENT_ERROR_INVALID_ID'] = true;
  redirect('blog');
}