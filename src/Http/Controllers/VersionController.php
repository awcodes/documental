<?php

namespace Awcodes\Documental\Http\Controllers;

use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Illuminate\Http\RedirectResponse;

class VersionController
{
    public function __invoke(string $package, string $version): RedirectResponse
    {
        $package = Package::query()
            ->where('slug', $package)
            ->with(['versions.pages'])
            ->firstOrFail();

        /** @var Version $version */
        $version = $package->versions->where('name', $version)->firstOrFail();

        /** @var Page $firstPage */
        $firstPage = $version->pages->first();

        return redirect(route('docs.page', [
            'package' => $package->slug,
            'version' => $version->name,
            'page' => $firstPage->slug,
        ]));
    }
}
