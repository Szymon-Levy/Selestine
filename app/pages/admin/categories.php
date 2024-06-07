<?php if ($action == 'add') { ?>

<main class="main">
  <h1 class="main__title">Add new category</h1>

  <div class="main__container">

    <!-- === ADD CATEGORY FORM === -->
    <section class="add-category">
      <form method="post" class="form category__form" enctype="multipart/form-data">
        <div class="form__row">
          <div class="form__field">
            <label for="categoryname" class="form__label">category name <span class="form__label__star">*</span></label>
            <input value="<?= $category_name ?? ''; ?>" type="text" name="categoryname" id="categoryname" placeholder="Category name">

            <?php if (!empty($errors['category_name'])) { ?>
              <div class="form_error"> <?= $errors['category_name']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form_checkbox">
              <label for="activity" class="form__label">activity</label>
              <input class="form_checkbox__input" <?= !empty($is_active) && $is_active == '1' ? 'checked' : '' ?> type="checkbox" name="activity" id="activity" value="1">
              <label for="activity">Active</label>
            </div>
          </div>
        </div>
        
        <div class="form__row form__row--submit form__row--buttons">
          <button class="btn btn--primary form__submit-btn" type="submit">Add category</button>
          <a href="<?=ROOT?>/admin/categories" class="btn btn--secondary">
            <i class="ri-arrow-go-back-line" aria-hidden="true"></i>
            Go back
          </a>
        </div>

      </form>
    </section>

  </div>
</main>

<?php }
else if ($action == 'edit') { ?>

<?php if (isset($category_row[0])) { ?>
  <main class="main">
    <h1 class="main__title">Edit category</h1>

    <div class="main__container">

      <!-- === EDIT CATEGORY FORM === -->
    <section class="edit-category">
      <form method="post" class="form user__form" enctype="multipart/form-data">

        <div class="form__row">
          <div class="form__field">
            <label for="categoryname" class="form__label">category name</label>
            <input value="<?= htmlspecialchars($category_row[0]['category_name'] ?? ''); ?>" type="text" name="categoryname" id="categoryname" placeholder="Category name">

            <?php if (!empty($errors['category_name'])) { ?>
              <div class="form_error"> <?= $errors['category_name']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <label for="activity" class="form__label">activity</label>
            <div class="form_checkbox">
              <input class="form_checkbox__input" <?= $category_row[0]['is_active'] ? 'checked' : '' ?> type="checkbox" name="activity" id="activity" value="1">
              <label for="activity">Active</label>
            </div>
          </div>
        </div>
        
        <div class="form__row form__row--submit form__row--buttons">
          <button class="btn btn--primary form__submit-btn" type="submit">Edit category</button>
          <a href="<?=ROOT?>/admin/categories" class="btn btn--secondary">
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
  <?php generate_alert('Category not found.', 'error'); ?>
<?php } ?>

<?php }
else if ($action == 'delete') { ?>

<?php if (isset($category_row[0])) { ?>
  <main class="main">
    <h1 class="main__title">Delete category</h1>

    <div class="main__container">

      <!-- === DELETE CATEGORY FORM === -->
    <section class="delete-category">
      <form method="post" class="form user__form">
        <div class="form__question">Are You sure to delete this category?</div>

        <div class="form__row">
          <div class="form__field">
            <div class="form__label">category name</div>
            <input disabled value="<?= htmlspecialchars($category_row[0]['category_name'] ?? ''); ?>" type="text" name="categoryname" id="categoryname">
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form__label">slug</div>
            <input disabled value="<?= htmlspecialchars($category_row[0]['slug'] ?? ''); ?>" type="text" name="slug'" id="slug'">
          </div>
        </div>
        
        <div class="form__row form__row--submit form__row--buttons">
          <button class="btn btn--primary form__submit-btn" type="submit">Delete category</button>
          <a href="<?=ROOT?>/admin/categories" class="btn btn--secondary">
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
<?php generate_alert('Category not found.', 'error'); ?>
<?php } ?>

<?php }
else { ?>

<!-- === CATEGORIES TABLE === -->
<main class="main">
<h1 class="main__title">Categories</h1>

<div class="main__container">
  <div class="buttons-container">
    <a class="btn btn--primary" href="<?=ROOT?>/admin/categories/add">
      <i class="ri-folder-add-line" aria-hidden="true"></i>
      Add new category
    </a>
  </div>

  <table class="table">
    <thead>
      <th>Id</th>
      <th>Category name</th>
      <th>Slug</th>
      <th>Status</th>
      <th>Actions</th>
    </thead>

    <?php
      $all_categories_query = 'SELECT * FROM categories ORDER BY id ASC';
      $found_categories = query($pdo, $all_categories_query);
    ?>

    <?php if (!empty($found_categories)) { ?>
    <tbody>
      <?php foreach($found_categories as $category) { ?>

        <tr>
          <td data-label="Id"><?= $category['id'] ?></td>
          <td data-label="Category name"><?= htmlspecialchars($category['category_name']) ?></td>
          <td data-label="Slug"><?= $category['slug'] ?></td>
          <td data-label="Status">
            <span class="table__status table__status--<?= $category['is_active'] ? 'active' : 'inactive' ?>">
          </span>
          </td>
          <td data-label="Actions">
            <div class="table__buttons">
              <a class="table__buttons__button table__buttons__button--edit" href="<?=ROOT?>/admin/categories/edit/<?=$category['id']?>">
                <i class="ri-edit-2-line" aria-hidden="true"></i>
                <span class="visually-hidden">Edit category</span>
              </a>

              <a class="table__buttons__button table__buttons__button--delete" href="<?=ROOT?>/admin/categories/delete/<?=$category['id']?>">
                <i class="ri-delete-bin-line" aria-hidden="true"></i>
                <span class="visually-hidden">Delete category</span>
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
if(isset($_SESSION['CATEGORY_ADDED']) && $_SESSION['CATEGORY_ADDED'] === true) {
  unset($_SESSION['CATEGORY_ADDED']);
  generate_alert('New user has been successfully added.', 'success');
}
?>

<?php
if(isset($_SESSION['CATEGORY_EDITED']) && $_SESSION['CATEGORY_EDITED'] === true) {
  unset($_SESSION['CATEGORY_EDITED']);
  generate_alert('User data has been successfully edited.', 'success');
}
?>

<?php
if(isset($_SESSION['CATEGORY_DELETED']) && $_SESSION['CATEGORY_DELETED'] === true) {
  unset($_SESSION['CATEGORY_DELETED']);
  generate_alert('User has been successfully deleted.', 'success');
}
?>

<?php } ?>
