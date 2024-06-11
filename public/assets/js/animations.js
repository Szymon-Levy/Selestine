const $fadeFromLeft = document.querySelectorAll('.js-animation-fade-from-left')
const fadeFromLeft = {
  distance: '20px',
  origin: 'left',
  opacity: 0,
  duration: 500,
  easing: 'ease-in',
  interval: 200
}

const $fadeFromRight = document.querySelectorAll('.js-animation-fade-from-right')
const fadeFromRight = {
  distance: '20px',
  origin: 'right',
  opacity: 0,
  duration: 500,
  easing: 'ease-in',
  interval: 200
}

const $fadeFromBottom = document.querySelectorAll('.js-animation-fade-from-bottom')
const fadeFromBottom = {
  distance: '20px',
  origin: 'bottom',
  opacity: 0,
  duration: 500,
  easing: 'ease-in',
  interval: 200
}

ScrollReveal().reveal($fadeFromRight, fadeFromRight)
ScrollReveal().reveal($fadeFromLeft, fadeFromLeft)
ScrollReveal().reveal($fadeFromBottom, fadeFromBottom)