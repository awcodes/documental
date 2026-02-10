<?php

namespace Awcodes\Documental\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Awcodes\Documental\Filament\Resources\PageResource\Pages\ListPages;
use Awcodes\Documental\Filament\Resources\PageResource\Pages\CreatePage;
use Awcodes\Documental\Filament\Resources\PageResource\Pages\EditPage;
use Awcodes\Documental\Enums\PublishStatus;
use Awcodes\Documental\Filament\Resources\PageResource\Pages;
use Awcodes\Documental\Models\Package;
use Awcodes\Documental\Models\Page;
use Awcodes\Documental\Models\Version;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected static string | \UnitEnum | null $navigationGroup = 'Documental';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                TextInput::make('title')
                    ->label('Title')
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
                Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('version_id')
                    ->label('Version')
                    ->relationship('version', 'name', function (Builder $query, Get $get) {
                        $query->where('package_id', $get('package_id'))->orderBy('name', 'desc');
                    })
                    ->preload()
                    ->searchable()
                    ->required(),
                MarkdownEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('version.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('package.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('package_version')
                    ->schema([
                        Select::make('package')
                            ->relationship('package', 'name')
                            ->preload()
                            ->label('Package'),
                        Select::make('version')
                            ->relationship('version', 'name', function (Builder $query, Get $get) {
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
                SelectFilter::make('status')
                    ->options(PublishStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
