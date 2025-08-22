<style>
    /* Navbar */
    .sidebar-enter {
        transform: translateX(-100%);
    }

    .sidebar-enter-active {
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
    }

    .nav-item {
        position: relative;
        overflow: hidden;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .nav-item.active::before,
    .nav-item:hover::before {
        transform: translateX(0);
    }

    .nav-item.active {
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        color: #3b82f6;
    }

    .nav-item .icon {
        transition: transform 0.3s ease;
    }

    .nav-item:hover .icon {
        transform: scale(1.1);
    }

    .logo-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .overlay {
        display: none;
    }

    /* Section Headers */
    .nav-section-title {
        position: relative;
        text-align: center;
        margin: 1rem 0 0.75rem 0;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .nav-section-title::before,
    .nav-section-title::after {
        content: '';
        position: absolute;
        top: 50%;
        width: calc(50% - 0.75rem);
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    }

    .nav-section-title::before {
        left: 0;
    }

    .nav-section-title::after {
        right: 0;
    }

    /* Sidebar Scrollbar */
    .sidebar-scroll {
        height: calc(100vh - 96px);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            width: 280px !important;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .overlay {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 40;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .main-content {
            margin-left: 0;
        }

        /* Better touch targets for mobile */
        .nav-item {
            min-height: 48px;
            padding: 0.75rem 1rem !important;
        }

        .nav-section-title {
            font-size: 0.7rem;
            margin: 0.75rem 0 0.5rem 0;
        }

        /* Dropdown items mobile optimization */
        .nav-dropdown-item {
            min-height: 40px;
            padding: 0.5rem 0.75rem !important;
        }
    }

    /* Tablet Responsive */
    @media (max-width: 1024px) and (min-width: 769px) {
        .sidebar {
            width: 12rem;
        }

        .main-content {
            margin-left: 12rem;
        }
    }

    /* Desktop Hover Effects */
    @media (min-width: 1025px) {
        .sidebar:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .main-content {
            margin-left: 18rem;
        }
    }

    @media (min-width: 769px) {
        .main-content {
            margin-left: 16rem;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0 !important;
        }
    }

    /* Dropdown animations */
    .dropdown-enter {
        opacity: 0;
        transform: translateY(-8px);
    }

    .dropdown-enter-active {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.2s ease-out, transform 0.2s ease-out;
    }

    .dropdown-leave {
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-leave-active {
        opacity: 0;
        transform: translateY(-8px);
        transition: opacity 0.15s ease-in, transform 0.15s ease-in;
    }
</style>

<!-- Top Navbar - ORIGINAL CODE PRESERVED -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Kiri: Burger Menu + Logo -->
        <div class="flex items-center w-full">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center shadow-md">
                    <img src="https://cdn.aceimg.com/1d462648b.png" alt="Sendang Plesungan" class="h-12 w-12 object-contain">
                </div>
                <h1 class="text-gray-800 text-xl font-bold hidden sm:block">Kasir Tiket Renang</h1>
            </div>

            <!-- Burger Menu -->
            <button class="ml-2  rounded-lg hover:bg-gray-100 transition-colors duration-200" id="menuToggle">
                <i class="fas fa-bars text-gray-600 text-lg"></i>
            </button>

            <!-- Spacer untuk mendorong date ke kanan -->
            <div class="flex-1"></div>

            <!-- Current Date and Time (hanya tampil inline di sm ke atas) -->
            <div class="hidden sm:flex items-center text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span id="current-date"></span>
                <span class="mx-2">•</span>
                <i class="fas fa-clock mr-2"></i>
                <span id="current-time"></span>
            </div>
        </div>

        <!-- Right: User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50" x-cloak>
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                @php
                $role = auth()->user()->role;
                $prefix = $role === 'admin' ? 'admin.' : ($role === 'kasir' ? 'kasir.' : 'user.');
                @endphp
                <a href="{{ route($prefix . 'setting') }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid fa-gear mr-3 text-gray-400"></i>Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket mr-3"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Current Date and Time (khusus mobile, tampil di bawah navbar) -->
    <div class="sm:hidden px-4 pb-2 flex items-center text-sm text-gray-500">
        <i class="fas fa-calendar-alt mr-2"></i>
        <span id="current-dates"></span>
        <span class="mx-2">•</span>
        <i class="fas fa-clock mr-2"></i>
        <span id="current-times"></span>
    </div>
</nav>

<!-- Overlay untuk Mobile -->
<div class="overlay" id="overlay"></div>

<!-- Sidebar - IMPROVED WITH SECTIONS -->
<div class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-2xl lg:w-72 h-screen" id="sidebar">
    <!-- Navigation -->
    <nav class="mt-24 px-4 pb-4 h-full">
        <div class="sidebar-scroll h-full overflow-y-auto">

            <!-- FITUR UTAMA Section -->
            <div class="nav-section-title">Fitur Utama</div>
            <div class="space-y-1 mb-6">
                <a href="{{ route($prefix . 'dashboard') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-lg icon"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route($prefix . 'kasir') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'kasir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-ticket mr-3 text-lg icon"></i>
                    <span class="font-medium">Kasir Tiket</span>
                </a>

                @auth
                @if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'user')
                <a href="{{ route($prefix . 'absensi.scan') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'absensi.scan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-qrcode mr-3 text-lg icon"></i>
                    <span class="font-medium">Scan Absen</span>
                </a>
                @endif
                @endauth

                @auth
                @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
                <a href="{{ route($prefix . 'broadcast') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'broadcast') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-bullhorn mr-3 text-lg icon"></i>
                    <span class="font-medium">Broadcast</span>
                </a>
                @endif
                @endauth
            </div>

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <!-- MASTER DATA Section -->
            <div class="nav-section-title">Master Data</div>
            <div class="space-y-1 mb-6">
                <!-- Produk Dropdown -->
                <div x-data="{ open: {{ request()->routeIs($prefix . 'produk') || request()->routeIs($prefix . 'diskon') || request()->routeIs($prefix . 'parkir') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                        class="nav-item w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group focus:outline-none
                        {{ request()->routeIs($prefix . 'produk') || request()->routeIs($prefix . 'diskon') || request()->routeIs($prefix . 'parkir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="fa-solid fa-box mr-3 text-lg icon"></i>
                        <span class="font-medium">Produk</span>
                        <svg :class="{ 'rotate-180': open }" class="ml-auto h-4 w-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        x-cloak class="ml-8 mr-2 space-y-1 text-sm">
                        <a href="{{ route($prefix . 'produk') }}"
                            class="nav-dropdown-item flex items-center px-3 py-2 rounded-lg transition hover:bg-blue-50
                            {{ request()->routeIs($prefix . 'produk') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                            <i class="fas fa-ticket-alt mr-2 text-xs"></i>
                            Tiket
                        </a>
                        <a href="{{ route($prefix . 'diskon') }}"
                            class="nav-dropdown-item flex items-center px-3 py-2 rounded-lg transition hover:bg-blue-50
                            {{ request()->routeIs($prefix . 'diskon') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                            <i class="fas fa-percentage mr-2 text-xs"></i>
                            Diskon
                        </a>
                        <a href="{{ route($prefix . 'parkir') }}"
                            class="nav-dropdown-item flex items-center px-3 py-2 rounded-lg transition hover:bg-blue-50
                            {{ request()->routeIs($prefix . 'parkir') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                            <i class="fas fa-car mr-2 text-xs"></i>
                            Parkir
                        </a>
                    </div>
                </div>

                <a href="{{ route($prefix . 'karyawan') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'karyawan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-users mr-3 text-lg icon"></i>
                    <span class="font-medium">Karyawan</span>
                </a>
            </div>

            <!-- MANAJEMEN Section -->
            <div class="nav-section-title">Manajemen</div>
            <div class="space-y-1 mb-6">
                <a href="{{ route($prefix . 'keuangan') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'keuangan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-sack-dollar mr-3 text-lg icon"></i>
                    <span class="font-medium">Keuangan</span>
                </a>

                <a href="{{ route($prefix . 'absensi') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'absensi') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-calendar-days mr-3 text-lg icon"></i>
                    <span class="font-medium">Absensi</span>
                </a>

                <!-- Slip Gaji Dropdown -->
                <div x-data="{ open: {{ request()->routeIs($prefix . 'slipgaji') || request()->routeIs($prefix . 'slipgaji.setting') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                        class="nav-item w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group focus:outline-none
                        {{ request()->routeIs($prefix . 'slipgaji') || request()->routeIs($prefix . 'slipgaji.setting') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="fa-solid fa-money-check-dollar mr-3 text-lg icon"></i>
                        <span class="font-medium">Slip Gaji</span>
                        <svg :class="{ 'rotate-180': open }" class="ml-auto h-4 w-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        x-cloak class="ml-8 mr-2 space-y-1 text-sm">
                        <a href="{{ route($prefix . 'slipgaji') }}"
                            class="nav-dropdown-item flex items-center px-3 py-2 rounded-lg transition hover:bg-blue-50
                            {{ request()->routeIs($prefix . 'slipgaji') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                            <i class="fas fa-file-invoice-dollar mr-2 text-xs"></i>
                            Slip Gaji
                        </a>
                        <a href="{{ route($prefix . 'slipgaji.setting') }}"
                            class="nav-dropdown-item flex items-center px-3 py-2 rounded-lg transition hover:bg-blue-50
                            {{ request()->routeIs($prefix . 'slipgaji.setting') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                            <i class="fas fa-cog mr-2 text-xs"></i>
                            Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAPORAN Section -->
            <div class="nav-section-title">Laporan</div>
            <div class="space-y-1 mb-6">
                <a href="{{ route($prefix . 'laporan') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs($prefix . 'laporan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-clipboard mr-3 text-lg icon"></i>
                    <span class="font-medium">Laporan</span>
                </a>
            </div>
            @endif
            @endauth

            <!-- Bottom padding for better scrolling -->
            <div class="h-20"></div>
        </div>
    </nav>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');

        if (window.innerWidth > 768) {
            document.body.classList.toggle('sidebar-collapsed');
        }
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        }
    });

    // Update current date and time
    function updateDateTime() {
        const now = new Date();
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        const dateStr = now.toLocaleDateString('id-ID', dateOptions);
        const timeStr = now.toLocaleTimeString('id-ID', timeOptions);

        // Update elements if they exist
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        const datesEl = document.getElementById('current-dates');
        const timesEl = document.getElementById('current-times');

        if (dateEl) dateEl.textContent = dateStr;
        if (timeEl) timeEl.textContent = timeStr;
        if (datesEl) datesEl.textContent = dateStr;
        if (timesEl) timesEl.textContent = timeStr;
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Prevent body scroll when sidebar is open on mobile
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                if (window.innerWidth <= 768) {
                    if (sidebar.classList.contains('open')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            }
        });
    });

    observer.observe(sidebar, {
        attributes: true
    });

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>