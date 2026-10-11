<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->website_name }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <div class="max-w-md mx-auto px-4 py-12">
        <!-- Profile Section -->
        <div class="text-center mb-8">
            @if ($user->avatar_image)
                <img src="{{ Storage::url($user->avatar_image) }}" alt="{{ $user->website_name }}"
                    class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-white shadow-lg">
            @else
                <div class="w-24 h-24 rounded-full mx-auto bg-blue-600 flex items-center justify-center border-4 border-white shadow-lg">
                    <span class="text-3xl text-white font-bold">{{ substr($user->website_name, 0, 2) }}</span>
                </div>
            @endif
            <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $user->website_name }}</h1>
            <p class="text-gray-500 text-sm">@<span id="username">{{ $user->username }}</span></p>
        </div>

        <!-- Sort & Search -->
        <div class="mb-6 space-y-3">
            <div class="flex gap-2">
                <select id="sort-select" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="latest" selected>Terbaru</option>
                    <option value="alphabet">Abjad</option>
                    <option value="oldest">Terlama</option>
                </select>
                <input type="text" id="search-input" placeholder="Cari Link..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Links List -->
        <div id="links-container" class="space-y-3">
            @forelse ($links as $link)
                <div class="link-item bg-white rounded-lg shadow hover:shadow-md transition-shadow"
                     data-title="{{ $link->title }}"
                     data-created="{{ $link->created_at }}">
                    <button type="button"
                            onclick="confirmLink('{{ $link->id }}', '{{ $link->url }}', '{{ addslashes($link->title) }}')"
                            class="w-full text-left px-4 py-3 flex items-center justify-between">
                        <span class="font-medium text-gray-900">{{ $link->title }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </button>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Belum ada Link.</p>
            @endforelse
        </div>

        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tinggalkan halaman ini?</h3>
                <p class="text-gray-600 text-sm mb-1">
                    Anda akan membuka: <span id="modal-link-title" class="font-medium text-gray-900"></span>
                </p>
                <p class="text-gray-400 text-xs mb-4 break-all" id="modal-link-url"></p>
                <div class="flex gap-3 justify-end">
                    <button onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm font-medium">
                        Batal
                    </button>
                    <a id="confirm-link" href="#" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium"
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

        function closeModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
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