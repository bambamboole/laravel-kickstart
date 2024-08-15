<?php declare(strict_types=1);

namespace App\Actions;

use App\Mail\ProjectInvitationMail;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class InviteProjectMember
{
    public function execute(Project $project, string $email, string $roleUuid): void
    {
        $role = Role::query()->where('uuid', $roleUuid)->firstOrFail();

        try {
            $invitation = $project->invitations()->create(
                [
                    'email' => $email,
                    'role_id' => $role->id,
                ]
            );
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['email' => __('validation.invitation.exists', ['email' => $email])]);
        }

        Mail::to($email)->send(
            new ProjectInvitationMail(
                $invitation,
                URL::signedRoute('project.invitations.accept', ['uuid' => $invitation->uuid]),
            )
        );
    }
}
