@props([
    'navigation' => [],
])
<div class="hidden shrink-0 lg:z-50 lg:flex w-full lg:flex-col">
    <div class="flex grow flex-col overflow-y-auto">
        <nav class="flex flex-1 flex-col">
            <ul role="list">
                @foreach ($navigation as $item)
                    <li>
                        @if (filled($item['children']))
                            @php
                              $children = array_values($item['children']);
                            @endphp
                            <div
                                x-data="{
                                    open: false,
                                    init: function() {
                                        let items = @js($children);
                                        let currentUrl = '{{ request()->url() }}';

                                        if (items.length > 0) {
                                            this.open = items.some(item => currentUrl.includes(item.url));
                                        }
                                    }
                                }"
                            >
                                <button type="button" class="flex w-full items-center justify-between gap-x-3 py-1 font-semibold text-left text-sm/6 text-gray-800 hover:text-primary-600 dark:text-gray-400" aria-controls="sub-menu-1" aria-expanded="false" x-on:click="open = !open">
                                    {{ $item['label'] }}
                                    <svg class="size-5 shrink-0" x-bind:class="{
                                            'text-gray-400': !open,
                                            'text-gray-500 rotate-90': open
                                        }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <ul class="mt-1 px-2" id="sub-menu-1" x-show="open">
                                    @foreach ($children as $child)
                                        <li>
                                            <a
                                                href="{{ $child['url'] }}"
                                                @class([
                                                    'block py-1 text-sm/6 font-semibold text-gray-800 hover:text-primary-600 dark:text-gray-400',
                                                    'text-primary-600 dark:text-primary-500' => str_contains(request()->url(), $child['url']),
                                                  ])
                                                aria-current="{{ str_contains(request()->url(), $child['url']) ? 'page' : false }}"
                                            >
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a
                                href="{{ $item['url'] }}"
                                @class([
                                    'block py-1 text-sm/6 font-semibold text-gray-800 hover:text-primary-600 dark:text-gray-400',
                                    'text-primary-600 dark:text-primary-500' => str_contains(request()->url(), $item['url']),
                                  ])
                                aria-current="{{ str_contains(request()->url(), $item['url']) ? 'page' : false }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
