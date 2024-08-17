<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Actions\InviteProjectMember;
use App\Http\Requests\Projects\InviteProjectMemberRequest;
use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\User;
use Inertia\Inertia;

class ProjectInvitationController
{
    public function create(InviteProjectMemberRequest $request, Project $project, InviteProjectMember $action)
    {
        $action->execute($project, $request->email, $request->role_uuid);

        return redirect()->route('project.members.index', $project)->with('success', 'Invitation sent!');
    }

    public function accept(string $uuid)
    {
        $invitation = ProjectInvitation::query()->where('uuid', $uuid)->firstOrFail();

        $user = User::query()->where('email', $invitation->email)->first();
        if (! $user instanceof User) {
            session()->put('from_project_invitation', $invitation->uuid);

            return Inertia::render('Auth/RegisterFromInvitation', ['email' => $invitation->email]);
        }

        $invitation->project->members()->attach(auth()->id(), ['role_id' => $invitation->role_id]);

        return redirect()->route('project.members.index', $invitation->project->uuid)->with('success', 'Invitation accepted!');
    }

    public function delete(Project $project, string $uuid)
    {
        $project->invitations()->where('uuid', $uuid)->delete();

        return redirect()->route('project.members.index', $project)->with('success', 'Invitation deleted!');
    }
}
