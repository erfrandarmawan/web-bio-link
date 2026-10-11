@extends('layouts.guest')

@section('title', 'Daftar - ' . config('app.name'))

@section('content')
<div class="glass-card rounded-3xl p-8">
    <h1 class="text-2xl font-bold text-center mb-2 text-gray-900">Buat Akun Baru</h1>
    <p class="text-center text-sm text-gray-500 mb-6">Mulai bagikan Link Anda dalam hitungan menit</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400 @error('email') !border-red-400 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="website_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
            <input type="text" name="website_name" id="website_name" value="{{ old('website_name') }}" required maxlength="50"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); document.getElementById('wname-count').textContent = this.value.length"
                class="w-full px-4 py-2.5 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400 @error('website_name') !border-red-400 @enderror">
            <div class="flex justify-between mt-1">
                <span class="text-xs text-gray-500">Hanya huruf, angka, dan spasi.</span>
                <span class="text-xs text-gray-400"><span id="wname-count">0</span>/50</span>
            </div>
            @error('website_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                Username
                <span class="text-xs text-gray-500">(tidak dapat diubah nanti)</span>
            </label>
            <div class="flex items-center glass-input rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-brand-500 @error('username') !border-red-400 @enderror">
                <span class="px-3 py-2.5 text-gray-500 text-sm bg-white/40 border-r border-white/60">link.develobe.id/</span>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required maxlength="50"
                    oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9_-]/g, ''); document.getElementById('uname-count').textContent = this.value.length"
                    class="flex-1 px-3 py-2.5 focus:outline-none bg-transparent">
            </div>
            <div class="flex justify-between mt-1">
                <span class="text-xs text-gray-500">Hanya huruf kecil, angka, -, dan _.</span>
                <span class="text-xs text-gray-400"><span id="uname-count">0</span>/50</span>
            </div>
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" required minlength="8"
                    class="w-full px-4 py-2.5 pr-11 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400 @error('password') !border-red-400 @enderror">
                <button type="button" onclick="togglePassword('password', this)"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-brand-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2.5 pr-11 glass-input rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400">
                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-brand-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-brand-500 to-brand-400 text-white py-2.5 px-4 rounded-xl hover:from-brand-600 hover:to-brand-500 font-semibold shadow-lg shadow-brand-500/30 transition">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-brand-600 hover:text-brand-700 font-medium">Masuk</a>
    </p>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const isPassword = field.type === 'password';
    field.type = isPassword ? 'text' : 'password';
    btn.innerHTML = isPassword
        ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>'
        : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
}
</script>
@endsection