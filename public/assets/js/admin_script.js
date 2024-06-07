/* === SIDEBAR === */

/* SIDEBAR TOGGLE ON MOBILE */
const $sidebar = document.querySelector('.js-sidebar')
const $sidebarToggler = document.querySelector('.js-sidebar-toggler')
const $sidebarTogglerIconMobile = document.querySelector('.js-sidebar-toggler-icon-mobile');
const $sidebarTogglerIconDesktop = document.querySelector('.js-sidebar-toggler-icon-desktop');

/**
 * Returns current width of browser.
 * @return Width in pixels
 */
function getBrowserWidth() {
  return Math.max(
    document.body.scrollWidth,
    document.documentElement.scrollWidth,
    document.body.offsetWidth,
    document.documentElement.offsetWidth,
    document.documentElement.clientWidth
  )
}

/**
 * Toggles navigation on mobile and changes hamburger icon into closing icon.
 */
const sidebarToggleOnMobile = () => {
  if ($sidebar.classList.contains('active')) {
    $sidebar.classList.remove('active')
    $sidebarTogglerIconMobile.classList.remove('ri-menu-fold-line')
    $sidebarTogglerIconMobile.classList.add('ri-menu-unfold-line')
  } else {
    $sidebar.classList.add('active')
    $sidebarTogglerIconMobile.classList.remove('ri-menu-unfold-line')
    $sidebarTogglerIconMobile.classList.add('ri-menu-fold-line')
  }
}

/**
 * Toggles navigation on desktop and changes hamburger icon into closing icon.
 */
const sidebarToggleOnDesktop = () => {
  if (document.body.classList.contains('sidebar-hidden')) {
    document.body.classList.remove('sidebar-hidden')
    $sidebarTogglerIconDesktop.classList.remove('ri-menu-unfold-line')
    $sidebarTogglerIconDesktop.classList.add('ri-menu-fold-line')
  } else {
    document.body.classList.add('sidebar-hidden')
    $sidebarTogglerIconDesktop.classList.remove('ri-menu-fold-line')
    $sidebarTogglerIconDesktop.classList.add('ri-menu-unfold-line')
  }
}

$sidebarToggler.addEventListener('click', () => {
  if (getBrowserWidth() > 992) {
    sidebarToggleOnDesktop()
  } else {
    sidebarToggleOnMobile()
  }
});


/* === USERS CRUD === */
const $uploadInputs = document.querySelectorAll('.js-form-upload-input')

/**
 * Updates label of file uploader.
 * @param {HTMLElement} $input - Input which belongs to particular file uploader.
 * @param {string} content - Text to show in label.
*/
const updateFileLabel = ($input, content) => {
  const $uploadedFileLabel = $input.closest('.js-form-upload-container').querySelector('.js-form-upload-filelabel')
  $uploadedFileLabel.textContent = content
}

/**
 * Updates source of preview image.
 * @param {HTMLElement} $input - Input which belongs to particular file uploader.
 * @param {object} file - Image file which to show in preview.
 */
const updateImagePreview = ($input, file) => {
  const $previewImage = $input.closest('.js-form-upload-container').querySelector('.js-form-upload-preview-image')

  $previewImage.src = URL.createObjectURL(file)
}

/**
 * Checks if file from given event is of the correct type and handles label contents to show.
 * @param {object} e - Event object of file input.
 */
const validateImage = (e) => {
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp']
  const $input = e.target
  const file = $input.files[0]
  if (allowedTypes.indexOf(file.type) > -1) {
    updateFileLabel($input, $input.value.split("\\").pop())
    updateImagePreview($input, file)
  }else {
    updateFileLabel($input, 'Not supported image type');
  }
}

if ($uploadInputs) { 
  $uploadInputs.forEach($input => {
    $input.addEventListener('change', function (e) {
      validateImage(e)
    })
  })
}