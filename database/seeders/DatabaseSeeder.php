<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
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

        User::factory()
            ->has(Project::factory(state: ['name' => 'test']))
            ->create([
                'name' => 'bambamboole',
                'email' => 'admin@admin.com',
            ]);
    }
}
