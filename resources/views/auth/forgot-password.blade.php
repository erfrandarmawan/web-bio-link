@extends('layouts.guest')

@section('title', 'Lupa Password - ' . config('app.name'))

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-2">Lupa Password</h1>
    <p class="text-center text-gray-600 text-sm mb-6">Masukkan email Anda dan kami akan mengirimkan Link reset.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Kembali ke masuk</a>
    </p>
</div>
@endsection