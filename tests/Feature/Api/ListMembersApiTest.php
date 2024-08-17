<?php declare(strict_types=1);

use App\Models\Project;
use App\Models\User;

test('project members are returned', function () {
    /** @var Project $project */
    $project = Project::factory()->withMembers(20)->create();
    $token = $project->createToken('test');
    $response = $this->get('/api/v1/members', ['Authorization' => 'Bearer '.$token->plainTextToken]);

    expect($response->json('data'))->toHaveCount(15)
        ->and($response->json('meta.last_page'))->toBe(2)
        ->and($response->json('meta.per_page'))->toBe(15);
});

test('project members can be filtered', function ($attribute, $value) {
    $user = User::factory()->withProject()->create([$attribute => $value]);
    /** @var Project $project */
    $project = $user->projects()->first();
    User::factory()->count(19)->create()->each(function ($user) use ($project) {
        $project->members()->save($user, ['role_id' => 1]);
    });
    $token = $project->createToken('test');
    $url = '/api/v1/members?'.http_build_query(['filter' => [$attribute => $value]]);
    $response = $this->get($url, ['Authorization' => 'Bearer '.$token->plainTextToken]);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data.0.'.$attribute))->toBe($value)
        ->and($response->json('meta.last_page'))->toBe(1)
        ->and($response->json('meta.per_page'))->toBe(15);
})->with([
    ['uuid', '123e4567-e89b-12d3-a456-426614174000'],
    ['email', 'john@example.com'],
    ['name', 'John Doe'],
]);

test('project members needs token ability', function () {
    /** @var Project $project */
    $project = Project::factory()->create();
    $token = $project->createToken('test', []);
    $response = $this->get('/api/v1/members', ['Authorization' => 'Bearer '.$token->plainTextToken]);

    $response->assertStatus(403);
});
