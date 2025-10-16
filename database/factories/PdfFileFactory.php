<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PdfFile>
 */
class PdfFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'filename' => fake()->uuid() . '.pdf',
            'original_name' => fake()->word() . '.pdf',
            'content' => fake()->paragraph(10),
            'page_count' => fake()->numberBetween(1, 50),
        ];
    }
}
