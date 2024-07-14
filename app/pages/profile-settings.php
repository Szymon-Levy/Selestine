<?php
  if (!is_user_logged_in()) {
    redirect('');
  }

  $user = get_logged_user_data($pdo);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get signup form values
    $first_name = trim($_POST['firstname']) ?? NULL;
    $user_name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['retype-password']);
    $about = trim($_POST['about']) ?? NULL;
    $instagram = $_POST['instagram'] ? trim($_POST['instagram']) : NULL;
    $facebook = $_POST['facebook'] ? trim($_POST['facebook']) : NULL;
    $twitter = $_POST['twitter'] ? trim($_POST['twitter']) : NULL;
    $avatar = $_FILES['avatar'] ?? null;
  
    //validate
    $errors = [];

    //validate avatar
    $current_avatar = $user['avatar'];
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!empty($avatar['name'])) {
      if (!in_array($avatar['type'], $allowed_types)) {
        $errors['avatar'] = 'JPG, PNG and WEBP only allowed!';
      } else if ($avatar['size'] > 300000) {
        $errors['avatar'] = 'Maximum filesize is 300kb!';
      } else {
        $uploaded_image_path = 'users/avatars/' . time() . basename($avatar['name']);
        $current_avatar = $uploaded_image_path;
      }
    }

    if (strlen($first_name) > 50) {
      $errors['first_name'] = 'First name cannot be longer than 50 characters!';
    }
  
    if (empty($user_name)) {
      $errors['user_name'] = 'User name cannot be empty!';
    }
    else if (str_contains($user_name, ' ')) {
      $errors['user_name'] = 'No spaces in user name!';
    }
    else if (strlen($user_name) < 6 || strlen($user_name) > 35) {
      $errors['user_name'] = 'Username cannot be shorter than 6 characters and longer than 35 characters!';
    }
  
    $email_query = 'SELECT id FROM users WHERE email = :email AND id != :id limit 1;';
    $is_email_in_db = db_query($pdo, $email_query, ['email' => $email, 'id' => $id])->fetch();
  
    if (empty($email)) {
      $errors['email'] = 'Email cannot be empty!';
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Wrong email format!';
    }
    else if ($is_email_in_db) {
      $errors['email'] = 'This email is already taken!';
    }
  
    if (!empty($password) && strlen($password) < 8) {
      $errors['password'] = 'Password cannot be shorter than 8 characters!';
    }
    else if ($password !== $password2) {
      $errors['password2'] = 'Passwords do not match!';
    }

    if (strlen($about) > 500) {
      $errors['about'] = 'About text cannot be longer than 500 characters!';
    }

    if (!empty($instagram) && !preg_match('/^[a-zA-Z0-9\-\_]+$/', $instagram)) {
      $errors['instagram'] = 'Not allowed characters used!';
    }

    if (!empty($facebook) && !preg_match('/^[a-zA-Z0-9\-\_]+$/', $facebook)) {
      $errors['facebook'] = 'Not allowed characters used!';
    }

    if (!empty($twitter) && !preg_match('/^[a-zA-Z0-9\-\_]+$/', $twitter)) {
      $errors['twitter'] = 'Not allowed characters used!';
    }
  
    if(empty($errors)) {
      //upload new avatar and delete the old one
      if ($current_avatar != 'users/avatars/default-profile-picture.jpg') {
        move_uploaded_file($avatar['tmp_name'], FILESYSTEM_PATH . '/assets/images/' . $uploaded_image_path);
        if ($user['avatar'] != 'users/avatars/default-profile-picture.jpg' && $user['avatar'] != $current_avatar) {
          delete_image($user['avatar']);
        }
      }

      //edit user in database
      $arguments                 = [];
      $arguments['id']           = $user['id'];
      $arguments['first_name']   = $first_name;
      $arguments['user_name']    = $user_name;
      $arguments['email']        = $email;
      $arguments['about']        = $about;
      $arguments['instagram']    = $instagram;
      $arguments['facebook']     = $facebook;
      $arguments['twitter']      = $twitter;
      $arguments['avatar']       = $current_avatar;
      
      if (empty($password)) {
        $query = 'UPDATE users 
                  SET first_name = :first_name, user_name = :user_name, email = :email, about = :about, instagram = :instagram, facebook = :facebook, twitter = :twitter, avatar = :avatar 
                  WHERE id = :id;';
      }
      else {
        $arguments['pass'] = hash_password($password);
        $query = 'UPDATE users 
                  SET first_name = :first_name, user_name = :user_name, email = :email, about = :about, instagram = :instagram, facebook = :facebook, twitter = :twitter, pass = :pass, avatar = :avatar 
                  WHERE id = :id;';
      }
      
      db_query($pdo, $query, $arguments);
      
      $_SESSION['PROFILE_EDITED'] = true;
      redirect('profile-settings');
    }
  }
?>

<?php
  $page_title = 'Profile settings';
  include '../app/pages/includes/top.php';
?>

<!-- === PROFILE SETTINGS FORM === -->
<section class="profile-settings">
  <div class="container">
    <div class="row">
      <form method="post" class="form profile-settings__form" enctype="multipart/form-data">
    
        <div class="profile-settings__form__side-col">
          <h1 class="profile-settings__form__title title title--h3">Edit Avatar</h1>

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
    
              <div class="profile-settings__form__avatar-preview">
                <span>Avatar preview:</span>
                <img src="<?= htmlspecialchars(get_image_path($user['avatar'])) ?>" class="profile-settings__form__avatar-preview__img js-form-upload-preview-image" alt="user avatar">
              </div>
            </div>
          </div>
        </div>

        <div class="profile-settings__form__main-col">
          <h1 class="profile-settings__form__title title title--h3">Edit profile info</h1>

          <div class="form__row">
            <div class="form__field">
              <label for="firstname" class="form__label">first name</label>
              <input value="<?= htmlspecialchars($user['first_name'] ?? ''); ?>" type="text" name="firstname" id="firstname" placeholder="First name">
      
              <?php if (!empty($errors['first_name'])) { ?>
                <div class="form_error"> <?= $errors['first_name']; ?> </div>
              <?php } ?>
            </div>
  
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
  
            <div class="form__field">
              <label for="facebook" class="form__label">facebook username</label>
              <input value="<?= $user['facebook'] ?? ''; ?>" type="text" name="facebook" id="facebook" placeholder="@">
      
              <?php if (!empty($errors['facebook'])) { ?>
                <div class="form_error"> <?= $errors['facebook']; ?> </div>
              <?php } ?>
            </div>
  
            <div class="form__field">
              <label for="twitter" class="form__label">twitter username</label>
              <input value="<?= $user['twitter'] ?? ''; ?>" type="text" name="twitter" id="twitter" placeholder="@">
      
              <?php if (!empty($errors['twitter'])) { ?>
                <div class="form_error"> <?= $errors['twitter']; ?> </div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form__row form__row--submit form__row--buttons">
            <button class="btn btn--accent form__submit-btn" type="submit">Save changes</button>
            <a href="<?=ROOT?>/profile/<?= $user['id'] ?>" class="btn btn--primary">
              <i class="ri-user-line" aria-hidden="true"></i>
              See my profile
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<?php
  if(isset($_SESSION['PROFILE_EDITED']) && $_SESSION['PROFILE_EDITED'] === true) {
    unset($_SESSION['PROFILE_EDITED']);
    $message_block = generate_alert('Profile changes have been updated.', 'success');
  }
?>

<?php include '../app/pages/includes/bottom.php'; ?>