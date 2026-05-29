<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jadwal - MentalUX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
</head>
<body>

    @include('navbar') 

    <div class="container mb-5">
        <div class="booking-card">
            
            <div class="text-center mb-4">
                <h5 class="text-muted small mb-1">Booking Konsultasi</h5>
                <h3 class="fw-bold text-dark">Pilih Jadwal</h3>
            </div>

            <!-- Dokter Summary Card -->
            @if(isset($psikolog))
            <div class="d-flex align-items-center gap-3 p-3 mb-4 bg-primary bg-opacity-10 rounded-4" style="border: 1px solid rgba(75, 77, 237, 0.1);">
                <img src="{{ asset($psikolog->image) }}" class="rounded-circle shadow-sm border border-2 border-white" style="width: 65px; height: 65px; object-fit: cover;" alt="{{ $psikolog->name }}">
                <div>
                    <span class="badge bg-primary text-white rounded-pill mb-1" style="font-size: 0.65rem; font-weight: 600;">{{ $psikolog->role }}</span>
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">{{ $psikolog->name }}</h5>
                    <small class="text-muted" style="font-size: 0.8rem;"><i class="fas fa-heartbeat me-1 text-primary"></i> {{ $psikolog->specialist }}</small>
                </div>
            </div>
            @else
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">{{ $name }}</h3>
            </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf 
                <input type="hidden" name="psikolog_name" value="{{ $name }}">

                <!-- Horizontal Scroll Date Selector -->
                @php
                    $days = [];
                    $englishDays = ['Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];
                    $englishMonths = ['Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agt', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'];
                    
                    $current = \Carbon\Carbon::today('Asia/Jakarta');
                    for ($i = 0; $i < 7; $i++) {
                        $rawDay = $current->format('D');
                        $rawMonth = $current->format('M');
                        
                        $dayLabel = $i === 0 ? 'Hari Ini' : ($i === 1 ? 'Besok' : ($englishDays[$rawDay] ?? $rawDay));
                        $monthLabel = $englishMonths[$rawMonth] ?? $rawMonth;

                        $days[] = [
                            'date_str' => $current->format('Y-m-d'),
                            'day_label' => $dayLabel,
                            'day_num' => $current->format('d'),
                            'month' => $monthLabel
                        ];
                        $current->addDay();
                    }
                @endphp

                <div class="mb-4">
                    <label class="fw-bold mb-2 ps-1 text-dark d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                        <i class="fas fa-calendar-day text-primary"></i> Pilih Tanggal Konsultasi
                    </label>
                    <div class="scroll-date-container gap-2">
                        @foreach($days as $key => $d)
                            <div class="date-card-wrapper">
                                <input type="radio" class="btn-check" name="tanggal" id="date_{{ $key }}" value="{{ $d['date_str'] }}" {{ $key === 0 ? 'checked' : '' }} required>
                                <label class="date-card-label" for="date_{{ $key }}">
                                    <small class="day-name">{{ $d['day_label'] }}</small>
                                    <strong class="day-num">{{ $d['day_num'] }}</strong>
                                    <small class="month-name">{{ $d['month'] }}</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 2x2 Grid Time Slot Selector -->
                <div class="mb-4">
                    <label class="fw-bold mb-3 ps-1 text-dark d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                        <i class="fas fa-clock text-primary"></i> Pilih Jam Konsultasi
                    </label>
                    <div class="row g-3">
                        @foreach($timeSlots as $key => $slot)
                            @php
                                $icon = 'fas fa-clock text-secondary';
                                if (str_contains($slot, '10.00')) {
                                    $icon = 'fas fa-sun text-warning';
                                } elseif (str_contains($slot, '13.00')) {
                                    $icon = 'fas fa-cloud-sun text-primary';
                                } elseif (str_contains($slot, '16.00')) {
                                    $icon = 'fas fa-cloud-moon text-primary';
                                } elseif (str_contains($slot, '19.00')) {
                                    $icon = 'fas fa-moon text-indigo';
                                }
                            @endphp
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="jam" id="time_{{ $key }}" value="{{ $slot }}" required>
                                <label class="time-card-label" for="time_{{ $key }}">
                                    <div class="d-flex flex-column align-items-center gap-2 py-3 px-2">
                                        <i class="{{ $icon }} fa-lg mb-1"></i>
                                        <span class="slot-text">{{ $slot }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-continue shadow">
                    Lanjutkan Ke Pembayaran <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </form>

        </div>
    </div>

    @include('footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>