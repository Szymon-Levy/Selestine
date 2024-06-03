/* === USERS CRUD === */
const $avatarInput = document.querySelector('.js-user-form-avatar-input')
const $avatarImage = document.querySelector('.js-user-form-avatar-image')

/**
 * Updates avatar preview after selecting file from explorer.
 */
const updateAvatar = (e) => {
  const file = e.target.files[0]
  $avatarImage.src = URL.createObjectURL(file)
}

if ($avatarInput) { 
  $avatarInput.addEventListener('change', updateAvatar) 
}