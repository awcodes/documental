<?php

namespace Awcodes\Documental\Filament\Resources\PageResource\Pages;

use Filament\Actions\DeleteAction;
use Awcodes\Documental\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
