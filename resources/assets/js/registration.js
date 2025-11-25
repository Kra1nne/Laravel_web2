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
      Toastify({
        text: errorMessages,
        duration: 3000,
        close: true,
        gravity: 'top', // top or bottom
        position: 'right', // left, center or right
        style: { background: '#cc3300' },
        stopOnFocus: true
      }).showToast();
    }

    if (field.id === 'password-confirmation' && value) {
      const password = document.getElementById('password').value.trim();
      if (value !== password) {
        valid = false;
        errorMessages.push('Passwords do not match.');
        Toastify({
          text: errorMessages,
          duration: 3000,
          close: true,
          gravity: 'top', // top or bottom
          position: 'right', // left, center or right
          style: { background: '#cc3300' },
          stopOnFocus: true
        }).showToast();
      }
    }
  });
  return valid;
}

$(document).ready(function () {
  $('#AddAcountBtn').on('click', function (event) {
    const fields = [
      { id: 'firstname', label: 'Firstname' },
      { id: 'lastname', label: 'Lastname' },
      { id: 'email', label: 'Email' },
      { id: 'password', label: 'Password' },
      { id: 'password-confirmation', label: 'Password Confirmation' },
      { id: 'terms-conditions', label: 'Terms and Condition'}
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/register/add',
      cache: false,
      data: $('#AddAccountData').serialize(),
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
            window.location.href = data.Redirect;
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
