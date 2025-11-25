// search
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
function getStatusBadge(total) {
  if (total >= 100) return '<span class="badge bg-success">Excellent</span>';
  if (total >= 75) return '<span class="badge bg-primary">Good</span>';
  if (total >= 50) return '<span class="badge bg-warning text-dark">Average</span>';
  return '<span class="badge bg-danger">Poor</span>';
}
$(document).ready(function () {
  function displaydata(data) {
    const $dataList = $('#evalList');
    $dataList.empty();

    if (data.length === 0) {
      $dataList.html(`<tr><td colspan="11" class="text-center text-muted">No evaluation found.</td></tr>`);
      return;
    }

    data.forEach(data => {
      const statusBadge = getStatusBadge(data.total);
      const dataRow = `
        <tr>
          <td>${data.email}</td>
          <td>${formatDate(new Date(data.created_at))}</td>
          <td>${data.A}/20</td>
          <td>${data.B}/15</td>
          <td>${data.C}/15</td>
          <td>${data.D}/15</td>
          <td>${data.E}/15</td>
          <td>${data.F}/15</td>
          <td>${data.G}/15</td>
          <td>${data.H}/15</td>
          <td>${statusBadge}</td>
          <td>${data.total}/125</td>
        </tr>
      `;
      $dataList.append(dataRow);
    });
  }

  function filterdata(query) {
    const filtered = window.data.filter(data => {
      return data.email.toLowerCase().includes(query);
    });
    displaydata(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterdata(query);
  });

  displaydata(window.data);
});
