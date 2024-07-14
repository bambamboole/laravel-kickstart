<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\Auth\PermissionRegistry;
use App\Services\View\SidebarRegistry;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
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
        Event::listen(Login::class, function (Login $event) {
            $event->user->update(['last_login_at' => now()]);
        });
        $permissionRegistry->add('project.delete');
        $permissionRegistry->add('project.settings.view');
        $permissionRegistry->add('project.members.view');
        $permissionRegistry->add('project.members.invite');
        $permissionRegistry->add('project.members.remove');
        $permissionRegistry->add('project.invitations.delete');
        $permissionRegistry->add('project.api-token.create');
        $permissionRegistry->add('project.api-token.delete');
        $sidebarRegistry->addMainItem('Overview', 'HomeIcon', 'project.overview', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addMainItem('Settings', 'CogIcon', 'project.settings', fn (Request $request) => ['uuid' => $request->route('uuid')]);
        $sidebarRegistry->addMainItem('Members', 'UsersIcon', 'project.members.index', fn (Request $request) => ['uuid' => $request->route('uuid')], 'project.members.view');
        $sidebarRegistry->addProfileItem('Profile', 'profile.edit');
        $sidebarRegistry->addProfileItem('Logout', 'logout');
    }
}
