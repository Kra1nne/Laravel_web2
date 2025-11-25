<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Revenue Reports</title>

  <style>
    @page {
      margin: 120px 40px 120px 40px; /* top, right, bottom, left */
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 0;
      background-color: #fff;
      color: #000;
    }

    /* ===== HEADER (REPEATS EACH PAGE) ===== */
    header {
      position: fixed;
      top: -90px;
      left: 0;
      right: 0;
      height: 80px;
      text-align: center;
      border-bottom: 2px solid #006994;
      padding-bottom: 20px;
    }

    header h1 {
      margin: 0;
      font-size: 20px;
      color: #006994;
      font-weight: bold;
    }

    header .date {
      font-size: 12px;
      margin-top: 4px;
    }

    /* ===== FOOTER (REPEATS EACH PAGE) ===== */
    footer {
      position: fixed;
      bottom: -90px;
      left: 0;
      right: 0;
      height: 80px;
      background: #f2f2f2;
      text-align: center;
      padding-top: 10px;
      border-top: 2px solid #006994;
      font-size: 11px;
      color: #444;
    }

    footer .line {
      width: 60%;
      margin: 6px auto;
      border-top: 1px solid #ccc;
    }

    footer .brand {
      font-weight: bold;
      color: #006994;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid black;
      padding: 6px;
    }

    .text-center {
      text-align: center;
    }

  </style>
</head>

<body>

  <!-- HEADER -->
  <header>
    <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
        <img src="{{ public_path('assets/img/favicon/logo.png') }}" alt="Logo" style="height: 50px;">
        <h1 style="margin: 0;">BLUEOASIS REPORT</h1>
        <span class="date">{{ now()->setTimezone('Asia/Manila')->format('M. d, Y') }}</span>
    </div>
</header>

  <!-- MAIN CONTENT -->
  <main>
    <table>
      <tr>
        <th>Date</th>
        <th>Status</th>
        <th class="text-center">Amount</th>
      </tr>

      @foreach($Revenue as $item)
      <tr>
        <td>{{ $item->created_at->format('F j, Y') }}</td>
        <td>{{ $item->status }}</td>
        <td class="text-center">₱ {{ number_format($item->amount, 2) }}</td>
      </tr>
      @endforeach

     <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td colspan="2" class="text-center">Total Amount</td>
        <td class="text-center">₱ {{ number_format($Total, 2) }}</td>
    </tr>
    </table>
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="brand">BLUEOASIS SYSTEM</div>
    <div class="line"></div>
    <span>Generated automatically — {{ now()->setTimezone('Asia/Manila')->format('M. d, Y h:i A') }}</span>
    <div>Confidential | Internal Use Only</div>
  </footer>

</body>
</html>
