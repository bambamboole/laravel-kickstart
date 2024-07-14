<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Resource\ProjectResource;
use App\Http\Resource\RoleResource;
use App\Models\Role;
use Inertia\Inertia;

class ProjectMembersController
{
    public function index(string $id)
    {
        $project = auth()
            ->user()
            ->projects()
            ->where('uuid', $id)
            ->with(['invitations', 'invitations.role', 'members.pivot.role'])
            ->firstOrFail();
        $roles = RoleResource::collection(Role::query()->get());
        $roles::withoutWrapping();
        $resource = new ProjectResource($project);
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Members/Index',
            [
                'project' => $resource,
                'roles' => $roles,
            ]
        );
    }
}
