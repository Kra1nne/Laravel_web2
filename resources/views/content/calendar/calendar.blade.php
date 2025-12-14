@extends('layouts/contentNavbarLayout')

@section('title', 'Facilities')

@section('content')
<section>

    <div id="calendar"></div>

    <!-- Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reservations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="reservationList"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const calendarEl = document.getElementById('calendar');

            // TODAY with current time exactly
            const now = new Date();

            // STEP 1: Raw reservation list
            const rawReservations = [
                @foreach($reservations as $res)
                {
                    name: "{{ $res->name }}",
                    check_in: "{{ $res->check_in }}",
                    check_out: "{{ $res->check_out }}",
                    category: "{{ $res->category }}",
                    date: "{{ \Carbon\Carbon::parse($res->check_in)->toDateString() }}"
                },
                @endforeach
            ];

            // STEP 2: Group
            const grouped = {};
            rawReservations.forEach(r => {
                if (!grouped[r.date]) grouped[r.date] = [];
                grouped[r.date].push(r);
            });

            // STEP 3: Events for calendar
            const events = Object.keys(grouped).map(date => ({
                title: "Reserved +" + grouped[date].length,
                start: date,
                allDay: true,
                extendedProps: { reservations: grouped[date] },
                backgroundColor: "#4A90E2",
                borderColor: "#4A90E2",
                textColor: "#fff"
            }));

            const calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',
                height: 730,
                dayMaxEventRows: 1,
                eventDisplay: "block",

                eventClick: function(info) {

                    const list = info.event.extendedProps.reservations;
                    let html = "";

                    // 12-hour format
                    function format12h(datetime) {
                        const d = new Date(datetime);
                        let hours = d.getHours();
                        let minutes = d.getMinutes().toString().padStart(2, "0");
                        let ampm = hours >= 12 ? "PM" : "AM";
                        hours = hours % 12 || 12;
                        return `${d.toISOString().slice(0,10)} ${hours}:${minutes} ${ampm}`;
                    }

                    // STATUS CALCULATION (based on date + time)
                    function getStatus(checkIn, checkOut) {
                        const start = new Date(checkIn);
                        const end = new Date(checkOut);

                        if (now < start) return `<span class="badge bg-primary">UPCOMING</span>`;
                        if (now >= start && now <= end) return `<span class="badge bg-warning text-dark">ONGOING</span>`;
                        return `<span class="badge bg-success">DONE</span>`;
                    }

                    list.forEach(r => {

                        let bg = r.category === "cottage" ? "#fc3e05" : "#4A90E2";
                        let textColor = "#fff";

                        let statusBadge = getStatus(r.check_in, r.check_out);

                        html += `
                            <div class="mb-3 p-3 rounded" style="background:${bg}; color:${textColor};">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>${r.name}</strong>
                                    ${statusBadge}
                                </div>
                                <div>Check-in: ${format12h(r.check_in)}</div>
                                <div>Check-out: ${format12h(r.check_out)}</div>
                            </div>
                        `;
                    });

                    document.getElementById("reservationList").innerHTML = html;

                    new bootstrap.Modal(document.getElementById('reservationModal')).show();
                },

                events: events
            });

            calendar.render();
        });
    </script>

</section>
@endsection
