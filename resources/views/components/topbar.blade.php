@props([
    'pageHeader' => 'Page Header',
    'package' => null,
    'navigation' => [],
])
<div class="sticky top-0 z-40 h-16 shrink-0 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8 dark:bg-gray-900 dark:border-gray-800">
    <div class="grid grid-cols-2 items-center gap-x-4 lg:gap-x-6 lg:grid-cols-3">
        <div class="flex items-center gap-x-4">
            <div class="flex h-16 shrink-0 items-center">
                <a href="{{ route('docs.home') }}">
                    @if ($logo = filament()->getBrandLogo())
                        <img class="h-8 w-auto" src="{{ $logo }}" alt="{{ config('app.name') }}">
                    @else
                        {{ config('app.name') }}
                    @endif
                </a>
            </div>

            <x-documental::mobile-nav :navigation="$navigation" />

            <div class="flex flex-1 items-center gap-x-4 lg:gap-x-6">
                <p class="font-bold dark:text-white">{{ $pageHeader }}</p>
            </div>
        </div>
        <div class="hidden lg:block">
            @if (! route('docs.home'))
            <form class="grid flex-1 grid-cols-1 max-w-xs mx-auto" action="#" method="GET">
                <input type="search" name="search" aria-label="Search" class="col-start-1 row-start-1 block size-full bg-white text-base text-gray-900 ring-1 ring-gray-300 rounded-md py-1 pl-8 pr-2 placeholder:text-gray-400 sm:text-sm/6" placeholder="Search">
                <svg class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400 ml-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                </svg>
            </form>
            @endif
        </div>
        <div class="flex items-center justify-end">
            <x-documental::dimmer />
            @if ($package)
                @if (count($package->versions) === 1)
                    <div class="relative flex items-center whitespace-nowrap justify-center gap-2 p-2 text-gray-800 dark:text-gray-400">
                        <span>{{ request()->segment(3) }}</span>
                    </div>
                @else
                    <div x-data="{open: false}" class="relative">
                        <button
                            type="button"
                            class="relative flex items-center whitespace-nowrap justify-center gap-2 p-2 text-gray-800 hover:text-primary-500 dark:text-gray-400"
                            x-on:click="open = !open"
                        >
                            <span>{{ request()->segment(3) }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            x-transition.origin.top.right
                            class="absolute min-w-24 right-0 rounded-lg shadow-sm mt-2 z-10 origin-top-right bg-white divide-y divide-gray-200 outline-none border border-gray-200 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700"
                            x-cloak
                            x-show="open"
                            x-on:click.outside="open = false"
                            x-on:keydown.escape.window="open = false"
                        >
                            <div class="p-1.5" role="group">
                                @foreach ($package->versions as $version)
                                    <a
                                        type="button"
                                        class="w-full text-left items-center gap-2 flex rounded-lg p-2 outline-none transition duration-75 hover:bg-gray-50 focus:bg-gray-50 dark:hover:bg-white/5 dark:focus:bg-white/5 dark:text-gray-400"
                                        x-bind:class="{'bg-gray-50 text-primary-500 dark:bg-white/5 dark:text-primary-400':  @js(request()->segment(3) === $version->name)}"
                                        x-on:click="open = false"
                                        href="{{ route('docs.version.show', ['package' => $package->slug, 'version' => $version->name]) }}"
                                    >
                                        {{ $version->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="p-2">
                    <x-documental::github :link="$package->github_url" />
                </div>
            @endif
        </div>
    </div>
</div>
