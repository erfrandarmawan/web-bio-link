@extends('layouts.app')

@section('title', (isset($link) ? 'Ubah' : 'Buat') . ' Tautan - ' . config('app.name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ isset($link) ? 'Ubah Tautan' : 'Buat Tautan' }}</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ isset($link) ? route('links.update', $link) : route('links.store') }}">
            @csrf
            @if (isset($link))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title', $link->title ?? '') }}" required maxlength="100"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                    oninput="document.getElementById('title-count').textContent = this.value.length">
                <div class="flex justify-end mt-1">
                    <span class="text-xs text-gray-400"><span id="title-count">{{ strlen(old('title', $link->title ?? '')) }}</span>/100</span>
                </div>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="url" name="url" id="url" value="{{ old('url', $link->url ?? '') }}" required maxlength="500"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('url') border-red-500 @enderror"
                    placeholder="https://example.com"
                    oninput="document.getElementById('url-count').textContent = this.value.length">
                <div class="flex justify-end mt-1">
                    <span class="text-xs text-gray-400"><span id="url-count">{{ strlen(old('url', $link->url ?? '')) }}</span>/500</span>
                </div>
                @error('url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    {{ isset($link) ? 'Perbarui' : 'Buat' }}
                </button>
                <a href="{{ route('links.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection