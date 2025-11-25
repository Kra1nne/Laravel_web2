$(document).ready(function () {
  const foods = window.foods || [];

  function buildCarousel(foods) {
    const $inner = $('#foodCarouselInner');
    $inner.empty();

    foods.forEach((food, idx) => {
      const hasPicture = Array.isArray(food.picture) && food.picture.length > 0;
      const picture = hasPicture ? food.picture[0].path : '/images/no-image.png';
      const activeClass = (idx === 0 ? ' active' : '');

      const slide = `
        <div class="carousel-item${activeClass}">
          <img src="${picture}" class="d-block w-100" alt="Food image ${idx + 1}">
        </div>`;
      $inner.append(slide);
    });

    // Initialize Bootstrap 5 carousel
    new bootstrap.Carousel('#foodCarousel', {
      interval: 2000,
      ride: 'carousel'
    });
  }

  function startRotation(foods) {
    if (!foods.length) return;
    let idx = 0;
    buildCarousel(foods);
    showQuote(idx);

    $('#foodCarousel').on('slide.bs.carousel', function () {
      idx = (idx + 1) % quotes.length;
      showQuote(idx);
    });
  }

  startRotation(foods);
});
