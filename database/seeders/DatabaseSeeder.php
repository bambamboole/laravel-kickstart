<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
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
        $this->call(RoleSeeder::class);

        $user = User::factory()
            ->withProject(['name' => 'test-project'])
            ->create([
                'name' => 'bambamboole',
                'email' => 'admin@admin.com',
            ]);

        /** @var Project $project */
        $project = $user->projects()->first();
        $project->invitations()->create([
            'email' => 'foo@bar.com',
            'role_id' => Role::query()->where('name', 'editor')->firstOrFail()->id,
        ]);
        $token = $project->createToken('test-token');
        $this->command->info("Token: {$token->plainTextToken}");
        $token->accessToken->update(['last_used_at' => now()]);
    }
}
