<?php declare(strict_types=1);

namespace App\Providers;

use App\Enum\Permission;
use App\Models\Project;
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
        $permissionRegistry->add(Permission::class);
        $sidebarRegistry->addMainItem('Overview', 'HomeIcon', 'project.overview', fn (Request $request) => ['project' => $request->route('project')]);
        $sidebarRegistry->addMainItem('Settings', 'CogIcon', 'project.settings', fn (Request $request) => ['project' => $request->route('project')], Permission::PROJECT_SETTINGS_VIEW);
        $sidebarRegistry->addMainItem('Members', 'UsersIcon', 'project.members.index', fn (Request $request) => ['project' => $request->route('project')], Permission::PROJECT_MEMBERS_VIEW);
        $sidebarRegistry->addProfileItem('Profile', 'profile.edit');
        $sidebarRegistry->addProfileItem('Logout', 'logout');

        Request::macro('project', function (): Project {
            $project = $this->user();
            if (! $project instanceof Project) {
                abort(403);
            }

            return $project;
        });
    }
}
