<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Product;
use Filament\Widgets\Widget;

class DashboardHero extends Widget
{
    protected static string $view = 'filament.widgets.hero';

    protected int | string | array $columnSpan = 12;

    protected static ?int $sort = 1;

    protected function getViewData(): array
    {
        $hour = now()->hour;

        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 18 => 'Good afternoon',
            default    => 'Good evening',
        };

        return [
            'name'           => auth()->user()?->name ?? 'Admin',
            'greeting'       => $greeting,
            'date'           => now()->format('l, j F Y'),
            'productsActive' => Product::active()->count(),
            'messagesUnread' => ContactMessage::unread()->count(),
        ];
    }
}
