@extends('layouts.guest')

@section('title', 'Lupa Password - ' . config('app.name'))

@section('content')
<div class="glass-card rounded-3xl p-8">
    <h1 class="text-2xl font-bold text-center mb-2 text-gray-900">Lupa Password</h1>
    <p class="text-center text-gray-500 text-sm mb-6">Masukkan email Anda dan kami akan mengirimkan Link reset.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400 @error('email') !border-red-400 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-brand-500 to-brand-400 text-white py-2.5 px-4 rounded-xl hover:from-brand-600 hover:to-brand-500 font-semibold shadow-lg shadow-brand-500/30 transition">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-brand-600 hover:text-brand-700 font-medium">Kembali ke masuk</a>
    </p>
</div>
@endsection