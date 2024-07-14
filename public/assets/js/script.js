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

/* === PROFILE PAGE === */
const $profilePictureBtn = document.querySelector('.js-profile-picture-btn')
const $profilePictureEnlarge = document.querySelector('.js-picture-enlarge')

/**
 * Gets src of picture to enlarge.
 * @returns {string} Src of image
 */
const getProfilePictureSrc = () => {
  return $profilePictureBtn.querySelector('.js-profile-picture-btn-image').src
}

/**
 * Opens popup with original size of profile picture.
 */
const openProfilePictureEnlarge = () => {
  document.body.style.overflowY = 'hidden'
  $profilePictureEnlarge.classList.add('active')
  $profilePictureEnlarge.querySelector('.js-picture-enlarge-image').src = getProfilePictureSrc()
}

/**
 * Closes profile picture popup.
 */
const closeProfilePictureEnlarge = () => {
  document.body.style.overflowY = 'auto'
  $profilePictureEnlarge.classList.remove('active')
}

if ($profilePictureBtn && $profilePictureEnlarge) {
  const $closePopupBtn = $profilePictureEnlarge.querySelector('.js-picture-enlarge-close')

  $profilePictureBtn.addEventListener('click', openProfilePictureEnlarge)
  $closePopupBtn.addEventListener('click', closeProfilePictureEnlarge)
}

/* === PROFILE SETTINGS === */
const $uploadInputs = document.querySelectorAll('.js-form-upload-input')

/**
 * Updates label of file uploader.
 * @param {HTMLElement} $input - Input which belongs to particular file uploader
 * @param {string} content - Text to show in label
*/
const updateFileLabel = ($input, content) => {
  const $uploadedFileLabel = $input.closest('.js-form-upload-container').querySelector('.js-form-upload-filelabel')
  $uploadedFileLabel.textContent = content
}

/**
 * Updates source of preview image.
 * @param {HTMLElement} $input - Input which belongs to particular file uploader
 * @param {object} file - Image file which to show in preview
 */
const updateImagePreview = ($input, file) => {
  const $previewImage = $input.closest('.js-form-upload-container').querySelector('.js-form-upload-preview-image')

  $previewImage.src = URL.createObjectURL(file)
}

/**
 * Cuts file name if its too long.
 * @param {string} $name - Fine name
 * @param {object} file - Image file which to show in preview
 * @returns {string} - Short file name
 */
const cutFileName = (name) => {
  const dividedFile = name.split(".")
  const bareFileName = dividedFile[0]

  if (bareFileName.length > 18) {
    return bareFileName.substring(0, 18) + '[...].' + dividedFile[1]
  } else {
    return name
  }
}

/**
 * Checks if file from given event is of the correct type and handles label contents to show.
 * @param {object} e - Event object of file input
 */
const validateImage = (e) => {
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp']
  const $input = e.target
  const file = $input.files[0]
  if (allowedTypes.indexOf(file.type) > -1) {
    const fileName = cutFileName($input.value.split("\\").pop())
    updateFileLabel($input, fileName)
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