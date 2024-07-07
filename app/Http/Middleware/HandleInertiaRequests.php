<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\View\SidebarRegistry;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => fn () => collect(['success', 'error', 'warning', 'info'])
                ->mapWithKeys(fn ($key) => [$key => $request->session()->pull($key)])
                ->filter()
                ->all(),
            'sidebar' => app(SidebarRegistry::class)->all(),
            'mainNavigation' => app(SidebarRegistry::class)->getMainItems(),
            'profileNavigation' => app(SidebarRegistry::class)->getProfileItems(),
        ];
    }
}
