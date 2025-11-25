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
//add
$(document).ready(function () {
  $('body').on('click', '#SaveProduct', function () {
    const fields = [
      { id: 'DataImages', label: 'Images' },
      { id: 'name', label: 'Name' },
      { id: 'price', label: 'Price' },
      { id: 'category', label: 'Category' },
      { id: 'description', label: 'Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    var formData = new FormData($('#ProductData')[0]);
    $.ajax({
      type: 'POST',
      url: '/foods/add',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $('#AddProduct').modal('hide');
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
  // Function to render foods
  function displayFoods(foods) {
    const $categoryList = $('#foods');
    $categoryList.empty();

    if (foods.length === 0) {
      $categoryList.html(`
        <div class="text-left text-muted">
        </div>
      `);
      return;
    }

    foods.forEach(food => {
      const hasPicture = Array.isArray(food.picture) && food.picture.length > 0;
      const picture = hasPicture ? food.picture[0].path : '/images/no-image.png';

      const foodCard = `
        <div class="col mb-5">
          <div class="card">
            <img class="card-img-top" src="${picture}" alt="${food.name}" style="height: 350px; object-fit: cover;">

            <div class="card-body">
              <div class="d-flex">
                <h5 class="card-title me-auto">
                  <span>${food.name}</span>
                </h5>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditProduct"
                      data-id="${food.encrypted_id}" data-name="${food.name}" data-price="${food.price}"
                      data-category="${food.category}" data-description="${food.description}"
                      data-images="${food.picture.map(pic => pic.path)}">
                      <i class="ri-pencil-line me-1"></i> Edit
                    </a>
                    <a class="dropdown-item DeleteBtn" data-id="${food.encrypted_id}" href="javascript:void(0);">
                      <i class="ri-delete-bin-6-line me-1"></i> Delete
                    </a>
                  </div>
                </div>

              </div>
              <p><strong>₱${food.price.toFixed(2)}</strong></p>
            </div>
          </div>
        </div>
      `;
      $categoryList.append(foodCard);
    });
  }

  // Function to filter foods based on search query
  function filterFoods(query) {
    const filtered = window.foods.filter(food => food.name.toLowerCase().includes(query));
    displayFoods(filtered);
  }

  // Search input handler
  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterFoods(query);
  });

  // Render all foods initially on page load
  displayFoods(window.foods);
});

$(document).ready(function () {
  $('body').on('click', '.DeleteBtn', function () {
    const id = $(this).data('id');
    console.log(id);
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
          url: '/foods/delete',
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

$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const price = $(this).data('price');
    const category = $(this).data('category');
    const description = $(this).data('description');

    $('#Edit_id').val(id);
    $('#Edit_name').val(name);
    $('#Edit_price').val(price);
    $('#Edit_category').val(category);
    $('#Edit_description').val(description);
  });
});

$(document).ready(function () {
  $('body').on('click', '#UpdateProduct', function () {
    const fields = [
      { id: 'Edit_name', label: 'Name' },
      { id: 'Edit_price', label: 'Price' },
      { id: 'Edit_category', label: 'Category' },
      { id: 'Edit_description', label: 'Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    var formData = new FormData($('#ProductDataUpdate')[0]);
    $.ajax({
      type: 'POST',
      url: '/foods/update',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $('#EditProduct').modal('hide');
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
