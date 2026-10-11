<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->website_name }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-liquid min-h-screen antialiased">
    <!-- Floating blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="blob w-96 h-96 bg-brand-300 animate-blob" style="top: -80px; left: -60px;"></div>
        <div class="blob w-80 h-80 bg-sky-200 animate-blob-slow" style="top: 40%; right: -100px;"></div>
        <div class="blob w-72 h-72 bg-purple-200 animate-blob" style="bottom: -80px; left: 25%;"></div>
    </div>

    <div class="max-w-md mx-auto px-4 py-12">
        <!-- Profile Section -->
        <div class="glass-card rounded-3xl p-8 text-center mb-6">
            @if ($user->avatar_image)
                <img src="{{ Storage::url($user->avatar_image) }}" alt="{{ $user->website_name }}"
                    class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-white shadow-xl">
            @else
                <div class="w-28 h-28 rounded-full mx-auto bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center border-4 border-white shadow-xl">
                    <span class="text-4xl text-white font-bold">{{ substr($user->website_name, 0, 2) }}</span>
                </div>
            @endif
            <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $user->website_name }}</h1>
            <p class="text-gray-500 text-sm">@<span id="username">{{ $user->username }}</span></p>
        </div>

        <!-- Sort & Search -->
        <div class="mb-6 space-y-3">
            <div class="flex gap-2">
                <select id="sort-select" class="flex-1 px-4 py-2.5 glass-input rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    <option value="latest" selected>Terbaru</option>
                    <option value="alphabet">Abjad</option>
                    <option value="oldest">Terlama</option>
                </select>
                <input type="text" id="search-input" placeholder="Cari Link..."
                    class="flex-1 px-4 py-2.5 glass-input rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent placeholder-gray-400">
            </div>
        </div>

        <!-- Links List -->
        <div id="links-container" class="space-y-3">
            @forelse ($links as $link)
                <div class="link-item glass-card rounded-2xl hover:bg-white/60 hover:shadow-lg hover:shadow-brand-500/10 transition"
                     data-title="{{ $link->title }}"
                     data-created="{{ $link->created_at }}">
                    <button type="button"
                            onclick="confirmLink('{{ $link->id }}', '{{ $link->url }}', '{{ addslashes($link->title) }}')"
                            class="w-full text-left px-5 py-4 flex items-center justify-between gap-3">
                        <span class="font-semibold text-gray-900">{{ $link->title }}</span>
                        <span class="w-9 h-9 shrink-0 rounded-xl bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-white shadow-md shadow-brand-500/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </span>
                    </button>
                </div>
            @empty
                <div class="glass-card rounded-2xl p-8 text-center">
                    <p class="text-gray-500">Belum ada Link.</p>
                </div>
            @endforelse
        </div>

        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="fixed inset-0 bg-brand-900/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
            <div class="glass-card rounded-3xl p-6 max-w-sm mx-4 shadow-2xl shadow-brand-500/20">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center shadow-md shadow-amber-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Tinggalkan halaman ini?</h3>
                        <p class="text-gray-500 text-sm mt-0.5">Anda akan membuka: <span id="modal-link-title" class="font-semibold text-white"></span></p>
                    </div>
                </div>

                <!-- URL — bold & clear -->
                <div class="rounded-xl bg-gradient-to-r from-brand-500 to-brand-400 p-4 mb-4 shadow-lg shadow-brand-500/25">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-brand-100 mb-1">Alamat URL Tujuan</p>
                    <p class="text-white font-bold text-sm break-all leading-snug" id="modal-link-url"></p>
                </div>

                <!-- User-generated content disclaimer -->
                <div class="rounded-xl bg-amber-100/80 border border-amber-300/60 px-4 py-3 mb-4">
                    <p class="text-xs text-amber-800 leading-relaxed">
                        Link ini dibuat oleh <span class="font-bold">{{ $user->website_name }}</span>.
                        Pastikan kamu <span class="font-bold">mengetahui dan memahami</span> URL yang akan kamu kunjungi sebelum melanjutkan.
                    </p>
                </div>

                <!-- Mandatory acknowledgment -->
                <label class="flex items-start gap-2.5 mb-5 cursor-pointer">
                    <input type="checkbox" id="confirm-acknowledge" onchange="updateConfirmButton()"
                        class="mt-0.5 w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-400">
                    <span class="text-sm text-gray-700">
                        Saya mengerti dan memahami alamat URL di atas, dan saya bersedia membukanya atas tanggung jawab saya sendiri.
                    </span>
                </label>

                <div class="flex gap-3 justify-end">
                    <button onclick="closeModal()" class="px-4 py-2.5 text-gray-700 glass-input rounded-xl hover:bg-white/70 text-sm font-medium transition">
                        Batal
                    </button>
                    <a id="confirm-link" href="#" target="_blank"
                        class="px-5 py-2.5 bg-gradient-to-r from-brand-500 to-brand-400 text-white rounded-xl hover:from-brand-600 hover:to-brand-500 text-sm font-semibold shadow-lg shadow-brand-500/30 transition opacity-40 pointer-events-none"
                        onclick="closeModal()">
                        Buka Link
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pendingUrl = '';

        function confirmLink(linkId, url, title) {
            pendingUrl = url;
            document.getElementById('modal-link-title').textContent = title;
            document.getElementById('modal-link-url').textContent = url;
            document.getElementById('confirm-link').href = url;
            document.getElementById('confirm-acknowledge').checked = false;
            updateConfirmButton();
            document.getElementById('confirm-modal').classList.remove('hidden');

            // Record click via fetch
            fetch('/links/' + linkId + '/click', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            });
        }

        function updateConfirmButton() {
            const acknowledged = document.getElementById('confirm-acknowledge').checked;
            const btn = document.getElementById('confirm-link');
            if (acknowledged) {
                btn.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-40', 'pointer-events-none');
            }
        }

        function closeModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            document.getElementById('confirm-acknowledge').checked = false;
            updateConfirmButton();
            pendingUrl = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        // Close modal on outside click
        document.getElementById('confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Sort functionality
        document.getElementById('sort-select').addEventListener('change', function() {
            sortLinks(this.value);
        });

        function sortLinks(sortBy) {
            const container = document.getElementById('links-container');
            const items = Array.from(container.querySelectorAll('.link-item'));

            if (items.length === 0) return;

            const sorted = items.sort((a, b) => {
                const titleA = a.dataset.title.toLowerCase();
                const titleB = b.dataset.title.toLowerCase();
                const dateA = new Date(a.dataset.created);
                const dateB = new Date(b.dataset.created);

                switch (sortBy) {
                    case 'alphabet':
                        return titleA.localeCompare(titleB);
                    case 'latest':
                        return dateB - dateA;
                    case 'oldest':
                        return dateA - dateB;
                    default:
                        return 0;
                }
            });

            // Re-append sorted items
            sorted.forEach(item => container.appendChild(item));
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('.link-item');

            items.forEach(item => {
                const title = item.dataset.title.toLowerCase();
                item.style.display = title.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html>