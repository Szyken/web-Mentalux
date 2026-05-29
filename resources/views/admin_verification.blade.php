<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MentalUX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/verification.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
</head>
<body class="bg-light">
    @include('navbar')

    <div class="container py-5 mt-5">
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-center justify-content-between">
            <h2 class="fw-bold mb-0">Verifikasi Sertifikat Psikolog</h2>
            <!-- Quick Filters -->
            <div class="btn-group btn-group-sm rounded-pill shadow-sm bg-white p-1" role="group">
                <button type="button" class="btn btn-primary rounded-pill px-3 active filter-btn" data-filter="all">Semua</button>
                <button type="button" class="btn btn-light rounded-pill px-3 filter-btn" data-filter="pending">Pending</button>
                <button type="button" class="btn btn-light rounded-pill px-3 filter-btn" data-filter="approved">Verified</button>
                <button type="button" class="btn btn-light rounded-pill px-3 filter-btn" data-filter="rejected">Rejected</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Psikolog</th>
                            <th>File Sertifikat</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $cert)
                        <tr class="filter-row" data-status="{{ $cert->status }}">
                            <td>
                                <div class="fw-bold">{{ $cert->psychologist_name }}</div>
                                <small class="text-muted">{{ $cert->email }}</small>
                            </td>
                            <td>
                                <a href="{{ asset('uploads/certificates/' . $cert->certificate_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cert->uploaded_at)->format('d M Y') }}</td>
                            <td>
                                @if($cert->status == 'approved')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($cert->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($cert->status == 'pending')
                                    <form action="{{ route('admin.approve', $cert->id) }}" method="POST" class="d-inline form-approve">
                                        @csrf
                                        <button type="button" class="btn btn-success btn-sm" onclick="konfirmasiTerima(this, '{{ $cert->psychologist_name }}')" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reject', $cert->id) }}" method="POST" class="d-inline form-reject">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm" onclick="konfirmasiTolak(this, '{{ $cert->psychologist_name }}')" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @elseif($cert->status == 'approved')
                                    <form action="{{ route('admin.revoke', $cert->id) }}" method="POST" class="d-inline form-revoke">
                                        @csrf
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" onclick="konfirmasiCabut(this, '{{ $cert->psychologist_name }}')">
                                            <i class="fas fa-undo-alt me-1"></i> Cabut Izin
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Ditolak</span>
                                @endif

                                <!-- Hapus Permanen Form -->
                                <form action="{{ route('admin.delete.verification', $cert->id) }}" method="POST" class="d-inline form-delete-verification ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 p-1" onclick="konfirmasiHapusVerification(this, '{{ $cert->psychologist_name }}')" title="Hapus Permanen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">&laquo; Kembali ke Dashboard</a>
        </div>
    </div>

    <script>
        function konfirmasiCabut(button, nama) {
            Swal.fire({
                title: 'Cabut Izin Verifikasi?',
                text: "Apakah Anda yakin ingin mencabut verifikasi untuk " + nama + "? Psikolog ini tidak akan bisa menerima chat booking dari pasien.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Cabut!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function konfirmasiHapusVerification(button, nama) {
            Swal.fire({
                title: 'Hapus Data Verifikasi?',
                text: "Apakah Anda yakin ingin menghapus data verifikasi sertifikat untuk " + nama + " secara permanen dari database? File sertifikat fisik di server juga akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        // Filter functionality for Admin Verifications
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Toggle active button class
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('btn-primary', 'active');
                    b.classList.add('btn-light');
                });
                this.classList.remove('btn-light');
                this.classList.add('btn-primary', 'active');

                const filterValue = this.getAttribute('data-filter');
                const rows = document.querySelectorAll('.filter-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');

                    let show = false;
                    if (filterValue === 'all') {
                        show = true;
                    } else if (filterValue === 'pending' && status === 'pending') {
                        show = true;
                    } else if (filterValue === 'approved' && status === 'approved') {
                        show = true;
                    } else if (filterValue === 'rejected' && status === 'rejected') {
                        show = true;
                    }

                    if (show) {
                        row.style.display = 'table-row';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state if no rows match
                const emptyRow = document.getElementById('tableEmptyRow');
                if (visibleCount === 0) {
                    if (!emptyRow) {
                        const noMatchHtml = `
                            <tr id="tableEmptyRow">
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-search fa-2x d-block mb-2"></i>
                                    <strong>Tidak ada data verifikasi yang sesuai dengan filter ini.</strong>
                                </td>
                            </tr>
                        `;
                        document.querySelector('tbody').insertAdjacentHTML('beforeend', noMatchHtml);
                    } else {
                        emptyRow.style.display = 'table-row';
                    }
                } else if (emptyRow) {
                    emptyRow.style.display = 'none';
                }
            });
        });
    </script>

    {{-- Toast feedback alerts --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/script.js"></script>
</body>
</html>