<?php

namespace Awcodes\Documental\Filament\Resources\PackageResource\Pages;

use Filament\Actions\DeleteAction;
use Awcodes\Documental\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
