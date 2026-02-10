@props([
    'navigation' => [],
])
<div class="relative z-50 lg:hidden" role="dialog" aria-modal="true"
    x-data="{
        open: false,
    }"
>
    <button type="button" class="p-2.5 text-gray-700 lg:hidden cursor-pointer" x-on:click="console.log('test'); open = true">
        <span class="sr-only">Open sidebar</span>
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
    <!--
      Off-canvas menu backdrop, show/hide based on off-canvas menu state.

      Entering: "transition-opacity ease-linear duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "transition-opacity ease-linear duration-300"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true"
         x-show="open"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    ></div>

    <div class="fixed inset-0 flex"
         x-show="open"
    >
        <!--
          Off-canvas menu, show/hide based on off-canvas menu state.

          Entering: "transition ease-in-out duration-300 transform"
            From: "-trangray-x-full"
            To: "trangray-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "trangray-x-0"
            To: "-trangray-x-full"
        -->
        <div class="relative mr-16 flex w-full max-w-xs flex-1"
             x-show="open"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
        >
            <!--
              Close button, show/hide based on off-canvas menu state.

              Entering: "ease-in-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in-out duration-300"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5"
                 x-show="open"
                 x-transition:enter="ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
            >
                <button type="button" class="-m-2.5 p-2.5" x-on:click="open = false">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                <div class="flex h-16 shrink-0 items-center">
                    <a href="{{ route('docs.home') }}">
                        @if ($logo = filament()->getBrandLogo())
                            <img class="h-8 w-auto" src="{{ $logo }}" alt="{{ config('app.name') }}">
                        @else
                            {{ config('app.name') }}
                        @endif
                    </a>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                    @foreach($navigation as $item)
                                <li>
                                    <!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
                                    <a href="{{ $item['url'] }}" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:text-white hover:bg-gray-800">
                                        <svg class="size-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                                    @endforeach
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
