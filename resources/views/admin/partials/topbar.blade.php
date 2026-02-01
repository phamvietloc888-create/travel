<header class="sticky top-0 z-20 flex items-center gap-4 border-b border-slate-200 bg-white/80 px-4 py-3 backdrop-blur dark:border-slate-800 dark:bg-slate-900/70">
    <button class="btn-ghost md:hidden" @click="Alpine.store('ui').toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="relative flex-1 max-w-xl">
        <input type="text" placeholder="Search across admin..."
               class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 pl-10 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200 dark:border-slate-800 dark:bg-slate-900" />
        <span class="absolute left-3 top-2.5 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.29 5.29a7.5 7.5 0 0011.36 11.36z" />
            </svg>
        </span>
    </div>

    <div class="flex items-center gap-2">
        <button class="btn-ghost" @click="Alpine.store('ui').toggleTheme()" title="Toggle theme">
            <svg x-show="!Alpine.store('ui').dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364L17.95 6.05M6.05 17.95l-1.414 1.414m12.728 0l-1.414-1.414M6.05 6.05 4.636 4.636M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg x-show="Alpine.store('ui').dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
            </svg>
        </button>

        <div class="relative" x-data="{ open: false }">
            <button class="btn-ghost" @click="open = !open">
                <div class="flex items-center gap-2">
                    <div class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <div class="hidden text-left text-sm md:block">
                        <p class="font-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Administrator</p>
                    </div>
                </div>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-52 rounded-xl border border-slate-200 bg-white p-3 shadow-lg dark:border-slate-800 dark:bg-slate-900">
                <p class="px-2 text-xs uppercase text-slate-400">Account</p>
                <a href="#" class="mt-2 flex items-center gap-2 rounded-lg px-2 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-100 dark:hover:bg-slate-800">
                    <span>Profile (coming)</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mt-1 flex w-full items-center gap-2 rounded-lg px-2 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-950">
                        <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
