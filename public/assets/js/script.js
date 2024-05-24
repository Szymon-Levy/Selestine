/* === NAVIGATION BAR === */
const $navToggler = document.querySelector('.js-nav-toggler');
const $navTogglerIcon = document.querySelector('.js-nav-toggler-icon');
const $navList = document.querySelector('.js-nav-list');

const navToggle = () => {
  if ($navList.classList.contains('active')) {
    $navList.classList.remove('active')
    $navTogglerIcon.classList.remove('ri-close-line')
    $navTogglerIcon.classList.add('ri-menu-3-line')
  } else {
    $navList.classList.add('active')
    $navTogglerIcon.classList.remove('ri-menu-3-line')
    $navTogglerIcon.classList.add('ri-close-line')
  }
}

$navToggler.addEventListener('click', navToggle);

/* === BOTTOM GALLERY === */

const swiper = new Swiper('.js-bottom-gallery-swiper', {
  loop: true,
  slidesPerView: 2,
  draggable: true,
  grabCursor: true,
  autoplay: {
    delay: 1500,
  },
  speed: 700,
  breakpoints: {
    768: {
      slidesPerView: 3,
    },
    992: {
      slidesPerView: 4,
    },
    1200: {
      slidesPerView: 5,
    }
  }
});

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
  }, 5000);
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
