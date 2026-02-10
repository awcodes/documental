<?php

namespace Awcodes\Documental\Filament\Resources\VersionResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Awcodes\Documental\Filament\Resources\PageResource;
use Awcodes\Documental\Filament\Resources\VersionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVersion extends EditRecord
{
    protected static string $resource = VersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pages')
                ->url(fn ($record) => PageResource::getUrl('index', [
                    'tableFilters[package_version][package]' => $record->package_id,
                    'tableFilters[package_version][version]' => $record->id,
                ])),
            DeleteAction::make(),
        ];
    }
}
