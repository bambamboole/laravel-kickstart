<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Resource\ProjectResource;
use App\Http\Resource\RoleResource;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProjectMembersController
{
    public function index(Project $project)
    {
        $roles = RoleResource::collection(Role::query()->get());
        $roles::withoutWrapping();
        $resource = new ProjectResource($project->load(['invitations', 'invitations.role', 'members.pivot.role']));
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Members',
            [
                'project' => $resource,
                'roles' => $roles,
            ]
        );
    }

    public function delete(Project $project, string $uuid)
    {
        if (auth()->user()->uuid === $uuid) {
            return redirect()->back()->with('error', 'You cannot remove yourself from the project');
        }

        Validator::validate([
            'uuid' => $uuid,
        ], [
            'uuid' => ['required', 'uuid', Rule::in($project->members->pluck('uuid'))],
        ]);

        $project->members()->detach($uuid);

        return redirect()->route('project.members.index', $project);
    }
}
