<?php if ($action == 'add') { ?>

  <main class="main">
    <h1 class="main__title">Add new user</h1>

    <div class="main__container">

      <!-- === ADD USER FORM === -->
      <section class="add-user">
        <form method="post" class="form user__form" enctype="multipart/form-data">
          <div class="form__row">
            <div class="form__field">
              <div class="js-form-upload-container">
                <label for="avatar" class="form__label">upload avatar</label>
                <label class="form__upload">
                  <span class="form__upload__text">
                    <i class="ri-upload-2-line" aria-hidden="true"></i>
                    Click or Drag file here...
                  </span>
                  <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                  <input type="file" name="avatar" id="avatar" class="form__upload__input js-form-upload-input">
                </label>
  
                <?php if (!empty($errors['avatar'])) { ?>
                  <div class="form_error"> <?= $errors['avatar']; ?> </div>
                <?php } ?>
  
                <div class="form__image-preview user__form__avatar-preview">
                  <span>Avatar preview:</span>
                  <img src="<?= get_image_path('users/avatars/default-profile-picture.jpg'); ?>" class="form__image-preview__image form__avatar__img user__form__avatar-preview__img js-form-upload-preview-image" alt="user avatar">
                </div>
              </div>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="firstname" class="form__label">first name</label>
              <input value="<?= $first_name ?? ''; ?>" type="text" name="firstname" id="firstname" placeholder="First name">

              <?php if (!empty($errors['first_name'])) { ?>
                <div class="form_error"> <?= $errors['first_name']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="username" class="form__label">user name <span class="form__label__star">*</span></label>
              <input value="<?= $user_name ?? ''; ?>" type="text" name="username" id="username" placeholder="username">

              <?php if (!empty($errors['user_name'])) { ?>
                <div class="form_error"> <?= $errors['user_name']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="email" class="form__label">email <span class="form__label__star">*</span></label>
              <input value="<?= $email ?? ''; ?>" type="text" name="email" id="email" placeholder="email">

              <?php if (!empty($errors['email'])) { ?>
                <div class="form_error"> <?= $errors['email']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="password" class="form__label">password <span class="form__label__star">*</span></label>
              <input type="password" name="password" id="password" placeholder="password">

              <?php if (!empty($errors['password'])) { ?>
                <div class="form_error"> <?= $errors['password']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="retype-password" class="form__label">retype password <span class="form__label__star">*</span></label>
              <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

              <?php if (!empty($errors['password2'])) { ?>
                <div class="form_error"> <?= $errors['password2']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="about" class="form__label">about user</label>
              <textarea name="about" id="about" placeholder="Description about user"><?= isset($about) ? htmlspecialchars($about) : ''; ?></textarea>

              <?php if (!empty($errors['about'])) { ?>
                <div class="form_error"> <?= $errors['about']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="instagram" class="form__label">instagram username</label>
              <input value="<?= $instagram ?? ''; ?>" type="text" name="instagram" id="instagram" placeholder="@">

              <?php if (!empty($errors['instagram'])) { ?>
                <div class="form_error"> <?= $errors['instagram']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="facebook" class="form__label">facebook username</label>
              <input value="<?= $facebook ?? ''; ?>" type="text" name="facebook" id="facebook" placeholder="@">

              <?php if (!empty($errors['facebook'])) { ?>
                <div class="form_error"> <?= $errors['facebook']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <label for="twitter" class="form__label">twitter username</label>
              <input value="<?= $twitter ?? ''; ?>" type="text" name="twitter" id="twitter" placeholder="@">

              <?php if (!empty($errors['twitter'])) { ?>
                <div class="form_error"> <?= $errors['twitter']; ?> </div>
              <?php } ?>
            </div>
          </div>

          <div class="form__row">
            <div class="form__field">
              <div class="form_checkbox">
                <label for="type" class="form__label">account type</label>
                <input class="form_checkbox__input" <?= !empty($type) && $type == 'admin' ? 'checked' : '' ?> type="checkbox" name="type" id="type" value="admin">
                <label for="type">Admin account</label>
              </div>
            </div>
          </div>
          
          <div class="form__row form__row--submit form__row--buttons">
            <button class="btn btn--primary form__submit-btn" type="submit">Add account</button>
            <a href="<?=ROOT?>/admin/users" class="btn btn--secondary">
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

  <?php if ($user) { ?>
    <main class="main">
      <h1 class="main__title">Edit user</h1>

      <div class="main__container">

        <!-- === EDIT USER FORM === -->
        <section class="edit-user">
          <form method="post" class="form user__form" enctype="multipart/form-data">

            <div class="form__row">
              <div class="form__field">
                <div class="js-form-upload-container">
                  <label for="avatar" class="form__label">upload avatar</label>
                  <label class="form__upload">
                    <span class="form__upload__text">
                      <i class="ri-upload-2-line" aria-hidden="true"></i>
                      Click or Drag file here...
                    </span>
                    <span role="presentation" class="form__upload__file-name js-form-upload-filelabel">No file selected</span>
                    <input type="file" name="avatar" id="avatar" class="form__upload__input js-form-upload-input">
                  </label>
    
                  
                  <?php if (!empty($errors['avatar'])) { ?>
                    <div class="form_error"> <?= $errors['avatar']; ?> </div>
                  <?php } ?>
    
                  <div class="form__image-preview user__form__avatar-preview">
                    <span>Avatar preview:</span>
                    <img src="<?= htmlspecialchars(get_image_path($user['avatar'])) ?>" class="form__image-preview__image form__avatar__img user__form__avatar-preview__img js-form-upload-preview-image" alt="user avatar">
                  </div>
                </div>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="firstname" class="form__label">first name</label>
                <input value="<?= htmlspecialchars($user['first_name'] ?? ''); ?>" type="text" name="firstname" id="firstname" placeholder="First name">

                <?php if (!empty($errors['first_name'])) { ?>
                  <div class="form_error"> <?= $errors['first_name']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="username" class="form__label">user name</label>
                <input value="<?= htmlspecialchars($user['user_name'] ?? ''); ?>" type="text" name="username" id="username" placeholder="username">

                <?php if (!empty($errors['user_name'])) { ?>
                  <div class="form_error"> <?= $errors['user_name']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="email" class="form__label">email</label>
                <input value="<?= htmlspecialchars($user['email'] ?? ''); ?>" type="text" name="email" id="email" placeholder="email">

                <?php if (!empty($errors['email'])) { ?>
                  <div class="form_error"> <?= $errors['email']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="password" class="form__label">password</label>
                <input type="password" name="password" id="password" placeholder="password (leave blank if it should remain unchanged)">

                <?php if (!empty($errors['password'])) { ?>
                  <div class="form_error"> <?= $errors['password']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="retype-password" class="form__label">retype password</label>
                <input type="password" name="retype-password" id="retype-password" placeholder="retype password">

                <?php if (!empty($errors['password2'])) { ?>
                  <div class="form_error"> <?= $errors['password2']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="about" class="form__label">about user</label>
                <textarea name="about" id="about" placeholder="Description about user"><?= $user['about'] ?? ''; ?></textarea>

                <?php if (!empty($errors['about'])) { ?>
                  <div class="form_error"> <?= $errors['about']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="instagram" class="form__label">instagram username</label>
                <input value="<?= $user['instagram'] ?? ''; ?>" type="text" name="instagram" id="instagram" placeholder="@">

                <?php if (!empty($errors['instagram'])) { ?>
                  <div class="form_error"> <?= $errors['instagram']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="facebook" class="form__label">facebook username</label>
                <input value="<?= $user['facebook'] ?? ''; ?>" type="text" name="facebook" id="facebook" placeholder="@">

                <?php if (!empty($errors['facebook'])) { ?>
                  <div class="form_error"> <?= $errors['facebook']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="twitter" class="form__label">twitter username</label>
                <input value="<?= $user['twitter'] ?? ''; ?>" type="text" name="twitter" id="twitter" placeholder="@">

                <?php if (!empty($errors['twitter'])) { ?>
                  <div class="form_error"> <?= $errors['twitter']; ?> </div>
                <?php } ?>
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <label for="type" class="form__label">account type</label>
                <div class="form_checkbox">
                  <input class="form_checkbox__input" <?= $user['account_type'] == 'admin' ? 'checked' : '' ?> type="checkbox" name="type" id="type" value="admin">
                  <label for="type">Admin account</label>
                </div>
              </div>
            </div>
            
            <div class="form__row form__row--submit form__row--buttons">
              <button class="btn btn--primary form__submit-btn" type="submit">Edit account</button>
              <a href="<?=ROOT?>/admin/users" class="btn btn--secondary">
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
    <?php generate_alert('User not found.', 'error'); ?>
  <?php } ?>

<?php }

else if ($action == 'delete') { ?>

  <?php if ($user) { ?>
      <main class="main">
        <h1 class="main__title">Delete user</h1>

        <div class="main__container">

          <!-- === DELETE USER FORM === -->
        <section class="delete-user">
          <form method="post" class="form user__form">
            <div class="form__question">Are You sure to delete this user?</div>

            <div class="form__row">
              <div class="form__field">
                <div class="form__label">user name</div>
                <input disabled value="<?= htmlspecialchars($user['user_name'] ?? ''); ?>" type="text" name="username" id="username" placeholder="username">
              </div>
            </div>

            <div class="form__row">
              <div class="form__field">
                <div class="form__label">user email</div>
                <input disabled value="<?= htmlspecialchars($user['email'] ?? ''); ?>" type="text" name="email" id="email" placeholder="email">
              </div>
            </div>
            
            <div class="form__row form__row--submit form__row--buttons">
              <button class="btn btn--primary form__submit-btn" type="submit">Delete account</button>
              <a href="<?=ROOT?>/admin/users" class="btn btn--secondary">
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
    <?php generate_alert('User not found.', 'error'); ?>
  <?php } ?>

<?php }

else { ?>

  <!-- === USERS TABLE === -->
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
          $users = db_query($pdo, $all_users_query)->fetchAll();
        ?>

        <?php if (!empty($users)) { ?>
        <tbody>
          <?php foreach($users as $user) { ?>

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
                    <i class="ri-edit-2-line" aria-hidden="true"></i>
                    <span class="visually-hidden">Edit user</span>
                  </a>

                  <a class="table__buttons__button table__buttons__button--delete" href="<?=ROOT?>/admin/users/delete/<?=$user['id']?>">
                    <i class="ri-delete-bin-line" aria-hidden="true"></i>
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
    if(isset($_SESSION['USER_DELETE_FORBIDDEN']) && $_SESSION['USER_DELETE_FORBIDDEN'] === true) {
      unset($_SESSION['USER_DELETE_FORBIDDEN']);
      generate_alert('Admin cannot be deleted.', 'error');
    }
  ?>

  <?php
    if(isset($_SESSION['USER_DELETED']) && $_SESSION['USER_DELETED'] === true) {
      unset($_SESSION['USER_DELETED']);
      generate_alert('User has been successfully deleted.', 'success');
    }
  ?>

<?php } ?>