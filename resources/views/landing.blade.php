@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
            Bio Link Anda dalam Satu Halaman
        </h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
            Buat halaman sederhana dan menarik untuk membagikan semua Link Anda ke dunia.
            Cocok untuk profil media sosial, bisnis, dan kreator.
        </p>

        <div class="mt-8 flex justify-center gap-4">
            @guest
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-700">
                    Mulai Sekarang
                </a>
                <a href="{{ route('login') }}" class="bg-white text-gray-700 px-8 py-3 rounded-lg text-lg font-medium border border-gray-300 hover:bg-gray-50">
                    Masuk
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-blue-700">
                    Buka Dasbor
                </a>
            @endguest
        </div>
    </div>

    <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">🔗</div>
            <h3 class="text-lg font-semibold text-gray-900">Bagikan Link</h3>
            <p class="mt-2 text-gray-600 text-sm">Buat halaman personal dengan semua Link penting Anda dalam satu tempat.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">📊</div>
            <h3 class="text-lg font-semibold text-gray-900">Pantau Analitik</h3>
            <p class="mt-2 text-gray-600 text-sm">Pantau kinerja Link Anda dengan analitik klik yang detail.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">🎨</div>
            <h3 class="text-lg font-semibold text-gray-900">Sesuaikan Profil</h3>
            <p class="mt-2 text-gray-600 text-sm">Tambahkan foto dan beri merek pada halaman Anda agar semakin unik.</p>
        </div>
    </div>
</div>
@endsection