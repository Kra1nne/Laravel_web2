$(document).ready(function () {
  function displayfeedbacks(feedbacks) {
    const $feedbackslist = $('#feedbackslist');
    $feedbackslist.empty();

    if (feedbacks.length === 0) {
      $feedbackslist.html(`<tr><td colspan="6" class="text-center text-muted">No feedbacks found.</td></tr>`);
      return;
    }

    feedbacks.forEach(feedback => {
      const feedbackRow = `
        <tr>
          <td>${feedback.firstname} ${feedback.middlename ?? " "} ${feedback.lastname}</td>
          <td>${feedback.name}</td>
          <td>${new Date(feedback.created_at).toLocaleString('en-US', {
              month: 'long',
              day: 'numeric',
              year: 'numeric',
              hour: '2-digit',
              minute: '2-digit',
              hour12: true
            })}
          </td>
          <td>${feedback.rating}</td>
          <td title="${feedback.comments}">
            ${feedback.comments.length > 50 ? feedback.comments.substring(0, 50) + '...' : feedback.comments}
          </td>
          <td><a href="" class="btn btn-success commentData" data-bs-toggle="modal" data-bs-target="#CommentModal" data-comment="${feedback.comments}">View</button></td>
        </tr>
      `;
      $feedbackslist.append(feedbackRow);
    });
  }

  function filterfeedbacks(query) {
    const filtered = window.feedbacks.filter(feedback => {
      const fullName = `${feedback.firstname} ${feedback.lastname}`.toLowerCase();
      return fullName.includes(query) || feedback.name.toLowerCase().includes(query);
    });
    displayfeedbacks(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterfeedbacks(query);
  });

  // Render all feedbacks on page load
  displayfeedbacks(window.feedbacks);
});

$(document).ready(function () {
  $('body').on('click', '.commentData', function(event){

    const comment = $(this).data('comment')

    $('#comment').text(comment);
  });
});