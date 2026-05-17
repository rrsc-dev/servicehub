<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
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
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'title' => fake()->sentence(5),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement([0, 1]),
            'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
