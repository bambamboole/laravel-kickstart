<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectInvitation>
 */
class ProjectInvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'role_id' => Role::query()->firstOrCreate(['name' => 'owner'])->id,
            'project_id' => Project::factory(),
        ];
    }
}
