<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultation Room - MentalUX</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    {{-- Header Chat --}}
    <div class="chat-header">
        <div class="doctor-info">
            <a href="{{ url('/') }}" class="text-dark me-2"><i class="fas fa-arrow-left"></i></a>

            <img src="https://ui-avatars.com/api/?name={{ urlencode($partnerName) }}&background=random" class="doctor-avatar" alt="Partner">

            <div>
                <h6 class="fw-bold m-0">{{ $partnerName }}</h6>
                <div class="status-badge" id="partnerStatus">
                    <span class="status-dot"></span> Online
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            {{-- Notifikasi Badge --}}
            <span class="notification-badge d-none" id="notifBadge">
                <i class="fas fa-bell"></i>
                <span class="badge-count" id="notifCount">0</span>
            </span>

            <button type="button" onclick="confirmRequestEnd()" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" id="btnRequestEnd">
                End Session
            </button>
        </div>
    </div>

    {{-- Area Chat (Scrollable) --}}
    <div class="chat-area" id="chatBox">
        <div class="text-center mb-3">
            <small class="badge bg-light text-secondary rounded-pill px-3 py-1">
                {{ \Carbon\Carbon::parse($consultation->created_at)->format('d M Y') }}
            </small>
        </div>

        {{-- Render semua pesan yang sudah ada dari database --}}
        @foreach($messages as $msg)
            <div class="message-bubble message-{{ $msg->sender_id == $userId ? 'out' : 'in' }} chat-animate-in"
                 data-message-id="{{ $msg->id }}">
                {!! nl2br(e($msg->message)) !!}
                <span class="message-time">
                    {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                    @if($msg->sender_id == $userId)
                        <i class="fas fa-check{{ $msg->is_read ? '-double text-info' : ' text-muted' }} ms-1" style="font-size: 10px;"></i>
                    @endif
                </span>
            </div>
        @endforeach
    </div>

    {{-- Toast Notification --}}
    <div id="chatToast" class="chat-toast d-none">
        <div class="toast-content">
            <i class="fas fa-comment-dots me-2"></i>
            <span id="toastText">Pesan baru!</span>
        </div>
    </div>

    {{-- Floating Agreement Banner --}}
    <div id="endSessionAgreement" class="card border-0 shadow-lg rounded-4 p-3 position-fixed d-none" 
         style="bottom: 90px; left: 20px; right: 20px; z-index: 1050; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-left: 5px solid #dc3545 !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center">
                <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-3 text-danger">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1 text-dark" id="agreementTitle">Permintaan Akhiri Sesi</h6>
                    <p class="text-muted small mb-0" id="agreementText">Partner Anda ingin mengakhiri sesi konsultasi ini. Apakah Anda setuju?</p>
                </div>
            </div>
            <div class="d-flex gap-2" id="agreementActions">
                <button onclick="acceptEndSession()" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">Setuju & Akhiri</button>
                <button onclick="rejectEndSession()" class="btn btn-light btn-sm rounded-pill px-3 border">Tolak</button>
            </div>
        </div>
    </div>

    {{-- Input Pesan --}}
    <div class="chat-input-area">
        <button class="btn-attach"><i class="fas fa-paperclip"></i></button>

        <input type="text" id="messageInput" class="chat-input" placeholder="Tulis pesan Anda..." autocomplete="off">

        <button class="btn-send" onclick="sendMessage()" id="btnSend">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

    {{-- Audio Notification --}}
    <audio id="notifSound" preload="auto">
        <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbsGczEjBYktfpx2QnCiRIgMzr2HhGFBlAcLvb5ZRoOB03ZanU5q9zNhoxYZ/P4bSCSiY0Y6vT35djJxtBb7PR35RcHxZHecLh6a12JBdFdsXh6bN3IhRDdMXh6bN3IhRDdA==" type="audio/wav">
    </audio>

    <script>
        // ==========================================
        // KONFIGURASI
        // ==========================================
        const CONSULTATION_ID = {{ $consultationId }};
        const USER_ID = {{ $userId }};
        const USER_ROLE = '{{ $userRole }}';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        const POLL_INTERVAL = 3000; // 3 detik

        const chatBox = document.getElementById('chatBox');
        const messageInput = document.getElementById('messageInput');
        const btnSend = document.getElementById('btnSend');
        const notifSound = document.getElementById('notifSound');
        const toastEl = document.getElementById('chatToast');
        const toastText = document.getElementById('toastText');

        // Track ID pesan terakhir untuk polling
        let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->id : 0 }};
        let isPolling = true;

        // Scroll ke bawah saat pertama load
        scrollToBottom();

        // ==========================================
        // KIRIM PESAN (POST ke Server)
        // ==========================================
        function sendMessage() {
            const text = messageInput.value.trim();
            if (text === "") return;

            // Disable tombol kirim sementara
            btnSend.disabled = true;
            messageInput.value = "";

            // Tampilkan pesan optimistis (langsung muncul)
            const tempId = 'temp_' + Date.now();
            addMessage(text, 'out', new Date(), tempId, false);
            scrollToBottom();

            // Kirim ke server
            fetch('{{ route("chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    consultation_id: CONSULTATION_ID,
                    message: text,
                }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update ID pesan terakhir
                    lastMessageId = data.message.id;

                    // Ganti temp element dengan ID asli
                    const tempEl = document.querySelector(`[data-message-id="${tempId}"]`);
                    if (tempEl) {
                        tempEl.setAttribute('data-message-id', data.message.id);
                    }
                }
                btnSend.disabled = false;
            })
            .catch(err => {
                console.error('Gagal kirim pesan:', err);
                btnSend.disabled = false;
                showToast('⚠️ Gagal mengirim pesan. Coba lagi.');
            });
        }
        // ==========================================
        // POLLING: Ambil Pesan Baru tiap 3 detik
        // ==========================================
        function pollMessages() {
            if (!isPolling) return;

            fetch(`/chat/messages/${CONSULTATION_ID}?after_id=${lastMessageId}`, {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Check if session has been closed
                    if (data.consultation_status === 'ended') {
                        isPolling = false;
                        Swal.fire({
                            title: 'Sesi Berakhir!',
                            text: 'Sesi konsultasi ini telah resmi diakhiri.',
                            icon: 'info',
                            confirmButtonColor: '#4f46e5',
                            confirmButtonText: 'Kembali ke Dashboard',
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.href = USER_ROLE === 'psychologist' 
                                ? '{{ route("dashboard.psychologist") }}' 
                                : '{{ route("dashboard.customer") }}';
                        });
                        return;
                    }

                    // Check for end session request
                    const agreementDiv = document.getElementById('endSessionAgreement');
                    const requestBy = data.end_requested_by;

                    if (requestBy) {
                        if (requestBy == USER_ID) {
                            document.getElementById('agreementTitle').textContent = 'Permintaan Akhiri Sesi';
                            document.getElementById('agreementText').textContent = 'Menunggu persetujuan partner untuk mengakhiri sesi ini.';
                            document.getElementById('agreementActions').innerHTML = `
                                <button onclick="cancelEndRequest()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Batal Kirim</button>
                            `;
                            agreementDiv.classList.remove('d-none');
                        } else {
                            const partner = '{{ $partnerName }}';
                            document.getElementById('agreementTitle').textContent = 'Partner Meminta Akhiri Sesi';
                            document.getElementById('agreementText').textContent = `${partner} ingin mengakhiri sesi konsultasi ini. Apakah Anda menyetujuinya?`;
                            document.getElementById('agreementActions').innerHTML = `
                                <button onclick="acceptEndSession()" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">Setuju & Akhiri</button>
                                <button onclick="rejectEndSession()" class="btn btn-light btn-sm rounded-pill px-3 border">Tolak</button>
                            `;
                            agreementDiv.classList.remove('d-none');
                        }
                    } else {
                        agreementDiv.classList.add('d-none');
                    }

                    // Render messages if any
                    if (data.messages && data.messages.length > 0) {
                        let hasNewFromPartner = false;

                        data.messages.forEach(msg => {
                            // Cek apakah pesan ini sudah ada di DOM
                            if (document.querySelector(`[data-message-id="${msg.id}"]`)) return;

                            // Hanya render pesan dari partner (pesan sendiri sudah ditampilkan optimistis)
                            if (msg.sender_id != USER_ID) {
                                const type = 'in';
                                addMessage(msg.message, type, new Date(msg.created_at), msg.id, true);
                                hasNewFromPartner = true;
                            }

                            // Update lastMessageId
                            if (msg.id > lastMessageId) {
                                lastMessageId = msg.id;
                            }
                        });

                        if (hasNewFromPartner) {
                            // Play sound
                            playNotifSound();
                            showToast('💬 Pesan baru diterima!');
                            scrollToBottom();
                        }
                    }
                }
            })
            .catch(err => {
                console.error('Polling error:', err);
            })
            .finally(() => {
                setTimeout(pollMessages, POLL_INTERVAL);
            });
        }

        // Mulai polling
        setTimeout(pollMessages, POLL_INTERVAL);

        // ==========================================
        // FITUR KESEPAKATAN AKHIRI SESI (MUTUAL AGREEMENT)
        // ==========================================
        function confirmRequestEnd() {
            Swal.fire({
                title: 'Akhiri Sesi Konsultasi?',
                text: 'Permintaan persetujuan akan dikirim ke partner Anda. Sesi hanya berakhir jika disetujui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Kirim Permintaan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/chat/request-end/${CONSULTATION_ID}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('📤 Permintaan akhiri sesi dikirim.');
                        }
                    });
                }
            });
        }

        function acceptEndSession() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/chat/end/${CONSULTATION_ID}`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = CSRF_TOKEN;
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }

        function rejectEndSession() {
            fetch(`/chat/reject-end/${CONSULTATION_ID}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('endSessionAgreement').classList.add('d-none');
                    showToast('❌ Permintaan akhiri sesi ditolak.');
                }
            });
        }

        function cancelEndRequest() {
            rejectEndSession();
        }
        // ==========================================
        // RENDER CHAT BUBBLE
        // ==========================================
        function addMessage(text, type, timestamp, messageId, animate) {
            const time = new Date(timestamp).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            const div = document.createElement('div');
            div.className = `message-bubble message-${type}${animate ? ' chat-animate-in' : ''}`;
            div.setAttribute('data-message-id', messageId);

            // Escape HTML & convert newlines
            const safeText = text.replace(/&/g, '&amp;')
                                 .replace(/</g, '&lt;')
                                 .replace(/>/g, '&gt;')
                                 .replace(/\n/g, '<br>');

            const checkIcon = type === 'out' 
                ? '<i class="fas fa-check text-muted ms-1" style="font-size: 10px;"></i>' 
                : '';

            div.innerHTML = `
                ${safeText}
                <span class="message-time">${time} ${checkIcon}</span>
            `;

            chatBox.appendChild(div);
        }

        // ==========================================
        // UTILITY FUNCTIONS
        // ==========================================
        function scrollToBottom() {
            setTimeout(() => {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100);
        }

        function playNotifSound() {
            try {
                notifSound.currentTime = 0;
                notifSound.play().catch(() => {});
            } catch(e) {}
        }

        function showToast(text) {
            toastText.textContent = text;
            toastEl.classList.remove('d-none');
            toastEl.classList.add('toast-show');

            setTimeout(() => {
                toastEl.classList.remove('toast-show');
                setTimeout(() => toastEl.classList.add('d-none'), 300);
            }, 3000);
        }

        // Kirim pakai tombol ENTER
        messageInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });

        // Cleanup saat user pergi
        window.addEventListener('beforeunload', () => {
            isPolling = false;
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>