<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - MentalUX</title>
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
        .btn-gradient-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        .btn-gradient-success:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        .article-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .badge-category {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    @include('navbar')

    <div class="container py-5 mt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="fas fa-file-alt text-success me-2"></i>Kelola Artikel Edukasi</h2>
                <p class="text-muted mb-0">Tambah, ubah, dan hapus artikel kesehatan mental pada platform MentalUX.</p>
            </div>
            <button class="btn btn-gradient-success" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                <i class="fas fa-plus me-2"></i>Tambah Artikel Baru
            </button>
        </div>

        <!-- Notifikasi -->
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

        <div class="card premium-card">
            <div class="card-body p-4">
                <!-- Search Box -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form action="{{ route('admin.articles') }}" method="GET" class="w-100 d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-radius-pill-start">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 border-radius-pill-end ps-0" 
                                   placeholder="Cari judul artikel atau kategori..." value="{{ $search }}">
                        </div>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Cari</button>
                    </form>
                </div>

                <!-- Tabel Artikel -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3">Gambar</th>
                                <th class="py-3">Judul Artikel</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Ringkasan</th>
                                <th class="py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $art)
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">{{ $loop->iteration + ($articles->firstItem() - 1) }}</td>
                                <td>
                                    <img src="{{ $art->image_url }}" alt="Thumbnail" class="article-thumb">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $art->title }}</div>
                                </td>
                                <td>
                                    @php
                                        $catLower = strtolower($art->category);
                                        $badgeClass = 'bg-secondary';
                                        if (str_contains($catLower, 'work')) $badgeClass = 'bg-warning text-dark';
                                        elseif (str_contains($catLower, 'mindful')) $badgeClass = 'bg-success text-white';
                                        elseif (str_contains($catLower, 'relation')) $badgeClass = 'bg-info text-white';
                                    @endphp
                                    <span class="badge badge-category {{ $badgeClass }}">{{ $art->category }}</span>
                                </td>
                                <td>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                        {{ $art->summary }}
                                    </small>
                                </td>
                                <td class="text-end px-4">
                                    <!-- View detail in frontend -->
                                    <a href="{{ route('article.detail', ['id' => $art->id]) }}" target="_blank" 
                                       class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Lihat di Halaman Depan">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" 
                                            onclick="openEditModal('{{ $art->id }}', '{{ addslashes($art->title) }}', '{{ addslashes($art->category) }}', '{{ addslashes($art->image_url) }}', '{{ addslashes($art->summary) }}', '{{ addslashes($art->content) }}')"
                                            title="Ubah Artikel">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.articles.delete', $art->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" 
                                                onclick="konfirmasiHapus(this, '{{ addslashes($art->title) }}')"
                                                title="Hapus Artikel">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3 d-block"></i>
                                    <span class="text-muted">Tidak ada artikel ditemukan.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span class="text-muted small">
                        Menampilkan {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} dari {{ $articles->total() ?? 0 }} data
                    </span>
                    <div>
                        {{ $articles->links('pagination::bootstrap-5') }}
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

    <!-- Modal Tambah Artikel -->
    <div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addArticleModalLabel"><i class="fas fa-plus text-success me-2"></i>Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Judul Artikel</label>
                                <input type="text" class="form-control rounded-3" name="title" placeholder="Contoh: Manfaat Meditasi Pagi" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="category" class="form-select rounded-3" required>
                                    <option value="Work Life">Work Life</option>
                                    <option value="Mindfulness">Mindfulness</option>
                                    <option value="Relationship">Relationship</option>
                                    <option value="Mental Health">Mental Health</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unggah File Gambar</label>
                                <input type="file" class="form-control rounded-3" name="image_file" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WEBP (Maks 5MB)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Atau Gunakan URL Gambar</label>
                                <input type="url" class="form-control rounded-3" name="image_url" placeholder="https://images.unsplash.com/...">
                                <small class="text-muted">Tempel link gambar jika tidak ingin mengunggah file.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ringkasan Singkat (Summary)</label>
                            <textarea class="form-control rounded-3" name="summary" rows="2" placeholder="Tulis ringkasan 1-2 kalimat untuk kartu depan" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Lengkap Artikel (Mendukung HTML)</label>
                            <textarea class="form-control rounded-3" name="content" rows="8" placeholder="<p>Tulis isi artikel lengkap disini...</p>" required></textarea>
                            <small class="text-muted">Anda dapat menyisipkan tag HTML seperti &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, dll.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4">Terbitkan Artikel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Artikel -->
    <div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="editArticleModalLabel"><i class="fas fa-edit text-primary me-2"></i>Ubah Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Judul Artikel</label>
                                <input type="text" class="form-control rounded-3" id="edit_title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="category" id="edit_category" class="form-select rounded-3" required>
                                    <option value="Work Life">Work Life</option>
                                    <option value="Mindfulness">Mindfulness</option>
                                    <option value="Relationship">Relationship</option>
                                    <option value="Mental Health">Mental Health</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unggah File Gambar Baru (Opsional)</label>
                                <input type="file" class="form-control rounded-3" name="image_file" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Atau Gunakan URL Gambar</label>
                                <input type="url" class="form-control rounded-3" id="edit_image_url" name="image_url">
                                <small class="text-muted">Link gambar aktif saat ini.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ringkasan Singkat (Summary)</label>
                            <textarea class="form-control rounded-3" id="edit_summary" name="summary" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Lengkap Artikel (Mendukung HTML)</label>
                            <textarea class="form-control rounded-3" id="edit_content" name="content" rows="8" required></textarea>
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
        // Membuka Edit Modal secara Dinamis
        function openEditModal(id, title, category, imageUrl, summary, content) {
            const form = document.getElementById('editForm');
            form.action = `/dashboard/admin/articles/${id}`;

            document.getElementById('edit_title').value = title;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_image_url').value = imageUrl;
            document.getElementById('edit_summary').value = summary;
            document.getElementById('edit_content').value = content;

            const editModal = new bootstrap.Modal(document.getElementById('editArticleModal'));
            editModal.show();
        }

        // Konfirmasi Hapus Artikel
        function konfirmasiHapus(button, title) {
            Swal.fire({
                title: 'Hapus Artikel Ini?',
                text: `Artikel "${title}" akan dihapus secara permanen dari database platform!`,
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
