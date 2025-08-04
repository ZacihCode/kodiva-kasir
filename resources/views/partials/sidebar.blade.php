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

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
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

        .main-content {
            margin-left: 0;
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
            /* lg:w-72 */
        }
    }

    @media (min-width: 769px) {
        .main-content {
            margin-left: 16rem;
            /* w-64 */
        }

        body.sidebar-collapsed .sidebar {
            display: none;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0 !important;
        }
    }
</style>

<!-- Top Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Kiri: Burger Menu + Logo -->
        <div class="flex items-center space-x-3">
            <!-- Logo -->
            <div class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-1 rounded-md">
                <div class="bg-white bg-opacity-20 p-2 rounded-full">
                    <img src="https://cdn.aceimg.com/1d462648b.png" alt="Sendang Plesungan" class="h-4 w-4 object-contain">
                </div>
                <h1 class="text-white text-lg font-bold hidden sm:block">Kasir Tiket</h1>
            </div>
            <!-- Burger Menu -->
            <button class="p-2 rounded-lg hover:bg-gray-100" id="menuToggle">
                <i class="fas fa-bars text-gray-600 text-lg"></i>
            </button>
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
</nav>


<!-- Overlay untuk Mobile -->
<div class="overlay" id="overlay"></div>

<!-- Sidebar -->
<div class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-2xl lg:w-72 h-screen overflow-hidden" id="sidebar">
    <!-- Navigation -->
    <nav class="mt-24 px-4 pb-4 h-full overflow-hidden">
        <div class="space-y-1">
            <a href="{{ route($prefix . 'dashboard') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
            {{ request()->routeIs($prefix . 'dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route($prefix . 'kasir') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'kasir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-ticket mr-3 text-lg"></i>
                <span class="font-medium">Kasir Tiket</span>
            </a>

            @auth
            @if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'user')
            <a href="{{ route($prefix . 'absensi.scan') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'absensi.scan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-ticket mr-3 text-lg"></i>
                <span class="font-medium">Scan Absen</span>
            </a>
            @endif
            @endauth

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <!-- Produk Dropdown -->
            <div x-data="{ open: {{ request()->routeIs($prefix . 'produk') || request()->routeIs($prefix . 'diskon') || request()->routeIs($prefix . 'parkir') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open"
                    class="nav-item w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group focus:outline-none
                    {{ request()->routeIs($prefix . 'produk') || request()->routeIs($prefix . 'diskon') || request()->routeIs($prefix . 'parkir') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-box mr-3 text-lg"></i>
                    <span class="font-medium">Produk</span>
                    <svg :class="{ 'rotate-180': open }" class="ml-auto h-4 w-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="pl-10 space-y-1 text-sm">
                    <a href="{{ route($prefix . 'produk') }}"
                        class="nav-item block px-2 py-1 rounded transition hover:bg-blue-50
                        {{ request()->routeIs($prefix . 'produk') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Tiket
                    </a>
                    <a href="{{ route($prefix . 'diskon') }}"
                        class="nav-item block px-2 py-1 rounded transition hover:bg-blue-50
                        {{ request()->routeIs($prefix . 'diskon') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Diskon
                    </a>
                    <a href="{{ route($prefix . 'parkir') }}"
                        class="nav-item block px-2 py-1 rounded transition hover:bg-blue-50
                        {{ request()->routeIs($prefix . 'parkir') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Parkir
                    </a>
                </div>
            </div>
            @endif
            @endauth

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <a href="{{ route($prefix . 'keuangan') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'keuangan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-sack-dollar mr-3 text-lg"></i>
                <span class="font-medium">Keuangan</span>
            </a>
            @endif
            @endauth

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <a href="{{ route($prefix . 'karyawan') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'karyawan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-user mr-3 text-lg"></i>
                <span class="font-medium">Karyawan</span>
            </a>
            @endif
            @endauth

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <a href="{{ route($prefix . 'absensi') }}"
                class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'absensi') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-calendar-days mr-3 text-lg"></i>
                <span class="font-medium">Absensi</span>
            </a>
            @endif
            @endauth

            @auth
            @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
            <!-- Slip Gaji Dropdown -->
            <div x-data="{ open: {{ request()->routeIs($prefix . 'slipgaji') || request()->routeIs($prefix . 'slipgaji.setting') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open"
                    class="nav-item w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group focus:outline-none
                    {{ request()->routeIs($prefix . 'slipgaji') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-money-check-dollar mr-3 text-lg"></i>
                    <span class="font-medium">Slip Gaji</span>
                    <svg :class="{ 'rotate-180': open }" class="ml-auto h-4 w-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="pl-10 space-y-1 text-sm">
                    <a href="{{ route($prefix . 'slipgaji') }}"
                        class="nav-item block px-2 py-1 rounded transition hover:bg-blue-50
                        {{ request()->routeIs($prefix . 'slipgaji') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Slip Gaji
                    </a>
                    <a href="{{ route($prefix . 'slipgaji.setting') }}"
                        class="nav-item block px-2 py-1 rounded transition hover:bg-blue-50
                        {{ request()->routeIs($prefix . 'slipgaji.setting') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                        Settings
                    </a>
                </div>
            </div>
            @endif
            @endauth
        </div>

        @auth
        @if(auth()->user()->role !== 'kasir' && auth()->user()->role !== 'user')
        <a href="{{ route($prefix . 'laporan') }}"
            class="nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                {{ request()->routeIs($prefix . 'laporan') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fa-solid fa-clipboard mr-3 text-lg"></i>
            <span class="font-medium">Laporan</span>
        </a>
        @endif
        @endauth
    </nav>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.querySelector('.main-content');

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
</script>