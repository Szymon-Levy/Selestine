/* === ALERTS === */
const $alert = document.querySelector('.js-alert')

/**
 * Hides alert and after 300 miliseconds removes it from DOM.
 */
const closeAlert = () => {
  if ($alert) {
    $alert.classList.remove('active');
    setTimeout(() => {
      $alert.remove()
    }, 300)
  }
}

/**
 * Hides alert automatically after 5 seconds of not closing it manually.
 */
const autoHideAlert = () => {
  setTimeout(() => {
    closeAlert()
  }, 5000)
}

/**
 * Shows alert after 500 miliseconds.
 */
const showAlert = () => {
  setTimeout(() => {
    $alert.classList.add('active');
    autoHideAlert()
  }, 500)
}

if ($alert) {
  const $closeAlert = document.querySelector('.js-alert-close')

  $closeAlert.addEventListener('click', closeAlert)
  showAlert()
}