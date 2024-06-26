<?php if ($action == 'add') { ?>

  <main class="main">
    <h1 class="main__title">Add new article</h1>

    <div class="main__container">

      <!-- === ADD ARTICLE FORM === -->
      <section class="add-article">
        <form method="post" class="form user__form" enctype="multipart/form-data">

          <div class="form__row">
            <div class="form__field">
              <label for="title" class="form__label">title <span class="form__label__star">*</span></label>
              <input value="<?= $title ?? ''; ?>" type="text" name="title" id="title" placeholder="Article title">

              <?php if (!empty($errors['title'])) { ?>
                <div class="form_error"> <?= $errors['title']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="author" class="form__label">author</label>
              <div class="form__select">
                <select id="author" name="author">
                  <option value="">Select the author</option>
                  <?php
                    $admin_users_query = 'SELECT id, user_name FROM users WHERE account_type = "admin";';
                    $found_admins = db_query($pdo, $admin_users_query);
                  ?>
                  <?php if (!empty($found_admins)) { ?>
                    <?php foreach ($found_admins as $admin) { ?>
                      <option value="<?= $admin['id']; ?>" <?= !empty($author) && $author == $admin['id'] ? 'selected' : '' ?>><?= $admin['user_name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="category" class="form__label">category</label>
              <div class="form__select">
                <select id="category" name="category">
                  <option value="">Select category</option>
                  <?php
                    $categories_query = 'SELECT id, category_name FROM categories;';
                    $found_categories = db_query($pdo, $categories_query);
                  ?>
                  <?php if (!empty($found_categories)) { ?>
                    <?php foreach ($found_categories as $category) { ?>
                      <option value="<?= $category['id']; ?>" <?= !empty($category) && $category == $category['id'] ? 'selected' : '' ?>><?= $category['category_name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="thumbnail" class="form__label">upload thumbnail <span class="form__label__star">*</span></label>
              <div class="user__form__upload-container js-form-upload-container">
                <label class="form__upload">
                  <span class="form__upload__text">
                    <i class="ri-upload-2-line" aria-hidden="true"></i>
                    Click or Drag file here...
                  </span>
                  <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                  <input type="file" name="thumbnail" id="thumbnail" class="form__upload__input js-form-upload-input">
                </label>

                <div class="form__image-preview">
                  <span>Thumbnail preview:</span>
                  <img src="<?= get_image_path('noimage.jpg'); ?>" class="form__image-preview__image js-form-upload-preview-image" alt="article thumbnail">
                </div>
              </div>

              <?php if (!empty($errors['thumbnail'])) { ?>
                <div class="form_error"> <?= $errors['thumbnail']; ?> </div>
              <?php } ?>

            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="fullimage" class="form__label">upload full image <span class="form__label__star">*</span></label>
              <div class="user__form__upload-container js-form-upload-container">
                <label class="form__upload">
                  <span class="form__upload__text">
                    <i class="ri-upload-2-line" aria-hidden="true"></i>
                    Click or Drag file here...
                  </span>
                  <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                  <input type="file" name="fullimage" id="fullimage" class="form__upload__input js-form-upload-input">
                </label>

                <div class="form__image-preview">
                  <span>Full image preview:</span>
                  <img src="<?= get_image_path('noimage.jpg'); ?>" class="form__image-preview__image js-form-upload-preview-image" alt="article full image">
                </div>
              </div>

              <?php if (!empty($errors['full_image'])) { ?>
                <div class="form_error"> <?= $errors['full_image']; ?> </div>
              <?php } ?>

            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="content" class="form__label">content</label>
              <textarea name="content" class="js-summernote" id="content" placeholder="Article content"><?= $content ?? ''; ?></textarea>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <label for="homeslider" class="form__label">Home slider</label>
                <input class="form_checkbox__input" <?= !empty($is_homeslider) && $is_homeslider == '1' ? 'checked' : '' ?> type="checkbox" name="homeslider" id="homeslider" value="1">
                <label for="homeslider">Show on home slider</label>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <label for="featured" class="form__label">Featured</label>
                <input class="form_checkbox__input" <?= !empty($is_featured) && $is_featured == '1' ? 'checked' : '' ?> type="checkbox" name="featured" id="featured" value="1">
                <label for="featured">Show in featured section</label>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <label for="dailyfeatured" class="form__label">Daily featured</label>
                <input class="form_checkbox__input" <?= !empty($is_dailyfeatured) && $is_dailyfeatured == '1' ? 'checked' : '' ?> type="checkbox" name="dailyfeatured" id="dailyfeatured" value="1">
                <label for="dailyfeatured">Show in daily featured section</label>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="tags" class="form__label">tags</label>
              <input value="<?= $tags ?? ''; ?>" type="text" name="tags" id="tags" placeholder="Tags divided by commas (,)">

              <?php if (!empty($errors['tags'])) { ?>
                <div class="form_error"> <?= $errors['tags']; ?> </div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form__row form__row--submit form__row--buttons">
            <button class="btn btn--primary form__submit-btn" type="submit">Add article</button>
            <a href="<?=ROOT?>/admin/articles" class="btn btn--secondary">
              <i class="ri-arrow-go-back-line" aria-hidden="true"></i>
              Go back
            </a>
          </div>
        </form>
      </section>

    </div>
  </main>

  <!-- ----- jquery to summernote -----  -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- ----- summernote js -----  -->
  <script src="<?=ROOT?>/assets/summernote/summernote-lite.min.js"></script>

  <!-- run summernote -->
  <script>
    $(document).ready(function() {
      $('.js-summernote').summernote({height: 500, tabsize: 2,});
    });
  </script>

<?php }
else if ($action == 'edit') { ?>

<?php if (isset($article_row[0])) { ?>
  <main class="main">
    <h1 class="main__title">Edit article</h1>

    <div class="main__container">

      <!-- === EDIT ARTICLE FORM === -->
    <section class="edit-user">
      <form method="post" class="form user__form" enctype="multipart/form-data">

        <div class="form__row">
          <div class="form__field">
            <label for="title" class="form__label">title <span class="form__label__star">*</span></label>
            <input value="<?= htmlspecialchars($article_row[0]['title'] ?? ''); ?>" type="text" name="title" id="title" placeholder="Article title">

            <?php if (!empty($errors['title'])) { ?>
              <div class="form_error"> <?= $errors['title']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="author" class="form__label">author</label>
            <div class="form__select">
              <select id="author" name="author">
                <option value="">Select the author</option>
                <?php
                  $admin_users_query = 'SELECT id, user_name FROM users WHERE account_type = "admin";';
                  $found_admins = db_query($pdo, $admin_users_query);
                ?>
                <?php if (!empty($found_admins)) { ?>
                  <?php foreach ($found_admins as $admin) { ?>
                    <option value="<?= $admin['id']; ?>" <?= !empty($article_row[0]['user_id']) && $article_row[0]['user_id'] == $admin['id'] ? 'selected' : '' ?>><?= $admin['user_name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="category" class="form__label">category</label>
            <div class="form__select">
              <select id="category" name="category">
                <option value="">Select category</option>
                <?php
                  $categories_query = 'SELECT id, category_name FROM categories;';
                  $found_categories = db_query($pdo, $categories_query);
                ?>
                <?php if (!empty($found_categories)) { ?>
                  <?php foreach ($found_categories as $category) { ?>
                    <option value="<?= $category['id']; ?>" <?= !empty($article_row[0]['category_id']) && $article_row[0]['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['category_name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="thumbnail" class="form__label">upload thumbnail <span class="form__label__star">*</span></label>
              <div class="user__form__upload-container js-form-upload-container">
                <label class="form__upload">
                  <span class="form__upload__text">
                    <i class="ri-upload-2-line" aria-hidden="true"></i>
                    Click or Drag file here...
                  </span>
                  <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                  <input type="file" name="thumbnail" id="thumbnail" class="form__upload__input js-form-upload-input">
                </label>

                <div class="form__image-preview">
                  <span>Thumbnail preview:</span>
                  <img src="<?= get_image_path(!empty($article_row[0]['thumbnail']) ? $article_row[0]['thumbnail'] : 'noimage.jpg'); ?>" class="form__image-preview__image js-form-upload-preview-image" alt="article thumbnail">
                </div>
              </div>

            <?php if (!empty($errors['thumbnail'])) { ?>
              <div class="form_error"> <?= $errors['thumbnail']; ?> </div>
            <?php } ?>

          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="fullimage" class="form__label">upload full image <span class="form__label__star">*</span></label>
            <div class="user__form__upload-container js-form-upload-container">
              <label class="form__upload">
                <span class="form__upload__text">
                  <i class="ri-upload-2-line" aria-hidden="true"></i>
                  Click or Drag file here...
                </span>
                <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                <input type="file" name="fullimage" id="fullimage" class="form__upload__input js-form-upload-input">
              </label>

              <div class="form__image-preview">
                <span>Full image preview:</span>
                <img src="<?= get_image_path(!empty($article_row[0]['full_image']) ? $article_row[0]['full_image'] : 'noimage.jpg'); ?>" class="form__image-preview__image js-form-upload-preview-image" alt="article full image">
              </div>
            </div>

            <?php if (!empty($errors['full_image'])) { ?>
              <div class="form_error"> <?= $errors['full_image']; ?> </div>
            <?php } ?>

          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="content" class="form__label">content</label>
            <textarea name="content" class="js-summernote" id="content" placeholder="Article content"><?= $article_row[0]['content'] ?? ''; ?></textarea>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form_checkbox">
              <label for="homeslider" class="form__label">Home slider</label>
              <input class="form_checkbox__input" <?= $article_row[0]['is_home_slider'] == '1' ? 'checked' : '' ?> type="checkbox" name="homeslider" id="homeslider" value="1">
              <label for="homeslider">Show on home slider</label>
            </div>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form_checkbox">
              <label for="featured" class="form__label">Featured</label>
              <input class="form_checkbox__input" <?= $article_row[0]['is_featured'] == '1' ? 'checked' : '' ?> type="checkbox" name="featured" id="featured" value="1">
              <label for="featured">Show in featured section</label>
            </div>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form_checkbox">
              <label for="dailyfeatured" class="form__label">Daily featured</label>
              <input class="form_checkbox__input" <?= $article_row[0]['is_daily_featured'] == '1' ? 'checked' : '' ?> type="checkbox" name="dailyfeatured" id="dailyfeatured" value="1">
              <label for="dailyfeatured">Show in daily featured section</label>
            </div>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="tags" class="form__label">tags</label>
            <input value="<?= htmlspecialchars($article_row[0]['tags'] ?? ''); ?>" type="text" name="tags" id="tags" placeholder="Tags divided by commas (,)">

            <?php if (!empty($errors['tags'])) { ?>
              <div class="form_error"> <?= $errors['tags']; ?> </div>
            <?php } ?>
          </div>
        </div>
        
        <div class="form__row form__row--submit form__row--buttons">
          <button class="btn btn--primary form__submit-btn" type="submit">Edit article</button>
          <a href="<?=ROOT?>/admin/articles" class="btn btn--secondary">
            <i class="ri-arrow-go-back-line" aria-hidden="true"></i>
            Go back
          </a>
        </div>

      </form>
    </section>

    </div>
  </main>

  <!-- ----- jquery to summernote -----  -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- ----- summernote js -----  -->
  <script src="<?=ROOT?>/assets/summernote/summernote-lite.min.js"></script>

  <!-- run summernote -->
  <script>
    $(document).ready(function() {
      $('.js-summernote').summernote({height: 500, tabsize: 2,});
    });
  </script>

<?php }
else { ?>
  <?php generate_alert('User not found.', 'error'); ?>
<?php } ?>

<?php }
else if ($action == 'delete') { ?>

<?php if (isset($article_row[0])) { ?>
  <main class="main">
    <h1 class="main__title">Delete article</h1>

    <div class="main__container">

      <!-- === DELETE ARTICLE FORM === -->
    <section class="delete-article">
      <form method="post" class="form user__form">
        <div class="form__question">Are You sure to delete this article?</div>

        <div class="form__row">
          <div class="form__field">
            <div class="form__label">Article title</div>
            <input disabled value="<?= htmlspecialchars($article_row[0]['title'] ?? ''); ?>" type="text" id="title">
          </div>
        </div>
        
        <div class="form__row form__row--submit form__row--buttons">
          <button class="btn btn--primary form__submit-btn" type="submit">Delete article</button>
          <a href="<?=ROOT?>/admin/articles" class="btn btn--secondary">
            <i class="ri-arrow-go-back-line" aria-hidden="true"></i>
            Go back
          </a>
        </div>

      </form>
    </section>

    </div>
  </main>
<?php }
else { ?>
<?php generate_alert('Article not found.', 'error'); ?>
<?php } ?>

<?php }
else { ?>

<!-- === ARTICLES TABLE === -->
<main class="main">
  <h1 class="main__title">Articles</h1>

  <div class="main__container">
    <div class="buttons-container">
      <a class="btn btn--primary" href="<?=ROOT?>/admin/articles/add">
        <i class="ri-file-add-line" aria-hidden="true"></i>
        Add new article
      </a>
    </div>

    <table class="table">
      <thead>
        <th>Id</th>
        <th>Thumbnail</th>
        <th>Title</th>
        <th>Category</th>
        <th>Home slider</th>
        <th>Featured</th>
        <th>Daily featured</th>
        <th>Actions</th>
      </thead>

      <?php
        $all_articles_query = 'SELECT * FROM articles ORDER BY id ASC';
        $found_articles = db_query($pdo, $all_articles_query);
      ?>

      <?php if (!empty($found_articles)) { ?>
      <tbody>
        <?php foreach($found_articles as $article) { ?>

          <?php
            $category_query = 'SELECT * FROM categories WHERE id = :id';
            $found_category = db_query($pdo, $category_query, ['id' => $article['category_id']]);
            $category_name = $found_category[0]["category_name"] ?? 'Not assigned';
          ?>

          <tr>
            <td data-label="Id"><?= $article['id'] ?></td>
            <td data-label="Thumbnail">
              <div class="table__thumbnail">
                <img src="<?= htmlspecialchars(get_image_path($article['thumbnail'])) ?>" alt="article thumbnail">
              </div>
            </td>
            <td data-label="Title"><?= htmlspecialchars($article['title']) ?></td>
            <td data-label="Category"><?= htmlspecialchars($category_name); ?></td>
            <td data-label="Home slider">
              <span class="table__status table__status--<?= $article['is_home_slider'] ? 'active' : 'inactive' ?>"></span>
            </td>
            <td data-label="Featured">
              <span class="table__status table__status--<?= $article['is_featured'] ? 'active' : 'inactive' ?>"></span>
            </td>
            <td data-label="Daily featured">
              <span class="table__status table__status--<?= $article['is_daily_featured'] ? 'active' : 'inactive' ?>"></span>
            </td>
            <td data-label="Actions">
              <div class="table__buttons">
                <a class="table__buttons__button table__buttons__button--edit" href="<?=ROOT?>/admin/articles/edit/<?=$article['id']?>">
                  <i class="ri-edit-2-line" aria-hidden="true"></i>
                  <span class="visually-hidden">Edit article</span>
                </a>

                <a class="table__buttons__button table__buttons__button--delete" href="<?=ROOT?>/admin/articles/delete/<?=$article['id']?>">
                  <i class="ri-delete-bin-line" aria-hidden="true"></i>
                  <span class="visually-hidden">Delete article</span>
                </a>
              </div>
            </td>
          </tr>

        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
</main>

<?php
if(isset($_SESSION['ARTICLE_ADDED']) && $_SESSION['ARTICLE_ADDED'] === true) {
  unset($_SESSION['ARTICLE_ADDED']);
  generate_alert('New article has been successfully added.', 'success');
}
?>

<?php
if(isset($_SESSION['ARTICLE_EDITED']) && $_SESSION['ARTICLE_EDITED'] === true) {
  unset($_SESSION['ARTICLE_EDITED']);
  generate_alert('Article data has been successfully edited.', 'success');
}
?>

<?php
if(isset($_SESSION['ARTICLE_DELETED']) && $_SESSION['ARTICLE_DELETED'] === true) {
  unset($_SESSION['ARTICLE_DELETED']);
  generate_alert('Article has been successfully deleted.', 'success');
}
?>

<?php } ?>
