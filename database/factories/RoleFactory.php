<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'code' => Str::slug($this->faker->unique()->word()),
            'name' => $this->faker->word(),
            'is_super' => $this->faker->boolean(),
        ];
    }

    public function super(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_super' => true,
        ]);
    }
}
