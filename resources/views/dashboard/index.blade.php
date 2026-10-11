@extends('layouts.app')

@section('title', 'Dasbor - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dasbor</h1>

    <!-- Filter Periode -->
    <div class="mb-6">
        <div class="flex gap-2 flex-wrap">
            @foreach (['today' => 'Hari Ini', '7days' => '7 Hari Terakhir', '30days' => '30 Hari Terakhir', 'month' => 'Bulan Ini'] as $key => $label)
                <a href="{{ route('dashboard', ['period' => $key]) }}"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $period === $key ? 'bg-gradient-to-r from-brand-500 to-brand-400 text-white shadow-lg shadow-brand-500/30' : 'glass-input text-gray-700 hover:bg-white/70' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="glass-card rounded-3xl p-6 flex items-center gap-5">
            <div class="w-14 h-14 shrink-0 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Klik</p>
                <p class="text-4xl font-bold text-gray-900">{{ $totalClicks }}</p>
            </div>
        </div>
        <div class="glass-card rounded-3xl p-6 flex items-center gap-5">
            <div class="w-14 h-14 shrink-0 rounded-2xl bg-gradient-to-br from-sky-400 to-brand-500 flex items-center justify-center shadow-lg shadow-sky-500/30">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0l2 2a4 4 0 01-5.656 5.656l-3.172-3.172M10.172 13.828a4 4 0 01-5.656 0l-2-2a4 4 0 015.656-5.656l3.172 3.172"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Link</p>
                <p class="text-4xl font-bold text-gray-900">{{ $totalLinks }}</p>
            </div>
        </div>
    </div>

    <!-- Clicks Per Day Chart -->
    <div class="glass-card rounded-3xl p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Klik Per Hari</h2>
        @if ($clicksPerDay->isNotEmpty())
            <div class="space-y-2.5">
                @foreach ($clicksPerDay as $day)
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600 w-32">{{ \Carbon\Carbon::parse($day->date)->format('d M, Y') }}</span>
                        <div class="flex-1 bg-white/50 rounded-full h-4 overflow-hidden border border-white/60">
                            <div class="bg-gradient-to-r from-brand-400 to-brand-500 h-4 rounded-full" style="width: {{ ($day->total / $clicksPerDay->max('total')) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-900 w-12 text-right">{{ $day->total }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada klik di periode ini.</p>
        @endif
    </div>

    <!-- Link Performance Table -->
    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/60">
            <h2 class="text-lg font-bold text-gray-900">Kinerja Link</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/30">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Klik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/50">
                    @forelse ($linksWithClicks as $link)
                        <tr class="hover:bg-white/40 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $link->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $link->url }}</td>
                            <td class="px-6 py-4 text-sm text-right font-bold text-brand-600">{{ $link->analytics_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada Link. <a href="{{ route('links.create') }}" class="text-brand-600 hover:text-brand-700 font-medium">Buat Link</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection