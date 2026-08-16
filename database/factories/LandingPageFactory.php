<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LandingPageFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => 'published',
            'blocks' => [
                [
                    'id' => uniqid('block_'),
                    'type' => 'hero',
                    'data' => [
                        'heading' => 'Hero Heading',
                        'subheading' => 'Hero Subheading'
                    ]
                ]
            ]
        ];
    }
}
