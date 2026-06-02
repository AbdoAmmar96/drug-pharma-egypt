<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use Filament\Widgets\Widget;

class KeyMetrics extends Widget
{
    protected static string $view = 'filament.widgets.key-metrics';

    protected int | string | array $columnSpan = 12;

    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        $p = Product::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->selectRaw('SUM(CASE WHEN is_featured = 1 AND is_active = 1 THEN 1 ELSE 0 END) as featured')
            ->first();
        $totalProducts    = (int) $p->total;
        $activeProducts   = (int) $p->active;
        $featuredProducts = (int) $p->featured;

        $totalCategories = Category::active()->count();

        $m = ContactMessage::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread')
            ->first();
        $totalMessages  = (int) $m->total;
        $unreadMessages = (int) $m->unread;

        return [
            'metrics' => [
                [
                    'label'     => 'Total Products',
                    'value'     => (string) $totalProducts,
                    'meta'      => "{$activeProducts} active",
                    'symbol'    => '▲',
                    'metaTone'  => 'orange',
                    'valueTone' => 'navy',
                    'accent'    => 'orange',
                ],
                [
                    'label'     => 'Categories',
                    'value'     => (string) $totalCategories,
                    'meta'      => 'Therapeutic',
                    'symbol'    => null,
                    'metaTone'  => 'muted',
                    'valueTone' => 'navy',
                    'accent'    => 'transparent',
                ],
                [
                    'label'     => 'Featured',
                    'value'     => (string) $featuredProducts,
                    'meta'      => 'on home page',
                    'symbol'    => '★',
                    'metaTone'  => 'muted',
                    'valueTone' => 'navy',
                    'accent'    => 'transparent',
                ],
                [
                    'label'     => 'Unread Messages',
                    'value'     => (string) $unreadMessages,
                    'meta'      => "{$totalMessages} total",
                    'symbol'    => '▲',
                    'metaTone'  => 'muted',
                    'valueTone' => $unreadMessages > 0 ? 'orange' : 'navy',
                    'accent'    => $unreadMessages > 0 ? 'orange' : 'transparent',
                ],
            ],
        ];
    }
}
