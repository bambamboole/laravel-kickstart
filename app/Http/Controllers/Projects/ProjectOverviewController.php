<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use Inertia\Inertia;

class ProjectOverviewController
{
    public function __invoke(string $id)
    {
        return Inertia::render(
            'Projects/Overview',
            [
                'projects' => auth()->user()->projects()->where('uuid', $id)->firstOrFail(),
            ]
        );
    }
}
