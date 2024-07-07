<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        User::factory()
            ->withProject(['name' => 'test-project'])
            ->create([
                'name' => 'bambamboole',
                'email' => 'admin@admin.com',
            ]);
    }
}
