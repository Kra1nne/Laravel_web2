// search
$(document).ready(function () {
  function displayLogs(logs) {
    const $logsList = $('#logslist');
    $logsList.empty();

    if (logs.length === 0) {
      $logsList.html(`<tr><td colspan="6" class="text-center text-muted">No logs found.</td></tr>`);
      return;
    }

    logs.forEach(log => {
      const logRow = `
        <tr>
          <td><span>${log.firstname} ${log.lastname}</span></td>
          <td>${log.action}</td>
          <td>${log.table_name}</td>
          <td>${log.description}</td>
          <td><span class="badge rounded-pill bg-label-success me-1">Success</span></td>
          <td>${log.date}</td>
        </tr>
      `;
      $logsList.append(logRow);
    });
  }

  function filterLogs(query) {
    const filtered = window.logs.filter(log => {
      const fullName = `${log.firstname} ${log.lastname}`.toLowerCase();
      return fullName.includes(query) || log.table_name.toLowerCase().includes(query);
    });
    displayLogs(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterLogs(query);
  });

  // Render all logs on page load
  displayLogs(window.logs);
});
