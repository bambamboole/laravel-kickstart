<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use Inertia\Inertia;

class ProjectSettingsController
{
    public function __invoke(string $id)
    {
        return Inertia::render(
            'Projects/Settings',
            [
                'project' => auth()->user()->projects()->where('uuid', $id)->firstOrFail(),
            ]
        );
    }
}
