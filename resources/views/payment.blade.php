<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway - MentalUX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    @include('navbar') 

    <div class="main-content-wrapper">
        <div class="container">
            
            <div class="text-center mb-4">
                <h5 class="text-muted small mb-1">PROSES TRANSAKSI</h5>
                <h3 class="fw-bold text-dark">Payment Gateway</h3>
            </div>

            <div class="payment-card">
                
                <!-- Header Card -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="opacity-75">Order ID: #TRX-{{ rand(1000, 9999) }}</small>
                    <div class="timer-badge">
                        <i class="far fa-clock me-1"></i> Sisa Waktu: <span id="countdown">15:00</span>
                    </div>
                </div>

                <!-- Detail Pesanan Summary Box -->
                <div class="order-summary-box">
                    <div class="row g-2">
                        <div class="col-12 border-bottom border-white border-opacity-10 pb-2 mb-2">
                            <small class="d-block">Layanan</small>
                            <span class="fw-bold text-white small">Konsultasi Jiwa Online (1 Sesi)</span>
                        </div>
                        <div class="col-6">
                            <small class="d-block">Psikolog</small>
                            <span class="fw-bold text-white small" style="font-size: 0.85rem;">{{ $booking['psikolog_name'] ?? 'Dr. Dicky Oktrianda' }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="d-block">Jadwal</small>
                            <span class="fw-bold text-white small" style="font-size: 0.85rem;">{{ $booking['tanggal'] ?? date('Y-m-d') }}</span>
                            <small class="d-block" style="font-size: 0.75rem;">{{ $booking['jam'] ?? '10.00 - 12.00 WIB' }}</small>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="nav-pills-custom">
                    <button class="nav-link-custom active" id="tab-qris" onclick="switchTab('qris')">
                        <i class="fas fa-qrcode me-1"></i> QRIS
                    </button>
                    <button class="nav-link-custom" id="tab-bank" onclick="switchTab('bank')">
                        <i class="fas fa-university me-1"></i> Transfer Bank
                    </button>
                </div>

                <p class="text-center small mb-3 opacity-75" id="instruction-text">Scan QR Code di bawah ini</p>

                <!-- QRIS Content -->
                <div id="content-qris" class="white-area shadow-sm">
                    <div class="d-flex justify-content-between align-items-center qris-header">
                        <h6 class="fw-bold m-0 text-primary">QRIS</h6>
                        <span class="badge bg-danger rounded-pill px-2">GPN</span>
                    </div>

                    <h5 class="fw-bold m-0 text-dark">MENTALUX APP</h5>
                    <p class="small text-muted mb-0">NMID: ID123456789</p>

                    <img src="{{ asset('img/qris/Qris.png') }}" class="qr-img" alt="QRIS">

                    <p class="fw-bold m-0 text-secondary" style="font-size: 0.85rem;">A01 - Otomatis Terverifikasi</p>
                </div>

                <!-- Bank Content -->
                <div id="content-bank" class="white-area shadow-sm d-none d-flex flex-column justify-content-center">
                    <div class="text-center py-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="bank-logo" alt="BCA">
                        <p class="text-muted small mb-1">Bank Central Asia (BCA)</p>
                        <h6 class="fw-bold mb-3 text-dark">PT MENTALUX SEHAT JIWA</h6>
                        
                        <div class="bg-light p-3 rounded-4 mb-3 border border-1" style="border-color: rgba(75, 77, 237, 0.15) !important;">
                            <small class="d-block text-muted mb-1" style="font-weight: 500;">Nomor Rekening</small>
                            <span class="rek-number" id="rekText">2530375202</span>
                            <button class="btn-copy-bca ms-2" onclick="copyRek()" title="Salin Rekening">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>

                        <div class="alert alert-info py-2 small m-0 text-start rounded-3" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i> Silakan masukkan **Order ID** di berita/keterangan transfer.
                        </div>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="text-center my-3">
                    <span class="d-block small opacity-75 mb-1">Total Pembayaran</span>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <h3 class="fw-bold m-0" id="priceText">{{ $booking['price'] ?? 'Rp 200.000' }}</h3>
                        <button class="btn-copy" onclick="copyPrice()" title="Salin Nominal">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <button type="button" class="btn-confirm-secondary shadow-sm" onclick="checkStatus()">
                    <i class="fas fa-sync-alt"></i> Cek Status Pembayaran
                </button>

                <a href="{{ url('/chat') }}?doctor={{ urlencode($booking['psikolog_name'] ?? 'Psikolog') }}" class="btn-confirm-primary shadow-sm">
                    Lanjutkan Ke Sesi Chat <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <p class="text-center text-muted small mt-4">
                <i class="fas fa-lock me-1 text-success"></i> Transaksi Aman & Terenkripsi dengan SSL Secure
            </p>

        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tab) {
            const btnQris = document.getElementById('tab-qris');
            const btnBank = document.getElementById('tab-bank');
            const contentQris = document.getElementById('content-qris');
            const contentBank = document.getElementById('content-bank');
            const textInst = document.getElementById('instruction-text');

            if(tab === 'qris') {
                btnQris.classList.add('active');
                btnBank.classList.remove('active');
                contentQris.classList.remove('d-none');
                contentBank.classList.add('d-none');
                textInst.innerText = "Scan QR Code di bawah ini";
            } else {
                btnBank.classList.add('active');
                btnQris.classList.remove('active');
                contentBank.classList.remove('d-none');
                contentQris.classList.add('d-none');
                textInst.innerText = "Lakukan transfer ke rekening berikut";
            }
        }

        // Timer countdown
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = minutes + ":" + seconds;
                if (--timer < 0) timer = 0;
            }, 1000);
        }

        window.onload = function () {
            var display = document.querySelector('#countdown');
            if(display) startTimer(60 * 15, display);
        };

        // Modern SweetAlert Toast Feedback
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Copy functions using modern toast
        function copyPrice() {
            var copyText = document.getElementById("priceText").innerText;
            navigator.clipboard.writeText(copyText).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Nominal berhasil disalin!'
                });
            });
        }

        function copyRek() {
            var copyText = document.getElementById("rekText").innerText.replace(/\s/g, '');
            navigator.clipboard.writeText(copyText).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Nomor Rekening disalin!'
                });
            });
        }

        // Simulate Status Check
        function checkStatus() {
            Swal.fire({
                title: 'Memeriksa Pembayaran...',
                text: 'Harap tunggu sementara sistem memverifikasi transaksi Anda.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran Diterima!',
                            text: 'Transaksi berhasil. Silakan tekan tombol Lanjutkan untuk masuk ke sesi chat.',
                            confirmButtonColor: '#4B4DED'
                        });
                    }, 2000);
                }
            });
        }
    </script>
    
    @include('footer')  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
