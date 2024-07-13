<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Resource\ProjectResource;
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

        return Redirect::route('project.overview', ['uuid' => $project->uuid])->with('success', 'Project created successfully');
    }

    public function show(string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->with(['members.pivot.role'])->firstOrFail();
        $resource = new ProjectResource($project);
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Overview',
            [
                'project' => $resource,
            ]
        );
    }

    public function settings(string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->with(['members.pivot.role'])->firstOrFail();
        $resource = new ProjectResource($project);
        $resource::withoutWrapping();

        return Inertia::render(
            'Projects/Settings',
            [
                'project' => $resource,
            ]
        );
    }

    public function delete(Request $request, string $id)
    {
        $project = auth()->user()->projects()->where('uuid', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|in:'.$project->name,
        ]);

        $project->delete();

        return Redirect::route('dashboard')->with('success', __('project.delete.success', ['name' => $project->name]));
    }
}
