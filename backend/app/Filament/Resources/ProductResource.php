<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.catalog');
    }

    public static function getModelLabel(): string
    {
        return __('admin.product.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.product.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.product.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Product')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('admin.product.tabs.basics'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('admin.product.fields.name'))
                                    ->required()
                                    ->maxLength(160)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                                        $set('slug', \Illuminate\Support\Str::slug($state))
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__('admin.product.fields.slug'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(160),

                                Forms\Components\Select::make('category_id')
                                    ->label(__('admin.product.fields.category'))
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\TextInput::make('form')
                                    ->label(__('admin.product.fields.form'))
                                    ->maxLength(80),

                                Forms\Components\Textarea::make('description')
                                    ->label(__('admin.product.fields.description'))
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make(__('admin.product.tabs.details'))
                            ->schema([
                                Forms\Components\Textarea::make('composition')
                                    ->label(__('admin.product.fields.composition'))
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('uses')
                                    ->label(__('admin.product.fields.uses'))
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('dose')
                                    ->label(__('admin.product.fields.dose'))
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make(__('admin.product.tabs.image'))
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label(__('admin.product.fields.image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('products')
                                    ->imageEditor()
                                    ->maxSize(3072)
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make(__('admin.product.tabs.visibility'))
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('admin.product.fields.is_active'))
                                    ->default(true),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label(__('admin.product.fields.is_featured')),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label(__('admin.product.fields.sort_order'))
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('admin.product.fields.image'))
                    ->disk('public')
                    ->square()
                    ->size(56)
                    ->defaultImageUrl(asset('images/placeholder-product.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.product.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('admin.product.fields.category'))
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('form')
                    ->label(__('admin.product.fields.form'))
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('admin.product.fields.is_featured'))
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.product.fields.is_active'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('admin.product.fields.sort_order'))
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label(__('admin.product.fields.category')),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('admin.product.fields.is_active')),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('admin.product.fields.is_featured')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('toggle_featured')
                        ->label(__('admin.product.fields.is_featured'))
                        ->icon('heroicon-o-star')
                        ->action(fn ($records) => $records->each(fn ($r) => $r->update(['is_featured' => !$r->is_featured]))),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
