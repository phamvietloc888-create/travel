<!DOCTYPE html>
<html lang="en" class="h-full" x-data>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} | Travel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100" x-data>
    <div class="flex min-h-screen" x-data>
        @include('admin.partials.sidebar')

        <div class="flex flex-1 flex-col min-h-screen md:ml-64 transition-all duration-300">
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
    @stack('scripts')
</body>
</html>
