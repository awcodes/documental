<?php

namespace Awcodes\Documental\Filament\Resources\PackageResource\Pages;

use Filament\Actions\CreateAction;
use Awcodes\Documental\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
