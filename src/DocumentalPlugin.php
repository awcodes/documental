<?php

namespace Awcodes\Documental;

use Awcodes\Documental\Filament\Resources\PackageResource;
use Awcodes\Documental\Filament\Resources\PageResource;
use Awcodes\Documental\Filament\Resources\VersionResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Phiki\Theme\DefaultThemes;
use Phiki\Theme\Theme;

class DocumentalPlugin implements Plugin
{
    public function getId(): string
    {
        return 'documental';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                config('documental.resources.package', PackageResource::class),
                config('documental.resources.version', VersionResource::class),
                config('documental.resources.page', PageResource::class),
            ])
            ->navigationGroups(['Documental']);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
