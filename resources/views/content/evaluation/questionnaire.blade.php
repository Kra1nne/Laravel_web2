<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resort Booking Survey | Blue Oasis</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logo3.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      font-size: 12px;
    }
    .card {
      margin-bottom: 1.5rem;
    }
    .card-header {
      background-color: #0d6efd;
      color: #fff;
      font-weight: bold;
      font-size: 1.1rem;
    }
    .question {
      margin-top: 1rem;
    }
    .form-check-label {
      margin-left: 0.3rem;
    }
  </style>
</head>
<body>
<div class="container my-5">
  <h2 class="text-center mb-4">Online Resort Booking System Survey</h2>
  <p>Please rate the following statements regarding your experience with the online resort booking system on a scale of 1-5, where 1 = Strongly Disagree, 2 = Disagree, 3 = Neutral, 4 = Agree, and 5 = Strongly Agree..</p>

  <form action="{{ route('evaluate-store') }}" method="POST">
    <div>
      <div class="row">
        <div class="col-12 col-md-6 mb-2 mt-2">
          <div class="form-floating form-floating-outline">
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email ..." required>
            <label for="email">Email</label>
          </div>
        </div>
      </div>
    </div>
    @csrf
    <!-- Section A: Website Quality -->
    <div class="card">
      <div class="card-header">A. Website Quality</div>
      <div class="card-body">
        <div class="question">
          <label>1. The website of the resort is well-designed and visually appealing.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q1" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q1" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q1" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q1" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q1" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>2. The website is easy to navigate.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q2" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q2" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q2" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q2" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q2" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>3. The website loads quickly.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q3" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q3" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q3" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q3" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q3" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>4. The website provides all the information I need (room types, price, amenities).</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q4" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q4" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q4" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q4" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q4" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section B: Social Presence -->
    <div class="card">
      <div class="card-header">B. Social Presence</div>
      <div class="card-body">
        <div class="question">
          <label>5. I feel that there are real people behind the website.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q5" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q5" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q5" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q5" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q5" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>6. The website gives a warm and personal feeling.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q6" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q6" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q6" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q6" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q6" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>7. The interaction with the website feels similar to interacting with a real person.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q7" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q7" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q7" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q7" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q7" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section C: Affective Commitment -->
    <div class="card">
      <div class="card-header">C. Affective Commitment</div>
      <div class="card-body">
        <div class="question">
          <label>8. I feel emotionally attached to this booking website.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q8" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q8" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q8" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q8" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q8" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>9. I would like to use this website again in the future.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q9" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q9" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q9" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q9" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q9" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>10. I feel committed to making my booking through this site.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q10" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q10" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q10" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q10" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q10" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section D: Trust -->
    <div class="card">
      <div class="card-header">D. Trust (E-Trust)</div>
      <div class="card-body">
        <div class="question">
          <label>11. I trust this booking website.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q11" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q11" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q11" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q11" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q11" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>12. This booking website is reliable.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q12" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q12" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q12" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q12" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q12" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>13. I believe the website will not take advantage of me.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q13" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q13" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q13" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q13" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q13" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section E: Perceived Risk -->
    <div class="card">
      <div class="card-header">E. Perceived Risk</div>
      <div class="card-body">
        <div class="question">
          <label>14. Booking a resort online involves a lot of risk.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q14" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q14" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q14" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q14" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q14" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>15. I worry about the security of my payment information.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q15" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q15" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q15" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q15" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q15" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>16. I am concerned that the resort reservation might not be honored.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q16" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q16" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q16" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q16" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q16" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section F: Perceived Usefulness -->
    <div class="card">
      <div class="card-header">F. Perceived Usefulness (TAM)</div>
      <div class="card-body">
        <div class="question">
          <label>17. Using this online booking system makes booking easier.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q17" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q17" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q17" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q17" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q17" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>18. I believe this system helps me find good deals.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q18" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q18" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q18" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q18" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q18" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>19. The booking system improves my efficiency in making a reservation.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q19" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q19" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q19" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q19" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q19" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section G: Booking Intention -->
    <div class="card">
      <div class="card-header">G. Booking Intention</div>
      <div class="card-body">
        <div class="question">
          <label>20. I intend to use this website to book a resort.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q20" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q20" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q20" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q20" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q20" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>21. There is a high probability that I will make a reservation through this site.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q21" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q21" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q21" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q21" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q21" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>22. I would recommend this booking website to others.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q22" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q22" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q22" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q22" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q22" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section H: Online Reviews -->
    <div class="card">
      <div class="card-header">H. Online Reviews (e-WOM)</div>
      <div class="card-body">
        <div class="question">
          <label>23. The reviews on this site are useful to me.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q23" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q23" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q23" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q23" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q23" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>24. I rely on other guests’ reviews before I book.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q24" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q24" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q24" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q24" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q24" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>

        <div class="question">
          <label>25. I think the reviews are mostly honest.</label>
          <div class="d-flex justify-content-between mt-2">
            <div class="form-check"><input type="radio" name="q25" value="1" required><label class="form-check-label">1</label></div>
            <div class="form-check"><input type="radio" name="q25" value="2"><label class="form-check-label">2</label></div>
            <div class="form-check"><input type="radio" name="q25" value="3"><label class="form-check-label">3</label></div>
            <div class="form-check"><input type="radio" name="q25" value="4"><label class="form-check-label">4</label></div>
            <div class="form-check"><input type="radio" name="q25" value="5"><label class="form-check-label">5</label></div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center my-4">
      <button type="submit" class="btn btn-primary btn-lg">Submit Survey</button>
    </div>

  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
@if(session('show_modal_duplicate'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'warning',
        title: 'Evaluation Error',
        text: 'You already evaluated our system',
        confirmButtonText: 'Okay',
    });
});
</script>
@endif
@if(session('show_modal'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'error',
        title: 'Evaluation',
        text: 'We just accept a evaluation from our dear customers.',
        confirmButtonText: 'Okay',
    });
});
</script>
@endif
@if(session('success_modal'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'success',
        title: 'Evaluation Success',
        text: 'Thank you for you evaluation.'
    });
});
</script>
@endif
</html>
