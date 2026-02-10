<?php

namespace Awcodes\Documental\Filament\Resources;

use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Filament\Resources\PageResource\Pages;
use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Documental';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
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
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('version_id')
                    ->label('Version')
                    ->relationship('version', 'name', function (Builder $query, Forms\Get $get) {
                        $query->where('package_id', $get('package_id'))->orderBy('name', 'desc');
                    })
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\MarkdownEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('package_version')
                    ->form([
                        Forms\Components\Select::make('package')
                            ->relationship('package', 'name')
                            ->preload()
                            ->label('Package'),
                        Forms\Components\Select::make('version')
                            ->relationship('version', 'name', function (Builder $query, Forms\Get $get) {
                                $query->where('package_id', $get('package'));
                            })
                            ->preload()
                            ->label('Version'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['package'],
                                fn (Builder $query, $package): Builder => $query->where('package_id', $package),
                            )
                            ->when(
                                $data['version'],
                                fn (Builder $query, $version): Builder => $query->where('version_id', $version),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['package'] ?? null) {
                            $package = Package::query()->find($data['package']);
                            $indicators[] = Indicator::make('Package: ' . $package->name)
                                ->removeField('package');
                        }

                        if ($data['version'] ?? null) {
                            $version = Version::query()->find($data['version']);
                            $indicators[] = Indicator::make('Version: ' . $version->name)
                                ->removeField('version');
                        }

                        return $indicators;
                    }),
                Tables\Filters\SelectFilter::make('status')
                    ->options(PublishStatus::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order_column')
            ->modifyQueryUsing(function (Builder $query) {
                $query->with(['version' => function ($query) {
                    $query->with(['package' => function ($query) {
                        $query->withoutGlobalScopes();
                    }]);
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
