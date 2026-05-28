<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun - MentalUX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .premium-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .nav-pills .nav-link {
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 500;
            color: #555;
            transition: all 0.3s ease;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }
        .btn-gradient-primary {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        .btn-gradient-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        .badge-role {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-admin {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .badge-psychologist {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        .badge-customer {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
    </style>
</head>
<body>
    @include('navbar')

    <div class="container py-5 mt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="fas fa-users-cog text-primary me-2"></i>Kelola Akun Pengguna</h2>
                <p class="text-muted mb-0">Tambah, ubah, dan hapus akun pengguna platform MentalUX.</p>
            </div>
            <button class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                <i class="fas fa-user-plus me-2"></i>Tambah Akun Baru
            </button>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <div>{{ session('error') }}</div>
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

        <div class="card premium-card">
            <div class="card-body p-4">
                <!-- Filter & Pencarian -->
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4">
                    <!-- Filter Tabs -->
                    <ul class="nav nav-pills gap-2 bg-light p-1 rounded-pill">
                        <li class="nav-item">
                            <a class="nav-link {{ !$roleFilter ? 'active' : '' }}" 
                               href="{{ route('admin.accounts', ['role' => '', 'search' => request('search')]) }}">
                                Semua Akun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ strtolower($roleFilter) === 'psychologist' ? 'active' : '' }}" 
                               href="{{ route('admin.accounts', ['role' => 'psychologist', 'search' => request('search')]) }}">
                                Psikolog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ strtolower($roleFilter) === 'customer' ? 'active' : '' }}" 
                               href="{{ route('admin.accounts', ['role' => 'customer', 'search' => request('search')]) }}">
                                Customer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ strtolower($roleFilter) === 'admin' ? 'active' : '' }}" 
                               href="{{ route('admin.accounts', ['role' => 'admin', 'search' => request('search')]) }}">
                                Admin
                            </a>
                        </li>
                    </ul>

                    <!-- Search Box -->
                    <form action="{{ route('admin.accounts') }}" method="GET" class="w-100 w-lg-auto d-flex gap-2">
                        <input type="hidden" name="role" value="{{ $roleFilter }}">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-radius-pill-start">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 border-radius-pill-end ps-0" 
                                   placeholder="Cari nama atau email..." value="{{ $search }}">
                        </div>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Cari</button>
                    </form>
                </div>

                <!-- Tabel Akun -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3">Username</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Role</th>
                                <th class="py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">{{ $loop->iteration + ($users->firstItem() - 1) }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $user->username }}</div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td>
                                    @php
                                        $roleLower = strtolower($user->role);
                                    @endphp
                                    @if($roleLower === 'admin')
                                        <span class="badge-role badge-admin"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                    @elseif($roleLower === 'psychologist')
                                        <span class="badge-role badge-psychologist"><i class="fas fa-user-md me-1"></i>Psikolog</span>
                                    @else
                                        <span class="badge-role badge-customer"><i class="fas fa-user me-1"></i>Customer</span>
                                    @endif
                                </td>
                                <td class="text-end px-4">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" 
                                            onclick="openEditModal('{{ $user->id }}', '{{ $user->username }}', '{{ $user->email }}', '{{ $user->role }}')"
                                            title="Ubah Akun">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    @if($user->id !== auth()->user()->id)
                                        <form action="{{ route('admin.accounts.delete', $user->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" 
                                                    onclick="konfirmasiHapus(this, '{{ $user->username }}')"
                                                    title="Hapus Akun">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small text-italic">Anda</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                    <span class="text-muted">Tidak ada data akun ditemukan.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span class="text-muted small">
                        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() ?? 0 }} data
                    </span>
                    <div>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addAccountModalLabel"><i class="fas fa-user-plus text-primary me-2"></i>Tambah Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.accounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control rounded-3" name="username" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control rounded-3" name="email" placeholder="contoh: budi@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control rounded-3" name="password" placeholder="Masukkan password" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">Role Pengguna</label>
                            <select name="role" class="form-select rounded-3" required>
                                <option value="Customer">Customer</option>
                                <option value="Psychologist">Psikolog</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Akun -->
    <div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editAccountModalLabel"><i class="fas fa-edit text-primary me-2"></i>Ubah Data Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control rounded-3" id="edit_username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control rounded-3" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control rounded-3" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah" minlength="6">
                            <small class="text-muted">Isi hanya jika ingin mengubah password akun.</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label fw-semibold">Role Pengguna</label>
                            <select name="role" id="edit_role" class="form-select rounded-3" required>
                                <option value="Customer">Customer</option>
                                <option value="Psychologist">Psikolog</option>
                                <option value="Admin">Admin</option>
                            </select>
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
    
    <script>
        // Membuka Modal Edit dengan mengisi datanya secara dinamis
        function openEditModal(id, username, email, role) {
            // Set action form ke URL yang sesuai
            const form = document.getElementById('editForm');
            form.action = `/dashboard/admin/accounts/${id}`;

            // Isi field-field modal
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_password').value = ''; // Kosongkan password input

            // Normalisasi casing untuk select option
            const selectElement = document.getElementById('edit_role');
            
            // Cek jika role bernilai 'CUSTOMER' atau lowercase 'customer' dll
            const normalizedRole = role.toLowerCase();
            
            if (normalizedRole === 'admin') {
                selectElement.value = 'Admin';
            } else if (normalizedRole === 'psychologist') {
                selectElement.value = 'Psychologist';
            } else {
                selectElement.value = 'Customer';
            }

            // Tampilkan Modal
            const editModal = new bootstrap.Modal(document.getElementById('editAccountModal'));
            editModal.show();
        }

        // Konfirmasi Hapus Akun
        function konfirmasiHapus(button, username) {
            Swal.fire({
                title: 'Hapus Akun Ini?',
                text: `Akun "${username}" akan dihapus permanen dari sistem MentalUX!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('.form-delete').submit();
                }
            });
        }
    </script>
</body>
</html>
