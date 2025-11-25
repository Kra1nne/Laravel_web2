function formatDate(date) {
  return date
    .toLocaleString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      hour12: true
    })
    .replace(',', '')
    .replace(/^([A-Za-z]+)\s/, '$1. ');
}

$(document).ready(function () {
  function displayPromos(reservations) {
    const $reservationList = $('#reservationList');
    $reservationList.empty();

    if (reservations.length === 0) {
      $reservationList.html(`<tr><td colspan="7" class="text-center text-muted">No Reservation Found.</td></tr>`);
      return;
    }

    reservations.forEach(reservation => {
    
      const Options = `
        ${reservation.status != 'Fully Paid' && new Date(reservation.check_in) <= new Date() ? `
          <a class="dropdown-item DoneBtn" href="javascript:void(0);"
          data-id="${reservation.id}"
          data-payment_id="${reservation.payment_id}"
          data-payment_amount="${reservation.payment_amount}"
          >
            <i class="ri-checkbox-circle-line me-1"></i> Done
          </a>
        ` : ''}
      `;
      const fullname = reservation.name ?? reservation.firstname + (reservation.middlename ?? ' ') + reservation.lastname;
      const reservationRow = `
        <tr>
          <td>
             ${fullname}
          </td>
          <td>
            ${reservation.facilities_name} ${reservation.promos_name !== null ? ' - ' + reservation.promos_name : ''}
          </td>
          <td>
          ₱${Number(reservation.amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}
          </td>
          <td>
          ₱${Number(reservation.payment_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}
          </td>
          <td>
            ${formatDate(new Date(reservation.check_in))} - ${formatDate(new Date(reservation.check_out))}
          </td>
          <td>
            <span class="badge rounded-pill ${reservation.status === "Partial Payment" ? 'bg-label-warning' : reservation.status === "Cancel" ? 'bg-label-danger' : 'bg-label-success'} me-1">${reservation.status}</span>
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item ViewBtn" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ViewReservation"
                    data-id="${reservation.encrypted_id}"
                    data-customer_name="${reservation.firstname} ${reservation.middlename == !null ? reservation.middlename : ' '} ${reservation.lastname}"
                    data-facility_name="${reservation.facilities_name}"
                    data-promos="${reservation.promos_name}"
                    data-time_in="${reservation.check_in}"
                    data-time_out="${reservation.check_out}"
                    data-guest="${reservation.guest}"
                    data-price="${reservation.promos_price ?? reservation.facilities_price}"
                    data-date="${reservation.created_at}"
                    data-amount="${reservation.amount}"
                    data-foods='${JSON.stringify(reservation.foods)}'
                    data-payment_amount="${reservation.payment_amount}"
                    data-status="${reservation.status}"
                    data-name="${reservation.name}"
                    >
                  <i class="ri-eye-line me-1"></i> View
                </a>
                ${Options}
          </td>
        </tr>
      `;
      $reservationList.append(reservationRow);
    });
  }

  function filterPromos(query) {
    const filtered = window.reservations.filter(reservation => {
      const fullName = `${reservation.firstname} ${reservation.lastname}`.toLowerCase();
      return fullName.includes(query);
    });
    displayPromos(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterPromos(query);
  });

  // Render all promos on page load
  displayPromos(window.reservations);
});


$(document).ready(function () {
  $('body').on('click', '.ViewBtn', function () {
    const id = $(this).data('id');
    const fullname = $(this).data('customer_name');
    const facility_name = $(this).data('facility_name');
    const promos = $(this).data('promos') ?? 'No Promo';
    const time_in = $(this).data('time_in');
    const time_out = $(this).data('time_out');
    const guest = $(this).data('guest');
    const price = $(this).data('price');
    const date = $(this).data('date');
    const amount = $(this).data('amount');
    const foods = JSON.parse($(this).attr('data-foods') || '[]');
    const payment_amount = $(this).data('payment_amount');
    const status = $(this).data('status');
    const name = $(this).data('name');

    $('#facility-customer').text(name ?? fullname);
    $('#facility-name_details').text(facility_name);
    $('#time-in_details').text(formatDate(new Date(time_in)));
    $('#time-out_details').text(formatDate(new Date(time_out)));
    $('#payment_amount').text(Number(payment_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
    $('#promo_details').text(promos);
    $('#number_of_guests').text(guest);
    $('#price_details').text(Number(price).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
    $('#date').text(formatDate(new Date(date)));
    $('#total_amount').text(Number(amount).toLocaleString('en-PH', { minimumFractionDigits: 2 }));
    $('#status').text(status);

    let foodHtml = '';
    if (foods.length > 0) {
      foods.forEach(food => {
        foodHtml += `<div class="row mb-2">
                        <div class="col-12">
                          <strong>${food.pivot.quantity} ${food.name}</strong> <span> x ${food.price} = ${food.price * food.pivot.quantity}</span>
                        </div>
                      </div>`;
      });
    } else {
      foodHtml = '<p class="text-muted">No food ordered.</p>';
    }
    let footerHtml = '';
    footerHtml = `<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <a href="/booking/pdf/${id}" target="_blank" type="button" class="btn btn-primary" >Print PDF</a>`;

    $('#foods_list').html(foodHtml); 
    $('#footerBtn').html(footerHtml); 
  });
});


$(document).ready(function () {
  $('body').on('click', '.DoneBtn', function () {
    const id = $(this).data('id');
    const payment_id = $(this).data('payment_id');
    const amount = $(this).data('payment_amount');

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes!',
      cancelButtonText: 'No!',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '/reservations/done',
          cache: false,
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id,
            payment_id: payment_id,
            amount: amount
          },
          dataType: 'json',
          beforeSend: function () {
            $('.preloader').show();
          },
          success: function (data) {
            $('.preloader').hide();
            if (data.Error == 1) {
              Swal.fire('Error!', data.Message, 'error');
            } else if (data.Error == 0) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Saved!',
                text: data.Message,
                showConfirmButton: true,
                confirmButtonText: 'OK'
              }).then(result => {
                location.reload();
              });
            }
          },
          error: function () {
            $('.preloader').hide();
            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
          }
        });
      }
    });
  });
});