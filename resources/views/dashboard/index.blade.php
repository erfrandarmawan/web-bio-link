@extends('layouts.app')

@section('title', 'Dasbor - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Dasbor</h1>

    <!-- Filter Periode -->
    <div class="mb-6">
        <div class="flex gap-2 flex-wrap">
            @foreach (['today' => 'Hari Ini', '7days' => '7 Hari Terakhir', '30days' => '30 Hari Terakhir', 'month' => 'Bulan Ini'] as $key => $label)
                <a href="{{ route('dashboard', ['period' => $key]) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === $key ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-500">Total Klik</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalClicks }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-500">Total Tautan</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalLinks }}</p>
        </div>
    </div>

    <!-- Clicks Per Day Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Klik Per Hari</h2>
        @if ($clicksPerDay->isNotEmpty())
            <div class="space-y-2">
                @foreach ($clicksPerDay as $day)
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600 w-32">{{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-4">
                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ ($day->total / $clicksPerDay->max('total')) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 w-12 text-right">{{ $day->total }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada klik di periode ini.</p>
        @endif
    </div>

    <!-- Link Performance Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Kinerja Tautan</h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Klik</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($linksWithClicks as $link)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $link->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $link->url }}</td>
                        <td class="px-6 py-4 text-sm text-right font-semibold">{{ $link->analytics_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada tautan. <a href="{{ route('links.create') }}" class="text-blue-600 hover:text-blue-800">Buat tautan</a></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection