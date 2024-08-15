<?php declare(strict_types=1);

use App\Models\Project;


test('project info is returned', function () {
    /** @var Project $project */
    $project = Project::factory()->withMembers()->create();
    $token = $project->createToken('test');
    $response = $this->getJson('/api/v1/info', ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertOk();
});

test('project info needs token ability', function () {
    /** @var Project $project */
    $project = Project::factory()->create();
    $token = $project->createToken('test', []);
    $response = $this->getJson('/api/v1/info', ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(403);
});
