@php
    use App\Models\ChatThread;

    $adminChatAttentionCount = ChatThread::adminAttentionCount();
@endphp

<aside
    class="fixed inset-y-3 left-3 z-30 w-72 -translate-x-[120%] rounded-3xl border border-white/70 bg-white/80 p-4 shadow-2xl shadow-slate-300/50 backdrop-blur-xl transition-transform duration-300 dark:border-slate-800 dark:bg-slate-900/85 dark:shadow-none md:translate-x-0"
    :class="{'translate-x-0': Alpine.store('ui').sidebarOpen, '-translate-x-[120%]': !Alpine.store('ui').sidebarOpen}"
>
    <div class="mb-5 flex items-center justify-between gap-3 border-b border-slate-200/80 pb-4 dark:border-slate-800">
        <div class="flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-sky-500 via-cyan-500 to-emerald-500 text-sm font-black text-white shadow-lg shadow-cyan-300/40">TR</span>
            <div>
                <p class="text-base font-extrabold tracking-tight text-slate-900 dark:text-white">TravelDesk</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Admin Experience</p>
            </div>
        </div>
        <button class="btn-ghost md:hidden" @click="Alpine.store('ui').closeSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @php
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12h18M12 3v18'],
            ['label' => 'Điểm đến', 'route' => 'admin.destinations.index', 'icon' => 'M4 6h16M4 12h12M4 18h9'],
            ['label' => 'Tour', 'route' => 'admin.tours.index', 'icon' => 'M4 8h16M6 16h12M9 4l1 4m5-4-1 4'],
            ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'icon' => 'M5 5h14v14H5z'],
            ['label' => 'Khuyến mãi', 'route' => 'admin.promotions.index', 'icon' => 'M4 7h16M4 12h10M4 17h7'],
            ['label' => 'Đánh giá', 'route' => 'admin.reviews.index', 'icon' => 'M4 6h16M4 12h16M4 18h10'],
            ['label' => 'Tin nhắn', 'route' => 'admin.chats.index', 'icon' => 'M21 14a2 2 0 01-2 2H8l-5 4V6a2 2 0 012-2h14a2 2 0 012 2z'],
            ['label' => 'Thanh toán', 'route' => 'admin.media.index', 'icon' => 'M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7l-4 2-4-2-4 2-4-2z'],
        ];
    @endphp

    <nav class="space-y-1.5">
        @foreach ($navItems as $item)
            @php($active = request()->routeIs($item['route'].'*'))
            <a href="{{ route($item['route']) }}"
               @click="Alpine.store('ui').closeSidebar()"
               class="group flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold transition-all {{ $active ? 'bg-gradient-to-r from-sky-500 to-cyan-500 text-white shadow-lg shadow-sky-300/40' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                <span class="grid h-8 w-8 place-items-center rounded-xl {{ $active ? 'bg-white/20' : 'bg-slate-100 text-slate-500 group-hover:bg-white dark:bg-slate-800 dark:text-slate-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                </span>
                <span>{{ $item['label'] }}</span>
                @if($item['route'] === 'admin.chats.index' && $adminChatAttentionCount > 0)
                    <span class="ml-auto inline-flex min-w-6 items-center justify-center rounded-full bg-rose-500 px-2 py-0.5 text-[11px] font-bold text-white">
                        {{ $adminChatAttentionCount }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</aside>
