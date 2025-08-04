<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Qr Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        .wave-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: auto;
        }

        .wave-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
            background-size: 1440px 320px;
            animation: wave 20s ease-in-out infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-50px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .water-drop {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: drop 4s ease-in-out infinite;
        }

        @keyframes drop {
            0% {
                transform: translateY(-100px) scale(0);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) scale(1);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="min-h-screen wave-bg">
    <!-- Water Drops Animation -->
    <div class="water-drop w-2 h-2" style="left: 10%; animation-delay: 0s;"></div>
    <div class="water-drop w-3 h-3" style="left: 20%; animation-delay: 1s;"></div>
    <div class="water-drop w-2 h-2" style="left: 80%; animation-delay: 2s;"></div>
    <div class="water-drop w-4 h-4" style="left: 90%; animation-delay: 3s;"></div>

    <!-- Header -->
    <div class="sticky top-0 z-50 bg-white bg-opacity-50 backdrop-blur-md border-b border-white border-opacity-30">
        <div class="container mx-auto px-4 py-4 relative">
            <div class="flex items-center justify-between">
                <!-- Logo & Judul -->
                <div class="flex items-center space-x-4">
                    <div class="h-14 w-14 md:h-16 md:w-16 rounded-full flex items-center justify-center">
                        <img src="https://cdn.aceimg.com/1d462648b.png" alt="Sendang Plesungan" class="h-full w-full object-contain">
                    </div>
                    <div class="text-black">
                        <h1 class="text-lg md:text-2xl font-bold">Pool Management System</h1>
                        <p class="text-sm md:text-base font-medium">Sistem Absensi Kolam Berenang</p>
                    </div>
                </div>

                <!-- Burger Menu untuk Mobile -->
                <div class="relative md:hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="text-white bg-blue-600 hover:bg-blue-700 p-2 rounded-lg focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div x-show="open" x-transition @click.outside="open = false"
                        class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg z-50 overflow-visible">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tombol Logout untuk Desktop -->
                <div class="hidden md:block">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Time & Date Card -->
            <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white border-opacity-30 shadow-xl">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-clock text-white text-3xl mr-3"></i>
                        <div>
                            <p id="clock" class="text-white text-3xl font-bold font-mono"></p>
                            <p id="date" class="text-blue-100 text-sm mt-1"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Card -->
            <div id="qr-card" class="bg-white bg-opacity-95 backdrop-blur-md rounded-2xl p-8 mb-6 border border-white border-opacity-50 shadow-2xl floating">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-qrcode text-blue-600 text-2xl mr-3"></i>
                        <h2 class="text-gray-800 text-xl font-bold">QR Code Absensi</h2>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 mb-4">
                        <!-- PHP QR Code section - keeping original logic -->
                        @php
                        $qrPath = public_path($user->qr_code);
                        @endphp
                        @if (file_exists($qrPath))
                        <div class="inline-block p-4 bg-white rounded-lg shadow-md">
                            <img src="{{ asset($user->qr_code) }}" alt="QR Code" class="w-48 h-48 mx-auto">
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center h-48">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                            <p class="text-gray-600 italic">QR Code belum tersedia</p>
                            <p class="text-gray-500 text-sm mt-2">Hubungi administrator untuk generate QR Code</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-blue-50 rounded-lg p-2">
                        <p class="text-gray-700 text-sm">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Tunjukkan QR Code ini ke petugas kasir untuk absensi
                        </p>
                        <p class="text-gray-700 text-sm mt-2">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Sistem keamanan terjamin dengan teknologi QR Code
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-2xl p-6 border border-white border-opacity-30 shadow-xl">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-check text-white text-2xl mr-3"></i>
                        <h3 class="text-white text-lg font-semibold">Status Absensi Hari Ini</h3>
                    </div>

                    <div class="bg-white bg-opacity-30 rounded-lg p-4">
                        <div class="flex items-center justify-center space-x-2">
                            @if($status === 'Hadir')
                            <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                            <span class="text-white text-xl font-bold">{{ $status }}</span>
                            @elseif($status === 'Belum Absen')
                            <i class="fas fa-clock text-yellow-400 text-2xl"></i>
                            <span class="text-white text-xl font-bold">{{ $status }}</span>
                            @else
                            <i class="fas fa-times-circle text-red-400 text-2xl"></i>
                            <span class="text-white text-xl font-bold">{{ $status }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center pb-8">
        <p class="text-black font-semibold text-sm flex items-center justify-center gap-2">
            <img src="https://cdn.aceimg.com/b127a1e12.png" alt="heart" class="w-4 h-4">
            © 2025 <span class="text-black font-semibold">kodiva.id</span>
            <i class="fas fa-sparkles text-yellow-400"></i>
        </p>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById("clock").textContent = time;
            document.getElementById("date").textContent = date;
        }

        function animateCard() {
            const card = document.getElementById('qr-card');
            card.classList.add('animate-pulse');
            setTimeout(() => {
                card.classList.remove('animate-pulse');
            }, 1000);
        }

        setInterval(updateClock, 1000);
        window.onload = function() {
            updateClock();
            animateCard();
        };
    </script>
</body>

</html>