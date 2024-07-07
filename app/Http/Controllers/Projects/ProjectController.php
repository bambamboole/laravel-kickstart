<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController
{
    public function create(CreateProjectRequest $request)
    {
        $project = $request->user()->projects()->create($request->validated());

        return Redirect::route('project.overview', ['uuid' => $project->uuid])->with('success', 'Project created successfully');
    }

    public function show(string $id)
    {
        return Inertia::render(
            'Projects/Overview',
            [
                'project' => auth()->user()->projects()->where('uuid', $id)->firstOrFail(),
            ]
        );
    }

    public function settings(string $id)
    {
        return Inertia::render(
            'Projects/Settings',
            [
                'project' => auth()->user()->projects()->where('uuid', $id)->firstOrFail(),
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
