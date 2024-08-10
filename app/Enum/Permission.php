<?php declare(strict_types=1);

namespace App\Enum;

enum Permission: string
{
    case PROJECT_DELETE = 'project.delete';
    case PROJECT_SETTINGS_VIEW = 'project.settings.view';
    case PROJECT_MEMBERS_VIEW = 'project.members.view';
    case PROJECT_MEMBERS_INVITE = 'project.members.invite';
    case PROJECT_MEMBERS_DELETE = 'project.members.delete';
    case PROJECT_INVITATIONS_DELETE = 'project.invitations.delete';
    case PROJECT_API_TOKENS_CREATE = 'project.api-tokens.create';
    case PROJECT_API_TOKENS_DELETE = 'project.api-tokens.delete';
}
