<?php

namespace Awcodes\Documental\Filament\Resources\VersionResource\Pages;

use Filament\Actions\CreateAction;
use Awcodes\Documental\Filament\Resources\VersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVersions extends ListRecords
{
    protected static string $resource = VersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
