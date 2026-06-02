<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Widgets\Widget;

class Inbox extends Widget
{
    protected static string $view = 'filament.widgets.inbox';

    protected int | string | array $columnSpan = 12;

    protected static ?int $sort = 5;

    protected function getViewData(): array
    {
        return [
            'messages' => ContactMessage::query()
                ->latest()
                ->limit(6)
                ->get(),
            'allUrl'   => ContactMessageResource::getUrl('index'),
        ];
    }
}
