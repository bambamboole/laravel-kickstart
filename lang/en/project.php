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
            'description' => 'i18next-project.members.index.description',
            'header' => 'i18next-project.members.index.header',
            'invite' => [
                'button' => 'i18next-project.members.index.invite.button',
            ],
            'inviteModal' => [
                'button' => 'i18next-project.members.index.inviteModal.button',
                'cancel' => 'i18next-project.members.index.inviteModal.cancel',
                'description' => 'i18next-project.members.index.inviteModal.description',
                'form' => [
                    'email' => [
                        'label' => 'i18next-project.members.index.inviteModal.form.email.label',
                        'placeholder' => 'i18next-project.members.index.inviteModal.form.email.placeholder',
                    ],
                    'role' => [
                        'label' => 'i18next-project.members.index.inviteModal.form.role.label',
                    ],
                ],
                'title' => 'i18next-project.members.index.inviteModal.title',
            ],
            'title' => 'i18next-project.members.index.title',
        ],
    ],
];
