<?php

namespace Awcodes\Documental\Http\Controllers;

use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class PageController
{
    public function __invoke(string $package, string $version, string $page): View
    {
        $package = Package::query()
            ->where('slug', $package)
            ->with(['versions.pages'])
            ->firstOrFail();

        /** @var Version $version */
        $version = $package->versions->where('name', $version)->firstOrFail();

        $page = $version->pages->where('slug', $page)->firstOrFail();

        $navigation = filled($version->navigation)
            ? $version->navigation
            : $version->pages->map(function (Page $page) {
                return [
                    'label' => $page->title,
                    'url' => $page->slug,
                    'children' => [],
                ];
            })->toArray();

        return view('documental::page', [
            'package' => $package,
            'version' => $version,
            'page' => $page,
            'navigation' => $navigation,
            'previousPage' => $this->getPreviousPage($navigation, $page),
            'nextPage' => $this->getNextPage($navigation, $page),
        ]);
    }

    private function flattenNavigation($navigation): array
    {
        $flattened = [];

        foreach ($navigation as $item) {
            $flattened[] = $item;

            if (filled(Arr::get($item, 'children'))) {
                $flattened = array_merge($flattened, $this->flattenNavigation(Arr::get($item, 'children')));
            }
        }

        return $flattened;
    }

    private function getPreviousPage(array $navigation, Page $currentPage): ?array
    {
        return collect($this->flattenNavigation($navigation))
            ->filter(function ($item) {
                return filled($item['url']);
            })
            ->before(function ($item) use ($currentPage) {
                return $item['url'] === $currentPage->slug;
            });
    }

    private function getNextPage(array $navigation, Page $currentPage): ?array
    {
        return collect($this->flattenNavigation($navigation))
            ->filter(function ($item) {
                return filled($item['url']);
            })
            ->after(function ($item) use ($currentPage) {
                return $item['url'] === $currentPage->slug;
            });
    }
}
