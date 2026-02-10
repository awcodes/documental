<?php

namespace Awcodes\Documental\Filament\Resources\VersionResource\Pages;

use Awcodes\Documental\Filament\Resources\VersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVersions extends ListRecords
{
    protected static string $resource = VersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
