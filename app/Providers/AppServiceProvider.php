<?php

namespace App\Providers;

use App\View\SidebarRegistry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SidebarRegistry::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SidebarRegistry $sidebarRegistry): void
    {
        $sidebarRegistry->addMainItem('Dashboard', 'dashboard', 'HomeIcon');
        $sidebarRegistry->addMainItem('Profile', 'profile.edit', 'UserIcon');
        $sidebarRegistry->addProfileItem('Profile', 'profile.edit');
        $sidebarRegistry->addProfileItem('Logout', 'logout');
    }
}
