@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
    <div class="text-center">
        <div class="glass-card rounded-3xl px-6 py-10 sm:px-12 sm:py-14 inline-block w-full max-w-4xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 glass-input rounded-full text-sm font-medium text-brand-600">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-brand-400 to-brand-500 animate-pulse"></span>
                Powerful Bio Link Platform
            </span>
            <h1 class="mt-6 text-4xl font-bold text-gray-900 sm:text-6xl tracking-tight">
                Bio Link Anda dalam
                <span class="bg-gradient-to-r from-brand-500 to-brand-300 bg-clip-text text-transparent">Satu Halaman</span>
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
                Buat halaman sederhana dan menarik untuk membagikan semua Link Anda ke dunia.
                Cocok untuk profil media sosial, bisnis, dan kreator.
            </p>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-brand-500 to-brand-400 text-white px-8 py-3.5 rounded-2xl text-lg font-semibold hover:from-brand-600 hover:to-brand-500 shadow-xl shadow-brand-500/30 transition">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="glass-card text-gray-700 px-8 py-3.5 rounded-2xl text-lg font-semibold hover:bg-white/70 transition">
                        Masuk
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-brand-500 to-brand-400 text-white px-8 py-3.5 rounded-2xl text-lg font-semibold hover:from-brand-600 hover:to-brand-500 shadow-xl shadow-brand-500/30 transition">
                        Buka Dasbor
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="glass-card rounded-3xl p-8 text-center hover:bg-white/60 transition">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-2xl shadow-lg shadow-brand-500/30">
                🔗
            </div>
            <h3 class="mt-5 text-xl font-bold text-gray-900">Bagikan Link</h3>
            <p class="mt-2 text-gray-600 text-sm">Buat halaman personal dengan semua Link penting Anda dalam satu tempat.</p>
        </div>
        <div class="glass-card rounded-3xl p-8 text-center hover:bg-white/60 transition">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-sky-400 to-brand-500 flex items-center justify-center text-2xl shadow-lg shadow-sky-500/30">
                📊
            </div>
            <h3 class="mt-5 text-xl font-bold text-gray-900">Pantau Analitik</h3>
            <p class="mt-2 text-gray-600 text-sm">Pantau kinerja Link Anda dengan analitik klik yang detail.</p>
        </div>
        <div class="glass-card rounded-3xl p-8 text-center hover:bg-white/60 transition">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-brand-500 to-purple-400 flex items-center justify-center text-2xl shadow-lg shadow-purple-500/30">
                🎨
            </div>
            <h3 class="mt-5 text-xl font-bold text-gray-900">Sesuaikan Profil</h3>
            <p class="mt-2 text-gray-600 text-sm">Tambahkan foto dan beri merek pada halaman Anda agar semakin unik.</p>
        </div>
    </div>
</div>
@endsection