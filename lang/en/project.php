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
        ],
    ],
];
