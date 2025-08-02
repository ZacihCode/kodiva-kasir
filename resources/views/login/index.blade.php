<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wisata Sendang Plesungan - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                        accent: '#06b6d4'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen">
    <div id="toast-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-info="{{ session('info') ?: ($infoMessage ?? '') }}">
    </div>
    @vite(['resources/js/app.jsx'])
    <!-- Auth Container -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Login Form -->
            <div id="login-form" class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="mx-auto h-16 w-16 white rounded-full flex items-center justify-center mb-4">
                        <img src="https://cdn.aceimg.com/1d462648b.png" alt="Sendang Plesungan" class="h-16 w-16 object-contain">
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Masuk ke Akun</h2>
                    <p class="mt-2 text-gray-600">Selamat datang kembali di Wisata Sendang Plesungan</p>
                </div>

                <form id="loginForm" action="{{ url('/login') }}" method="POST" data-loading>
                    @csrf
                    @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md text-sm shadow">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md text-sm shadow">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="mb-4">
                        <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-primary"></i>Email
                        </label>
                        <input id="login-email" name="email" type="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                            placeholder="nama@email.com">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="login-password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-primary"></i>Password
                        </label>
                        <div class="relative">
                            <input id="login-password" name="password" type="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition pr-12"
                                placeholder="••••••••" />
                            <button type="button" id="toggle-login-password"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </button>

                    <div class="text-sm text-center text-gray-600 mt-4">
                    </div>
                </form>
            </div>
            <!-- Footer -->
            <div class="text-center mt-8 pt-6 border-t border-white/10">
                <p class="text-black font-semibold text-sm flex items-center justify-center gap-2">
                    <img src="https://cdn.aceimg.com/b127a1e12.png" alt="heart" class="w-4 h-4">
                    © 2025 <span class="text-black font-semibold">kodiva.id</span>
                    <i class="fas fa-sparkles text-yellow-400"></i>
                </p>
            </div>
        </div>
    </div>

    <!-- Floating Particles Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 w-2 h-2 bg-primary rounded-full opacity-30 animate-bounce"></div>
        <div class="absolute top-40 right-20 w-3 h-3 bg-accent rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-2 h-2 bg-green-400 rounded-full opacity-25 animate-bounce" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 right-10 w-2 h-2 bg-primary rounded-full opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 left-1/4 w-1 h-1 bg-accent rounded-full opacity-40 animate-ping" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-2/3 right-1/3 w-1 h-1 bg-green-400 rounded-full opacity-35 animate-ping" style="animation-delay: 1.5s;"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toastRoot = document.getElementById('toast-root');
            if (toastRoot?.dataset.success) showToast('success', toastRoot.dataset.success);
            if (toastRoot?.dataset.error) showToast('error', toastRoot.dataset.error);
            if (toastRoot?.dataset.info) showToast('info', toastRoot.dataset.info);
        });
        // Toggle password visibility
        const toggle = document.getElementById('toggle-login-password');
        const input = document.getElementById('login-password');

        toggle.addEventListener('click', () => {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;

            const icon = toggle.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Particle animation duration randomizer
        const particles = document.querySelectorAll('.fixed.inset-0 > div');
        particles.forEach(p => {
            const delay = Math.random() * 3;
            const duration = 3 + Math.random() * 2;
            p.style.animationDelay = `${delay}s`;
            p.style.animationDuration = `${duration}s`;
        });
    </script>
</body>

</html>