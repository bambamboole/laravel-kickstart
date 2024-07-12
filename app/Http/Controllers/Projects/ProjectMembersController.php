<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use Inertia\Inertia;

class ProjectMembersController
{
    public function index(string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->with('members.pivot.role')->firstOrFail();

        return Inertia::render(
            'Projects/Members/Index',
            [
                'project' => $project,
            ]
        );
    }
}
