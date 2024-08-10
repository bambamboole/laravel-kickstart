<?php declare(strict_types=1);

return [
    'delete' => [
        'button' => 'Delete project',
        'confirmation' => [
            'button' => 'Delete project',
            'cancel' => 'Cancel',
            'description' => 'This is nor reversible. All data will be lost. Do you really want to delete the project <strong>:name</strong>?',
            'placeholder' => 'type in the projects name...',
            'title' => 'Delete project',
        ],
        'description' => 'Delete the project and all its data. This action is not reversible.',
        'success' => 'Project :name was successfully deleted',
        'title' => 'Delete project',
    ],
    'invitation' => [
        'created' => 'Created :time ago',
        'delete' => 'Delete invitation',
    ],
    'member' => [
        'change_role' => 'Change role',
        'last_login' => 'Last login :time ago',
        'remove' => 'Remove from Project',
    ],
    'members' => [
        'index' => [
            'description' => 'Here you can manage the project members',
            'header' => 'Project members',
            'invitation_list' => 'Open invitations',
            'invite' => [
                'button' => 'Invite a new Member',
            ],
            'inviteModal' => [
                'button' => 'Invite a new Member',
                'cancel' => 'cancel',
                'description' => 'The invitee will get an email with alink to join the project. Please make sure the email is correct.',
                'form' => [
                    'email' => [
                        'label' => 'Email',
                        'placeholder' => 'the invitees email address...',
                    ],
                    'role' => [
                        'label' => 'Role',
                    ],
                ],
                'title' => 'Invite a new member',
            ],
            'member_list' => 'Members',
            'title' => 'Invite a new member',
        ],
    ],
    'settings' => [
        'createApiTokenModal' => [
            'button' => 'Create new API token',
            'cancel' => 'Cancel',
            'description' => 'Use API tokens to integrate your project with other services. You can create multiple tokens with different abilities to control access.',
            'form' => [
                'abilities' => [
                    'label' => 'Abilities',
                ],
                'name' => [
                    'label' => 'Name',
                    'placeholder' => 'Choose a name for the token...',
                ],
            ],
            'title' => 'Create new API token',
        ],
        'description' => 'You will find all the project related settings here.',
        'header' => 'Project Settings',
        'title' => 'Project Settings',
    ],
    'token' => [
        'ability' => [
            'info' => [
                'description' => 'Get general project information',
            ],
            'invitations' => [
                'delete' => [
                    'description' => 'Delete project invitations',
                ],
            ],
            'members' => [
                'invite' => [
                    'description' => 'Invite new members to the project',
                ],
                'remove' => [
                    'description' => 'Remove members from the project',
                ],
            ],
        ],
        'created' => 'Token successfully created',
        'delete' => 'Delete',
        'deleted' => 'Token successfully deleted',
        'last_used_at' => 'Last used :time ago',
        'list' => 'Your Projects API tokens',
        'never_used' => 'Not yet used',
    ],
];
