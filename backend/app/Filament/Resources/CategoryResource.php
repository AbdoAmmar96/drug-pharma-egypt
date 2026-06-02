<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.catalog');
    }

    public static function getModelLabel(): string
    {
        return __('admin.category.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.category.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.category.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.category.fields.name'))
                            ->required()
                            ->maxLength(120)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                                $set('slug', \Illuminate\Support\Str::slug($state))
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label(__('admin.category.fields.slug'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(120),

                        Forms\Components\Textarea::make('description')
                            ->label(__('admin.category.fields.description'))
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('icon')
                            ->label(__('admin.category.fields.icon'))
                            ->maxLength(8)
                            ->placeholder('👶'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('admin.category.fields.sort_order'))
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.category.fields.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')->label(''),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.category.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('admin.category.fields.slug'))
                    ->color('gray')
                    ->copyable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label(__('admin.product.plural')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.category.fields.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('admin.category.fields.sort_order'))
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('admin.category.fields.is_active')),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
