<?php declare(strict_types=1);

namespace App\Providers;

use App\View\SidebarRegistry;
use Illuminate\Http\Request;
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
        $sidebarRegistry->addMainItem('Overview', 'HomeIcon', 'projects.overview', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addMainItem('Settings', 'CogIcon', 'projects.settings', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addProfileItem('Profile', 'profile.edit');
        $sidebarRegistry->addProfileItem('Logout', 'logout');
    }
}
