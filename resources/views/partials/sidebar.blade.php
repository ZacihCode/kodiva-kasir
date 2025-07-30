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

    .menu-toggle {
        display: none;
    }

    .overlay {
        display: none;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .menu-toggle {
            display: flex;
        }

        .overlay {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
    }

    /* Tablet Responsive */
    @media (max-width: 1024px) and (min-width: 769px) {
        .sidebar {
            width: 12rem;
        }
    }

    /* Desktop Hover Effects */
    @media (min-width: 1025px) {
        .sidebar:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    }
</style>
<!-- Mobile Menu Toggle -->
<button class="menu-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg md:hidden">
    <i class="fas fa-bars text-gray-600"></i>
</button>

<!-- Overlay untuk Mobile -->
<div class="overlay" id="overlay"></div>

<!-- Sidebar -->
<div class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl lg:w-72 h-screen overflow-y-auto" id="sidebar">
    <!-- Header -->
    <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative z-10 flex items-center space-x-2">
            <div class="logo-animation">
                <img src="https://cdn.aceimg.com/446a53924.png" alt="Sendang Plesungan" class="h-8 w-8 object-contain">
            </div>
            <h1 class="text-white text-xl font-bold tracking-wide">Kasir Tiket</h1>
        </div>
        <!-- Close button for mobile -->
        <button class="absolute top-4 right-4 text-white hover:text-gray-200 md:hidden" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-4 pb-4 h-full overflow-y-auto">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('kasir') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('kasir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-ticket mr-3 text-lg"></i>
                <span class="font-medium">Kasir Tiket</span>
            </a>

            <!-- Produk Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('produk') || request()->routeIs('diskon') || request()->routeIs('parkir') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open"
                    class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group focus:outline-none
        {{ request()->routeIs('produk') || request()->routeIs('diskon') || request()->routeIs('parkir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-box mr-3 text-lg"></i>
                    <span class="font-medium">Produk</span>
                    <svg :class="{ 'rotate-180': open }" class="ml-auto h-4 w-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="pl-10 space-y-1 text-sm">
                    <a href="{{ route('produk') }}"
                        class="block px-2 py-1 rounded transition hover:bg-blue-50
            {{ request()->routeIs('produk') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Tiket
                    </a>
                    <a href="{{ route('diskon') }}"
                        class="block px-2 py-1 rounded transition hover:bg-blue-50
            {{ request()->routeIs('diskon') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Diskon
                    </a>
                    <a href="{{ route('parkir') }}"
                        class="block px-2 py-1 rounded transition hover:bg-blue-50
            {{ request()->routeIs('parkir') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Parkir
                    </a>
                </div>
            </div>

            <a href="{{ route('keuangan') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('keuangan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-sack-dollar mr-3 text-lg"></i>
                <span class="font-medium">Keuangan</span>
            </a>

            <a href="{{ route('absensi') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('absensi') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-calendar-days mr-3 text-lg"></i>
                <span class="font-medium">Absensi</span>
            </a>

            <a href="{{ route('laporan') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('laporan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-clipboard mr-3 text-lg"></i>
                <span class="font-medium">Laporan</span>
            </a>

            <a href="{{ route('slipgaji') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs('slip-gaji') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-money-check-dollar mr-3 text-lg"></i>
                <span class="font-medium">Slip Gaji</span>
            </a>
        </div>

        <!-- User Profile Section with Dropdown -->
        <div class="mt-8 pt-4 border-t border-gray-200" x-data="{ open: false }">
            <div class="relative">
                <button @click="open = !open" class="w-full flex items-center px-4 py-3 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3 text-left">
                        <p class="text-sm font-medium text-gray-700">Admin User</p>
                        <p class="text-xs text-gray-500">Kasir Utama</p>
                    </div>
                    <svg class="w-4 h-4 ml-auto text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-4 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50" x-cloak>
                    <a href="{{ route('setting') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-gear mr-2"></i>Pengaturan
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div x-data="{open: false, date: new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }), time: new Date().toLocaleTimeString('id-ID'),
            init() {setInterval(() => {this.time = new Date().toLocaleTimeString('id-ID');}, 1000);}}">
            <div class="px-4 py-3 border-b">
                <p class="text-gray-800 font-semibold">📅 <span x-text="date"></span></p>
                <p class="text-gray-600">⏰ <span x-text="time"></span></p>
            </div>
        </div>
        <!-- Footer -->
        <div class="text-center mt-4 pt-2 border-t border-white/10">
            <p class="text-black font-semibold text-sm flex items-center justify-center gap-2">
                <img src="https://cdn.aceimg.com/b127a1e12.png" alt="heart" class="w-4 h-4">
                © 2025 <span class="text-black font-semibold">kodiva.id</span>
                <i class="fas fa-sparkles text-yellow-400"></i>
            </p>
        </div>
    </nav>
</div>

<script>
    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
        overlay.classList.add('active');
    });

    closeSidebar.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    });
</script>