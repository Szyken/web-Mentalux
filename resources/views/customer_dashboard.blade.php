<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - MentalUX</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
    
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 100px 0 50px;
            margin-top: 60px;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

    @include('navbar')

    <section class="dashboard-header text-center">
        <div class="container">
            <h1 class="fw-bold">Welcome back, {{ Auth::user()->username }}!</h1>
            <p class="opacity-75">Customer Dashboard</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fa-lg text-success"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                
                <div class="col-md-4">
                    <div class="card stat-card h-100 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">My Profile ({{ Auth::user()->username }})</h6>
                                    <h5 class="fw-bold mb-0" style="font-size: 0.95rem;">{{ Auth::user()->email }}</h5>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#editProfileModal" title="Ubah Profil">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card h-100 p-3">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-circle bg-success bg-opacity-10 text-success me-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Active Session</h6>
                                <h5 class="fw-bold mb-0">
                                    {{ isset($activeConsultations) && $activeConsultations->count() > 0 
                                        ? $activeConsultations->count() . ' Session(s)' 
                                        : 'No Active Session' }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card h-100 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1">Need Help?</h6>
                                <p class="text-muted small mb-0">Book a psychologist now</p>
                            </div>
                            <a href="{{ route('psychologist.index') }}" class="btn btn-primary rounded-pill btn-sm px-3">
                                Find Expert
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Active Consultations Section --}}
            @if(isset($activeConsultations) && $activeConsultations->count() > 0)
            <div class="mt-5">
                <h4 class="fw-bold mb-3"><i class="fas fa-comments text-primary me-2"></i>Active Consultations</h4>
                <div class="row g-3">
                    @foreach($activeConsultations as $consult)
                    <div class="col-md-6">
                        <div class="card stat-card p-3">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($consult->psychologist_name) }}&background=random" 
                                         class="rounded-circle me-3" width="50" height="50" alt="Doctor">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $consult->psychologist_name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>
                                            Active • {{ \Carbon\Carbon::parse($consult->created_at)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                <a href="{{ route('chat.room', $consult->id) }}" 
                                   class="btn btn-primary rounded-pill btn-sm px-3">
                                    <i class="fas fa-comment-dots me-1"></i> Continue Chat
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="text-center mt-5">
                <a href="{{ route('logout') }}" class="btn btn-outline-danger px-4">
                    <i class="fas fa-sign-out-alt me-2"></i> Log Out
                </a>
            </div>

        </div>
    </section>

    <!-- Modal Edit Profil Customer -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editProfileModalLabel"><i class="fas fa-user-edit text-primary me-2"></i>Ubah Profil Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control rounded-3" name="username" value="{{ Auth::user()->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control rounded-3" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                            <input type="password" class="form-control rounded-3" name="password" placeholder="Kosongkan jika tidak ingin diubah" minlength="6">
                            <small class="text-muted">Isi hanya jika Anda ingin mengganti password login.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/script.js"></script>
</body>
</html>