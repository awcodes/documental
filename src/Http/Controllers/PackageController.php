<?php

namespace Awcodes\Documental\Http\Controllers;

use Awcodes\Documental\Models\Package;
use Illuminate\View\View;

class PackageController
{
    public function index(): View
    {
        $packages = Package::query()->with('versions')->get();

        return view('documental::index', ['packages' => $packages]);
    }

    public function show(string $package): View
    {
        $package = Package::query()
            ->where('slug', $package)
            ->with(['versions'])
            ->firstOrFail();

        return view('documental::package', [
            'package' => $package,
        ]);
    }
}
