<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ProductResource;
use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';

    protected int | string | array $columnSpan = 12;

    protected static ?int $sort = 3;

    protected function getViewData(): array
    {
        return [
            'heading'  => 'Quick Actions',
            'sub'      => 'Jump straight to your next task.',
            'actions'  => [
                [
                    'icon'  => 'plus',
                    'tone'  => 'orange',
                    'title' => 'New Product',
                    'desc'  => 'Add a formulation.',
                    'url'   => ProductResource::getUrl('create'),
                ],
                [
                    'icon'  => 'folder',
                    'tone'  => 'navy',
                    'title' => 'Categories',
                    'desc'  => 'Therapeutic groups.',
                    'url'   => CategoryResource::getUrl('index'),
                ],
                [
                    'icon'  => 'chat',
                    'tone'  => 'navy-soft',
                    'title' => 'Inbox',
                    'desc'  => 'Customer messages.',
                    'url'   => ContactMessageResource::getUrl('index'),
                ],
                [
                    'icon'  => 'globe',
                    'tone'  => 'orange-soft',
                    'title' => 'View Site',
                    'desc'  => 'Open the front-end.',
                    'url'   => env('FRONTEND_URL', 'http://localhost:5173'),
                    'external' => true,
                ],
            ],
        ];
    }
}
