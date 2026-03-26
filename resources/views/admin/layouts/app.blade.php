<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} | Travel</title>
    <script>
        (function () {
            const savedTheme = localStorage.getItem('admin-theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const useDark = savedTheme ? savedTheme === 'dark' : prefersDark;
            document.documentElement.classList.toggle('dark', useDark);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell" x-data>
    <div class="admin-bg-orb admin-bg-orb-a"></div>
    <div class="admin-bg-orb admin-bg-orb-b"></div>

    <div class="admin-main px-3 py-3 sm:px-4 sm:py-4">
        <div class="admin-content-wrap flex min-h-[calc(100vh-1.5rem)]" x-data>
        @include('admin.partials.sidebar')

            <div class="flex min-h-full flex-1 flex-col md:ml-72 transition-all duration-300">
            @include('admin.partials.topbar')

                <main class="flex-1 px-4 pb-10 pt-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-7xl space-y-6">
                    @isset($pageHeader)
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            {{ $pageHeader }}
                        </div>
                    @endisset

                    <x-admin.toast />
                    @yield('content')
                </div>
            </main>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
