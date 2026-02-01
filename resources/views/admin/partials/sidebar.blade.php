<aside
    class="fixed inset-y-0 left-0 z-30 w-64 -translate-x-full border-r border-slate-200 bg-white/80 backdrop-blur transition-transform duration-300 dark:border-slate-800 dark:bg-slate-900/80 md:translate-x-0"
    :class="{'translate-x-0': Alpine.store('ui').sidebarOpen, '-translate-x-full': !Alpine.store('ui').sidebarOpen}"
>
    <div class="flex items-center justify-between px-4 py-4">
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-400 text-white font-bold shadow-lg shadow-sky-200/60">TR</span>
            <div>
                <p class="text-lg font-bold">Travel Admin</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage experiences</p>
            </div>
        </div>
        <button class="btn-ghost md:hidden" @click="Alpine.store('ui').toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="mt-4 space-y-1 px-3">
        @php
            $navItems = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12h18'],
                ['label' => 'Destinations', 'route' => 'admin.destinations.index', 'icon' => 'M4 6h16M4 12h16M4 18h10'],
                ['label' => 'Tours', 'route' => 'admin.tours.index', 'icon' => 'M5 8h14M5 16h14M9 4l-1 4m7-4 1 4'],
                ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'icon' => 'M6 6h12v12H6z'],
                ['label' => 'Promotions', 'route' => 'admin.promotions.index', 'icon' => 'M4 6h16M4 12h8M4 18h5'],
                ['label' => 'Reviews', 'route' => 'admin.reviews.index', 'icon' => 'M5 5h14M5 12h14M5 19h10'],
                ['label' => 'Chats', 'route' => 'admin.chats.index', 'icon' => 'M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z'],
                ['label' => 'Histories', 'route' => 'admin.histories.index', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Media', 'route' => 'admin.media.index', 'icon' => 'M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7l-4 2-4-2-4 2-4-2z'],
            ];
        @endphp
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold transition hover:bg-sky-50 hover:text-sky-600 dark:hover:bg-slate-800 {{ request()->routeIs($item['route'].'*') ? 'bg-sky-100 text-sky-700 dark:bg-slate-800 dark:text-sky-300' : 'text-slate-700 dark:text-slate-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
    <div class="mt-6 border-t border-slate-200 px-4 py-4 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">
        Tip: bật/tắt dark mode ở góc trên.
    </div>
</aside>
