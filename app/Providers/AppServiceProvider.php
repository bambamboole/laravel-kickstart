<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\Auth\PermissionRegistry;
use App\Services\View\SidebarRegistry;
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
        $this->app->singleton(PermissionRegistry::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SidebarRegistry $sidebarRegistry, PermissionRegistry $permissionRegistry): void
    {
        $permissionRegistry->add('project.delete');
        $sidebarRegistry->addMainItem('Overview', 'HomeIcon', 'project.overview', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addMainItem('Settings', 'CogIcon', 'project.settings', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addMainItem('Members', 'UsersIcon', 'project.members.index', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addProfileItem('Profile', 'profile.edit');
        $sidebarRegistry->addProfileItem('Logout', 'logout');
    }
}
