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
];
