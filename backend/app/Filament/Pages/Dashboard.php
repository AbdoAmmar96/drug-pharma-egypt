<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardHero;
use App\Filament\Widgets\KeyMetrics;
use App\Filament\Widgets\QuickActions;
use App\Filament\Widgets\Inbox;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getTitle(): string
    {
        return __('admin.dashboard.title');
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getColumns(): int | string | array
    {
        return 12;
    }

    public function getWidgets(): array
    {
        return [
            DashboardHero::class,    // span 12
            KeyMetrics::class,       // span 12 (4 KPI cards in a row)
            QuickActions::class,     // span 12 (4 action cards in a row)
            Inbox::class,            // span 12
        ];
    }
}
