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
    public function index(string $id)
    {
        abort_unless(auth()->user()->hasProjectPermission($id, 'project.members.view'), 403);

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

    public function delete(string $projectUuid, string $memberUuid)
    {
        abort_unless(auth()->user()->hasProjectPermission($projectUuid, 'project.members.delete'), 403);

        /** @var Project $project */
        $project = auth()
            ->user()
            ->projects()
            ->where('uuid', $projectUuid)
            ->firstOrFail();

        if (auth()->user()->uuid === $memberUuid) {
            return redirect()->back()->with('error', 'You cannot remove yourself from the project');
        }

        Validator::validate([
            'projectUuid' => $projectUuid,
            'memberUuid' => $memberUuid,
        ], [
            'memberUuid' => ['required', 'uuid', Rule::in($project->members->pluck('uuid'))],
        ]);

        $project->members()->detach($memberUuid);

        return redirect()->route('project.members.index', ['uuid' => $projectUuid]);
    }
}
