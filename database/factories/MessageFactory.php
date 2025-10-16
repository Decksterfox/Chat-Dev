<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
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
            'content' => fake()->paragraph(),
            'sender' => fake()->randomElement(['user', 'bot']),
        ];
    }

    /**
     * Indicate that the message is from a user.
     */
    public function fromUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'sender' => 'user',
        ]);
    }

    /**
     * Indicate that the message is from the bot.
     */
    public function fromBot(): static
    {
        return $this->state(fn (array $attributes) => [
            'sender' => 'bot',
        ]);
    }
}
