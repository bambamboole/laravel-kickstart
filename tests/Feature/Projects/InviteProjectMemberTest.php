<?php declare(strict_types=1);

use App\Mail\ProjectInvitationMail;
use App\Models\ProjectInvitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia;

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

    Mail::assertSent(ProjectInvitationMail::class);
    $invitation = $project->invitations()->first();
    $this->assertInstanceOf(ProjectInvitation::class, $invitation);

    $this->get(URL::signedRoute('project-invitation.accept', $invitation->uuid))
        ->assertSessionHas('from_project_invitation', $invitation->uuid)
        ->assertInertia(function (AssertableInertia $assert) {
            $assert->component('Auth/RegisterFromInvitation');
        });
    $this->app['auth']->guard()->forgetUser();
    $this->withSession(['from_project_invitation' => $invitation->uuid])
        ->post(route('register-from-invitation'), [
            'name' => 'Foo Bar',
            'email' => 'foo@bar.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasNoErrors()->assertRedirectToRoute('dashboard');

    $this->assertDatabaseMissing('project_invitations', ['id' => $invitation->id]);
    $user = User::query()->where('email', 'foo@bar.com')->first();
    $this->assertTrue($project->fresh()->members->contains($user));
});
