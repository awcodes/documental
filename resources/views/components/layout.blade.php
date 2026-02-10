@props([
    'title' => 'Packages',
    'navigation' => [],
    'pageHeader' => null,
    'package' => null,
])

<!doctype html>
<html lang="en" class="h-dvh bg-white dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <script>
        let currentMode = localStorage.getItem('dimmer-theme');
        if (
            currentMode === 'dark' ||
            (currentMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="min-h-full flex flex-col">
    <div class="flex w-full flex-col">
        <x-documental::topbar :pageHeader="$pageHeader" :package="$package" :navigation="$navigation" />

        <div class="relative mx-auto flex w-full max-w-8xl flex-auto justify-center sm:px-2 lg:px-8 xl:px-12">
            @if (filled($navigation))
            <div class="hidden lg:relative lg:block lg:flex-none">
                <div class="absolute inset-y-0 right-0 w-[50vw] bg-gray-50 dark:hidden"></div>
                <div class="absolute top-16 right-0 bottom-0 hidden h-12 w-px bg-linear-to-t from-gray-800 dark:block"></div>
                <div class="absolute top-28 right-0 bottom-0 hidden w-px bg-gray-800 dark:block"></div>
                <div class="sticky top-[4.75rem] -ml-0.5 h-[calc(100vh-4.75rem)] w-64 overflow-x-hidden overflow-y-auto py-8 pr-8 pl-0.5 xl:w-72">
                    @if (filled($navigation))
                        <x-documental::sidebar :navigation="$navigation" />
                    @endif
                </div>
            </div>
            @endif
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
