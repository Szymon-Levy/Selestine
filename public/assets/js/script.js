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