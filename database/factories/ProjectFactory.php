<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Services\Auth\PermissionRegistry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }

    public function withMembers(): static
    {
        return $this->hasAttached(
            User::factory()->count(3),
            ['role_id' => Role::query()->firstOrCreate(['name' => 'owner'], ['permissions' => app(PermissionRegistry::class)->all()])->id],
            'members',
        );
    }
}
