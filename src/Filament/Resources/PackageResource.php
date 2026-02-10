<?php

namespace Awcodes\Documental\Filament\Resources;

use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Filament\Resources\PackageResource\Pages;
use Awcodes\Documental\Filament\Resources\PackageResource\RelationManagers;
use Awcodes\Documental\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Documental';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Forms\Set $set, string $operation, $state) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options(PublishStatus::class)
                    ->required(),
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('github_url')
                        ->label('GitHub')
                        ->prefix('github.com/')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Forms\Components\Component $component, $state) {
                            $component->state(Str::ltrim($state, '/'));
                        })
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('stars')
                        ->label('Stars')
                        ->disabled()
                        ->formatStateUsing(fn ($state) => Number::format($state)),
                    Forms\Components\TextInput::make('downloads')
                        ->label('Downloads')
                        ->disabled()
                        ->formatStateUsing(fn ($state) => Number::format($state)),
                    Forms\Components\TextInput::make('latest_release')
                        ->label('Latest Release')
                        ->disabled(),
                ])->columnSpanFull()->columns(5),
                Forms\Components\Group::make([
                    Forms\Components\Textarea::make('description')
                        ->label('Description')
                        ->columnSpanFull(),
                ])->columns(3)->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latest_release'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stars')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('downloads')
                    ->numeric()
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VersionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
