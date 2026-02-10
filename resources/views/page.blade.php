@php
    use Phiki\CommonMark\PhikiExtension;
    use RyanChandler\CommonmarkBladeBlock\BladeExtension;
    use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
    use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;

    $content = docMarkdown($page->content);
@endphp

<x-documental::layout
    title="{{ $page->title }} - {{ $package->name }}"
    page-header="{{ $package->name }}"
    :navigation="$navigation"
    :package="$package"
>
    <div class="max-w-2xl min-w-0 flex-auto px-4 pt-8 pb-16 lg:max-w-none lg:px-8 lg:pt-12">
        <div class="mb-8 lg:mb-0 lg:hidden">
            <x-documental::toc-dropdown>
                {!! $content['toc'] !!}
            </x-documental::toc-dropdown>
        </div>
        <article>
            <div class="prose max-w-none prose-gray dark:text-gray-400 dark:prose-invert prose-headings:scroll-mt-28 prose-headings:font-display prose-headings:font-normal lg:prose-headings:scroll-mt-[8.5rem] prose-lead:text-gray-500 dark:prose-lead:text-gray-400 prose-a:font-semibold dark:prose-a:text-primary-500 dark:[--tw-prose-background:var(--color-gray-900)] prose-a:no-underline prose-a:shadow-[inset_0_-2px_0_0_var(--tw-prose-background,#fff),inset_0_calc(-1*(var(--tw-prose-underline-size,4px)+2px))_0_0_var(--tw-prose-underline,var(--color-primary-600))] prose-a:hover:[--tw-prose-underline-size:6px] dark:prose-a:shadow-[inset_0_calc(-1*var(--tw-prose-underline-size,2px))_0_0_var(--tw-prose-underline,var(--color-primary-800))] dark:prose-a:hover:[--tw-prose-underline-size:6px] prose-pre:rounded-xl dark:prose-hr:border-gray-800 [&_*:is(h1,h2,h3,h4,h5,h6)_a]:mr-2">
                {!! $content['content'] !!}
            </div>
        </article>
        <div class="mt-12 flex items-center justify-between gap-6">
            @if (filled($previousPage))
                <a
                    href="{{ route('docs.page', ['package' => $package->slug, 'version' => $version->name, 'page' => $previousPage['url']]) }}"
                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    {{ $previousPage['label'] }}
                </a>
            @endif
            @if (filled($nextPage))
                <a
                    href="{{ route('docs.page', ['package' => $package->slug, 'version' => $version->name, 'page' => $nextPage['url']]) }}"
                    class="ml-auto flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                >
                    {{ $nextPage['label'] }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
    <div class="hidden xl:sticky xl:top-[4.75rem] xl:-mr-6 xl:block xl:h-[calc(100vh-4.75rem)] xl:flex-none xl:overflow-y-auto xl:py-12 xl:pr-6">
        <div class="w-56">
        @if (filled($content['toc']))
            <nav aria-labelledby="on-this-page-title" class="[&_a]:text-gray-500 [&_a]:text-sm/6 [&_a]:block [&_a]:py-1 [&_a:hover]:text-gray-700 dark:[&_a]:text-gray-400 dark:[&_a:hover]:text-gray-300">
                <h2
                    id="on-this-page-title"
                    class="font-display text-sm font-medium mb-2 text-primary-600 dark:text-primary-500"
                >
                    On this page
                </h2>
                {!! $content['toc'] !!}
            </nav>
        @endif
    </div>
</x-documental::layout>
