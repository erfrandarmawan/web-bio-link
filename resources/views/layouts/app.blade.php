<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-liquid text-gray-900 antialiased">
    <!-- Floating blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="blob w-96 h-96 bg-brand-300 animate-blob" style="top: -80px; left: -60px;"></div>
        <div class="blob w-80 h-80 bg-sky-200 animate-blob-slow" style="top: 40%; right: -100px;"></div>
        <div class="blob w-72 h-72 bg-purple-200 animate-blob" style="bottom: -80px; left: 25%;"></div>
    </div>

    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-brand-600 flex items-center gap-2 whitespace-nowrap">
                            <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0l2 2a4 4 0 01-5.656 5.656l-3.172-3.172M10.172 13.828a4 4 0 01-5.656 0l-2-2a4 4 0 015.656-5.656l3.172 3.172"/>
                                </svg>
                            </span>
                            <span class="hidden sm:inline">{{ config('app.name') }}</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-1 sm:gap-2 flex-wrap sm:flex-nowrap">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-brand-600 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Dasbor</a>
                            <a href="{{ route('links.index') }}" class="text-gray-700 hover:text-brand-600 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Link</a>
                            <a href="{{ route('user.link', auth()->user()->username) }}" target="_blank"
                                class="text-gray-700 hover:text-brand-600 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Halaman Saya</a>
                            <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-brand-600 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-red-500 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-brand-600 hover:bg-white/40 px-2 sm:px-3 py-2 text-sm font-medium rounded-xl transition whitespace-nowrap">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-brand-500 to-brand-400 text-white hover:from-brand-600 hover:to-brand-500 px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-brand-500/30 transition whitespace-nowrap">Daftar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="mt-0">
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="glass-card rounded-xl px-4 py-3 text-emerald-700" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>