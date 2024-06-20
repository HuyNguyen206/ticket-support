<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn() => User::factory()->create(),
            'title' => $this->faker->words(4, true),
            'description' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['A','C','H','X'])
        ];
    }
}
