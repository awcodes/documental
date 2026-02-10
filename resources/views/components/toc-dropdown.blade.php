<div x-data="{
    open: false,
}" class="relative">
    <button
        type="button"
        class="relative flex items-center whitespace-nowrap justify-center gap-2 py-2 rounded-lg shadow-sm bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 hover:border-gray-200 px-4 w-full"
        x-on:click="open = !open"
        x-on:click.outside="open = false"
        x-on:keydown.escape.window="open = false"
    >
        <span>On this page</span>

        <!-- Heroicon: micro chevron-down -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Menu Items -->
    <div
        x-transition.origin.top
        class="absolute inset-x-0 min-w-48 rounded-lg shadow-sm mt-2 z-10 origin-top bg-white divide-y divide-gray-200 outline-none border border-gray-200"
        x-cloak
        x-show="open"
    >
        <div class="p-1.5 [&_a]:text-gray-500 [&_a]:block [&_a]:py-1 [&_a]:px-2 [&_a:hover]:text-gray-700 dark:[&_a]:text-gray-400 dark:[&_a:hover]:text-gray-300" role="group">
            {{ $slot }}
        </div>
    </div>
</div>
