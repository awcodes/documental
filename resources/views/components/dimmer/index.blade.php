@props([
    'forceMode' => null,
])

<div
    x-data="{
        dimmerTheme: null,
        open: false,
        init: function () {
            this.dimmerTheme = localStorage.getItem('dimmer-theme');

            if (! this.dimmerTheme) {
                this.dimmerTheme = '{{ $forceMode ?? "system" }}';
                localStorage.setItem('dimmer-theme', this.dimmerTheme);
            }

            this.handleAttribute();

            $dispatch('dimmer-theme-changed', this.dimmerTheme);

            $watch('dimmerTheme', (theme) => {
                this.handleAttribute();
                localStorage.setItem('dimmer-theme', theme);
                $dispatch('dimmer-theme-changed', theme);

                this.open = false;
            })
        },
        handleAttribute() {
            if (
                this.dimmerTheme === 'dark' ||
                (this.dimmerTheme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
    }"
    @class([
        'dimmer-controls relative',
    ])
>
    <button
        type="button"
        class="relative flex items-center whitespace-nowrap justify-center gap-2 p-2 text-gray-800 hover:text-primary-500 dark:text-gray-400"
        x-on:click="open = !open"
    >
        <svg x-show="dimmerTheme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" x-cloak>
            <title>Light mode</title>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>

        <svg x-show="dimmerTheme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" x-cloak>
            <title>Dark mode</title>
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>

        <svg x-show="dimmerTheme === 'system'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" x-cloak>
            <title>System mode</title>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
        </svg>
    </button>

    <div
        x-transition.origin.top.right
        class="absolute min-w-48 right-0 rounded-lg shadow-sm mt-2 z-10 origin-top-right bg-white divide-y divide-gray-200 outline-none border border-gray-200 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700"
        x-cloak
        x-show="open"
        x-on:click.outside="open = false"
        x-on:keydown.escape.window="open = false"
    >
        <div class="p-1.5" role="group">
            <x-documental::dimmer.button theme="light">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <title>Light mode</title>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <span @class([
                    'text-sm text-gray-500 dark:text-gray-400',
                ])>
                    Light mode
                </span>
            </x-documental::dimmer.button>

            <x-documental::dimmer.button theme="dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <title>Dark mode</title>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
                <span @class([
                    'text-sm text-gray-500 dark:text-gray-400',
                ])>
                    Dark mode
                </span>
            </x-documental::dimmer.button>

            <x-documental::dimmer.button theme="system">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <title>System mode</title>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                </svg>
                <span @class([
                    'text-sm text-gray-500 dark:text-gray-400',
                ])>
                    System mode
                </span>
            </x-documental::dimmer.button>
        </div>
    </div>
</div>
