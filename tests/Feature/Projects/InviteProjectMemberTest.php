<?php declare(strict_types=1);

use App\Mail\ProjectInvitationMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('member can be invited', function () {
    Mail::fake();
    $user = User::factory()->withProject()->create();
    $project = $user->projects()->first();
    $role = Role::query()->firstOrCreate(['name' => 'owner']);

    $this->actingAs($user)
        ->post(
            route('project.members.invite', $project->uuid),
            [
                'email' => 'foo@bar.com',
                'role_uuid' => $role->uuid,
            ]
        )
        ->assertRedirectToRoute('project.members.index', $project->uuid);

    $this->assertDatabaseHas('project_invitations', [
        'email' => 'foo@bar.com',
    ]);
    Mail::assertSent(ProjectInvitationMail::class);
});
