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
            'project_id' => Project::factory(),
            'title' => fake()->sentence(5),
            'user_id' => User::factory(),
            'status' => fake()->randomElement([
                1, // aberto
                2, // em andamento
                3, // aguardando
                4, // finalizado
                5, // cancelado
            ]),
        ];
    }
}
