<?php declare(strict_types=1);

use App\Mail\ProjectInvitationMail;
use App\Models\Project;
use App\Models\Role;

test('Inviting project members needs token ability', function () {
    /** @var Project $project */
    $project = Project::factory()->withMembers(2)->create();
    $token = $project->createToken('test', []);
    $response = $this->postJson('/api/v1/members', headers: ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(403);
});

test('Payload is validated', function (array $payload, array $expectedErrors) {
    Mail::fake();
    /** @var Project $project */
    $project = Project::factory()->withMembers(1)->create();
    $token = $project->createToken('test');
    expect($project->invitations()->count())->toBe(0);

    $response = $this->postJson(
        '/api/v1/members',
        $payload,
        ['Authorization' => 'Bearer '.$token->plainTextToken],
    );

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors($expectedErrors);
    expect($project->invitations()->count())->toBe(0);
    Mail::assertNothingSent();
})->with([
    [['email' => '', 'role_uuid' => ''], ['email', 'role_uuid']],
    [['email' => 'john@example.com', 'role_uuid' => ''], ['role_uuid']],
]);

test('Project members can be invited', function () {
    Mail::fake();
    $this->withoutExceptionHandling();
    /** @var Project $project */
    $project = Project::factory()->withMembers(1)->create();
    $token = $project->createToken('test');
    expect($project->invitations()->count())->toBe(0);

    $response = $this->postJson(
        '/api/v1/members',
        ['email' => 'john@example.com', 'role_uuid' => Role::query()->first()->uuid],
        ['Authorization' => 'Bearer '.$token->plainTextToken],
    );

    $response->assertStatus(201);

    expect($project->invitations()->count())->toBe(1);
    Mail::assertSent(ProjectInvitationMail::class);
});
