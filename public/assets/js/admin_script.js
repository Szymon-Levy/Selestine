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
const $uploadInput = document.querySelector('.js-form-upload-input')
const $uploadImage = document.querySelector('.js-form-avatar-image')
const $uploadFileName = document.querySelector('.js-form-upload-filename')

/**
 * Shows name of file after selecting from explorer.
 */
const updateFileName = () => {
  $uploadFileName.textContent = $uploadInput.value.split("\\").pop()
}

/**
 * Updates image preview after selecting file from explorer.
 */
const updateImage = (e) => {
  const file = e.target.files[0]
  $uploadImage.src = URL.createObjectURL(file)
}

if ($uploadInput) { 
  $uploadInput.addEventListener('change', (e) => {
    updateImage(e)
    updateFileName()
  }) 
}