<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateProjectApiTokenRequest;
use App\Models\Project;

class ProjectApiTokenController
{
    public function create(CreateProjectApiTokenRequest $request, string $uuid)
    {
        abort_unless(auth()->user()->hasProjectPermission($uuid, 'project.api-token.create'), 403);

        /** @var Project $project */
        $project = auth()
            ->user()
            ->projects()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $project->createToken($request->name, $request->abilities);

        return redirect()->route('project.settings', ['uuid' => $uuid])->with('success', __('project.token.created'));
    }

    public function delete(string $projectUuid, int $tokenId)
    {
        abort_unless(auth()->user()->hasProjectPermission($projectUuid, 'project.api-token.delete'), 403);

        /** @var Project $project */
        $project = auth()
            ->user()
            ->projects()
            ->where('uuid', $projectUuid)
            ->firstOrFail();

        $token = $project->tokens()->where('id', $tokenId)->firstOrFail();
        $token->delete();

        return redirect()->route('project.settings', ['uuid' => $projectUuid])->with('success', __('project.token.deleted'));
    }
}
