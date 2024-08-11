<?php declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;

test('project can be deleted', function () {
    $uuid = Str::orderedUuid();
    $user = User::factory()->withProject(['uuid' => $uuid, 'name' => 'test-project'])->create();
    $this->assertDatabaseHas('projects', ['uuid' => $uuid]);

    $response = $this
        ->actingAs($user)
        ->from('/')
        ->delete('/projects/'.$uuid, [
            'name' => 'test-project',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/dashboard');

    $this->assertDatabaseMissing('projects', ['uuid' => $uuid]);
});

test('project name has to match', function () {
    $uuid = Str::orderedUuid();
    $user = User::factory()->withProject(['uuid' => $uuid, 'name' => 'test-project'])->create();

    $response = $this
        ->actingAs($user)
        ->from('/')
        ->delete('/projects/'.$uuid, [
            'name' => 'test-foo',
        ]);

    $response->assertSessionHasErrors(['name']);
});
