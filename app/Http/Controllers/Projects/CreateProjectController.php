<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateProjectRequest;
use Illuminate\Support\Facades\Redirect;

class CreateProjectController
{
    public function __invoke(CreateProjectRequest $request)
    {
        $project = $request->user()->projects()->create($request->validated());

        return Redirect::route('project.overview', ['uuid' => $project->uuid])->with('success', 'Project created successfully');
    }
}
