document.addEventListener('DOMContentLoaded', () => {
   new Swiper('.testimonial-swiper', {
      slidesPerView: 'auto', // tarjetas tamaño auto
      centeredSlides: true,
      loop: true,
      speed: 600,
      navigation: {
         nextEl: '.slider-next',
         prevEl: '.slider-prev',
      },
      on: {
         slideChangeTransitionStart(swiper) {
            swiper.slides.forEach((slide) => slide.classList.remove('is-active'));
            swiper.slides[swiper.activeIndex].classList.add('is-active');
         },
      },
   });
});
