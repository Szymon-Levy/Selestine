<?php if ($action == 'add') { ?>

  <main class="main">
  <h1 class="main__title">Add new user</h1>

  <div class="main__container">

    <!-- === ADD USER FORM === -->
    <section class="add-user">
      <form method="post" class="form user__form">
        <div class="form__row">
          <div class="form__field">
            <input value="<?= $user_name ?? ''; ?>" type="text" name="username" id="username" placeholder="username">

            <?php if (!empty($errors['user_name'])) { ?>
              <div class="form_error"> <?= $errors['user_name']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

            <?php if (!empty($errors['email'])) { ?>
              <div class="form_error"> <?= $errors['email']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <input type="password" name="password" id="password" placeholder="password">

            <?php if (!empty($errors['password'])) { ?>
              <div class="form_error"> <?= $errors['password']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

            <?php if (!empty($errors['password2'])) { ?>
              <div class="form_error"> <?= $errors['password2']; ?> </div>
            <?php } ?>
          </div>
        </div>

        <div class="form__row">
          <div class="form__field">
            <div class="form_checkbox">
              <input class="form_checkbox__input" <?= !empty($type) && $type == 'admin' ? 'checked' : '' ?> type="checkbox" name="type" id="type" value="admin">
              <label for="type">Accept terms and conditions</label>
            </div>
          </div>
        </div>
        
        <div class="form__row form__row--submit">
          <button class="btn btn--accent form__submit-btn" type="submit">Add account</button>
        </div>

      </form>
    </section>

  </div>
  </main>

<?php }
else if ($action == 'edit') { ?>

  <?php if (isset($user_row[0])) { ?>
    <main class="main">
      <h1 class="main__title">Edit user</h1>

      <div class="main__container">

        <!-- === EDIT USER FORM === -->
      <section class="edit-user">
        <form method="post" class="form user__form" enctype="multipart/form-data">

        <div class="form__row">
            <div class="form__field">
              <label for="avatar">
                <img src="<?= htmlspecialchars(get_image_path($user_row[0]['avatar'])) ?>" class="js-user-form-avatar-image" alt="user avatar">
              </label>
              <input type="file" name="avatar" id="avatar" class="js-user-form-avatar-input">

              <?php if (!empty($errors['avatar'])) { ?>
                <div class="form_error"> <?= $errors['avatar']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input value="<?= htmlspecialchars($user_row[0]['user_name'] ?? ''); ?>" type="text" name="username" id="username" placeholder="username">

              <?php if (!empty($errors['user_name'])) { ?>
                <div class="form_error"> <?= $errors['user_name']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input value="<?= htmlspecialchars($user_row[0]['email'] ?? ''); ?>" type="text" name="email" id="email" placeholder="email">

              <?php if (!empty($errors['email'])) { ?>
                <div class="form_error"> <?= $errors['email']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input type="password" name="password" id="password" placeholder="password (leave blank if it should remain unchanged)">

              <?php if (!empty($errors['password'])) { ?>
                <div class="form_error"> <?= $errors['password']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

              <?php if (!empty($errors['password2'])) { ?>
                <div class="form_error"> <?= $errors['password2']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <input class="form_checkbox__input" <?= $user_row[0]['account_type'] == 'admin' ? 'checked' : '' ?> type="checkbox" name="type" id="type" value="admin">
                <label for="type">Admin account</label>
              </div>
            </div>
          </div>
          
          <div class="form__row form__row--submit">
            <button class="btn btn--accent form__submit-btn" type="submit">Edit account</button>
          </div>

        </form>
      </section>

      </div>
    </main>
  <?php }
  else { ?>
    <?php generate_alert('User not found.', 'error'); ?>
  <?php } ?>

<?php }
else if ($action == 'delete') { ?>

<?php if (isset($user_row[0])) { ?>
    <main class="main">
      <h1 class="main__title">Delete user</h1>

      <div class="main__container">

        <!-- === DELETE USER FORM === -->
      <section class="delete-user">
        <form method="post" class="form user__form">
          <div class="form__row">
            <div class="form__field">
              <input disabled value="<?= htmlspecialchars($user_row[0]['user_name'] ?? ''); ?>" type="text" name="username" id="username" placeholder="username">
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <input disabled value="<?= htmlspecialchars($user_row[0]['email'] ?? ''); ?>" type="text" name="email" id="email" placeholder="email">
            </div>
          </div>
          
          <div class="form__row form__row--submit">
            <button class="btn btn--accent form__submit-btn" type="submit">Delete account</button>
          </div>

        </form>
      </section>

      </div>
    </main>
<?php }
else { ?>
  <?php generate_alert('User not found.', 'error'); ?>
<?php } ?>

<?php }
else { ?>

<main class="main">
  <h1 class="main__title">Users</h1>

  <div class="main__container">
    <div class="buttons-container">
      <a class="btn btn--primary" href="<?=ROOT?>/admin/users/add">
        <i class="ri-user-add-line" aria-hidden="true"></i>
        Add new user
      </a>
    </div>

    <table class="table">
      <thead>
        <th>Id</th>
        <th>Avatar</th>
        <th>Username</th>
        <th>Email</th>
        <th>Date</th>
        <th>Account</th>
        <th>Actions</th>
      </thead>

      <?php
        $all_users_query = 'SELECT * FROM users ORDER BY id ASC';
        $found_users = query($pdo, $all_users_query);
      ?>

      <?php if (!empty($found_users)) { ?>
      <tbody>
        <?php foreach($found_users as $user) { ?>

          <tr>
            <td data-label="Id"><?= $user['id'] ?></td>
            <td data-label="Avatar">
              <div class="table__avatar">
                <img src="<?= htmlspecialchars(get_image_path($user['avatar'])) ?>" alt="user avatar">
              </div>
            </td>
            <td data-label="Username"><?= htmlspecialchars($user['user_name']) ?></td>
            <td data-label="Email"><?= $user['email'] ?></td>
            <td data-label="Date"><?= date('jS M, Y', strtotime($user['create_date'])) ?></td>
            <td data-label="Account type"><span class="table__account--<?= $user['account_type'] ?>"><?= $user['account_type'] ?></span></td>
            <td data-label="Actions">
              <div class="table__buttons">
                <a class="table__buttons__button table__buttons__button--edit" href="<?=ROOT?>/admin/users/edit/<?=$user['id']?>">
                  <i class="ri-user-settings-line" aria-hidden="true"></i>
                  <span class="visually-hidden">Edit user</span>
                </a>

                <a class="table__buttons__button table__buttons__button--delete" href="<?=ROOT?>/admin/users/delete/<?=$user['id']?>">
                  <i class="ri-user-unfollow-line" aria-hidden="true"></i>
                  <span class="visually-hidden">Delete user</span>
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
  if(isset($_SESSION['USER_ADDED']) && $_SESSION['USER_ADDED'] === true) {
    unset($_SESSION['USER_ADDED']);
    generate_alert('New user has been successfully added.', 'success');
  }
?>

<?php
  if(isset($_SESSION['USER_EDITED']) && $_SESSION['USER_EDITED'] === true) {
    unset($_SESSION['USER_EDITED']);
    generate_alert('User data has been successfully edited.', 'success');
  }
?>

<?php
  if(isset($_SESSION['USER_DELETED']) && $_SESSION['USER_DELETED'] === true) {
    unset($_SESSION['USER_DELETED']);
    generate_alert('User has been successfully deleted.', 'success');
  }
?>

<?php } ?>
