<?php declare(strict_types=1);

namespace Database\Factories;

use App\Services\Auth\PermissionRegistry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'permissions' => app(PermissionRegistry::class)->all(),
        ];
    }
}
