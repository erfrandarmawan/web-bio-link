@extends('layouts.app')

@section('title', 'Edit Profil - ' . config('app.name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Profil</h1>

    <div class="glass-card rounded-3xl p-8 mb-6">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Avatar -->
            <div class="mb-8 text-center">
                <img id="avatar-preview"
                    src="{{ $user->avatar_image ? Storage::url($user->avatar_image) : '' }}"
                    alt="Preview Avatar"
                    class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-white shadow-xl {{ $user->avatar_image ? '' : 'hidden' }}">
                <div id="avatar-placeholder" class="w-28 h-28 rounded-full mx-auto bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center border-4 border-white shadow-xl {{ $user->avatar_image ? 'hidden' : '' }}">
                    <span class="text-4xl text-white font-bold">{{ substr($user->website_name, 0, 2) }}</span>
                </div>
                <label for="avatar_image" class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-brand-600 hover:text-brand-700 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Ganti Foto
                </label>
                <input type="file" name="avatar_image" id="avatar_image" accept="image/jpeg,image/png,image/webp" class="hidden"
                    onchange="previewAvatar(this)">
                <p id="avatar-file-name" class="text-xs text-gray-500 mt-1"></p>
                @error('avatar_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (readonly) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                    class="w-full px-4 py-2.5 glass-input rounded-xl bg-white/30 text-gray-500">
            </div>

            <!-- Username (readonly) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" value="{{ $user->username }}" disabled
                    class="w-full px-4 py-2.5 glass-input rounded-xl bg-white/30 text-gray-500">
                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah.</p>
            </div>

            <!-- Website Name -->
            <div class="mb-6">
                <label for="website_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
                <input type="text" name="website_name" id="website_name" value="{{ old('website_name', $user->website_name) }}" required maxlength="50"
                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); document.getElementById('wname-count').textContent = this.value.length"
                    class="w-full px-4 py-2.5 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400 @error('website_name') !border-red-400 @enderror">
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-500">Hanya huruf, angka, dan spasi.</span>
                    <span class="text-xs text-gray-400"><span id="wname-count">{{ strlen(old('website_name', $user->website_name)) }}</span>/50</span>
                </div>
                @error('website_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-brand-500 to-brand-400 text-white py-2.5 px-4 rounded-xl hover:from-brand-600 hover:to-brand-500 font-semibold shadow-lg shadow-brand-500/30 transition">
                Perbarui Profil
            </button>
        </form>
    </div>

    <!-- Preview Link -->
    <div class="glass-card rounded-3xl p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Halaman Publik Anda</h2>
        <p class="text-sm text-gray-600 mb-4">Bagikan Link ini di profil media sosial Anda.</p>
        <a href="{{ route('user.link', $user->username) }}" target="_blank"
            class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-700 text-sm font-semibold break-all">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0l2 2a4 4 0 01-5.656 5.656l-3.172-3.172M10.172 13.828a4 4 0 01-5.656 0l-2-2a4 4 0 015.656-5.656l3.172 3.172"/>
            </svg>
            {{ route('user.link', $user->username) }}
        </a>
    </div>
</div>

<script>
function previewAvatar(input) {
    const preview = document.getElementById('avatar-preview');
    const placeholder = document.getElementById('avatar-placeholder');
    const fileName = document.getElementById('avatar-file-name');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            fileName.textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection