<?php
// Konversi object data dari controller ke array
if (isset($data)) {
    $articleData = (array) $data;
} else {
    // Fallback jika diakses langsung tanpa controller
    $id = request()->query('id', 1);
    $dbData = \Illuminate\Support\Facades\DB::table('articles')->where('id', $id)->first() 
              ?? \Illuminate\Support\Facades\DB::table('articles')->first();
    $articleData = (array) $dbData;
}

// Map key image_url ke image agar template tetap bekerja tanpa ubah key
$articleData['image'] = $articleData['image_url'] ?? '';

// Reassign ke variable $data untuk kecocokan kode di bawahnya
$data = $articleData;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> - MentalUX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
</head>
<body>

    @include('navbar')

    <header style="height: 400px; background: url('<?php echo $data['image']; ?>') no-repeat center center/cover; position: relative;">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5);"></div>
        <div class="container h-100 d-flex align-items-end pb-5 position-relative z-1">
            <div class="text-white">
                <span class="badge bg-primary mb-2"><?php echo $data['category']; ?></span>
                <h1 class="display-4 fw-bold"><?php echo $data['title']; ?></h1>
            </div>
        </div>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <a href="{{ route('education') }}" class="text-decoration-none text-muted mb-4 d-inline-block">
                    <i class="fas fa-arrow-left me-2"></i> Back to Education
                </a>

                <article class="lh-lg fs-5 text-secondary">
                    <?php echo $data['content']; ?>
                </article>

                <hr class="my-5">

                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark">Share this article:</span>
                    
                    <button onclick="shareToWhatsApp()" class="btn btn-outline-success btn-sm rounded-circle" title="Share ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    
                    <!-- <button onclick="shareToTwitter()" class="btn btn-outline-dark btn-sm rounded-circle" title="Share ke Twitter">
                        <i class="fab fa-twitter"></i>
                    </button> -->
                    
                    <button onclick="copyLink()" class="btn btn-outline-primary btn-sm rounded-circle" title="Salin Link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Ambil data Judul Artikel dari PHP ke variabel JS
        const articleTitle = "<?php echo addslashes($data['title']); ?>";

        // 1. Fungsi Share ke WhatsApp
        function shareToWhatsApp() {
            // Ambil URL halaman saat ini
            const url = window.location.href;
            const text = `Cek artikel menarik ini di MentalUX: *${articleTitle}*\n\nBaca selengkapnya disini: ${url}`;
            
            // Encode biar karakter spasi/simbol aman di URL
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            
            // Buka di tab baru
            window.open(whatsappUrl, '_blank');
        }

        // // 2. Fungsi Share ke Twitter
        // function shareToTwitter() {
        //     const url = window.location.href;
        //     const text = `Cek artikel: ${articleTitle} via @MentalUX`;
            
        //     const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            
        //     window.open(twitterUrl, '_blank');
        // }

        // 3. Fungsi Copy Link (Pake SweetAlert biar keren)
        function copyLink() {
            const url = window.location.href;

            // Perintah copy ke clipboard
            navigator.clipboard.writeText(url).then(() => {
                // Muncul notifikasi Toast (Kecil di pojok kanan atas)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Link berhasil disalin!'
                });
            }).catch(err => {
                console.error('Gagal menyalin link: ', err);
            });
        }
    </script>
</body>
</html>