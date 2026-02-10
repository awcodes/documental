<?php

namespace Awcodes\Documental\Filament\Resources;

use Awcodes\Documental\Enums\VersionStatus;
use Awcodes\Documental\Filament\Resources\VersionResource\Pages;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationIcon = 'heroicon-o-variable';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Documental';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options(VersionStatus::class)
                    ->required(),
                Forms\Components\DatePicker::make('released_at')
                    ->label('Released At')
                    ->required(),
                AdjacencyList::make('navigation')
                    ->label('Navigation')
                    ->columnSpanFull()
                    ->addAction(fn (Action $action): Action => $action->modalWidth(MaxWidth::Small))
                    ->addChildAction(fn (Action $action): Action => $action->modalWidth(MaxWidth::Small))
                    ->editAction(fn (Action $action): Action => $action->modalWidth(MaxWidth::Small))
                    ->deleteAction(fn (Action $action): Action => $action->modalWidth(MaxWidth::Small))
                    ->form([
                        Forms\Components\TextInput::make('label')
                            ->required(),
                        Forms\Components\Select::make('url')
                            ->searchable()
                            ->preload()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state, $record) {
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('released_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Package')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListVersions::route('/'),
            'create' => Pages\CreateVersion::route('/create'),
            'edit' => Pages\EditVersion::route('/{record}/edit'),
        ];
    }
}
