<?php

namespace Awcodes\Documental\Filament\Resources;

use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Filament\Resources\PackageResource\Pages\CreatePackage;
use Awcodes\Documental\Filament\Resources\PackageResource\Pages\EditPackage;
use Awcodes\Documental\Filament\Resources\PackageResource\Pages\ListPackages;
use Awcodes\Documental\Filament\Resources\PackageResource\RelationManagers\VersionsRelationManager;
use Awcodes\Documental\Models\Package;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 1;

    protected static string | \UnitEnum | null $navigationGroup = 'Documental';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Set $set, string $operation, $state) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options(PublishStatus::class)
                    ->required(),
                Group::make([
                    TextInput::make('github_url')
                        ->label('GitHub')
                        ->prefix('github.com/')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Component $component, $state) {
                            $component->state(Str::ltrim($state, '/'));
                        })
                        ->columnSpan(2),
                    TextInput::make('stars')
                        ->label('Stars')
                        ->disabled()
                        ->formatStateUsing(fn ($state) => Number::format($state)),
                    TextInput::make('downloads')
                        ->label('Downloads')
                        ->disabled()
                        ->formatStateUsing(fn ($state) => Number::format($state)),
                    TextInput::make('latest_release')
                        ->label('Latest Release')
                        ->disabled(),
                ])->columnSpanFull()->columns(5),
                Group::make([
                    Textarea::make('description')
                        ->label('Description')
                        ->columnSpanFull(),
                ])->columns(3)->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('latest_release'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('stars')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('downloads')
                    ->numeric()
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VersionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
