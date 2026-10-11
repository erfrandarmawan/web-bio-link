@extends('layouts.guest')

@section('title', 'Daftar - ' . config('app.name'))

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6">Daftar</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="website_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
            <input type="text" name="website_name" id="website_name" value="{{ old('website_name') }}" required maxlength="50"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('website_name') border-red-500 @enderror">
            @error('website_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                Username
                <span class="text-xs text-gray-500">(tidak dapat diubah nanti)</span>
            </label>
            <div class="flex items-center border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 @error('username') border-red-500 @enderror">
                <span class="px-3 py-2 text-gray-500 text-sm bg-gray-50 rounded-l-lg border-r border-gray-300">link.develobe.id/</span>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required maxlength="50"
                    class="flex-1 px-3 py-2 focus:outline-none bg-transparent">
            </div>
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Hanya huruf, angka, garis datar, dan garis bawah yang diperbolehkan.</p>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" required minlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">
            Daftar
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Masuk</a>
    </p>
</div>
@endsection