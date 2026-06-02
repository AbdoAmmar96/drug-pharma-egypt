<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\DashboardHero;
use App\Filament\Widgets\Inbox;
use App\Filament\Widgets\KeyMetrics;
use App\Filament\Widgets\QuickActions;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName(fn () => __('admin.brand_name'))
            ->brandLogo(asset('logo.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('logo.png'))
            ->colors([
                'primary' => Color::hex('#1B2360'),
                'warning' => Color::hex('#E87330'),
                'gray'    => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                DashboardHero::class,
                KeyMetrics::class,
                QuickActions::class,
                Inbox::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()->label(fn () => __('admin.nav.catalog')),
                NavigationGroup::make()->label(fn () => __('admin.nav.communication')),
            ])
            ->renderHook(
                'panels::head.end',
                fn (): string => view('filament.admin-head')->render()
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
