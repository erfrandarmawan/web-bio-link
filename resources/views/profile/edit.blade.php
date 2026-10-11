@extends('layouts.app')

@section('title', 'Edit Profil - ' . config('app.name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Profil</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Avatar -->
            <div class="mb-6 text-center">
                @if ($user->avatar_image)
                    <img src="{{ Storage::url($user->avatar_image) }}" alt="Avatar"
                        class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-gray-200">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto bg-blue-600 flex items-center justify-center border-4 border-gray-200">
                        <span class="text-3xl text-white font-bold">{{ substr($user->website_name, 0, 2) }}</span>
                    </div>
                @endif
                <label for="avatar_image" class="mt-3 inline-block text-sm text-blue-600 hover:text-blue-800 cursor-pointer">
                    Ganti Foto
                </label>
                <input type="file" name="avatar_image" id="avatar_image" accept="image/jpeg,image/png,image/webp" class="hidden">
                @error('avatar_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (readonly) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
            </div>

            <!-- Username (readonly) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" value="{{ $user->username }}" disabled
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah.</p>
            </div>

            <!-- Website Name -->
            <div class="mb-6">
                <label for="website_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
                <input type="text" name="website_name" id="website_name" value="{{ old('website_name', $user->website_name) }}" required maxlength="50"
                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); document.getElementById('wname-count').textContent = this.value.length"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('website_name') border-red-500 @enderror">
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Hanya huruf, angka, dan spasi.</span>
                    <span class="text-xs text-gray-400"><span id="wname-count">{{ strlen(old('website_name', $user->website_name)) }}</span>/50</span>
                </div>
                @error('website_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">
                Perbarui Profil
            </button>
        </form>
    </div>

    <!-- Preview Link -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Halaman Publik Anda</h2>
        <p class="text-sm text-gray-600 mb-4">Bagikan tautan ini di profil media sosial Anda.</p>
        <a href="{{ route('user.link', $user->username) }}" target="_blank"
            class="text-blue-600 hover:text-blue-800 text-sm font-medium break-all">
            {{ route('user.link', $user->username) }}
        </a>
    </div>
</div>
@endsection