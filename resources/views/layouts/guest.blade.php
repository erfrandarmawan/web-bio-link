<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-liquid text-gray-900 antialiased min-h-screen">
    <!-- Floating blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="blob w-96 h-96 bg-brand-300 animate-blob" style="top: -80px; left: -60px;"></div>
        <div class="blob w-80 h-80 bg-sky-200 animate-blob-slow" style="top: 40%; right: -100px;"></div>
        <div class="blob w-72 h-72 bg-purple-200 animate-blob" style="bottom: -80px; left: 25%;"></div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-2xl font-bold text-brand-600">
                    <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0l2 2a4 4 0 01-5.656 5.656l-3.172-3.172M10.172 13.828a4 4 0 01-5.656 0l-2-2a4 4 0 015.656-5.656l3.172 3.172"/>
                        </svg>
                    </span>
                    {{ config('app.name') }}
                </a>
            </div>

            @if (session('status'))
                <div class="glass-card rounded-xl px-4 py-3 text-emerald-700 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>