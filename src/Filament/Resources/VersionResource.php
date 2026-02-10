<?php

namespace Awcodes\Documental\Filament\Resources;

use Awcodes\Documental\Enums\VersionStatus;
use Awcodes\Documental\Filament\Resources\VersionResource\Pages\CreateVersion;
use Awcodes\Documental\Filament\Resources\VersionResource\Pages\EditVersion;
use Awcodes\Documental\Filament\Resources\VersionResource\Pages\ListVersions;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-variable';

    protected static ?int $navigationSort = 2;

    protected static string | \UnitEnum | null $navigationGroup = 'Documental';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options(VersionStatus::class)
                    ->required(),
                DatePicker::make('released_at')
                    ->label('Released At')
                    ->required(),
                AdjacencyList::make('navigation')
                    ->label('Navigation')
                    ->columnSpanFull()
                    ->addAction(fn (Action $action): Action => $action->modalWidth(Width::Small))
                    ->addChildAction(fn (Action $action): Action => $action->modalWidth(Width::Small))
                    ->editAction(fn (Action $action): Action => $action->modalWidth(Width::Small))
                    ->deleteAction(fn (Action $action): Action => $action->modalWidth(Width::Small))
                    ->form([
                        TextInput::make('label')
                            ->required(),
                        Select::make('url')
                            ->searchable()
                            ->preload()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, $state, $record) {
                                if (! $get('label')) {
                                    $page = Page::query()
                                        ->where('slug', $state)
                                        ->where('version_id', $record->id)
                                        ->first();

                                    $set('label', $page->title);
                                }

                                return $state;
                            })
                            ->options(function ($record): array {
                                return Page::query()
                                    ->where('version_id', $record->id)
                                    ->limit(10)
                                    ->pluck('title', 'slug')
                                    ->toArray();
                            })
                            ->getSearchResultsUsing(function (string $search, $record): array {
                                return Page::query()
                                    ->where('title', 'like', "%{$search}%")
                                    ->where('version_id', $record->id)
                                    ->limit(50)
                                    ->pluck('title', 'slug')
                                    ->toArray();
                            })
                            ->getOptionLabelUsing(function ($value): ?string {
                                return Page::query()->find($value)?->title;
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('released_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('package.name')
                    ->label('Package')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->with(['package' => function ($query) {
                    $query->withoutGlobalScopes();
                }]);
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVersions::route('/'),
            'create' => CreateVersion::route('/create'),
            'edit' => EditVersion::route('/{record}/edit'),
        ];
    }
}
