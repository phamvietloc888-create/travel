@php
    use App\Models\ChatThread;

    $adminChatAttentionCount = ChatThread::adminAttentionCount();
@endphp

<header class="sticky top-0 z-20 border-b border-white/60 bg-white/70 px-4 py-3 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/70 sm:px-6">
    <div class="flex items-center gap-3">
        <button class="btn-ghost md:hidden" @click="Alpine.store('ui').toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="hidden min-w-0 flex-1 sm:block">
            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $title ?? 'Trang quản trị' }}</p>
            <p class="truncate text-xs text-slate-500 dark:text-slate-400">Không gian quản trị Travel</p>
        </div>

        <form method="GET" action="{{ route('admin.search') }}" class="relative hidden max-w-md flex-1 md:block">
            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Tìm tour, booking, điểm đến..."
                class="input pl-10 pr-24"
            />
            <span class="absolute left-3 top-2.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.2-4.2m0 0A7.3 7.3 0 105.6 5.6a7.3 7.3 0 0011.2 11.2z" />
                </svg>
            </span>
            <button type="submit" class="absolute right-2 top-1.5 rounded-xl bg-sky-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-sky-600">
                Tìm
            </button>
        </form>

        <div class="ml-auto flex items-center gap-2">
            <a href="{{ route('admin.chats.index') }}" class="relative btn-ghost" title="Tin nhan ho tro">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 14a2 2 0 01-2 2H8l-5 4V6a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>
                @if($adminChatAttentionCount > 0)
                    <span id="adminChatBadge" class="absolute -right-1 -top-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white">
                        {{ $adminChatAttentionCount > 9 ? '9+' : $adminChatAttentionCount }}
                    </span>
                @endif
            </a>
            <button class="btn-ghost" @click="Alpine.store('ui').toggleTheme()" title="Đổi giao diện">
                <svg x-show="!Alpine.store('ui').dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m13.95-6.95-1.42 1.42M7.47 16.53l-1.42 1.42m11.9 0-1.42-1.42M7.47 7.47 6.05 6.05M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg x-show="Alpine.store('ui').dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 12.8A9 9 0 1111.2 3a7 7 0 109.8 9.8z" />
                </svg>
            </button>

            <div class="relative" x-data="{ open: false }">
                <button class="rounded-2xl border border-slate-200 bg-white px-2 py-1.5 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800" @click="open = !open">
                    <div class="flex items-center gap-2">
                        <div class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-xs font-black text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                        </div>
                        <div class="hidden text-left leading-tight md:block">
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Quản trị viên</p>
                        </div>
                    </div>
                </button>

                <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-56 rounded-2xl border border-slate-200 bg-white p-2 shadow-2xl shadow-slate-300/50 dark:border-slate-700 dark:bg-slate-900 dark:shadow-none"
                >
                    <p class="px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-400">Tài khoản</p>
                    <a href="#" class="mt-1 flex items-center gap-2 rounded-xl px-2 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        Hồ sơ (sắp có)
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mt-1 flex w-full items-center gap-2 rounded-xl px-2 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const badge = document.getElementById('adminChatBadge');

        const ensureBadge = (count) => {
            if (!badge && count <= 0) {
                return;
            }
        };

        window.setInterval(async () => {
            try {
                const response = await fetch(@json(route('admin.chats.attention-count')), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    return;
                }

                const payload = await response.json();
                const count = Number(payload.attention_count || 0);
                const nextLabel = count > 9 ? '9+' : String(count);
                let currentBadge = document.getElementById('adminChatBadge');

                if (count <= 0) {
                    currentBadge?.remove();
                    return;
                }

                if (!currentBadge) {
                    const chatLink = document.querySelector('a[title="Tin nhan ho tro"]');

                    if (!chatLink) {
                        return;
                    }

                    currentBadge = document.createElement('span');
                    currentBadge.id = 'adminChatBadge';
                    currentBadge.className = 'absolute -right-1 -top-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white';
                    chatLink.appendChild(currentBadge);
                }

                currentBadge.textContent = nextLabel;
            } catch (error) {
                console.warn('Admin attention polling failed', error);
            }
        }, 12000);
    });
</script>
