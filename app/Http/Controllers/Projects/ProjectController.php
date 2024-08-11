<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Enum\ApiAbility;
use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Resource\ProjectResource;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController
{
    public function create(CreateProjectRequest $request)
    {
        $role = Role::query()->where('name', 'owner')->firstOrFail();
        $project = $request->user()->projects()->create($request->validated(), ['role_id' => $role->id]);

        return Redirect::route('project.overview', $project)->with('success', 'Project created successfully');
    }

    public function show(Project $project)
    {
        $resource = new ProjectResource($project->load(['members.pivot.role']));
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Overview',
            [
                'project' => $resource,
            ]
        );
    }

    public function settings(Project $project)
    {
        $resource = new ProjectResource($project->load(['members.pivot.role', 'tokens']));
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Settings',
            [
                'project' => $resource,
                'abilities' => ApiAbility::cases(),
            ]
        );
    }

    public function delete(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|in:'.$project->name,
        ]);

        $project->delete();

        return Redirect::route('dashboard')->with('success', __('project.delete.success', ['name' => $project->name]));
    }
}
