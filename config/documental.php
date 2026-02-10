<?php

// config for Awcodes/Documental
use Phiki\Theme\Theme;

return [
    'resources' => [
        'package' => \Awcodes\Documental\Filament\Resources\PackageResource::class,
        'version' => \Awcodes\Documental\Filament\Resources\VersionResource::class,
        'page' => \Awcodes\Documental\Filament\Resources\PageResource::class,
    ],
    'phiki' => [
        'themes' => [
            'light' => Theme::GithubLight,
            'dark' => Theme::GithubDark,
        ],
    ],
];
