@extends('layouts.app')

@section('title', 'Link - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Link Saya</h1>
        <a href="{{ route('links.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            + Tambah Link
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($links as $link)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $link->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $link->url }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <a href="{{ route('links.edit', $link) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium">Ubah</a>
                            <form method="POST" action="{{ route('links.destroy', $link) }}" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Link ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            Belum ada Link.
                            <a href="{{ route('links.create') }}" class="text-blue-600 hover:text-blue-800">Buat Link pertama Anda</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection