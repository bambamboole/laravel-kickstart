<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Resource\ProjectResource;
use Inertia\Inertia;

class ProjectMembersController
{
    public function index(string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->with('members.pivot.role')->firstOrFail();

        $resource = new ProjectResource($project);
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Members/Index',
            [
                'project' => $resource,
            ]
        );
    }
}
