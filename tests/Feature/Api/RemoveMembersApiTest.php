<?php declare(strict_types=1);

use App\Models\Project;
use App\Models\Role;
use App\Models\User;

test('Removing project members needs token ability', function () {
    /** @var Project $project */
    $project = Project::factory()->withMembers(2)->create();
    $token = $project->createToken('test', []);
    $uuid = $project->members()->first()->uuid;
    $response = $this->delete('/api/v1/members/'. $uuid, headers: ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(403);
});

test('Project owners cant be removed', function () {
    $this->withoutExceptionHandling();
    /** @var Project $project */
    $project = Project::factory()->withMembers(2)->create();
    $token = $project->createToken('test');
    $uuid = $project->members()->first()->uuid;

    $response = $this->delete('/api/v1/members/'. $uuid, headers: ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(422);

    expect($project->members()->count())->toBe(2);
});

test('Project members can be removed', function () {
    $this->withoutExceptionHandling();
    /** @var Project $project */
    $project = Project::factory()->withMembers(2)->create();
    $token = $project->createToken('test');
    $memberToRemove = $project->members()->save(User::factory()->create(), ['role_id' => Role::factory()->create(['name' => 'editor'])->id]);;
    expect($project->members()->count())->toBe(3);

    $response = $this->delete('/api/v1/members/'. $memberToRemove->uuid, headers: ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(200);

    expect($project->members()->count())->toBe(2);
});
