<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
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
            ->path('useluminii')
            ->login()
            ->colors([
                'primary'   => Color::hex('#635bff'),
                'gray'      => Color::Slate,
                'danger'    => Color::Rose,
                'info'      => Color::Blue,
                'success'   => Color::Emerald,
                'warning'   => Color::Amber,
            ])
            ->brandName('Luminii CRM')
            ->brandLogo(fn () => view('filament.brand'))
            ->favicon(asset('assets/images/favicon.ico'))
            ->font('Inter')
            ->darkMode(false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15rem')
            ->collapsedSidebarWidth('4rem')
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): HtmlString => new HtmlString(
                    '<link rel="stylesheet" href="' . asset('css/crm-design-system.css') . '?v=' . filemtime(public_path('css/crm-design-system.css')) . '" />'
                )
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\CrmStatsOverview::class,
                \App\Filament\Widgets\RevenueChartWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('CRM')->icon('heroicon-o-users'),
                NavigationGroup::make('Operations')->icon('heroicon-o-briefcase'),
                NavigationGroup::make('Finance')->icon('heroicon-o-banknotes'),
                NavigationGroup::make('Reports')->icon('heroicon-o-chart-bar'),
                NavigationGroup::make('Settings')->icon('heroicon-o-cog-6-tooth'),
            ])
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
