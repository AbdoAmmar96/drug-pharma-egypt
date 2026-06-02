<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_read')
                ->label('Mark as read')
                ->icon('heroicon-o-check')
                ->visible(fn () => !$this->record->is_read)
                ->action(fn () => $this->record->markAsRead()),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->record->markAsRead();
    }
}
