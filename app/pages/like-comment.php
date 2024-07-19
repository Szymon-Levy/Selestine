<?php

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
  $comment_query = 'SELECT comments.id, articles.slug AS article_slug
                    FROM comments 
                    INNER JOIN articles ON comments.article_id = articles.id
                    WHERE comments.id = :id;';
  $comment = db_query($pdo, $comment_query, [$id])->fetch();

  if (!$comment) {
    $_SESSION['MESSAGE_ERROR'] = "Comment doesn't exist.";
    redirect('blog');
  }

  if (is_user_logged_in()) {
    $arguments['user_id'] = get_logged_user_data($pdo)['id'];
    $arguments['comment_id'] = $id;
    $like_query = 'SELECT COUNT(*) FROM comments_likes WHERE user_id = :user_id AND comment_id = :comment_id';
    $like = db_query($pdo, $like_query, $arguments)->fetchColumn();
    if (!$like) {
      $add_like_query = 'INSERT INTO comments_likes (user_id, comment_id) VALUES (:user_id, :comment_id);';
      db_query($pdo, $add_like_query, $arguments);
      $_SESSION['MESSAGE_SUCCESS'] = 'You have successfully added like to the comment.';
    }
    else {
      $delete_like_query = 'DELETE FROM comments_likes WHERE user_id = :user_id AND comment_id = :comment_id;';
      db_query($pdo, $delete_like_query, $arguments);
      $_SESSION['MESSAGE_SUCCESS'] = 'You have successfully deleted like from the comment.';
    }
  }
  else {
    $_SESSION['MESSAGE_ERROR'] = 'Only logged in users can like comments.';
    redirect('blog');
  }

  //redirect to article where the comment was assigned
  redirect('blog/' . $comment['article_slug'] . '#comment' . $id);
}
else {
  $_SESSION['MESSAGE_ERROR'] = 'Invalid comment id.';
  redirect('blog');
}