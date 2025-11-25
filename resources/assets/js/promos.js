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
  $('body').on('click', '#SubmitPromo', function () {
    const fields = [
      { id: 'name', label: 'Name' },
      { id: 'price', label: 'Price' },
      { id: 'description', label: 'Description' },
      { id: 'max_person', label: 'Maximum Person' },
      { id: 'additional_price', label: 'Additional Price' },
      { id: 'facilities_id', label: 'Facilities' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    $.ajax({
      type: 'POST',
      url: '/promos/add',
      cache: false,
      data: $('#PromoData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#AddPromos').modal('hide');
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
  });
});

$(document).ready(function () {
  function displayPromos(promos) {
    const $promoslist = $('#promoslist');
    $promoslist.empty();

    if (promos.length === 0) {
      $promoslist.html(`<tr><td colspan="4" class="text-center text-muted">No promos found.</td></tr>`);
      return;
    }

    promos.forEach(promo => {
      const promoRow = `
        <tr>
          <td>${promo.name}</td>
          <td>${promo.facility_name}</td>
          <td>₱${Number(promo.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
          <td>${promo.max_person}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditPromos"
                   data-max="${promo.max_person}" data-additional="${promo.additional_price}" data-description="${promo.description}"
                    data-id="${promo.encrypted_id}" data-name="${promo.name}" data-price="${promo.price}" data-facilities_id="${promo.facilities_id}">
                  <i class="ri-pencil-line me-1"></i> Edit
                </a>
                <a class="dropdown-item DeleteBtn" href="javascript:void(0);" data-id="${promo.encrypted_id}">
                  <i class="ri-delete-bin-6-line me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
      `;
      $promoslist.append(promoRow);
    });
  }

  function filterPromos(query) {
    const filtered = window.promos.filter(promo => {
      const fullName = `${promo.name}`.toLowerCase();
      return fullName.includes(query) || promo.description.toLowerCase().includes(query);
    });
    displayPromos(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterPromos(query);
  });

  // Render all promos on page load
  displayPromos(window.promos);
});

// retrieve a data
$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const price = $(this).data('price');
    const facilities_id = $(this).data('facilities_id');
    const description = $(this).data('description');
    const max = $(this).data('max');
    const additional = $(this).data('additional');

    $('#Edit_id').val(id);
    $('#Edit_name').val(name);
    $('#Edit_price').val(price);
    $('#Edit_description').val(description);
    $('#Edit_max_person').val(max);
    $('#Edit_additional_price').val(additional);
    $('#Edit_facilities_id').val(facilities_id);
  });
});
// update
$(document).ready(function () {
  $('body').on('click', '#UpdatePromo', function () {
    const fields = [
      { id: 'Edit_name', label: 'Name' },
      { id: 'Edit_price', label: 'Price' },
      { id: 'Edit_description', label: 'Description' },
      { id: 'Edit_max_person', label: 'Maximum Person' },
      { id: 'Edit_additional_price', label: 'Additional Price' },
      { id: 'Edit_facilities_id', label: 'Facilities' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    $.ajax({
      type: 'POST',
      url: '/promos/update',
      cache: false,
      data: $('#Edit_PromoData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#EditPromos').modal('hide');
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

    //
  });
});

//delete
$(document).ready(function () {
  $('body').on('click', '.DeleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '/promos/delete',
          cache: false,
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
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
