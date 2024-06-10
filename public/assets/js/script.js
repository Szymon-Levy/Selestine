/* === NAVIGATION BAR === */

/* FIXED NAV WHILE SCROLLING DOWN */
const $nav = document.querySelector('.js-nav')

/**
 * Checks if window is scrolled over particular distance and adds or removes class from nav bar.
 */
const fixedNav = function () {
  if (this.scrollY > 500) {
    $nav.classList.add('nav--fixed')
  } else {
    $nav.classList.remove('nav--fixed')
  }
}

if ($nav) {
  window.addEventListener('scroll', fixedNav)
}

/* NAV TOGGLER ON MOBILE */
const $navToggler = document.querySelector('.js-nav-toggler');
const $navTogglerIcon = document.querySelector('.js-nav-toggler-icon');
const $navList = document.querySelector('.js-nav-list');

/**
 * Toggles navigation on mobile and changes hamburger icon into closing icon.
 */
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

/* PROFILE DROPDOWN */
const $profileDropdown = document.querySelector('.js-nav-profile')
const $profileDropdownButton = document.querySelector('.js-nav-profile-button')
const $profileDropdownMenu = document.querySelector('.js-nav-profile-menu')

/**
 * Checks if dropdown is expanded.
 */
const isDropdownExpanded = () => {
  return $profileDropdownButton.getAttribute("aria-expanded")
}

/**
 * Opens profile dropdown.
 */
const openProfileDropdown = () => {
  $profileDropdownButton.setAttribute("aria-expanded", "true")
  $profileDropdownMenu.classList.add('active')
}

/**
 * Closes profile dropdown.
 */
const closeProfileDropdown = () => {
  $profileDropdownButton.setAttribute("aria-expanded", "false")
  $profileDropdownMenu.classList.remove('active')
}

/**
 * Controls opening and closing profile dropdown.
 */
const toggleProfileDropdown = () => {
  if (isDropdownExpanded() === 'false') {
    openProfileDropdown()
  } else {
    closeProfileDropdown()
  }
}

/**
 * Closes profile dropdown when clicking outside its area.
 */
const handleClickingOutside = (e) => {
  const $target = e.target

  if ($profileDropdown.contains($target)) { return false }

  if (isDropdownExpanded() === 'true') {
    closeProfileDropdown()
  }
}

/**
 * Handles profile dropdown events.
 */
const handleProfileDropdown = () => {
  const $profileDropdownButton = $profileDropdown.querySelector('.js-nav-profile-button')

  $profileDropdownButton.addEventListener('click', toggleProfileDropdown)
  window.addEventListener('click', handleClickingOutside)
}

if ($profileDropdown) { handleProfileDropdown() }

/* === HOME PAGE === */

/* HOME SLIDER */
const homeSlider = new Swiper('.js-home-slider', {
  loop: true,
  draggable: true,
  grabCursor: true,
  effect: 'fade',
  autoplay: {
    delay: 3500,
  },
  speed: 1000,
  navigation: {
    nextEl: '.slider__controls__button--next',
    prevEl: '.slider__controls__button--prev',
  },
});

/* HOME CAROUSEL */
const homeCarousel = new Swiper('.js-home-carousel', {
  loop: true,
  draggable: true,
  autoplay: {
    delay: 2500,
  },
  speed: 1000,
  navigation: {
    nextEl: '.slider__controls__button--next',
    prevEl: '.slider__controls__button--prev',
  },
});

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
