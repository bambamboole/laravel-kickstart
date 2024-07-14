<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::factory()->create(['name' => 'owner']);
        Role::factory()->create(['name' => 'editor', 'permissions' => ['project.members.view']]);

        User::factory()
            ->withProject(['name' => 'test-project'])
            ->create([
                'name' => 'bambamboole',
                'email' => 'admin@admin.com',
            ]);
    }
}
