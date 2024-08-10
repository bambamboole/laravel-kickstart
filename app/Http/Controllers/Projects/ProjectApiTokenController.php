<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateProjectApiTokenRequest;
use App\Models\Project;

class ProjectApiTokenController
{
    public function create(CreateProjectApiTokenRequest $request, Project $project)
    {
        $project->createToken($request->name, $request->abilities);

        return redirect()->route('project.settings', $project)->with('success', __('project.token.created'));
    }

    public function delete(Project $project, int $tokenId)
    {
        $token = $project->tokens()->where('id', $tokenId)->firstOrFail();
        $token->delete();

        return redirect()->route('project.settings', $project)->with('success', __('project.token.deleted'));
    }
}
