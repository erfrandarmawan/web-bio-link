@extends('layouts.app')

@section('title', 'Link - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Link Saya</h1>
        <a href="{{ route('links.create') }}"
            class="bg-gradient-to-r from-brand-500 to-brand-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-brand-600 hover:to-brand-500 shadow-lg shadow-brand-500/30 transition">
            + Tambah Link
        </a>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/30">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/50">
                    @forelse ($links as $link)
                        <tr class="hover:bg-white/40 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $link->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $link->url }}</td>
                            <td class="px-6 py-4 text-sm text-right space-x-3">
                                <a href="{{ route('links.edit', $link) }}"
                                    class="text-brand-600 hover:text-brand-700 font-semibold">Ubah</a>
                                <form method="POST" action="{{ route('links.destroy', $link) }}" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Link ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                Belum ada Link.
                                <a href="{{ route('links.create') }}" class="text-brand-600 hover:text-brand-700 font-medium">Buat Link pertama Anda</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection