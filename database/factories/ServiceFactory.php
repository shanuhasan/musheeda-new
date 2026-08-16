<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'short_description' => $this->faker->sentence(),
            'full_description' => $this->faker->paragraphs(3, true),
            'status' => 'active',
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
