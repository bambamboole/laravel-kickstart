<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create(['name' => 'owner']);
        Role::factory()->create(['name' => 'editor', 'permissions' => ['project.members.view']]);
    }
}
