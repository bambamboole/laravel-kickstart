<?php declare(strict_types=1);

namespace App\Enum;

enum ApiAbility: string
{
    case INFO = 'info';
    case MEMBERS_INVITE = 'members.invite';
    case MEMBERS_REMOVE = 'members.remove';
    case INVITATIONS_DELETE = 'invitations.delete';
}
