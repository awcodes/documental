<?php

use Awcodes\Documental\Http\Controllers\PackageController;
use Awcodes\Documental\Http\Controllers\PageController;
use Awcodes\Documental\Http\Controllers\VersionController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', SubstituteBindings::class])->group(function () {
    Route::get('/docs', [PackageController::class, 'index'])->name('docs.home');
    Route::get('/docs/{package:slug}', [PackageController::class, 'show'])->name('docs.package.show');
    Route::get('/docs/{package:slug}/{version:name}', VersionController::class)->name('docs.version.show');
    Route::get('/docs/{package:slug}/{version:name}/{page:slug}', PageController::class)->name('docs.page');
});
