<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.communication');
    }

    public static function getModelLabel(): string
    {
        return __('admin.message.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.message.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.message.plural');
    }

    public static function getNavigationBadge(): ?string
    {
        $count = \Illuminate\Support\Facades\Cache::remember(
            'inbox.unread_count',
            60,
            fn () => static::getModel()::unread()->count()
        );
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.message.fields.name'))->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.message.fields.email'))->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('admin.message.fields.phone'))->disabled(),
                        Forms\Components\TextInput::make('topic')
                            ->label(__('admin.message.fields.topic'))->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->label(__('admin.message.fields.message'))
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_read')
                            ->label(__('admin.message.fields.status')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label(__('admin.message.fields.status'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.message.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight(fn ($record) => $record->is_read ? null : 'bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.message.fields.email'))
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('topic')
                    ->label(__('admin.message.fields.topic'))
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('admin.message.fields.phone'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.message.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label(__('admin.message.fields.status')),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_read')
                    ->label(__('admin.message.fields.status'))
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => !$record->is_read)
                    ->action(fn ($record) => $record->markAsRead()),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_all_read')
                        ->label(__('admin.message.fields.status'))
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->markAsRead()),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view'  => Pages\ViewContactMessage::route('/{record}'),
            'edit'  => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
