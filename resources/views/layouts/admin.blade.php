<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        body { color: #334155; }
        aside { 
            background: #ffffff !important; 
            border-right: 1px solid #e2e8f0 !important; 
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important; 
        }
        
        /* Sidebar Brand Gradient yang lebih modern */
        .sidebar-brand { 
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important; 
            border-bottom: none !important; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom Scrollbar untuk Sidebar agar rapi */
        nav::-webkit-scrollbar { width: 5px; }
        nav::-webkit-scrollbar-track { background: transparent; }
        nav::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        nav::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Animasi Main Menu */
        nav ul li a, nav ul li button { 
            transition: all 0.2s ease-in-out !important; 
            margin-bottom: 4px; 
            font-weight: 500; 
            position: relative;
        }
        nav ul li a:hover, nav ul li button:hover { 
            color: #4f46e5 !important; 
            background-color: #f0f4ff !important; 
        }
        
        /* Indikator Menu Utama Aktif (Garis kiri) */
        .nav-active { 
            background-color: #f0f4ff !important; 
            color: #4f46e5 !important; 
            font-weight: 600; 
        }
        .nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10%;
            height: 80%;
            width: 4px;
            background-color: #4f46e5;
            border-radius: 0 4px 4px 0;
        }

        /* Styling & Animasi Submenu (Panah Dropdown) */
        .submenu-item { transition: all 0.2s ease; }
        .submenu-item svg { transition: transform 0.2s ease, color 0.2s ease; }
        
        /* Efek saat submenu di-hover */
        .submenu-item:hover { background-color: #eef2ff !important; color: #4f46e5 !important; }
        .submenu-item:hover svg { transform: translateX(4px); color: #4f46e5; }
        
        /* Efek saat submenu aktif */
        .submenu-active { background-color: #eef2ff !important; color: #4f46e5 !important; font-weight: 600; }
        .submenu-active svg { transform: translateX(4px); color: #4f46e5; }
        
        /* Header Glassmorphism */
        header { 
            backdrop-filter: blur(12px); 
            background-color: rgba(255, 255, 255, 0.85) !important; 
            position: sticky; 
            top: 0; 
            z-index: 40; 
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    
    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">
        
        <aside class="flex flex-col z-50 bg-white shadow-lg overflow-hidden"
            :class="sidebarOpen ? 'w-64' : 'w-20'">
            
            <div class="sidebar-brand flex items-center justify-center h-16 shrink-0 transition-all duration-300">
                <span class="font-bold text-white tracking-widest uppercase" :class="sidebarOpen ? 'text-xl' : 'text-sm'">MENU</span>
            </div>

            <nav class="mt-6 px-4 flex-1 overflow-y-auto overflow-x-hidden pb-4">
                <ul class="space-y-1">
                    
                    @if(auth()->user()->role == 'admin_gudang' || auth()->user()->role == 'superadmin')
                        
                        <li x-show="sidebarOpen" class="px-3 mt-2 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">
                            Warehouse System
                        </li>

                        <li>
                            <a href="{{ route('jenis.index') }}" 
                            class="flex items-center p-3 rounded-xl group {{ request()->routeIs('jenis.*') ? 'nav-active' : 'text-gray-600' }}"
                            :class="!sidebarOpen ? 'justify-center' : ''">
                                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('jenis.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span x-show="sidebarOpen" x-transition.opacity class="ms-3 whitespace-nowrap">Support</span>
                            </a>
                        </li>

                        <li x-data="{ open: {{ request()->routeIs('barang.*') ? 'true' : 'false' }} }">
                            <button @click="sidebarOpen ? open = !open : sidebarOpen = true" type="button" 
                                class="flex items-center w-full p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('barang.*') ? 'nav-active' : 'text-gray-600' }}"
                                :class="!sidebarOpen ? 'justify-center' : ''">
                                
                                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('barang.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                
                                <span x-show="sidebarOpen" x-transition.opacity class="ms-3 flex-1 text-left whitespace-nowrap">Data Barang</span>
                                
                                <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <ul x-show="open && sidebarOpen" x-transition class="py-2 space-y-1">
                                <li>
                                    <a href="{{ route('barang.index') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('barang.index') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('barang.index') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Stok Barang (Log)
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('barang.createOrder') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('barang.createOrder') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('barang.createOrder') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Input Data Order
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('barang.createPacking') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('barang.createPacking') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('barang.createPacking') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Input Data Packing
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'admin_keuangan' || auth()->user()->role == 'superadmin')
                        
                        <li x-show="sidebarOpen" class="px-3 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">
                            Operating Expenses System
                        </li>

                        <li x-data="{ open: {{ request()->routeIs('admin.keuangan.*') ? 'true' : 'false' }} }">
                            <button @click="sidebarOpen ? open = !open : sidebarOpen = true" type="button" 
                                class="flex items-center w-full p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('admin.keuangan.*') ? 'nav-active' : 'text-gray-600' }}"
                                :class="!sidebarOpen ? 'justify-center' : ''">
                                
                                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('admin.keuangan.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                
                                <span x-show="sidebarOpen" x-transition.opacity class="ms-3 flex-1 text-left whitespace-nowrap">Keuangan Delivery</span>
                                
                                <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <ul x-show="open && sidebarOpen" x-transition class="py-2 space-y-1">
                                <li>
                                    <a href="{{ route('admin.keuangan.index') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('admin.keuangan.index') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('admin.keuangan.index') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Dashboard Keuangan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.keuangan.pencairan') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('admin.keuangan.pencairan') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('admin.keuangan.pencairan') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Pencairan Saldo
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.keuangan.topup') }}" 
                                        class="submenu-item flex items-center w-full p-2 pl-9 rounded-lg text-sm {{ request()->routeIs('admin.keuangan.topup') ? 'submenu-active' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-2 shrink-0 {{ request()->routeIs('admin.keuangan.topup') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Top Up Saldo
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </nav>
            
            <div class="user-info-box p-4 shrink-0">
                <div class="flex items-center p-2 bg-white rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md"
                    :class="!sidebarOpen ? 'justify-center' : ''">
                    <div class="w-8 h-8 shrink-0 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity class="ml-3 overflow-hidden">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider">{{ str_replace('_', ' ', Auth::user()->role ?? 'Admin') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
                
                {{-- KIRI: Burger + Judul Halaman --}}
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 mr-6 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-indigo-600 focus:outline-none transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <h1 class="hidden lg:block text-sm font-semibold text-gray-400 uppercase tracking-widest">
                        @if(request()->routeIs('jenis.*')) Manajemen Jenis
                        @elseif(request()->routeIs('barang.*')) Manajemen Barang
                        @elseif(request()->routeIs('admin.keuangan.*')) Panel Keuangan
                        @else Gudang Panel
                        @endif
                    </h1>
                </div>

                {{-- KANAN: Profil Dropdown --}}
                <div x-data="{ profileOpen: false }" class="relative">
                    <button @click="profileOpen = !profileOpen" class="flex items-center space-x-3 px-3 py-1.5 transition focus:outline-none group">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-gray-700 group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name ?? 'User' }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="profileOpen" x-transition @click.away="profileOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md z-50 border border-gray-200" style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-[#4a5568] hover:bg-gray-50 transition border-b border-dashed border-gray-200">
                            <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-[#4a5568] hover:bg-gray-50 hover:text-red-600 transition group">
                                <svg class="w-5 h-5 mr-3 text-gray-700 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
                {{ $slot }}
            </main>
        </div>

        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden" style="display: none;"></div>
    </div>
</body>
</html>