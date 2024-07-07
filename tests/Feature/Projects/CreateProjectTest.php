<?php declare(strict_types=1);

use App\Models\User;

test('project can be created', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/')
        ->post('/projects', [
            'name' => 'test-project',
        ]);

    $project = $user->projects()->first();
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/projects/'.$project->uuid);

    $this->assertSame('test-project', $project->name);
});

test('project name has to be unique', function () {
    $user = User::factory()->withProject(['name' => 'test-project'])->create();

    $response = $this
        ->actingAs($user)
        ->from('/')
        ->post('/projects', [
            'name' => 'test-project',
        ]);

    $response
        ->assertSessionHasErrors('name')
        ->assertRedirect('/');
});
