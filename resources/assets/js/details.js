// error trapping
function validateForm(fields) {
  let valid = true;

  // Loop through all fields to check if any are empty
  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    const errorMessages = [];

    // Check for empty fields
    if (!value) {
      valid = false;
      errorMessages.push(`${field.label} is required.`);
    }

    if (errorMessages.length > 0) {
      input.classList.add('is-invalid'); // Add Bootstrap 'is-invalid' class
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (!errorMessageContainer) {
        errorMessageContainer = document.createElement('div');
        errorMessageContainer.classList.add('invalid-feedback');
        input.parentNode.appendChild(errorMessageContainer);
      }
      errorMessageContainer.innerHTML = errorMessages.join('<br>'); // Display all errors for this field
    } else {
      input.classList.remove('is-invalid'); // Remove 'is-invalid' class if valid
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (errorMessageContainer) {
        errorMessageContainer.remove(); // Remove error messages
      }
    }
  });

  return valid;
}

$(document).ready(function () {
  const facilitydetails = window.venue;
  $('#venue_id').val(facilitydetails.id);
  $('#venue_name').val(facilitydetails.name);
  $('#venue_price').val(facilitydetails.price);
  $('#price').text(formatPrice(facilitydetails.price));
  let selectedPromo = null;

  function formatPrice(price) {
    return '₱' + Number(price).toLocaleString('en-PH', { minimumFractionDigits: 2 });
  }

  function calculateTotalPrice(basePrice, guestCount, maxPerson, additionalPrice) {
    let total = Number(basePrice);
    if (guestCount > maxPerson && maxPerson > 0) {
      total += (guestCount - maxPerson) * additionalPrice;
    }
    return total;
  }

  function updatePriceDisplay() {
    const guestCount = Number($('#guest').val()) || 1;
    let basePrice = facilitydetails.price;
    let maxPerson = Number(facilitydetails.max_person) || 0;
    let additionalPrice = Number(facilitydetails.additional_price) || 0;

    if (selectedPromo && selectedPromo.price) {
      basePrice = selectedPromo.price;
      maxPerson = Number(selectedPromo.max_person) || maxPerson;
      additionalPrice = Number(selectedPromo.additional_price) || additionalPrice;
    }

    const total = calculateTotalPrice(basePrice, guestCount, maxPerson, additionalPrice);
    $('#price').text(formatPrice(total));
    $('#venue_price').val(total);
  }

  // Promo button selection
  $('.promo-btn').on('click', function () {
    $('.promo-btn').removeClass('active bg-label-primary bg-label-gray');
    $(this).addClass('active bg-label-primary');
    $('.promo-btn').not('.active').addClass('bg-label-gray');
    $('#promo_id').val($(this).data('promo-id') || '');

    const promoId = $(this).data('promo-id');
    selectedPromo = null;
    if (promoId) {
      selectedPromo = facilitydetails.promo.find(p => p.id == promoId);
    }
    updatePriceDisplay();
  });

  $(document).ready(function () {
    // Cottage date & time logic
    if (facilitydetails.category === 'cottage') {
      // When a time button is clicked
      $('.cottage-btn').on('click', function () {
        // Remove active class from all, add to clicked
        $('.cottage-btn').removeClass('bg-label-primary').addClass('bg-label-gray');
        $(this).removeClass('bg-label-gray').addClass('bg-label-primary');

        // Get selected date
        const date = $('#date').val();
        if (!date) return;

        // Get time range from button text
        const timeRange = $(this).text().trim();
        const [start, end] = timeRange.split(' - ');

        // Format date for input[type="datetime-local"]
        function formatDateTime(dateStr, timeStr) {
          // dateStr: yyyy-mm-dd, timeStr: hh:mm AM/PM
          let [h, m] = timeStr.split(':');
          let [hour, minute] = [parseInt(h), m.slice(0, 2)];
          let ampm = m.slice(3).toUpperCase();
          if (ampm === 'PM' && hour < 12) hour += 12;
          if (ampm === 'AM' && hour === 12) hour = 0;
          return `${dateStr}T${hour.toString().padStart(2, '0')}:${minute}`;
        }

        // Set check-in and check-out values
        $('#checkin-date').val(formatDateTime(date, start));
        $('#checkout-date').val(formatDateTime(date, end));
      });

      // When date changes, if a time button is active, update check-in/out
      $('#date').on('change', function () {
        const activeBtn = $('.cottage-btn.bg-label-primary');
        if (activeBtn.length) {
          activeBtn.trigger('click');
        }
      });
    }

    // ...existing code...
  });

  // Guest input change
  $('#guest').on('input change', function () {
    updatePriceDisplay();
  });

  // Initial price calculation
  updatePriceDisplay();

  function isFutureOrToday(dateStr) {
    const selected = new Date(dateStr);
    const today = new Date();
    // Set time to 00:00:00 for accurate comparison
    selected.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);
    return selected >= today;
  }
  function calculateDays(checkIn, checkOut) {
    if (checkIn && checkOut) {
      let inDate = new Date(checkIn);
      let outDate = new Date(checkOut);

      let diffMs = outDate - inDate;
      let diffDays = diffMs / (1000 * 60 * 60 * 24);

      $('#time-in').text(checkIn);
      $('#time-out').text(checkOut);
      $('#days').text(diffDays + ' days');

      return diffDays;
    }
    return 0; // if missing dates
  }

  $('#reservationBtn').on('click', function (e) {
    const fields = [
      { id: 'checkin-date', label: 'Check-in Date' },
      { id: 'checkout-date', label: 'Check-out Date' },
      { id: 'guest', label: 'Number of Guests' }
    ];
    e.preventDefault();
    let valid = validateForm(fields);

    const checkin = $('#checkin-date').val();
    const checkout = $('#checkout-date').val();

   
    if (checkin) {
      const checkinDate = new Date(checkin);
      const now = new Date();
      if (checkinDate < now) {
        valid = false;
        Toastify({
          text: 'Check-in date and time cannot be in the past.',
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          backgroundColor: '#cc3300',
          stopOnFocus: true
        }).showToast();
      }
    }


    if (checkout) {
      const checkoutDate = new Date(checkout);
      const now = new Date();
      if (checkoutDate < now) {
        valid = false;
        Toastify({
          text: 'Check-out date and time cannot be in the past.',
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          backgroundColor: '#cc3300',
          stopOnFocus: true
        }).showToast();
      }
    }

    
    if (checkin && checkout) {
      const checkinDate = new Date(checkin);
      const checkoutDate = new Date(checkout);
      if (checkoutDate <= checkinDate) {
        valid = false;
        Toastify({
          text: 'Check-out must be after check-in.',
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          backgroundColor: '#cc3300',
          stopOnFocus: true
        }).showToast();
      }
    }
    const facilitydetails = window.venue;
    let isConflict = false;
    if(facilitydetails.category === 'cottage')
    {
      isConflict = window.bookingDetails.some(booking => {
        const reservedStart = new Date(booking.time_in);
        const reservedEnd = new Date(booking.time_out);
        const inDate = new Date(checkin);
        const outDate = new Date(checkout);
        console.log(inDate == reservedEnd);
        console.log(inDate);
        console.log(reservedStart);
        return inDate <= reservedEnd && outDate >= reservedStart;
      });
    }else{
      function stripTime(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
      }

      isConflict = window.bookingDetails.some(booking => {
        const reservedStart = stripTime(new Date(booking.time_in));
        const reservedEnd = stripTime(new Date(booking.time_out));
        reservedEnd.setDate(reservedEnd.getDate() + 1);
        const inDate = stripTime(new Date(checkin));
        const outDate = stripTime(new Date(checkout));

        return inDate <= reservedEnd && outDate >= reservedStart;
      });
    }
    
   
    if (isConflict) {
        Toastify({
          text: 'Oops! These dates are already reserved. Please choose different dates.',
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          backgroundColor: '#cc3300',
          stopOnFocus: true
        }).showToast();
        event.preventDefault();
        return;
      }

    if (valid) {
      $('#BookingDetailsModal').modal('show');
      $('#facility-name_details').text(facilitydetails.name);
      $('#time-in_details').text($('#checkin-date').val());
      $('#time-out_details').text($('#checkout-date').val());
      $('#promo_details').text(selectedPromo ? selectedPromo.name : 'No Promo');
      $('#price_details').text(formatPrice($('#venue_price').val()));
      $('#number_of_days').text(facilitydetails.category === 'cottage' ? '1' : calculateDays(checkin, checkout));
      $('#number_of_guests').text($('#guest').val());

      let total = 0;
      let venuePrice = Number($('#venue_price').val()) || 0;
      let days = calculateDays(checkin, checkout) || 1; // fallback to 1 day if 0
      //let serviceFee = venuePrice * days * (2.5 / 100);
      let serviceFee = 50;
      if (facilitydetails.category === 'cottage') {
        total = Number($('#venue_price').val()) + serviceFee;
      } else {
        total = Number($('#venue_price').val()) * calculateDays(checkin, checkout) + serviceFee;
      }
      $('#total_amount').text(formatPrice(total));
      $('#service-fee').text(formatPrice(serviceFee));

      // store to the input fields
      $('#facility_category').val(facilitydetails.category);
      $('#facility_id').val(facilitydetails.id);
      $('#facility_name').val(facilitydetails.name);
      $('#facility_price').val($('#venue_price').val());
      $('#facility_checkin').val($('#checkin-date').val());
      $('#facility_checkout').val($('#checkout-date').val());
      $('#facility_number_of_guests').val($('#guest').val());
      $('#facility_promo_id').val($('#promo_id').val() || '');
      $('#facility_total_amount').val(total);
      $('#promo_name').val(selectedPromo ? selectedPromo.name : 'No Promo');
      $('#facility_number_of_days').val(facilitydetails.category === 'cottage' ? 1 : calculateDays(checkin, checkout));
    }
  });
});

// Calendar initialization

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth'
  });
  calendar.render();
});


document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    dayMaxEvents: 1,
    moreLinkClick: 'popover',
    eventColor: '#0722cfff', // default color
    events: window.bookingDetails.map(event => {
      const currentDate = new Date();
      const eventendDate = new Date(event.end);

      if (eventendDate < currentDate) {
        event.title = 'Reserve';
      }
      return event;
    })
  });
  calendar.render();
});
