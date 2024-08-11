<?php declare(strict_types=1);

namespace App\Policies;

use App\Enum\Permission;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return $project->members()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_DELETE);
    }

    public function viewSettings(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_SETTINGS_VIEW);
    }

    public function viewMembers(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_MEMBERS_VIEW);
    }

    public function deleteMembers(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_MEMBERS_DELETE);
    }

    public function inviteMembers(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_MEMBERS_INVITE);
    }

    public function deleteInvitations(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_INVITATIONS_DELETE);
    }

    public function createApiTokens(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_API_TOKENS_CREATE);
    }

    public function deleteApiTokens(User $user, Project $project): bool
    {
        return $user->hasProjectPermission($project, Permission::PROJECT_API_TOKENS_DELETE);
    }
}
