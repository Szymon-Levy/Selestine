/* === BOTTOM GALLERY === */

const swiper = new Swiper('.js-bottom-gallery-swiper', {
  loop: true,
  slidesPerView: 2,
  draggable: true,
  grabCursor: true,
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