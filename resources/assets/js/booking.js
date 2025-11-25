$(document).ready(function () {
  // Function to render venues
  function displayVenues(venues) {
    const $categoryList = $('#facilities');
    $categoryList.empty();

    if (venues.length === 0) {
      $categoryList.html(`
        <div class="text-left text-muted">

        </div>
      `);
      return;
    }

    venues.forEach(venue => {
      const carouselId = 'carouselVenue' + venue.id;
      const hasPictures = Array.isArray(venue.picture) && venue.picture.length > 0;
      const pictures = hasPictures ? venue.picture : [{ path: '/images/no-image.png', v_code: '' }];
      
      const ratings = venue.rating || [];
      const ratingCount = ratings.length;
      const ratingTotal = ratings.reduce((sum, r) => sum + (r.rating || 0), 0);
      const rating = ratingCount > 0 ? (ratingTotal / ratingCount).toFixed(1) : '0.0';

      const venueCard = `
        <div class="col mb-5 ">
          <div class="card">
            <div id="${carouselId}" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
              <div class="carousel-indicators">
                ${pictures
                  .map(
                    (pic, index) => `
                  <button type="button" data-bs-target="#${carouselId}" data-bs-slide-to="${index}"
                    ${index === 0 ? 'class="active" aria-current="true"' : ''} aria-label="Slide ${index + 1}">
                  </button>`
                  )
                  .join('')}
              </div>

              <div class="carousel-inner">
                ${pictures
                  .map(
                    (pic, index) => `
                  <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img class="d-block w-100" src="${pic.path}" alt="Slide ${index + 1}" style="height: 300px; object-fit: cover;">
                  </div>`
                  )
                  .join('')}
              </div>

              <a class="carousel-control-prev" href="#${carouselId}" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </a>
              <a class="carousel-control-next" href="#${carouselId}" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </a>
            </div>

            <div class="card-body">
              <div class="d-flex">
                <h5 class="card-title me-auto"><a href="/booking/${venue.encrypted_id}">${venue.name}</a></h5>
                <p><strong>₱${venue.price.toFixed(2)}</strong></p>
              </div>
              <div class="d-flex align-items-center mt-2">
                <span style="color: #ffc107; font-size: 1.2em;">&#9733;</span>
                <span class="ms-1 fw-bold">${rating}</span>
              </div>
            </div>
          </div>
        </div>
      `;
      $categoryList.append(venueCard);
    });
  }

  // Function to filter venues based on search query
  function filterVenues(query) {
    const filtered = window.venues.filter(venue => venue.name.toLowerCase().includes(query));
    displayVenues(filtered);
  }

  // Search input handler
  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterVenues(query);
  });

  // Render all venues initially on page load
  displayVenues(window.venues);
});
