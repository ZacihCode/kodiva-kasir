<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Absensi</title>
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.4s ease-out;
        }

        /* Custom styles for QR scanner */
        #reader video {
            border-radius: 0.75rem !important;
        }

        #reader>div:first-child {
            border-radius: 0.75rem !important;
            overflow: hidden !important;
        }
    </style>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h-.01M12 12v.01"></path>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Scan QR Code</h1>
                <p class="text-gray-600 text-sm sm:text-base">Arahkan kamera ke QR code karyawan</p>
            </div>

            <!-- Flash Message -->
            <div id="flash-message" class="hidden mb-6 p-4 rounded-xl shadow-sm border-l-4 animate-fade-in">
            </div>

            <!-- QR Scanner Container -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
                <div class="p-6">
                    <div class="relative">
                        <div id="reader" class="w-full rounded-xl overflow-hidden shadow-inner bg-gray-50 min-h-[280px] sm:min-h-[320px]"></div>

                        <!-- Scanner Overlay -->
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="w-full h-full border-2 border-dashed border-blue-300 rounded-xl opacity-50"></div>
                        </div>
                    </div>

                    <!-- Scanner Status -->
                    <div id="scanner-statuson" class="mt-4 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span>Scanner aktif</span>
                        </div>
                    </div>
                    <div id="scanner-statusoff" class="hidden mt-4 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                            <span>Scanner tidak aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div id="user-info" class="hidden bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6 animate-slide-up">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Data Karyawan</h3>
                            <p class="text-green-100 text-sm">Berhasil dipindai</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">ID</p>
                            <p class="text-sm font-semibold text-gray-900 truncate" id="info-id"></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama</p>
                            <p class="text-sm font-semibold text-gray-900 truncate" id="info-nama"></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</p>
                            <p class="text-sm font-semibold text-gray-900 truncate" id="info-email"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div id="instructions" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Cara Penggunaan
                </h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-semibold text-blue-600">1</span>
                        </div>
                        <span>Pastikan QR code berada dalam frame kamera</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-semibold text-blue-600">2</span>
                        </div>
                        <span>Tunggu hingga QR code terbaca secara otomatis</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-semibold text-blue-600">3</span>
                        </div>
                        <span>Data absensi akan tersimpan otomatis</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <audio id="success-audio" preload="auto">
        <source src="/sounds/success.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    @endsection

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let audioUnlocked = false;
        window.addEventListener('click', () => {
            if (!audioUnlocked) {
                const audio = document.getElementById('success-audio');
                if (audio) audio.play().catch(() => {});
                audio.pause(); // Segera pause agar tidak berbunyi
                audioUnlocked = true;
            }
        });

        // Inisialisasi QR Code scanner
        const html5QrCode = new Html5Qrcode("reader");
        const qrConfig = {
            fps: 10,
            qrbox: 250
        };

        // Fungsi handler hasil scan
        async function handleScanResult(qrCodeMessage) {
            const lines = qrCodeMessage.split('\n');
            const idLine = lines.find(line => line.trim().toLowerCase().startsWith('id:'));
            const namaLine = lines.find(line => line.trim().toLowerCase().startsWith('nama:'));
            const emailLine = lines.find(line => line.trim().toLowerCase().startsWith('email:'));

            if (idLine) {
                const userId = idLine.split(':')[1].trim();
                const nama = namaLine ? namaLine.split(':')[1].trim() : '-';
                const email = emailLine ? emailLine.split(':')[1].trim() : '-';

                document.getElementById('info-id').textContent = userId;
                document.getElementById('info-nama').textContent = nama;
                document.getElementById('info-email').textContent = email;
                document.getElementById('user-info').classList.remove('hidden');
                document.getElementById('instructions').classList.add('hidden');
                document.getElementById('scanner-statuson').classList.add('hidden');
                document.getElementById('scanner-statusoff').classList.remove('hidden');

                await html5QrCode.stop();

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch("{{ route('kasir.absensi.submit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        user_id: userId
                    })
                });

                const result = await response.json();
                showFlashMessage(
                    result.status === "success" ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200',
                    result.message,
                    result.status === "success" ? 'text-green-600' : 'text-red-600'
                );

                // Play success audio if absen berhasil
                if (result.status === "success") {
                    const audio = document.getElementById('success-audio');
                    if (audio) {
                        audio.volume = 1.0; // Atur ke volume maksimum
                        audio.play().catch(err => console.log("Audio play failed:", err));
                    }
                }

                // Reset kamera + UI setelah 5 detik
                setTimeout(() => {
                    document.getElementById('flash-message').classList.add('hidden');
                    document.getElementById('user-info').classList.add('hidden');
                    document.getElementById('instructions').classList.remove('hidden');
                    document.getElementById('scanner-statuson').classList.remove('hidden');
                    document.getElementById('scanner-statusoff').classList.add('hidden');

                    html5QrCode.start({
                            facingMode: "environment"
                        },
                        qrConfig,
                        handleScanResult, // << penting!
                        error => {}
                    );
                }, 1000);
            } else {
                alert("❌ Format QR tidak valid. Pastikan berisi ID.");
            }
        }

        // Jalankan scanner pertama kali
        html5QrCode.start({
                facingMode: "environment"
            },
            qrConfig,
            handleScanResult,
            error => {}
        ).catch(err => {
            console.error("Camera start error:", err);
        });

        function showFlashMessage(cssClass, message, iconColor = 'text-blue-600') {
            const flash = document.getElementById('flash-message');
            const isSuccess = cssClass.includes('green');
            const icon = isSuccess ?
                `<svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>` :
                `<svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            flash.className = `mb-6 p-4 rounded-xl shadow-sm border-l-4 animate-fade-in ${cssClass}`;
            flash.innerHTML = `
            <div class="flex items-center space-x-3">
                ${icon}
                <span class="font-medium">${message}</span>
            </div>
        `;
            flash.classList.remove('hidden');
        }
    </script>
    @endpush
</body>

</html>