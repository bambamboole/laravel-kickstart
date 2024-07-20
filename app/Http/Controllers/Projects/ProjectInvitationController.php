<?php declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\InviteProjectMemberRequest;
use App\Mail\ProjectInvitationMail;
use App\Models\ProjectInvitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProjectInvitationController
{
    public function create(InviteProjectMemberRequest $request, string $id)
    {
        abort_unless(auth()->user()->hasProjectPermission($id, 'project.members.invite'), 403);
        /** @var \App\Models\Project $project */
        $project = auth()->user()->projects()->where('uuid', $id)->firstOrFail();
        $role = Role::query()->where('uuid', $request->role_uuid)->firstOrFail();

        try {
            $invitation = $project->invitations()->create(
                [
                    'email' => $request->email,
                    'role_id' => $role->id,
                ]
            );
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['email' => __('validation.invitation.exists', ['email' => $request->email])]);
        }

        Mail::to($request->email)->send(
            new ProjectInvitationMail(
                $invitation,
                URL::signedRoute('project.invitations.accept', ['uuid' => $invitation->uuid]),
            )
        );

        return redirect()->route('project.members.index', $project->uuid)->with('success', 'Invitation sent!');
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

    public function delete(string $projectUuid, string $invitationUuid)
    {
        abort_unless(auth()->user()->hasProjectPermission($projectUuid, 'project.invitations.delete'), 403);
        $invitation = ProjectInvitation::query()->where('uuid', $invitationUuid)->with('project')->firstOrFail();
        $invitation->delete();

        return redirect()->route('project.members.index', $invitation->project->uuid)->with('success', 'Invitation deleted!');
    }
}
