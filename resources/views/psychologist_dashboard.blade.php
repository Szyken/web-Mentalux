<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychologist Dashboard - MentalUX</title>
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6fb;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 40px 0;
            margin-top: 70px;
        }

        .stat-card-mini {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
        }

        .stat-card-mini:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .icon-stat {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .appointment-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }

        .appointment-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .appointment-card.has-unread {
            border-left: 4px solid #4e73df;
        }

        .unread-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
        }

        .btn-join-chat {
            background: linear-gradient(135deg, #4e73df, #224abe);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-join-chat:hover {
            background: linear-gradient(135deg, #3a5fc8, #1a3da0);
            transform: scale(1.05);
            color: white;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
        }

        .btn-join-ended {
            background: #e9ecef;
            color: #6c757d;
            cursor: default;
        }

        .btn-join-ended:hover {
            background: #e9ecef;
            color: #6c757d;
            transform: none;
            box-shadow: none;
        }

        .date-badge {
            background: linear-gradient(135deg, #f0f4ff, #e8eeff);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            min-width: 80px;
        }

        .quick-menu-item {
            border: none !important;
            border-radius: 12px !important;
            margin-bottom: 4px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .quick-menu-item:hover {
            background-color: #f0f4ff !important;
            padding-left: 1.5rem !important;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #c5cfe0;
            margin-bottom: 15px;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(135deg, #4e73df, #224abe);
            border-radius: 10px;
        }

        .notif-bell {
            position: relative;
            display: inline-block;
        }

        .notif-bell .bell-count {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
        }
    </style>
</head>

<body>

    @include('navbar')

    {{-- Hero Section --}}
    <section class="dashboard-hero">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 80px; height: 80px; font-size: 2rem; flex-shrink: 0;">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">
                        Dr. {{ auth()->user()->name ?? auth()->user()->username }}
                        @if(isset($verification) && $verification->status == 'approved')
                            <i class="fas fa-check-circle text-warning ms-2" title="Verified Psychologist" style="font-size: 1.2rem;"></i>
                        @endif
                    </h2>
                    <p class="mb-0 opacity-75">Clinical Psychologist</p>
                </div>

                <div class="ms-auto text-end d-none d-md-block">
                    <div class="d-flex align-items-center gap-3">
                        @if($totalUnread > 0)
                        <div class="notif-bell">
                            <i class="fas fa-bell fa-lg text-warning"></i>
                            <span class="bell-count">{{ $totalUnread }}</span>
                        </div>
                        @endif
                        <div>
                            <h4 class="fw-bold mb-0">{{ count($appointments) }}</h4>
                            <small>Total Consultations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        
        {{-- Verification Status Alerts --}}
        <div class="mb-4">
            @if(isset($verification))
                @if($verification->status == 'pending')
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" style="border-radius: 14px;">
                        <div class="fs-1 me-3"><i class="fas fa-clock"></i></div>
                        <div>
                            <strong>Dokumen Sedang Ditinjau</strong><br>
                            Tim admin kami sedang memverifikasi sertifikat Anda. Fitur konsultasi akan aktif setelah disetujui.
                        </div>
                    </div>
                @elseif($verification->status == 'rejected')
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center" style="border-radius: 14px;">
                        <div class="fs-1 me-3"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <strong>Verifikasi Ditolak</strong><br>
                            Maaf, dokumen Anda ditolak. Alasan: {{ $verification->reject_reason ?? 'Dokumen tidak valid' }}.<br>
                            Silakan <a href="{{ route('psychologist.upload') }}" class="fw-bold text-danger text-decoration-underline">Upload Ulang</a>.
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" style="border-radius: 14px;">
                    <div class="fs-1 me-3"><i class="fas fa-info-circle"></i></div>
                    <div>
                        <strong>Akun Belum Terverifikasi</strong><br>
                        Silakan upload sertifikat praktek Anda agar profil Anda muncul di pencarian user.
                        <a href="{{ route('psychologist.upload') }}" class="fw-bold text-primary text-decoration-underline ms-1">Upload Sekarang</a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card-mini p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-stat bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Active</small>
                            <h5 class="fw-bold mb-0">{{ collect($appointments)->where('status', 'Active')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card-mini p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-stat bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Ended</small>
                            <h5 class="fw-bold mb-0">{{ collect($appointments)->where('status', 'Ended')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card-mini p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-stat bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Unread</small>
                            <h5 class="fw-bold mb-0">{{ $totalUnread }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card-mini p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-stat bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total</small>
                            <h5 class="fw-bold mb-0">{{ count($appointments) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Consultation List --}}
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4 section-title">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>Consultations
                </h4>

                @forelse($appointments as $apt)
                <div class="appointment-card mb-3 {{ $apt['unread'] > 0 ? 'has-unread' : '' }}">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-3">
                            {{-- Date Badge --}}
                            <div class="date-badge">
                                <small class="d-block text-muted" style="font-size: 0.75rem;">{{ $apt['date'] }}</small>
                                <strong class="text-primary" style="font-size: 0.9rem;">{{ $apt['time'] }}</strong>
                            </div>

                            {{-- Client Info --}}
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0">{{ $apt['client'] }}</h6>
                                    @if($apt['unread'] > 0)
                                        <span class="unread-badge">{{ $apt['unread'] }}</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    @if($apt['status'] == 'Active')
                                        <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.75rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Ended
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex align-items-center gap-2">
                            @if($apt['status'] == 'Active')
                                <a href="{{ route('chat.room', $apt['id']) }}" class="btn-join-chat">
                                    <i class="fas fa-comment-dots"></i> Join Chat
                                </a>
                            @else
                                <a href="{{ route('chat.room', $apt['id']) }}" class="btn-join-chat btn-join-ended">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="appointment-card">
                    <div class="empty-state">
                        <i class="fas fa-inbox d-block"></i>
                        <h5 class="fw-bold text-muted">Belum Ada Konsultasi</h5>
                        <p class="text-muted small mb-0">Konsultasi dari pasien akan muncul di sini saat mereka memulai sesi.</p>
                    </div>
                </div>
                @endforelse

            </div>

            {{-- Quick Menu Sidebar --}}
            <div class="col-lg-4">
                <h4 class="fw-bold mb-4 section-title">
                    <i class="fas fa-bolt text-warning me-2"></i>Quick Menu
                </h4>
                <div class="list-group shadow-sm rounded-3 overflow-hidden">
                    <a href="{{ route('psychologist.upload') }}" class="list-group-item list-group-item-action py-3 quick-menu-item">
                        <i class="fas fa-certificate me-2 text-warning"></i> Upload Sertifikat
                    </a>
                    <a href="{{ route('dashboard.psychologist') }}" class="list-group-item list-group-item-action py-3 quick-menu-item">
                        <i class="fas fa-sync-alt me-2 text-primary"></i> Refresh Dashboard
                    </a>
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action py-3 quick-menu-item text-danger fw-bold">
                        <i class="fas fa-sign-out-alt me-2"></i> Log Out
                    </a>
                </div>

                {{-- Tips Card --}}
                <div class="stat-card-mini p-4 mt-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-stat bg-info bg-opacity-10 text-info flex-shrink-0">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Tips</h6>
                            <p class="text-muted small mb-0">
                                Klik <strong>"Join Chat"</strong> untuk membuka ruang konsultasi dengan pasien. 
                                Badge merah menunjukkan pesan yang belum dibaca.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    {{-- Auto-refresh unread count --}}
    <script>
        function refreshUnreadBadges() {
            fetch('/chat/unread-count', {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.total_unread > 0) {
                    // Update title
                    document.title = `(${data.total_unread}) Psychologist Dashboard - MentalUX`;
                } else {
                    document.title = 'Psychologist Dashboard - MentalUX';
                }
            })
            .catch(() => {});
        }

        // Refresh setiap 10 detik
        setInterval(refreshUnreadBadges, 10000);
    </script>
</body>

</html>